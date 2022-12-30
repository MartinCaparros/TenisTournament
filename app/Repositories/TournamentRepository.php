<?php

namespace App\Repositories;

use App\Models\Tournament;

use App\Interfaces\PlayerRepositoryInterface;
use App\Interfaces\TournamentRepositoryInterface;

use App\Models\Player;

use Illuminate\Database\Eloquent\Collection;

class TournamentRepository implements TournamentRepositoryInterface
{
    /** @var PlayerRepositoryInterface $playerRepository  */
    protected $playerRepository;

    /** @var Player $player */
    protected $player;

    protected $tournament;

    public function __construct(
        Tournament $tournament,
        PlayerRepositoryInterface $playerRepository,
        Player $player,
    )
    {
        $this->tournament       = $tournament;
        $this->playerRepository = $playerRepository;
        $this->player           = $player;
    }

    /**
     * Filters
     *
     * @param array $data
     * @return mixed
     **/
    private function filters ($data)
    {
        $query = $this->tournament;

        foreach ($data as $key => $value) {
            if ($key == 'start_date') {
                $query = $query->where('created_at', '>=', $value.' 00:00:01');
            } else if ($key == 'end_date') {
                $query = $query->where('created_at', '<=', $value.' 23:59:59');
            } else if ($key == 'gender') {
                $query = $query->where('gender', $value);
            }
        }

        return $query;
    }
    /**
     * Calculate championship winner
     *
     *
     * @param Collection $players
     * @param int   $luck
     * @return mixed
     **/
    private function calculateChampion(Collection $players)
    {
        $totalRounds = $this->totalRounds(count($players));

        $eliminated = new Collection();
        for ($i=0; $i < $totalRounds; $i++) {
            for ($j=0; $j < count($players)/2; $j++) {
                $aux = ($j == 0 ? 0 : $j*2);
                if ($players[$aux]->competitivePower > $players[$aux+1]->competitivePower) {
                    $eliminated->push($players[$aux+1]);
                } else {
                    $eliminated->push($players[$aux]);
                }
            }
            $players = $players->diff($eliminated);
        }

        return $players;
    }

    /**
     * Calculate total matches
     *
     *
     * @param int $totalPlayers
     * @return int
     **/
    private function totalRounds(int $totalPlayers)
    {
        $rounds = 0;
        while ($totalPlayers > 1) {
            $rounds++;
            $totalPlayers = $totalPlayers / 2;
        }

        return $rounds;
    }
    /**
     * Calculate the competitive power of a player based on gender and rules
     *
     *
     * @param Collection $players
     * @return mixed
     **/

    private function calculateCompetitivePower(Collection $players, string $tournamentGender)
    {
        if ($tournamentGender == 'Male') {
            foreach($players as $player) {
                $player->competitivePower = ($player->stregth + $player->speed) * $player->luck;
            }
        } else {
            foreach($players as $player) {
                $player->competitivePower = $player->reaction * $player->luck;
            }
        }

        return $players;
    }

    /**
     * Generate luck value
     *
     * @param float $lowValue
     * @param float $maxValue
     * @param int $aux
     * @return mixed
     **/

    private function luckGenerator(Collection $players, float $lowValue, float $maxValue, int $aux = 100)
    {
        foreach($players as $player) {
            $player->luck = mt_rand($lowValue * $aux, $maxValue * $aux)/$aux;
        }

        return $players;
    }

    /**
     * Emulate a new Tournament
     *
     * @param array $players
     * @param string $tournament_gender
     * @return mixed
     **/

    public function emulateTournament(array $playersIds, string $tournamentGender)
    {
        $players = $this->playerRepository->getPlayersById($playersIds);
        $players = $this->luckGenerator($players, 0.75, 1.25);
        $players = $this->calculateCompetitivePower($players, $tournamentGender);

        $champion = $this->calculateChampion($players)->first();
        $tournament = $this->tournament->create(['champion_id' => $champion->id, 'gender' => $tournamentGender]);
        $champion = $this->playerRepository->updateById($champion->id, ['tournaments_won' => $champion->tournaments_won +1]);

        return $tournament;
    }

    /**
     * Get tournament list
     *
     * @param array $data
     * @param int $limit
     * @return mixed
     **/

    public function getTournaments(array $data, int $limit)
    {
        $query = $this->filters($data);

        return $query->orderByDesc('id')->paginate(isset($data['one_page']) && $data['one_page'] ? $query->count() : $limit);
    }
}

<?php

namespace App\Repositories;

use App\Models\Player;
use App\Models\Tournament;

use App\Interfaces\PlayerRepositoryInterface;

class PlayerRepository implements PlayerRepositoryInterface
{

    /** @var Player $player  */
    protected $player;

    protected $tournament;

    public function __construct(tournament $tournament, Player $player) {
        $this->tournament = $tournament;
        $this->player     = $player;
    }

    /**
     * Emulate a new Tournament
     *
     * @param array $players
     * @return mixed
     **/

    public function getPlayersById(array $playersIds)
    {
        return $this->player->whereIn('id', $playersIds)->get();
    }

    /**
     * Update player By Id
     *
     * @param int $id
     * @param array $data
     * @return mixed
     **/
    public function updateById(int $id, array $data)
    {
        $player = $this->player->where('id', $id)->first();
        $player->update($data);

        return $player;
    }
}

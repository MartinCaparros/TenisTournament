<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmulateTournamentRequest;
use App\Http\Requests\TournamentRequest;
use App\Http\Resources\EmulateTournamentResource;
use App\Http\Resources\TournamentListPaginatedResource;
use App\Interfaces\TournamentRepositoryInterface;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Tournament API Documentation",
 *      description="L5 Swagger OpenApi description",
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="https://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * )
 */

class TournamentController extends Controller
{
    private TournamentRepositoryInterface $tournamentRepository;

    public function __construct(TournamentRepositoryInterface $tournamentRepository)
    {
        $this->tournamentRepository = $tournamentRepository;
    }

    /**
     * Simulate a new Tournament
     *
     * @OA\Post(
     *     path="/api/tournament/emulate",
     *     tags={"emulate-tournament"},
     *     summary= "Emulate a new tournament using an array of players ids and tournament gender",
     *     operationId="emulateTournament",
     *     @OA\Response(
     *         response=400,
     *         description="Two its the minimum players involved in a tournament"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tournament finished"
     *     )
     * )
     */
    public function emulateTournament(EmulateTournamentRequest $request)
    {
        $playersIds = $request->only('players');

        if (count($playersIds['players']) < 2) {
            return response([
                'status'   => 'error',
                'message'  => 'TOURNAMENT_NEEDS_TWO_PLAYERS_AT_LEAST'
            ], 400);
        }

        return response()->json(new EmulateTournamentResource($this->tournamentRepository->emulateTournament($playersIds['players'], $request['tournament_gender'])), 200);
    }

    /**
     * Return all the tournaments
     *
     * @OA\Get(
     *     path="/api/tournament/list",
     *     tags={"list-tournaments"},
     *     summary= "Return all tournaments that ended",
     *     operationId="getTournaments",
     *     @OA\Response(
     *         response=200,
     *         description="Tournament list"
     *     )
     * )
     */
    public function getTournaments(TournamentRequest $request)
    {
        return response()->json(new TournamentListPaginatedResource($this->tournamentRepository->getTournaments($request->only('start_date', 'end_date', 'gender', 'one_page'), $request['limit'] ?? 10)));
    }
}

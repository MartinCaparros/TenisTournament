<?php

namespace App\Interfaces;

Interface TournamentRepositoryInterface
{
    public function emulateTournament(array $playersIds, string $tournament_gender);
    public function getTournaments(array $data, int $limit);
}

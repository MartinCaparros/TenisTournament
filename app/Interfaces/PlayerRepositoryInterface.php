<?php

namespace App\Interfaces;

interface PlayerRepositoryInterface
{
    public function getPlayersById(array $playersIds);
    public function updateById(int $id, array $data);
}

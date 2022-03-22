<?php

namespace App\Infrastructure\Repository;

use App\Model\Agent;
use App\Model\City;
use App\Model\Province;

class AgentRepository
{
    public function getAll()
    {
        $agents = Agent::with('address.city.province')->with('bankAccount')->orderBy('name')->get();
        return $agents;
    }
}

<?php

namespace App\Infrastructure\Repository;

use App\Infrastructure\Repository\Filters\RepositoryFilterInterface;
use App\Model\Client;
use Illuminate\Support\Facades\Auth;

class ClientRepository
{
    public function getAll(RepositoryFilterInterface $filter = null)
    {
        $user =  Auth::user();

        if (isset($user->agent)) {
            $clients = Client::select()->where('agent_id', $user->agent->id)->with('addresses.city.province');
        } else {
            $clients = Client::select()->with('addresses.city.province');
        }

        if ($filter !== null) {
            $filter->apply($clients);
        }

        return $clients->get();
    }
}


<?php 

namespace App\Infrastructure\Services;

use App\Model\Address;
use App\Model\AddressAgent;
use App\Model\Agent;
use App\Model\Client;

class AddressService
{
    public function create(Client $client, Array $data)
    {
        $address = new Address($data);
        $client->addresses()->save($address);
    }

    public function createAddressAgent(Agent $agent, Array $data)
    {
        $address = new AddressAgent($data);
        $agent->address()->save($address);
    }
}


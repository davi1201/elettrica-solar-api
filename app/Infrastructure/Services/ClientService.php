<?php
namespace App\Infrastructure\Services;

use App\Model\Address;
use App\Model\Client;

class ClientService
{
    public function create(Array $data): Client
    {
        $client = new Client($data);
        $client->save();

        return $client;
    }

    public function update(Client $client, Array $data)
    {
        
        $address_data = $data['address'];
        $address = Address::find($address_data['id']);
        $address->update($address_data);
        return $client->update($data);
    }
}
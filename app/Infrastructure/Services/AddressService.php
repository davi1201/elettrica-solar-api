<?php 

namespace App\Infrastructure\Services;

use App\Entities\Province;
use App\Model\Address;
use App\Model\AddressAgent;
use App\Model\Agent;
use App\Model\Client;
use Illuminate\Support\Facades\Http;

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

    public function getAddresByZipCode($cep)
    {
        $url = 'https://viacep.com.br/ws/'.$cep.'/json';
        $response = Http::get($url);

        $data = $response->json();

        $data['estado'] = Province::where('initial', $data['uf'])->first()->name;
        $data['id_estado'] = Province::where('initial', $data['uf'])->first()->id;

        return $data;
    }
}


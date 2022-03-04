<?php

namespace App\Http\Controllers;

use App\Infrastructure\Repository\ClientRepository;
use App\Infrastructure\Services\AddressService;
use App\Infrastructure\Services\ClientService;
use App\Infrastructure\Repository\Filters\ClientFilter;
use App\Model\Agent;
use App\Model\City;
use App\Model\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    private $client_repository;
    private $client_service;
    private $address_service;

    public function __construct(
        ClientRepository $clientRepository, 
        ClientService $clientService,
        AddressService $addressService
    ){
        $this->client_repository = $clientRepository;
        $this->client_service = $clientService;
        $this->address_service = $addressService;
    }
    /**
     * Display a listing of the resource
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filter = new ClientFilter($request->query());

        $clients = $this->client_repository->getAll($filter);
        return response()->json($clients, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $client = $this->client_service->create($data);        
        $this->address_service->create($client, $data['address']);

        return response()->json($client, 200);
    }

    public function getByAgent(Agent $agent)
    {
        $clients = $agent->clients;
        return response()->json($clients, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        $addresses = $client->addresses;
        $city = $addresses->first()->city;
        $city->load('province');
        
        return response()->json($client, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        $data = $request->all();
        $client = $this->client_service->update($client, $data);
        return response()->json($client, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

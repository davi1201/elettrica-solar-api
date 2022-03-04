<?php

namespace App\Http\Controllers;

use App\Http\Requests\AgentRequest;
use App\Infrastructure\Repository\AgentRepository;
use App\Infrastructure\Services\AddressService;
use App\Infrastructure\Services\AgentService;
use App\Model\Agent;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class AgentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $agent_service;
    protected $address_service;
    protected $auth_controller;
    protected $agent_repository;

    public function __construct(
        AgentService $agentService,
        AuthController $authController,
        AgentRepository $agentRepository,
        AddressService $addressService
    )
    {
        $this->agent_service = $agentService;
        $this->auth_controller = $authController;
        $this->agent_repository = $agentRepository;
        $this->address_service = $addressService;
    }
    public function index()
    {
        $agents = $this->agent_repository->getAll();

        return response()->json($agents, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AgentRequest $request)
    {
        // $request->add(['password' => bcrypt('subs0l@r2021')]);

        $data = $request->all();

        $agent = $this->agent_service->create($data);
        $this->address_service->createAddressAgent($agent, $data['address']);

        return response()->json($agent, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Agent $agent)
    {
        $agent->load('address.city.province');
        $agent->load('bankAccount');
        $agent->load('fileEntry');
        
        return response()->json($agent, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AgentRequest $request, Agent $agent)
    {
        $data = $request->all();

        $agent = $this->agent_service->update($data, $agent);
        return new JsonResponse($agent);;
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

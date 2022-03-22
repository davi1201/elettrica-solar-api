<?php

namespace App\Http\Controllers;

use App\Infrastructure\Repository\UserRepository;
use App\Infrastructure\Services\UserService;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     private $user_repository;
     private $user_service;
     private $auth_controller;

    public function __construct(
        UserRepository $userRepository, 
        UserService $userService,
        AuthController $authController)
    {
        $this->user_repository = $userRepository;
        $this->user_service = $userService;
        $this->auth_controller = $authController;
    }
    public function index(Request $request)
    {
        $users = $this->user_repository->getAll();
        return response($users, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)    {
        
        $user = $this->auth_controller->register($request);
        return response()->json($user, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return response()->json($user->load('agent'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $data = $request->all();
        $user = $this->user_service->update($user, $data);

        return response()->json($user, 201);
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

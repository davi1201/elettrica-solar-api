<?php

namespace App\Http\Controllers;

use App\Model\ConfigAdmin;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ConfigAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ConfigAdmin  $configAdmin
     * @return \Illuminate\Http\Response
     */
    public function show(ConfigAdmin $configAdmin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ConfigAdmin  $configAdmin
     * @return \Illuminate\Http\Response
     */
    public function edit(ConfigAdmin $configAdmin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ConfigAdmin  $configAdmin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ConfigAdmin $configAdmin)
    {
        $data = $request->all();

        $configAdmin->update($data);

        return new JsonResponse($configAdmin);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ConfigAdmin  $configAdmin
     * @return \Illuminate\Http\Response
     */
    public function destroy(ConfigAdmin $configAdmin)
    {
        //
    }
}

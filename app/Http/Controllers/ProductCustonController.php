<?php

namespace App\Http\Controllers;

use App\Infrastructure\Services\ProductCustonService;
use App\Infrastructure\Services\ProjectService;
use App\Model\Project;
use App\ProductCuston;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductCustonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $productCustonService;
    protected $projectService;

    public function __construct(ProductCustonService $productCustonService, ProjectService $projectService)
    {
        $this->productCustonService = $productCustonService;
        $this->projectService = $projectService;
    }

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
        $data = $request->all();

        $productCuston = $this->productCustonService->create($data);

        $project = Project::find($data['project_id']);

        $this->projectService->updateKit($project, $productCuston);

        return new JsonResponse($productCuston, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProductCuston  $productCuston
     * @return \Illuminate\Http\Response
     */
    public function show(ProductCuston $productCuston)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProductCuston  $productCuston
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductCuston $productCuston)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProductCuston  $productCuston
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductCuston $products_custon)
    {
        $data = $request->all();

        $this->productCustonService->update($data, $products_custon);

        return new JsonResponse($products_custon, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProductCuston  $productCuston
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductCuston $productCuston)
    {
        //
    }
}

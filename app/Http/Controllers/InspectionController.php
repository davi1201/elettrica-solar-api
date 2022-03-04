<?php

namespace App\Http\Controllers;

use App\Infrastructure\Repository\InspectionRepository;
use App\Infrastructure\Repository\PreInspectionRepository;
use App\Model\Inspection;
use App\Model\PreInspection;
use App\Model\Status;
use Illuminate\Http\Request;

class InspectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $inspection_repository;
    protected $pre_inspection_repository;
    
    public function __construct(InspectionRepository $inspectionRepository, PreInspectionRepository $preInspectionRepository)
    {
        $this->inspection_repository = $inspectionRepository;
        $this->pre_inspection_repository = $preInspectionRepository;
    }

    public function index()
    {
        $data = $this->inspection_repository->getAll();
        return response()->json($data, 200);
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Inspection  $inspection
     * @return \Illuminate\Http\Response
     */
    public function show(Inspection $inspection)
    {
        $project = $inspection->project->load('client');
        $data = [
            'inspection' => $inspection,
            'project' => $project->load('city.province'),
            'statuses' => Status::where('department_id', 1)->get(),
            'pre_inspection' => PreInspection::where('project_id', $inspection->project_id)->first(),
            'pre_inspection_attachments' => $this->pre_inspection_repository->getAttachments($inspection->project),
        ];

        return response()->json($data, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Inspection  $inspection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Inspection $inspection)
    {
        $data = $request->all();
        $inspection->update($data);
        return response()->json($inspection, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Inspection  $inspection
     * @return \Illuminate\Http\Response
     */
    public function destroy(Inspection $inspection)
    {
        //
    }
}

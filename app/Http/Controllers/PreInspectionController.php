<?php

namespace App\Http\Controllers;

use App\Infrastructure\Repository\PreInspectionRepository;
use App\Infrastructure\Services\InspectionService;
use App\Infrastructure\Services\PreInspectionService;
use App\Model\PreInspection;
use App\Model\PreInspectionAttachments;
use App\Model\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PreInspectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     protected $pre_inspection_repository;
     protected $pre_inspection_service;
     protected $inspection_service;

    public function __construct(
        PreInspectionRepository $preInspectionRepository, 
        PreInspectionService $preInspectionService,
        InspectionService $inspectionService
    ) {
        $this->pre_inspection_repository = $preInspectionRepository;
        $this->pre_inspection_service = $preInspectionService;
        $this->inspection_service = $inspectionService;
    }

    public function index(Request $request)
    {
        $project = Project::where('id', $request->get('project_id'))->first();
        $project->load('client');
        $project->load('preInspection');
        $project->load('inspection');
        $project->load('city.province');
        $this->pre_inspection_repository->getAttachments($project);
        return response()->json($project, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pre_inspection_data = $request->get('pre_inspection');
        $inspection_data = $request->get('inspection');

        $this->pre_inspection_service->create($pre_inspection_data);
        $this->inspection_service->create($inspection_data);

        return response()->json($pre_inspection_data, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = $request->all();
        $pre_inspection = PreInspection::where('project_id', $data['project_id'])->first();

        $pre_inspection->update($data);
        return response()->json($pre_inspection, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(PreInspectionAttachments $pre_inspection)
    {
        $pre_inspection->delete();
        $pre_inspection->file()->delete();
        File::deleteDirectory(storage_path().'/files/uploads'. $pre_inspection->file->path);
        return response()->json($pre_inspection, 200);
    }

    public function rejected(PreInspectionAttachments $attachment)
    {
        try {
            $pre_inspection = $this->pre_inspection_service->rejecteAttachment($attachment);
            
            return response()->json($pre_inspection, 200);
        } catch (\Throwable $th) {
            return response()->json($th, 400);   
        }
    }
}

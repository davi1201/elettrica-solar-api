<?php
namespace App\Http\Controllers;

use App\Infrastructure\Services\PreInspectionService;
use App\Model\FileEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

class FileEntryController
{
    protected $pre_inspection_service;

    public function __construct(PreInspectionService $preInspectionService)
    {
        $this->pre_inspection_service = $preInspectionService;
    }

    public function uploadFile(Request $request) {
        $file = $request->file('file');
        $filename = $file->getClientOriginalName();
        $data = json_decode($request->get('payload'));
        
        $path = hash( 'sha256', time());

        if(Storage::disk('uploads')->put($path.'/'.$filename,  File::get($file))) {
            $input['filename'] = $filename;
            $input['mime'] = $file->getClientMimeType();
            $input['path'] = $path;
            $file = FileEntry::create($input);

            if (!empty($data)) {
                if ($data->origin === 'pre-inspection') {
                    $this->pre_inspection_service->saveAttachment($file, $data);
                }
            }

            return response()->json($file, 200);
        }
        
        
        return response()->json([
            'success' => ''
        ], 500);
    }
}
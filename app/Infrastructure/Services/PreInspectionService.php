<?php
namespace App\Infrastructure\Services;

use App\Model\FileEntry;
use App\Model\Inspection;
use App\Model\PreInspection;
use App\Model\PreInspectionAttachments;

class PreInspectionService {

    public function saveAttachment(FileEntry $fileEntry, $data)
    {
        $data->file_entry_id = $fileEntry->id;
        $pre_inspection_attachemnt = new PreInspectionAttachments((array)$data);
        $pre_inspection_attachemnt->save();
    }

    public function rejecteAttachment(PreInspectionAttachments $pre_inspection)
    {
        $pre_inspection->status = 'rejected';
        $pre_inspection->update();
        return $pre_inspection;
    }

    public function create(Array $data)
    {
        $pre_inspection = new PreInspection($data);
        $pre_inspection->save();
    }
}
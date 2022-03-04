<?php

namespace App\Infrastructure\Repository;


use App\Model\Project;

class PreInspectionRepository
{
    public function getAttachments(Project $project)
    {
        $attachments = $project->preInspectionAttachments;
        foreach ($attachments as $attachment) {
            $attachment->load('file');
        }
        return $attachments;
    }
}

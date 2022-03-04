<?php

namespace App\Infrastructure\Repository;

use App\Model\Inspection;
use App\Model\Project;

class InspectionRepository
{
   public function getAll()
   {
       $inspections = Inspection::with('status')
                                ->with('project.client')
                                ->with('project.agent')
                                ->with('user')
                                ->orderBy('created_at', 'DESC')
                                ->get();
       return $inspections;
   }
}

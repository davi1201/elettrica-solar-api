<?php

namespace App\Infrastructure\Repository;

use App\Infrastructure\Repository\Filters\RepositoryFilterInterface;
use App\Model\Project;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Auth;

class ProjectRepository
{
    public function getList(RepositoryFilterInterface $filter = null)
    {
        $user =  Auth::user();
        $projects = Project::select()->limit(100)
        ->orderBy('created_at', 'DESC')
        ->with('client.addresses.city.province')
        ->with('agent')
        ->with('province')
        ->with('city');

        if (isset($user->agent)) {
            $projects = $projects->orderBy('created_at', 'DESC')->where('agent_id', $user->agent->id);
        }

        if ($filter !== null) {
            $filter->apply($projects);
        }

        return $projects->get();
    }
}

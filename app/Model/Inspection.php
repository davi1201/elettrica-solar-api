<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Inspection extends Model
{
    protected $fillable = [
        'project_id',
        'status_id',
        'user_id',
        'comment',
    ];

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}

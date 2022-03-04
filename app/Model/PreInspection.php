<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PreInspection extends Model
{
    protected $fillable = [
        'project_id',
        'observations',
    ];
}

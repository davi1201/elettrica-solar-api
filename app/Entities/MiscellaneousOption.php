<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class MiscellaneousOption extends Model
{
    protected $fillable = [
        'slug',
        'label',
        'type'
    ];
}

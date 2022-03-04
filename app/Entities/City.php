<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = [
        'name',
        'latitude',
        'longitude',
    ];

    public function province()
    {
        return $this->belongsTo(Province::class);
    }
}

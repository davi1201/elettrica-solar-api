<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $fillable = [
        'initial',
        'name',
    ];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function cities()
    {
        return $this->hasMany(City::class);
    }
}

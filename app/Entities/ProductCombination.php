<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class ProductCombination extends Model
{

    protected $table = 'products_combinations';
    public $timestamps = false;

    protected $fillable = [
        'panel',
        'power_inverter',
        'roof_type',
    ];

    protected $casts = [
        'panel' => 'string',
        'power_inverter' => 'string',
        'roof_type' => 'string',
    ];
}

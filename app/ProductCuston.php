<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductCuston extends Model
{
    protected $fillable = [
        'value',
        'description',
        'power_estimate',
        'inverter',
        'inverter_power',
        'inverter_quantity',
        'supplier',
        'panel',
        'panel_power',
        'panel_quantity',
        'structure',
        'transformer',
        'transformer_kva',
        'transformer_quantity',
        'string_box_input',
        'string_box_output',
    ];
}

<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ConfigAdmin extends Model
{
    protected $table = 'config_admin';

    protected $fillable = [
        'percentage_sale',
        'percentage_financing',
        'percentage_product' ,
    ];
}

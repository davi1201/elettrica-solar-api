<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'city_id',
        'client_id',
        'zip_code',
        'street',
        'number',
        'neighborhood',
        'address_type',
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}

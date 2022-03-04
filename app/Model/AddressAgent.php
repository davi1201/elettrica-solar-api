<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AddressAgent extends Model
{
    protected $fillable = [
        'city_id',
        'agent_id',
        'zip_code',
        'street',
        'number',
        'neighborhood',
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function agent()
    {
        return $this->hasOne(Agent::class);
    }
}

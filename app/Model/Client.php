<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'agent_id', 
        'name',
        'email',
        'document',
        'phone_mobile',
        'phone',
    ];

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }
}

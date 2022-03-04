<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    protected $fillable = [
        'agent_id',
        'bank_code',
        'bank_name',
        'agency',
        'account',
        'person_type',
    ];

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }
}

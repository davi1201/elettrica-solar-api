<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'fantasy_name',
        'email',
        'file_entry_id',
        'cpf',
        'cnpj',
        'agent_type',
        'phone_mobile',
        'phone',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function address()
    {
        return $this->hasOne(AddressAgent::class);
    }

    public function clients()
    {
        return $this->hasMany(Client::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function bankAccount()
    {
        return $this->hasOne(BankAccount::class);
    }

    public function fileEntry()
    {
        return $this->belongsTo(FileEntry::class);
    }
}

<?php
namespace App\Infrastructure\Services;

use App\Model\AddressAgent;
use App\Model\Agent;
use App\Model\BankAccount;
use App\User;
use Illuminate\Support\Facades\DB;

class AgentService
{
    public function create(Array $data): Agent
    {
        $agent = DB::transaction(function() use ($data) {
            $agent = new Agent($data);
            $user_data = [
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt('subs0l@r2021'),
            ];
    
            $user = new User($user_data);
            $user->save();

            
            $agent->user()->associate($user);
            $agent->save();
            
            

            $bank_account = new BankAccount($data['bank_account']);
            $bank_account->agent()->associate($agent);
            $bank_account->save();

            return $agent;
        });

        return $agent;
    }
}
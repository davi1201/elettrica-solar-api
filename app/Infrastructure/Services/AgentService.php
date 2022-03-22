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
            // $user_data = [
            //     'name' => $data['name'],
            //     'email' => $data['email'],
            //     'password' => bcrypt('elettrica@2022'),
            // ];
    
            // $user = new User($user_data);
            // $user->save();

            
            // $agent->user()->associate($user);
            $agent->save();
            
            

            $bank_account = new BankAccount($data['bank_account']);
            $bank_account->agent()->associate($agent);
            $bank_account->save();

            return $agent;
        });

        return $agent;
    }

    public function update(Array $data, Agent $agent): Agent
    {
        $address_data = $data['address'];
        $address = AddressAgent::find($address_data['id']);
        $address->update($address_data);

        $bank_account_data = $data['bank_account'];
        $bank_account = BankAccount::find($bank_account_data['id']);
        $bank_account->update($bank_account_data);

        $agent->update($data);

        return $agent;
    }
}
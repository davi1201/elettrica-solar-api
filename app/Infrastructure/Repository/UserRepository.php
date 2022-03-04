<?php 

namespace App\Infrastructure\Repository;

use App\User;

class UserRepository
{
    public function getAll()
    {
        $users = User::orderBy('name')->get();
        foreach ($users as $user) {
            if (isset($user->agent)) {
                $user['perfil'] = 'Agente';
            } else {
                $user['perfil'] = 'Administrador';
            }
        }
        return $users;
    }
}


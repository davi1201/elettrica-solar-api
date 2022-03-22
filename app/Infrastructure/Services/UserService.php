<?php 

namespace App\Infrastructure\Services;

use App\User;

class UserService
{
    public function update(User $user, Array $data):User
    {
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->type = $data['type'];
        $user->password = bcrypt($data['password']);
        $user->save();

        return $user;
    }
}


<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\UserResourse;
use App\Models\User;

class UserBlockListController
{
    public function index(){
        return UserResourse::collection(User::bannedUsers());
    }

    public function banUser(User $user){

        $user->ban();

        return response(status: 204);
    }

    public function unbanUser(User $user){

        $user->unban();

        return response(status: 204);
    }

    public function destroy(){

    }
}

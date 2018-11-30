<?php

namespace App\Http\Controllers\Models;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function getUsers()
    {
        $users = User::all();
        return response()->json([
           "status" => "success",
           "code" => 200,
           "data" => $users
        ]);
    }
}

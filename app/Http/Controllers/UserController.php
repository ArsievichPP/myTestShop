<?php

namespace App\Http\Controllers;

use Illuminate\Support\Arr;

class UserController extends Controller
{
    public function index()
    {
        $user = auth()->user()->toArray();
        $user = Arr::only($user, ['name', 'email', 'phone', 'address']);
        return view('user', ['user' => $user]);
    }


}

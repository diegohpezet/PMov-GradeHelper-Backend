<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return User::all();
    }


    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return response()->json($user);
    }
}

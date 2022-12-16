<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function create(Request $request){
        return $request;
    }

    public function show(Request $request){
        return User::findOrFail($request->id);
    }
}

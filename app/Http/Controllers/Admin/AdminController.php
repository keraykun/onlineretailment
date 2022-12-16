<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\userReports;
use App\Models\User;
use App\Models\violationReports;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard(){
        $user = User::whereHas('role',function($role){
            $role->whereIn('name',['user']);
        })->count();
        $client = User::whereHas('role',function($role){
            $role->whereIn('name',['client']);
        })->count();
        $violation = violationReports::where('notification',1)->count();
        return view('admin.dashboard',[
            'user'=>$user,
            'client'=>$client,
            'violation'=>$violation,
        ]);
    }
}

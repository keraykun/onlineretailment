<?php

namespace App\Http\Controllers\User\History;

use App\Http\Controllers\Controller;
use App\Models\orderStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public function index(){
        $user = Auth::user()->id;
         $orders = orderStatus::where('user_id',$user)->get();
        return view('user.history.index',['orders'=>$orders]);
    }
}

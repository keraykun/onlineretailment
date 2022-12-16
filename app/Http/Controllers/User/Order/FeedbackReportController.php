<?php

namespace App\Http\Controllers\User\Order;

use App\Http\Controllers\Controller;
use App\Models\feedbackReports;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackReportController extends Controller
{

    public function store(Request $request){

        $user = Auth::user()->id;
        feedbackReports::create([
            'from_user_id'=> $user,
            'to_user_id'=>$request->user_id,
            'product_id'=>$request->product_id,
            'title'=>$request->title,
            'description'=>$request->description,
            'notification'=>1
        ]);

        Order::where('user_id',$user)
        ->where('_id',$request->id)
        ->where('product_id',$request->product_id)
        ->delete();
        return redirect()->back();
    }
}

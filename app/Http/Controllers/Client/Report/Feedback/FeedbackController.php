<?php

namespace App\Http\Controllers\Client\Report\Feedback;

use App\Http\Controllers\Controller;
use App\Models\feedbackReports;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    public function index(){
        $user = Auth::user()->id;
         $reports = feedbackReports::where('to_user_id',$user)
        ->with(['product.category'])
        ->where('notification',1)
        ->get();
        return view('client.report.feedback.index',['reports'=>$reports]);
    }

    public function show(Products $product){
        $user = Auth::user()->id;
        feedbackReports::where('product_id',$product->_id)
        ->where('to_user_id',$user)
        ->update(['notification'=>0]);
        return redirect()->route('guest.feedback',$product->_id);
    }
}

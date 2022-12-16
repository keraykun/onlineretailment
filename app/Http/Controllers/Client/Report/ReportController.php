<?php

namespace App\Http\Controllers\Client\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\feedbackReports;
use App\Models\productRefund;
use App\Models\violationReports;

class ReportController extends Controller
{
    public function index(){
        $user = Auth::user()->id;
        $countfeedback = feedbackReports::where('to_user_id',$user)
        ->where('notification',1)->count();
        $countrefund = productRefund::where('to_user_id',$user)
        ->where('notification',1)->count();
        $violationReport = violationReports::where('to_user_id',$user)
        ->where('notification',1)->count();

         $reports = productRefund::where('to_user_id',$user)
        ->where('notification',1)->get();
        return view('client.report.index',[
            'reports'=>$reports,
            'countrefund'=>$countrefund,
            'countfeedback'=>$countfeedback,
            'violation'=>$violationReport
        ]
    );
    }
}

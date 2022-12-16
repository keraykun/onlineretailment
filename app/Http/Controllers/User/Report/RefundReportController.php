<?php

namespace App\Http\Controllers\User\Report;

use App\Http\Controllers\Controller;
use App\Models\productRefund;
use App\Models\productReports;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\replyReports;
class RefundReportController extends Controller
{
    public function index(){
         $user = Auth::user()->id;
         $reports = productRefund::where('from_user_id',$user)->get();
         return view('user.report.index',['reports'=>$reports]);
    }

    public function show($request){
        $user = Auth::user()->id;
         $report = productRefund::
        with(['user','product.image','reply.user'])
        ->where('from_user_id',$user)->first();
        abort_if($report===null,404);
        return view('user.report.report_message',['report'=>$report]);
    }

    public function store(Request $request){
        $report = productRefund::findOrFail($request->id);
        replyReports::create([
            'model'=>'App\Models\productRefund',
            'model_id'=>$report->id,
            'user_id'=>Auth::user()->id,
            'description'=>$request->textarea,
            'notification'=>1,
        ]);
         return redirect()->back();
    }

    public function destroy(replyReports $replyreports)
    {
        $user = Auth::user()->id;
       replyReports::where('_id',$replyreports->id)
       ->where('model_id',$replyreports->model_id)
       ->where('user_id',$user)
       ->where('model','App\Models\productRefund')
       ->delete();
       return redirect()->back();
    }


    public function trash(productRefund $productrefund)
    {


       replyReports::where('model_id',$productrefund->id)
       ->where('model','App\Models\productRefund')
       ->delete();
       productrefund::where('_id',$productrefund->id)->delete();
       return redirect()->route('user.report.refund.index');
    }


    public function solve(productRefund $productrefund)
    {
        return $productrefund; //no here
    //     $user = Auth::user()->id;
    //   replyReports::where('_id',$replyreports->id);
    //    ->where('model_id',$replyreports->model_id)
    //    ->where('user_id',$user)
    //    ->where('model','App\Models\productRefund')
    //    ->delete();
    //    return redirect()->back();
    }
}

<?php

namespace App\Http\Controllers\Client\Report\Violation;


use App\Http\Controllers\Controller;
use App\Models\feedbackReports;
use App\Models\Products;
use App\Models\violationReports;
use Illuminate\Http\Request;
use App\Models\replyReports;
use Illuminate\Support\Facades\Auth;

class ViolationController extends Controller
{
    public function index(){
        $user = Auth::user()->id;
          $reports = violationReports::where('to_user_id',$user)
         ->with(['fromuser'])
        ->get();
       return view('client.report.violation.index',['reports'=>$reports]);
    }

    public function show(violationReports $data){
         $report = violationReports::where('_id',$data->_id)->with(['touser.role','fromuser.role','reply.user'])->first();
        return view('client.report.violation.violation_message',['report'=>$report]);
    }

    public function store(Request $request){

        $report = violationReports::findOrFail($request->id);
        replyReports::create([
            'model'=>'App\Models\violationReports',
            'model_id'=>$report->id,
            'user_id'=>Auth::user()->id,
            'description'=>$request->textarea,
            'notification'=>1,
        ]);
        return redirect()->back();
    }

    public function solve(violationReports $violationReports)
    {

    violationReports::where('_id',$violationReports->_id)
      ->update(['notification'=>0]);
      return redirect()->back();
    }

   public function destroy(replyReports $replyreports)
   {
       $user = Auth::user()->id;
      replyReports::where('_id',$replyreports->id)
      ->where('model_id',$replyreports->model_id)
      ->where('user_id',$user)
      ->where('model','App\Models\violationReports')
      ->delete();
      return redirect()->back();
   }
}

<?php

namespace App\Http\Controllers\Admin\Reports\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\userReport;
use App\Models\replyReports;
use App\Models\userReports;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserReportController extends Controller
{
    public function index(Request $request){

       if($request->search){
        $search = $request->search;
        $reports = userReports::whereHas('user',function($user) use($search){
            $user->where('name','like', "%$search%");
        })
        ->orWhere('title','like', "%$search%")
        ->where('notification',1)
        ->paginate(10);
       }else{
          $reports = userReports::with('user','replyCount')->where('notification',1)->paginate(10);
        }
       return view('admin.report.user.index',['reports'=>$reports]);
    }

    public function show(userReports $userreport){
        $model_name = 'App\Models\userReports';
        $find = userReports::findOrFail($userreport->id);
        $report = userReports::where('_id',$find->id)
        ->where('user_id',$find->user_id)
        ->with(['user.role','reply.user','reply'=>function($id) use($model_name){
            return $id->where('model',$model_name);
        }])->first();
        return view('admin.report.user.user_reports_message',['report'=>$report]);
    }

    public function store(userReport $request){
        $report = userReports::findOrFail($request->id);
        replyReports::create([
            'model'=>'App\Models\userReports',
            'model_id'=>$report->id,
            'user_id'=>Auth::user()->id,
            'description'=>$request->textarea,
            'notification'=>1
        ]);
         return redirect()->back();
    }

    public function update(userReport $userreport)
    {
        userReport::where('_id',$userreport->id)
        ->update(['notification'=>0]);
        return redirect()->back();
    }


    public function destroy(replyReports $replyreports)
     {
        replyReports::destroy($replyreports->id);
        replyReports::where('model_id',$replyreports->id)
        ->where('model','App\Models\userReports')
        ->delete();
        return redirect()->back();

     }
}

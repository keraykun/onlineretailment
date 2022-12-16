<?php

namespace App\Http\Controllers\Admin\Reports\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\productReports;
use Illuminate\Support\Facades\Auth;
use App\Models\replyReports;

class ProductController extends Controller
{
    public function index(Request $request){

     if($request->search){
        $search = $request->search;
        $reports = productReports::whereHas('user',function($user) use($search){
            $user->where('name','like', "%$search%");
        })
        ->orWhere('title','like', "%$search%")
        ->where('notification',1)
        ->paginate(10);
       }else{
          $reports = productReports::with('user','replyCount')->where('notification',1)->paginate(10);
        }
       return view('admin.report.product.index',['reports'=>$reports]);
  }

  public function show(productReports $productreport){

         $model_name = 'App\Models\productReports';
         $find = productReports::findOrFail($productreport->id);
         $report = productReports::where('_id',$find->id)
         ->with(['user.role','reply.user','reply'=>function($id) use($model_name){
            return $id->where('model',$model_name);
        }])->first();
        return view('admin.report.product.product_reports_message',['report'=>$report]);
  }

  public function store(Request $request){
     $report = productReports::findOrFail($request->id);
      replyReports::create([
          'model'=>'App\Models\productReports',
          'model_id'=>$report->id,
          'user_id'=>Auth::user()->id,
          'description'=>$request->textarea,
          'notification'=>1,
      ]);
       return redirect()->back();
  }


  public function update(productReports $productReports)
   {
    productReports::where('_id',$productReports->id)
    ->update(['notification'=>0]);
    return redirect()->back();
   }


  public function destroy(productReports $productReports)
   {
      productReports::destroy($productReports->id);
      replyReports::where('model_id',$productReports->id)
      ->where('model','App\Models\productReports')
      ->delete();
      return redirect()->route('admin.report.product.index');
   }
}

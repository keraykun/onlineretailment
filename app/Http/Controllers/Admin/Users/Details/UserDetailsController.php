<?php

namespace App\Http\Controllers\Admin\Users\Details;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\orderStatus;
use App\Models\User;
use App\Models\Wishlist;
use App\Models\feedbackReports;
use App\Models\Products;
use App\Models\productSold;
use App\Models\violationReports;
use Illuminate\Http\Request;
use App\Models\replyReports;

class UserDetailsController extends Controller
{
 public function products(User $data){
    $orders = Order::where('user_id',$data->_id)->with(['product.image','product.category'])->paginate(15);
    return view('admin.users.user.index',['orders'=>$orders,'data'=>$data]);
  }

  public function history(User $data){
     $orders = orderStatus::where('user_id',$data->_id)->paginate(15);
    return view('admin.users.user.history',['orders'=>$orders,'data'=>$data]);
  }

  public function wishlist(User $data){
     $orders = Wishlist::where('user_id',$data->id)
    ->with(['product.category','product.image'])
    ->orderBy('_id','desc')
    ->paginate(8);
    return view('admin.users.user.wishlist',['orders'=>$orders,'data'=>$data]);
  }


  public function create(Request $request){
   $user = Auth::user()->id;
   violationReports::create([
     'from_user_id'=>$user,
     'to_user_id'=>$request->user_id,
     'title'=>$request->title,
     'description'=>$request->description,
     'notification'=>1,
     ]);
     return redirect()->back()->with('success','Violation Created');
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


public function show(User $data){

  return view('admin.users.user.violation_create',['data'=>$data]);
 }

public function violation(User $data){
  $reports = violationReports::where('to_user_id',$data->_id)
 ->with(['fromuser.image'])->get();
 return view('admin.users.user.violation',['reports'=>$reports,'data'=>$data]);
}

public function message(violationReports $data){
   $report = violationReports::where('_id',$data->_id)->with(['touser.role','fromuser.role','reply.user'])->first();
   return view('admin.users.user.violation_message',['report'=>$report]);
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

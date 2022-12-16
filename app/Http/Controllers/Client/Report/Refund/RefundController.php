<?php

namespace App\Http\Controllers\Client\Report\Refund;

use App\Http\Controllers\Controller;
use App\Models\feedbackReports;
use App\Models\orderStatus;
use App\Models\productRefund;
use App\Models\productReports;
use App\Models\productSold;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\replyReports;

class RefundController extends Controller
{
    public function show($product, $user){
        $auth = Auth::user()->id;
         $report = productRefund::where('to_user_id',$auth)
        ->where('from_user_id',$user)
        ->where('product_id',$product)
        ->with(['product.category','product.image','user','reply','owner'])
        ->first();

        abort_if($report===null,404);
        return view('client.report.refund.show',['report'=>$report]);
    }

    public function index(){
        $user = Auth::user()->id;
         $reports = productRefund::where('to_user_id',$user)
              ->with(['product.category','product.image','user','reply','owner','productsold'])
              ->get();
        return view('client.report.refund.index',['reports'=>$reports]);
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

    public function solve(productRefund $productRefund)
    {
       productRefund::where('_id',$productRefund->_id)
       ->update(['notification'=>0]);
       return redirect()->route('client.report.refund.index');
    }

    public function order(productRefund $productRefund)
    {

        $product_sold = productSold::where('order_id',$productRefund->order_id)
        ->update(['status'=>'refund']);

        $order_status = orderStatus::where('order_id',$productRefund->order_id)
        ->update(['status'=>'refund']);

        productRefund::where('_id',$productRefund->id)
        ->update(['notification'=>0]);

         return redirect()->route('client.report.refund.index');
    }
}

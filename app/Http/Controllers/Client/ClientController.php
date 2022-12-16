<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\productSold;
use App\Models\User;
use Illuminate\Support\Str;


class ClientController extends Controller
{
    public function dashboard(Request $request){
    $user = Auth::user()->id;

    $products = productSold::where('user_id',$user)->get();

    $productSold = productSold::where('user_id',$user)->where('status','delivered')->count();
    $productRefund = productSold::where('user_id',$user)->where('status','refund')->count();
    $productCancelled = productSold::where('user_id',$user)->where('status','cancelled')->count();

    $pending = Order::where('seller_id',$user)->where('status','pending')->count();
    $approved = Order::where('seller_id',$user)->where('status','approved')->count();
    $cancel = Order::where('seller_id',$user)->where('status','cancelled')->count();


    $monthRefund = [
        'Dec'=>0,
        'Jan'=>0,
        'Feb'=>0,
        'Mar'=>0,
        'Apr'=>0,
        'May'=>0,
        'Jun'=>0,
        'Jul'=>0,
    ];
    $monthRefundCount = [
        'dec'=>0,
        'jan'=>0,
        'feb'=>0,
        'mar'=>0,
        'apr'=>0,
        'may'=>0,
        'jun'=>0,
        'jul'=>0,
    ];
    $monthySales = [
        'Dec'=>0,
        'Jan'=>0,
        'Feb'=>0,
        'Mar'=>0,
        'Apr'=>0,
        'May'=>0,
        'Jun'=>0,
        'Jul'=>0,
    ];
    $monthySalesProduct = [
        'Dec'=>0,
        'Jan'=>0,
        'Feb'=>0,
        'Mar'=>0,
        'Apr'=>0,
        'May'=>0,
        'Jun'=>0,
        'Jul'=>0,
    ];
    $monthCancelled = [
        'Dec'=>0,
        'Jan'=>0,
        'Feb'=>0,
        'Mar'=>0,
        'Apr'=>0,
        'May'=>0,
        'Jun'=>0,
        'Jul'=>0,
    ];

    $monthyRefund = [];
    $monthyCancelled = [];

        //monthly Refund
            foreach($products as $product){
                if($product->status=='refund' && date('m Y',strtotime($product->created_at))=='12 2022'){
                    $monthRefundCount['dec'] += 1;
                    $monthyRefund[] += $product->price;
                }else if($product->status=='refund' && date('m Y',strtotime($product->created_at))=='01 2023'){
                    $monthRefundCount['jan'] += 1;
                    $monthyRefund[] += $product->price;
                }else if($product->status=='refund' && date('m Y',strtotime($product->created_at))=='02 2023'){
                    $monthRefundCount['feb'] += 1;
                    $monthyRefund[] += $product->price;
                }else if($product->status=='refund' && date('m Y',strtotime($product->created_at))=='03 2023'){
                    $monthRefundCount['mar'] += 1;
                    $monthyRefund[] += $product->price;
                }else if($product->status=='refund' && date('m Y',strtotime($product->created_at))=='04 2023'){
                    $monthRefundCount['apr'] += 1;
                    $monthyRefund[] += $product->price;
                }else if($product->status=='refund' && date('m Y',strtotime($product->created_at))=='05 2023'){
                    $monthRefundCount['may'] += 1;
                    $monthyRefund[] += $product->price;
                }else if($product->status=='refund' && date('m Y',strtotime($product->created_at))=='06 2023'){
                    $monthRefundCount['jun'] += 1;
                    $monthyRefund[] += $product->price;
                }else if($product->status=='refund' && date('m Y',strtotime($product->created_at))=='07 2023'){
                    $monthRefundCount['jul'] += 1;
                    $monthyRefund[] += $product->price;
                }else{
                    continue;
                }
            }
        //monthly delieverd
            foreach($products as $product){
                if($product->status=='delivered' && date('m Y',strtotime($product->created_at))=='12 2022'){
                    $monthySales['Dec'] += $product->price;
                    $monthySalesProduct['Dec'] += 1;
                }else if($product->status=='delivered' && date('m Y',strtotime($product->created_at))=='01 2023'){
                    $monthySales['Jan'] += $product->price;
                    $monthySalesProduct['Jan'] += 1;
                }else if($product->status=='delivered' && date('m Y',strtotime($product->created_at))=='02 2023'){
                    $monthySales['Feb'] += $product->price;
                    $monthySalesProduct['Feb'] += 1;
                }else if($product->status=='delivered' && date('m Y',strtotime($product->created_at))=='03 2023'){
                    $monthySales['Mar'] += $product->price;
                    $monthySalesProduct['Mar'] += 1;
                }else if($product->status=='delivered' && date('m Y',strtotime($product->created_at))=='04 2023'){
                    $monthySales['Apr'] += $product->price;
                    $monthySalesProduct['Apr'] += 1;
                }else if($product->status=='delivered' && date('m Y',strtotime($product->created_at))=='05 2023'){
                    $monthySales['May'] += $product->price;
                    $monthySalesProduct['May'] += 1;
                }else if($product->status=='delivered' && date('m Y',strtotime($product->created_at))=='06 2023'){
                    $monthySales['Jun'] += $product->price;
                    $monthySalesProduct['Jun'] += 1;
                }else if($product->status=='delivered' && date('m Y',strtotime($product->created_at))=='07 2023'){
                    $monthySales['Jul'] += $product->price;
                    $monthySalesProduct['Jul'] += 1;
                }else{
                    continue;
                }
            }


        //monthly cancelled
            foreach($products as $product){
                if($product->status=='cancelled' && date('m Y',strtotime($product->created_at))=='12 2022'){
                    $monthyCancelled[] += $product->price;
                    $monthCancelled['Dec'] += 1;
                }else if($product->status=='cancelled' && date('m Y',strtotime($product->created_at))=='01 2023'){
                    $monthyCancelled[] += $product->price;
                    $monthCancelled['Jan'] += 1;
                }else if($product->status=='cancelled' && date('m Y',strtotime($product->created_at))=='02 2023'){
                    $monthyCancelled[] += $product->price;
                    $monthCancelled['Feb'] += 1;
                }else if($product->status=='cancelled' && date('m Y',strtotime($product->created_at))=='03 2023'){
                    $monthyCancelled[] += $product->price;
                    $monthCancelled['Mar'] += 1;
                }else if($product->status=='cancelled' && date('m Y',strtotime($product->created_at))=='04 2023'){
                    $monthyCancelled[] += $product->price;
                    $monthCancelled['Apr'] += 1;
                }else if($product->status=='cancelled' && date('m Y',strtotime($product->created_at))=='05 2023'){
                    $monthyCancelled[] += $product->price;
                    $monthCancelled['May'] += 1;
                }else if($product->status=='cancelled' && date('m Y',strtotime($product->created_at))=='06 2023'){
                    $monthyCancelled[] += $product->price;
                    $monthCancelled['Jun'] += 1;
                }else if($product->status=='cancelled' && date('m Y',strtotime($product->created_at))=='07 2023'){
                    $monthyCancelled[] += $product->price;
                    $monthCancelled['Jul'] += 1;
                }else{
                    continue;
                }
            }


        //monthsearch

        $monthSearch = collect($products)->map(function ($product) {
        if($product->status=='refund'){
        return date('m Y',strtotime($product->created_at));
        }
        })->unique()->values();
        foreach($monthSearch as $month){
            switch ($month) {
                case '12 2022':
                $monthRefund['Dec'] = 1;
                    break;
                case '01 2023':
                    $monthRefund['Jan'] = 1;
                    break;
                case '02 2023':
                    $monthRefund['Feb'] = 1;
                    break;
                case '03 2023':
                    $monthRefund['Mar'] = 1;
                    break;
                case '04 2023':
                    $monthRefund['Apr'] = 1;
                    break;
                case '05 2023':
                    $monthRefund['May'] = 1;
                    break;
                case '06 2023':
                    $monthRefund['Jun'] = 1;
                    break;
                case '07 2023':
                    $monthRefund['Jul'] = 1;
                    break;
                default:
                    false;
                    break;
                }
        }

        $totalDelivered = collect($monthySales)->values()->sum(); // total delivered
        $totalRefund = collect($monthyRefund)->values()->sum(); // total delivered
        $totalCancelled = collect($monthyCancelled)->sum(); //total cancelled


        $monthRefundValues = collect($monthRefundCount)->values();
        $monthRefundKeys = collect($monthRefundCount)->keys();


        $monthCancelledValues = collect($monthCancelled)->values();
        $monthCancelledKeys = collect($monthCancelled)->keys();

        $saless =  collect($monthySales)->values();
        $monthss =  collect($monthySales)->keys();
        $productss = collect($monthySalesProduct)->values();

        $revenue = collect([$totalCancelled,$totalRefund,$totalDelivered])->sum();
        $revenueProduct = collect([$productSold ,$productRefund, $productCancelled])->sum();

        $delivered = productSold::where('user_id',$user)
        ->where('status','delivered')
        ->count();
        $cancelled = productSold::where('user_id',$user)
        ->where('status','cancelled')
        ->count();
        $refund = productSold::where('user_id',$user)
        ->where('status','refund')
        ->count();
        return view('client.dashboard',[
            'statuscount'=>[$refund,$cancelled,$delivered],
            'order'=>[
                $pending,
                $cancel,
                $approved
            ],
            'cancel'=>[
                $monthCancelledValues,
                $monthCancelledKeys
            ],
            'refund'=>[
                $monthRefundValues,
                $monthRefundKeys
            ],
            'line'=>[
                $saless,
                $monthss,
                $productss,
            ],
            'statustotal'=>[
                ' -'.$totalRefund,
                ' '. $totalCancelled,
                ' '.$totalDelivered,
            ],
            'total'=>$revenue,
            'totalproduct'=>$revenueProduct
        ]);
    }
}

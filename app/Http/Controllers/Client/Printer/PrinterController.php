<?php

namespace App\Http\Controllers\Client\Printer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\PDF;
use App\Models\productSold;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PrinterController extends Controller
{
    public function index(Request $request){

        $user = Auth::user()->id;
        $data = productSold::where('user_id',$user)
        ->with(['product.category','product.image'])
        ->orderBy('_id','desc')
        ->get();

        if($request->month!='All'){
            $newDataSum = [];;
            $products = collect($data)->map(function($value, $key) use($request){
                if(date('Y-m',strtotime($value->created_at))==$request->month){
                    return [
                        '_id'=>$value->_id,
                        'user_id'=>$value->user_id,
                        'product_id'=>$value->product_id,
                        'order_id'=>$value->order_id,
                        'price'=>$value->price,
                        'status'=>$value->status,
                        'product_name'=>$value->product->name,
                        'product_image'=>$value->product->image->name,
                        'category_name'=>$value->product->category->name,
                        'created_at'=>date('Y-m',strtotime($value->created_at)),
                    ];
                }
            })->filter();
        }else if($request->month=='All'){
            $products = collect($data)->map(function($value, $key) use($request){
                return [
                    '_id'=>$value->_id,
                    'user_id'=>$value->user_id,
                    'product_id'=>$value->product_id,
                    'order_id'=>$value->order_id,
                    'price'=>$value->price,
                    'status'=>$value->status,
                    'product_name'=>$value->product->name,
                    'product_image'=>$value->product->image->name,
                    'category_name'=>$value->product->category->name,
                    'created_at'=>date('Y-m',strtotime($value->created_at)),
                    ];
            })->filter();
        }else{
            $products = collect($data)->map(function($value, $key) use($request){
                    return [
                        '_id'=>$value->_id,
                        'user_id'=>$value->user_id,
                        'product_id'=>$value->product_id,
                        'order_id'=>$value->order_id,
                        'price'=>$value->price,
                        'status'=>$value->status,
                        'product_name'=>$value->product->name,
                        'product_image'=>$value->product->image->name,
                        'category_name'=>$value->product->category->name,
                        'created_at'=>date('Y-m',strtotime($value->created_at)),
                    ];
            })->filter();
        }
        return view('client.printer.index',['products'=>$products]);
    }

    public function print(Request $request){
        $user = Auth::user()->id;
        if($request->month){
            $data = productSold::where('user_id',$user)
            ->with(['product.category','product.image'])
            ->get();
            $newDataSum = [];
            $totaldeliver = 0;
            $totalcancel = 0;
            $totalrefund = 0;
            $products = collect($data)->map(function($value, $key) use($request){
                if(date('Y-m',strtotime($value->created_at))==$request->month){
                    return [
                        '_id'=>$value->_id,
                        'user_id'=>$value->user_id,
                        'product_id'=>$value->product_id,
                        'order_id'=>$value->order_id,
                        'price'=>$value->price,
                        'status'=>$value->status,
                        'product_name'=>$value->product->name,
                        'category_name'=>$value->product->category->name,
                        'created_at'=>date('Y-m',strtotime($value->created_at)),
                    ];
                    }
                })->filter();
                foreach($products as $new){
                 $newDataSum[] = $new['price'] ;
                    switch ($new['status']) {
                        case 'delivered':
                            $totaldeliver += $new['price'];
                            break;
                        case 'cancelled':
                            $totalcancel += $new['price'];
                            break;
                            case 'refund':
                            $totalrefund += $new['price'];
                            break;
                        default:
                            break;
                    }
                }

            $summaries = collect($newDataSum)->sum();
            $totalsummaries = $summaries - collect([$totalcancel,$totalrefund])->sum();

            $pdf = Pdf::setOption(['dpi' => 150, 'defaultFont' => 'sans-serif']);
            return $pdf->loadView('client/printer/prints',
            compact(
                'products',
                'totalcancel',
                'totaldeliver',
                'totalrefund',
                'summaries',
                'totalsummaries'
                ))->stream();
        }else{
            $sum = productSold::where('user_id',$user)->pluck('price');
            $summary = collect($sum)->map(function($number){return (int)$number;})->sum();

            $deliver = collect(productSold::where('user_id',$user)
            ->where('status','delivered')->pluck('price'))
            ->map(function($number){return (int)$number;})->sum();

            $refunds = collect(productSold::where('user_id',$user)
            ->where('status','refund')->pluck('price'))
            ->map(function($number){return (int)$number;})->sum();

            $cancel = collect(productSold::where('user_id',$user)
            ->where('status','cancelled')->pluck('price'))
            ->map(function($number){return (int)$number;})->sum();

            $total =  $summary - collect([$cancel,$refunds])->sum();

            $products = productSold::with(['product.category','product.image'])
            ->where('user_id',$user)
            ->orderBy('_id','desc')
            ->get();
            $pdf = Pdf::setOption(['dpi' => 150, 'defaultFont' => 'sans-serif']);
            return $pdf->loadView('client/printer/print',compact('products','summary','cancel','refunds','deliver','total'))->stream();
        }

    }
}

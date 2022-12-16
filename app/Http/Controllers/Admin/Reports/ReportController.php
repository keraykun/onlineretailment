<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use App\Models\userReports;
use App\Models\productReports;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(){
        $userReport = userReports::where('notification',1)->count();
        $productReports = productReports::where('notification',1)->count();
        return view('admin.report.index',[
            'userReport'=>$userReport,
            'productReports'=>$productReports
        ]);
    }
}

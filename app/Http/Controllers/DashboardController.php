<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\PDF;



class DashboardController extends Controller
{
    function DashboardPage():View{
        return view('pages.dashboard.dashboard-page');
    }
    function ReportPage():View{
        return view('pages.dashboard.report-page');
    }

    function Summary(Request $request):array{

        $user_id=$request->header('id');

        $product= Product::where('user_id',$user_id)->count();
        $Category= Category::where('user_id',$user_id)->count();
        $Customer=Customer::where('user_id',$user_id)->count();
        $Invoice= Invoice::where('user_id',$user_id)->count();
        $total=  Invoice::where('user_id',$user_id)->sum('total');
        $vat= Invoice::where('user_id',$user_id)->sum('vat');
        $payable =Invoice::where('user_id',$user_id)->sum('payable');

        return[
            'product'=> $product,
            'category'=> $Category,
            'customer'=> $Customer,
            'invoice'=> $Invoice,
            'total'=> round($total,2),
            'vat'=> round($vat,2),
            'payable'=> round($payable,2)
        ];


    }

    function SaleReport(Request $request){
        $user_id=$request->header('id');
        $FormDate = date('Y-m-d', strtotime($request->FormDate));
        $ToDate = date('Y-m-d', strtotime($request->ToDate));


        $total=Invoice::where('user_id',$user_id)->whereDate('created_at', ">=" , $FormDate)->whereDate('created_at', "<=" , $ToDate)->sum('total');

        $vat=Invoice::where('user_id',$user_id)->whereDate('created_at', ">=" , $FormDate)->whereDate('created_at', "<=" , $ToDate)->sum('vat');
        $payable= Invoice::where("user_id", "=" , $user_id)->whereDate('created_at', ">=" , $FormDate)->whereDate('created_at', "<=" , $ToDate)->sum('payable');
        $discount= Invoice::where("user_id", "=" , $user_id)->whereDate('created_at', ">=" , $FormDate)->whereDate('created_at', "<=" , $ToDate)->sum('discount');
        $list= Invoice::where("user_id", "=" , $user_id)->whereDate('created_at', ">=" , $FormDate)->whereDate('created_at', "<=" , $ToDate)->get();

       $data= [
            'total'=>$total,
            'vat'=>$vat,
            'payable'=>$payable,
            'discount'=>$discount,
            'list'=>$list,
            'FormDate'=>$FormDate,
            'ToDate'=>$ToDate
        ];

        $pdf= PDF::loadView('report.SalesReport', $data);
        return $pdf->download('saleReport.pdf');
        
    }
}

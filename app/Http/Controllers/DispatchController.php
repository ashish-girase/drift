<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\ProductType;
use App\Models\Customer;
use App\Models\Dispatch;
use App\Helpers\AppHelper;
use App\Models\API\Login_History;
use MongoDB\BSON\Regex;
use Auth;
use PDF;
use DB;
use Illuminate\Validation\Rule;
use Validator;

class DispatchController extends Controller
{
    public function view_dispatch_order(Request $request){

        // $companyID=1;
        $id=$request->id;
        $companyID=1;
        $collection=Dispatch::raw();
        // $customers = Customer::select('_id', 'custName')->get();
        $cust_id=$request->input('cust_id');
        $customers = Customer::raw()->aggregate([
            ['$match' => ['companyID' => $companyID]],
            ['$unwind' => '$customer'],
            ['$match' => ['customer._id' => $cust_id]],
            ['$limit' => 1],
            
            ])->toArray();
    
            $customers_name = $customers ? $customers[0]['customer']['custName'] : '';
        $orderCurr = $collection->aggregate([
            ['$match' => ['companyID' => $companyID]],
            ['$unwind' => '$order'],  // Unwind the order array first
            ['$match' => ['order.delete_status' => "NO"]],  // Apply filter after unwinding
            ['$sort' => ['order._id' => -1]]
        ]);

        $order_data = $orderCurr->toArray();
        // dd($order_data);
        
        return view('dispatch.view_dispatch', compact('order_data'));
                
        

    }

    public function dispatch_details(Request $request){
        $parent=$request->master_id;
        $companyID=1;
        $id=$request->id;
        // dd($id);
        // dd($parent);
        $collection=Dispatch::raw();
        
        $orderData = $collection->aggregate([
        ['$match' => ['_id' => (int)$parent, 'companyID' => $companyID]],
        ['$unwind' => '$order'],
        ['$match' => ['order._id' => (int)$id]],
        // ['$match' => ['designname.delete_status' => "NO"]],
        ])->toArray();
        foreach ($orderData as $row) {
            $activeProduct12 = array();
            $k = 0;
            $activeProduct12[$k] = $row['order'];
            $k++;
        }
        // dd($orderData);

        return view('dispatch.view_dispatchdetails', compact('orderData'));
    }
}

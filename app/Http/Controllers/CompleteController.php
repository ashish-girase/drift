<?php

namespace App\Http\Controllers;

use App\Models\Completed;
use Illuminate\Http\Request;

class CompleteController extends Controller
{
    public function view_complete_order(Request $request){
        $id=$request->id;
        $companyID=1;
        $collection=Completed::raw();
        // $customers = Customer::select('_id', 'custName')->get();
        $cust_id=$request->input('cust_id');
        $customers = Completed::raw()->aggregate([
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
        
        return view('complete.view_complete', compact('order_data'));
    }

    public function complete_details(Request $request){
        $parent=$request->master_id;
        $companyID=1;
        $id=$request->id;
        // dd($id);
        // dd($parent);
        $collection=Completed::raw();
        
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

        
        // dd($notes_Curr);

        return view('complete.view_compledetails', compact('orderData'));
    }
}

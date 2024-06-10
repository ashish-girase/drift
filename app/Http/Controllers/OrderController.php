<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Design;
use Illuminate\Http\Request;
// use App\Models\User;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Colour;
use App\Models\Color;
use App\Helpers\AppHelper;
use App\Models\API\Login_History;
use MongoDB\BSON\Regex;
use Auth;
use PDF;
use DB;
use Illuminate\Validation\Rule;
use Validator;
use MongoDB\Client;
use App\Models\NewOrder;
use App\Models\Processing;
use App\Models\Dispatch;
use App\Models\Cancelled;
use App\Models\Completed;
use App\Models\New_notes;
use Illuminate\Support\Facades\Redirect;

class OrderController extends Controller
{
  
    public function addOrder(Request $request)
    {
        // dd($request);
        $isChecked = $request->input('isChecked');
        $maxLength = 2000;
        $new_id = NewOrder::max('_id') + 1;
        $randomNumber = rand(100000, 999999);
        $unique_value = $randomNumber . $new_id;
        $companyId = 1;
        $docAvailable = AppHelper::instance()->checkDoc(NewOrder::raw(), $companyId, $maxLength);

        $cust_id = (int)$request->input('cust_id');
        // dd($cust_id);
        $prod_id = (int)$request->input('prod_id');
        // Fetch customer details
        $customer = Customer::raw()->aggregate([
        ['$match' => ['companyID' => $companyId]],
        ['$unwind' => '$customer'],
        ['$match' => ['customer._id' => $cust_id]],
        ['$limit' => 1]
        ])->toArray();

        $customers_name = $customer ? $customer[0]['customer']['custName'] : '';

        // Fetch product details
        $product = Product::raw()->aggregate([
        ['$match' => ['companyID' => $companyId]],
        ['$unwind' => '$product'],
        ['$match' => ['product._id' => $prod_id]],
        ['$limit' => 1]
        ])->toArray();

        $products_name = $product ? $product[0]['product']['prodName'] : '';

        $colour_id = (int)$request->input('colour_id');
        $colour = Color::raw()->aggregate([
            ['$match' => ['companyID' => $companyId]],
            ['$unwind' => '$color'],
            ['$match' => ['color._id' => $colour_id]],
            ['$limit' => 1]
            ])->toArray();

            
            $colours_name = $colour ? $colour[0]['color']['color_name'] : '';
            // dd($colours_name);

            $design_id = (int)$request->input('design_id');
            $design = Design::raw()->aggregate([
                ['$match' => ['companyID' => $companyId]],
                ['$unwind' => '$design'],
                ['$match' => ['design._id' => $design_id]],
                ['$limit' => 1]
                ])->toArray();
    
                $design_name = $design ? $design[0]['design']['design_name'] : '';


              // Extract product details


        // Construct the order data
        $orderData = [
            '_id' => $new_id,
            'counter' => 1,
            'customer' => [
                'cust_id' => $request->input('cusrID'),
                'custName' => $request->input('custName'),
                'companylistcust' => $request->input('companylistcust'),
                'email' => $request->input('email'),
                'phoneno' => $request->input('phoneno'),
                'address' => $request->input('address'),
                'city' => $request->input('city'),
                'zipcode' => $request->input('zipcode'),
                'state' => $request->input('state'),
                'country' => $request->input('country'),
                'custref' => $request->input('custref'),
            ],
            'product' => [
                'prod_id' => $request->input('prodID'),
                'prodName' => $request->input('prodName'),
                'product_type' => $request->input('product_type'),
                'prod_code' => $request->input('prod_code'),
                'color_id'=>$colour_id,
                'ColourName' => $colours_name,
                'design_id'=>$design_id,
                'design_name' => $design_name, 
                
            ],
                'box_packed' =>  $request->input('isChecked'),
                'total_quantity' => $request->input('total_quantity'),
                'order_date' => $request->input('order_date'),  
                'disptach_date' => $request->input('disptach_date'), 
                'tentative_date' => $request->input('tentative_date'),     
                'quantity_in_soft' => $request->input('quantity_in_soft'), 
                'quantity_in_pieces' => $request->input('quantity_in_pieces'), 
                'ordertype' => $request->input('ordertype'), 
                'transportname' => $request->input('transportname'), 
                'trackingdetails' => $request->input('trackingdetails'), 
                // 'price' => $request->input('price'),
                // 'Billing_address' => $request->input('Billing_address'),
                // 'Delivery_address' => $request->input('Delivery_address'),
                'status' => "New",
                'order_remark' => $request->input('order_remark'),
                'dispatch_remark' => $request->input('dispatch_remark'),

            'insertedTime' => time(),
            'delete_status' => "NO",
            'deleteOrder' => "",
            'deleteTime' => "",
        ];

        dd($orderData);
        
       
    
        // Check document availability
        if ($docAvailable != "No") {
            // Parse the document ID
            $info = explode("^", $docAvailable);
            $docId = (int)$info[1];
    
            // Get a new order ID
            $orderid = AppHelper::instance()->getAdminDocumentSequence(1, NewOrder::raw(), 'order', $docId);
    
            // Set the order data
            $orderData['_id'] = $orderid;
            $orderData['counter'] = 0;
    
            // Update the existing document
            NewOrder::raw()->updateOne(
                ['companyID' => $companyId, '_id' => $docId],
                ['$push' => ['order' => $orderData]]
            );
            // dd($orderData);
    
            return response()->json(['status' => true, 'message' => 'Order added successfully'], 200);
        } else {
            // Get a new ID for the document
            $new_id = NewOrder::max('_id') + 1;
    
            // Set the order data for a new document
            $orderData['_id'] = $new_id;
            $orderData['counter'] = 0;
            $orderData['companyID'] = $companyId;
    
            // Insert a new document
           $orderData= NewOrder::raw()->insertOne([
                '_id' => $new_id,
                'counter' => 0,
                'companyID' => $companyId,
                'order' => [$orderData],
            ]);
          
    
            return response()->json(['status' => true, 'message' => 'Order added successfully'], 200);
        }
    }
    


    public function searchCustomer(Request $request)
    {
        $val = $request->value;
        $para = '^' . $val;
        $datasearch = new Regex ($para, 'i');
        $companyID=1;
        $collection =Customer::raw();
        $show =$collection ->aggregate([['$match' => ["companyID" => $companyID]],
            ['$unwind' => '$customer'],
            ['$match' => ['customer.custName' => $datasearch,'customer.delete_status' => "NO"]],
            ['$project' => [
                'customer._id' => 1,
                '_id' => 1, 
                'customer.delete_status' => 1,
                'customer.custName'=> 1,
                'customer.companylistcust'=>1,
                'customer.email' => 1,
                'customer.phoneno' => 1,
                'customer.address' => 1,
                'customer.city' => 1,
                'customer.zipcode' => 1,
                'customer.state' => 1,
                'customer.country' => 1,
                'customer.custref' => 1,
            ]],
          
    ]);

    
        $show_data = $show->toArray();
    //    dd($show_data);
       return response()->json($show_data);
        // return response()->json($show[0]['customer']);
        // return response()->json($customerList);

        // $customer = array();
        // $customerList = array();
    //     foreach ($show as $s)
    //     {
    //         $k = 0;
    //         $customer[$k] = $s['customer'];
    //         $parent = $s['_id'];
    //         $k++;
    //         foreach ($customer as $s)
    //         {
    //             $customerList[] = array("id" => $s['_id'], "custName" => $s['custName']
    //         );
    //         }

    //     }
    //    dd($customerList);
    //     echo json_encode($customerList);
    }

    public function customerdataget_single(Request $request)
{
    $bank_admin = Customer::raw();
    $id = (int)$request->customer_name;
    $companyID = 1;

    $show1 = $bank_admin->aggregate([
        ['$match' => ['companyID' => $companyID]],
        ['$unwind' => '$customer'],
        ['$match' => ['customer._id' => $id]]
    ]);

    $output = []; // Initialize output array

    foreach ($show1 as $row) {
        // Extract customer details
        $customerDetails = $row['customer'];

        // Add customer details to output array
        $output[] = [
            "customerid" => $customerDetails['_id'],
            "custName" => $customerDetails['custName'],
            "companylistcust" => $customerDetails['companylistcust'],
            "email" => $customerDetails['email'],
            "phoneno" => $customerDetails['phoneno'],
            "address" => $customerDetails['address'],
            "city" => $customerDetails['cust_Billing_address'],
            "zipcode" => $customerDetails['zipcode'],
            "state" => $customerDetails['state'],
            "country" => $customerDetails['country'],
            "custref" => $customerDetails['custref']
            //"custZip" => $customerDetails['custZip'],
            //"custTelephone" => $customerDetails['custTelephone']
        ];
    }

    // Encode output array to JSON and send response
    echo json_encode($output);
}


    
    public function getCustomer(Request $request)
    {
    $companyId = 1;
    $cust_id = (int)$request->input('cust_id');
        $customers = Customer::raw()->aggregate([
        ['$match' => ['companyID' => $companyId]],
        ['$unwind' => '$customer'],
        ['$match' => ['customer._id' => $cust_id ]],
        ['$group' => [
        '_id' => null,
        'customer' => ['$push' => [
        'custName' => '$customer.custName',
        'companylistcust' => '$customer.companylistcust',
        'email' => '$customer.email',
        'phoneno' => '$customer.phoneno',
        'address' => '$customer.address',
        'city' => '$customer.city',
        'zipcode' => '$customer.zipcode',
        'state' => '$customer.state',
        'country' => '$customer.country',
        'custref' => '$customer.custref'
       /* 'briefInformation' => '$customer.briefInformation',
        'cust_Billing_address' => '$customer.cust_Billing_address',
        'cust_Delivery_address' => '$customer.cust_Delivery_address'
        */]],
        ]],
        ['$project' => ['customer' => 1, '_id' => 0]]
        ])->toArray();
        // dd($customers);
  //  dd($customers);
    if (empty($customers)) {
    // dd($customers);
    return response()->json(['status' => false, 'message' => 'No customer found'], 404);
    }

    return response()->json(['status' => true, 'data' => $customers[0]['customer'], 'message' => 'Customer found successfully'], 200);


    }
    public function searchProduct(Request $request)
    {
    $companyId = 1;
    $product_nm = $request->input('prod_name');
    // dd($product_nm);
    $products = Product::raw()->aggregate([
    ['$match' => ['companyID' => $companyId]],
    ['$unwind' => '$product'],
    ['$match' => ['product.prodName' => new Regex("{$product_nm}", 'i')]],
    ['$group' => [
    '_id' => null,
    'products' => ['$push' => [
    'prodName' => '$product.prodName',

    ]],
    ]],
    ['$project' => ['products' => 1, '_id' => 0]],
    ])->toArray();

    if (empty($products)) {
    return response()->json(['status' => false, 'message' => 'No products found'], 404);
    }
   
    return response()->json(['status' => true, 'data' => $products[0]['products'], 'message' => 'Products found successfully'], 200);


    }
    public function getProduct(Request $request)
    {
    $companyId = 1;
    $prod_id = (int)$request->input('prod_id');
    // dd($prod_id);
    $products = Product::raw()->aggregate([
    ['$match' => ['companyID' => $companyId]],
    ['$unwind' => '$product'],
    ['$match' => ['product._id' => $prod_id]],
    ['$group' => [
    '_id' => null,
    'products' => ['$push' => [

    'prodName' => '$product.prodName',
    'product_type' => '$product.product_type',

    ]],
    ]],
    ['$project' => ['products' => 1, '_id' => 0]],
    ])->toArray();

    if (empty($products)) {
    return response()->json(['status' => false, 'message' => 'No products found'], 404);
    }

    return response()->json(['status' => true, 'data' => $products[0]['products'], 'message' => 'Products found successfully'], 200);
    }


       public function view_order(Request $request)
    {
        $companyID=1;
        $collection=NewOrder::raw();
        $processing =Processing::raw();
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
        $processCurr = $processing->aggregate([
            ['$match' => ['companyID' => $companyID]],
            ['$unwind' => '$order'],  // Unwind the order array first
            ['$match' => ['order.delete_status' => "NO"]],  // Apply filter after unwinding
            ['$sort' => ['order._id' => -1]]
        ]);
        $process_data = $processCurr->toArray();
        $order_data = $orderCurr->toArray();
        
        // dd($order_data);
        
        return view('order.view_order', compact('order_data','customers','process_data'));
        

    }
    public function edit_order(Request $request)
    {
        $parent = $request->input('master_id');
        $companyID = 1;
        $id = $request->input('id');
        $collection=NewOrder::raw();
        $show1 = $collection->aggregate([
        ['$match' => ['_id' => (int)$parent, 'companyID' => $companyID]],
        ['$unwind' => ['path' => '$order']],
        ['$match' => ['order._id' => (int)$id]]
        ])->toArray();
      
        // foreach ($show1 as $row) {
        // $activeOrder = array();
        // $k = 0;
        // $activeOrder[$k] = $row['order'];
        // $k++;
        // }
        // $orderData[]=array("order" => $activeOrder);
        // if ($orderData) {
        // return response()->json([
        // 'success' => $orderData,
        // ]);
        // } else {
        // return response()->json([
        // 'success' => 'No record'
        // ]);
        // }

        
        $activeOrder = [];
        foreach ($show1 as $row) {
            $activeOrder[] = $row['order'];
        }

        if (!empty($activeOrder)) {
            return response()->json(['success' => $activeOrder]);
        } else {
            return response()->json(['success' => 'No record']);
        }

    }
    public function update_order(Request $request)
    {
    $companyId = 1;
    $masterId = (int)$request->masterId;
    $id = (int)$request->_id;
    // dd( $id);
    $collection = NewOrder::raw();
    // Update the order inside the array
    $orderCurr=NewOrder::raw()->updateOne(['companyID' => $companyId,'order._id' => $id],

    ['$set' => [
    // 'order.$.cust_id' => $request->customer_id,
    // 'order.$.prod_id' => $request->product_id,
    'order.$.custName' => $request->customers_name,
    'order.$.prodName' => $request->products_name,
    'order.$.product_type' => $request->product_type,
    'order.$.colour_id' => $request->colour_id,
    'order.$.ColourName' => $request->colours_name,
    'order.$.design_name' => $request->design_name,
    'order.$.quantity_in_soft' => $request->quantity_in_soft,   
    'order.$.quantity_in_pieces' => $request->quantity_in_pieces,  
    'order.$.Total_qty' => $request->Total_qty,
    'order.$.Detail_inst' => $request->Detail_inst,
    // 'order.$.Billing_address' => $request->Billing_address,
    // 'order.$.Delivery_address' => $request->Delivery_address,
    'order.$.total_quantity' => $request->total_quantity,
    // 'order.$.price' => $request->price,
    'order.$.order_remark' => $request->order_remark,
    'order.$.dispatch_remark' => $request->dispatch_remark,
    'order.$.order_date' => $request->order_date,
    'order.$.disptach_date' => $request->disptach_date,
    'order.$.tentative_date' => $request->tentative_date,
    'order.$.trackingdetails' => $request->trackingdetails,
    'order.$.transportname' => $request->transportname,
    'order.$.box_packed' => $request->box_packed,
    'order.$.insertedTime' => time(),
    'order.$.delete_status' => "NO",
    'order.$.deleteOrder' => "",
    'order.$.deleteTime' => ""
    ]
    ]
    );

    // dd($request->box_packed);

    if ($orderCurr==true) {
        // dd($orderCurr);
        return response()->json(['status' => true,'message' => 'Order updated successfully'], 200);
        } else {
        return response()->json(['status' => false,'message' => 'Failed to update Product'], 500);
        }
    }
    public function delete_order(Request $request)
    {
        $id = intval($request->id);
        $companyID=1;
        $mainId=(int)$request->master_id;
        // dd($mainId);
        $orderData=NewOrder::raw()->updateOne(['companyID' =>$companyID,'_id' => $mainId,'order._id' => $id],
       
        ['$set' => [
            'order.$.insertedTime' => time(),
            'order.$.delete_status' => "YES",
            'order.$.deleteOrder' => intval($id),
            'order.$.deleteTime0' => time(),
            ]]);
        // dd($id);
        $processData=Processing::raw()->updateOne(['companyID' =>$companyID,'_id' => $mainId,'order._id' => $id],
        ['$set' => [
            'order.$.insertedTime' => time(),
            'order.$.delete_status' => "YES",
            'order.$.deleteOrder' => intval($id),
            'order.$.deleteTime0' => time(),
            ]]);

        if($orderData==true)
        {
        $arr = array('status' => 'success', 'message' => 'Order Deleted successfully.','statusCode' => 200);
        return json_encode($arr);
        } elseif($processData==true)
        {
        $parr = array('status' => 'success', 'message' => 'Order Deleted successfully From processing.','statusCode' => 200);
        return json_encode($parr);
        }
        

    }


    public function updateStatus(Request $request)
    {
        //dd($request);
        $companyID = 1;
        $id = intval($request->id);
        $oldStatus = strtolower($request->oldstatus);
        $newStatus = strtolower($request->newstatus);
        // dd($oldStatus);
    
        // Define collection map
        $collectionMap = [
            'new' => NewOrder::raw(),
            'processing' => Processing::raw(),
            'dispatch' => Dispatch::raw(),
            'completed' => Completed::raw(),
            'cancelled' => Cancelled::raw()
        ];
        // dd($id);
        // Determine old collection
        if (!isset($collectionMap[$oldStatus])) {
            return response()->json(['success' => false, 'message' => 'Invalid old status.']);
        }
        $oldCollection = $collectionMap[$oldStatus];
    
        // Aggregate to find the order
        $orderResult = NewOrder::raw()->aggregate([
            ['$match' => ['companyID' => $companyID]],
            ['$unwind' => '$order'],
            ['$match' => ['order._id' => $id]]
        ])->toArray();

        $processResult = Processing::raw()->aggregate([
            ['$match' => ['companyID' => $companyID]],
            ['$unwind' => '$order'],
            ['$match' => ['order._id' => $id]]
        ])->toArray();
    
        
        
        if (empty($orderResult) && empty($processResult)) {
            return response()->json(['success' => false, 'message' => 'Order not found.']);
        }
        
        // dd($processResult);
        
        // $order = $orderResult[0]['order'];
        // $parentid = $orderResult[0]['_id'];
        // $proorder = $processResult[0]['order'];
        // $proParentId  = $processResult[0]['_id'];

        dd($processResult);


        // If $orderResult is not empty, extract values
        if (!empty($orderResult)) {
            $order = $orderResult[0]['order'];
            $parentid = $orderResult[0]['_id'];
            
        }

        // If $processResult is not empty, extract values
        if (!empty($processResult)) {
            $proorder = $processResult[0]['order'];
            $proParentId = $processResult[0]['_id'];

            // You can now safely use $proorder and $proParentId here
           
        }
        
    
        // Update the order status and time
        $statusTimes = [
            'new' => 'status_New_time',
            'processing' => 'status_Processing_time',
            'dispatch' => 'status_dispatch_time',
            'completed' => 'status_Completed_time',
            'cancelled' => 'status_Cancelled_time'
        ];
    
        $order['status'] = $newStatus;
        
        if (isset($statusTimes[$newStatus])) {
            $order[$statusTimes[$newStatus]] = time();
        }
    
        // Determine new collection
        if (!isset($collectionMap[$newStatus])) {
            return response()->json(['success' => false, 'message' => 'Invalid new status.']);
        }
        $newCollection = $collectionMap[$newStatus];
    
        // Check if document is available in the new collection
        $docAvailable = AppHelper::instance()->checkDoc($newCollection, $companyID, 7000);
    
        if ($docAvailable != "No") {
            $info = explode("^", $docAvailable);
            $docId = (int)$info[1];
            $pushResult = $newCollection->updateOne(
                ['companyID' => $companyID, '_id' => $docId],
                ['$push' => ['order' => $order]]
            );
        } else {
            $parentId = AppHelper::instance()->getNextSequenceForNewDoc($newCollection);
            //dd($parentId);
            $newDoc = [
                "_id" => $parentId,
                "counter" => 1,
                "companyID" => $companyID,
                "order" => [$order]
            ];
            $pushResult = $newCollection->insertOne($newDoc);
        }
        
        if (isset($pushResult) && $pushResult->getMatchedCount() > 0) {
            $pullResult = $oldCollection->updateOne(
                ['companyID' => $companyID, '_id' => $parentid],
                ['$pull' => ['order' => ['_id' => $id]]]
            );
    
            if ($pullResult->getMatchedCount() > 0) {
               echo "<script>";
               echo "alert('Status changed successfully.');";
               echo 'window.location.href = "' . url("order") . '";';
               echo "</script>";
            } else {
                echo "<script>";
                echo "alert('Order moved but not removed from the old collection.');";
                echo 'window.location.href = "' . url("order") . '";';
                echo "</script>";
                //return response()->json(['success' => false, 'message' => 'Order moved but not removed from the old collection.']);
            }
        } else {
            echo "<script>";
            echo "alert('Failed to move the order to the new collection.');";
            echo 'window.location.href = "' . url("order") . '";';
            echo "</script>";
            //return response()->json(['success' => false, 'message' => 'Failed to move the order to the new collection.']);
        }

    }
    public function showCustomers()
    {
        $companyID=1;
        $collection=Customer::raw();
        $customerCurr = Customer::raw()->aggregate([
            ['$match' => ['companyID' => $companyID]],
            ['$unwind' => '$customer'],
            ['$match' => ['customer.delete_status' =>"NO"]],
            ['$project' => [
                'customer._id' => 1,
                'customer.custName' => 1,
            ]],
             ]);
             
            //  $order_data = $orderCurr->toArray();
            $customer_data = $customerCurr->toArray();
            //dd( $customer_data);
        //  $customerCurr = Customer::all();
        
            //$customer_data = iterator_to_array($customerCurr);
           
            return view('order.view_order',compact('customer_data'));
        }
       // $cusdata= Customer::all(); // Retrieve all customer data
        //return view('order.view_order', compact('cusdata'));
        // Pass customer data to the view


        public function searchcustomerdata(Request $request){
            $customers = Customer::raw()->aggregate([
                ['$unwind' => '$customer'],
                ['$match' => ['customer.delete_status'=>'NO']],
                ])->toArray();
    
            // $customers_name = $customers ? $customers[0]['customer']['custName'] : '';
            // dd($customers);
            return response()->json($customers);
        }

    

        public function searchproductdata(Request $request){
            $products = Product::raw()->aggregate([
                ['$unwind' => '$product'],
                ['$match' => ['product.delete_status'=>'NO']],
                ])->toArray();
    
            // $customers_name = $customers ? $customers[0]['customer']['custName'] : '';
            // dd($products);
            return response()->json($products);
        }

        public function addnewStatus(Request $request) {
            

            $maxLength = 2000;
            $new_id = New_notes::max('_id') + 1;
            $companyId =1;
            $docAvailable = AppHelper::instance()->checkDoc(New_notes::raw(),$companyId,$maxLength);
            // dd($docAvailable);
            $cons = [
            '_id' => $new_id,
            'counter' => 1,
            'orderid'=>  $request->input('orderid'),
            'status' => $request->input('status'),
            'delivery_date' => $request->input('delivery_date'),
            'time' => $request->input('time'),
            'note' => $request->input('note'),
            'insertedTime' => time(),
            'delete_status' => "NO",
            'deletestatus' => "",
            'deleteTime' => "",
            ];
            // dd($cons);
            if ($docAvailable != null)
            {
                $info = (explode("^",$docAvailable));
                $docId = $info[1];
                // dd($docId);
                $counter = $info[0];
                $companyid = AppHelper::instance()->getAdminDocumentSequence(1, New_notes::raw(),'order',(int)$docId);
                // dd($companyid);
                $data = array(
                '_id' => $companyid,
                'counter' => 0,
                'oldstatus' => $request->input('addoldStatus'),
                'status' => $request->input('status'),
                'delivery_date' => $request->input('delivery_date'),
                'time' => $request->input('time'),
                'note' => $request->input('note'),
                'orderid' => $request->input('orderid'),
                'insertedTime' => time(),
                'delete_status' => "NO",
                'deleteCompany' => "",
                'deleteTime' => "",
                );
                // dd($data);
                New_notes::raw()->updateOne(['companyID' => $companyId,'_id' => (int)$docId], ['$push' => ['order' => $data]]);
                //dd($cons_data);
                echo json_encode($data);
            }
            else
            {

                $count_data=New_notes::all();;
                $count=count($count_data);
                $ids=array();
                if($count !=0)
                {
                foreach($count_data as $row)
                {
                $ids[]=$row->_id;
                }
                $id=max($ids);
                }
                else
                {
                $id=0;
                }
                $data=array(
                '_id'=>$id+1,
                'counter'=>0,
                "companyID"=>$companyId,
                'new_notes'=>array($cons),
                );
                New_notes::raw()->insertOne($data);
            }
            $completedata[] = $data;
            echo json_encode($completedata);

            return response()->json(['status' => true, 'message' => 'Satatus added successfully'], 200);

        }



            public function get_designlist(Request $request){
                // $colors = Color::all()->toArray();
                $productName = $request->product;
                $searchTerm = $request->input('searchTerm');
        
                // $designs = Product::raw()->aggregate([
                //     ['$unwind' => '$product'],
                //     ['$match' => ['product.designname.delete_status'=>'NO']],
                //     ])->toArray();
                $designs = Product::raw(function($collection) use ($productName) {
                    return $collection->aggregate([
                        ['$unwind' => '$product'],
                        ['$match' => ['product.prodName' => $productName]],
                        ['$match' => ['product.designname' => ['$exists' => true]]], // Filter out documents without designname
                        ['$match' => ['product.designname.delete_status' => 'NO']],
                        ['$project' => [
                            'designname' => '$product.designname'
                        ]]
                    ]);
                });

            
                // dd($designs);
                return response()->json($designs);
            }


            public function fetchColorsNames(Request $request){
                // $colors = Color::all()->toArray();
                $searchTerm = $request->input('searchTerm');
        
                $colour = Color::raw()->aggregate([
                    ['$unwind' => '$color'],
                    ['$match' => ['color.delete_status'=>'NO']],
                    ])->toArray();
                // Fetch color names from the database based on the search term
                // $colors =  $colors = Color::where('_id')->get();
                // dd($colour);
        
                return response()->json($colour);
            }


    }

        
     


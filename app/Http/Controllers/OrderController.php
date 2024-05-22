<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
// use App\Models\User;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Colour;
use App\Helpers\AppHelper;
use App\Models\API\Login_History;
use MongoDB\BSON\Regex;
use Auth;
use PDF;
use DB;
use Illuminate\Validation\Rule;
use Validator;

class OrderController extends Controller
{
    public function addOrder(Request $request)
    {
        //dd($request);
        $maxLength = 2000;
        $new_id = Order::max('_id') + 1;
        $randomNumber = rand(100000, 999999);
        $unique_value = $randomNumber . $new_id;
        $companyId = 1;
        $docAvailable = AppHelper::instance()->checkDoc(Order::raw(), $companyId, $maxLength);
    
        // Construct the order data
        $orderData = [
            '_id' => $new_id,
            'counter' => 1,
            'customer' => [
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
                'prodName' => $request->input('prodName'),
                'product_type' => $request->input('product_type'),
                'prod_code' => $request->input('prod_code'),
                'prod_qty' => $request->input('prod_qty'),
                'Thickness' => $request->input('Thickness'),
                'Width' => $request->input('Width'),
                'Roll_weight' => $request->input('Roll_weight'),
                'ColourName' => $request->input('ColourName'),
                
            ],
            'total_quantity' => $request->input('total_quantity'),
                'price' => $request->input('price'),
                'Billing_address' => $request->input('Billing_address'),
                'Delivery_address' => $request->input('Delivery_address'),
                'price_type' => $request->input('price_type'),
                'status' => "New",
                'notes' => $request->input('notes'),
            'insertedTime' => time(),
            'delete_status' => "NO",
            'deleteOrder' => "",
            'deleteTime' => "",
        ];
        //dd($orderData);
    
        // Check document availability
        if ($docAvailable != "No") {
            // Parse the document ID
            $info = explode("^", $docAvailable);
            $docId = (int)$info[1];
    
            // Get a new order ID
            $orderid = AppHelper::instance()->getAdminDocumentSequence(1, Order::raw(), 'order', $docId);
    
            // Set the order data
            $orderData['_id'] = $orderid;
            $orderData['counter'] = 0;
    
            // Update the existing document
            Order::raw()->updateOne(
                ['companyID' => $companyId, '_id' => $docId],
                ['$push' => ['order' => $orderData]]
            );
    
            return response()->json(['status' => true, 'message' => 'Order added successfully'], 200);
        } else {
            // Get a new ID for the document
            $new_id = Order::max('_id') + 1;
    
            // Set the order data for a new document
            $orderData['_id'] = $new_id;
            $orderData['counter'] = 0;
            $orderData['companyID'] = $companyId;
    
            // Insert a new document
           $orderData= Order::raw()->insertOne([
                '_id' => $new_id,
                'counter' => 0,
                'companyID' => $companyId,
                'order' => [$orderData],
            ]);
          // dd($orderData);
    
            return response()->json(['status' => true, 'message' => 'Order added successfully'], 200);
        }
    }
    


    public function searchCustomer(Request $request)
    {
        $val = $request->value;
        $para = '^' . $val;
        $datasearch = new Regex ($para, 'i');
        $companyID=1;
        $show = \App\Models\Customer::raw()->aggregate([['$match' => ["companyID" => $companyID]],
            ['$unwind' => '$customer'],
            ['$match' => ['customer.custName' => $datasearch,'customer.delete_status' => "NO"]],
            ['$project' => ['customer._id' => 1,'_id' => 1, 'customer.delete_status' => 1,'customer.custName'=> 1,'customer.companylistcust'=>1,
            'customer.email' => 1,'customer.phoneno' => 1,'customer.address' => 1,'customer.city' => 1,
            'customer.zipcode' => 1,'customer.state' => 1,'customer.country' => 1,'customer.custref' => 1,
            ]],
            // ['$limit' => 100]
        ]);
        $customer = array();
        $customerList = array();
        foreach ($show as $s)
        {
            $k = 0;
            $customer[$k] = $s['customer'];
            $parent = $s['_id'];
            $k++;
            foreach ($customer as $s)
            {
                $customerList[] = array("id" => $s['_id'], "custName" => $s['custName']
            );
            }

        }
      //  dd($customerList);
        echo json_encode($customerList);
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
    ['$match' => ['product.prodName' => new \MongoDB\BSON\Regex("{$product_nm}", 'i')]],
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
    'Thickness' => '$product.Thickness',
    'Width' => '$product.Width',
    'ColourName' => '$product.ColourName',
    'Roll_weight' => '$product.Roll_weight',
    ]],
    ]],
    ['$project' => ['products' => 1, '_id' => 0]],
    ])->toArray();

    if (empty($products)) {
    return response()->json(['status' => false, 'message' => 'No products found'], 404);
    }

    return response()->json(['status' => true, 'data' => $products[0]['products'], 'message' => 'Products found successfully'], 200);
    }


    public function searchColour(Request $request)
    {
    $companyId = 1;
    $colour_nm = $request->input('colour_name');

    $colours = Colour::raw()->aggregate([
    ['$match' => ['companyID' => $companyId]],
    ['$unwind' => '$colour'],
    ['$match' => ['colour.ColourName' => new \MongoDB\BSON\Regex("{$colour_nm}", 'i')]],
    ['$group' => [
    '_id' => null,
    'colours' => ['$push' => [
    'ColourName' => '$colour.ColourName',

    // Add other colour fields you want to include here
    ]],
    ]],
    ['$project' => ['colours' => 1, '_id' => 0]],
    ])->toArray();

    if (empty($colours)) {
    return response()->json(['status' => false, 'message' => 'No colour found'], 404);
    }

    return response()->json([
    'status' => true,
    'data' => $colours[0]['colours'],
    'message' => 'Colours found successfully'
    ], 200);
    }
    public function getColour(Request $request)
    {
    $companyId = 1;
    $colour_id = (int)$request->input('colour_id');

    $colours = Colour::raw()->aggregate([
    ['$match' => ['companyID' => $companyId]],
    ['$unwind' => '$colour'],
    ['$match' => ['colour._id' => $colour_id]],
    ['$group' => [
    '_id' => null,
    'colours' => ['$push' => [
    'ColourName' => '$colour.ColourName',

    // Add other colour fields you want to include here
    ]],
    ]],
    ['$project' => ['colours' => 1, '_id' => 0]],
    ])->toArray();

    if (empty($colours)) {
    return response()->json(['status' => false, 'message' => 'No colour found'], 404);
    }

    return response()->json([
    'status' => true,
    'data' => $colours[0]['colours'],
    'message' => 'Colours found successfully'
    ], 200);
    }

       public function view_order(Request $request)
    {
        $companyID=1;
        $collection=Order::raw();
        $orderCurr= $collection->aggregate([
        ['$match' => ['companyID' => $companyID]],
        ['$unwind' => '$order'],
        ['$match' => ['order.delete_status' =>"NO"]],
        ['$project' => [
            'customer._id' => 1,
            'customer.custName' => 1,
            'customer.companylistcust' => 1,
            'customer.email' => 1,
            'customer.phoneno' => 1,
            'customer.address' => 1,
            'customer.city' => 1,
            'customer.zipcode' => 1,
            'customer.state' => 1,
            'customer.country' => 1,
            'customer.custref' => 1,
            'product.prodName' => 1,
            'product.product_type' => 1,
            'product.prod_code' => 1,
            'product.prod_qty' => 1,
            'product.Thickness' => 1,
            'product.Width' => 1,
            'product.Roll_weight' => 1,
            'product.ColourName' => 1,
            'total_quantity' => 1,
            'price' => 1,
            'Billing_address' => 1,
            'Delivery_address' => 1,
            'price_type' => 1,
            'status' => 1,
            'notes' => 1,
           
        ]]


        ]);

        $order_data = $orderCurr->toArray();

        return view('order.view_order',compact('order_data'));

    }
    public function edit_order(Request $request)
    {
    $parent=$request->comId;
    $companyID=1;
    $id=$request->id;
    $collection=\App\Models\Order::raw();
    $show1 = $collection->aggregate([
    ['$match' => ['_id' => (int)$parent, 'companyID' => 1]],
    ['$unwind' => ['path' => '$order']],
    ['$match' => ['order._id' => (int)$id]]
    ]);
    foreach ($show1 as $row) {
    $activeOrder = array();
    $k = 0;
    $activeOrder[$k] = $row['order'];
    $k++;
    }
    $orderData[]=array("order" => $activeOrder);
    if ($orderData) {
    return response()->json([
    'success' => $orderData,
    ]);
    } else {
    return response()->json([
    'success' => 'No record'
    ]);
    }

    }
    public function update_order(Request $request)
    {
    $companyId = 1;
    $masterId = (int)$request->masterId;
    $id = (int)$request->id;
    $collection = \App\Models\Order::raw();
    // Update the order inside the array
    $orderCurr=Order::raw()->updateOne(['companyID' => $companyId,'_id' => $masterId,'order._id' => $id],

    ['$set' => [
    'order.$.cust_id' => $request->customer_id,
    'order.$.prod_id' => $request->product_id,
    'order.$.custName' => $request->customers_name,
    'order.$.prodName' => $request->products_name,
    'order.$.product_type' => $request->product_type,
    'order.$.Thickness' => $request->Thickness,
    'order.$.Width' => $request->Width,
    'order.$.colour_id' => $request->colour_id,
    'order.$.ColourName' => $request->colours_name,
    'order.$.Roll_weight' => $request->Roll_weight,
    //'order.$.Total_qty' => $request->Total_qty,
    //'order.$.Detail_inst' => $request->Detail_inst,
    //'order.$.Billing_address' => $request->Billing_address,
   // 'order.$.Delivery_address' => $request->Delivery_address,
    //'order.$.Typeof_price' => $request->Typeof_price,
    'order.$.insertedTime' => time(),
    'order.$.delete_status' => "NO",
    'order.$.deleteOrder' => "",
    'order.$.deleteTime' => ""
    ]
    ]
    );

    if ($orderCurr->getModifiedCount() == 0) {
    return response()->json(['status' => false, 'message' => 'Order not found or not updated'], 404);
    }

    return response()->json(['status' => true, 'message' => 'Order updated successfully'], 200);
    }

    public function delete_order(Request $request)
    {
    $id = intval($request->id);
    //dd($id);
    $companyID=1;
    $mainId=(int)$request->docid;
    $orderData=Order::raw()->updateOne(['companyID' =>$companyID,'_id' => $mainId,'order._id' => (int)$id],
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
    }

    }
    
}
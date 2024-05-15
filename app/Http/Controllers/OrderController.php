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
    public function searchCustomer(Request $request)
    {
        $val = $request->value;
        $para = '^' . $val;
        $datasearch = new Regex ($para, 'i');
        $companyID=1;
        $show = \App\Models\Customer::raw()->aggregate([['$match' => ["companyID" => $companyID]],
            ['$unwind' => '$customer'],
            ['$match' => ['customer.custName' => $datasearch,'customer.delete_status' => "NO"]],
            ['$project' => ['customer._id' => 1,'_id' => 1, 'customer.delete_status' => 1,'customer.custName'=> 1,'customer.factoryCode'=>1,
            'customer.GstDetails' => 1,'customer.custEmail' => 1,'customer.custAddress' => 1,'customer.cust_Billing_address' => 1,
            'customer.cust_Delivery_address' => 1,'customer.custCity' => 1,'customer.custState' => 1,'customer.custCountry' => 1,
            'customer.custZip' => 1,'customer.custTelephone' => 1]],
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
        // dd($customerList);
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
            "customer_name" => $customerDetails['custName'],
            "factoryCode" => $customerDetails['factoryCode'],
            "GstDetails" => $customerDetails['GstDetails'],
            "custEmail" => $customerDetails['custEmail'],
            "custAddress" => $customerDetails['custAddress'],
            "cust_Billing_address" => $customerDetails['cust_Billing_address'],
            "cust_Delivery_address" => $customerDetails['cust_Delivery_address'],
            "custCity" => $customerDetails['custCity'],
            "custState" => $customerDetails['custState'],
            "custCountry" => $customerDetails['custCountry'],
            "custZip" => $customerDetails['custZip'],
            "custTelephone" => $customerDetails['custTelephone']
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
        'custEmail' => '$customer.custEmail',
        'factoryCode' => '$customer.factoryCode',
        'GstDetails' => '$customer.GstDetails',
        'custTelephone' => '$customer.custTelephone',
        'custAddress' => '$customer.custAddress',
        'custCountry' => '$customer.custCountry',
        'custState' => '$customer.custState',
        'custCity' => '$customer.custCity',
        'custZip' => '$customer.custZip',
        'briefInformation' => '$customer.briefInformation',
        'cust_Billing_address' => '$customer.cust_Billing_address',
        'cust_Delivery_address' => '$customer.cust_Delivery_address'
        ]],
    ]],
    ['$project' => ['customer' => 1, '_id' => 0]]
    ])->toArray();
    // dd($customers);
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

    public function addOrder(Request $request)
    {
    // dd($request);
    $maxLength = 2000;
    $new_id = Order::max('_id') + 1;
    $companyId = 1;

    $docAvailable = AppHelper::instance()->checkDoc(Order::raw(), $companyId, $maxLength);



    $orderData = [
    '_id' => $new_id,
    'counter' => 1,
    // 'cust_id' => $request->input('customer_id'),
    'custName' => $request->input('custName'),
    'factoryCode' => $request->input('factoryCode'),
    'GstDetails' => $request->input('GstDetails'),
    'custEmail' => $request->input('custEmail'),
    'custAddress' => $request->input('custAddress'),
    'cust_Billing_address' => $request->input('cust_Billing_address'),
    'cust_Delivery_address' => $request->input('cust_Delivery_address'),
    'custCity' => $request->input('custCity'),
    'custState' => $request->input('custState'),
    'custCountry' => $request->input('custCountry'),
    'custZip' => $request->input('custZip'),
    'custTelephone' => $request->input('custTelephone'),
    'briefInformation' => $request->input('briefInformation'),
    //'prod_id' => $request->input('product_id'),
    'prodName' => $request->input('prodName'),
    'product_type' => $request->input('product_type'),
    // 'prod_code' => $request->input('prod_code'),
    'Thickness' => $request->input('Thickness'),
    'Width' => $request->input('Width'),
    // 'colour_id' => $request->input('colour_id'),
    'ColourName' => $request->input('ColourName'),
    'Roll_weight' => $request->input('Roll_weight'),
    'Status'=>"New",
    'Total_qty' => $request->input('Total_qty'),
    'Detail_inst' => $request->input('Detail_inst'),
    'Billing_address' => $request->input('Billing_address'),
    'Delivery_address' => $request->input('Delivery_address'),
    'Typeof_price' => $request->input('Typeof_price'),
    'insertedTime' => time(),
    'delete_status' => "NO",
    'deleteOrder' => "",
    'deleteTime' => "",
    ];
    //dd($orderData);
    if ($docAvailable != "No") {
    $info = explode("^", $docAvailable);
    $docId = $info[1];
    $orderid = AppHelper::instance()->getAdminDocumentSequence(1, Order::raw(), 'order', (int)$docId);

    $orderData['_id'] = $orderid;
    $orderData['counter'] = 0;

    Order::raw()->updateOne(
    ['companyID' => $companyId, '_id' => (int)$docId],
    ['$push' => ['order' => $orderData]]
    );

    return response()->json(['status' => true, 'message' => 'Order added successfully'], 200);
    } else {
    $orderData['_id'] = $new_id;
    $orderData['counter'] = 0;
    $orderData['companyID'] = $companyId;

    Order::raw()->insertOne([
    '_id' => $new_id,
    'counter' => 0,
    'companyID' => $companyId,
    'order' => [$orderData],
    ]);

    return response()->json(['status' => true, 'message' => 'Order added successfully'], 200);
    }
    }
    public function view_order(Request $request)
    {
        $companyID=1;
        $collection=\App\Models\Order::raw();
        $orderCurr= $collection->aggregate([
        ['$match' => ['companyID' => $companyID]],
        ['$unwind' => '$order'],
        ['$match' => ['order.delete_status' =>"NO"]]


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
    'order.$.Total_qty' => $request->Total_qty,
    'order.$.Detail_inst' => $request->Detail_inst,
    'order.$.Billing_address' => $request->Billing_address,
    'order.$.Delivery_address' => $request->Delivery_address,
    'order.$.Typeof_price' => $request->Typeof_price,
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
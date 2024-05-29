<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Customer;
use File;
use Image;
use MongoDB\BSON\ObjectId;
use Auth;
use PDF;
use Carbon\Carbon;
use App\Helpers\AppHelper;
use MongoDB\BSON\Regex;
use Illuminate\Database\Eloquent\Collection;

class CustomerController extends Controller
{
    public function add_customer(Request $request)
{
    $maxLength = 2000;
    $new_id = Customer::max('_id') + 1;
    $randomNumber = rand(100000, 999999);
    $unique_value = $randomNumber . $new_id;
    $companyId = 1;
    $docAvailable = AppHelper::instance()->checkDoc(Customer::raw(), $companyId, $maxLength);
    $company_id = (int)$request->input('company_id');

    // Fetching company name based on company_id
    $company = Company::raw()->aggregate([
        ['$match' => ['companyID' => $companyId]],
        ['$unwind' => '$company'],
        ['$match' => ['company._id' => $company_id]],
        ['$limit' => 1]
    ])->toArray();

    //$companylistcust = !empty($company) ? $company[0]['company']['companylistcust'] : '';

    $cons = [
        '_id' => $new_id,
        'counter' => 1,
        'custName' => $request->input('custName'),
        'companylistcust' => $request->input('companylistcust'),  // Assuming 'companylistcust' is equivalent to 'companyName'
        'email' => $request->input('email'),
        'phoneno' => $request->input('phoneno'),
        'address' => $request->input('address'),
        'city' => $request->input('city'),
        'zipcode' => $request->input('zipcode'),
        'state' => $request->input('state'),
        'country' => $request->input('country'),
        'custref' => $request->input('custref'),
        'insertedTime' => time(),
        'delete_status' => "NO",
        'deleteCustomer' => "",
        'deleteTime' => "",
    ];

    if ($docAvailable != "No") {
        $info = explode("^", $docAvailable);
        $docId = (int)$info[1];
        $counter = (int)$info[0];

        $customerid = AppHelper::instance()->getAdminDocumentSequence(1, Customer::raw(), 'customer', $docId);

        $cons_data = array_merge($cons, [
            '_id' => $customerid,
            'counter' => 0,
        ]);

        Customer::raw()->updateOne(
            ['companyID' => $companyId, '_id' => $docId],
            ['$push' => ['customer' => $cons_data]]
        );

        echo json_encode($cons_data);
    } else {
        $count_data = Customer::all();
        $count = count($count_data);
        $ids = [];

        if ($count != 0) {
            foreach ($count_data as $row) {
                $ids[] = $row->_id;
            }
            $id = max($ids);
        } else {
            $id = 0;
        }

        $data = [
            '_id' => $id + 1,
            'counter' => 0,
            "companyID" => $companyId,
            'customer' => [$cons],
        ];

        Customer::raw()->insertOne($data);

        echo json_encode($data);
    }
}

        public function view_customer()
        {
           // dd($request);
            $companyID=1;
            $collection=Customer::raw();
            $customerCurr= $collection->aggregate([
            ['$match' => ['companyID' => $companyID]],
            ['$unwind' => '$customer'],
            ['$match' => ['customer.delete_status' =>"NO"]],
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
                //'customer.website' => 1,
            ]],
             ]);
             
            $customer_data = $customerCurr->toArray();
            //dd( $customer_data);
        //  $customerCurr = Customer::all();
        
            //$customer_data = iterator_to_array($customerCurr);
           
            return view('Customer.view_customer',compact('customer_data'));
        }

        // public function edit_user(Request $request)
        // {
        //     $id = intval($request->id);
        //     $UserData = Company::where('_id', $id)->where('delete_status', 'NO')->first();
        //     echo json_encode($UserData);
        // }
        public function edit_customer(Request $request)
        {
            $companyID=1;
            $parent=$request->master_id;
            $id=$request->id;
            $collection=Customer::raw();
            $show1 = $collection->aggregate([
            ['$match' => ['_id' => (int)$parent, 'companyID' => 1]],
            ['$unwind' => ['path' => '$customer']],
            ['$match' => ['customer._id' => (int)$id]]
            ]);
            //dd($show1);
            foreach ($show1 as $row) {
            $activeCust= array();
            $k = 0;
            $activeCust[$k] = $row['customer'];
            $k++;

            }

            $companyData[]=array("customer" => $activeCust);
            // dd($companyData);
            if ($companyData) {
            // dd($companyData);
            return response()->json(['success' => $companyData]);
            //dd($companyData);
            }
        }

        public function update_customer(Request $request)
        {
        // dd($request);
            $id=(int)$request->_id;
            $companyID=1;

            $data=Customer::raw()->updateOne(['companyID' => $companyID,'customer._id' => $id],

            ['$set' => [

            'customer.$.custName' => $request->custName,
            'customer.$.companylistcust' => $request->companylistcust,
            'customer.$.email' => $request->email,
            'customer.$.phoneno' => $request->phoneno,
            'customer.$.address' => $request->address,
            'customer.$.city' => $request->city,
            'customer.$.zipcode' => $request->zipcode,
            'customer.$.state' => $request->state,
            'customer.$.country' => $request->country,
            'customer.$.custref' => $request->custref,
            /*'customer.$.custCountry' => $request->custCountry,
            'customer.$.custZip' => $request->custZip,
            'customer.$.custTelephone' => $request->custTelephone,
            'customer.$.briefInformation' => $request->briefInformation,
            */'customer.$.insertedTime' => time(),
            'customer.$.delete_status' => "NO",
            'customer.$.deletecustomer' => "",
            'customer.$.deleteTime' => "",]]
            
            );

            if ($data==true) {
            //dd($data);
            return response()->json(['status' => true,'message' => 'Record updated successfully'], 200);
            } else {
            return response()->json(['status' => false,'message' => 'Failed to update Company'], 200);
            }

        }
        public function delete_customer(Request $request)
        {
            $id = intval($request->id);
            $companyID=1;
            $mainId=(int)$request->master_id;
            // dd($request);
            $prodData=Customer::raw()->updateOne(['companyID' =>$companyID,'_id' => $mainId,'customer._id' => (int)$id],
            ['$set' => [
                'customer.$.insertedTime' => time(),
                'customer.$.delete_status' => "YES",
                'customer.$.deletecustomer' => intval($id),
                'customer.$.deleteTime0' => time(),
            ]]);
            if($prodData==true)
            {
                $arr = array('status' => 'success', 'message' => 'Record Deleted successfully.','statusCode' => 200);
                return json_encode($arr);
            }

        }

       /* public function get_companylist(Request $request)
        {
            $val = $request->value;
            $para = '^' . $val;
            $datasearch = new Regex ($para, 'i');
            // dd($datasearch);
            $companyID=1;
            $show = \App\Models\Company::raw()->aggregate([['$match' => ["companyID" => $companyID]],
                ['$unwind' => '$company'],
                ['$match' => ['company.companyName' => $datasearch,'company.delete_status' => "NO"]],
                ['$project' => ['company._id' => 1,'_id' => 1, 'company.companyName' => 1,'company.deleteStatus'=>1]],
            ]);
            $company = array();
            $companyList = array();
            foreach ($show as $s)
            {
                // dd($s);
                $k = 0;
                $company[$k] = $s['company'];
                $parent = $s['_id'];
                $k++;
                foreach ($company as $sr)
                {
                    $companyList[] = array("id" =>$sr['_id'], "value" => $sr['companyName'],"parent" => $parent);
                }
    
            }
            // dd($companyList);
            echo json_encode($companyList);
        }*/
        public function view_company()
        {
            $companyID=1;
            $collection=Company::raw();
            $companyCurr= $collection->aggregate([
            ['$match' => ['companyID' => $companyID]],
            ['$unwind' => '$company'],
            ['$match' => ['company.delete_status' =>"NO"]],
            ['$project' => [
                'company._id' => 1,
                'company.company_name' => 1,
                'company.ccode' => 1,
                'company.caddress'=>1,
                'company.city' => 1,
                'company.zipcode' => 1,
                'company.state' => 1,
                'company.country' => 1,
                'company.taxgstno' => 1,
                'company.phoneno' => 1,
                'company.email' => 1,
                'company.website' => 1,
                //'customer.website' => 1,
            ]],
            ]);
            // Check if company are found

          // $companyCurr = Company::all();
             //dd($companyCurr);
           // $companyData = iterator_to_array($companyCurr);
          
           $companyData= $companyCurr->toArray();
            //dd($companyData);
           
            return view('Company.view_company',compact('companyData'));
            
        }

}

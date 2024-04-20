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

        //dd($request);
        $maxLength = 2000;
        $new_id = Customer::max('_id') + 1;
        $randomNumber = rand(100000, 999999); // You can adjust the range as needed
        $unique_value = $randomNumber . $new_id;
        $companyId =1;
        $docAvailable = AppHelper::instance()->checkDoc(Customer::raw(),$companyId,$maxLength);
        // dd($docAvailable);
        $company_id = (int)$request->input('company_id');

        // Fetching company name based on company_id
        $company = Company::raw()->aggregate([
        ['$match' => ['companyID' => $companyId]],
        ['$unwind' => '$company'],
        ['$match' => ['company._id' => $company_id]],
        ['$limit' => 1]
        ])->toArray();

        $company_name = $company ? $company[0]['company']['companyName'] : '';
        $cons = [
        '_id' => $new_id,
        'counter' => 1,
        'custName' => $request->input('custName'),
        'company_id'=>$company_id,
        'companyName' => $company_name,
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
        // 'SalesRep' => $request->input('SalesRep'),
        'insertedTime' => time(),
        'delete_status' => "NO",
        'deleteCustomer' => "",
        'deleteTime' => "",
        ];
        //dd($cons);
        if ($docAvailable != "No")
        {
            $info = (explode("^",$docAvailable));
            $docId = $info[1];
            // dd($docId);
            $counter = $info[0];
            $customerid = AppHelper::instance()->getAdminDocumentSequence(1, Customer::raw(),'customer',(int)$docId);
            // dd($customerid);
            $cons_data = array(
            '_id' => $customerid,
            'counter' => 0,
            'custName' => $request->input('custName'),
            'company_id'=>$company_id,
            'companyName' => $company_name,
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
            // 'SalesRep' => $request->input('SalesRep'),
            'insertedTime' => time(),
            'delete_status' => "NO",
            'deleteCustomer' => "",
            'deleteTime' => "",
            );
            // dd($cons_data);
            Customer::raw()->updateOne(['companyID' => $companyId,'_id' => (int)$docId], ['$push' => ['customer' => $cons_data]]);
            //dd($cons_data);
            echo json_encode($cons_data);
        }
        else
        {

            $count_data=Customer::all();;
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
            'customer'=>array($cons),
            );
            Customer::raw()->insertOne($data);
        }
        echo json_encode($data);

        // dd($data);
        // if (!empty($data)) {
        //      return response()->json([ 'status' => true,'message' => 'Company added successfully'], 200);
        // } else {
        //     return response()->json(['status' => false,'message' => 'Failed to Add Company'], 200);
        // }


    }
        public function view_customer(Request $request)
        {
            $companyID=1;
            $collection=\App\Models\Customer::raw();
            $customerCurr= $collection->aggregate([
            ['$match' => ['companyID' => $companyID]],
            ['$unwind' => '$customer'],
            ['$match' => ['customer.delete_status' =>"NO"]]
             ]);
            $customer_data = $customerCurr->toArray();

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
            $collection=\App\Models\Customer::raw();
            $show1 = $collection->aggregate([
            ['$match' => ['_id' => (int)$parent, 'companyID' => 1]],
            ['$unwind' => ['path' => '$customer']],
            ['$match' => ['customer._id' => (int)$id]]
            ]);
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
            }
        }

        public function update_company(Request $request)
        {
        //dd($request);
            $id=(int)$request->_id;
            $companyID=1;

            $data=Company::raw()->updateOne(['companyID' => $companyID,'company._id' => $id],

            ['$set' => [

            'company.$.companyName' => $request->company_name,
            'company.$.insertedTime' => time(),
            'company.$.delete_status' => "NO",
            'company.$.deleteCompany' => "",
            'company.$.deleteTime' => "",]]
            );

            if ($data==true) {
            //dd($data);
            return response()->json(['status' => true,'message' => 'Company updated successfully'], 200);
            } else {
            return response()->json(['status' => false,'message' => 'Failed to update Company'], 200);
            }

        }
        public function get_companylist(Request $request)
        {
    
            $val = $request->value;
            $para = '^' . $val;
            $datasearch = new Regex ($para, 'i');
            $companyID=1;
            $show = \App\Models\Company::raw()->aggregate([['$match' => ["companyID" => $companyID]],
                ['$unwind' => '$company'],
                ['$match' => ['company.companyName' => $datasearch,'company.deleteStatus' => "NO"]],
                ['$project' => ['company._id' => 1,'_id' => 1, 'company.companyName' => 1,'company.deleteStatus'=>1,'companyID' => (int)$companyID]],
                // ['$limit' => 100]
            ]);
            $company = array();
            $companyList = array();
            foreach ($show as $s)
            {
                dd($s);
                $k = 0;
                $company[$k] = $s['company'];
                $parent = $s['_id'];
                $k++;
                foreach ($company as $sr)
                {
                    $companyList[] = array("id" =>$sr['_id'], "value" => $sr['companyName'],"delstatus"=>$sr['deleteStatus'], "parent" => $parent);
                }
    
            }
            // dd($companyList);
            echo json_encode($companyList);
        }

}

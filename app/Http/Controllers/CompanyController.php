<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use File;
use Image;
use MongoDB\BSON\ObjectId;
use Auth;
use PDF;
use Carbon\Carbon;
use App\Helpers\AppHelper;
use MongoDB\BSON\Regex;
use Illuminate\Database\Eloquent\Collection;

class CompanyController extends Controller
{
    public function add_company(Request $request)
    {
    //dd($request);
        $maxLength = 2000;
        $new_id = Company::max('_id') + 1;
        $companyId =1;
        $docAvailable = AppHelper::instance()->checkDoc(Company::raw(),$companyId,$maxLength);
        // dd($docAvailable);
        $cons = [
        '_id' => $new_id,
        'counter' => 1,
        'companyName' => $request->input('company_name'),
        'insertedTime' => time(),
        'delete_status' => "NO",
        'deleteCompany' => "",
        'deleteTime' => "",
        ];
        //dd($cons);
        if ($docAvailable != "No")
        {
            $info = (explode("^",$docAvailable));
            $docId = $info[1];
            // dd($docId);
            $counter = $info[0];
            $companyid = AppHelper::instance()->getAdminDocumentSequence(1, Company::raw(),'company',(int)$docId);
            // dd($companyid);
            $data = array(
            '_id' => $companyid,
            'counter' => 0,
            'companyName' => $request->input('company_name'),
            'insertedTime' => time(),
            'delete_status' => "NO",
            'deleteCompany' => "",
            'deleteTime' => "",
            );
            // dd($cons_data);
            Company::raw()->updateOne(['companyID' => $companyId,'_id' => (int)$docId], ['$push' => ['company' => $data]]);
            //dd($cons_data);
            echo json_encode($data);
        }
        else
        {

            $count_data=Company::all();;
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
            'company'=>array($cons),
            );
            Company::raw()->insertOne($data);
        }
        $completedata[] = $data;
        echo json_encode($completedata);

        // dd($data);
        // if (!empty($data)) {
        //      return response()->json([ 'status' => true,'message' => 'Company added successfully'], 200);
        // } else {
        //     return response()->json(['status' => false,'message' => 'Failed to Add Company'], 200);
        // }


    }
        public function view_company(Request $request)
        {
            $companyID=1;
            $collection=\App\Models\Company::raw();
            $companyCurr= $collection->aggregate([
            ['$match' => ['companyID' => $companyID]],
            ['$unwind' => '$company'],
            ['$match' => ['company.delete_status' =>"NO"]]
            ]);
            // Check if company are found

            $companyData = iterator_to_array($companyCurr);
            // dd($companyData);
            return view('Company.view_company',compact('companyData'));
        }

        // public function edit_user(Request $request)
        // {
        //     $id = intval($request->id);
        //     $UserData = Company::where('_id', $id)->where('delete_status', 'NO')->first();
        //     echo json_encode($UserData);
        // }
        public function edit_company(Request $request)
        {
            // dd($request);
            $companyID=1;
            $parent=$request->master_id;
            $id=$request->id;
            $collection=\App\Models\Company::raw();
            $show1 = $collection->aggregate([
            ['$match' => ['_id' => (int)$parent, 'companyID' => 1]],
            ['$unwind' => ['path' => '$company']],
            ['$match' => ['company._id' => (int)$id]]
            ]);
            foreach ($show1 as $row) {
            $activeCust= array();
            $k = 0;
            $activeCust[$k] = $row['company'];
            $k++;

            }

            $companyData[]=array("company" => $activeCust);
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
        public function delete_company(Request $request)
        {
            $id = intval($request->id);
            $companyID=1;
            $mainId=(int)$request->master_id;
            //  dd($id);
            $comData=Company::raw()->updateOne(['companyID' =>$companyID,'_id' => $mainId,'company._id' => (int)$id],
            ['$set' => [
            'company.$.insertedTime' => time(),
            'company.$.delete_status' => "YES",
            'company.$.deletecompany' => intval($id),
            'company.$.deleteTime0' => time(),
            ]]);
            
            if($comData==true)
            {
            $arr = array('status' => 'success', 'message' => 'Record Deleted successfully.','statusCode' => 200);
            return json_encode($arr);
        }
    }
}

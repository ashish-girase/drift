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

        public function edit_user(Request $request)
        {
            $id = intval($request->id);
            $UserData = Company::where('_id', $id)->where('delete_status', 'NO')->first();
            echo json_encode($UserData);
        }
        public function update_user(Request $request)
        {
        // dd($request);
            $reqid = intval($request->user_id);
            // dd($request->input('user_firstname'));
            $UserArrayUp =Company::where('_id', $reqid)->first();
            if (!$UserArrayUp) {
            return response()->json(['status' => false, 'message' => 'No records found'], 200);
            }
            //$password = hash('sha1',$request->userPass);
            $data = [

            'userEmail' => $request->input('user_email'),
            'user_type' => $request->input('user_type'),
            'userFirstName' => $request->input('user_firstname'),
            'userLastName' => $request->input('user_lastname'),
            'userAddress' => $request->input('user_address'),
            'userCode' => $request->input('user_code'),
            'userDob' => $request->input('user_dob'),
            'userNote' => $request->input('userNote'),
            'userTelephone' => $request->input('user_phoneno'),
            'department' => $request->input('user_department'),
            'userNote' => $request->input('user_note'),
            // 'aa'=>$request->insertUser,

            'privilege' => (object)array(

            'insertUser' => $request->insertUser,
            'updateUser' => $request->updateUser,
            'deleteUser' => $request->deleteUser,
            ),
            'dashboard' => (object)array(

            ),
            'product' => (object)array(
            // 'addProduct' => (int)$request->input('addProduct'),
            ),
            'order' => (object)array(
            ),
            'admin' => (object)array(

            ),
            'QC' => (object)array(

            ),
            'insertedTime' => time(),
            'delete_status' => "NO",
            'deleteUser' => "",
            'deleteTime' => "",
            ];
            // dd($UserArrayUp);
            $result = $UserArrayUp->update($data);
            if ($result) {
            // dd($result);
            return response()->json(['status' => true,'message' => 'User updated successfully'], 200);
            } else {
            return response()->json(['status' => false,'message' => 'Failed to update User'], 200);
            }
            }
        public function delete_user(Request $request)
        {
            $id = intval($request->id);
            // dd($id);
            $userData = Company::raw()->updateOne(
            ['_id' => $id],
            ['$set' => ['delete_status' => 'YES', 'deleteUser' => intval($id), 'deleteTime' => time()]]
            );
            if ($userData == true) {
            // dd($userData);
            $arr = array('status' => 'success', 'message' => 'User deleted successfully.', 'statusCode' => 200);
            return json_encode($arr);
        }
        }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Design;use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
use File;
use Image;
use MongoDB\BSON\ObjectId;
use Auth;
use PDF;
use Carbon\Carbon;
use App\Helpers\AppHelper;
use MongoDB\BSON\Regex;
use Illuminate\Database\Eloquent\Collection;

class DesignController extends Controller
{
    public function add_design(Request $request)
    {
    //dd($request);
        $maxLength = 2000;
        $new_id = Design::max('_id') + 1;
        $companyId =1;
        $docAvailable = AppHelper::instance()->checkDoc(Design::raw(),$companyId,$maxLength);
        // dd($docAvailable);
        $cons = [
        '_id' => $new_id,
        'counter' => 1,
        'design_name' => $request->input('design_name'),
        'insertedTime' => time(),
        'delete_status' => "NO",
        'deletedesign' => "",
        'deleteTime' => "",
        ];
        // dd($cons);
        if ($docAvailable != "No")
        {
            $info = (explode("^",$docAvailable));
            $docId = $info[1];
            // dd($docId);
            $counter = $info[0];
            $companyid = AppHelper::instance()->getAdminDocumentSequence(1, Design::raw(),'design',(int)$docId);
            // dd($companyid);
            $data = array(
            '_id' => $companyid,
            'counter' => 0,
            'design_name' => $request->input('design_name'),
            'insertedTime' => time(),
            'delete_status' => "NO",
            'deleteCompany' => "",
            'deleteTime' => "",
            );
            // dd($cons_data);
            Design::raw()->updateOne(['companyID' => $companyId,'_id' => (int)$docId], ['$push' => ['design' => $data]]);
            //dd($cons_data);
            echo json_encode($data);
        }
        else
        {

            $count_data=Design::all();;
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
            'design'=>array($cons),
            );
            Design::raw()->insertOne($data);
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
        public function view_design()
        {
            $companyID=1;
            $collection=Design::raw();
            $companyCurr= $collection->aggregate([
            ['$match' => ['companyID' => $companyID]],
            ['$unwind' => '$design'],
            ['$match' => ['design.delete_status' =>"NO"]]
            ]);
            // Check if company are found

            $designData = iterator_to_array($companyCurr);
            // dd($colorData);
            return view('design.view_design',compact('designData'));
        }
        public function edit_design(Request $request)
        {
            // dd($request);
            $companyID=1;
            $parent=$request->master_id;
            $id=$request->id;
            $collection=Design::raw();
            $show1 = $collection->aggregate([
            ['$match' => ['_id' => (int)$parent, 'companyID' => 1]],
            ['$unwind' => ['path' => '$design']],
            ['$match' => ['design._id' => (int)$id]]
            ]);
            foreach ($show1 as $row) {
            $activeCust= array();
            $k = 0;
            $activeCust[$k] = $row['design'];
            $k++;

            }

            $designData[]=array("design" => $activeCust);
            // dd($colorData);
            if ($designData) {
            // dd($colorData);
            return response()->json(['success' => $designData]);
            }
        }

        public function update_design(Request $request)
        {
        // dd($request);
            $id=(int)$request->_id;
            $companyID=1;
        // dd($id);
            $data=Design::raw()->updateOne(['companyID' => $companyID,'design._id' => $id],

            ['$set' => [

            'design.$.design_name' => $request->design_name,
            'design.$.insertedTime' => time(),
            'design.$.delete_status' => "NO",
            'design.$.deletedesign' => "",
            'design.$.deleteTime' => "",]]
            );

            // dd($data);
            if ($data==true) {
            return response()->json(['status' => true,'message' => 'Color updated successfully'], 200);
            } else {
            return response()->json(['status' => false,'message' => 'Failed to update Company'], 200);
            }

        }
        public function delete_design(Request $request)
        {
            $id = intval($request->id);
            // dd($id);
            $companyID=1;
            $mainId=(int)$request->master_id;
            
            $comData=Design::raw()->updateOne(['companyID' =>$companyID,'_id' => $mainId,'design._id' => (int)$id],
            ['$set' => [
            'design.$.insertedTime' => time(),
            'design.$.delete_status' => "YES",
            'design.$.deletedesign' => intval($id),
            'design.$.deleteTime0' => time(),
            ]]);
            // dd($comData);
            if($comData==true)
            {
            $arr = array('status' => 'success', 'message' => 'Record Deleted successfully.','statusCode' => 200);
            return json_encode($arr);
        }
    }
}

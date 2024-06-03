<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Color;
use File;
use Image;
use MongoDB\BSON\ObjectId;
use Auth;
use PDF;
use Carbon\Carbon;
use App\Helpers\AppHelper;
use MongoDB\BSON\Regex;
use Illuminate\Database\Eloquent\Collection;

class ColorController extends Controller
{
    public function add_color(Request $request)
    {
    //dd($request);
        $maxLength = 2000;
        $new_id = Color::max('_id') + 1;
        $companyId =1;
        $docAvailable = AppHelper::instance()->checkDoc(Color::raw(),$companyId,$maxLength);
        // dd($docAvailable);
        $cons = [
        '_id' => $new_id,
        'counter' => 1,
        'color_name' => $request->input('color_name'),
        'insertedTime' => time(),
        'delete_status' => "NO",
        'deletecolor' => "",
        'deleteTime' => "",
        ];
        //dd($cons);
        if ($docAvailable != "No")
        {
            $info = (explode("^",$docAvailable));
            $docId = $info[1];
            // dd($docId);
            $counter = $info[0];
            $companyid = AppHelper::instance()->getAdminDocumentSequence(1, Color::raw(),'color',(int)$docId);
            // dd($companyid);
            $data = array(
            '_id' => $companyid,
            'counter' => 0,
            'color_name' => $request->input('color_name'),
            'insertedTime' => time(),
            'delete_status' => "NO",
            'deleteCompany' => "",
            'deleteTime' => "",
            );
            // dd($cons_data);
            Color::raw()->updateOne(['companyID' => $companyId,'_id' => (int)$docId], ['$push' => ['color' => $data]]);
            //dd($cons_data);
            echo json_encode($data);
        }
        else
        {

            $count_data=Color::all();;
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
            'color'=>array($cons),
            );
            Color::raw()->insertOne($data);
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
        public function view_color()
        {
            $companyID=1;
            $collection=\App\Models\Color::raw();
            $companyCurr= $collection->aggregate([
            ['$match' => ['companyID' => $companyID]],
            ['$unwind' => '$color'],
            ['$match' => ['color.delete_status' =>"NO"]]
            ]);
            // Check if company are found

            $colorData = iterator_to_array($companyCurr);
            // dd($colorData);
            return view('color.view_color',compact('colorData'));
        }
        public function edit_color(Request $request)
        {
            // dd($request);
            $companyID=1;
            $parent=$request->master_id;
            $id=$request->id;
            $collection=\App\Models\Color::raw();
            $show1 = $collection->aggregate([
            ['$match' => ['_id' => (int)$parent, 'companyID' => 1]],
            ['$unwind' => ['path' => '$color']],
            ['$match' => ['color._id' => (int)$id]]
            ]);
            foreach ($show1 as $row) {
            $activeCust= array();
            $k = 0;
            $activeCust[$k] = $row['color'];
            $k++;

            }

            $colorData[]=array("color" => $activeCust);
            // dd($colorData);
            if ($colorData) {
            // dd($colorData);
            return response()->json(['success' => $colorData]);
            }
        }

        public function update_color(Request $request)
        {
        // dd($request);
            $id=(int)$request->_id;
            $companyID=1;
        // dd($id);
            $data=Color::raw()->updateOne(['companyID' => $companyID,'color._id' => $id],

            ['$set' => [

            'color.$.color_name' => $request->color_name,
            'color.$.insertedTime' => time(),
            'color.$.delete_status' => "NO",
            'color.$.deletecolor' => "",
            'color.$.deleteTime' => "",]]
            );

            // dd($data);
            if ($data==true) {
            return response()->json(['status' => true,'message' => 'Color updated successfully'], 200);
            } else {
            return response()->json(['status' => false,'message' => 'Failed to update Company'], 200);
            }

        }
        public function delete_color(Request $request)
        {
            $id = intval($request->id);
            // dd($id);
            $companyID=1;
            $mainId=(int)$request->master_id;
            
            $comData=Color::raw()->updateOne(['companyID' =>$companyID,'_id' => $mainId,'color._id' => (int)$id],
            ['$set' => [
            'color.$.insertedTime' => time(),
            'color.$.delete_status' => "YES",
            'color.$.deletecolor' => intval($id),
            'color.$.deleteTime0' => time(),
            ]]);
            // dd($comData);
            if($comData==true)
            {
            $arr = array('status' => 'success', 'message' => 'Record Deleted successfully.','statusCode' => 200);
            return json_encode($arr);
        }
    }
}

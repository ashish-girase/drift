<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductType;
use App\Http\Controllers\Controller;
use App\Helpers\AppHelper;

class ProductTypeController extends Controller
{
    public function add_producttype(Request $request)
    {
    //dd($request);
        $maxLength = 2000;
        $new_id = ProductType::max('_id') + 1;
        $companyId =1;
        $docAvailable = AppHelper::instance()->checkDoc(ProductType::raw(),$companyId,$maxLength);
        // dd($docAvailable);
        $cons = [
        '_id' => $new_id,
        'counter' => 1,
        'producttype_name' => $request->input('producttype_name'),
        'insertedTime' => time(),
        'delete_status' => "NO",
        'deleteproducttype' => "",
        'deleteTime' => "",
        ];
        // dd($cons);
        if ($docAvailable != "No")
        {
            $info = (explode("^",$docAvailable));
            $docId = $info[1];
            // dd($docId);
            $counter = $info[0];
            $companyid = AppHelper::instance()->getAdminDocumentSequence(1, ProductType::raw(),'producttype',(int)$docId);
            // dd($companyid);
            $data = array(
            '_id' => $companyid,
            'counter' => 0,
            'producttype_name' => $request->input('producttype_name'),
            'insertedTime' => time(),
            'delete_status' => "NO",
            'deleteproducttype' => "",
            'deleteTime' => "",
            );
            // dd($cons_data);
            ProductType::raw()->updateOne(['companyID' => $companyId,'_id' => (int)$docId], ['$push' => ['producttype' => $data]]);
            //dd($cons_data);
            echo json_encode($data);
        }
        else
        {

            $count_data=ProductType::all();;
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
            'producttype'=>array($cons),
            );
            ProductType::raw()->insertOne($data);
        }
        $completedata[] = $data;
        echo json_encode($completedata);

        // dd($data);
        if (!empty($data)) {
             return response()->json([ 'status' => true,'message' => 'Product Type added successfully'], 200);
        } else {
            return response()->json(['status' => false,'message' => 'Failed to Add Product Type'], 200);
        }


    }
        public function view_producttype()
        {
            $companyID=1;
            $collection=ProductType::raw();
            $companyCurr= $collection->aggregate([
            ['$match' => ['companyID' => $companyID]],
            ['$unwind' => '$producttype'],
            ['$match' => ['producttype.delete_status' =>"NO"]]
            ]);
            // Check if company are found

            $producttypeData = iterator_to_array($companyCurr);
            // dd($colorData);
            return view('producttype.view_producttype',compact('producttypeData'));
        }
        public function edit_producttype(Request $request)
        {
            // dd($request);
            $companyID=1;
            $parent=$request->master_id;
            $id=$request->id;
            $collection=ProductType::raw();
            $show1 = $collection->aggregate([
            ['$match' => ['_id' => (int)$parent, 'companyID' => 1]],
            ['$unwind' => ['path' => '$producttype']],
            ['$match' => ['producttype._id' => (int)$id]]
            ]);
            foreach ($show1 as $row) {
            $activeCust= array();
            $k = 0;
            $activeCust[$k] = $row['producttype'];
            $k++;

            }

            $producttypeData[]=array("producttype" => $activeCust);
            // dd($producttypeData);
            if ($producttypeData) {
            // dd($colorData);
            return response()->json(['success' => $producttypeData]);
            }
        }

        public function update_producttype(Request $request)
        {
        // dd($request);
            $id=(int)$request->_id;
            $companyID=1;
        // dd($id);
            $data=ProductType::raw()->updateOne(['companyID' => $companyID,'producttype._id' => $id],

            ['$set' => [

            'producttype.$.producttype_name' => $request->producttype_name,
            'producttype.$.insertedTime' => time(),
            'producttype.$.delete_status' => "NO",
            'producttype.$.deleteproducttype' => "",
            'producttype.$.deleteTime' => "",]]
            );

            // dd($data);
            if ($data==true) {
            return response()->json(['status' => true,'message' => 'Design Type updated successfully'], 200);
            } else {
            return response()->json(['status' => false,'message' => 'Failed to update Design Type '], 200);
            }

        }
        public function delete_producttype(Request $request)
        {
            $id = intval($request->id);
            // dd($id); 
            $companyID=1;
            $mainId=(int)$request->master_id;
            // dd($id);
            
            $comData=ProductType::raw()->updateOne(['companyID' =>$companyID,'_id' => $mainId,'producttype._id' => (int)$id],
            ['$set' => [
            'producttype.$.insertedTime' => time(),
            'producttype.$.delete_status' => "YES",
            'producttype.$.deleteproducttype' => intval($id),
            'producttype.$.deleteTime0' => time(),
            ]]);
            // dd($comData);
            if($comData==true)
            {
            $arr = array('status' => 'success', 'message' => 'Record Deleted successfully.','statusCode' => 200);
            return json_encode($arr);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Color;
use App\Helpers\AppHelper;
use App\Models\API\Login_History;
use MongoDB\BSON\Regex;
use Auth;
use PDF;
use DB;
use Illuminate\Validation\Rule;
use Validator;

class ProductController extends Controller
{

          
            public function add_product(Request $request)
            {
            $maxLength = 2000;
            $new_id = Product::max('_id') + 1;
            // $randomNumber = rand(100000, 999999);
            // $unique_value = $randomNumber . $new_id;
            $companyId = 1;

            $docAvailable = AppHelper::instance()->checkDoc(Product::raw(), $companyId, $maxLength);

            // dd($colour_id);
             $colour_id = (int)$request->input('colour_id');
             $colours_name = $request->input('colours_name');
            

            // Fetching colour name based on colour_id
            $colour = Color::raw()->aggregate([
            ['$match' => ['companyID' => $companyId]],
            ['$unwind' => '$color'],
            ['$match' => ['color._id' => $colour_id]],
            ['$limit' => 1]
            ])->toArray();

            $colours_name = $colour ? $colour[0]['color']['color_name'] : '';

            // Create data array
            $cons = [
            '_id' => $new_id,
            'counter' => 1,
            'prodName' => $request->input('prodName'),
            'product_type' => $request->input('product_type'),
            'prod_code' => $request->input('prod_code'),
            'Thickness' => $request->input('Thickness'),
            'Width' => $request->input('Width'),
            'colour_id' => $colour_id,
            'ColourName' => $colours_name, // Storing colour name
            'Roll_weight' => $request->input('Roll_weight'),
            'insertedTime' => time(),
            'delete_status' => "NO",
            'deleteProduct' => "",
            'deleteTime' => "",
            ];
        //    dd($cons);

            if ($docAvailable != "No")
            {
            $info = explode("^", $docAvailable);
            $docId = $info[1];
            $productid = AppHelper::instance()->getAdminDocumentSequence(1, Product::raw(), 'product', (int)$docId);

            $cons_data = array(
            '_id' => $productid,
            'counter' => 0,
            'prodName' => $request->input('prodName'),
            'product_type' => $request->input('product_type'),
            'prod_code' => $request->input('prod_code'),
            'prod_qty' => $request->input('prod_qty'),
            'Thickness' => $request->input('Thickness'),
            'Width' => $request->input('Width'),
            'colour_id' => $colour_id,
            'ColorName' => $colours_name, // Storing colour name
            'Roll_weight' => $request->input('Roll_weight'),
            'insertedTime' => time(),
            'delete_status' => "NO",
            'deleteProduct' => "",
            'deleteTime' => "",
            );
            // dd($cons_data);
            Product::raw()->updateOne(['companyID' => $companyId, '_id' => (int)$docId], ['$push' => ['product' => $cons_data]]);

            return response()->json(['status' => true, 'message' => 'Product added successfully'], 200);
            }
            else
            {
            $count_data = Product::all();
            $count = count($count_data);
            $ids = [];

            if ($count != 0)
            {
            foreach ($count_data as $row)
            {
            $ids[] = $row->_id;
            }
            $id = max($ids);
            }
            else
            {
            $id = 0;
            }

            $data = [
            '_id' => $id + 1,
            'counter' => 0,
            'companyID' => $companyId,
            'product' => [$cons],
            ];

            Product::raw()->insertOne($data);

            return response()->json(['status' => true, 'message' => 'Product added successfully'], 200);
            }
        }

        public function view_product()
        {
            $companyID=1;
            $collection=Product::raw();
            $productCurr= $collection->aggregate([
            ['$match' => ['companyID' => $companyID]],
            ['$unwind' => '$product'],
            ['$match' => ['product.delete_status' =>"NO"]]


            ]);

            $productData = $productCurr->toArray();

            // return response()->json($product_data, 200 );
            return view('product.view_product',compact('productData'));
            }
            public function edit_product(Request $request)
            {
                $parent=$request->master_id;
                $companyID=1;
                $id=$request->id;
                // dd($parent);
                $collection=Product::raw();
                $show1 = $collection->aggregate([
                ['$match' => ['_id' => (int)$parent, 'companyID' => $companyID]],
                ['$unwind' => ['path' => '$product']],
                ['$match' => ['product._id' => (int)$id]]
                ])->toArray();
                foreach ($show1 as $row) {
                    $activeProduct12 = array();
                    $k = 0;
                    $activeProduct12[$k] = $row['product'];
                    $k++;
                }
                // dd($show1);
                $colors = Color::raw();
                $color_name = $colors->aggregate([
                    ['$match' => ['companyID' => $companyID]],
                    ['$unwind' => '$color'],
                    ['$match' => ['color.delete_status' =>"NO"]]
                ]);
                $colorData = $color_name->toArray();
               
                // dd($productData);
                $productData[]=array("product" => $activeProduct12);
                if ($productData && $colorData) {
                    return response()->json([
                    'success' => $productData,
                    'colors' => $colorData,
                ]);
                } else {
                    return response()->json([
                    'success' => 'No record'
                ]);
                }
        }


        public function view_productdetails(Request $request){
            $parent=$request->master_id;
                $companyID=1;
                $id=$request->id;
                // dd($parent);
                $collection=Product::raw();
                $show1 = $collection->aggregate([
                ['$match' => ['_id' => (int)$parent, 'companyID' => $companyID]],
                ['$unwind' => ['path' => '$product']],
                ['$match' => ['product._id' => (int)$id]]
                ])->toArray();
                foreach ($show1 as $row) {
                    $activeProduct12 = array();
                    $k = 0;
                    $activeProduct12[$k] = $row['product'];
                    $k++;
                }
                // dd($show1);
                // return view('product.view_productdetails', compact('show1'));
                return response()->json(['success' => $show1]);
        }

        public function update_product(Request $request)
        {
            //dd($request);
            $id=(int)$request->_id;
            // dd($id);
            $companyID=1;

            $colour_id1 = (int)$request->input('colour_id');
            //dd($colour_id1);
            // Fetching colour name based on colour_id
            $colour = Color::raw()->aggregate([
            ['$match' => ['companyID' => $companyID]],
            ['$unwind' => '$color'],
            ['$match' => ['color._id' => $colour_id1]],
            ['$limit' => 1]
            ])->toArray();
            // dd($colour);
            $colours_name = $colour ? $colour[0]['color']['color_name'] : '';
            $data=Product::raw()->updateOne(['companyID' => $companyID,'product._id' => $id],

            ['$set' => [
            'product.$.prodName' => $request->prodName,
            'product.$.product_type' => $request->product_type,
            'product.$.prod_code' => $request->prod_code,
            'product.$.prod_qty' => $request->prod_qty,
            'product.$.Thickness' => $request->Thickness,
            'product.$.Width' => $request->Width,
            'product.$.colour_id' => $request->colour_id,
            'product.$.ColourName' => $colours_name,
            'product.$.Roll_weight' => $request->Roll_weight,
            'product.$.insertedTime' => time(),
            'product.$.delete_status' => "NO",
            'product.$.deleteProduct' => "",
            'product.$.deleteTime' => "",]]
            );
            //dd($data);
            if ($data==true) {
            //dd($data);
            return response()->json(['status' => true,'message' => 'Product updated successfully'], 200);
            } else {
            return response()->json(['status' => false,'message' => 'Failed to update Product'], 500);
            }

        }
        public function delete_product(Request $request)
        {
            $id = intval($request->id);
            $companyID=1;
            $mainId=(int)$request->master_id;
            // dd($mainId);
            $prodData=Product::raw()->updateOne(['companyID' =>$companyID,'_id' => $mainId,'product._id' => (int)$id],
            ['$set' => [
                'product.$.insertedTime' => time(),
                'product.$.delete_status' => "YES",
                'product.$.deleteProduct' => intval($id),
                'product.$.deleteTime0' => time(),
            ]]);
            if($prodData==true)
            {
                $arr = array('status' => 'success', 'message' => 'Product Deleted successfully.','statusCode' => 200);
                return json_encode($arr);
            }

        }
        public function get_colorlist(Request $request)
        {
            $val = $request->value;
            $para = '^' . $val;
            $datasearch = new Regex ($para, 'i');
            // dd($datasearch);
            $companyID=1;
            $show = Color::raw()->aggregate([['$match' => ["companyID" => $companyID]],
                ['$unwind' => '$color'],
                ['$match' => ['color.color_name' => $datasearch,'color.delete_status' => "NO"]],
                ['$project' => ['color._id' => 1,'_id' => 1, 'color.color_name' => 1,'color.delete_status'=>1]],
            ]);
            $color = array();
            $colorList = array();
            foreach ($show as $s)
            {
                // dd($s);
                $k = 0;
                $color[$k] = $s['color'];
                $parent = $s['_id'];
                $k++;
                foreach ($color as $sr)
                {
                    $colorList[] = array("id" =>$sr['_id'], "value" => $sr['color_name'],"parent" => $parent);
                }
    
            }
           
            echo json_encode($colorList);
        }



        public function getProduct(Request $request){
            $productdata = Product::all();
            $product = $productdata->toArray();
            // dd($product);
            return response()->json($product);
        }

        public function index()
    {
        $products = Product::all();
        $product = $products->toArray();
        //dd($products);
        return response()->json($product);
    }

    public function show($id)
    {
        $product = Product::find($id);
        return response()->json($product);
    }

    public function fetchColorNames(Request $request){
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
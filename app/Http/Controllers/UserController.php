<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use File;
use Image;
use MongoDB\BSON\ObjectId;
use Auth;
use PDF;
use Carbon\Carbon;
use App\Helpers\AppHelper;
use MongoDB\BSON\Regex;
use Illuminate\Database\Eloquent\Collection;

class UserController extends Controller
{
        public function add_user(Request $request)
        {
            dd($request);
            $new_id = User::max('_id') + 1;
            $randomNumber = rand(100000, 999999); // You can adjust the range as needed
            $unique_value = $randomNumber . $new_id;
            // Hash the password using bcrypt
            $password = hash('sha1',$request->user_password);

            // Create data array
            $data = [
            '_id' => $new_id,
            'userEmail' => $request->input('user_email'),
            // 'userName' => $request->input('userName'),
            'userPass' => $password,
            'user_type' => $request->input('user_type'),
            'userFirstName' => $request->input('user_firstname'),
            'userLastName' => $request->input('user_lastname'),
            'userAddress' => $request->input('user_address'),
            // 'userCity' => $request->input('userCity'),
            // 'userState' => $request->input('userState'),
            // 'userZip' => $request->input('userZip'),
            'userCode' => $request->input('user_code'),
            'userDob' => $request->input('user_dob'),
            'userTelephone' => $request->input('user_phoneno'),
            'department' => $request->input('user_department'),
            'userNote' => $request->input('user_note'),
            // 'privilege' => (object)array(
            // 'insertUser' => (int)$request->insertUser,
            // 'updateUser' => (int)$request->updateUser,
            // 'deleteUser' => (int)$request->deleteUser,
            // ),
            'dashboard' => 1,
            'product' => 1,
            'order' => 1,
            'admin' => 1,
            'QC' => 1,
            'insertedTime' => time(),
            'delete_status' => "NO",
            'deleteUser' => "",
            'deleteTime' => "",
            ];
            // dd($data);
            $result = User::insert($data);

            if ($result) {
            return response()->json([ 'status' => true,'message' => 'User added successfully'], 200);
            } else {
            return response()->json(['status' => false,'message' => 'Failed to Add User'], 200); // 500 for internal server error
            }
        }
        public function view_user(Request $request)
        {
            // try {
            // Perform aggregation query
            $users = User::raw(function ($collection) {
            return $collection->aggregate([
            ['$match' => ['delete_status' => 'NO']]
            ]);
            });

            // Check if users are found

            $userData = iterator_to_array($users);

            // if ($userData) {
            // return response()->json([
            //     'success' => $userData,
            //     ]);
            //     } else {
            //     return response()->json([
            //     'success' => 'No record'
            //     ]);
            // }
            return view('User.view_user',compact('userData'));
            // }
            // catch (\Exception $e) {
            // // Handle exceptions if any
            // return response()->json(['status' => false , 'message' => $e->getMessage()], 500);
            // }
        }

        public function edit_user(Request $request)
        {
            $id = intval($request->id);
            $UserData = User::where('_id', $id)->where('delete_status', 'NO')->first();
            echo json_encode($UserData);
        }
        public function update_user(Request $request)
        {
        // dd($request);
            $reqid = intval($request->user_id);
            // dd($request->input('user_firstname'));
            $UserArrayUp =User::where('_id', $reqid)->first();
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
            $userData = User::raw()->updateOne(
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

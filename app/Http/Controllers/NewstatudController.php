<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\AppHelper;
use App\Models\new_notes;

class NewstatudController extends Controller
{
    // public function addnewStatus(Request $request){
    //     $latestNote = new_notes::latest()->first();

    //     if ($latestNote) {
    //         $new_id = $latestNote->_id + 1;
    //     } else {
    //         // If the collection is empty, start from 1
    //         $new_id = 1;
    //     }

    //     // Prepare data for insertion
    //     $data = [
    //         '_id' => $new_id,
    //         'counter' => 1,
    //         'status' => $request->input('status'),
    //         'receipy_code' => $request->input('receipy_code'), 
    //         'delivery_date' => $request->input('delivery_date'),
    //         'time' => $request->input('time'),
    //         'note' => $request->input('note'),
    //         'orderid' => $request->input('id'),
    //         'insertedTime' => time(),
    //         'delete_status' => "NO",
    //         'deleteCustomer' => "",
    //         'deleteTime' => "",
    //     ];
    //     $newNote= new_notes::raw()->insertOne([
    //         '_id' => $new_id, 
    //         'companyID' => 1,
    //         'order' => [$data],
    //     ]);
    //     // Create new notes instance
    //     // $newNote = new_notes::create($data);

    //     // Return success response with the created data
    //     return response()->json(['status' => true, 'message' => 'Notes added successfully'], 200);
    // }

    use MongoDB;



}
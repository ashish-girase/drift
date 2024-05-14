<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Hash;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Session;


class SessionsController extends Controller
{
    public function create()
    {
        return view('session.login-session');
    }

    public function User_Login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        // dd($request);
        $email = strtolower($request->email);
        $password = $request->password;
        $collection=\App\Models\User::raw();

        $user = $collection->aggregate([
            [
                '$match' => [
                    'userEmail' => [
                        '$regex' => '^' . preg_quote($email, '/') . '$',
                        '$options' => 'i', // Case-insensitive option
                    ],
                    'userPass' => sha1($password),
                ],
            ],
        ]);

        $userFound = false;

        foreach ($user as $u) {
            $userFound = true;
            $userModel = new User();
            $userModel->_id = $u->_id;
            $userModel->userEmail = $u->userEmail;
            $userModel->userPass = $u->userPass;
            $userModel->userFirstName = $u->userFirstName;
            $userModel->userLastName = $u->userLastName;
            $userModel->userAddress = $u->userAddress;

            Auth::login($userModel);
        }

        if ($userFound) {
            return redirect('/')->withSuccess('You have Successfully logged in');
        } else {
            // dd($userFound);
            return redirect('/login')->with('error', 'Invalid credentials');
        }

        // if ($user->count() > 0) { // Check if any documents are returned
        //     foreach ($user as $u) {
        //         $userModel = new User();
        //         $userModel->_id = $u->_id;
        //         $userModel->userEmail = $u->userEmail;
        //         $userModel->userPass = $u->userPass;
        //         $userModel->userFirstName = $u->userFirstName;
        //         $userModel->userLastName = $u->userLastName;
        //         $userModel->userAddress = $u->userAddress;

        //         Auth::login($userModel);
        //     }

        //     return redirect('/')->withSuccess('You have Successfully logged in');
        // } else {
        //     return redirect('/login')->with('error', 'Invalid credentials');
        // }


    }

    public function destroy()
    {

        Auth::logout();

        return redirect('/login')->with(['success'=>'You\'ve been logged out.']);
    }
}

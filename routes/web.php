<?php

use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InfoUserController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CustomerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(['middleware' => 'auth'], function () {

    Route::get('/', [HomeController::class, 'home']);
	Route::get('dashboard', function () {
		return view('dashboard');
	})->name('dashboard');

    //user Module
    Route::POST('/admin/add_user', [UserController::class, 'add_user']);
    Route::POST('/admin/edit_user', [UserController::class, 'edit_user']);
    Route::POST('/admin/update_user', [UserController::class, 'update_user']);
    Route::get('/user', [UserController::class, 'view_user']);
    Route::post('/delete_user', [UserController::class, 'delete_user'])->name('delete_user');

    //Company master module
    Route::get('/company', [CompanyController::class, 'view_company'])->name('company');
    Route::POST('/admin/add_company', [CompanyController::class, 'add_company']);
    Route::POST('/admin/edit_company', [CompanyController::class, 'edit_company']);
    Route::POST('/admin/update_company', [CompanyController::class, 'update_company']);
    Route::post('/admin/delete_company', [CompanyController::class, 'delete_company'])->name('delete_company');

    //Customer master module
    Route::get('/customer', [CustomerController::class, 'view_customer'])->name('customer');
    Route::POST('/admin/add_customer', [CustomerController::class, 'add_customer']);
    Route::POST('/admin/edit_customer', [CustomerController::class, 'edit_customer']);
    Route::post('admin/get_companylist', [CustomerController::class, 'get_companylist']);

    Route::get('/logout', [SessionsController::class, 'destroy']);
	Route::get('/user-profile', [InfoUserController::class, 'create']);
	Route::post('/user-profile', [InfoUserController::class, 'store']);
    Route::get('/login', function () {
		return view('dashboard');
	})->name('sign-up');
});



Route::group(['middleware' => 'guest'], function () {
    Route::get('/register', [RegisterController::class, 'create']);
    Route::post('/register', [RegisterController::class, 'store']);
    Route::get('/login', [SessionsController::class, 'create']);
    Route::post('/auth', [SessionsController::class, 'store']);
	// Route::get('/login/forgot-password', [ResetController::class, 'create']);
	// Route::post('/forgot-password', [ResetController::class, 'sendEmail']);
	// Route::get('/reset-password/{token}', [ResetController::class, 'resetPass'])->name('password.reset');
	// Route::post('/reset-password', [ChangePasswordController::class, 'changePassword'])->name('password.update');

});

Route::get('/login', function () {
    return view('auth/login-session');
})->name('login');

Route::post('/user_login', [SessionsController::class, 'User_Login'])->name('login.user');

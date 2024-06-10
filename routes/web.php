<?php

use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\DesignController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InfoUserController;
use App\Http\Controllers\NewstatudController;
use App\Http\Controllers\ProductTypeController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\OrderController;
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
    Route::get('/user', [UserController::class, 'view_user']);
    Route::post('/admin/add_user', [UserController::class, 'add_user']);
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
    Route::POST('/admin/update_customer', [CustomerController::class, 'update_customer']);
    Route::get('/get-customer', [CustomerController::class, 'getCustomer']);
    Route::post('/admin/delete_customer', [CustomerController::class, 'delete_customer'])->name('delete_customer');
    Route::post('admin/get_companylist', [CustomerController::class, 'get_companylist']);

    //Color master module
     Route::get('/color', [ColorController::class, 'view_color'])->name('color');
     Route::get('/admin/add_color', [ColorController::class, 'add_color']);
     Route::POST('/admin/edit_color', [ColorController::class, 'edit_color']);
     Route::POST('/admin/update_color', [ColorController::class, 'update_color']);
     Route::post('/admin/delete_color', [ColorController::class, 'delete_color'])->name('delete_color');

    //  //Design master module
    //  Route::get('/design', [DesignController::class, 'view_design'])->name('design');
    //  Route::POST('/admin/add_design', [DesignController::class, 'add_design']);
    //  Route::POST('/admin/edit_design', [DesignController::class, 'edit_design']);
    //  Route::POST('/admin/update_design', [DesignController::class, 'update_design']);
    //  Route::post('/admin/delete_design', [DesignController::class, 'delete_design'])->name('delete_design');

    //ProductType master module
    Route::get('/producttype', [ProductTypeController::class, 'view_producttype'])->name('producttype');
    Route::POST('/admin/add_producttype', [ProductTypeController::class, 'add_producttype']);
    Route::POST('/admin/edit_producttype', [ProductTypeController::class, 'edit_producttype']);
    Route::POST('/admin/update_producttype', [ProductTypeController::class, 'update_producttype']);
    Route::post('/admin/delete_producttype', [ProductTypeController::class, 'delete_producttype'])->name('delete_producttype');
    
     //Product master module
     Route::get('/product', [ProductController::class, 'view_product'])->name('product');
     Route::get('/productdetils', [ProductController::class, 'view_productdetails'])->name('productdetils');
     Route::POST('/admin/adddesign', [ProductController::class, 'addDesign']);
    
     Route::POST('/admin/add_product', [ProductController::class, 'add_product']);
     Route::POST('/admin/edit_product', [ProductController::class, 'edit_product']);
     Route::POST('/admin/update_product', [ProductController::class, 'update_product']);
     Route::get('/admin/get_product', [ProductController::class, 'getProduct'])->name('getProduct');
     Route::get('/products/{id}', [ProductController::class, 'show']);
     Route::post('/admin/delete_product', [ProductController::class, 'delete_product'])->name('delete_product');
     Route::post('/admin/get_colorlist', [ProductController::class, 'fetchColorNames']);
    // Route::get('/fetch-color-name', 'ProductController@fetchColorName');
     
     //Order master module
     Route::get('/order', [OrderController::class, 'view_order'])->name('order');
     //  Route::POST('/admin/add_product', [OrderController::class, 'add_product']);
     //  Route::POST('/admin/edit_product', [ProductController::class, 'edit_product']);
     //  Route::POST('/admin/update_product', [ProductController::class, 'update_product']);
     //  Route::post('/admin/delete_product', [ProductController::class, 'delete_product'])->name('delete_product');
      Route::get('admin/get_designlist/{product}', [OrderController::class, 'get_designlist']);
     Route::post('/admin/add_order', [OrderController::class, 'addOrder']);
     Route::POST('/admin/edit_order', [OrderController::class, 'edit_order']);
     Route::POST('/admin/find_color', [OrderController::class, 'fetchColorsNames']);
     Route::POST('/admin/update_order', [OrderController::class, 'update_order']);
     Route::post('/admin/delete_order', [OrderController::class, 'delete_order'])->name('delete_order');
     Route::post('admin/searchCustomer', [OrderController::class, 'searchCustomer']);
     Route::get('admin/searchProducts', [OrderController::class, 'searchProduct']);
    Route::post('admin/customerdataget_single', [OrderController::class, 'customerdataget_single']);
   // Route::post('order/view_order', [OrderController::class, ' showCustomers'])->name('showCustomers');
    Route::post('/orders/updateStatus', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::post('/orders/addnewStatus', [OrderController::class, 'addnewStatus'])->name('orders.addnewStatus');
    Route::get('/admin/searchcustomerdata', [OrderController::class, 'searchcustomerdata']);
    Route::get('/admin/searchproductdata', [OrderController::class, 'searchproductdata']);
    
    // Route::get('/admin/create', [OrderController::class, 'create'])->name('create');






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

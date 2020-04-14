<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminChk;
use App\Http\Middleware\UserChk;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::group(['middleware' => ['auth']], function () {
        Route::post('/edit-customer', 'HomeController@editCustomer')->name('edit.customer');
        Route::post('/update-customer', 'HomeController@updateCustomer')->name('update.customer');
        Route::get('/update-password', 'HomeController@updatePasswordForm')->name('update.passwordForm');
        Route::post('/update-password', 'HomeController@updatePassword')->name('update.password');
});

Route::group(['middleware' => ['userChk']], function () {
    Route::get('/home', 'HomeController@index')->name('home');
});
Route::group(['middleware' => ['adminChk']], function () {
    Route::get('/admin/home','Admin\AdminController@index')->name('admin.dashboard');
    Route::get('/admin/customers','Admin\AdminController@customerList')->name('admin.customerList');
    Route::post('/admin/customer-delete','Admin\AdminController@customerDelete')->name('admin.customerDelete');

});


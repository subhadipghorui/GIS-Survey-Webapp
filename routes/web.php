<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    // return view('welcome');
    return redirect()->route('login');
});
Route::get('/users', function () {
    return \App\User::all();
});

Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home');

// Super Admin ////////////////////////////////////////////////////////////////////////
Route::group(['prefix' => 'superadmin', 'as' => 'superadmin.', 'namespace' => 'SuperAdmin', 'middleware' => ['auth', 'super_admin']], function () {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    // Settings
    Route::get('dashboard/profile', 'DashboardController@profile')->name('profile');
    Route::put('dashboard/profile', 'DashboardController@profileUpdate')->name('profile.update');
    Route::put('dashboard/profile/pwd', 'DashboardController@changePassword')->name('changepassword');

    // // Users
    Route::resource('user', 'UserController')->except(['create','show', 'edit', ]);
});

// User ////////////////////////////////////////////////////////////////////////
Route::group(['prefix' => 'user', 'as' => 'user.', 'namespace' => 'user', 'middleware' => ['auth', 'user']], function () {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    // Settings
    Route::get('dashboard/profile', 'DashboardController@profile')->name('profile');
    Route::put('dashboard/profile', 'DashboardController@profileUpdate')->name('profile.update');
    Route::put('dashboard/profile/pwd', 'DashboardController@changePassword')->name('changepassword');


    // Data Table
    Route::get('datasets', 'DatasetController@index')->name('dataset.index');
    Route::get('datasets/ajax', 'DatasetController@ajaxData')->name('dataset.ajax');
    Route::get('dataset/create', 'DatasetController@create')->name('dataset.create');
    Route::post('dataset/store', 'DatasetController@store')->name('dataset.store');
    Route::put('dataset/update', 'DatasetController@update')->name('dataset.update');
    Route::post('dataset/delete', 'DatasetController@destroy')->name('dataset.destroy');

});

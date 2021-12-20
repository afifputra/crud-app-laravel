<?php

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
    return view('welcome');
});

Route::get('/profile', function () {
    return view('profile');
});

Route::get('/home', 'HomeController@tampilkanData');

Route::post('/home/manipulasidata', 'HomeController@manipulasiData');

Route::post('/home/getdata', 'HomeController@getDataForEdit');

Route::post('/home/hapus', 'HomeController@hapusData');
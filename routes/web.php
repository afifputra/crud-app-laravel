<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Karyawan_controller;

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

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/profile', function () {
//     return view('profile');
// });

Route::get('/','Karyawan_controller@index');

Route::get('/yajra','Karyawan_controller@yajra');

Route::post('/getdata', 'Karyawan_controller@getDataForEdit');

Route::post('/manipulasidata', 'Karyawan_controller@manipulasiData');

Route::post('/hapus', 'Karyawan_controller@hapusData');
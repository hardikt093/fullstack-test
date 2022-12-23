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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/truncate',                 'TaskController@truncate');
Route::get('/',                         'TaskController@index');
Route::post('/task/load',               'TaskController@load');
Route::post('/task/create',             'TaskController@create');
Route::post('/task/complete',           'TaskController@complete');
Route::post('/task/delete',             'TaskController@delete');
Route::post('/task/pending',            'TaskController@pending');

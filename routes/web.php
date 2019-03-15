<?php

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
//Route::resource('threads','ThreadController');

Route::get('threads','ThreadController@index');

Route::get('threads/create','ThreadController@create');
Route::get('threads/{channel}/{thread}','ThreadController@show');

Auth::routes();

Route::get('threads/{channel}','ThreadController@index');

Route::post('/threads/{channel}/{thread}/replies','RepliesController@store');
Route::post('/threads','ThreadController@store');
Route::get('/home', 'HomeController@index')->name('home');

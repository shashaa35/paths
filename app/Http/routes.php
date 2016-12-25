<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/',  [ 'middleware'=>'web','uses'=>'HomeController@index']);
Route::get('/check_paths',  [ 'middleware'=>'web','uses'=>'HomeController@check_paths']);
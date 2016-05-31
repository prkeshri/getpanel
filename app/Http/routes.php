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

Route::auth();

Route::controller('/tables', 'TableController');
Route::controller('/pages', 'PageGenerationController');
Route::controller('/page','PageController');
Route::controller('/user-groups','Auth\\UserGroupController');
Route::controller('/users','Auth\\UserController');
Route::controller('/', 'HomeController');
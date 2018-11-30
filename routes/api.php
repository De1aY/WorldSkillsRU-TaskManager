<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/users', "Models\UserController@getUsers")->middleware('session');

Route::get('/tasks', "Models\TaskController@getTasks")->middleware('session');
Route::put('/tasks', "Models\TaskController@addTask")->middleware('session');

Route::get('/processes', "Models\ProcessController@getProcesses")->middleware('session');

Route::post('/login', 'AuthorizationController@login');
Route::post('/session', 'AuthorizationController@checkSessionID')->middleware('session');

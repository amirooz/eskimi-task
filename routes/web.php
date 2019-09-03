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

Route::resource('/', 'Projects\DashboardController');

Auth::routes();
Route::resource('tasks', 'Projects\TaskController');
Route::resource('dashboard', 'Projects\DashboardController');
Route::resource('guzzle', 'GuzzleHttpController');

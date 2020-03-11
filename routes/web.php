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

Auth::routes();


Route::get('/index', 'HomeController@index')->name('index');
Route::get('/profil', 'HomeController@profil')->name('profil');
Route::get('/game', 'IndexController@game')->name('game');


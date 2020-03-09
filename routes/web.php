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

<<<<<<< HEAD
Route::get('/index', 'HomeController@index')->name('index');

Route::get('/profil', 'HomeController@profil')->name('profil');
=======
Route::get('/game', 'IndexController@game')->name('game');
Route::get('/index', 'IndexController@index')->name('index');
>>>>>>> 9de9d23271eb7ee7384ca8b5cd41ef51dbbd1313

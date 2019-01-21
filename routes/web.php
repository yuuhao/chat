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
});
Route::get('/make','HomeController@index');

Route::group(['middleware' => 'auth','prefix' => 'chat'],function($router){

    Route::get('/','ChatController@index');
    Route::get('/init','ChatController@init')->name('chat.init');
    Route::get('/find','ChatController@find')->name('chat.find');

});



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

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

// Route::get('/', function () {
//     return view('welcome');
// });
// Route::view('/bulksms', 'bulksms');
// Route::post('/bulksms', 'BulkSmsController@sendSms');

Route::post('/', 'MailController@updateStatus');
Route::get('/', 'HomeController@show')->name('home');
Route::post('/', 'HomeController@storePhoneNumber');
Route::post('/custom', 'HomeController@sendCustomMessage');

Route::post('/SentSmsStatus', 'HomeController@SentSmsStatus');
Route::post('/IncommingSmsStatus', 'HomeController@IncommingSmsStatus');

Route::get('/replies/{id}/show', 'ReplyController@show')->name('replies.show');

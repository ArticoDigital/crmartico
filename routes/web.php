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

Auth::routes();

Route::get('/', 'HomeController@index')->name('home')->middleware('guest');
Route::get('/auth/facebook/', 'SocialAuthController@facebook');
Route::get('/auth/facebook/callback', 'SocialAuthController@callback');
Route::post('/auth/facebook/register','SocialAuthController@register');
Route::get('logout',function (){Auth::logout(); return redirect('/');});

Route::group(['middleware' => 'auth', 'prefix' => 'admin'],function (){
    Route::get('/','HomeController@admin');
    Route::get('/facturas','InvoiceController@index');
    Route::get('/facturas/nueva','InvoiceController@newInvoice');

});
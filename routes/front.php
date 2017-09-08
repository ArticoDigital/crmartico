<?php
Auth::routes();

Route::get('/', 'HomeController@index')->name('home')->middleware('guest');
Route::get('/auth/facebook/', 'SocialAuthController@facebook');
Route::get('/auth/facebook/callback', 'SocialAuthController@callback');
Route::post('/auth/facebook/register', 'SocialAuthController@register');
Route::get('logout', function () {
    Auth::logout();
    return redirect('/');
});

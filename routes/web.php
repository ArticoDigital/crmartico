<?php

require __DIR__ . '/front.php';
Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function () {
    Route::get('/', 'HomeController@admin');

    require __DIR__ . '/admin/invoice.php';
    require __DIR__ . '/admin/product.php';
    require __DIR__ . '/admin/customer.php';
    require __DIR__ . '/admin/provider.php';

});
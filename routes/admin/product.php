<?php

Route::get('/productos','ProductController@products');
Route::get('/productos/nuevo','ProductController@newProduct');
Route::post('/productos/nuevo','ProductController@insertProduct');
Route::get('/productos/{id}/editar','ProductController@editProduct');
Route::post('/productos/editar','ProductController@updateProduct');
Route::post('/productos/eliminar','ProductController@deleteProduct');
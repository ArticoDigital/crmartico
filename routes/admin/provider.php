<?php
Route::get('/proveedores','ProviderController@providers');
Route::get('/proveedores/nuevo','ProviderController@newProvider');
Route::post('/proveedores/nuevo','ProviderController@insertProvider');
Route::get('/proveedores/{id}/editar','ProviderController@editProvider');
Route::post('/proveedores/editar','ProviderController@updateProvider');
Route::post('/proveedores/eliminar','ProviderController@deleteProvider');
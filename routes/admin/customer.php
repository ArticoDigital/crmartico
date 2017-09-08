<?php
Route::get('/clientes','CustomerController@customers');
Route::get('/clientes/nuevo','CustomerController@newCustomer');
Route::post('/clientes/nuevo','CustomerController@insertNewCustomer');
Route::get('/clientes/{id}/editar','CustomerController@editCustomer');
Route::post('/clientes/editar','CustomerController@updateCustomer');
Route::post('/clientes/eliminar','CustomerController@deleteCustomer');
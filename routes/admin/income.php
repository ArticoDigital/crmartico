<?php
Route::get('/ingresos', 'IncomeController@index');
Route::get('/ingresos/nuevo', 'IncomeController@newIncome');
Route::post('/ingresos/nuevo', 'IncomeController@insertIncome');
Route::get('/ingresos/{id}/editar', 'IncomeController@editIncome');
Route::post('/ingresos/editar','IncomeController@updateIncome');
Route::post('/ingresos/eliminar','IncomeController@deleteIncome');
Route::post('/ingresos/parciales','IncomeController@partialIncome');
Route::post('/ingresos/parciales/eliminar','IncomeController@deletePartialIncome');
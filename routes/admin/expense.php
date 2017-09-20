<?php
Route::get('/gastos','ExpenseController@expenses');
Route::get('/gastos/nuevo','ExpenseController@newExpense');
Route::post('/gastos/nuevo','ExpenseController@insertExpense');
Route::get('/gastos/{id}/editar','ExpenseController@editExpense');
Route::post('/gastos/editar','ExpenseController@updateExpense');
Route::post('/gastos/eliminar','ExpenseController@deleteExpense');
Route::post('/gastos/parciales','ExpenseController@partialExpense');
Route::post('/gastos/parciales/eliminar','ExpenseController@deletePartialExpense');



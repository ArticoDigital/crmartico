<?php
Route::get('/facturas', 'InvoiceController@index');
Route::get('/facturas/nueva', 'InvoiceController@newInvoice');
Route::post('/facturas/nueva', 'InvoiceController@insertInvoice');
Route::get('/facturas/{id}/editar','InvoiceController@editInvoice');
Route::post('/facturas/editar','InvoiceController@updateInvoice');

Route::post('/facturas/eliminar','InvoiceController@deleteInvoice');
Route::post('/facturas/parciales','InvoiceController@partialInvoice');
Route::post('/facturas/parciales/eliminar','InvoiceController@deletePartialInvoice');

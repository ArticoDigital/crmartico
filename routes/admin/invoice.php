<?php
Route::get('/facturas', 'InvoiceController@index');
Route::get('/facturas/nueva', 'InvoiceController@newInvoice');
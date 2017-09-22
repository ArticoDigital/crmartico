<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{

    public function index(){
        return view('invoices.index',[
            'invoices' =>auth()->user()->invoices()->paginate(10)
        ]);
    }
    public function newInvoice(){
        return view('invoices.newInvoice',
            [
                'customers' => Customer::select('name_customer','address','id')->get(),
                'products' => Product::all()
            ]);
    }
}

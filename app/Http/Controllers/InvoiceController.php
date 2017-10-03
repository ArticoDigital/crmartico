<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateInvoiceRequest;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Product;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{

    public function index()
    {
        return view('invoices.index', [
            'invoices' => Invoice::with(['state','customer'])->get()
        ]);
    }

    public function newInvoice()
    {
        return view('invoices.newInvoice',
            [
                'customers' => Customer::select('name_customer', 'address', 'id')->get(),
                'products' => Product::all()
            ]);
    }

    public function insertInvoice(CreateInvoiceRequest $request)
    {
        $dataInvoice = collect($request->validated());
        $products = $dataInvoice->pull('product');
        $dataInvoice->put('status_invoces_id', 1);
        $dataInvoice->put('user_id', Auth()->user()->id);

        $products = collect($products)->map(function ($item, $key) {
            unset($item['name'],$item['price_temp']) ;
            return $item ;
        })->keyBy('product_id')->all();

        $invoice = Invoice::create($dataInvoice->all());
        $invoice->products()->attach($products);
        return redirect('/admin/facturas');
    }

    public function editInvoice($id){
        $customers = Customer::select('name_customer', 'address', 'id')->get();
        $products = Product::all();
        $invoice = Invoice::findOrFail($id)->load(['state','customer']);

        Session()->flash('invoiceId', $id);
        return view('invoices.editInvoice', compact('customers', 'products','invoice'));
    }

    public function updateInvoice(CreateInvoiceRequest $request){
        $id = session('invoiceId');
        $invoice = Invoice::findOrFail($id);

        $dataInvoice = collect($request->validated());
        $products = $dataInvoice->pull('product');
        $dataInvoice->put('status_invoces_id', 1);
        $dataInvoice->put('user_id', Auth()->user()->id);

        $products = collect($products)->map(function ($item) {
            unset($item['name'],$item['price_temp']) ;
            return $item ;
        })->keyBy('product_id')->all();

        $invoice->products()->sync($products);
        return back();


    }


}

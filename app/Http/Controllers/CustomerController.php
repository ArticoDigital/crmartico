<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCustomerRequest;
use App\Models\Contact;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function customers()
    {
        $customers = Customer::paginate()->load('contacts');
        return view('contacts.customers', compact('customers'));
    }

    public function newCustomer()
    {
        return view('contacts.newCustomer');
    }

    public function insertNewCustomer(CreateCustomerRequest $request)
    {
        $customer = Customer::create($this->saveStorage($request, ['chamber_commerce', 'rut']));
        $customer->contacts()->saveMany($this->contactsArray($request->all()));
        return redirect('/admin/clientes')->with(['success' => '¡Cliente Creado!']);
    }

    public function editCustomer($id)
    {
        $customer = Customer::findOrFail($id)->load('contacts');
        Session()->flash('userId', $id);
        return view('contacts.updateCustomer', compact('customer'));
    }

    public function updateCustomer(CreateCustomerRequest $request)
    {
        $id = session('userId');
        $inputs = $request->all();
        $customer = Customer::findOrFail($id);
        $customer->fill($this->validateUpdateFiles($request, ['chamber_commerce', 'rut']))->save();
        $customer->contacts()->delete();
        $customer->contacts()->saveMany($this->contactsArray($inputs));
        return back()->with(['success' => '¡Cliente Actualizado!']);
    }

    public function deleteCustomer(Request $request)
    {
        $customer = Customer::find($request->input('id'));
        $customer->contacts()->delete();
        $customer->delete();
        return redirect('/admin/clientes')->with(['success' => '¡Cliente Elimado!']);
    }

    public function providers()
    {
        return view('contacts.providers');
    }

    public function newProvider()
    {
        return view('contacts.newProvider');
    }

    private function contactsArray($inputs)
    {
        $contacts = [];
        foreach ($inputs['c'] as $contact) {
            $contacts[] = new Contact($contact);
        }
        return $contacts;
    }

    private function saveStorage($request, $nameFiles)
    {
        $data = $request->all();
        foreach ($nameFiles as $nameFile) {
            $data[$nameFile] =
                ($request->hasFile($nameFile)) ? $request->file($nameFile)->store('customers', 'public') : '';
        }
        return $data;
    }

    private function validateUpdateFiles($request, $nameFiles)
    {
        $data = $request->all();
        foreach ($nameFiles as $nameFile) {
            if (isset($data[$nameFile])) {
                $data[$nameFile] =
                    ($request->hasFile($nameFile)) ? $request->file($nameFile)->store('customers', 'public') : '';
            }
        }
        return $data;

    }

}

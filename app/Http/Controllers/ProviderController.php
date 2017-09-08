<?php

namespace App\Http\Controllers;


use App\Http\Requests\CreateProviderRequest;
use App\Models\Provider;
use Illuminate\Http\Request;

class ProviderController extends Controller
{

    public function providers()
    {
        $providers = Provider::paginate();
        return view('contacts.providers',compact('providers'));
    }

    public function newProvider()
    {
        return view('contacts.newProvider');
    }

    public function editProvider($id)
    {
        $provider = Provider::findOrFail($id);
        Session()->flash('userId', $id);
        return view('contacts.updateProvider', compact('provider'));
    }

    public function insertProvider(CreateProviderRequest $request)
    {
        $data = $request->validated();
        Provider::create($this->validateUpdateFiles($request, ['chamber_commerce', 'rut'], $data));
        return redirect('/admin/proveedores')->with(['success' => '¡Provedor Creado!']);
    }
    public function updateProvider(CreateProviderRequest $request)
    {
        $id = session('userId');
        $data = $request->validated();
        $provider = Provider::findOrFail($id);
        $provider->fill($this->validateUpdateFiles($request, ['chamber_commerce', 'rut'], $data))->save();

        return back()->with(['success' => '¡Cliente Actualizado!']);
    }
    public function deleteProvider(Request $request)
    {
        $provider = Provider::find($request->input('id'));
        $provider->delete();
        return redirect('/admin/proveedores')->with(['success' => '¡Cliente Elimado!']);
    }

    private function validateUpdateFiles($request, $nameFiles, $data)
    {
        foreach ($nameFiles as $nameFile) {
            if (isset($data[$nameFile])) {
                $data[$nameFile] =
                    ($request->hasFile($nameFile)) ? $request->file($nameFile)->store('customers', 'public') : '';
            }
        }
        return $data;
    }


}

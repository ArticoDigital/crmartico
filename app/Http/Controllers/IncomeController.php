<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateIncomeRequest;
use App\Http\Requests\CreatePartialIncomeRequest;
use App\Models\Customer;
use App\Models\Income;
use App\Models\IncomeCategory;
use App\Models\IncomePartial;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    public function index()
    {
        return view('income.index', ['incomes' => Income::with('category')->paginate()]);
    }

    public function newIncome()
    {
        return view('income.newIncome', [
            'incomeCategories' => IncomeCategory::pluck('name', 'id'),
            'customers' => Customer::pluck('name_customer', 'id')

        ]);
    }

    public function insertIncome(CreateIncomeRequest $request)
    {
        $data = $request->validated();
        $data['document'] = ($request->hasFile('document')) ?
            $request->file('document')->store('documents', 'public') : '';
        $income = Income::create($data);
        return redirect('/admin/ingresos');
        return redirect('/admin/gastos/' . $income->id . '/editar');
    }

    public function editIncome($id)
    {
        $incomeCategories = IncomeCategory::pluck('name', 'id');
        $customers = Customer::pluck('name_customer', 'id');
        $income = Income::findOrFail($id)->load('partials');
        Session()->flash('IncomeId', $id);
        return view('income.editIncome', compact('incomeCategories', 'customers', 'income'));
    }

    public function updateIncome(CreateIncomeRequest $request)
    {
        $income = Income::findOrFail(session('IncomeId'));
        $data = $request->validated();
        $data['document'] = ($request->hasFile('document')) ?
            $request->file('document')->store('documents', 'public') : '';

        $income->fill($data)->save();
        return redirect('/admin/ingresos/' . $income->id . '/editar');
    }

    public function partialIncome(CreatePartialIncomeRequest $request)
    {
        return ['success' => 1, 'partial' => IncomePartial::create($request->validated())];
    }

    public function deleteIncome(Request $request)
    {
        $expense = Income::findOrFail($request->input('id'));
        $expense->delete();
        return redirect('/admin/ingresos')->with(['success' => '¡Gasto eliminado Elimado!']);
    }

    public function deletePartialIncome(Request $request)
    {
        $expense = IncomePartial::findOrFail($request->input('idPartial'));
        $expense->delete();
        return back()->with(['message' => 'Pago eliminado']);
    }

}

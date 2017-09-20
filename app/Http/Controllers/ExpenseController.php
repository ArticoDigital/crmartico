<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateExpenseRequest;
use App\Http\Requests\CreatePartialExpesesRequest;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\ExpensePartial;
use App\Models\Provider;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function expenses()
    {
        return view('expenses.expenses', ['expenses' => Expense::with('category')->paginate()]);
    }

    public function newExpense()
    {
        $expenseCategories = ExpenseCategory::pluck('name', 'id');
        $providers = Provider::pluck('name', 'id');
        session()->flash('status', 0);
        return view('expenses.newExpense', compact('expenseCategories', 'providers'));
    }

    public function insertExpense(CreateExpenseRequest $request)
    {
        $data = $request->validated();
        $data['document'] = ($request->hasFile('document')) ?
            $request->file('document')->store('documents', 'public') : '';
        $data['status'] = session('status');
        $expense = Expense::create($data);
        return redirect('/admin/gastos/' . $expense->id . '/editar');
    }

    public function editExpense($id)
    {
        $expenseCategories = ExpenseCategory::pluck('name', 'id');
        $providers = Provider::pluck('name', 'id');
        $expense = Expense::findOrFail($id)->load('partials');

        Session()->flash('ExpenseId', $id);
        return view('expenses.editExpense', compact('expenseCategories', 'providers', 'expense'));
    }

    public function updateExpense(CreateExpenseRequest $request)
    {
        $expense = Expense::findOrFail(session('ExpenseId'));
        $data = $request->validated();
        $data['document'] = ($request->hasFile('document')) ?
            $request->file('document')->store('documents', 'public') : '';

        $expense->fill($data)->save();

        return redirect('/admin/gastos/' . $expense->id . '/editar');
    }

    public function deleteExpense(Request $request)
    {
        $expense = Expense::findOrFail($request->input('id'));
        $expense->delete();
        return redirect('/admin/gastos')->with(['success' => '¡Gasto eliminado Elimado!']);
    }

    public function partialExpense(CreatePartialExpesesRequest $request)
    {
        return ['success' => 1,'partial' => ExpensePartial::create($request->validated())];
    }

    public function deletePartialExpense(Request $request){
        $expense = ExpensePartial::findOrFail($request->input('idPartial'));
        $expense->delete();
        return back()->with(['message' => 'Pago eliminado']);
    }

}

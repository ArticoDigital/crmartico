<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductRequest;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function products()
    {
        return view('products.products', ['products' => Product::paginate()]);
    }

    public function newProduct()
    {
        return view('products.newProduct', ['categories' => ProductCategory::pluck('name', 'id')]);
    }

    public function insertProduct(CreateProductRequest $request)
    {
        Product::create($request->validated());
        return redirect('/admin/productos')->with(['success' => '¡Producto Creado!']);
    }

    public function editProduct($id)
    {
        Session()->flash('userId', $id);
        $product = Product::findOrFail($id);
        $categories = ProductCategory::pluck('name', 'id');
        return view('products.editProduct', compact('product', 'categories'));
    }

    public function updateProduct(CreateProductRequest $request)
    {
        $product = Product::findOrFail(session('userId'));
        $product->fill($request->validated())->save();
        return back()->with(['success' => '¡Producto Actualizado!']);
    }

    public function deleteProduct(Request $request)
    {
        $product = Product::find($request->input('id'));
        $product->delete();
        return redirect('/admin/productos')->with(['success' => '¡Productos Elimado!']);
    }
}

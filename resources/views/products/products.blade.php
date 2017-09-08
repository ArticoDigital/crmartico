@extends('layouts.back')
@section('title', 'Agencia de Publicidad en Bogotá')

@section('content')
    <div class="col-16 row TitleBar">
        <a class="TitleBar-navLink active" href="productos">Productos</a>
    </div>
    <div class="Table-title row">
        <a class="Button Button-blue" href="/admin/productos/nuevo">Nuevo producto</a>
        <input placeholder="Buscar proveedor" type="search" class="Search">
    </div>
    <section class="Table">
        <div class="Table-header row around ">
            <div class="col-1">N.º</div>
            <div class="col-3">Nombre</div>
            <div class="col-4">Descripción</div>
            <div class="col-2 alignRight">unidad</div>
            <div class="col-1 alignRight">IVA</div>
            <div class="col-3 alignRight">Precio</div>
            <div class="col-2 alignRight">Precio + IVA</div>
        </div>
        @foreach($products as $product)
            <a href="/admin/productos/{{$product->id}}/editar" class="Table-row row around ">
                <div class="col-1">{{$product->id}}</div>
                <div class="col-3">{{$product->name}}</div>
                <div class="col-4">{{$product->description}}</div>
                <div class="col-2 alignRight">{{$product->unity}}</div>
                <div class="col-1 alignRight">{{$product->iva}}%</div>
                <div class="col-3 alignRight">{{$product->net_price}}</div>
                <div class="col-2 alignRight">{{$product->gross_price_with_iva}}</div>
            </a>
        @endforeach
    </section>
@endsection
@section('scripts')
@endsection
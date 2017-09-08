@extends('layouts.back')
@section('title', 'Agencia de Publicidad en Bogotá')

@section('content')
    <div class="col-16 row TitleBar">
        <a class="TitleBar-navLink " href="clientes">Clientes</a>
        <a class="TitleBar-navLink active" href="proveedores">Proveedores</a>
    </div>
    <div class="Table-title row">
        <a class="Button Button-blue" href="/admin/proveedores/nuevo">Nuevo proveedor</a>
        <input placeholder="Buscar proveedor" type="search" class="Search">
    </div>
    <section class="Table">
        <div class="Table-header row around ">
            <div class="col-4">Nombre</div>
            <div class="col-3">E-mail</div>
            <div class="col-3">Celular</div>
            <div class="col-3">Dirección</div>
            <div class="col-3">Servicio</div>
        </div>
        @foreach($providers as $provider)
            <a href="/admin/proveedores/{{$provider->id}}/editar" class="Table-row row around ">
                <div class="col-4">{{$provider->name}}</div>
                <div class="col-3">{{$provider->email}}</div>
                <div class="col-3">{{$provider->cellphone}}</div>
                <div class="col-3 ">{{$provider->address}}</div>
                <div class="col-3 ">{{$provider->position}}</div>
            </a>
        @endforeach
    </section>
@endsection
@section('scripts')
@endsection
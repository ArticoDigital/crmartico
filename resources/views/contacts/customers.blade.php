@extends('layouts.back')
@section('title', 'Agencia de Publicidad en Bogotá')

@section('content')
    <div class="col-16 row TitleBar">
        <a class="TitleBar-navLink active" href="clientes">Clientes</a>
        <a class="TitleBar-navLink " href="proveedores">Proveedores</a>
    </div>
    <div class="Table-title row">
        <a class="Button Button-blue" href="/admin/clientes/nuevo">Nuevo cliente</a>
        <input placeholder="Buscar cliente" type="search" class="Search">
    </div>
    <section class="Table">

        <div class="Table-header row around ">
            <div class="col-3">Nombre</div>
            <div class="col-3">Dirección</div>
            <div class="col-3">Contacto</div>
            <div class="col-3">Email</div>
            <div class="col-3 ACenter">Celular</div>
        </div>
        @foreach($customers as $customer)
            <a href="/admin/clientes/{{$customer->id}}/editar" class="Table-row row around ">
                    <div class="col-3">{{$customer->name_customer}}</div>
                    <div class="col-3">{{$customer->address}}</div>
                    <div class="col-3">{{$customer->contacts->first()->name}}</div>
                    <div class="col-3">{{$customer->contacts->first()->email}}</div>
                    <div class="col-3 ACenter">{{$customer->contacts->first()->cellphone}}</div>
            </a>
        @endforeach
    </section>
@endsection
@section('styles')
    @if(session('success'))
        <link rel="stylesheet" href="{{url('css/sweetalert.css')}}">
    @endif
@endsection
@section('scripts')
    @if(session('success'))
        <script src="{{url('js/sweetalert.min.js')}}"></script>
        <script>
            swal({{session('success')}}, "", "success")
        </script>
    @endif
@endsection
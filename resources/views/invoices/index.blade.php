@extends('layouts.back')
@section('title', 'Agencia de Publicidad en Bogotá')

@section('content')
    @if(session('ok'))
        {{session()->get('ok')}}
    @endif


    <div class="col-16 row TitleBar">
        <a class="TitleBar-navLink active" href="facturas">Facturas</a>
        <a class="TitleBar-navLink " href="/admin/ingresos">Otros ingresos</a>
    </div>
    <div class="Table-title row">
        <a class="Button Button-blue" href="/admin/facturas/nueva">Nueva factura</a>
        <input placeholder="Buscar facturas" type="search" class="Search">
    </div>
    <section class="Table">
        <div class="Table-header row around ">
            <div class="col-2">Nº</div>
            <div class="col-3">Estado</div>
            <div class="col-4">Cliente</div>
            <div class="col-2 ACenter">Fecha</div>
            <div class="col-2 ACenter">Vencimiento</div>
            <div class="col-2 ARight">Importe</div>
            <div class="col-1"></div>
        </div>
        <div >
            @foreach($invoices as $invoice)
                <a href="/admin/facturas/{{$invoice->id}}/editar" class="Table-row row around ">
                    <div class="col-2">{{$invoice->number}}</div>
                    <div class="col-3">{{$invoice->state->name}}</div>
                    <div class="col-4">{{$invoice->customer->name_customer}}</div>
                    <div class="col-2 ACenter">{{$invoice->date}}</div>
                    <div class="col-2 ACenter">{{$invoice->due_date}}</div>
                    <div class="col-2 ARight"></div>
                    <div class="col-1"></div>
                </a>
            @endforeach
        </div>
    </section>
@endsection
@section('scripts')
@endsection
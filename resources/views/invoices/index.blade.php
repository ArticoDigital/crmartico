@extends('layouts.back')
@section('title', 'Agencia de Publicidad en Bogotá')

@section('content')
        <div class="col-16 row TitleBar">
                <a class="TitleBar-navLink active" href="facturas">Facturas</a>
                <a class="TitleBar-navLink " href="gastos">Otros ingresos</a>
        </div>
        <div class="Table-title row">
                <a class="Button Button-blue" href="/admin/facturas/nueva">Nueva factura</a>
                <input placeholder="Buscar facturas" type="search" class="Search">
        </div>
        <section class="Table">
                <div class="Table-header row around ">
                        <div class="col-2">Estado</div>
                        <div class="col-3">Nº</div>
                        <div class="col-4">Cliente</div>
                        <div class="col-2 ACenter">Fecha</div>
                        <div class="col-2 ACenter">Vencimiento</div>
                        <div class="col-2 ARight">Importe</div>
                        <div class="col-1"></div>
                </div>
                <div class="Table-row row around ">
                        <div class="col-2">Parcial</div>
                        <div class="col-3">3</div>
                        <div class="col-4">Lilipink</div>
                        <div class="col-2 ACenter">24.02.2017</div>
                        <div class="col-2 ACenter">24.02.2017</div>
                        <div class="col-2 ARight">10.000</div>
                        <div class="col-1"></div>
                </div>
        </section>
@endsection
@section('scripts')
@endsection
@extends('layouts.back')
@section('title', 'Agencia de Publicidad en Bogotá')

@section('content')
    @if(session('ok'))
        {{session()->get('ok')}}
    @endif


    <div class="col-16 row TitleBar">
        <a class="TitleBar-navLink " href="/admin/facturas">Facturas</a>
        <a class="TitleBar-navLink active" href="/admin/ingresos">Otros ingresos</a>
    </div>
    <div class="Table-title row">
        <a class="Button Button-blue" href="/admin/ingresos/nuevo">Nuevo ingreso</a>
        <input placeholder="Buscar ingreso" type="search" class="Search">
    </div>
    <section class="Table">
        <div class="Table-header row around ">
            <div class="col-3">Nº</div>
            <div class="col-3">Categoria</div>
            <div class="col-3">Fecha</div>
            <div class="col-3 ARight">Importe</div>
            <div class="col-3 ARight">Pendiente</div>
        </div>
        @foreach($incomes as $income)
            <a href="/admin/ingresos/{{$income->id}}/editar" class="Table-row row around ">
                <div class="col-3">{{$income->id}}</div>
                <div class="col-3">{{$income->category->name}}</div>
                <div class="col-3">{{$income->date}}</div>
                <div class="col-3 ARight">{{$income->amount}}</div>
                <div class="col-3 ARight pending">{{$income->pending}}</div>
            </a>
        @endforeach
    </section>
@endsection
@section('scripts')
    <script src="{{asset('/js/numeral.min.js')}}"></script>
    <script>
        actionsClass(document.querySelectorAll('.pending'), function (el) {
            el.innerHTML = numeral(el.textContent).format('$0,0.00')
        })

        function actionsClass(array, callback, scope) {

            [].map.call(array, function (el) {
                callback.call(scope, el, array[el]);
            });
        };
    </script>
@endsection
@extends('layouts.back')
@section('title', 'Agencia de Publicidad en Bogotá')

@section('content')
    <div class="col-16 row TitleBar">
        <a class="TitleBar-navLink active" href="">Gastos</a>
    </div>
    <div class="Table-title row">
        <a class="Button Button-blue" href="/admin/gastos/nuevo">Nuevo gasto</a>
        <input placeholder="Buscar gasto" type="search" class="Search">
    </div>
    <section class="Table">

        <div class="Table-header row around ">
            <div class="col-3">Nº</div>
            <div class="col-3">Categoria</div>
            <div class="col-3">Fecha</div>
            <div class="col-3 ARight">Importe</div>
            <div class="col-3 ARight">Pendiente</div>
        </div>
        @foreach($expenses as $expense)
            <a href="/admin/gastos/{{$expense->id}}/editar" class="Table-row row around ">
                    <div class="col-3">{{$expense->id}}</div>
                    <div class="col-3">{{$expense->category->name}}</div>
                    <div class="col-3">{{$expense->date}}</div>
                    <div class="col-3 ARight">{{$expense->amount}}</div>
                    <div class="col-3 ARight pending">{{$expense->pending}}</div>
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

    @if(session('success'))
        <script src="{{url('js/sweetalert.min.js')}}"></script>
        <script>
            swal({{session('success')}}, "", "success")
        </script>
    @endif
@endsection
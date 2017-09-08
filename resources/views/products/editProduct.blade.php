@extends('layouts.back')
@section('title', 'Agencia de Publicidad en Bogotá')

@section('content')
    <form action="/admin/productos/eliminar" method="post" id="formDelete">
        {{csrf_field()}}
        <input type="hidden" name="id" value="{{$product->id}}">
    </form>
    <div class="col-16 row TitleBar">
        <a class="TitleBar-navLink " href="/admin/productos"> ← Productos</a>
    </div>
    <div class="Table-title row between middle">
        <h1>{{$product->name}}</h1>
        <div class="row">
            <button id="deleteProduct" class="Button Button-red">Eliminar</button>
            <button id="submit" class="Button Button-blue">Guardar</button>
        </div>
    </div>
    <section class="Invoice">
        @if($errors->any())
            <div class="Errors">
                @foreach($errors->all() as $error)
                    <div>
                        {{$error}}
                    </div>
                @endforeach
            </div>
        @endif
        <form action="/admin/productos/editar" method="post" id="FormProduct">
            {{ csrf_field() }}
            <article class="Invoice-area">
                <h3>Datos básicos</h3>
                <div class="row arrow between">
                    <div class="col-7">
                        <label for="name">
                            <span>Nombre del producto</span>
                            <input type="text" id="name" name="name" placeholder="Introduce el nombre"
                                   value="{{old('name')?old('name'):$product->name}}">
                        </label>
                        <div class="row between">
                            <label id="product_category_id" class="col-7 Label-select"><span>Categoria</span>
                                <select name="product_category_id" id="product_category_id">
                                    <option value="">Elije una categoria</option>
                                    @foreach($categories as $key => $category )
                                        <option
                                                value="{{$key}}"
                                                {{(old('product_category_id') == $key)?'selected':
                                                (($product->product_category_id == $key) ?'selected': '')}}
                                        >
                                            {{$category}}
                                        </option>
                                    @endforeach
                                </select>
                            </label>
                            <label id="unity" class="col-7 Label-select"><span>Unidad</span>
                                <select name="unity" id="">
                                    <option value="">Elige una opción</option>
                                    <option value="1"
                                            {{((old('unity') == 1) ?
                                            'selected':(($product->unity == 1)?'selected':''))}}
                                    >Ninguno</option>
                                    <option value="2"
                                            {{((old('unity') == 2) ?
                                            'selected':(($product->unity == 2)?'selected':''))}}>Mes</option>
                                    <option value="3"
                                            {{((old('unity') == 3) ?
                                            'selected':(($product->unity == 3)?'selected':''))}}
                                    >Unidad</option>
                                </select>
                            </label>
                        </div>
                        <label for="description"><span>Descripción </span>
                            <textarea placeholder="Introduce la descripción del producto"
                                      name="description"
                            >{{old('description')?old('description'):$product->description}}</textarea>
                        </label>
                    </div>
                    <div class="col-7">
                        <div class="row between">
                            <label for="net_price" class="col-16 "><span> Precio (sin IVA) </span>
                                <input type="text" id="net_price" name="net_price" class="alignRight"
                                       placeholder="Ingrese el precio $100.000"
                                       value="{{old('net_price')?old('description'):$product->net_price}}">
                            </label>
                        </div>
                        <div class="row between">
                            <label id="" class="col-7 Label-select"><span>IVA</span>
                                <select name="iva" id="iva">
                                    <option value="">Elige una opción</option>
                                    <option value="0"
                                            {{(old('iva') == '0')?
                                            'selected' :(($product->iva == '0')?'selected':'')}}
                                    >0%
                                    </option>
                                    <option value="9"
                                            {{(old('iva') == '9')?
                                            'selected' :(($product->iva == '9')?'selected':'')}}
                                    >9%
                                    </option>
                                    <option value="16"
                                            {{(old('iva') == '16')?
                                            'selected' :(($product->iva == '16')?'selected':'')}}
                                    >16%</option>
                                    <option value="19"
                                            {{(old('iva') == '19')?
                                            'selected' :(($product->iva == '19')?'selected':'')}}>19%
                                    </option>
                                </select>
                            </label>
                            <label for="gross_price_with_iva" class="col-7 "><span> Precio bruto (con IVA) </span>
                                <input type="text" name="gross_price_with_iva" id="gross_price_with_iva" readonly
                                       class="alignRight"
                                       value="{{old('gross_price_with_iva')?
                                       old('gross_price_with_iva'):$product->gross_price_with_iva}}">
                            </label>
                        </div>
                        <div class="row between">
                            <label for="cost_price" class="col-16 "><span> Precio de coste </span>
                                <input type="text" name="cost_price" class="alignRight" id="cost_price"
                                       placeholder="Ingrese el precio de coste"
                                       value="{{old('cost_price')?old('cost_price'):$product->cost_price}}">
                            </label>
                        </div>
                    </div>
                </div>
            </article>

        </form>
    </section>
@endsection
@section('scripts')
    <script src="{{asset('/js/numeral.min.js')}}"></script>
    <script>
        const price = document.querySelector('#net_price'),
            costPrice = document.querySelector('#cost_price'),
            priceIva = document.querySelector('#gross_price_with_iva'),
            iva = document.querySelector('#iva');

        iva.addEventListener('change', changePrice);
        costPrice.addEventListener('blur', function () {
            this.value = (this.value) ? numeral(this.value).format('$0,0') : '';
        })
        price.addEventListener('blur', function () {
            this.value = numeral(this.value).format('$0,0');
            changePrice();
        })

        function changePrice() {
            var ivaPer = numeral(iva.options[iva.selectedIndex].value).value(),
                priceVal = numeral(price.value).value();
            priceIva.value = numeral(priceVal * (  1 + (ivaPer / 100))).format('$0,0');
        }

        document.querySelector('#submit').addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelector('#FormProduct').submit();
        });
        document.querySelector('#deleteProduct').addEventListener('click', function () {
            swal({
                title: "¿Estás seguror de eliminar este cliente?",
                text: "Una vez eliminado, no podrá recuperarlo",
                icon: "warning",
                buttons: ["No, cancelar!", "Si, eliminalo!"],
                dangerMode: true,
            }).then(function (isConfirm) {
                if (isConfirm) {
                    document.querySelector('#formDelete').submit();
                }

            });

        })
    </script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@endsection
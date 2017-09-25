@extends('layouts.back')
@section('title', 'Agencia de Publicidad en Bogotá')

@section('content')
    <div class="col-16 row TitleBar">
        <a class="TitleBar-navLink " href="/admin/facturas"> ← Facturas</a>
    </div>
    <div class="Table-title row between middle">
        <h1>Nueva factura</h1>
        <div class="row">
            <a href="" class="Button-Transparent">... Más</a>
            <a href="" class="Button-Transparent">Guardar</a>
            <a href="" class="Button-Transparent">Mostrar</a>
            <a href="" class="Button Button-blue">Terminar y ver factura</a>
        </div>
    </div>
    <section class="Invoice">
        <form action="" method="post">
            <article class="Invoice-area">
                <h3>Clientes y fechas</h3>
                <div class="row arrow between">
                    <div class="col-7">

                        <label for="client">
                            <span>Cliente</span>
                            <input type="text" name="customer" id="customer" placeholder=""
                                   value="{{old('customer')}}">
                            <input type="hidden" name="customer_id" id="customerId" value="{{old('customer_id')}}">
                            <a class=" marginTop-20 Button Button-Transparent" href="/admin/clientes/nuevo">
                                Crear un cliente</a>
                        </label>
                        <div class=" marginTop-20">
                            <label for="address"><span>Dirección</span>
                                <textarea name="address" id="address"
                                          placeholder="Introduce la dirección completa del cliente"></textarea>
                            </label>
                        </div>
                    </div>
                    <div class="col-7">
                        <div class="row between">
                            <label for="date" class="col-7 "><span>Fecha de factura</span>
                                <input type="date" name="date" placeholder="">
                            </label>
                            <label for="number" class="col-7"><span>N.º de factura</span>
                                <input type="text" name="number" class="alignRight">
                            </label>
                        </div>
                        <div class="row between">
                            <label id="payment_conditions" class="col-7"><span>Condiciones de pago</span>
                                <select name="payment_conditions" id="">
                                    <option value="">A 14 días</option>
                                    <option value="">A 30 días</option>
                                    <option value="">A 8 días</option>
                                    <option value="">Pagado</option>
                                </select>
                            </label>
                            <label for="due_date" class="col-7"><span>Fecha de vencimiento</span>
                                <input type="date" name="date" placeholder="">
                            </label>
                        </div>

                        <label for="note">
                            <span>Nota</span>
                            <textarea name="note" placeholder="Introduce un mensaje para el cliente"></textarea>
                        </label>
                    </div>
                </div>
            </article>
            <article class="Invoice-borderTop">
                <h3>Líneas de facturas</h3>
                <div id="items">

                    <div class="row middle Invoice-product products">
                        <div class="move">
                            <img src="{{url('/img/move.png')}}" alt="">
                        </div>
                        <label for="product0Name" class="col-6">
                            <span>Producto</span>
                            <input id="product0Name" type="text" name="producto[0][name]">
                            <input id="product0Id" type="hidden" name="producto[0][product_id]">
                        </label>
                        <label for="producto0Quantity" class="col-2">
                            <span>Cantidad</span>
                            <input id="producto0Quantity" type="text" name="producto[0][quantity]" class="alignRight">
                        </label>

                        <label for="producto0Discount" class="col-2">
                            <span>Descuento</span>
                            <input type="text" id="producto0Discount" name="producto[0][discount]" class="alignRight">
                        </label>
                        <label for="producto0Net_price" class="col-2">
                            <span>Precio (neto)</span>
                            <input id="producto0Net_price" type="text" name="producto[0][net_price]" class="alignRight">
                        </label>
                        <label for="producto0Iva" class="col-2">
                            <span>IVA</span>
                            <input id="producto0Iva" type="text" name="producto[0][iva]">
                        </label>
                        <label for="" class="col-2">
                            <span>Importe (neto)</span>
                            <input type="text" class="alignRight" readonly>
                        </label>
                        <label for="producto0Description" class="col-10">
                            <span>Descripción</span>
                            <input id="producto0Description" type="text" name="producto[0][description]">
                        </label>
                        <div class="Invoice-tax row">
                            <input type="checkbox" name="producto[0][withholding_tax]" id="invoicetax">
                            <label for="invoicetax" class="Invoice-taxLabel">Aplica retenciones a la fuente (11,00
                                %)</label>
                        </div>
                    </div>
                </div>
                <div class="row marginTop-20" id="Buttons">
                    <a id="addProduct" class="Button Button-Transparent">Agregar un producto</a>
                </div>
            </article>
            <article class="Invoice-borderTop row">
                <div class="col-9">
                    <h3>Totales</h3>
                </div>
                <div class="col-7 row between Invoice-total">
                    <div class="col-9">
                        <p>Retenciones -11 % de 10.000.000,00</p>
                        <p>IVA 19 % de 10.000.000,00</p>
                        <p>Retenciones -11 % de 1.000.000,00</p>
                        <p>Total COP</p>
                    </div>
                    <div class="col-7" style="text-align: right">
                        <p> 1.000.000,00</p>
                        <p> 190.000,00</p>
                        <p> -110.000,00</p>
                        <p> 1.080.000,00</p>
                    </div>
                </div>
            </article>
            <article class="Invoice-borderTop row">
                <h3>Términos</h3>
                <textarea placeholder="Introduce términos, Resolución de facturación DIAN,
                instrucciones de pago u otras notas adicionales"></textarea>
            </article>
        </form>
        <datalist id="customers">
            @foreach($customers as $customer)
                <option
                        data-id="{{$customer->id}}"
                        data-address="{{$customer->address}}" value="{{$customer->name_customer}}">
                </option>
            @endforeach
        </datalist>
        <datalist id="productsList">
            @foreach($products as $product)
                <option
                        data-id="{{$product->id}}"
                        data-name="{{$product->name}}"
                        data-price="{{$product->net_price}}"
                        data-description="{{$product->description}}"
                        data-iva="{{$product->iva}}"
                >
                </option>


            @endforeach
        </datalist>
    </section>

@endsection
@section('scripts')

    <script src="{{url('js/auto-complete.min.js')}}"></script>
    <script src="{{url('js/CompleteGenerateV2.js')}}"></script>
    <script src="{{url('js/sortable.min.js')}}"></script>
    <script>
        var el = document.getElementById('items');
        var sortable = Sortable.create(el, {
            animation: 150,
            handle: '.move'
        });

        completeGenerate(
            {
                selector: '#customer',
                elements: '#customers',
                selectorId: '#customerId',
                'inputsValue': ['value', 'data-id', 'data-address'],
                onSelect: function (e, term, item) {
                    document.querySelector('#customer').value = item.getAttribute('data-name');
                    document.querySelector('#customerId').value = item.getAttribute('data-id');
                    document.querySelector('#address').value = item.getAttribute('data-address');

                },
                onHtml: function (item, re) {
                    return '<div class="autocomplete-suggestion" ' +
                        'data-address="' + item[2] + '" ' +
                        'data-name="' + item[0] + '" ' +
                        'data-id="' + item[1] + '"> ' + item[0].replace(re, "<b>$1</b>") + '</div>';
                },
            });


        completeGenerate(
            {
                selector: '#product0Name',
                elements: '#productsList',
                selectorId: '#product0Id',
                'inputsValue': ['data-name', 'data-id', 'data-price', 'data-description', 'data-iva'],
                onSelect: function (e, term, item) {
                    document.querySelector('#product0Name').value = item.getAttribute('data-name');
                    document.querySelector('#product0Id').value = item.getAttribute('data-id');
                    document.querySelector('#producto0Net_price').value = item.getAttribute('data-price');
                    document.querySelector('#producto0Description').value = item.getAttribute('data-description');
                    document.querySelector('#producto0Iva').value = item.getAttribute('data-iva');
                },
                onHtml: function (item, re) {
                    return '<div class="autocomplete-suggestion" ' +
                        'data-description="' + item[3] + '" ' +
                        'data-name="' + item[0] + '" ' +
                        'data-price="' + item[2] + '" ' +
                        'data-iva="' + item[4] + '" ' +
                        'data-id="' + item[1] + '"> ' + item[0].replace(re, "<b>$1</b>") + '</div>';
                },
                clear: function (e, t) {
                    if (document.querySelector(t.opts.selectorId).value == '') {
                        document.querySelector('#product0Name').value = '';
                        document.querySelector('#producto0Net_price').value = '';
                        document.querySelector('#producto0Description').value = '';
                        document.querySelector('#producto0Iva').value = '';
                    }
                }
            });

        var item = 1;
        const items = document.querySelector('#items'),
            buttons = document.querySelector('#Buttons');
        document.querySelector('#addProduct').addEventListener('click', function (e) {
            e.preventDefault();
            var parser = new DOMParser();
            var domString = ' <div class="row middle Invoice-product products" id="product-' + item + '">' +
                '<div class="move">' +
                '<img src="/img/move.png" alt="">' +
                '</div>' +

                '<label for="product' + item + 'Name" class="col-6">' +
                ' <span>Producto</span>' +
                '<input id="product' + item + 'Name" type="text" name="producto[' + item + '][name]">' +
                '<input id="product' + item + 'Id" type="hidden" name="producto[' + item + '][product_id]">' +
                '</label>' +
                ' <label for="producto' + item + 'Quantity" class="col-2">' +
                ' <span>Cantidad</span>' +
                '<input id="producto' + item + 'Quantity" type="text" name="producto[' + item + '][quantity]" class="alignRight">' +
                '</label>' +

                '<label for="producto' + item + 'Discount" class="col-2">' +
                '<span>Descuento</span>' +
                '<input type="text" id="producto' + item + 'Discount" name="producto[' + item + '][discount]" class="alignRight">' +
                '</label>' +
                '<label for="producto' + item + 'Net_price" class="col-2">' +
                '<span>Precio (neto)</span>' +
                '<input id="producto' + item + 'Net_price" type="text" name="producto[' + item + '][net_price]" class="alignRight">' +
                '</label>' +
                '<label for="producto' + item + 'Iva" class="col-2">' +
                '<span>IVA</span>' +
                '<input id="producto' + item + 'Iva" type="text" name="producto[' + item + '][iva]">' +
                '</label>' +
                '<label for="" class="col-2">' +
                '<span>Importe (neto)</span>' +
                '<input type="text" class="alignRight" readonly>' +
                '</label>' +
                '<label for="producto' + item + 'Description" class="col-10">' +
                '<span>Descripción</span>' +
                '<input id="producto' + item + 'Description" type="text" name="producto[' + item + '][description]">' +
                '</label>' +
                '<div class="Invoice-tax row">' +
                '<input type="checkbox" name="producto[' + item + '][withholding_tax]" id="invoicetax">' +
                '<label for="invoicetax" class="Invoice-taxLabel">Aplica retenciones a la fuente (11,00' +
                '%)</label>' +
                '</div>' +
                '</div>';
            var html = parser.parseFromString(domString, 'text/html');
            items.append(html.body.firstChild);

            completeGenerate(
                {
                    selector: '#product' + item + 'Name',
                    elements: '#productsList',
                    selectorId: '#product' + item + 'Id',
                    'inputsValue': ['data-name', 'data-id', 'data-price', 'data-description', 'data-iva'],
                    number: item,
                    onSelect: function (e, term, item, number) {
                        document.querySelector('#product' + number + 'Name').value = item.getAttribute('data-name');
                        document.querySelector('#product' + number + 'Id').value = item.getAttribute('data-id');
                        document.querySelector('#producto' + number + 'Net_price').value = item.getAttribute('data-price');
                        document.querySelector('#producto' + number + 'Description').value = item.getAttribute('data-description');
                        document.querySelector('#producto' + number + 'Iva').value = item.getAttribute('data-iva');
                    },
                    onHtml: function (item, re) {
                        return '<div class="autocomplete-suggestion" ' +
                            'data-description="' + item[3] + '" ' +
                            'data-name="' + item[0] + '" ' +
                            'data-price="' + item[2] + '" ' +
                            'data-iva="' + item[4] + '" ' +
                            'data-id="' + item[1] + '"> ' + item[0].replace(re, "<b>$1</b>") + '</div>';
                    },
                    clear: function (e, t, number) {
                        if (document.querySelector(t.opts.selectorId).value == '') {
                            document.querySelector('#product' + number + 'Name').value = '';
                            document.querySelector('#producto' + number + 'Net_price').value = '';
                            document.querySelector('#producto' + number + 'Description').value = '';
                            document.querySelector('#producto' + number + 'Iva').value = '';
                        }
                    }
                });
            item++;
            actionsClass(document.querySelectorAll('.move'), function (el) {
                el.classList.add('active')
                console.log(el)
            })
            if (item == 2) {

                var buttonDelete = document.createElement('button');
                buttonDelete.innerText = 'Eliminar producto'
                buttonDelete.className = "Button Button-Transparent"
                buttonDelete.onclick = deleteProduct;
                buttonDelete.id = "deleteProduct";
                buttons.append(buttonDelete);
            }
        })

        function deleteProduct(e) {
            e.preventDefault();
            item--;
            var elem = document.querySelector("#product-" + item);
            elem.remove();
            if (item == 1) {
                document.getElementById("deleteProduct").remove();
                actionsClass(document.querySelectorAll('.move'), function (el) {
                    el.classList.remove('active')
                })
            }
        }

        if (document.getElementById('deleteProduct') != null) {
            document.getElementById("deleteProduct").addEventListener('click', deleteProduct)
        }
        function actionsClass(array, callback, scope) {

            [].map.call(array, function (el) {
                callback.call(scope, el, array[el]);
            });
        };
    </script>
@endsection

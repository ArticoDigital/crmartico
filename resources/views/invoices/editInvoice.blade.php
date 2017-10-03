@extends('layouts.back')
@section('title', 'Agencia de Publicidad en Bogotá')

@section('content')
    <div class="col-16 row TitleBar">
        <a class="TitleBar-navLink " href="/admin/facturas"> ← Facturas</a>
    </div>
    <div class="Table-title row between middle">
        <h1>Factura</h1>
        <div class="row">
            <a class="Button-Transparent">Mostrar</a>
            <a id="submit" class="Button Button-blue">Guardar</a>
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

        <form action="/admin/facturas/nueva" method="post" id="newInvoice">
            {{csrf_field()}}
            <article class="Invoice-area">
                <h3>Clientes y fechas</h3>
                <div class="row arrow between">
                    <div class="col-7">

                        <label for="client">
                            <span>Cliente</span>
                            <input type="text" name="customer" id="customer" placeholder=""
                                   value="{{old('customer')?old('customer'):$invoice->customer->name_customer}}">
                            <input type="hidden" name="customer_id" id="customerId"
                                   value="{{old('customer_id')?old('customer_id'):$invoice->customer->name_customer}}">
                            <a class=" marginTop-20 Button Button-Transparent" href="/admin/clientes/nuevo">
                                Crear un cliente</a>
                        </label>
                        <div class=" marginTop-20">
                            <label for="address"><span>Dirección</span>
                                <textarea name="address" id="address"
                                          placeholder="Introduce la dirección completa del cliente">{{old('address')?old('address'):$invoice->address}}</textarea>
                            </label>
                        </div>
                    </div>
                    <div class="col-7">
                        <div class="row between">
                            <label for="date" class="col-7 "><span>Fecha de factura</span>
                                <input type="date" name="date" placeholder="" value="{{old('date')?old('date'):$invoice->date}}">
                            </label>
                            <label for="number" class="col-7"><span>N.º de factura</span>
                                <input type="text" name="number" class="alignRight" value="{{old('number')}}">
                            </label>
                        </div>
                        <div class="row between">
                            <label id="payment_conditions" class="col-7 Label-select"><span>Condiciones de pago</span>
                                <select name="payment_conditions" id="">
                                    <option value="14" {{ (old('payment_conditions') == 14) ?'selected':'' }}>A 14
                                        días
                                    </option>
                                    <option value="30" {{ (old('payment_conditions') == 30) ?'selected':'' }}>A 30
                                        días
                                    </option>
                                    <option value="8" {{ (old('payment_conditions') == 8) ?'selected':'' }}>A 8 días
                                    </option>
                                    <option value="manual" {{ (old('payment_conditions') == 'manual') ?'selected':'' }}>
                                        Definir manualmente
                                    </option>
                                    <option value="pagado" {{ (old('payment_conditions') == 'pagado') ?'selected':'' }}>
                                        Pagado
                                    </option>
                                </select>
                            </label>
                            <label for="due_date" class="col-7"><span>Fecha de vencimiento</span>
                                <input type="date" name="due_date" value="{{old('due_date')}}">
                            </label>
                        </div>

                        <label for="note">
                            <span>Nota</span>
                            <textarea name="note"
                                      placeholder="Introduce un mensaje para el cliente">{{old('note')}}</textarea>
                        </label>
                    </div>
                </div>
            </article>
            <article class="Invoice-borderTop">
                <h3>Líneas de facturas</h3>
                @php($old = session()->getOldInput())
                @php($countProduct = ($old) ? collect( $old['product'])->count() : 1)
                <ul id="items" data-size="{{$countProduct}}">
                    @for($i = 0; $i < $countProduct; $i++)
                        <li class="row middle Invoice-product products item" draggable="true" id="product-{{$i}}">
                            <div class="move  {{($countProduct>1)?'active':''}}">
                                <img src="{{url('/img/move.png')}}" alt="">
                            </div>
                            <label for="product{{$i}}Name" class="col-6">
                                <span>Producto</span>
                                <input id="product{{$i}}Name" type="text"
                                       value="{{ ($old) ? $old['product'][$i]['name'] : '' }}"
                                       class="changeInput" name="product[{{$i}}][name]">
                                <input id="product{{$i}}Id"
                                       value="{{ ($old) ? $old['product'][$i]['product_id'] : '' }}"
                                       type="hidden" name="product[{{$i}}][product_id]">
                            </label>
                            <label for="producto{{$i}}Quantity" class="col-2">
                                <span>Cantidad</span>
                                <input
                                        value="{{ ($old) ? $old['product'][$i]['quantity'] : '1' }}" min="1"
                                        id="producto{{$i}}Quantity" type="number" name="product[{{$i}}][quantity]"
                                        class="alignRight changeInput quantity">
                            </label>

                            <label for="producto{{$i}}Discount" class="col-2">
                                <span>Descuento %</span>
                                <input type="text" id="producto{{$i}}Discount" name="product[{{$i}}][discount]"
                                       value="{{ ($old) ? $old['product'][$i]['discount'] : '0%' }}"
                                       class="percentage alignRight changeInput discount">
                            </label>
                            <label for="producto{{$i}}Net_price" class="col-2">
                                <span>Precio (neto)</span>
                                <input
                                        value="{{ ($old) ? $old['product'][$i]['net_price'] : '0%' }}"
                                        id="producto{{$i}}Net_price" type="text" name="product[{{$i}}][net_price]"
                                        class="alignRight money changeInput net_price">
                            </label>
                            <label id="producto{{$i}}Iva" class="col-2 Label-select"><span>IVA</span>
                                <select name="product[{{$i}}][iva]" id="producto{{$i}}Iva" class="changeInput iva">
                                    <option value="0" {{(($old && $old["product"][$i]["iva"])== 0)?'selected':'' }}>0%
                                    </option>
                                    <option value="5" {{(($old && $old["product"][$i]["iva"]) == 5)?'selected':''}}>5%
                                    </option>
                                    <option value="8" {{(($old && $old["product"][$i]["iva"]) == 8)?'selected':''}}>8%
                                    </option>
                                    <option value="19" {{(($old && $old["product"][$i]["iva"])== 19)?'selected':''}}>
                                        19%
                                    </option>
                                </select>
                            </label>

                            <label for="" class="col-2">
                                <span>Importe (neto)</span>
                                <input type="text" class="alignRight price" name="product[{{$i}}][price_temp]"
                                       value="{{ ($old) ? $old['product'][$i]['price_temp'] : '$0' }}"
                                       readonly>
                            </label>
                            <label for="producto{{$i}}Description" class="col-10">
                                <span>Descripción</span>
                                <input id="producto{{$i}}Description" type="text" name="product[{{$i}}][Description]"
                                       value="{{ ($old) ? $old['product'][$i]['Description'] : '' }}">
                            </label>
                            <div class="Invoice-tax row">
                                <input type="checkbox" name="product[{{$i}}][withholding_tax]" id="invoicetax">
                                <label for="invoicetax" class="Invoice-taxLabel">Aplica retenciones a la fuente (11,00
                                    %)</label>
                            </div>
                        </li>
                    @endfor
                </ul>
                <div class="row marginTop-20" id="Buttons">
                    <a id="addProduct" class="Button Button-Transparent">Agregar un producto</a>
                    @if($countProduct > 1)
                        <a class="Button Button-Transparent" id="deleteProduct">
                            Eliminar producto
                        </a>
                    @endif
                </div>
            </article>
            <article class="Invoice-borderTop row">
                <div class="col-9">
                    <h3>Totales</h3>
                </div>
                <div class="col-7 row between Invoice-total">
                    <div class="col-9">
                        <p>Subtotal</p>
                        <p>IVA</p>
                        <p>Total COP</p>
                    </div>
                    <div class="col-7" style="text-align: right">
                        <p id="subtotal">$0</p>
                        <p id="iva">$0</p>
                        <p id="total">$0</p>
                    </div>
                </div>
            </article>
            <article class="Invoice-borderTop row">
                <h3 draggable="true">Términos</h3>
                <textarea name="terms" placeholder="Introduce términos, Resolución de facturación DIAN,
                instrucciones de pago u otras notas adicionales">{{old('terms')}}</textarea>
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
    <script src="{{asset('/js/numeral.min.js')}}"></script>
    <script>
        var el = document.getElementById('items');
        Sortable.create(el, {
            animation: 150,
            handle: '.move',
            draggable: ".item",
            chosenClass: "sortable",

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
                clear: function (e, t) {
                    if (document.querySelector(t.opts.selectorId).value == '') {
                        document.querySelector('#customer').value = '';
                    }
                }
            });
        document.querySelector('#submit').addEventListener('click', function () {
            document.querySelector('#newInvoice').submit();
        })
        const items = document.querySelector('#items'),
            buttons = document.querySelector('#Buttons');
        var item = items.dataset.size;

        total();

        for (var i = 0; i < item; i++) {
            generateAutoComplete(i);
        }
        document.querySelector('#addProduct').addEventListener('click', function (e) {
            e.preventDefault();
            var parser = new DOMParser();
            var domString = ' <li class="row item middle Invoice-product products" draggable="true" id="product-' + item + '">' +
                '<div class="move">' +
                '<img src="/img/move.png" alt="">' +
                '</div>' +

                '<label for="product' + item + 'Name" class="col-6">' +
                ' <span>Producto</span>' +
                '<input class="changeInput" id="product' + item + 'Name"  type="text" name="product[' + item + '][name]" >' +
                '<input id="product' + item + 'Id" type="hidden" name="product[' + item + '][product_id]">' +
                '</label>' +
                ' <label for="producto' + item + 'Quantity" class="col-2">' +
                ' <span>Cantidad</span>' +
                '<input value="1" min="1" id="producto' + item + 'Quantity" type="number" name="product[' + item + '][quantity]" class="alignRight quantity changeInput">' +
                '</label>' +

                '<label for="producto' + item + 'Discount" class="col-2">' +
                '<span>Descuento</span>' +
                '<input type="text" value="0%" id="producto' + item + 'Discount" name="product[' + item + '][discount]" class="alignRight discount percentage changeInput">' +
                '</label>' +
                '<label for="producto' + item + 'Net_price" class="col-2">' +
                '<span>Precio (neto)</span>' +
                '<input value="$0" id="producto' + item + 'Net_price" type="text" name="product[' + item + '][net_price]" class="alignRight money net_price changeInput">' +
                '</label>' +
                '<label id="producto' + item + 'Iva" class="col-2  Label-select"><span>IVA</span>' +
                '<select name="product[' + item + '][iva]" id="producto' + item + 'Iva" class="changeInput iva">' +
                '<option value="0">0%</option>' +
                '<option value="5">5%</option>' +
                '<option value="8">8%</option>' +
                '<option value="19">19%</option>' +
                '</select>' +
                '</label>' +
                '<label for="" class="col-2">' +
                '<span>Importe (neto)</span>' +
                '<input value="$0"  type="text" class="alignRight price" readonly  name="product[' + item + '][price_temp]">' +
                '</label>' +
                '<label for="producto' + item + 'Description" class="col-10">' +
                '<span>Descripción</span>' +
                '<input  id="producto' + item + 'Description" type="text" name="product[' + item + '][Description]">' +
                '</label>' +
                '<div class="Invoice-tax row">' +
                '<input type="checkbox"  name="product[' + item + '][withholding_tax]" id="invoicetax">' +
                '<label for="invoicetax" class="Invoice-taxLabel">Aplica retenciones a la fuente (11,00' +
                '%)</label>' +
                '</div>' +
                '</li>';
            var html = parser.parseFromString(domString, 'text/html');
            items.append(html.body.firstChild);


            actionsClass(document.querySelectorAll('.changeInput'), calcInvoice)
            actionsClass(document.querySelectorAll('.percentage'), numberFormat)
            actionsClass(document.querySelectorAll('.money'), moneyFormat)

            generateAutoComplete(item)
            item++;
            actionsClass(document.querySelectorAll('.move'), function (el) {
                el.classList.add('active')
                console.log(el)
            })
            if (item == 2) {

                var buttonDelete = document.createElement('a');
                buttonDelete.innerText = 'Eliminar producto'
                buttonDelete.className = "Button Button-Transparent"
                buttonDelete.onclick = deleteProduct;
                buttonDelete.id = "deleteProduct";
                buttons.append(buttonDelete);
            }

        })

        function generateAutoComplete(item) {
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
        }

        function deleteProduct(e) {
            e.preventDefault();
            item--
            console.log(item)
            var elem = document.querySelector("#product-" + item);
            elem.remove();
            if (item == 1) {
                document.getElementById("deleteProduct").remove();
                actionsClass(document.querySelectorAll('.move'), function (el) {
                    el.classList.remove('active')
                })
            }
            total();
        }

        if (document.getElementById('deleteProduct') != null) {
            document.getElementById("deleteProduct").addEventListener('click', deleteProduct)
        }

        function actionsClass(array, callback, scope) {

            [].map.call(array, function (el) {
                callback.call(scope, el, array[el]);
            });
        };

        function calcInvoice(el) {
            el.addEventListener('blur', function () {
                var li = el.parentNode.parentNode,
                    quantity = numeral(li.querySelector('.quantity').value).value(),
                    net_price = numeral(li.querySelector('.net_price').value).value(),
                    discount = numeral(li.querySelector('.discount').value).value(),
                    price = li.querySelector('.price'),
                    value = ( net_price * quantity  ) * ( 1 - discount)

                price.value = numeral(value).format('$0,0')
                total()
            })
        }

        function total() {
            var iva = {},
                totales = 0,
                total = 0,
                ivaper = 0;
            actionsClass(document.querySelectorAll('.products'), function (el) {
                price = numeral(el.querySelector('.price').value).value()
                totales += price;

                var val = ( iva[el.querySelector('.iva').value] == null) ? 0 : iva[el.querySelector('.iva').value].priceVal,
                    priceValTemp = val + price,
                    ivaCalcTemp = priceValTemp * numeral(el.querySelector('.iva').value).value() / 100;


                iva[el.querySelector('.iva').value] = {
                    priceVal: priceValTemp,
                    ivaCalc: ivaCalcTemp
                }

            })
            Object.values(iva).forEach(function (e) {
                total += e.priceVal + e.ivaCalc
                ivaper += e.ivaCalc
            })

            document.querySelector('#total').innerHTML = numeral(total).format('$0,0')

            document.querySelector('#subtotal').innerHTML = numeral(totales).format('$0,0');
            document.querySelector('#iva').innerHTML = numeral(ivaper).format('$0,0');

        }

        function numberFormat(el) {
            el.addEventListener('blur', function () {
                el.value = numeral(el.value).format('%')
            })
        }

        function moneyFormat(el) {
            el.addEventListener('blur', function () {
                el.value = numeral(el.value).format('$0,0');
            })
        }

        actionsClass(document.querySelectorAll('.changeInput'), calcInvoice)
        actionsClass(document.querySelectorAll('.percentage'), numberFormat)
        actionsClass(document.querySelectorAll('.money'), moneyFormat)

    </script>
@endsection

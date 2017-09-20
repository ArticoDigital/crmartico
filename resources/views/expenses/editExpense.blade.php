@extends('layouts.back')
@section('title', 'Agencia de Publicidad en Bogotá')

@section('content')
    <form action="/admin/gastos/eliminar" method="post" id="formDelete">
        {{csrf_field()}}
        <input type="hidden" name="id" id="idExpense" value="{{$expense->id}}">
    </form>
    <form action="/admin/gastos/parciales/eliminar" method="post" id="formDeletePartial">
        {{csrf_field()}}
        <input type="hidden" name="idPartial" id="idPartial">
    </form>
    <div class="col-16 row TitleBar">
        <a class="TitleBar-navLink " href="/admin/gastos"> ← Gastos</a>
    </div>
    @if($expense->partials)
        <div class="Expenses-partials" id="ExpensePartial">
            <p>Cobros (pendiente: <span id="pending" data-val="{{$expense->partialSum}}"></span>)</p>
            @foreach($expense->partials as $partial)
                <div class="row middle Expenses-partial">
                    <div class="col-1 ACenter"><img src="/img/data.svg" alt=""></div>
                    <div class="col-6 "> {{$partial->description}}</div>
                    <div class="col-4 alignRight"> {{$partial->date}}</div>
                    <div class="col-4 alignRight"> {{$partial->price}}</div>
                    <div class="col-1 ACenter">
                        <button class="reset"
                                onclick="partialDelete({{$partial->id}})"><img src="/img/delete.svg" alt=""></button>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
    <div class="Table-title row between middle">
        <h1>Editar gasto</h1>

        <div class="row">
            <button id="deleteExpense" class="Button Button-red">Eliminar</button>
            @if($expense->pending)
                <button id="pay" href="" class="Button Button-blue">Pagar gasto</button>
            @endif
            <button id="submit" href="" class="Button Button-blue">Guardar</button>
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

        <form action="/admin/gastos/editar" method="post" id="expenseForm" enctype="multipart/form-data">
            {{ csrf_field() }}
            <article class="Invoice-area">
                <h3>Datos básicos</h3>
                <div class="row arrow between">
                    <div class="col-7">
                        <label for="description"><span>Descripción del gasto</span>
                            <textarea name="description" placeholder="Introduce la description del gasto"
                            >{{old('description')?old('description'):$expense->description}}</textarea>
                        </label>
                        <div class="row between">
                            <label for="provider" class="col-16 "><span>Proveedor</span>
                                <input type="text" name="provider" id="provider" placeholder=""
                                       value="{{old('provider')?old('provider'):$expense->provider->name}}">
                                <input type="hidden" name="provider_id" id="providerId"
                                       value="{{old('provider_id')?old('provider_id'):$expense->provider->id}}">
                                <a class=" marginTop-20 Button Button-Transparent" href="/admin/proveedores/nuevo">
                                    Crear un proveedor</a>
                            </label>
                        </div>
                    </div>
                    <div class="col-7">

                        <div class="row between">
                            <label id="expense_category_id" class="col-7  Label-select"><span>Categoria</span>
                                <select name="expense_category_id" id="">
                                    <option value="">Elige una opción</option>
                                    @php( $oldCat= old('expense_category_id') ?
                                    old('expense_category_id') : $expense->expense_category_id )
                                    @foreach($expenseCategories as $key => $expenseCategory)
                                        <option value="{{$key}}"
                                                {{$oldCat==$key?'selected':''}}>{{$expenseCategory}}
                                        </option>
                                    @endforeach
                                </select>
                            </label>
                            <label for="date" class="col-7"><span>Fecha</span>
                                <input type="date" name="date" placeholder=""
                                       value="{{old('date')?old('date'):$expense->date}}">
                            </label>
                        </div>
                        <div class="row between">
                            <label for="amount" class="col-7"><span>Importe</span>
                                <input type="text" id="amount" name="amount" class="alignRight"
                                       placeholder="Ingrese el precio $100.000"
                                       value="{{old('amount')?old('amount'):$expense->amount}}">
                            </label>
                            </label>
                            <label id="" class="col-7 Label-select"><span>IVA</span>
                                @php( $oldIva =  old('iva') ? old('iva') : $expense->iva )
                                <select name="iva" id="iva">
                                    <option value="">Elige una opción</option>
                                    <option value="0"
                                            {{
                                            (old('iva') == '0')?'selected' :(($expense->iva))
                                            }}>0%
                                    </option>
                                    <option value="-9" {{($oldIva == -9)?'selected':''}}>Incl 9%</option>
                                    <option value="-16" {{($oldIva == -16)?'selected':''}}>Incl 16%</option>
                                    <option value="-19" {{($oldIva == -19)?'selected' :''}}>Incl 19%</option>
                                    <option value="9" {{($oldIva == 9)?'selected':''}}>Excl 9%</option>
                                    <option value="16" {{($oldIva == 16)?'selected':''}}>Excl 16%</option>
                                    <option value="19" {{($oldIva == 19)?'selected' :''}}>Excl 19%</option>
                                </select>
                            </label>
                        </div>
                        <div class="row between">
                            <label for="withholding_tax" class="col-16"><span></span>
                                <input type="text" name="withholding_tax" id="withholding_tax" class="alignRight"
                                       placeholder="Introducir el valor de las retenciones a la fuente $100.000"
                                       value="{{old('withholding_tax')?old('withholding_tax')
                                       :$expense->withholding_tax}}">
                            </label>
                        </div>
                    </div>
                </div>
            </article>

            <article class="Invoice-borderTop row between">

                <h3 class="col-8">Documentación</h3>
                <h3 class="col-8">Totales</h3>
                <label for="note" class="col-7">
                    <span>Documento</span>
                    <input type="file" name="document">
                    @if($expense->document)
                        <a href="{{$expense->document}}"
                           target="_blank" class="Button Button-blue marginTop-20">ver archivo</a>
                    @endif
                </label>
                <div class="col-7 row between Invoice-total">
                    <div class="col-9">
                        <p>Subtotal</p>
                        <p>IVA <em id="percentage">0</em>% de <em id="percentageCalc">$0</em></p>
                        <p>Retenciones </p>
                        <p>Total COP</p>
                    </div>
                    <div class="col-7" style="text-align: right">
                        <p><em id="subtotal">{{$expense->subtotal   }}</em></p>
                        <p><em id="ivaCalc">$0</em></p>
                        <p><em id="tax">$0</em></p>
                        <p><em id="total">$0</em></p>
                    </div>
                </div>
            </article>
        </form>

    </section>
    <datalist id="providers">
        @foreach($providers as $key => $provider)
            <option data-id="{{$key}}" value="{{$provider}}">
        @endforeach
    </datalist>

@endsection
@section('styles')
    <link rel="stylesheet" href="{{asset('/css/tingle.min.css')}}">
@endsection
@section('scripts')
    <script src="{{asset('/js/numeral.min.js')}}"></script>
    <script src="{{asset('js/auto-complete.min.js')}}"></script>
    <script src="{{asset('js/tingle.min.js')}}"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>

        const amount = document.querySelector('#amount'),
            taxInput = document.querySelector('#withholding_tax'),
            iva = document.querySelector('#iva'),
            total = document.querySelector('#total'),
            tax = document.querySelector('#tax'),
            ivaCalc = document.querySelector('#ivaCalc'),
            subtotal = document.querySelector('#subtotal'),
            percentage = document.querySelector('#percentage'),
            percentageCalc = document.querySelector('#percentageCalc'),
            provider = document.querySelector('#provider'),
            providerId = document.querySelector('#providerId'),
            partials = document.querySelector('#pending');

        changePrice()

        function changePrice() {
            var ivaVal = numeral(iva.options[iva.selectedIndex].value).value(),
                amountVal = numeral(amount.value).value();
            if (!ivaVal || !amountVal)
                return

            if (ivaVal < 0) {
                ivaVal = ivaVal * -1;
                percentage.innerHTML = ivaVal;
                ivaCalc.innerHTML = numeral(amountVal * ivaVal / (ivaVal + 100)).format('$0,0.00');
                var subtotalCalc = (amountVal * 100) / ( (ivaVal + 100));
                subtotal.innerHTML = percentageCalc.innerHTML = numeral(subtotalCalc).format('$0,0.00');
                var totalVal = amountVal - numeral(taxInput.value).value()
                total.innerHTML = numeral(totalVal).format('$0,0.00');
                tax.innerHTML = (taxInput.value) ? taxInput.value : '$0';
                partials.innerHTML = numeral(totalVal - numeral(partials.dataset.val).value()).format('$0,0.00');
                return
            }

            percentage.innerHTML = ivaVal;
            var ivaCalcNum = amountVal * ivaVal / 100,
                taxNum = (taxInput.value) ? numeral(taxInput.value).value() : 0;
            ivaCalc.innerHTML = numeral(ivaCalcNum).format('$0,0.00');
            subtotal.innerHTML = percentageCalc.innerHTML = numeral(amountVal).format('$0,0.00');
            var totalVal = amountVal + ivaCalcNum - taxNum
            total.innerHTML = numeral(totalVal).format('$0,0.00');
            tax.innerHTML = (taxInput.value) ? taxInput.value : 0;

            partials.innerHTML = numeral(totalVal - numeral(partials.dataset.val).value()).format('$0,0.00');
        }

        iva.addEventListener('change', changePrice);
        amount.addEventListener('blur', function () {
            this.value = numeral(this.value).format('$0,0.00');
            changePrice();
        })
        taxInput.addEventListener('blur', function () {
            this.value = numeral(this.value).format('$0,0');
            changePrice();
        })


        document.querySelector('#submit').addEventListener('click', function () {
            document.querySelector('#expenseForm').submit();
        })
        const providers = document.querySelector('#providers').options;
        var providerArray = [];

        for (var i = 0; i < providers.length; i++) {
            providerArray.push([providers[i].value, providers[i].dataset.id])
        }
        new autoComplete({
            selector: '#provider',
            minChars: 1,
            source: function (term, suggest) {
                term = term.toLowerCase();
                var choices = providerArray;
                var suggestions = [];
                for (var i = 0; i < choices.length; i++)
                    if (~(choices[i][0] + ' ' + choices[i][1]).toLowerCase().indexOf(term))
                        suggestions.push(choices[i]);
                suggest(suggestions);
            },
            renderItem: function (item, search) {
                search = search.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&amp;');
                var re = new RegExp("(" + search.split(' ').join('|') + ")", "gi");
                providerId.value = '';
                return '<div class="autocomplete-suggestion" ' +
                    'data-name="' + item[0] + '" ' +
                    'data-id="' + item[1] + '"> ' + item[0].replace(re, "<b>$1</b>") + '</div>';
            }
            ,
            onSelect: function (e, term, item) {
                provider.value = item.getAttribute('data-name');
                providerId.value = item.getAttribute('data-id');

            }
        })
        ;
        provider.addEventListener('blur', function () {
            if (!providerId.value) {
                provider.value = "";
                providerId.value = '';
            }

        });
        document.querySelector('#deleteExpense').addEventListener('click', function () {
            swal({
                title: "¿Estás seguror de eliminar este pago?",
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

        /* Modal pay */
        const ExpensePartial = document.querySelector('#ExpensePartial');
        var modal = new tingle.modal({
            footer: true,
            stickyFooter: false,
            closeMethods: ['overlay', 'button', 'escape'],
            closeLabel: "Close",
            onOpen: function () {
                var pay = document.querySelector('#importePay');
                pay.value = partials.textContent

                pay.addEventListener('blur', function () {
                    var totalImport = numeral(this.value).value(),
                        importpay = numeral(partials.textContent).value();
                    if (totalImport > importpay) {
                        this.value = numeral(importpay).format('$0,0.00')
                    } else {
                        this.value = numeral(this.value).format('$0,0.00');
                    }
                })
            },
        });
        modal.setContent(' <form action="" class="">\n' +
            '        <p>Añadir información sobre el pago de este gasto:</p>\n' +
            '        <div class="row between">\n' +
            '            <label for="" class="col-8"><span>Descripción</span>\n' +
            '                <input type="text" id="descritionPartial">\n' +
            '            </label>\n' +
            '            <label for="" class="col-4"><span>Fecha</span>\n' +
            '                <input type="date" id="datePartial">\n' +
            '            </label>\n' +
            '            <label for="" class="col-4 alignRight"><span>Importe</span>\n' +
            '                <input type="text" id="importePay"  class="alignRight">\n' +
            '            </label>\n' +
            '        </div>\n' +
            '    </form>\n');
        modal.addFooterBtn('Cancelar', 'Button Button-Transparent', function () {
            modal.close();
        });
        modal.addFooterBtn('Guardar!', 'Button Button-blue AddPay', function () {

            axios.post('/admin/gastos/parciales', {
                description: document.querySelector('#descritionPartial').value,
                date: document.querySelector('#datePartial').value,
                price: document.querySelector('#importePay').value,
                expense_id: document.querySelector('#idExpense').value,
                _token: document.querySelector('[name=_token]').value
            }).then(function (response) {
                var data = response.data
                if (data.success) {
                    var parser = new DOMParser();
                    var domString = ' <div class="row middle Expenses-partial">\n' +
                        '                <div class="col-1 ACenter"><img src="/img/data.svg" alt=""></div>\n' +
                        '                <div class="col-6 ">' + data.partial.description + '</div>\n' +
                        '                <div class="col-4 alignRight"> ' + data.partial.date + '</div>\n' +
                        '                <div class="col-4 alignRight"> ' + data.partial.price + '</div>\n' +
                        '                <div class="col-1 ACenter">' +
                        '                   <a href="" data-id="' + data.partial.id + '"> ' +
                        '                           <img src="/img/delete.svg" alt="">' +
                        '                   </a>' +
                        '                 </div>\n' +
                        '            </div>';

                    var html = parser.parseFromString(domString, 'text/html');
                    ExpensePartial.append(html.body.firstChild);
                    totalPartial = numeral(partials.innerHTML).value() - numeral(data.partial.price).value();

                    if (!totalPartial){
                        document.querySelector('#pay').remove()
                    }

                    partials.innerHTML = numeral(totalPartial).format('$0,0.00');
                    modal.close();
                }
            }).catch(function (error) {

            });
        });
        document.querySelector('#pay').addEventListener('click', function () {
            modal.open();
        })
        document.querySelector('#deleteExpense').addEventListener('click', function () {
            swal({
                title: "¿Estás seguro de eliminar este Pago?",
                text: "Una vez eliminado, no podrá recuperarlo",
                icon: "warning",
                buttons: ["No, cancelar!", "Si, eliminalo!"],
                dangerMode: true,
            }).then(function (isConfirm) {
                if (isConfirm) {
                    document.querySelector('#formDelete').submit();
                }

            });

        });

        function partialDelete(id) {
            swal({
                title: "¿Estás seguro de eliminar este pago parcial?",
                text: "Una vez eliminado, no podrá recuperarlo",
                icon: "warning",
                buttons: ["No, cancelar!", "Si, eliminalo!"],
                dangerMode: true,
            }).then(function (isConfirm) {
                if (isConfirm) {
                    document.querySelector('#idPartial').value = id;
                    document.querySelector('#formDeletePartial').submit();
                }

            });

        }
    </script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@endsection
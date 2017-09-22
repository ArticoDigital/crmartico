@extends('layouts.back')
@section('title', 'Agencia de Publicidad en Bogotá')

@section('content')
    <div class="col-16 row TitleBar">
        <a class="TitleBar-navLink " href="/admin/gastos"> ← Ingresos</a>
    </div>
    <div class="Table-title row between middle">
        <h1>Nuevo ingreso</h1>

        <div class="row">
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

        <form action="/admin/ingresos/nuevo" method="post" id="expenseForm" enctype="multipart/form-data">
            {{ csrf_field() }}
            <article class="Invoice-area">
                <h3>Datos básicos</h3>
                <div class="row arrow between">
                    <div class="col-7">
                        <label for="description"><span>Descripción del ingreso</span>
                            <textarea name="description" placeholder="Introduce la description del gasto"
                            >{{old('description')}}</textarea>
                        </label>
                        <div class="row between">
                            <label for="customer" class="col-16 "><span>Cliente</span>
                                <input type="text" name="customer" id="customer" placeholder=""
                                       value="{{old('customer')}}">
                                <input type="hidden" name="customer_id" id="customerId" value="{{old('customer_id')}}">
                                <a class=" marginTop-20 Button Button-Transparent" href="/admin/clientes/nuevo">
                                    Crear un cliente</a>
                            </label>
                        </div>
                    </div>
                    <div class="col-7">

                        <div class="row between">
                            <label id="income_category_id" class="col-7  Label-select"><span>Categoria</span>
                                <select name="income_category_id" id="">
                                    <option value="">Elige una opción</option>
                                    @foreach($incomeCategories as $key => $incomeCategory)
                                        <option value="{{$key}}"
                                                {{(old('expense_category_id')==$key)?'selected':''}}>
                                            {{$incomeCategory}}
                                        </option>
                                    @endforeach
                                </select>
                            </label>
                            <label for="date" class="col-7"><span>Fecha</span>
                                <input type="date" name="date" placeholder="" value="{{old('date')}}">
                            </label>
                        </div>
                        <div class="row between">
                            <label for="amount" class="col-7"><span>Importe</span>
                                <input type="text" id="amount" name="amount" class="alignRight"
                                       placeholder="Ingrese el precio $100.000" value="{{old('amount')}}">
                            </label>
                            <label id="" class="col-7 Label-select"><span>IVA</span>
                                <select name="iva" id="iva">
                                    <option value="">Elige una opción</option>
                                    <option value="0" {{(old('iva') == '0')?'selected' :''}}>0%</option>
                                    <option value="-9" {{(old('iva') == -9)?'selected':''}}>Incl 9%</option>
                                    <option value="-16" {{(old('iva') == -16)?'selected':''}}>Incl 16%</option>
                                    <option value="-19" {{(old('iva') == -19)?'selected' :''}}>Incl 19%</option>
                                    <option value="9" {{(old('iva') == 9)?'selected':''}}>Excl 9%</option>
                                    <option value="16" {{(old('iva') == 16)?'selected':''}}>Excl 16%</option>
                                    <option value="19" {{(old('iva') == 19)?'selected' :''}}>Excl 19%</option>
                                </select>
                            </label>
                        </div>
                        <div class="row between">
                            <label for="withholding_tax" class="col-16"><span></span>
                                <input type="text" name="withholding_tax" id="withholding_tax" class="alignRight"
                                       placeholder="Introducir el valor de las retenciones a la fuente $100.000"
                                       value="{{old('withholding_tax')}}">
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
                </label>
                <div class="col-7 row between Invoice-total">
                    <div class="col-9">
                        <p>Subtotal</p>
                        <p>IVA <em id="percentage">0</em>% de <em id="percentageCalc">$0</em></p>
                        <p>Retenciones </p>
                        <p>Total COP</p>
                    </div>
                    <div class="col-7" style="text-align: right">
                        <p><em id="subtotal">$0</em></p>
                        <p><em id="ivaCalc">$0</em></p>
                        <p><em id="tax">$0</em></p>
                        <p><em id="total">$0</em></p>
                    </div>
                </div>
            </article>
        </form>
        <datalist id="customers">
            @foreach($customers as $key => $customer)
                <option data-id="{{$key}}" value="{{$customer}}">
            @endforeach
        </datalist>
    </section>

@endsection
@section('scripts')
    <script src="{{asset('/js/numeral.min.js')}}"></script>
    <script src="{{url('js/auto-complete.min.js')}}"></script>
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
            customer = document.querySelector('#customer'),
            customerId = document.querySelector('#customerId');
        @if($errors->any())
        changePrice()

        @endif
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
                total.innerHTML = numeral(amountVal - numeral(taxInput.value).value()).format('$0,0.00');
                tax.innerHTML = (taxInput.value) ? taxInput.value : '$0';
                return
            }

            percentage.innerHTML = ivaVal;
            var ivaCalcNum = amountVal * ivaVal / 100,
                taxNum = (taxInput.value) ? numeral(taxInput.value).value() : 0;
            ivaCalc.innerHTML = numeral(ivaCalcNum).format('$0,0.00');
            subtotal.innerHTML = percentageCalc.innerHTML = numeral(amountVal).format('$0,0.00');

            total.innerHTML = numeral(amountVal + ivaCalcNum - taxNum).format('$0,0.00');
            tax.innerHTML = (taxInput.value) ? taxInput.value : 0;

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
        const customers = document.querySelector('#customers').options;
        var customerArray = [];

        for(var i = 0; i < customers.length; i++){
            customerArray.push([customers[i].value, customers[i].dataset.id])
        }
        new autoComplete({
            selector: '#customer',
            minChars: 1,
            source: function (term, suggest) {
                term = term.toLowerCase();
                var choices = customerArray;
                var suggestions = [];
                for (var i = 0; i < choices.length; i++)
                    if (~(choices[i][0] + ' ' + choices[i][1]).toLowerCase().indexOf(term))
                        suggestions.push(choices[i]);
                suggest(suggestions);
            },
            renderItem: function (item, search) {
                search = search.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&amp;');
                var re = new RegExp("(" + search.split(' ').join('|') + ")", "gi");
                customerId.value = '';
                return '<div class="autocomplete-suggestion" ' +
                    'data-name="' + item[0] + '" ' +
                    'data-id="' + item[1] + '"> ' + item[0].replace(re, "<b>$1</b>") + '</div>';
            }
            ,
            onSelect: function (e, term, item) {
                customer.value = item.getAttribute('data-name');
                customerId.value = item.getAttribute('data-id');

            }
        });

        customer.addEventListener('blur', function () {
            if (!customerId.value) {
                customer.value = "";
                customerId.value = '';
            }

        });
    </script>
@endsection
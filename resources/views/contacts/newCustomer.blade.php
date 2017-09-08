@extends('layouts.back')
@section('title', 'Agencia de Publicidad en Bogotá')

@section('content')
    <div class="col-16 row TitleBar">
        <a class="TitleBar-navLink " href="/admin/clientes"> ← Clientes</a>
    </div>
    <div class="Table-title row between middle">
        <h1>Nuevo cliente</h1>

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

        <form action="/admin/clientes/nuevo" method="post" id="customerForm" enctype="multipart/form-data">
            {{ csrf_field() }}
            <article class="Invoice-area">
                <h3>Datos básicos</h3>
                <div class="row arrow between">
                    <div class="col-7">
                        <label for="name_customer">
                            <span>Nombre de la empresa</span>
                            <input id="name_customer" type="text"
                                   value="{{old('name_customer')}}" name="name_customer"
                                   placeholder="Introduce el nombre">
                        </label>
                        <label for="address"><span>Dirección de la empresa</span>
                            <textarea name="address" placeholder="Introduce la dirección completa de la empresa"
                            >{{old('address')}}</textarea>
                        </label>
                    </div>
                    <div class="col-7">
                        <div class="row between">
                            <label for="nit" class="col-16 "><span>NIT</span>
                                <input type="text" id="nit" name="nit" placeholder=""
                                       value="{{old('nit')}}">
                            </label>
                        </div>
                        <div class="row between">
                            <label id="payment_conditions" class="col-7"><span>Condiciones de pago</span>
                                <select name="payment_conditions" id="">
                                    <option value="">Elige una opción</option>
                                    <option value="1" {{(old('payment_conditions')==1)?'selected':''}}>
                                        A 15 días
                                    </option>
                                    <option value="2" {{(old('payment_conditions')==2)?'selected':''}}>
                                        A 30 días
                                    </option>
                                    <option value="3" {{(old('payment_conditions')==3)?'selected':''}}>
                                        A 8 días
                                    </option>
                                    <option value="4" {{(old('payment_conditions')==4)?'selected':''}}>
                                        Definir manualmente
                                    </option>
                                    <option value="5" {{(old('payment_conditions')==5)?'selected':''}}>
                                        Pagado
                                    </option>
                                </select>
                            </label>
                            <label for="date" class="col-7"><span>Fecha de ingreso</span>
                                <input type="date" name="date" placeholder="" value="{{old('date')}}">
                            </label>
                        </div>

                        <label for="note">
                            <span>Nota</span>
                            <textarea name="note" placeholder="Introduce un mensaje para el cliente"
                            >{{old('note')}}</textarea>
                        </label>
                    </div>
                </div>
            </article>
            <article class="Invoice-borderTop">
                @include('partial.clientsInsertCustomer')
            </article>
            <article class="Invoice-borderTop row between">
                <h3 class="col-16">Documentación</h3>
                <label for="note" class="col-7">
                    <span>Camara de comercio</span>
                    <input type="file" name="chamber_commerce">
                </label>
                <label for="note" class="col-7">
                    <span>RUT</span>
                    <input type="file" name="rut">
                </label>
            </article>
        </form>

    </section>

@endsection
@section('scripts')
    <script>
        const form = document.getElementById('customerForm'),
            submit = document.getElementById('submit'),
            content = document.getElementById('Invoice-productContent'),
            ClientButtons = document.getElementById('ClientButtons'),
            addContacttButton = document.getElementById('addContact');
        var client = content.dataset.size;
        submit.addEventListener('click', function (e) {
            e.preventDefault();
            form.submit();
        });
        addContacttButton.addEventListener('click', function (e) {
            e.preventDefault();
            var parser = new DOMParser();
            var domString =
                '           <div class="row middle Invoice-product" id="Invoice-product' + client + '">' +
                '                        <label for="name' + client + '" class="col-4">' +
                '                            <span>Nombre</span>' +
                '                            <input type="text" name="c[' + client + '][name]" ' +
                '                               required id="name' + client + '" >' +
                '                        </label>' +
                '                        <label for="email' + client + '" class="col-4">' +
                '                            <span>E-mail</span>' +
                '                            <input type="email" required name="c[' + client + '][email]" ' +
                '                               id="email' + client + '">' +
                '                        </label>' +
                '                        <label for="position' + client + '" class="col-3">' +
                '                            <span>Cargo</span>' +
                '                            <input type="text" name="c[' + client + '][position]" ' +
                '                               required id="position' + client + '">' +
                '                        </label>' +
                '                        <label for="cellphone' + client + '" class="col-3">' +
                '                            <span>Celular</span>' +
                '                            <input type="text" name="c[' + client + '][cellphone]" ' +
                '                               required id="cellphone' + client + '" ' + 'class="alignRight">' +
                '                        </label>' +
                '                        <label for="phone' + client + '" class="col-2">' +
                '                            <span>Télefono</span>' +
                '                            <input type="text" name="c[' + client + '][phone]" ' +
                '                               id="phone' + client + '" ' + 'class="alignRight">' +
                '                        </label>' +
                '                    </div>' +
                '                </div>';
            client++;
            if (client == 2) {

                var buttonDelete = document.createElement('button');
                buttonDelete.innerText = 'Eliminar cliente'
                buttonDelete.className = "Button Button-Transparent"
                buttonDelete.onclick = deleteClient;
                buttonDelete.id = "deleteClient";
                var parser2 = new DOMParser();
                ClientButtons.append(buttonDelete);

            }
            var html = parser.parseFromString(domString, 'text/html');
            content.append(html.body.firstChild);
        });

        function deleteClient(e) {
            e.preventDefault();
            client--;
            var elem = document.querySelector("#Invoice-product" + client);
            elem.remove();
            if (client == 1) {
                document.getElementById("deleteClient").remove();
            }
        }

        if (document.getElementById('deleteClient') != null) {
            document.getElementById("deleteClient").addEventListener('click', deleteClient)
        }


    </script>
@endsection
@extends('layouts.back')
@section('title', 'Agencia de Publicidad en Bogotá')

@section('content')
    <form action="/admin/proveedores/eliminar" method="post" id="formDelete">
        {{csrf_field()}}
        <input type="hidden" name="id" value="{{$provider->id}}">
    </form>
    <div class="col-16 row TitleBar">
        <a class="TitleBar-navLink " href="/admin/proveedores"> ← Proveedores</a>
    </div>
    <div class="Table-title row between middle">
        <h1>Nuevo Proveedor</h1>
        <div class="row">
            <button id="deleteCustomer" class="Button Button-red">Eliminar</button>
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
        <form action="/admin/proveedores/editar" method="post" id="FormProvider" enctype="multipart/form-data">
            {{ csrf_field() }}
            <article class="Invoice-area">
                <h3>Datos básicos</h3>
                <div class="row arrow between">
                    <div class="col-7">
                        <label for="name">
                            <span>Nombre del proveedor</span>
                            <input type="text" id="name" name="name" placeholder="Introduce el nombre"
                                   value="{{(old('name'))?old('name'):$provider->name}}">
                        </label>

                        <label for="position" class="col-16 "><span>Cargo o servicio</span>
                            <input type="text" name="position" id="position" placeholder="Introduce el cargo"
                                   value="{{(old('position'))?old('position'):$provider->position}}">
                        </label>
                    </div>
                    <div class="col-7">
                        <div class="row between">
                            <label for="nit" class="col-16"><span>Cédula o NIT</span>
                                <input type="text" id="nit" name="nit" placeholder="Introduce el NIT o cédula"
                                       value="{{(old('nit'))?old('nit'):$provider->nit}}">
                            </label>
                        </div>
                        <div class="row between">
                            <label id="type_person" class="col-7"><span>Tipo de persona</span>
                                <select name="type_person" id="">
                                    <option value="">Selecciona el tipo de persona</option>
                                    <option value="1"
                                            {{(old('type_person'))?
                                            ((old('type_person')==1)?'selected':'' ):
                                            (($provider->type_person == 1)?'selected':'')}}
                                    >Natural</option>
                                    <option value="2"
                                            {{(old('type_person'))?
                                            ((old('type_person')==2)?'selected':'' ):
                                            (($provider->type_person == 2)?'selected':'')}}
                                    >Jurídica</option>
                                </select>
                            </label>
                            <label for="due_date" class="col-7"><span>Fecha de ingreso</span>
                                <input type="date" name="date" id="due_date" placeholder=""
                                       value="{{(old('date'))?old('date'):$provider->date}}">
                            </label>
                        </div>
                    </div>
                </div>
            </article>
            <article class="Invoice-borderTop">
                <h3>Datos de contacto</h3>
                <div class="row arrow between">
                    <div class="col-7">
                        <label for="email">
                            <span>Email del proveedor</span>
                            <input type="email" name="email" placeholder="Introduce el email"
                                   value="{{(old('email'))?old('email'):$provider->email}}">
                        </label>

                        <label for="address"><span>Dirección del proveedor</span>
                            <textarea name="address"  placeholder="Introduce la dirección completa del proveedor"
                                      id="address">{{(old('address'))?old('address'):$provider->address}}</textarea>
                        </label>
                    </div>
                    <div class="col-7">
                        <label for="phone" id="phone">
                            <span>Teléfono fijo proveedor</span>
                            <input type="text" id="phone" name="phone" placeholder="Introduce el Teléfono"
                                   value="{{(old('phone'))?old('phone'):$provider->phone}}">
                        </label>
                        <label for="cellphone">
                            <span>Celular proveedor</span>
                            <input type="text" id="cellphone" name="cellphone"
                                   placeholder="Introduce el Celular"
                                   value="{{(old('cellphone'))?old('cellphone'):$provider->cellphone}}">
                        </label>
                    </div>
                </div>
            </article>
            <article class="Invoice-borderTop row between">
                <h3 class="col-16">Documentos</h3>
                <div class="col-7">
                    <label for="cellphone">
                        <span>Cámara de comercio</span>
                        <input type="file" name="chamber_commerce">
                        @if($provider->chamber_commerce)
                            <a href="{{$provider->chamber_commerce}}"
                               class="Button Button-blue marginTop-20 " target="_blank">ver archivo</a>
                        @endif
                    </label>
                </div>
                <div class="col-7">
                    <label for="cellphone">
                        <span>RUT</span>
                        <input type="file" name="rut" >
                        @if($provider->rut)
                            <a href="{{$provider->rut}}" class="Button Button-blue marginTop-20 " target="_blank">
                                ver archivo</a>
                        @endif
                    </label>
                </div>
            </article>
            <article class="Invoice-borderTop ">
                <label for="note"><span>Nota</span>
                    <textarea placeholder="Introduce una nota del proveedor" id="note"
                              name="note" >{{(old('note'))?old('note'):$provider->note}}</textarea>
                </label>
            </article>
        </form>
    </section>

@endsection
@section('scripts')
    <script>
        document.querySelector('#submit').addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelector('#FormProvider').submit();
        });
        document.querySelector('#deleteCustomer').addEventListener('click', function () {
            swal({
                title: "¿Estás seguror de eliminar este proveedor?",
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
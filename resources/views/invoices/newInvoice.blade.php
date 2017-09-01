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
                            <input type="text" name="client" placeholder="Introduce el cliente">
                        </label>
                        <label for="address"><span>Dirección</span>
                            <textarea name="address"
                                      placeholder="Introduce la dirección completa del cliente"></textarea>
                        </label>
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
                <div class="row middle Invoice-product">
                    <label for="" class="col-4">
                        <span>Producto</span>
                        <input type="text" name="name">
                    </label>
                    <label for="" class="col-2">
                        <span>Cantidad</span>
                        <input type="text" name="name" class="alignRight">
                    </label>
                    <label for="" class="col-2">
                        <span>Unidad</span>
                        <input type="text" name="name" class="alignRight">
                    </label>
                    <label for="" class="col-2">
                        <span>Descuento</span>
                        <input type="text" name="name" class="alignRight">
                    </label>
                    <label for="" class="col-2">
                        <span>Precio (neto)</span>
                        <input type="text" name="name" class="alignRight">
                    </label>
                    <label for="" class="col-2">
                        <span>IVA</span>
                        <input type="text" name="name">
                    </label>
                    <label for="" class="col-2">
                        <span>Importe (neto)</span>
                        <input type="text" name="name"  class="alignRight" readonly>
                    </label>
                    <label for="" class="col-10">
                        <span>Descripción</span>
                        <input type="text" name="name">
                    </label>
                    <div class="Invoice-tax row">
                        <input type="checkbox" name="" id="invoicetax">
                        <label for="invoicetax" class="Invoice-taxLabel">Aplica retenciones a la fuente (11,00
                            %)</label>
                    </div>
                </div>
                <div class="row marginTop-20">
                    <a href="" class="Button Button-Transparent">Agregar un producto</a>
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
                <textarea
                        placeholder="Introduce términos, Resolución de facturación DIAN, instrucciones de pago u otras notas adicionales"></textarea>
            </article>
        </form>
    </section>

@endsection
@section('scripts')
@endsection
<h3>Contactos</h3>
@php($old = session()->getOldInput())
@php($countClient = ($old) ? collect( $old['c'])->count() : 1)

<div id="Invoice-productContent" data-size="{{$countClient}}">
    @for($i = 0; $i < $countClient; $i++)
        <div class="row middle Invoice-product" id="Invoice-product{{$i}}">

            <label for="name" class="col-4">
                <span>Nombre</span>
                <input type="text" id="name" name="c[{{$i}}][name]"
                       value="{{ ($old) ? $old['c'][$i]['name'] : '' }}">
            </label>
            <label for="email" class="col-4">
                <span>E-mail</span>
                <input type="text" name="c[{{$i}}][email]" id="email"
                       value="{{ ($old) ? $old['c'][$i]['email'] : '' }}">
            </label>
            <label for="position" class="col-3">
                <span>Cargo</span>
                <input type="text" name="c[{{$i}}][position]" id="position"
                       value="{{ ($old) ? $old['c'][$i]['position'] : '' }}">
            </label>
            <label for="cellphone" class="col-3">
                <span>Celular</span>
                <input type="text" name="c[{{$i}}][cellphone]" id="cellphone" class="alignRight"
                       value="{{ ($old) ? $old['c'][$i]['cellphone'] : '' }}">
            </label>
            <label for="phone" class="col-2">
                <span>Télefono</span>
                <input type="text" name="c[{{$i}}][phone]" id="phone" class="alignRight"
                       value="{{ ($old) ? $old['c'][$i]['phone'] : '' }}">
            </label>
        </div>
    @endfor
</div>
<div class="row marginTop-20" id="ClientButtons">
    <button id="addContact" class="Button Button-Transparent">Agregar un contacto</button>
    @if($countClient > 1)
        <button class="Button Button-Transparent" id="deleteClient">
            Eliminar cliente
        </button>
    @endif
</div>
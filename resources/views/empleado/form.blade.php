<h1>{{ $modo }} Empleado</h1>

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="form-group mb-3">
    <label for="nombre">Nombre <span class="text-danger"><b>(*)</b></span></label>
    <input type="text" class="form-control" name="nombre" id="nombre"
        value="{{ isset($empleado->nombre) ? $empleado->nombre : old('nombre') }}">
</div>

<div class="form-group mb-3">
    <label for="apellido_paterno">Apellido Paterno <span class="text-danger"><b>(*)</b></span></label>
    <input type="text" class="form-control" name="apellido_paterno" id="apellido_paterno"
        value="{{ isset($empleado->apellido_paterno) ? $empleado->apellido_paterno : old('apellido_paterno') }}">
</div>

<div class="form-group mb-3">
    <label for="apellido_materno">Apellido Materno <span class="text-danger"><b>(*)</b></span></label>
    <input type="text" class="form-control" name="apellido_materno" id="apellido_materno"
        value="{{ isset($empleado->apellido_materno) ? $empleado->apellido_materno : old('apellido_materno') }}">
</div>

<div class="form-group mb-3">
    <label for="correo">Correo <span class="text-danger"><b>(*)</b></span></label>
    <input type="email" class="form-control" name="correo" id="correo"
        value="{{ isset($empleado->correo) ? $empleado->correo : old('correo') }}">
</div>

<div class="form-group mb-3">
    <label for="foto">Foto <span class="text-danger"><b>(*)</b></span></label>
    <input type="file" class="form-control" name="foto" id="foto">
</div>

@if (isset($empleado->foto))
    <div class="form-group mb-3">
        <img class="img-thumbnail img-fluid" src="{{ asset('storage') . '/' . $empleado->foto }}"
            alt="{{ $empleado->nombre }}" width="100">
    </div>
@endif

<div class="form-group mb-3">
    <input class="btn btn-success" type="submit" value="{{ $modo }} Empleado">
    <a class="btn btn-primary" href="{{ url('empleado') }}">Regresar</a>
</div>

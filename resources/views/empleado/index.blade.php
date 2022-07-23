@extends('layouts.app')

@section('content')
    <div class="container">

        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
            <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                <path
                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
            </symbol>
        </svg>

        @if (Session::has('Mensaje'))
            <div class="alert alert-success d-flex align-items-center alert-dismissible fade show" role="alert">
                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
                    <use xlink:href="#check-circle-fill" />
                </svg>
                <div>
                    {{ Session::get('Mensaje') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        <a href="{{ url('empleado/create') }}" class="btn btn-success mb-4">Registrar Empleado</a>

        <div class="table-responsive">
            <table class="table table-sm">
                <thead class="table-light">
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">Foto</th>
                        <th>Nombre</th>
                        <th>Apellido Paterno</th>
                        <th>Apellido Materno</th>
                        <th>Correo</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($empleados as $empleado)
                        <tr>
                            <td class="text-center">{{ $empleado->id }}</td>
                            <td class="text-center">
                                <img class="img-thumbnail img-fluid" src="{{ asset('storage') . '/' . $empleado->foto }}"
                                    alt="{{ $empleado->nombre }}" width="80">
                            </td>
                            <td>{{ $empleado->nombre }}</td>
                            <td>{{ $empleado->apellido_paterno }}</td>
                            <td>{{ $empleado->apellido_materno }}</td>
                            <td>{{ $empleado->correo }}</td>
                            <td class="text-center">
                                <a href="{{ url('/empleado/' . $empleado->id . '/edit') }}"
                                    class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                                |
                                <form action="{{ url('/empleado/' . $empleado->id) }}" class="d-inline" method="post">
                                    @csrf
                                    {{ method_field('DELETE') }}
                                    <button type="submit" onclick="return confirm('¿Quiere borrar el registro?')"
                                        class="btn btn-danger btn-sm"><i class="fa-solid fa-trash-can"></i></button>
                                </form>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $empleados->links() }}
        </div>
    </div>
@endsection

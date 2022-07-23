<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $datos['empleados'] = Empleado::paginate(1);

        return view('empleado.index', $datos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('empleado.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validation
        $campos = [
            'nombre' => 'required|string|max:100',
            'apellido_paterno' => 'required|string|max:100',
            'apellido_materno' => 'required|string|max:100',
            'correo' => 'required|string|email|unique:empleados',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:10000',
        ];

        $mensajes = [
            'nombre.required' => 'El nombre es requerido',
            'apellido_paterno.required' => 'El apellido paterno es requerido',
            'apellido_materno.required' => 'El apellido materno es requerido',
            'correo.required' => 'El correo es requerido',
            'correo.email' => 'El correo debe ser un correo válido',
            'correo.unique' => 'El correo ya existe',
            'foto.required' => 'La foto es requerida',
            'foto.image' => 'La foto debe ser una imagen',
            'foto.mimes' => 'La foto debe ser formato jpeg, png o jpg',
            'foto.max' => 'La foto debe pesar menos de 10MB',
        ];

        $this->validate($request, $campos, $mensajes);

        // $datosEmpleado = request()->all();
        $datosEmpleado = request()->except('_token');

        if ($request->hasFile('foto')) {
            $datosEmpleado['foto'] = $request->file('foto')->store('uploads', 'public');
        }

        $datosEmpleado['created_at'] = date('Y-m-d H:i:s');
        $datosEmpleado['updated_at'] = date('Y-m-d H:i:s');

        Empleado::insert($datosEmpleado);

        return redirect('empleado')->with('Mensaje', 'Empleado creado con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function show(Empleado $empleado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        //
        $datos['empleado'] = Empleado::findOrFail($request->id);
        return view('empleado.edit', $datos);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Validation
        $campos = [
            'nombre' => 'required|string|max:100',
            'apellido_paterno' => 'required|string|max:100',
            'apellido_materno' => 'required|string|max:100',
            'correo' => 'required|string|email|unique:empleados,correo,' . $request->id,
        ];

        $mensajes = [
            'nombre.required' => 'El nombre es requerido',
            'apellido_paterno.required' => 'El apellido paterno es requerido',
            'apellido_materno.required' => 'El apellido materno es requerido',
            'correo.required' => 'El correo es requerido',
            'correo.email' => 'El correo debe ser un correo válido',
            'correo.unique' => 'El correo ya existe',
        ];

        if ($request->hasFile('foto')) {
            $empleado = Empleado::findOrFail($request->id);
            Storage::delete('public/' . $empleado->foto);
            $datosEmpleado['foto'] = $request->file('foto')->store('uploads', 'public');
            $campos = ['foto' => 'required|image|mimes:jpeg,png,jpg|max:10000'];
            $mensajes = [
                'foto.required' => 'La foto es requerida',
                'foto.image' => 'La foto debe ser una imagen',
                'foto.mimes' => 'La foto debe ser formato jpeg, png o jpg',
                'foto.max' => 'La foto debe pesar menos de 10MB',
            ];
        }

        $this->validate($request, $campos, $mensajes);

        $datosEmpleado = request()->except('_token', '_method');

        $datosEmpleado['updated_at'] = date('Y-m-d H:i:s');

        Empleado::where('id', $request->id)->update($datosEmpleado);

        $empleado = Empleado::findOrFail($request->id);

        // return view('empleado.edit', compact('empleado'));
        return redirect('empleado')->with('Mensaje', 'Empleado actualizado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        $empleado = Empleado::findOrFail($request->id);
        if (Storage::delete('public/' . $empleado->foto)) {
            $empleado->delete();
        }
        return redirect('empleado')->with('Mensaje', 'Empleado eliminado con éxito');
    }
}

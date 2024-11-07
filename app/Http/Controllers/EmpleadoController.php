<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class EmpleadoController extends Controller
{
    // Mostrar todos los empleados
    public function index()
    {
        $empleados = Empleado::with('usuario')->get();
        return response()->json($empleados);
    }

    // Mostrar un empleado específico
    public function show($id)
    {
        $empleado = Empleado::with('usuario')->findOrFail($id);
        return response()->json($empleado);
    }

    // Crear un nuevo empleado
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'rol' => 'required|string|max:255',
            'usuario_id' => 'required|exists:usuarios,id',
        ]);

        $empleado = Empleado::create($request->all());
        return response()->json($empleado, 201);
    }

    // Actualizar un empleado existente
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'rol' => 'required|string|max:255',
            'usuario_id' => 'required|exists:usuarios,id',
        ]);

        $empleado = Empleado::findOrFail($id);
        $empleado->update($request->all());

        return response()->json($empleado);
    }

    // Eliminar un empleado
    public function destroy($id)
    {
        $empleado = Empleado::findOrFail($id);
        $empleado->delete();

        return response()->json(['message' => 'Empleado eliminado correctamente']);
    }
}

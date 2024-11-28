<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\computadora;
use Illuminate\Database\QueryException;
use App\Rules\CodigoBarrasUnico;
class computadorasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $search = $request->input('search');

        $computadoras = computadora::query()
            ->orWhere('estado', 'like', "%{$search}%")
            ->orWhere('codigo_barras', 'like', "%{$search}%")
            ->paginate(10);

        return view('computadoras.index', compact('computadoras'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('computadoras.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'estado' => ['required', 'string'],
                'disponible' => 'boolean',
                'codigo_barras' => [
                    'string',
                    'nullable',
                    new CodigoBarrasUnico,  // Se usa la regla personalizada aquí
                ],
            ]);
    
            // Si no se provee un código de barras, asigna '0'
            $data['codigo_barras'] = $data['codigo_barras'] ?? '0';
    
            // Establecer disponible como verdadero o falso dependiendo de si se envió
            $data['disponible'] = $request->has('disponible');
    
            // Crear el registro en la base de datos
            $computadora = computadora::create($data);
    
            // Redirigir al usuario al detalle de la computadora creada
            return to_route('computadoras.show', $computadora)->with('success', 'computadora creada correctamente.');
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Verifica si el error es específico del código de barras duplicado
            if ($e->validator->errors()->has('codigo_barras')) {
                return to_route('computadoras.create')->with('error', 'Código de barras en uso.');
            }
    
            throw $e; // Lanza de nuevo la excepción si es otro error de validación
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(computadora $computadora)
    {
       return view('computadoras.show', ["computadora" => $computadora]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(computadora $computadora)
    {
        return view('computadoras.edit', ["computadora" => $computadora]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, computadora $computadora)
    {
        try {
            $data = $request->validate([
                'estado' => ['required', 'string'],
                'disponible' => 'boolean',
                'codigo_barras' => [
                    'string',
                    'nullable',
                    new CodigoBarrasUnico,  // Se usa la regla personalizada aquí
                ],
            ]);
    
            // Si no se provee un código de barras, asigna '0'
            $data['codigo_barras'] = $data['codigo_barras'] ?? '0';
    
            // Establecer disponible como verdadero o falso dependiendo de si se envió
            $data['disponible'] = $request->has('disponible');
    
            // Crear el registro en la base de datos
            $computadora->update($data);
    
            // Redirigir al usuario al detalle de la computadora creada
            return to_route('computadoras.show', $computadora)->with('success', 'computadora editada correctamente.');
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Verifica si el error es específico del código de barras duplicado
            if ($e->validator->errors()->has('codigo_barras')) {
                return to_route('computadoras.create')->with('error', 'Código de barras en uso.');
            }
    
            throw $e; // Lanza de nuevo la excepción si es otro error de validación
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(computadora $computadora)
    {

        try {
            // Intentar eliminar la computadora
            $computadora->delete();
    
            // Redirigir con mensaje de éxito
            return redirect()->route('computadoras.index')->with('success', 'computadora eliminada correctamente.');
    
        } catch (QueryException $e) {
            // Si ocurre una violación de clave foránea (error 1451)
            if ($e->getCode() == 23000) {
                // Redirigir con un mensaje de error amigable
                return redirect()->route('computadoras.index')->with('error', 'No se puede eliminar la computadora porque está asociada a un préstamo.');
            }
    
            // Si es otro error, puedes manejarlo de manera diferente o volver a lanzarlo
            throw $e;
        }
    }

    public function buscar(Request $request)
    {
        $search = $request->get('search');
        $computadoras = computadora::where('codigo_barras', 'like', "%{$search}%")->limit(10)->get();
    
        return response()->json($computadoras);
    }

}

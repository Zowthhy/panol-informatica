<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prestamo;
use App\Models\computadora;
use Illuminate\Database\QueryException;
class prestamosController extends Controller
{
    /**
     * Muestra todos los prestamos
     */
    public function index(Request $request)
    {


        $prestamos = Prestamo::query()
        -> orderBy('created_at', 'desc')
        -> paginate(15);;
        return view('prestamos.index', ['prestamos' => $prestamos]);
    }

    public function indexSinDevolucion()
    {
        // Filtrar donde 'devolucion' es null
        $prestamos = Prestamo::whereNull('devolucion')
        -> paginate(15);
        return view('prestamos.index', ['prestamos' => $prestamos]);
    }

    /**
     * Muestra el formulario para agregar un prestamo
     */
    public function create()
    {
        return view('prestamos.create');
    }
    public function crearSinCB()
    {
        return view('prestamos.crearSinCB');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request -> validate([
            'id_computadora' => ['required', 'integer', 'min:1'],
            'id_encargado' => ['required', 'integer', 'min:1'],
            'id_usuario' => ['required', 'integer', 'min:1']
        ]);

        $computadora = computadora::where('codigo_barras', $data['id_computadora'])->first();
        // Verificar si la computadora está disponible
        if ($computadora && $computadora->disponible == 1) {
            // Cambiar el estado de disponibilidad a 0 (no disponible)
            $data['id_computadora'] = $computadora->id;
            $computadora->disponible = 0;
            $computadora->save();
            $prestamo = Prestamo::create($data);
            return to_route('prestamos.show', $prestamo)->with('success', 'Prestamo creado');
        } else {
            return back()->with('error', 'La computadora no está disponible.');
        }
    }

    public function storeSinCB(Request $request)
    {
        $data = $request -> validate([
            'id_computadora' => ['required', 'integer', 'min:1'],
            'id_encargado' => ['required', 'integer', 'min:1'],
            'id_usuario' => ['required', 'integer', 'min:1']
        ]);

        $computadora = computadora::find($data['id_computadora']);
        // Verificar si la computadora está disponible
        if ($computadora && $computadora->disponible == 1) {
            // Cambiar el estado de disponibilidad a 0 (no disponible)
            $computadora->disponible = 0;
            $computadora->save();
            $prestamo = Prestamo::create($data);
            return to_route('prestamos.show', $prestamo)->with('success', 'Prestamo creado');
        } else {
            return back()->with('error', 'La computadora no está disponible.');
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(Prestamo $prestamo)
    {
        $prestamo = prestamo::with('reportes')->find($prestamo -> id); // Usa el ID del usuario que deseas mostrar
        return view('prestamos.show', compact('prestamo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Prestamo $prestamo)
    {
        return view('prestamos.edit', ['prestamo' => $prestamo]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Prestamo $prestamo)
    {
        $data = $request -> validate([
            'id_computadora' => ['required', 'integer', 'min:1'],
            'id_encargado' => ['required', 'integer', 'min:1'],
            'id_usuario' =>['required', 'integer', 'min:1']
        ]);

        $prestamo -> update($data);
        return to_route('prestamos.show', $prestamo)->with('success', 'Prestamo actualizado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Prestamo $prestamo)
    {
        
        try {
            // Intentar eliminar la computadora
            $prestamo->delete();
    
            // Redirigir con mensaje de éxito
            return redirect()->route('prestamos.index')->with('success', 'Prestamo eliminado correctamente.');
    
        } catch (QueryException $e) {
            // Si ocurre una violación de clave foránea (error 1451)
            if ($e->getCode() == 23000) {
                // Redirigir con un mensaje de error amigable
                return redirect()->route('prestamos.index')->with('error', 'No se puede eliminar al prestamo porque está asociado a un reporte.');
            }
    
            // Si es otro error, puedes manejarlo de manera diferente o volver a lanzarlo
            throw $e;
        }
    }

    public function devolver(Prestamo $prestamo)
    {
        $prestamo->devolucion = now();

        $prestamo->save();

        $computadora = computadora::find($prestamo -> id_computadora);
        $computadora->disponible = 1;
        $computadora->save();

        return to_route('prestamos.index')->with('success','La computadora fue devuelta');
    }
    public function buscar(Request $request)
    {

        $search = $request->get('search');
        
        $prestamos = Prestamo::query()
        ->whereHas('usuario', function($query) use ($search) {
            $query->where('nombre', 'like', "%{$search}%")
                  ->orWhere('apellido', 'like', "%{$search}%");
        })
        ->orderBy('created_at', 'desc')
        ->paginate(15);
    
        return view('prestamos.index', ['prestamos' => $prestamos]);
    }
}

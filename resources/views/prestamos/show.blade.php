<x-app-layout>
    <div class="show-container">
        <div class="show-header">
            <h1>Préstamo creado el: <span>{{ $prestamo->created_at }}</span></h1>
            <div class="show-actions">
                <a href="{{ route('prestamos.edit', $prestamo) }}" class="btn btn-primary">Editar</a>
                <form action="{{ route('prestamos.destroy', $prestamo) }}" method="POST" onsubmit="return confirmDelete();" class="inline-form">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Borrar</button>
                </form>
                <a href="{{ url('/reportes/create/' . $prestamo->id) }}" class="btn btn-secondary">Generar Reporte</a>
            </div>
        </div>
    
        <div class="show-details">
            <div class="detail-item">
                <label>Computadora:</label>
                <span>{{ Str::words($prestamo->id_computadora) }}</span>
            </div>
            <div class="detail-item">
                <label>Encargado:</label>
                <span>{{ Str::words($prestamo->id_encargado) }}</span>
            </div>
            <div class="detail-item">
                <label>Usuario:</label>
                <a href="{{ route('usuarios.show', $prestamo->usuario->id) }}" class="link">
                    {{ $prestamo->usuario->nombre }} {{ $prestamo->usuario->apellido }}
                </a>
            </div>
        </div>
    
        <div class="show-reportes">
            <h2>Reportes</h2>
            <ul>
                @foreach($prestamo->reportes as $reporte)
                    <li>
                        <a href="{{ route('reportes.show', $reporte) }}" class="link">{{ $reporte->created_at }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <script>
        function confirmDelete() {
            return confirm('¿Estás seguro de que deseas eliminar este préstamo?');
        }
    </script>
</x-app-layout>
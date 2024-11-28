<x-app-layout>

    <div class="show-container">
        <div class="show-header">
            <h1>Computadora creada el: <span>{{ $computadora->created_at }}</span></h1>
            <div class="show-actions">
                <a href="{{ route('computadoras.edit', $computadora) }}" class="btn btn-primary">Editar</a>
                <form action="{{ route('computadoras.destroy', $computadora) }}" method="POST" onsubmit="return confirmDelete();" class="inline-form">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Borrar</button>
                </form>
            </div>
        </div>
    
        <div class="show-details">
            <table class="details-table">
                <tr>
                    <th>Id de computadora:</th>
                    <td>{{ Str::words($computadora->id) }}</td>
                </tr>
                <tr>
                    <th>Estado de la computadora:</th>
                    <td>{{ Str::words($computadora->estado) }}</td>
                </tr>
                <tr>
                    <th>Código de barras:</th>
                    <td>{{ Str::words($computadora->codigo_barras) }}</td>
                </tr>
            </table>
        </div>
    </div>

    <script>
        function confirmDelete() {
            return confirm('¿Estás seguro de que deseas eliminar esta computadora?');
        }
    </script>
</x-app-layout>
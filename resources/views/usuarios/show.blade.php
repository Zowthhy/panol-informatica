<x-app-layout>
    <div class="show-container">
        <div class="show-header">
            <h1>Usuario creado el: <span>{{ $usuario->created_at }}</span></h1>
            <div class="show-actions">
                <a href="{{ route('usuarios.edit', $usuario) }}" class="btn btn-primary">Editar</a>
                <form action="{{ route('usuarios.destroy', $usuario) }}" method="POST" onsubmit="return confirmDelete();" class="inline-form">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Borrar</button>
                </form>
            </div>
        </div>
    
        <div class="details">
            <div class="detail-item">
                <label>Nombre:</label>
                <span>{{ Str::words($usuario->nombre) }}</span>
            </div>
            <div class="detail-item">
                <label>Apellido:</label>
                <span>{{ Str::words($usuario->apellido) }}</span>
            </div>
            <div class="detail-item">
                <label>Email:</label>
                <span>{{ Str::words($usuario->email) }}</span>
            </div>
            <div class="detail-item">
                <label>Curso:</label>
                <span>{{ Str::words($usuario->curso) }}</span>
            </div>
        </div>
    
        <div class="show-reportes">
            <h2>Préstamos</h2>
            <ul>
                @foreach($usuario->prestamos as $prestamo)
                    <li>
                        <a href="{{ route('prestamos.show', $prestamo) }}" class="link">{{ $prestamo->created_at }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <script>
        function confirmDelete() {
            return confirm('¿Estás seguro de que deseas eliminar este Usuario?');
        }
    </script>
</x-app-layout>
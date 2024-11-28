<x-app-layout>
    <div class="note-container single-note">
        <form action="{{ route('computadoras.store') }}" method="POST" class="agregarForm">
            <div class="titulo">
                <h1>Agregar computadora </h1>
            </div>

            @csrf
            <label>Estado de la computadora:</label>
            <textarea name="estado" rows="10" class="note-body" placeholder="Descripción de la computadora..."></textarea>
            <label>Codigo de barras:</label>
            <input type="text" name="codigo_barras" placeholder="codigo de barras (Dejar vacio si no tiene)">
            <label for="disponible">Marcar si la computadora esta disponible:
            <input type="checkbox" name="disponible" id="disponible" value="1" {{ old('activo', $modelo->activo ?? true) ? 'checked' : '' }}> </label>
                <a href="{{ route('computadoras.index')}}" class="cancel">Cancelar</a> 
                <button class="submit">Agregar</button>
            </div>
        </form>
    </div>
</x-app-layout>

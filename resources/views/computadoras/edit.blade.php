
<x-app-layout>
    <div class="note-container single-note">
        <form action="{{ route('computadoras.update', $computadora) }}" method="POST" class="agregarForm">
            @csrf
            @method('PUT')

            <div class="titulo">
                <h1>Editar computadora ID: {{ $computadora -> id }} </h1>
            </div>

            <label>Estado de la computadora:</label>
            <textarea name="estado" rows="10" class="note-body" required>{{ Str::words($computadora->estado) }}</textarea>
            <label>Codigo de barras:</label>
            <input type="text" name="codigo_barras" value="{{ $computadora -> codigo_barras }}" required>
            <label for="disponible">Marcar si la computadora esta disponible:
            <input type="checkbox" name="disponible" id="disponible" value="1" {{ old('activo', $modelo->activo ?? false) ? 'checked' : '' }}> </label>
                <a href="{{ route('computadoras.index')}}" class="cancel">Cancelar</a> 
                <button class="submit">Editar</button>
            </div>
        </form>
    </div>
</x-app-layout>
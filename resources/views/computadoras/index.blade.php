<x-app-layout>

        <a href="{{ route('computadoras.create') }}" class="agregarBoton"><p>+ Agregar computadora</p></a>

        <!-- Barra de búsqueda -->
        <form class="barraBusqueda" action="{{ route('computadoras.index') }}" method="GET">
            <input type="text" class="inputBusqueda" name="search" placeholder="Buscar por codigo de barras" value="{{ request('search') }}">
            <button type="submit" class="botonBusqueda">Buscar</button>
        </form>

        <div class="computadoras">
            <h1 class="titulo">computadoras</h1>
            <table class="computadorasTable">
                <tr>
                    <th>ID computadora</th>
                    <th>Estado</th>
                    <th>Codigo de barras</th>
                    <th>Disponible</th>
                    <th colspan="3">Opciones</th>
                </tr>
            @foreach ($computadoras as $computadora)
            <div class="computadora">
                <tr>
                    <th> {{ Str::words($computadora -> id)}}</th>
                    <th>{{ Str::limit($computadora->estado, 100, '...') }}</th>
                    <th> {{ Str::words($computadora -> codigo_barras)}}</th>
                    @if ($computadora -> disponible == 1)
                    <th>Si</th>
                    @else
                    <th>No</th>
                    @endif
                    <div class="buttons">
                    <th class="show-button"><a href="{{ route('computadoras.show', $computadora) }}">Ver</a></th>
                    <th class="edit-button"><a href="{{ route('computadoras.edit', $computadora) }}">Editar</a></th>
                    <form action="{{ route('computadoras.destroy', $computadora) }}" method="POST" onsubmit="return confirmDelete();">
                            @csrf
                            @method('DELETE')
                            <th class="delete-button"><button>Borrar</button></th> 
                        </form>
                </tr>
            </div>
            @endforeach
        </div>

        {{ $computadoras->links() }}

        <script>
        function confirmDelete() {
            return confirm('¿Estás seguro de que deseas eliminar esta computadora?');
        }
    </script>
</x-app-layout>
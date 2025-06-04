@extends('layouts.admin')

@section('contenido')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Películas</h2>
        <button onclick="document.getElementById('modal-create').showModal()"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            + Nueva Película
        </button>
    </div>

    @if($peliculas->isEmpty())
        <p>No hay películas registradas.</p>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($peliculas as $pelicula)
                <div class="relative bg-gray-100 rounded shadow overflow-hidden group">

                    {{-- Imagen de la película (usa asset o Storage si usas disco) --}}
                    <img src="{{ asset($pelicula->foto_miniatura) }}"
                         alt="{{ $pelicula->titulo }}"
                         class="w-full h-60 object-cover group-hover:brightness-75 transition duration-300">

                    {{-- Botones superpuestos --}}
                    <div class="absolute inset-0 flex items-start justify-end p-2 gap-1">
                        <button onclick="document.getElementById('modal-edit-{{ $pelicula->id }}').showModal()"
                                class="bg-yellow-500 text-white px-2 py-1 rounded text-sm hover:bg-yellow-600">
                            ✏️
                        </button>

                        <a href="{{ route('admin.peliculas.show', $pelicula->id) }}"
                           class="bg-blue-500 text-white px-2 py-1 rounded text-sm hover:bg-blue-600">
                            👁️
                        </a>

                        <button onclick="document.getElementById('modal-delete-{{ $pelicula->id }}').showModal()"
                                class="bg-red-600 text-white px-2 py-1 rounded text-sm hover:bg-red-700">
                            🗑️
                        </button>
                    </div>

                    {{-- Título abajo --}}
                    <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-60 text-white px-3 py-2 text-sm">
                        {{ $pelicula->titulo }}
                    </div>
                </div>

                {{-- Modal Editar --}}
                <dialog id="modal-edit-{{ $pelicula->id }}" class="rounded-md w-full max-w-lg p-6">
                    <form method="POST" action="{{ route('admin.peliculas.update', $pelicula->id) }}">
                        @csrf
                        @method('PUT')
                        <h3 class="text-xl font-bold mb-4">Editar Película</h3>
                        <!-- Campos aquí -->
                        <!-- ... -->
                        <div class="flex justify-end gap-2 mt-4">
                            <button type="button" onclick="document.getElementById('modal-edit-{{ $pelicula->id }}').close()" class="px-4 py-2 bg-gray-300 rounded">Cancelar</button>
                            <button type="submit" class="px-4 py-2 bg-yellow-600 text-white rounded">Actualizar</button>
                        </div>
                    </form>
                </dialog>

                {{-- Modal Eliminar --}}
                <dialog id="modal-delete-{{ $pelicula->id }}" class="rounded-md w-full max-w-md p-6">
                    <form method="POST" action="{{ route('admin.peliculas.destroy', $pelicula->id) }}">
                        @csrf
                        @method('DELETE')
                        <h3 class="text-lg font-bold mb-4">¿Eliminar película?</h3>
                        <p>¿Estás seguro de que deseas eliminar <strong>{{ $pelicula->titulo }}</strong>?</p>
                        <div class="mt-6 flex justify-end gap-2">
                            <button type="button" onclick="document.getElementById('modal-delete-{{ $pelicula->id }}').close()" class="px-4 py-2 bg-gray-300 rounded">Cancelar</button>
                            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded">Eliminar</button>
                        </div>
                    </form>
                </dialog>
            @endforeach
        </div>
    @endif

    {{-- Modal Crear --}}
    <dialog id="modal-create" class="rounded-md shadow-md w-full max-w-lg p-6">
        <form method="POST" action="{{ route('admin.peliculas.store') }}" enctype="multipart/form-data">
            @csrf
            <h3 class="text-xl font-bold mb-4">Agregar Película</h3>

            <label class="block mb-2">
                Título:
                <input type="text" name="titulo" class="w-full border rounded px-2 py-1" required>
            </label>

            <label class="block mb-2">
                Género:
                <input type="text" name="genero" class="w-full border rounded px-2 py-1" required>
            </label>

            <label class="block mb-4">
                Duración (minutos):
                <input type="number" name="duracion" class="w-full border rounded px-2 py-1" required>
            </label>

            <label class="block mb-4">
                Imagen:
                <input type="file" name="imagen" accept="image/*" class="w-full">
            </label>

            <div class="flex justify-end gap-2">
                <button type="button" onclick="document.getElementById('modal-create').close()" class="px-4 py-2 bg-gray-300 rounded">Cancelar</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Guardar</button>
            </div>
        </form>
    </dialog>
@endsection

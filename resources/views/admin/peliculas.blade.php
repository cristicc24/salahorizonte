@extends('layouts.admin')

@section('contenido')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Películas</h2>
        <button id="buttonNuevaPelicula" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 cursor-pointer">
            + Nueva Película
        </button>
        @if(session('success') || session('createError') || session('editError'))
            <div id="flash-message" class="fixed bottom-5 right-5 flex items-center gap-3 px-4 py-3 rounded shadow-lg z-50
                        {{ session('success') ? 'bg-green-100 border border-green-400 text-green-700' : 'bg-red-100 border border-red-400 text-red-700' }}">

                @if(session('success'))
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                @endif

                <span class="text-sm font-medium flex-1">{{ session('success') ?? session('createError') ?? session('editError') }}</span>

                <button type="button" data-close-flash class="text-lg font-bold leading-none text-gray-500 hover:text-black focus:outline-none" aria-label="Cerrar notificación">
                    &times;
                </button>
            </div>
        @endif
    </div>

    {{-- Buscador y filtros --}}
    <form method="GET" action="{{ route('admin.peliculas') }}" class="mb-6 flex flex-wrap gap-4 items-center">
        <input type="text" name="search" placeholder="Buscar título..." value="{{ request('search') }}"
               class="border border-gray-300 rounded px-3 py-2 w-64"/>
        <select name="genero" class="border border-gray-300 rounded px-3 py-2">
            <option value="">Género</option>
            @foreach($generos as $genero)
                <option value="{{ $genero }}" @selected(request('genero')==$genero)>{{ $genero }}</option>
            @endforeach
        </select>
        <select name="anio_estreno" class="border border-gray-300 rounded px-3 py-2">
            <option value="">Año Estreno</option>
            @foreach($anios as $anio)
                <option value="{{ $anio }}" @selected(request('anio_estreno')==$anio)>{{ $anio }}</option>
            @endforeach
        </select>
        
        <button type="submit" class="bg-text-color text-white px-4 py-2 rounded hover:bg-text-color/80 transition">Filtrar</button>
        <a href="{{ route('admin.peliculas') }}" id="resetFiltros" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">Resetear filtros</a>
    </form>

    @if($peliculas->isEmpty())
        <p>No hay películas que mostrar.</p>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6">
            @foreach($peliculas as $pelicula)
                <div class="relative bg-gray-100 rounded shadow overflow-hidden group"><img src="{{ asset($pelicula->foto_miniatura) }}"
                         alt="{{ $pelicula->titulo }}" class="w-full h-70 object-cover group-hover:brightness-75 transition duration-300">

                    <div class="absolute inset-0 flex items-start justify-end p-2 gap-1">
                        <label class="inline-flex items-center cursor-pointer">
                            <meta name="csrf-token" content="{{ csrf_token() }}">
                            <input name="activo" type="checkbox" class="sr-only peer toggle-activo hidden" data-id="{{ $pelicula->id }}" {{ $pelicula->activo ? 'checked' : '' }}>
                            <div class="relative w-11 h-6 bg-gray-200 rounded-full 
                                    peer dark:bg-gray-700 
                                    peer-focus:ring-4 peer-focus:ring-[#A7D7C5] 
                                    dark:peer-focus:ring-[#A7D7C5] 
                                    peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full 
                                    peer-checked:after:border-white 
                                    after:content-[''] after:absolute after:top-0.5 after:start-[2px] 
                                    after:bg-white after:border-gray-300 after:border 
                                    after:rounded-full after:h-5 after:w-5 after:transition-all 
                                    dark:border-gray-600 
                                    peer-checked:bg-green-700">
                            </div>

                        </label>

                        <!-- Botón Editar -->
                        <button data-idpelicula="{{ $pelicula->id }}"
                                class="edit bg-yellow-400 text-white px-2 py-1 rounded text-sm hover:bg-yellow-500 cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                 viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82
                                      a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1
                                      1.13-1.897L16.863 4.487Zm0 0L19.5 7.125"/>
                            </svg>
                        </button>

                        <!-- Botón Ver -->
                        <a href="/pelicula/{{ $pelicula->id }}" target="_blank" rel="noopener noreferrer"
                           class="bg-blue-500 text-white px-2 py-1 rounded text-sm hover:bg-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                 viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5
                                      12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431
                                      0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638
                                      0-8.573-3.007-9.963-7.178Z"/>
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                            </svg>
                        </a>

                        <!-- Botón Eliminar -->
                        <button data-idpelicula="{{ $pelicula->id }}"
                                class="delete bg-red-600 text-white px-2 py-1 rounded text-sm hover:bg-red-700 cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                 viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107
                                      1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0
                                      1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772
                                      5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12
                                      .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0
                                      0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964
                                      51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5
                                      0a48.667 48.667 0 0 0-7.5 0"/>
                            </svg>
                        </button>
                    </div>
                    <div class="absolute bottom-0 left-0 right-0 h-12 bg-black bg-opacity-60 text-white text-sm flex items-center justify-center text-center">
                        {{ $pelicula->titulo }}
                    </div>
                </div>

                <!-- Modal Editar -->
                <div id="backdrop-edit-{{ $pelicula->id }}" class="hidden fixed inset-0 bg-gray-400/70 bg-opacity-50 z-40" data-close-modal="edit-{{ $pelicula->id }}"></div>
                <dialog id="modal-edit-{{ $pelicula->id }}" class="rounded-md w-full max-w-lg p-6 fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 shadow-lg z-50">
                    <div class="flex justify-between items-center mb-3">
                        <h3 class="text-xl font-bold">Editar Película</h3>
                        <button type="button" data-close-modal="edit-{{ $pelicula->id }}" class="text-gray-500 cursor-pointer">X</button>
                    </div>

                    <form method="POST" action="{{ route('admin.peliculas.update', $pelicula->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <label class="block mb-2">
                            Título:
                            <input type="text" name="titulo" value="{{ $pelicula->titulo }}" class="w-full border rounded px-2 py-1" required>
                        </label>
                        <label class="block mb-2">
                            Precio:
                            <input type="number" name="precio" step="0.01" value="{{ $pelicula->precio }}" class="w-full border rounded px-2 py-1" required>
                        </label>
                        <label class="block mb-2">
                            Género:
                            <input type="text" name="genero" value="{{ $pelicula->genero }}" class="w-full border rounded px-2 py-1" required>
                        </label>
                        <label class="block mb-2">
                            Directores:
                            <input type="text" name="directores" value="{{ $pelicula->directores }}" class="w-full border rounded px-2 py-1" required>
                        </label>
                        <label class="block mb-2">
                            Edad recomendada:
                            <input type="text" name="edad_recomendada" value="{{ $pelicula->edad_recomendada }}" class="w-full border rounded px-2 py-1" required>
                        </label>
                        <label class="block mb-2">
                            Duración (min):
                            <input type="text" name="duracion" value="{{ old('duracion', $pelicula->duracion) }}" class="w-full border rounded px-2 py-1" required>
                        </label>
                        <label class="block mb-2">
                            Fecha de estreno:
                            <input type="date" name="fecha_estreno" value="{{ $pelicula->fecha_estreno }}" class="w-full border rounded px-2 py-1" required>
                        </label>
                        <label class="block mb-2">
                            Fecha de emisión:
                            <input type="date" name="fecha_emision" value="{{ $pelicula->fecha_emision }}" class="w-full border rounded px-2 py-1" required>
                        </label>
                        <label class="block mb-2">
                            Sinopsis:
                            <textarea name="sinopsis" rows="4" class="w-full border rounded px-2 py-1" required>{{ $pelicula->sinopsis }}</textarea>
                        </label>
                        <label class="block mb-2">
                            Foto miniatura:
                            <input type="file" name="foto_miniatura" accept="image/*" class="w-full">
                            @if($pelicula->foto_miniatura)
                                <img src="{{ asset($pelicula->foto_miniatura) }}" class="h-20 mt-2">
                            @endif
                        </label>
                        <label class="block mb-2">
                            Actores:
                            <input type="text" name="actores" value="{{ $pelicula->actores }}" class="w-full border rounded px-2 py-1" required>
                        </label>
                        <label class="block mb-2">
                            Enlace del tráiler:
                            <input type="url" name="enlace_trailer" value="{{ $pelicula->enlace_trailer }}" class="w-full border rounded px-2 py-1">
                        </label>
                        <label class="block mb-2">
                            Foto grande:
                            <input type="file" name="foto_grande" accept="image/*" class="w-full">
                            @if($pelicula->foto_grande)
                                <img src="{{ asset($pelicula->foto_grande) }}" class="h-32 mt-2">
                            @endif
                        </label>

                        <!-- Acciones -->
                        <div class="flex justify-end gap-2 mt-4">
                            {{-- <button type="button" onclick="closeModal('edit-{{ $pelicula->id }}')" class="px-4 py-2 bg-gray-300 rounded cursor-pointer">Cancelar</button> --}}
                            <button type="button" data-close-modal="edit-{{ $pelicula->id }}" class="px-4 py-2 bg-gray-300 rounded cursor-pointer">Cancelar</button>
                            <button type="submit" class="px-4 py-2 bg-yellow-400 text-black rounded cursor-pointer">Actualizar</button>
                        </div>
                    </form>
                </dialog>


                <div id="backdrop-delete-{{ $pelicula->id }}" class="hidden fixed inset-0 bg-gray-400/70 bg-opacity-50 z-40" data-close-modal="delete-{{ $pelicula->id }}"></div>
                <!-- Modal Eliminar -->
                <dialog id="modal-delete-{{ $pelicula->id }}" class="rounded-md w-full max-w-md p-6 fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 shadow-lg z-50">
                    <div class="flex justify-between items-center mb-3">
                        <h3 class="text-lg font-bold">¿Eliminar película?</h3>
                        <button type="button" data-close-modal="delete-{{ $pelicula->id }}" class="text-gray-500 cursor-pointer">X</button>
                    </div>

                    <p>¿Estás seguro de que deseas eliminar <strong>{{ $pelicula->titulo }}</strong>?</p>

                    <form method="POST" action="{{ route('admin.peliculas.destroy', $pelicula->id) }}" class="mt-4">
                        @csrf
                        @method('DELETE')

                        <div class="flex justify-end gap-2 mt-4">
                            <button type="button" data-close-modal="delete-{{ $pelicula->id }}" class="px-4 py-2 bg-gray-300 rounded">Cancelar</button>
                            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded">Eliminar</button>
                        </div>
                    </form>
                </dialog>
            @endforeach
        </div>
        <div class="flex justify-center mt-10 text-black">
            {{ $peliculas->onEachSide(1)->links('components.pagination') }}
        </div>
    @endif

    <div class="text-center text-black mt-2">
        Mostrando página {{ $peliculas->currentPage() }} de {{ $peliculas->lastPage() }} ({{ $peliculas->total() }} películas)
    </div>

    <!-- Modal Crear -->
    <div id="backdrop-create" class="hidden fixed inset-0 bg-gray-400/70 bg-opacity-50 z-40" data-close-modal="create"></div>
    <dialog id="modal-create" class="rounded-md w-full max-w-lg p-6 fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 shadow-lg z-50">
        <div class="flex justify-between items-center mb-3">
            <h3 class="text-xl font-bold">Agregar Película</h3>
            <button type="button" data-close-modal="create" class="text-gray-500 cursor-pointer">X</button>
        </div>

        <form method="POST" action="{{ route('admin.peliculas.store') }}" enctype="multipart/form-data">
            @csrf
        
            <label class="block mb-2">
                Título:
                <input type="text" name="titulo" class="w-full border rounded px-2 py-1" required>
            </label>
        
            <label class="block mb-2">
                Precio:
                <input type="number" name="precio" step="0.01" class="w-full border rounded px-2 py-1" required>
            </label>
        
            <label class="block mb-2">
                Género:
                <input type="text" name="genero" class="w-full border rounded px-2 py-1" required>
            </label>
        
            <label class="block mb-2">
                Directores:
                <input type="text" name="directores" class="w-full border rounded px-2 py-1" required>
            </label>
        
            <label class="block mb-2">
                Edad recomendada:
                <input type="text" name="edad_recomendada" class="w-full border rounded px-2 py-1" required>
            </label>
        
            <label class="block mb-2">
                Duración (min):
                <input type="text" name="duracion" class="w-full border rounded px-2 py-1" required>
            </label>
        
            <label class="block mb-2">
                Fecha de estreno:
                <input type="date" name="fecha_estreno" class="w-full border rounded px-2 py-1" required>
            </label>
        
            <label class="block mb-2">
                Fecha de emisión:
                <input type="date" name="fecha_emision" class="w-full border rounded px-2 py-1" required>
            </label>
        
            <label class="block mb-2">
                Sinopsis:
                <textarea name="sinopsis" rows="4" class="w-full border rounded px-2 py-1" required></textarea>
            </label>
        
            <label class="block mb-2">
                Actores:
                <input type="text" name="actores" class="w-full border rounded px-2 py-1" required>
            </label>
        
            <label class="block mb-2">
                Enlace del tráiler:
                <input type="url" name="enlace_trailer" class="w-full border rounded px-2 py-1">
            </label>
        
            <label class="block mb-2">
                Foto miniatura:
                <input type="file" name="foto_miniatura" accept="image/*" class="w-full">
            </label>
        
            <label class="block mb-2">
                Foto grande:
                <input type="file" name="foto_grande" accept="image/*" class="w-full">
            </label>        

            <!-- Acciones -->
            <div class="flex justify-end gap-2 mt-4">
                <button type="button" data-close-modal="create" class="px-4 py-2 bg-gray-300 rounded cursor-pointer">Cancelar</button>                
                <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded cursor-pointer">Guardar</button>
            </div>
        </form>
    </dialog>
@endsection

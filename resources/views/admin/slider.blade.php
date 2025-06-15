@extends('layouts.admin')

@section('contenido')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold">Sliders</h2>
    <button type="button" data-open-modal="create" class="flex items-center gap-2 bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 cursor-pointer">+ Nuevo Slider</button>

    @if(session('success') || session('createError') || session('editError'))
        <div id="flash-message" class="fixed top-5 right-5 flex items-center gap-3 px-4 py-3 rounded shadow-lg z-50
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

            <span class="text-sm font-medium flex-1"> {{ session('success') ?? session('createError') ?? session('editError') }}</span>
            <button type="button" data-close-flash class="text-lg font-bold leading-none text-gray-500 hover:text-black focus:outline-none" aria-label="Cerrar notificación">&times;</button>
        </div>
    @endif
</div>

@if($sliders->isEmpty())
    <p class="text-gray-600">No hay sliders registrados.</p>
@else
    <div class="overflow-x-auto">
        <table class="w-full text-left border mt-4 text-sm">
            <thead class="bg-gray-200">
                <tr>
                    <th class="p-2">Imagen</th>
                    <th class="p-2">Película</th>
                    <th class="p-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sliders as $slider)
                <tr class="border-t">
                    <td class="p-2">
                        <img src="{{ asset($slider->pelicula->foto_grande) }}" alt="{{ $slider->pelicula->titulo }}" class="w-32 h-20 object-cover rounded">
                    </td>
                    <td class="p-2">{{ $slider->pelicula->titulo }}</td>
                    <td class="p-2 flex gap-2">
                        <!-- Editar -->
                        <button type="button" class="bg-yellow-400 text-white px-2 py-1 rounded cursor-pointer" title="Editar"
                            data-edit-slider data-id="{{ $slider->id }}" data-pelicula-id="{{ $slider->pelicula->id }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487z" />
                            </svg>
                        </button>

                        <!-- Eliminar -->
                        <button type="button" data-open-modal="delete-{{ $slider->id }}" class="bg-red-600 text-white px-2 py-1 rounded cursor-pointer" title="Eliminar">
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
                    </td>
                </tr>

                <!-- Backdrop eliminar -->
                <div id="backdrop-delete-{{ $slider->id }}" class="hidden fixed inset-0 bg-gray-400/70 bg-opacity-50 z-40" data-close-modal="delete-{{ $slider->id }}"></div>

                <!-- Modal eliminar slider -->
                <dialog id="modal-delete-{{ $slider->id }}" class="rounded-md w-full max-w-sm p-6 fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 shadow-lg z-50">
                    <form method="POST" action="{{ route('admin.sliders.destroy', $slider->id) }}">
                        @csrf
                        @method('DELETE')

                        <div class="flex justify-between items-center mb-3">
                            <h3 class="text-lg font-bold">¿Eliminar slider?</h3>
                            <button type="button" data-close-modal="delete-{{ $slider->id }}" class="text-gray-500 cursor-pointer text-xl leading-none">&times;</button>
                        </div>

                        <p>ID: <strong>{{ $slider->id }}</strong></p>
                        <p>Película: {{ $slider->pelicula->titulo }}</p>

                        <div class="flex justify-end gap-2 mt-6">
                            <button type="button" data-close-modal="delete-{{ $slider->id }}" class="bg-gray-300 px-4 py-2 rounded cursor-pointer">Cancelar</button>
                            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded cursor-pointer">Eliminar</button>
                        </div>
                    </form>
                </dialog>
                @endforeach
            </tbody>
        </table>
    </div>
@endif

<!-- Modal Crear/Editar -->
<dialog id="modal-create" class="rounded-md w-full max-w-md p-6 fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 shadow-lg z-50">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-bold" id="modalTitle">Crear Slider</h3>
        <button type="button" class="text-gray-500 text-lg font-bold cursor-pointer" data-close-modal="create" aria-label="Cerrar">&times;</button>
    </div>

    <form id="sliderForm" method="POST" action="{{ route('admin.sliders.store') }}">
        @csrf
        <input type="hidden" name="_method" id="sliderMethod" value="POST">

        <label class="block mb-4">Película:
            <select name="idPelicula" id="idPelicula" class="w-full border rounded px-2 py-1 cursor-pointer focus:outline-none focus:ring-2 focus:ring-text-color focus:border-text-color transition duration-200" required>
                @foreach($peliculas as $pelicula)
                    <option value="{{ $pelicula->id }}">{{ $pelicula->titulo }}</option>
                @endforeach
            </select>
        </label>

        <div class="flex justify-end gap-2">
            <button type="button" class="bg-gray-300 px-4 py-2 rounded cursor-pointer" data-close-modal="create">Cancelar</button>
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded cursor-pointer">Guardar</button>
        </div>
    </form>
</dialog>
@endsection

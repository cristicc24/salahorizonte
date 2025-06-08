@extends('layouts.admin')

@section('contenido')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold">Sliders</h2>
    <button onclick="openModal('create')" class="flex items-center gap-2 bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 cursor-pointer">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Nuevo Slider
    </button>
</div>

@if(session('success') || session('createError') || session('editError'))
    <div id="flash-message" class="fixed bottom-5 right-5 px-4 py-3 rounded shadow-lg z-50 flex items-start gap-2 w-96
         {{ session('success') ? 'bg-green-100 border border-green-400 text-green-700' : 'bg-red-100 border border-red-400 text-red-700' }}">
        <div class="shrink-0 pt-1">
            @if(session('success'))
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            @else
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            @endif
        </div>
        <div class="flex-1 text-sm">
            {{ session('success') ?? session('createError') ?? session('editError') }}
        </div>
        <button onclick="document.getElementById('flash-message').remove()" class="ml-2 text-xl leading-none">&times;</button>
    </div>
@endif

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
                    @php
                        $pelicula = $peliculas->firstWhere('id', $slider->pelicula->id);
                    @endphp
                    @if($pelicula)
                        <img src="{{ $pelicula->foto_grande }}" alt="{{ $pelicula->titulo }}" class="w-32 h-20 object-cover rounded">
                    @else
                        N/A
                    @endif
                </td>
                <td class="p-2">
                    {{ $slider->pelicula->titulo }}
                </td>
                <td class="p-2 flex gap-2">
                    <button onclick="editSlider({{ $slider->id }}, {{ $slider->pelicula->id }})" class="bg-yellow-400 text-white px-2 py-1 rounded cursor-pointer" title="Editar">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125"/>
                        </svg>
                    </button>
                    <form method="POST" action="{{ route('admin.sliders.destroy', $slider->id) }}" onsubmit="return confirm('¿Seguro que querés eliminar este slider?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 text-white px-2 py-1 rounded cursor-pointer" title="Eliminar">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

<!-- Modal Crear/Editar -->
<dialog id="modal-create" class="rounded-md w-full max-w-md p-6 fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 shadow-lg z-50">
    <form id="sliderForm" method="POST" action="{{ route('admin.sliders.store') }}">
        @csrf
        <input type="hidden" name="_method" id="sliderMethod" value="POST">

        <h3 class="text-lg font-bold mb-4" id="modalTitle">Crear Slider</h3>

        <label class="block mb-4">Película:
            <select name="idPelicula" id="idPelicula" class="w-full border rounded px-2 py-1 cursor-pointer" required>
                @foreach($peliculas as $pelicula)
                    <option value="{{ $pelicula->id }}">{{ $pelicula->titulo }}</option>
                @endforeach
            </select>
        </label>

        <div class="flex justify-end gap-2">
            <button type="button" onclick="closeModal('create')" class="bg-gray-300 px-4 py-2 rounded">Cancelar</button>
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Guardar</button>
        </div>
    </form>
</dialog>

<script>
    function openModal(id) {
        const modal = document.getElementById('modal-' + id);
        if (modal) modal.showModal();
    }

    function closeModal(id) {
        const modal = document.getElementById('modal-' + id);
        if (modal) modal.close();
    }

    function editSlider(id, idPelicula) {
        const form = document.getElementById('sliderForm');
        form.action = `/adminSH/sliders/${id}`;
        document.getElementById('modalTitle').innerText = 'Editar Slider';
        document.getElementById('sliderMethod').value = 'PUT';

        const select = document.getElementById('idPelicula');
        for (let i = 0; i < select.options.length; i++) {
            if (parseInt(select.options[i].value) === idPelicula) {
                select.selectedIndex = i;
                break;
            }
        }

        openModal('create');
    }

    document.addEventListener('DOMContentLoaded', () => {
        const flash = document.getElementById('flash-message');
        if (flash) setTimeout(() => flash.remove(), 3000);
    });
</script>
@endsection

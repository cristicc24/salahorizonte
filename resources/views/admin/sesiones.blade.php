@extends('layouts.admin')

@section('contenido')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold">Sesiones</h2>
    <button onclick="openModal('create')" class="flex items-center gap-2 bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Nueva Sesión
    </button>
</div>

@if($sesiones->isEmpty())
    <p class="text-gray-600">No hay sesiones registradas.</p>
@else
<div class="overflow-x-auto">
    <table class="w-full text-left border mt-4 text-sm">
        <thead class="bg-gray-200">
            <tr>
                <th class="p-2">Película</th>
                <th class="p-2">Sala</th>
                <th class="p-2">Butacas reservadas</th>
                <th class="p-2">Fecha y hora</th>
                <th class="p-2">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sesiones as $sesion)
                <tr class="border-t">
                    <td class="p-2">{{ $sesion->pelicula->titulo }}</td>
                    <td class="p-2">{{ $sesion->sala->idSala }}</td>
                    <td class="p-2">{{ $sesion->numButacasReservadas }}</td>
                    <td class="p-2">{{ \Carbon\Carbon::parse($sesion->fechaHora)->format('d/m/Y H:i') }}</td>
                    <td class="p-2 flex gap-2">
                        <!-- Editar -->
                        <button onclick="openModal('edit-{{ $sesion->id }}')" class="bg-yellow-400 text-white px-2 py-1 rounded">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82
                                    a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1
                                    1.13-1.897L16.863 4.487Zm0 0L19.5 7.125"/>
                            </svg>
                        </button>
                        <!-- Eliminar -->
                        <button onclick="openModal('delete-{{ $sesion->id }}')" class="bg-red-600 text-white px-2 py-1 rounded">
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

                <!-- Modal Editar -->
                <dialog id="modal-edit-{{ $sesion->id }}" class="rounded-md w-full max-w-md p-6 fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 shadow-lg z-50">
                    <form method="POST" action="{{ route('admin.sesiones.update', $sesion->id) }}">
                        @csrf
                        @method('PUT')

                        <h3 class="text-lg font-bold mb-4">Editar Sesión</h3>

                        <label class="block mb-2">Película:
                            <select name="idPelicula" class="w-full border rounded px-2 py-1">
                                @foreach($peliculas as $pelicula)
                                    <option value="{{ $pelicula->id }}" @selected($pelicula->id == $sesion->idPelicula)>
                                        {{ $pelicula->titulo }}
                                    </option>
                                @endforeach
                            </select>
                        </label>

                        <label class="block mb-2">Sala:
                            <select name="idSala" class="w-full border rounded px-2 py-1">
                                @foreach($salas as $sala)
                                    <option value="{{ $sala->id }}">Sala {{ $sala->id }}</option>
                                @endforeach
                            </select>
                        </label>

                        <label class="block mb-4">Fecha y hora:
                            <input type="datetime-local" name="fechaHora" value="{{ \Carbon\Carbon::parse($sesion->fechaHora)->format('Y-m-d\TH:i') }}" class="w-full border rounded px-2 py-1" required>
                        </label>

                        <div class="flex justify-end gap-2">
                            <button type="button" onclick="closeModal('edit-{{ $sesion->id }}')" class="bg-gray-300 px-4 py-2 rounded">Cancelar</button>
                            <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded">Actualizar</button>
                        </div>
                    </form>
                </dialog>

                <!-- Modal Eliminar -->
                <dialog id="modal-delete-{{ $sesion->id }}" class="rounded-md w-full max-w-sm p-6 fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 shadow-lg z-50">
                    <form method="POST" action="{{ route('admin.sesiones.destroy', $sesion->id) }}">
                        @csrf
                        @method('DELETE')

                        <h3 class="text-lg font-bold mb-4">¿Eliminar sesión?</h3>
                        <p>Película: <strong>{{ $sesion->pelicula->titulo }}</strong></p>
                        <p>Sala: <strong>{{ $sesion->sala->id }}</strong></p>
                        <p>Fecha: {{ \Carbon\Carbon::parse($sesion->fechaHora)->format('d/m/Y H:i') }}</p>

                        <div class="flex justify-end gap-2 mt-4">
                            <button type="button" onclick="closeModal('delete-{{ $sesion->id }}')" class="bg-gray-300 px-4 py-2 rounded">Cancelar</button>
                            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded">Eliminar</button>
                        </div>
                    </form>
                </dialog>
            @endforeach
        </tbody>
    </table>
</div>
@endif

<!-- Modal Crear Sesión -->
<dialog id="modal-create" class="rounded-md w-full max-w-md p-6 fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 shadow-lg z-50">
    <form method="POST" action="{{ route('admin.sesiones.store') }}">
        @csrf

        <h3 class="text-lg font-bold mb-4">Crear Sesión</h3>

        <label class="block mb-2">Película:
            <select name="idPelicula" class="w-full border rounded px-2 py-1">
                @foreach($peliculas as $pelicula)
                    <option value="{{ $pelicula->id }}">{{ $pelicula->titulo }}</option>
                @endforeach
            </select>
        </label>

        <label class="block mb-2">Sala:
            <select name="idSala" class="w-full border rounded px-2 py-1">
                @foreach($salas as $sala)
                    <option value="{{ $sala->id }}">{{ $sala->id }}</option>
                @endforeach
            </select>
        </label>

        <label class="block mb-4">Fecha y hora:
            <input type="datetime-local" name="fechaHora" class="w-full border rounded px-2 py-1" required>
        </label>

        <div class="flex justify-end gap-2">
            <button type="button" onclick="closeModal('create')" class="bg-gray-300 px-4 py-2 rounded">Cancelar</button>
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Guardar</button>
        </div>
    </form>
</dialog>

<!-- Scripts -->
<script>
    function openModal(id) {
        const modal = document.getElementById('modal-' + id);
        if (modal) modal.showModal();
    }

    function closeModal(id) {
        const modal = document.getElementById('modal-' + id);
        if (modal) modal.close();
    }
</script>
@endsection

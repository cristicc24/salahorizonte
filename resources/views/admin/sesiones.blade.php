@extends('layouts.admin')

@section('contenido')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold">Sesiones</h2>
    <button type="button" data-open-modal="create" class="flex items-center gap-2 bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 cursor-pointer">
        + Nueva Sesión
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

            <span class="text-sm font-medium flex-1"> {{ session('success') ?? session('createError') ?? session('editError') }}</span>
            <button type="button" data-close-flash class="text-lg leading-none text-gray-500 hover:text-black focus:outline-none" aria-label="Cerrar notificación">&times;</button>
        </div>
    @endif

</div>

@if($sesiones->isEmpty())
    @if(isset($salaSeleccionada))
        @php
            $salaNombre = optional($salas->firstWhere('id', $salaSeleccionada))->idSala ?? $salaSeleccionada;
        @endphp
        <p class="text-gray-600">
            Esta sala (<strong>Sala {{ $salaNombre }}</strong>) no tiene sesiones registradas.
        </p>
        <div class="mt-2 flex gap-3">
            <a href="{{ route('admin.sesiones') }}" class="text-blue-600 hover:underline">Ver todas las sesiones</a>
            <a href="{{ route('admin.salas') }}" class="text-gray-700 hover:underline">Volver a Salas</a>
        </div>
    @else
        <p class="text-gray-600">No hay sesiones registradas.</p>
    @endif
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
                            <button type="button" data-open-modal="edit-{{ $sesion->id }}" class="bg-yellow-400 text-white px-2 py-1 rounded cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82
                                        a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1
                                        1.13-1.897L16.863 4.487Zm0 0L19.5 7.125"/>
                                </svg>
                            </button>

                            <button type="button" data-open-modal="delete-{{ $sesion->id }}" class="bg-red-600 text-white px-2 py-1 rounded cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
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
                            @if (session('editError') && session('openModal') === 'edit-' . $sesion->id)
                                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4 text-sm">
                                    {{ session('editError') }}
                                </div>
                                <script>window.onload = () => openModal('edit-{{ $sesion->id }}');</script>
                            @endif

                            <label class="block mb-2">Película:
                                <select name="idPelicula" class="w-full border rounded px-2 py-1 cursor-pointer">
                                    @foreach($peliculas as $pelicula)
                                        <option value="{{ $pelicula->id }}" @selected(old('idPelicula', $sesion->idPelicula) == $pelicula->id)>
                                            {{ $pelicula->titulo }}
                                        </option>
                                    @endforeach
                                </select>
                            </label>

                            <label class="block mb-2">Sala:
                                <select name="idSala" class="w-full border rounded px-2 py-1 cursor-pointer">
                                    @foreach($salas as $sala)
                                        <option value="{{ $sala->id }}" @selected(old('idSala', $sesion->idSala) == $sala->id)>Sala {{ $sala->id }}</option>
                                    @endforeach
                                </select>
                            </label>

                            <label class="block mb-4">Fecha y hora:
                                <input type="datetime-local" name="fechaHora" value="{{ old('fechaHora', \Carbon\Carbon::parse($sesion->fechaHora)->format('Y-m-d\TH:i')) }}" class="w-full border rounded px-2 py-1 cursor-pointer" required>
                            </label>

                            <div class="flex justify-end gap-2">
                                <button type="button" data-close-modal="edit-{{ $sesion->id }}" class="bg-gray-300 px-4 py-2 rounded cursor-pointer">Cancelar</button>
                                <button type="submit" class="bg-yellow-400 text-white px-4 py-2 rounded cursor-pointer">Actualizar</button>
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
                                <button type="button" data-close-modal="delete-{{ $sesion->id }}" class="bg-gray-300 px-4 py-2 rounded cursor-pointer">Cancelar</button>
                                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded cursor-pointer">Eliminar</button>
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
        @if (session('createError') && session('openModal') === 'create')
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4 text-sm">
                {{ session('createError') }}
            </div>
            <script>window.onload = () => openModal('create');</script>
        @endif

        <label class="block mb-2">Película:
            <select name="idPelicula" class="w-full border rounded px-2 py-1 cursor-pointer">
                @foreach($peliculas as $pelicula)
                    <option value="{{ $pelicula->id }}" @selected(old('idPelicula') == $pelicula->id)>
                        {{ $pelicula->titulo }}
                    </option>
                @endforeach
            </select>
        </label>

        <label class="block mb-2">Sala:
            <select name="idSala" class="w-full border rounded px-2 py-1 cursor-pointer">
                @foreach($salas as $sala)
                    <option value="{{ $sala->id }}" @selected(old('idSala') == $sala->id)>
                        Sala {{ $sala->id }}
                    </option>
                @endforeach
            </select>
        </label>

        <label class="block mb-4">Fecha y hora:
            <input type="datetime-local" name="fechaHora" value="{{ old('fechaHora') }}" class="w-full border rounded px-2 py-1 cursor-pointer" required>
        </label>

        <div class="flex justify-end gap-2">
            <button type="button" data-close-modal="create" class="bg-gray-300 px-4 py-2 rounded cursor-pointer">Cancelar</button>
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded cursor-pointer">Guardar</button>
        </div>
    </form>
</dialog>

@endsection

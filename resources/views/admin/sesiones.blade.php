@extends('layouts.admin')

@section('contenido')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold">Sesiones</h2>

    <div class="flex gap-2 items-center">
        @if(isset($salaSeleccionada))
            @php
                $salaNombre = optional($salas->firstWhere('id', $salaSeleccionada))->idSala ?? $salaSeleccionada;
            @endphp
            <span class="text-sm text-gray-700">Filtrando por: <strong>Sala {{ $salaNombre }}</strong></span>
            
            <a href="{{ route('admin.sesiones') }}"
            class="flex items-center gap-2 bg-gray-200 hover:bg-gray-300 text-gray-800 text-sm px-4 py-2 rounded cursor-pointer">
                Limpiar filtro
            </a>
        @endif

        <button type="button" data-open-modal="create" class="flex items-center gap-2 bg-green-600 text-white text-sm px-4 py-2 rounded hover:bg-green-700 cursor-pointer">
            + Nueva Sesión
        </button>
    </div>
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
            <button type="button" data-close-flash class="text-lg leading-none text-gray-500 hover:text-black focus:outline-none" aria-label="Cerrar notificación">&times;</button>
        </div>
    @endif
</div>


@if($sesiones->isEmpty())
    @if(isset($salaSeleccionada))
        <p class="text-gray-600"> Esta (<strong>Sala {{ $salaNombre }}</strong>) no tiene sesiones registradas.</p>
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
                    <th class="p-2">Estado</th>
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

                        @php
                            $estado = $sesion->estado;
                            $estadoColor = match($estado) {
                                'Activa' => 'text-blue-600',
                                'En curso' => 'text-yellow-600',
                                'Finalizada' => 'text-gray-600',
                                default => 'text-black',
                            };
                        @endphp
                        <td class="p-2 font-semibold {{ $estadoColor }}">{{ $estado }}</td>

                        <td class="p-2 flex gap-2">
                            @if($estado === 'Activa')
                                <button type="button" data-open-modal="edit-{{ $sesion->id }}" class="bg-yellow-400 text-white px-2 py-1 rounded cursor-pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5"
                                        stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zM19.5 7.125L16.863 4.487"/>
                                    </svg>
                                </button>
                            @else
                                <span title="No se puede editar esta sesión (estado: {{ $estado }})"
                                    class="bg-yellow-200 text-white px-2 py-1 rounded opacity-50 cursor-not-allowed flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5"
                                        stroke="currentColor" class="size-6 text-yellow-500">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zM19.5 7.125L16.863 4.487"/>
                                    </svg>
                                </span>
                            @endif

                            <button type="button" data-open-modal="delete-{{ $sesion->id }}" class="bg-red-600 text-white px-2 py-1 rounded cursor-pointer">
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
                        <button type="button" data-close-modal="edit-{{ $sesion->id }}" class="absolute top-3 right-3 text-xl font-bold text-gray-500 hover:text-black cursor-pointer" aria-label="Cerrar modal">&times;</button>
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
                                <select name="idPelicula" class="w-full border rounded px-2 py-1 cursor-pointer focus:outline-none focus:ring-2 focus:ring-text-color focus:border-text-color transition duration-200">
                                    @foreach($peliculas as $pelicula)
                                        <option value="{{ $pelicula->id }}" @selected(old('idPelicula', $sesion->idPelicula) == $pelicula->id)>
                                            {{ $pelicula->titulo }}
                                        </option>
                                    @endforeach
                                </select>
                            </label>

                            <label class="block mb-2">Sala:
                                <select name="idSala" class="w-full border rounded px-2 py-1 cursor-pointer focus:outline-none focus:ring-2 focus:ring-text-color focus:border-text-color transition duration-200">
                                    @foreach($salas as $sala)
                                        <option value="{{ $sala->id }}" @selected(old('idSala', $sesion->idSala) == $sala->id)>Sala {{ $sala->idSala }}</option>
                                    @endforeach
                                </select>
                            </label>

                            <label class="block mb-4">Fecha y hora:
                                <input type="datetime-local" name="fechaHora" value="{{ old('fechaHora', \Carbon\Carbon::parse($sesion->fechaHora)->format('Y-m-d\TH:i')) }}" class="w-full border rounded px-2 py-1 cursor-pointer focus:outline-none focus:ring-2 focus:ring-text-color focus:border-text-color transition duration-200" required>
                            </label>

                            <div class="flex justify-end gap-2">
                                <button type="button" data-close-modal="edit-{{ $sesion->id }}" class="bg-gray-300 px-4 py-2 rounded cursor-pointer">Cancelar</button>
                                <button type="submit" class="bg-yellow-400 text-white px-4 py-2 rounded cursor-pointer">Actualizar</button>
                            </div>
                        </form>
                    </dialog>

                    <!-- Modal Eliminar -->
                    <dialog id="modal-delete-{{ $sesion->id }}" class="rounded-md w-full max-w-sm p-6 fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 shadow-lg z-50">
                        <button type="button" data-close-modal="delete-{{ $sesion->id }}" class="absolute top-3 right-3 text-xl font-bold text-gray-500 hover:text-black cursor-pointer" aria-label="Cerrar modal">&times;</button>
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
    <button type="button" data-close-modal="create" class="absolute top-3 right-3 text-xl font-bold text-gray-500 hover:text-black cursor-pointer" aria-label="Cerrar modal">&times;</button>
    <form method="POST" action="{{ route('admin.sesiones.store') }}">
        @csrf
        <h3 class="text-lg font-bold mb-4">Crear Sesión</h3>

        <label class="block mb-2">Película:
            <select name="idPelicula" class="w-full border rounded px-2 py-1 cursor-pointer focus:outline-none focus:ring-2 focus:ring-text-color focus:border-text-color transition duration-200">
                @foreach($peliculas as $pelicula)
                    <option value="{{ $pelicula->id }}" @selected(old('idPelicula') == $pelicula->id)>
                        {{ $pelicula->titulo }}
                    </option>
                @endforeach
            </select>
        </label>

        <label class="block mb-2">Sala:
            <select name="idSala" class="w-full border rounded px-2 py-1 cursor-pointer focus:outline-none focus:ring-2 focus:ring-text-color focus:border-text-color transition duration-200">
                @foreach($salas as $sala)
                    <option value="{{ $sala->id }}" @selected(old('idSala') == $sala->id)>
                        Sala {{ $sala->idSala }}
                    </option>
                @endforeach
            </select>
        </label>

        <label class="block mb-4">Fecha y hora:
            <input type="datetime-local" name="fechaHora" value="{{ old('fechaHora') }}" class="w-full border rounded px-2 py-1 cursor-pointer focus:outline-none focus:ring-2 focus:ring-text-color focus:border-text-color transition duration-200" required>
        </label>

        <div class="flex justify-end gap-2">
            <button type="button" data-close-modal="create" class="bg-gray-300 px-4 py-2 rounded cursor-pointer">Cancelar</button>
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded cursor-pointer">Guardar</button>
        </div>
    </form>
</dialog>

@endsection

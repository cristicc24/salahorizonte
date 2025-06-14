@extends('layouts.admin')

@section('contenido')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold">Salas</h2>
    <button data-open-modal="create" class="flex items-center gap-2 bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 cursor-pointer">+ Nueva Sala</button>

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

@if($salas->isEmpty())
    <p class="text-gray-600">No hay salas registradas.</p>
@else
<div class="overflow-x-auto">
    <table class="w-full text-left border mt-4 text-sm">
        <thead class="bg-gray-200">
            <tr>
                <th class="p-2">ID Sala</th>
                <th class="p-2">Filas</th>
                <th class="p-2">Columnas</th>
                <th class="p-2">Total Butacas</th>
                <th class="p-2">Sesiones</th>
                <th class="p-2">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($salas as $sala)
                <tr class="border-t">
                    <td class="p-2">{{ $sala->idSala }}</td>
                    <td class="p-2">{{ $sala->cantidadFilas }}</td>
                    <td class="p-2">{{ $sala->cantidadColumnas }}</td>
                    <td class="p-2">{{ $sala->numButacasTotales }}</td>
                    <td class="p-2">{{ $sala->sesiones_count  }}</td>
                    <td class="p-2 flex gap-2">
                        <!-- Editar -->
                        @if($sala->sesiones_count == 0)
                            <button type="button" data-open-modal="edit-{{ $sala->id }}" class="bg-yellow-400 text-white px-2 py-1 rounded cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82
                                    a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1
                                    1.13-1.897L16.863 4.487Zm0 0L19.5 7.125"/>
                            </svg>
                        </button>
                        @else
                            <button class="bg-gray-200 text-gray-400 px-2 py-1 rounded cursor-not-allowed" disabled title="Esta sala tiene sesiones">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="size-6 opacity-50">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82
                                        a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1
                                        1.13-1.897L16.863 4.487Zm0 0L19.5 7.125"/>
                                </svg>
                            </button>
                        @endif

                        {{-- Ver sesiones de esa sala --}}
                        @if($sala->sesiones_count > 0)
                            <a href="{{ route('admin.sesiones', ['idSala' => $sala->id]) }}" class="bg-blue-500 text-white px-2 py-1 rounded cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                            </a>
                        @else
                            <button class="bg-gray-200 text-gray-400 px-2 py-1 rounded cursor-not-allowed" disabled title="Esta sala no tiene sesiones">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                            </button>
                        @endif

                        <!-- Eliminar -->
                        <button type="button" data-open-modal="delete-{{ $sala->id }}" class="bg-red-600 text-white px-2 py-1 rounded cursor-pointer">
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

                <!-- Modal editar -->
                <dialog id="modal-edit-{{ $sala->id }}" class="rounded-md w-full max-w-md p-6 fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 shadow-lg z-50">
                    <button type="button" data-close-modal="edit-{{ $sala->id }}" class="absolute top-3 right-3 text-xl font-bold text-gray-500 hover:text-black cursor-pointer" aria-label="Cerrar modal">&times;</button>
                    <form method="POST" action="{{ route('admin.salas.update', $sala->id) }}">
                        @csrf
                        @method('PUT')
                        <h3 class="text-lg font-bold mb-4">Editar Sala</h3>

                        @if (session('editError') && session('openModal') === 'edit-' . $sala->id)
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4 text-sm">{{ session('editError') }}</div>
                            <script>
                                window.onload = () => openModal('edit-{{ $sala->id }}');
                            </script>
                        @endif

                        <label class="block mb-2">Cantidad de filas (mín 5 - máx 13): <input type="number" name="cantidadFilas" value="{{ old('cantidadFilas', $sala->cantidadFilas) }}" 
                            class="w-full border rounded px-2 py-1" required min="5" max="13">
                        </label>

                        <label class="block mb-4">Cantidad de columnas (mín 5 - máx 13): <input type="number" name="cantidadColumnas" value="{{ old('cantidadColumnas', $sala->cantidadColumnas) }}" 
                            class="w-full border rounded px-2 py-1" required min="5" max="13"></label>

                        <div class="flex justify-end gap-2">
                            <button type="button" data-close-modal="edit-{{ $sala->id }}" class="bg-gray-300 px-4 py-2 rounded cursor-pointer">Cancelar</button>
                            <button type="submit" class="bg-yellow-400 text-white px-4 py-2 rounded cursor-pointer">Actualizar</button>
                        </div>
                    </form>
                </dialog>


                <!-- Modal eliminar -->
                <dialog id="modal-delete-{{ $sala->id }}" class="rounded-md w-full max-w-sm p-6 fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 shadow-lg z-50">
                    <button type="button" data-close-modal="delete-{{ $sala->id }}" class="absolute top-3 right-3 text-xl font-bold text-gray-500 hover:text-black cursor-pointer" aria-label="Cerrar modal">&times;</button>
                    <form method="POST" action="{{ route('admin.salas.destroy', $sala->id) }}">
                        @csrf
                        @method('DELETE')

                        <h3 class="text-lg font-bold mb-4">¿Eliminar sala?</h3>

                        <p>ID: <strong>{{ $sala->id }}</strong></p>
                        <p>Butacas: {{ $sala->numButacasTotales }}</p>

                        {{-- Mostrar sesiones asociadas --}}
                        @if($sala->sesiones->isEmpty())
                            <p class="text-sm text-gray-500 mt-4">Esta sala no tiene sesiones asociadas.</p>
                        @else
                            <p class="mt-4 font-semibold">Sesiones asociadas:</p>
                            <ul class="list-disc list-inside text-sm text-gray-600 max-h-32 overflow-y-auto">
                                @foreach($sala->sesiones as $sesion)
                                    <li>{{ \Carbon\Carbon::parse($sesion->fechaHora)->format('d/m/Y H:i') }}</li>
                                @endforeach
                            </ul>
                        @endif

                        <div class="flex justify-end gap-2 mt-6">
                            <button type="button" data-close-modal="delete-{{ $sala->id }}" class="bg-gray-300 px-4 py-2 rounded cursor-pointer">Cancelar</button>
                            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded cursor-pointer">Eliminar</button>
                        </div>
                    </form>
                </dialog>
            @endforeach
        </tbody>
    </table>
</div>
@endif

<!-- Modal crear sala -->
<dialog id="modal-create" class="rounded-md w-full max-w-md p-6 fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 shadow-lg z-50">
    <button type="button" data-close-modal="create" class="absolute top-3 right-3 text-xl font-bold text-gray-500 hover:text-black cursor-pointer" aria-label="Cerrar modal">&times;</button>
    <form method="POST" action="{{ route('admin.salas.store') }}">
        @csrf
        <h3 class="text-lg font-bold mb-4">Crear Sala</h3>

        <label class="block mb-2">ID de sala (único): 
            <input type="number" name="idSala" value="{{ old('idSala') }}" class="w-full border rounded px-2 py-1" required>
        </label>

        <label class="block mb-2">Cantidad de filas (mín 5 - máx 13): 
            <input type="number" name="cantidadFilas" value="{{ old('cantidadFilas') }}"  class="w-full border rounded px-2 py-1" required min="5" max="13">
        </label>

        <label class="block mb-4">Cantidad de columnas (mín 5 - máx 13): 
            <input type="number" name="cantidadColumnas" value="{{ old('cantidadColumnas') }}" class="w-full border rounded px-2 py-1" required min="5" max="13">
        </label>

        <div class="flex justify-end gap-2">
            <button type="button" data-close-modal="create" class="bg-gray-300 px-4 py-2 rounded">Cancelar</button>
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Guardar</button>
        </div>
    </form>
</dialog>

@endsection

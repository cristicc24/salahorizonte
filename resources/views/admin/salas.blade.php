@extends('layouts.admin')

@section('contenido')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold">Salas</h2>
    <button onclick="openModal('create')" class="flex items-center gap-2 bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 cursor-pointer">
        + Nueva Sala
    </button>

    @if(session('success') || session('createError') || session('editError'))
        <div id="flash-message"
            class="fixed bottom-5 right-5 flex items-center gap-3 px-4 py-3 rounded shadow-lg z-50
                    {{ session('success') ? 'bg-green-100 border border-green-400 text-green-700' : 'bg-red-100 border border-red-400 text-red-700' }}">
            
            @if(session('success'))
                <!-- Icono de éxito -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            @else
                <!-- Icono de error -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            @endif

            <span class="text-sm font-medium flex-1">
                {{ session('success') ?? session('createError') ?? session('editError') }}
            </span>

            <!-- Botón para cerrar -->
            <button onclick="document.getElementById('flash-message').remove()"
                    class="text-lg font-bold leading-none text-gray-500 hover:text-black focus:outline-none"
                    aria-label="Cerrar notificación">
                &times;
            </button>
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
                <th class="p-2">ID</th>
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
                    <td class="p-2">{{ $sala->id }}</td>
                    <td class="p-2">{{ $sala->cantidadFilas }}</td>
                    <td class="p-2">{{ $sala->cantidadColumnas }}</td>
                    <td class="p-2">{{ $sala->numButacasTotales }}</td>
                    <td class="p-2">{{ $sala->sesiones_count  }}</td>
                    <td class="p-2 flex gap-2">
                        <!-- Editar -->
                        @if($sala->sesiones_count == 0)
                        <button onclick="openModal('edit-{{ $sala->id }}')" class="bg-yellow-400 text-white px-2 py-1 rounded cursor-pointer">
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
                            <button class="bg-gray-200 text-gray-400 px-2 py-1 rounded cursor-not-allowed" disabled>
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

                        <!-- Eliminar -->
                        <button onclick="openModal('delete-{{ $sala->id }}')" class="bg-red-600 text-white px-2 py-1 rounded cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </td>
                </tr>

                <!-- Modal editar -->

                <dialog id="modal-edit-{{ $sala->id }}" class="rounded-md w-full max-w-md p-6 fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 shadow-lg z-50">
                    <form method="POST" action="{{ route('admin.salas.update', $sala->id) }}">
                        @csrf
                        @method('PUT')

                        <h3 class="text-lg font-bold mb-4">Editar Sala</h3>

                        {{-- Mostrar error si viene de validación --}}
                        @if (session('editError') && session('openModal') === 'edit-' . $sala->id)
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4 text-sm">
                                {{ session('editError') }}
                            </div>
                            <script>
                                window.onload = () => openModal('edit-{{ $sala->id }}');
                            </script>
                        @endif

                        <label class="block mb-2">Cantidad de filas (máx 13):
                            <input
                                type="number"
                                name="cantidadFilas"
                                value="{{ old('cantidadFilas', $sala->cantidadFilas) }}"
                                class="w-full border rounded px-2 py-1"
                                required
                                min="1"
                                max="13"
                            >
                        </label>

                        <label class="block mb-4">Cantidad de columnas (máx 13):
                            <input
                                type="number"
                                name="cantidadColumnas"
                                value="{{ old('cantidadColumnas', $sala->cantidadColumnas) }}"
                                class="w-full border rounded px-2 py-1"
                                required
                                min="1"
                                max="13"
                            >
                        </label>

                        <div class="flex justify-end gap-2">
                            <button type="button" onclick="closeModal('edit-{{ $sala->id }}')" class="bg-gray-300 px-4 py-2 rounded">Cancelar</button>
                            <button type="submit" class="bg-yellow-400 text-white px-4 py-2 rounded cursor-pointer">Actualizar</button>
                        </div>
                    </form>
                </dialog>


                <!-- Modal eliminar -->
                <dialog id="modal-delete-{{ $sala->id }}" class="rounded-md w-full max-w-sm p-6 fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 shadow-lg z-50">
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
                            <button type="button" onclick="closeModal('delete-{{ $sala->id }}')" class="bg-gray-300 px-4 py-2 rounded cursor-pointer">Cancelar</button>
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
    <form method="POST" action="{{ route('admin.salas.store') }}">
        @csrf
        <h3 class="text-lg font-bold mb-4">Crear Sala</h3>
        @if (session('createError'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4 text-sm">
                {{ session('createError') }}
            </div>
            <script>
                window.onload = () => openModal('create');
            </script>
        @endif

        <label class="block mb-2">ID de sala (único):
            <input
                type="number"
                name="idSala"
                value="{{ old('idSala') }}"
                class="w-full border rounded px-2 py-1 @if(session('createError')) border-red-500 @endif"
                required
            >
        </label>

        <label class="block mb-2">Cantidad de filas (máx 13):
            <input
                type="number"
                name="cantidadFilas"
                value="{{ old('cantidadFilas') }}"
                class="w-full border rounded px-2 py-1"
                required
                min="1"
                max="13"
            >
        </label>

        <label class="block mb-4">Cantidad de columnas (máx 13):
            <input
                type="number"
                name="cantidadColumnas"
                value="{{ old('cantidadColumnas') }}"
                class="w-full border rounded px-2 py-1"
                required
                min="1"
                max="13"
            >
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

    //validación del formulario
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('input[name="cantidadFilas"], input[name="cantidadColumnas"]').forEach(input => {
            input.addEventListener('input', () => {
                const val = parseInt(input.value);
                if (val > 13) input.value = 13;
                if (val < 1) input.value = 1;
            });
        });
    });

    // Permitir cerrar modales con ESC o clic fuera del contenido
    document.querySelectorAll("dialog").forEach(dialog => {
        // Cierre con clic fuera del modal
        dialog.addEventListener("click", e => {
            const rect = dialog.getBoundingClientRect();
            if (
                e.clientX < rect.left || e.clientX > rect.right ||
                e.clientY < rect.top || e.clientY > rect.bottom
            ) {
                dialog.close();
            }
        });

        // Cierre con tecla ESC
        dialog.addEventListener("keydown", e => {
            if (e.key === "Escape") {
                dialog.close();
            }
        });
    });

    document.addEventListener('DOMContentLoaded', () => {
        const flash = document.getElementById('flash-message');
        if (flash) {
            setTimeout(() => {
                flash.remove();
            }, 3000); 
        }
    });
</script>
@endsection

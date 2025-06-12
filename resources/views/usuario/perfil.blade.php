@include('head', ['title' => 'Mi cuenta | Sala Horizonte'])
@include('cabeceraCompleta' , ['completo' => true])

<div class="max-w-6xl mx-auto px-4 py-6 mt-[140px]">

    {{-- Contenedor de información del usuario --}}
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <h2 class="text-2xl font-semibold mb-4 border-b pb-2">Información del Usuario</h2>
        <div class="space-y-2">
            <p><span class="font-medium">Nombre:</span> {{ $usuario->name }}</p>
            <p><span class="font-medium">Email:</span> {{ $usuario->email }}</p>
            {{-- Agrega más campos si es necesario --}}
        </div>
    </div>

    {{-- Contenedor de pedidos del usuario --}}
    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-semibold mb-4 border-b pb-2">Mis Pedidos</h2>
        
        @forelse ($pedidos as $pedido)
            <div class="mb-6 border border-gray-200 rounded-lg p-4 bg-gray-50">
                <div class="md:flex md:justify-between md:items-center mb-2">
                    <h3 class="text-lg font-bold">Pedido #{{ $pedido->id }}</h3>
                    <p class="text-sm text-gray-500">{{ $pedido->created_at->format('d/m/Y H:i') }}</p>
                </div>

                <p><span class="font-medium">Método de pago:</span> {{ $pedido->metodoPago }}</p>
                <p><span class="font-medium">Total:</span> {{ $pedido->totalPedido }} €</p>

                <div class="mt-4">
                    <h4 class="font-semibold mb-2">Líneas de pedido:</h4>
                    <ul class="list-disc list-inside space-y-1 text-sm">
                        @foreach ($pedido->lineas as $linea)
                            <li>Butaca: {{ $linea->numButaca }} | Sesión ID: {{ $linea->sesion_id }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @empty
            <p class="text-gray-600">No tienes pedidos todavía.</p>
        @endforelse
    </div>

</div>


@include('footer');
@include('head', ['title' => 'Mi cuenta | Sala Horizonte'])
@include('cabeceraCompleta', ['completo' => true])

<div class="max-w-6xl mx-auto px-4 py-10 mt-24 font-primary-font text-white">

    {{-- Información del Usuario --}}
    <div class="bg-primary-color shadow-lg rounded-lg p-6 mb-10 border border-white/10">
        <h2 class="text-2xl sm:text-3xl font-bold mb-4 border-b border-white/20 pb-2">Información del Usuario</h2>
        <div class="space-y-2 text-lg">
            <p><span class="font-semibold text-text-color">Nombre:</span> {{ $usuario->name }}</p>
            <p><span class="font-semibold text-text-color">Email:</span> {{ $usuario->email }}</p>
        </div>
    </div>

    {{-- Pedidos del Usuario --}}
    <div class="bg-primary-color shadow-lg rounded-lg p-6 border border-white/10">
        <h2 class="text-2xl sm:text-3xl font-bold mb-4 border-b border-white/20 pb-2">Mis Pedidos</h2>

        @forelse ($pedidos as $pedido)
            <div class="mb-6 border border-white/10 rounded-lg p-4 bg-white/5 hover:bg-white/10 transition duration-300">
                <div class="flex justify-between items-center mb-2 flex-wrap gap-2">
                    <h3 class="text-lg font-bold text-text-color">Pedido #{{ $pedido->id }}</h3>
                    <p class="text-sm text-white/70">{{ $pedido->created_at->format('d/m/Y H:i') }}</p>
                </div>

                <p><span class="font-semibold text-text-color">Método de pago:</span> {{ $pedido->metodoPago }}</p>
                <p><span class="font-semibold text-text-color">Total:</span> {{ $pedido->totalPedido }} €</p>

                <div class="mt-4">
                    <h4 class="font-semibold mb-2 text-text-color">Líneas de pedido:</h4>
                    <ul class="list-disc list-inside space-y-1 text-sm text-white">
                        @foreach ($pedido->lineas as $linea)
                            <li>Butaca: {{ $linea->numButaca }} | Sesión ID: {{ $linea->sesion_id }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @empty
            <p class="text-white/80">No tienes pedidos todavía.</p>
        @endforelse
    </div>

</div>

@include('footer')

@include('head', ['title' => 'Proceso de Compra | Sala Horizonte'])

<div class="min-h-screen bg-gray-100 flex items-center justify-center p-6">
    <div class="bg-white shadow-lg rounded-lg w-full max-w-md p-8 font-sans">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">
            TPV - {{ ucfirst($metodo) }}
        </h2>

        <p class="text-gray-700 text-center mb-4">
            Estás realizando el pago con <strong>{{ ucfirst($metodo) }}</strong> para <strong>{{ $infoPelicula->titulo }}</strong>.
        </p>

        <p class="text-gray-600 text-sm mb-6 text-center">
            Butacas: 
            @php $butacaArray = json_decode($butacas); @endphp
            {{ implode(', ', $butacaArray) }}
        </p>

        <form method="GET" action="{{ route('procesoCompra.paso4') }}">
            <input type="hidden" name="idSesion" value="{{ $idSesion }}">
            <input type="hidden" name="butacas" value="{{ $butacas }}">
            <input type="hidden" name="metodo" value="{{ $metodo }}">
            <input type="hidden" name="orderID" value="{{ $orderID }}">

            @if ($metodo === 'tarjeta')
                <div class="space-y-4">
                    <input type="text" name="nombre" placeholder="Titular de la tarjeta" class="w-full px-4 py-2 border rounded" required>
                    <input type="text" name="numero" placeholder="Número de tarjeta" class="w-full px-4 py-2 border rounded" required maxlength="19">
                    <div class="flex gap-4">
                        <input type="text" name="caducidad" placeholder="MM/AA" class="w-1/2 px-4 py-2 border rounded" required maxlength="5">
                        <input type="text" name="cvv" placeholder="CVV" class="w-1/2 px-4 py-2 border rounded" required maxlength="4">
                    </div>
                </div>
            @elseif ($metodo === 'bizum')
                <div class="space-y-4">
                    <input type="text" name="telefono" placeholder="Teléfono asociado a Bizum" class="w-full px-4 py-2 border rounded" required maxlength="9">
                    <input type="password" name="pin" placeholder="PIN Bizum" class="w-full px-4 py-2 border rounded" required maxlength="6">
                </div>
            @elseif ($metodo === 'googlepay')
                <div class="space-y-4 text-center text-gray-600">
                    <p class="text-sm mb-4">Autenticando con Google Pay...</p>
                    <p class="text-xs">Presiona el botón para continuar</p>
                </div>
            @endif

            <button type="submit" class="mt-6 w-full bg-green-600 text-white py-2 rounded hover:bg-green-700 transition">
                Confirmar y pagar
            </button>
        </form>

        <div class="mt-6 text-center">
            <a href="{{ route('procesoCompra.paso3', ['idSesion' => $idSesion, 'butacas' => $butacas]) }}"
               class="text-sm text-blue-600 hover:underline">
                Cancelar y volver
            </a>
        </div>
    </div>
</div>

@include('head', ['title' => 'Proceso de Compra | Sala Horizonte'])

<div class="min-h-screen bg-gray-100 flex items-center justify-center p-6">
    <div class="bg-white shadow-lg rounded-lg w-full max-w-md p-8 font-sans">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">
            TPV - {{ ucfirst($metodo) }}
        </h2>

        <p class="text-gray-700 text-center mb-4">
            Estás realizando el pago con <strong>{{ ucfirst($metodo) }}</strong> para <strong>{{ $infoPelicula->pelicula->titulo }}</strong>.
        </p>

        <p class="text-gray-600 text-sm mb-6 text-center">
            Butacas: 
            @php $butacaArray = json_decode($butacas); @endphp
            {{ implode(', ', $butacaArray) }}
        </p>

        <form method="POST" action="{{ route('procesoCompra.procesarPago') }}">
            @csrf
            <input type="hidden" name="idSesion" value="{{ $idSesion }}">
            <input type="hidden" name="butacas" value="{{ $butacas }}">
            <input type="hidden" name="metodo" value="{{ $metodo }}">

            @if ($metodo === 'tarjeta')
                <div class="space-y-4">
                    <div>
                        <label for="nombre" class="block text-sm font-medium text-gray-700">Titular de la tarjeta</label>
                        <input type="text" id="nombre" name="nombre" placeholder="Titular de la tarjeta"
                            class="w-full px-4 py-2 border rounded {{ $errors->has('nombre') ? 'border-red-500' : '' }}"
                            value="{{ old('nombre') }}" required>
                        @if ($errors->has('nombre'))
                            <p class="text-sm text-red-500 mt-1">{{ $errors->first('nombre') }}</p>
                        @endif
                    </div>
                    <div>
                        <label for="numero" class="block text-sm font-medium text-gray-700">Número de tarjeta</label>
                        <input type="text" id="numero" name="numero" placeholder="Número de tarjeta"
                               class="w-full px-4 py-2 border rounded {{ $errors->has('numero') ? 'border-red-500' : '' }}"
                               value="{{ old('numero') }}" required maxlength="19">
                        @if ($errors->has('numero'))
                            <p class="text-sm text-red-500 mt-1">{{ $errors->first('numero') }}</p>
                        @endif
                    </div>
                    <div class="flex gap-4">
                        <div class="w-1/2">
                            <label for="caducidad" class="block text-sm font-medium text-gray-700">Caducidad</label>
                            <input type="text" id="caducidad" name="caducidad" placeholder="MM/AA"
                                   class="w-full px-4 py-2 border rounded {{ $errors->has('caducidad') ? 'border-red-500' : '' }}"
                                   value="{{ old('caducidad') }}" required maxlength="5">
                            @if ($errors->has('caducidad'))
                                <p class="text-sm text-red-500 mt-1">{{ $errors->first('caducidad') }}</p>
                            @endif
                        </div>

                        <div class="w-1/2">
                            <label for="cvv" class="block text-sm font-medium text-gray-700">CVV</label>
                            <input type="text" id="cvv" name="cvv" placeholder="CVV"
                                   class="w-full px-4 py-2 border rounded {{ $errors->has('cvv') ? 'border-red-500' : '' }}"
                                   value="{{ old('cvv') }}" required maxlength="4">
                            @if ($errors->has('cvv'))
                                <p class="text-sm text-red-500 mt-1">{{ $errors->first('cvv') }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            @elseif ($metodo === 'bizum')
                <div class="space-y-4">
                    <div>
                        <label for="telefono" class="block text-sm font-medium text-gray-700">Teléfono asociado a Bizum</label>
                        <input type="text" id="telefono" name="telefono" placeholder="Teléfono asociado a Bizum"
                               class="w-full px-4 py-2 border rounded {{ $errors->has('telefono') ? 'border-red-500' : '' }}"
                               value="{{ old('telefono') }}" required maxlength="9">
                        @if ($errors->has('telefono'))
                            <p class="text-sm text-red-500 mt-1">{{ $errors->first('telefono') }}</p>
                        @endif
                    </div>
                    <div>
                        <label for="pin" class="block text-sm font-medium text-gray-700">PIN Bizum</label>
                        <input type="password" id="pin" name="pin" placeholder="PIN Bizum"
                               class="w-full px-4 py-2 border rounded {{ $errors->has('pin') ? 'border-red-500' : '' }}"
                               required maxlength="6">
                        @if ($errors->has('pin'))
                            <p class="text-sm text-red-500 mt-1">{{ $errors->first('pin') }}</p>
                        @endif
                    </div>
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

        <div class="mt-4 text-center">
            <a href="{{ route('procesoCompra.paso3', ['idSesion' => $idSesion, 'butacas' => $butacas]) }}"
               class="text-sm text-blue-600 hover:underline">
                Cancelar y volver
            </a>
        </div>
    </div>
</div>

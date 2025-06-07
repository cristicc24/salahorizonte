@extends('layouts.procesoCompra')

@section('Proceso de Compra')
    <div class="max-w-xl mx-auto text-white mt-28">
        <h2 class="text-3xl font-bold mb-6">Selecciona método de pago</h2>

        <ul class="space-y-4">
            @foreach(['tarjeta' => 'Pago con tarjeta', 'bizum' => 'Bizum', 'googlepay' => 'Google Pay'] as $metodo => $texto)
                <li>
                    <a href="{{ route('procesoCompra.tpv', [
                        'idSesion' => $infoPelicula->id,
                        'butacas' => implode(',', $butacas),
                        'metodo' => $metodo
                    ]) }}"
                    class="block bg-gray-800 hover:bg-gray-700 px-6 py-3 rounded">
                        {{ $texto }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
@endsection

@extends('layouts.procesoCompra')

@section('Proceso de Compra')
    <div class="max-w-2xl mx-auto text-white mt-28">
        <h2 class="text-3xl font-bold mb-6">Resumen de compra</h2>

        <div class="mb-4">
            @php
                $fecha = \Carbon\Carbon::parse($infoPelicula->fechaHora);
                $dia = $fecha->format('d F Y');
                $horaSesion = $fecha->format('H:i');
            @endphp
            <p><strong>Película:</strong> {{ $infoPelicula->titulo }}</p>
            <p><strong>Sesión:</strong> {{ $dia }} - {{ $horaSesion }}</p>
        </div>

        <div>
            <p class="mb-2"><strong>Butacas seleccionadas:</strong></p>
            <ul class="list-disc list-inside">
                @foreach($butacas as $butaca)
                    <li>{{ $butaca }}</li>
                @endforeach
            </ul>
        </div>

        <form action="{{ route('procesoCompra.paso3') }}" method="GET" class="mt-6">
            {{-- @csrf --}}
            <input type="hidden" name="idSesion" value="{{ $infoPelicula->id }}">
            <input type="hidden" name="butacas" value="{{ json_encode($butacas) }}">

            <button type="submit" class="mt-4 bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
                Confirmar y pagar
            </button>
        </form>
    </div>
@endsection

@extends('layouts.procesoCompra')

@section('Proceso de Compra')
    <div class="max-w-2xl mx-auto text-white mt-32 p-6 my-4 mb-4 font-primary-font">
        <h2 class="text-3xl font-bold mb-6 border-b border-white/90 pb-2">Resumen de compra</h2>

        <div class="mb-6 space-y-4">
            @php
                $fecha = \Carbon\Carbon::parse($infoPelicula->fechaHora);
                $dia = $fecha->format('d F Y');
                $horaSesion = $fecha->format('H:i');
            @endphp

            <p class="flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 0 1-1.125-1.125M3.375 
                          19.5h1.5C5.496 19.5 6 18.996 6 18.375m-3.75 0V5.625m0 
                          12.75v-1.5c0-.621.504-1.125 1.125-1.125m18.375 
                          2.625V5.625m0 12.75c0 .621-.504 1.125-1.125 
                          1.125m1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125m0 
                          3.75h-1.5A1.125 1.125 0 0 1 18 
                          18.375M20.625 4.5H3.375m17.25 0c.621 0 
                          1.125.504 1.125 1.125M20.625 
                          4.5h-1.5C18.504 4.5 18 5.004 18 
                          5.625m3.75 0v1.5c0 .621-.504 1.125-1.125 
                          1.125M3.375 4.5c-.621 0-1.125.504-1.125 
                          1.125M3.375 4.5h1.5C5.496 4.5 6 5.004 6 
                          5.625m-3.75 0v1.5c0 .621.504 1.125 1.125 
                          1.125m0 0h1.5m-1.5 0c-.621 0-1.125.504-1.125 
                          1.125v1.5c0 .621.504 1.125 1.125 
                          1.125m1.5-3.75C5.496 8.25 6 7.746 6 
                          7.125v-1.5M4.875 8.25C5.496 8.25 6 8.754 6 
                          9.375v1.5m0-5.25v5.25m0-5.25C6 5.004 6.504 
                          4.5 7.125 4.5h9.75c.621 0 1.125.504 1.125 
                          1.125m1.125 2.625h1.5m-1.5 0A1.125 1.125 0 0 
                          1 18 7.125v-1.5m1.125 2.625c-.621 0-1.125.504-1.125 
                          1.125v1.5m2.625-2.625c.621 0 1.125.504 1.125 
                          1.125v1.5c0 .621-.504 1.125-1.125 
                          1.125M18 5.625v5.25M7.125 12h9.75m-9.75 0A1.125 
                          1.125 0 0 1 6 10.875M7.125 12C6.504 12 6 12.504 6 
                          13.125m0-2.25C6 11.496 5.496 12 4.875 12M18 
                          10.875c0 .621-.504 1.125-1.125 
                          1.125M18 10.875c0 .621.504 1.125 1.125 
                          1.125m-2.25 0c.621 0 1.125.504 1.125 
                          1.125m-12 5.25v-5.25m0 5.25c0 .621.504 1.125 
                          1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125m-12 
                          0v-1.5c0-.621-.504-1.125-1.125-1.125M18 
                          18.375v-5.25m0 5.25v-1.5c0-.621.504-1.125 
                          1.125-1.125M18 13.125v1.5c0 .621.504 1.125 
                          1.125 1.125M18 13.125c0-.621.504-1.125 
                          1.125-1.125M6 13.125v1.5c0 .621-.504 1.125-1.125 
                          1.125M6 13.125C6 12.504 5.496 12 4.875 
                          12m-1.5 0h1.5m-1.5 0c-.621 0-1.125.504-1.125 
                          1.125v1.5c0 .621.504 1.125 1.125 
                          1.125M19.125 12h1.5m0 0c.621 0 1.125.504 1.125 
                          1.125v1.5c0 .621-.504 1.125-1.125 
                          1.125m-17.25 0h1.5m14.25 0h1.5"/>
                </svg>
                <span class="font-semibold">Película:</span> {{ $infoPelicula->titulo }}
            </p>

            <p class="flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <span class="font-semibold">Sesión:</span> {{ $dia }} - {{ $horaSesion }}
            </p>
        </div>

        <div class="mb-6">
            <p class="flex items-center gap-2 font-semibold mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 0 1 0 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 0 1 0-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375Z" />
                </svg>
                Butacas seleccionadas:
            </p>
            <ul class="list-disc list-inside pl-4 space-y-1">
                @foreach(json_decode($butacas) as $butaca)
                    <li>{{ $butaca }}</li>
                @endforeach
            </ul>
        </div>

        <div class="flex justify-between items-center mt-8">
            <a href="{{ url()->previous() }}" class="flex items-center gap-2 text-white border border-white px-4 py-2 rounded hover:bg-white/80 hover:text-gray-800 transition duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 15.75 3 12m0 0 3.75-3.75M3 12h18" />
                </svg>
                Volver atrás
            </a>

            <form action="{{ route('procesoCompra.paso3') }}" method="GET">
                <input type="hidden" name="idSesion" value="{{ $infoPelicula->id }}">
                <input type="hidden" name="butacas" value="{{ $butacas }}">
                <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition duration-200 cursor-pointer">
                    Confirmar y pagar
                </button>
            </form>
        </div>
    </div>
@endsection

@extends('layouts.procesoCompra')

@section('Proceso de Compra')
<div class="w-full font-primary-font mt-28">
    <div class="relative w-full h-[200px] sm:h-[320px] md:h-[380px] lg:h-[420px] xl:h-[480px] font-primary-font">
        <img src="../{{ asset($infoPelicula->foto_grande) }}" 
             alt="Foto de portada de la película" 
             class="w-full h-full object-cover object-top">
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent pointer-events-none"></div>
        <p class="text-white text-2xl sm:text-3xl md:text-4xl font-bold text-center absolute bottom-[-1rem] md:bottom-[-1rem] w-[90%] left-1/2 -translate-x-1/2">
            {{ $infoPelicula->titulo }}
        </p>
    </div>
</div>

<div class="container mx-auto my-10 flex justify-center flex-wrap font-primary-font">
    <p class="text-white text-xl sm:text-2xl font-bold tracking-wider text-center mb-6">ELIGE TUS ASIENTOS</p>

    <div class="flex justify-center gap-8 w-full mt-4">
        <div class="flex items-center gap-2">
            <svg class="w-3 h-3 sm:w-4 sm:h-4 md:w-8 md:h-8"><use href="#v-icon_standard-available"/></svg>
            <span class="text-white">Disponible</span>
        </div>
        <div class="flex items-center gap-2">
            <svg class="w-3 h-3 sm:w-4 sm:h-4 md:w-8 md:h-8"><use href="#v-icon_standard-unavailable"/></svg>
            <span class="text-white">Ocupado</span>
        </div>
        <div class="flex items-center gap-2">
            <svg class="w-3 h-3 sm:w-4 sm:h-4 md:w-8 md:h-8"><use href="#v-icon_standard-selected"/></svg>
            <span class="text-white">Seleccionado</span>
        </div>
    </div>

    <div id='contenedor-mapa' class="mt-10 grid gap-[2px] w-full max-w-lg text-white text-xl grid-cols-{{ $infoPelicula->cantidadColumnas + 1 }}">
        <div id="pantalla" class="col-start-2 col-end-{{ $infoPelicula->cantidadColumnas + 2 }} text-center bg-[#555555] mb-1 px-2">Pantalla</div>

        <div></div>
        @for ($i = 1; $i <= $infoPelicula->cantidadColumnas; $i++)
            <div class="text-center">{{ $i }}</div>
        @endfor

        @php
            $mapaObjeto = json_decode($infoPelicula->butacasReservadas, true);
            $mapaLetras = array_keys($mapaObjeto);
        @endphp

        @foreach($mapaLetras as $letra)
            <div class="text-center">{{ $letra }}</div>
            @for ($c = 1; $c <= $infoPelicula->cantidadColumnas; $c++)
                @if ($mapaObjeto[$letra][$c])
                    <div class="flex justify-center"><svg class="w-3 h-3 sm:w-4 sm:h-4 md:w-8 md:h-8"><use href="#v-icon_standard-unavailable"/></svg></div>
                @else
                    <div class="flex justify-center">
                        <svg class="w-3 h-3 sm:w-4 sm:h-4 md:w-8 md:h-8 cursor-pointer butaca-disponible" data-fila="{{ $letra }}" data-columna="{{ $c }}">
                            <use href="#v-icon_standard-available"/></svg>
                    </div>
                @endif
            @endfor
        @endforeach
    </div>

    <div id="butacasSeleccionadas" class="text-white w-full flex justify-center items-center h-8 mt-6 text-base sm:text-lg"></div>
    
    {{-- ✅ Mensaje de error si no se selecciona ninguna butaca --}}
    <div id="mensaje-error-butacas" class="text-red-500 text-center mt-2 hidden text-sm sm:text-base">
        Debes seleccionar al menos una butaca.
    </div>

    <!-- Navegación -->
    <div class="w-full flex flex-col sm:flex-row justify-around items-center gap-4 mt-6">
        <a href="{{ url()->previous() }}" 
           class="flex items-center gap-2 text-white border border-white px-4 py-2 rounded hover:bg-white/80 hover:text-gray-800 transition duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                 stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M6.75 15.75 3 12m0 0 3.75-3.75M3 12h18" />
            </svg>
            Volver atrás
        </a>

        <form id="formContinuar" method="GET" action="{{ route('procesoCompra.paso2') }}">
            <input type="hidden" name="idSesion" value="{{ $idSesion }}">
            <input type="hidden" name="butacas" id="inputButacas">
            <button type="submit" class="bg-text-color text-white px-6 py-2 rounded hover:bg-text-color/80 cursor-pointer mt-2 sm:mt-0 text-lg sm:text-xl">
                Continuar
            </button>
        </form>
    </div>
</div>

@endsection

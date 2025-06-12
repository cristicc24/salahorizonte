@include('head', ['title' => $nombrePelicula . ' | Sala Horizonte'])
@include('cabeceraCompleta' , ['completo' => true])


<div class="bg-primary-color w-full font-primary-font mt-28">
    <div class="relative w-full h-[240px] sm:h-[320px] md:h-[380px] lg:h-[420px] xl:h-[480px]">
        <img src="../{{ $foto_grande }}" alt="Foto de portada de la película" class="w-full h-full object-cover object-top">
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent pointer-events-none"></div>
        <a href="{{ $trailer }}" rel="noopener noreferrer" target="_blank"
        class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-9">
            <div class="w-14 h-14 bg-white/70 rounded-full flex items-center justify-center shadow-lg hover:scale-105 transition-transform">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-black" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M8 5v14l11-7z"/>
                </svg>
            </div>
        </a>
        <p class="text-white text-2xl sm:text-3xl md:text-4xl font-bold text-center absolute bottom-[-1rem]  md:bottom-[-1rem] w-[90%] left-1/2 -translate-x-1/2">
            {{ $nombrePelicula }}
        </p>
    </div>

    <div class="flex flex-col md:flex-row gap-6 text-white mt-3 md:mt-10 px-4 md:mr-1">
        <div class="w-full md:w-1/4 relative">
            <img src="../{{ $foto_miniatura }}" alt="Foto miniatura"
                class="hidden md:block absolute top-[-40%] right-0 w-[180px] lg:w-[200px] xl:w-[220px]">
        </div>

        <div class="w-full md:w-3/4 grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div class="space-y-4">
                <div><h3 class="text-text-color text-2xl">DIRECTOR/ES</h3><p>{{ $directores }}</p></div>
                <div><h3 class="text-text-color text-2xl">ACTORES</h3><p>{{ $actores }}</p></div>
                <div><h3 class="text-text-color text-2xl">SINOPSIS</h3><p>{{ $sinopsis }}</p></div>
            </div>
            <div class="space-y-4">
                <div><h3 class="text-text-color text-2xl">DURACIÓN</h3><p>{{ $duracion }}</p></div>
                <div><h3 class="text-text-color text-2xl">FECHA DE ESTRENO</h3><p>{{ $fecha_estreno }}</p></div>
                <div><h3 class="text-text-color text-2xl">GÉNERO/S</h3><p>{{ $genero }}</p></div>
                <div><p>Apta para {{ $edad_recomendada }}</p></div>
                <div><h3 class="text-text-color text-2xl">PRECIO ENTRADA</h3><p>{{ $precio }}€</p></div>
            </div>
        </div>
    </div>
</div>

{{-- SESIONES --}}

@php
    use Carbon\Carbon;
    $hoy = Carbon::today();
@endphp

<div class="container mx-auto px-4 py-6 font-primary-font">
    <h1 class="text-2xl sm:text-3xl font-bold text-white mb-6 text-center">Sesiones de la película</h1>

    <div id='contendor-dias' class="flex sm:justify-center space-x-4 mb-4 overflow-x-scroll sm:overflow-auto">
        @for($i = 0; $i < 5; $i++)
            @php
                $dia = $hoy->copy()->addDays($i);
                $fecha = $dia->format('Y-m-d');
                $etiqueta = $i == 0 ? 'Hoy' : $dia->format('D d/m');
            @endphp
            <button class="btn-dia px-4 py-2 rounded bg-text-color text-white hover:bg-text-color/80 transition duration-300"
                data-fecha="{{ $fecha }}">
                {{ $etiqueta }}
            </button>
        @endfor
    </div>

    <div id="lista-sesiones" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
        @foreach($sesiones as $sesion)
            @php
                $fechaSesion = Carbon::parse($sesion->fechaHora)->format('Y-m-d');
                $horaSesion = Carbon::parse($sesion->fechaHora)->format('H:i');
            @endphp
            <div class="border-2 border-text-color/70 rounded-lg shadow-md p-4 my-4 hover:border-text-color transition duration-300 sesion " data-dia="{{ $fechaSesion }}">
                <h2 class="text-xl font-semibold text-white mb-2">Sala {{ $sesion->idSala }}</h2>
                <p class="text-white"><strong>Hora:</strong> {{ $horaSesion }}</p>
                <p class="text-white"><strong>Butacas Reservadas:</strong> {{ $sesion->numButacasReservadas }}</p>
                @php
                    $total = $sesion->numButacasTotales;
                    $ocupadas = $sesion->numButacasReservadas;
                    $completa = $ocupadas >= $total;
                @endphp

                <button 
                    class="btnMostrarMapa ml-auto w-full items-center mt-3 px-4 py-2 {{ $completa ? 'bg-gray-400 cursor-not-allowed' : 'bg-white/50 hover:bg-white/80 cursor-pointer' }} text-black rounded transition duration-300"
                    data-idsesion="{{ $completa ? '' : $sesion->id }}"
                    {{ $completa ? 'disabled' : '' }}>
                    {{ $completa ? 'Sala Completa' : 'Ver Detalles' }}
                </button>
            </div>
        @endforeach
    </div>

    <!-- Definición del ícono de butaca -->
    <svg style="display: none;">
        <symbol id="v-icon_standard-available" viewBox="0 0 35 35" fill="gray" stroke="none" xmlns="http://www.w3.org/2000/svg">
            <path fill="transparent" d="M0 0h35v35H0z"></path>
            <g transform="translate(5 4)" style="fill:#a1a7b1;stroke:#000;stroke-miterlimit:10">
                <rect width="25" height="27" rx="1"></rect>
                <rect width="24" height="26" x=".5" y=".5" rx=".5" style="fill:none"></rect>
            </g>
            <g transform="translate(28 11)" style="fill:#a1a7b1;stroke:#000;stroke-miterlimit:10">
                <rect width="3" height="15" rx="1"></rect>
                <rect width="2" height="14" x=".5" y=".5" rx=".5" style="fill:none"></rect>
            </g>
            <g transform="translate(4 11)" style="fill:#a1a7b1;stroke:#000;stroke-miterlimit:10">
                <rect width="3" height="15" rx="1"></rect>
                <rect width="2" height="14" x=".5" y=".5" rx=".5" style="fill:none"></rect>
            </g>
        </symbol>
    </svg>

    <svg style="display: none;">
        <symbol id="v-icon_standard-unavailable" viewBox="0 0 35 35" fill="#555555" stroke="none" xmlns="http://www.w3.org/2000/svg">
            <path fill="transparent" data-name="icon/Seat Picker/Seat/Available Standard Copy 4 background" d="M0 0h35v35H0z"></path>
            <g transform="translate(5 4)" style="fill:#555555;stroke:#000;stroke-miterlimit:10">
                <rect width="25" height="27" rx="1" style="stroke:none" stroke="none"></rect>
                <rect width="24" height="26" x=".5" y=".5" rx=".5" style="fill:none"></rect>
            </g>
            <g data-name="Rectangle" transform="translate(28 11)" style="fill:#555555;stroke:#000;stroke-miterlimit:10">
                <rect width="3" height="15" rx="1" style="stroke:none" stroke="none"></rect>
                <rect width="2" height="14" x=".5" y=".5" rx=".5" style="fill:none"></rect>
            </g>
            <g data-name="Rectangle Copy 6" transform="translate(4 11)" style="fill:#555555;stroke:#000;stroke-miterlimit:10">
                <rect width="3" height="15" rx="1" style="stroke:none" stroke="none"></rect>
                <rect width="2" height="14" x=".5" y=".5" rx=".5" style="fill:none"></rect>
            </g>
        </symbol>
    </svg>

    <div id="mapa-butacas" class="mt-4">
        <div class="flex justify-center">
            <div>
                <div id='contenedor-mapa' class="grid gap-[2px] max-w-full text-white text-xl">

                </div>
            </div>
        </div>
    </div>
</div>

<div class="text-white font-primary-font px-4 py-6">
    <p class="w-full text-center text-2xl sm:text-3xl lg:text-4xl my-8 font-bold">PELÍCULAS RELACIONADAS</p>
    <div class="relative flex justify-center items-center flex-col">
        <div id="carousel-container" class="overflow-x-auto lg:overflow-hidden max-w-7xl w-full">

            <div id="carousel-inner" @class(['flex', 'transition-transform', 'duration-500', 'ease-in-out', 'justify-center' => count($peliculasRelacionadas) <= 4])>
                @foreach ($peliculasRelacionadas as $pelicula)
                    <div class="min-w-[80%] sm:min-w-[45%] md:min-w-[30%] lg:min-w-[23%] h-[400px] box-border relative mr-8">
                        <div class="rounded-lg shadow-lg overflow-hidden h-full">
                            <a href="/pelicula/{{ $pelicula->id }}" rel="noopener noreferrer">
                                <img src="../{{ $pelicula->foto_miniatura }}" alt="{{ $pelicula->titulo }}" class="w-full h-full object-cover object-top">
                            </a>
                        </div>
                        <div class="absolute bottom-0 w-full bg-black/45 h-[64px] flex items-center justify-center">
                            <h2 class="text-center text-white text-2xl font-semibold truncate p-4">
                                {{ $pelicula->titulo }}
                            </h2>
                        </div>
                        <div class="absolute top-0 left-0 w-full flex justify-start">
                            <a href="{{ $pelicula->enlace_trailer }}" rel="noopener noreferrer"
                                class="bg-text-color hover:bg-text-color/80 text-white p-2 rounded-tl-lg transition">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-5 h-5" viewBox="0 0 24 24">
                                    <path d="M8 5v14l11-7z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        @if(count($peliculasRelacionadas) > 4)
        <div class="p-8 gap-4">
            <button id="prev" class="hover:bg-text-color/80 text-white p-2 rounded-full cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-10">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                </svg>
            </button>
            <button id="next" class="hover:bg-text-color/80 text-white p-2 rounded-full cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-10">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                </svg>
            </button>
        </div>
        @endif
    </div>
</div>


@include('footer');
@include('head', ['title' => $nombrePelicula . ' | Sala Horizonte'])
@include('cabeceraCompleta' , ['completo' => true])


<div class="bg-primary-color w-full font-primary-font mt-28">
    <div class="relative w-full h-100">
        <img src="{{ $foto_grande }}" alt="" class="w-full h-full object-cover object-top">
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent pointer-events-none"></div>
        <img src="{{ $foto_miniatura }}" alt="" class="absolute top-[80%] left-[12%] w-[200px]">
        <a href="{{ $trailer }}" rel="noopener noreferrer" class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-10">
            <div class="w-14 h-14 bg-white/70 rounded-full flex items-center justify-center shadow-lg hover:scale-105 transition-transform">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-black" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M8 5v14l11-7z"/>
                </svg>
            </div>
        </a>
    </div>
    <div class="mx-115">
        <p class="text-5xl font-bold absolute bottom-95 text-white">{{$nombrePelicula}}</p>
        <div class="flex gap-8 w-full text-white mt-10 text-lg text-justify
                    [&_div]:flex [&_div]:flex-col
                    [&_div_>_h3]:text-2xl [&_div_>_h3]:text-text-color">
            <div class="w-[70%] gap-y-6">
                <div>
                    <h3>DIRECTOR/ES</h3>
                    <p>{{$directores}}</p>
                </div>
                <div>
                    <h3>ACTORES</h3>
                    <p>{{$actores}}</p>
                </div>
                <div>
                    <h3>SINOPSIS</h3>
                    <p>{{$sinopsis}}</p>
                </div>
            </div>
            <div class="w-[28%] gap-y-6">
                <div>
                    <h3>DURACIÓN</h3>
                    <p>{{$duracion}}</p>
                </div>
                <div>
                    <h3>FECHA DE ESTRENO</h3>
                    <p>{{$fecha_estreno}}</p>
                </div>
                <div>
                    <h3>GÉNERO/S</h3>
                    <p>{{ $genero }}</p>
                </div>
                <div>
                    <p>Apta para {{ $edad_recomendada }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- SESIONES --}}

@php
    use Carbon\Carbon;
    $hoy = Carbon::today();
@endphp

<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold text-white mb-6 text-center">Sesiones de la película</h1>

    <!-- Menú de días -->
    <div class="flex justify-center space-x-4 mb-4">
        @for($i = 0; $i < 5; $i++)
            @php
                $dia = $hoy->copy()->addDays($i);
                $fecha = $dia->format('Y-m-d');
                $etiqueta = $i == 0 ? 'Hoy' : $dia->format('D d/m');
            @endphp
            <button 
                class="px-4 py-2 rounded bg-blue-500 text-white hover:bg-blue-600"
                onclick="filtrarPorDia('{{ $fecha }}')">
                {{ $etiqueta }}
            </button>
        @endfor
    </div>

    <!-- Sesiones -->
    <div id="lista-sesiones" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($sesiones as $sesion)
            @php
                $fechaSesion = Carbon::parse($sesion->fechaHora)->format('Y-m-d');
                $horaSesion = Carbon::parse($sesion->fechaHora)->format('H:i');
            @endphp
            <div class="bg-gray-800 rounded-lg shadow-md p-4 hover:bg-gray-700 transition duration-300 sesion" data-dia="{{ $fechaSesion }}">
                <h2 class="text-xl font-semibold text-white mb-2">Sala {{ $sesion->idSala }}</h2>
                <p class="text-white"><strong>Hora:</strong> {{ $horaSesion }}</p>
                <p class="text-white"><strong>Butacas Reservadas:</strong> {{ $sesion->numButacasReservadas }}</p>
                <button 
                    class="inline-block mt-3 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600"
                    onclick="mostrarMapa('{{ $sesion->idSala }}')">
                    Ver Detalles
                </button>
            </div>
        @endforeach
    </div>
      <!-- Definición del ícono de butaca -->
<svg style="display: none;">
    <symbol id="v-icon_standard-available" viewBox="0 0 35 35" fill="white" stroke="none" xmlns="http://www.w3.org/2000/svg">
        <path fill="transparent" d="M0 0h35v35H0z"></path>
        <g transform="translate(5 4)" style="fill:#a1a7b1;stroke:#4e5a6c;stroke-miterlimit:10">
            <rect width="25" height="27" rx="1"></rect>
            <rect width="24" height="26" x=".5" y=".5" rx=".5" style="fill:none"></rect>
        </g>
        <g transform="translate(28 11)" style="fill:#a1a7b1;stroke:#4e5a6c;stroke-miterlimit:10">
            <rect width="3" height="15" rx="1"></rect>
            <rect width="2" height="14" x=".5" y=".5" rx=".5" style="fill:none"></rect>
        </g>
        <g transform="translate(4 11)" style="fill:#a1a7b1;stroke:#4e5a6c;stroke-miterlimit:10">
            <rect width="3" height="15" rx="1"></rect>
            <rect width="2" height="14" x=".5" y=".5" rx=".5" style="fill:none"></rect>
        </g>
    </symbol>
</svg>

<symbol id="v-icon_standard-selected" viewBox="0 0 35 35" fill="none" stroke="none" xmlns="http://www.w3.org/2000/svg">
  <path fill="transparent" data-name="icon/Seat Picker/Seat/Available Standard Copy 4 background" d="M0 0h35v35H0z"></path>
  <g transform="translate(5 4)" style="fill:#0068c8;stroke:#023d75;stroke-miterlimit:10">
    <rect width="25" height="27" rx="1" style="stroke:none" stroke="none"></rect>
    <rect width="24" height="26" x=".5" y=".5" rx=".5" style="fill:none"></rect>
  </g>
  <g data-name="Rectangle" transform="translate(28 11)" style="fill:#0068c8;stroke:#023d75;stroke-miterlimit:10">
    <rect width="3" height="15" rx="1" style="stroke:none" stroke="none"></rect>
    <rect width="2" height="14" x=".5" y=".5" rx=".5" style="fill:none"></rect>
  </g>
  <g data-name="Rectangle Copy 6" transform="translate(4 11)" style="fill:#0068c8;stroke:#023d75;stroke-miterlimit:10">
    <rect width="3" height="15" rx="1" style="stroke:none" stroke="none"></rect>
    <rect width="2" height="14" x=".5" y=".5" rx=".5" style="fill:none"></rect>
  </g>
</symbol>

<div id="mapa-butacas" class="mt-4">
    <!-- Contenedor principal -->
    <div class="flex justify-center">
        <div>

            <div id='contenedor-mapa' class="grid grid-cols-8 gap-[2px] max-w-full text-white text-xs">
                
            </div>
        </div>
    </div>
</div>




    <script>
        function mostrarMapa(idSesion) {
            const sesionId = idSesion;
            const mapa = document.getElementById('mapa-butacas');
            const contenedor = document.getElementById('contenedor-mapa');

            if(sesionId) {
                fetch(`/sesion/${sesionId}/ocupados`)
                    .then(response => response.json())
                    .then(ocupados => {
                        mapa.classList.remove('hidden');
                        contenedor.innerHTML = ''; // Limpiar mapa

                        const columnas = 7, filas = 8, total = 56, filaLabels = ['A','B','C','D','E','F','G','H'];

                        // Encabezados
                        contenedor.innerHTML += `<div></div>`; 
                        for(let c=1; c<=columnas; c++) {
                            contenedor.innerHTML += `<div class="text-center">${c}</div>`;
                        }

                        for(let f=0; f<filas; f++) {
                            contenedor.innerHTML += `<div class="text-center">${filaLabels[f]}</div>`;
                            for(let c=1; c<=columnas; c++) {
                                const numButaca = f*columnas + c;
                                if(numButaca <= total) {
                                    if(ocupados.includes(numButaca)) {
                                        contenedor.innerHTML += `<svg class="w-3 h-3 sm:w-4 sm:h-4 md:w-5 md:h-5 cursor-not-allowed"><use href="#v-icon_standard-selected"/></svg>`;
                                    } else {
                                        contenedor.innerHTML += `<svg class="w-3 h-3 sm:w-4 sm:h-4 md:w-5 md:h-5 cursor-pointer"><use href="#v-icon_standard-available"/></svg>`;
                                    }
                                } else {
                                    contenedor.innerHTML += `<div></div>`;
                                }
                            }
                        }
                    });
            } else {
                mapa.classList.add('hidden');
                contenedor.innerHTML = '';
            }
        }

        function cerrarMapa() {
            document.getElementById('mapa-butacas').classList.add('hidden');
        }
    </script>


</div>

<script>
    function filtrarPorDia(fecha) {
        document.querySelectorAll('.sesion').forEach(el => {
            el.style.display = el.dataset.dia === fecha ? 'block' : 'none';
        });
    }
    // Mostrar solo las sesiones de hoy por defecto
    document.addEventListener('DOMContentLoaded', function() {
        filtrarPorDia('{{ $hoy->format('Y-m-d') }}');
    });
</script>









<div class="text-white font-primary-font px-4 py-6">
    <p class="w-full text-center text-4xl my-8 font-bold">PELÍCULAS RELACIONADAS</p>
    <div class="relative flex justify-center items-center flex-col">
        <div id="carousel-container" class="overflow-hidden max-w-7xl w-full">

            <div id="carousel-inner" @class(['flex', 'transition-transform', 'duration-500', 'ease-in-out', 'justify-center' => count($peliculasRelacionadas) <= 4])>
                @foreach ($peliculasRelacionadas as $pelicula)
                    <div class="min-w-[23%] h-[400px] box-border relative mr-8">
                        <div class="rounded-lg shadow-lg overflow-hidden h-full">
                            <a href="/pelicula/{{ $pelicula->id }}" rel="noopener noreferrer">
                                <img src="{{ $pelicula->foto_miniatura }}" alt="{{ $pelicula->titulo }}" class="w-full h-full object-cover object-top">
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


@if(count($peliculasRelacionadas) > 4)
<script>
document.addEventListener("DOMContentLoaded", function () {
    // 1. Obtenemos los elementos del carrusel y los botones
    const contenedor = document.getElementById("carousel-container");
    const carrusel = document.getElementById("carousel-inner");
    const botonIzquierda = document.getElementById("prev");
    const botonDerecha = document.getElementById("next");

    // 2. Guardamos las tarjetas originales del carrusel
    const tarjetas = Array.from(carrusel.children);

    // 3. Calculamos el ancho de cada tarjeta (incluye margen derecho)
    const estilo = getComputedStyle(tarjetas[0]);
    const anchoTarjeta = tarjetas[0].offsetWidth + parseInt(estilo.marginRight);

    // 4. Cuántas tarjetas se ven al mismo tiempo
    const visibles = Math.floor(contenedor.offsetWidth / anchoTarjeta);
    const total = tarjetas.length;

    // 5. Iniciamos desde la primera tarjeta real (después de clonar)
    let actual = visibles;

    // 6. Clonamos algunas tarjetas al principio y al final para hacer el bucle infinito
    const clonesInicio = tarjetas.slice(-visibles).map(t => t.cloneNode(true));
    const clonesFinal = tarjetas.slice(0, visibles).map(t => t.cloneNode(true));

    clonesInicio.forEach(clon => carrusel.prepend(clon));
    clonesFinal.forEach(clon => carrusel.append(clon));

    // 7. Posicionamos el carrusel en la primera tarjeta real
    let posicion = -actual * anchoTarjeta;
    carrusel.style.transform = `translateX(${posicion}px)`;

    // 8. Función para mover el carrusel con animación
    function mover() {
        carrusel.style.transition = "transform 0.5s ease";
        carrusel.style.transform = `translateX(${posicion}px)`;
    }

    // 9. Función para saltar (sin animación) cuando llegamos a un clon
    function saltar(nuevoIndice) {
        carrusel.style.transition = "none";
        posicion = -nuevoIndice * anchoTarjeta;
        carrusel.style.transform = `translateX(${posicion}px)`;
        actual = nuevoIndice;
    }

    // 10. Detecta si llegamos a un clon y vuelve al original sin que se note
    carrusel.addEventListener("transitionend", function () {
        if (actual >= total + visibles) {
            saltar(visibles); // Volver al principio real
        } else if (actual < visibles) {
            saltar(total + visibles - 1); // Ir al final real
        }
    });

    // 11. Botón ← para ir hacia atrás
    botonIzquierda.addEventListener("click", function () {
        actual--;
        posicion = -actual * anchoTarjeta;
        mover();
    });

    // 12. Botón → para ir hacia adelante
    botonDerecha.addEventListener("click", function () {
        actual++;
        posicion = -actual * anchoTarjeta;
        mover();
    });
});
</script>
@endif


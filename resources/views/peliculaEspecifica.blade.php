@include('head', ['title' => $nombrePelicula . ' | Sala Horizonte'])
@include('cabeceraCompleta' , ['completo' => true])


<div class="bg-primary-color w-full font-primary-font mt-28">
    <div class="relative w-full h-[240px] sm:h-[320px] md:h-[380px] lg:h-[420px] xl:h-[480px]">
        <img src="{{ $foto_grande }}" alt="Foto de portada de la película" class="w-full h-full object-cover object-top">
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent pointer-events-none"></div>
        <a href="{{ $trailer }}" rel="noopener noreferrer"
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
    <h1 class="text-3xl font-bold text-white mb-6 text-center">Sesiones de la película</h1>

    <div id='contendor-dias' class="flex justify-center space-x-4 mb-4">
        @for($i = 0; $i < 5; $i++)
            @php
                $dia = $hoy->copy()->addDays($i);
                $fecha = $dia->format('Y-m-d');
                $etiqueta = $i == 0 ? 'Hoy' : $dia->format('D d/m');
            @endphp
            <button 
                class="btn-dia px-4 py-2 rounded bg-text-color text-white hover:bg-text-color/80 transition duration-300"
                onclick="filtrarPorDia('{{ $fecha }}', this)">
                {{ $etiqueta }}
            </button>
        @endfor
    </div>

    <div id="lista-sesiones" class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($sesiones as $sesion)
            @php
                $fechaSesion = Carbon::parse($sesion->fechaHora)->format('Y-m-d');
                $horaSesion = Carbon::parse($sesion->fechaHora)->format('H:i');
            @endphp
            <div class="border-2 border-text-color/70 rounded-lg shadow-md p-4 my-4 hover:border-text-color transition duration-300 sesion " data-dia="{{ $fechaSesion }}">
                <h2 class="text-xl font-semibold text-white mb-2">Sala {{ $sesion->idSala }}</h2>
                <p class="text-white"><strong>Hora:</strong> {{ $horaSesion }}</p>
                <p class="text-white"><strong>Butacas Reservadas:</strong> {{ $sesion->numButacasReservadas }}</p>
                <button 
                    class="ml-auto w-full items-center mt-3 px-4 py-2 bg-white/50 text-black rounded hover:bg-white/80 transition duration-300 cursor-pointer"
                    onclick="mostrarMapa('{{ $sesion->id }}')">
                    Ver Detalles
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

    <script>
        function mostrarMapa(idSesion) {
            const sesionId = idSesion;
         

            if(sesionId) {
                fetch(`/sesion/${sesionId}/getMapa`)
                    .then(response => response.json())
                    .then(mapa => {
                        const contenedor = document.getElementById('contenedor-mapa');
                        contenedor.innerHTML = '';
                        const mapaObjeto = JSON.parse(mapa);
                        const filas = Object.keys(mapaObjeto).length;
                        const columnas = Object.keys(mapaObjeto['A']).length;
                        
                        contenedor.classList.add('grid-cols-' + (+columnas + 1));

                        // Encabezados
                        contenedor.innerHTML += `<p class="text-white font-bold block col-start-1 col-end-${+columnas + 2} text-center my-4">VISTA PREVIA SALA</p>`;
                        contenedor.innerHTML += `<div class="flex justify-center col-start-1 col-end-${+columnas + 2} gap-8 w-full mt-4">
                                                    <div class="flex items-center gap-2">
                                                        <svg class="w-3 h-3 sm:w-4 sm:h-4 md:w-8 md:h-8"><use href="#v-icon_standard-available"/></svg>
                                                        <span class="text-white">Disponible</span>
                                                    </div>
                                                    <div class="flex items-center gap-2">
                                                        <svg class="w-3 h-3 sm:w-4 sm:h-4 md:w-8 md:h-8"><use href="#v-icon_standard-unavailable"/></svg></svg>
                                                        <span class="text-white">Ocupado</span>
                                                    </div>
                                                </div>`;
                        contenedor.innerHTML += `<div id="pantalla" class="col-start-2 col-end-${+columnas + 2} text-center bg-gray-600 mb-1 px-2">Pantalla</div>`;
                        contenedor.innerHTML += `<div></div>`; 
                        for(let c=1; c<=columnas; c++) {
                            contenedor.innerHTML += `<div class="text-center">${c}</div>`;
                        }

                        let mapaNumerico = Object.values(mapaObjeto);
                        let mapaLetras = Object.keys(mapaObjeto);
                        for(let f = 0; f < filas; f++) {
                            const letra = mapaLetras[f];
                            contenedor.innerHTML += `<div class="text-center">${letra}</div>`;

                            for(let c = 1; c <= columnas; c++) {
                                if(mapaObjeto[letra][c]) {
                                    contenedor.innerHTML += `<svg class="w-3 h-3 sm:w-4 sm:h-4 md:w-8 md:h-8"><use href="#v-icon_standard-unavailable"/></svg>`;
                                } else {
                                    contenedor.innerHTML += `<svg class="w-3 h-3 sm:w-4 sm:h-4 md:w-8 md:h-8"><use href="#v-icon_standard-available"/></svg>`;
                                }
                            }
                        }
                        contenedor.innerHTML += `<div class="col-start-2 col-end-${+columnas + 2} text-center bg-text-color mt-4 p-2 hover:bg-text-color/80"><button id='comprarEntrada' data-idsesion='${sesionId}' class="cursor-pointer">Comprar entradas</button></div>`;
                        const comprarEntrada  = document.getElementById('comprarEntrada');
                        comprarEntrada.addEventListener('click', comprarEntradas)
                    });
            } else {
                mapa.classList.add('hidden');
                contenedor.innerHTML = '';
            }
        }

        function cerrarMapa() {
            document.getElementById('mapa-butacas').classList.add('hidden');
        }

        const usuarioAutenticado = {{ Auth::check() ? 'true' : 'false' }};
        const rutaCompraBase = "{{ route('procesoCompra.paso1', ['idSesion' => '__ID__']) }}"; 
        
        function comprarEntradas(){
            const idSesion = this.dataset.idsesion;

            if (usuarioAutenticado === true || usuarioAutenticado === 'true') {
                const form = document.createElement('form');
                form.method = 'GET';
                form.action = '/compra/asientos';

                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'idSesion';
                input.value = idSesion;

                form.appendChild(input);
                document.body.appendChild(form);
                form.submit();
            } else {
                // Redirige al login (asumiendo que tienes un botón oculto que lo hace)
                document.getElementById('botonLogin').click();
            }
        }
    </script>
</div>

<script>
    function filtrarPorDia(fecha, botonActivo) {
        document.querySelectorAll('.sesion').forEach(el => {
            el.style.display = el.dataset.dia === fecha ? 'block' : 'none';
        });

        document.querySelectorAll('.btn-dia').forEach(btn => {
            btn.classList.remove('bg-text-color/50', 'font-bold');
            btn.classList.add('bg-text-color', 'hover:bg-text-color/80');
        });

        botonActivo.classList.remove('bg-text-color', 'hover:bg-text-color/80');
        botonActivo.classList.add('bg-text-color/50', 'font-bold');
    }
    // Mostrar solo las sesiones de hoy por defecto
    document.addEventListener('DOMContentLoaded', function() {
        filtrarPorDia('{{ $hoy->format('Y-m-d') }}', document.querySelector('#contendor-dias button:first-child'));
    });
</script>

<div class="text-white font-primary-font px-4 py-6">
    <p class="w-full text-center text-4xl my-8 font-bold">PELÍCULAS RELACIONADAS</p>
    <div class="relative flex justify-center items-center flex-col">
        <div id="carousel-container" class="overflow-x-auto lg:overflow-hidden max-w-7xl w-full">

            <div id="carousel-inner" @class(['flex', 'transition-transform', 'duration-500', 'ease-in-out', 'justify-center' => count($peliculasRelacionadas) <= 4])>
                @foreach ($peliculasRelacionadas as $pelicula)
                    <div class="min-w-[80%] sm:min-w-[45%] md:min-w-[30%] lg:min-w-[23%] h-[400px] box-border relative mr-8">
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
    const contenedor = document.getElementById("carousel-container");
    const carrusel = document.getElementById("carousel-inner");
    const botonIzquierda = document.getElementById("prev");
    const botonDerecha = document.getElementById("next");

    let anchoTarjeta;
    let visibles;
    let posicion;
    let actual;

    function calcularMedidas() {
        const tarjetas = Array.from(carrusel.children).filter(el => !el.classList.contains('clon'));
        if (!tarjetas.length) return;
        const estilo = getComputedStyle(tarjetas[0]);
        anchoTarjeta = tarjetas[0].offsetWidth + parseInt(estilo.marginRight);
        visibles = Math.floor(contenedor.offsetWidth / anchoTarjeta) || 1;
    }

    function inicializarCarrusel() {
        const tarjetasOriginales = Array.from(carrusel.children).filter(el => !el.classList.contains('clon'));

        // Limpiar carrusel y quitar clones
        carrusel.innerHTML = '';
        tarjetasOriginales.forEach(t => carrusel.appendChild(t));

        calcularMedidas();

        // Clonar
        const clonesInicio = tarjetasOriginales.slice(-visibles).map(t => {
            const clon = t.cloneNode(true);
            clon.classList.add('clon');
            return clon;
        });

        const clonesFinal = tarjetasOriginales.slice(0, visibles).map(t => {
            const clon = t.cloneNode(true);
            clon.classList.add('clon');
            return clon;
        });

        clonesInicio.forEach(clon => carrusel.prepend(clon));
        clonesFinal.forEach(clon => carrusel.appendChild(clon));

        actual = visibles;
        posicion = -actual * anchoTarjeta;
        carrusel.style.transition = "none";
        carrusel.style.transform = `translateX(${posicion}px)`;
    }

    function mover() {
        carrusel.style.transition = "transform 0.5s ease";
        carrusel.style.transform = `translateX(${posicion}px)`;
    }

    function saltar(nuevoIndice) {
        carrusel.style.transition = "none";
        posicion = -nuevoIndice * anchoTarjeta;
        carrusel.style.transform = `translateX(${posicion}px)`;
        actual = nuevoIndice;
    }

    carrusel.addEventListener("transitionend", function () {
        const total = Array.from(carrusel.children).filter(el => !el.classList.contains('clon')).length;
        if (actual >= total + visibles) {
            saltar(visibles);
        } else if (actual < visibles) {
            saltar(total + visibles - 1);
        }
    });

    botonIzquierda.addEventListener("click", function () {
        actual--;
        posicion = -actual * anchoTarjeta;
        mover();
    });

    botonDerecha.addEventListener("click", function () {
        actual++;
        posicion = -actual * anchoTarjeta;
        mover();
    });

    window.addEventListener('resize', () => {
        inicializarCarrusel();
    });

    inicializarCarrusel();
});
</script>
@endif


@include('footer');
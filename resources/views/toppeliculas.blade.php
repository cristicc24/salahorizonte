<div class="text-white font-primary-font px-4 py-6">
    <p class="w-full text-center text-4xl my-8 font-bold">TOP PELÍCULAS</p>
    <div class="relative flex justify-center items-center flex-col">
        <div id="carousel-container" class="overflow-hidden max-w-7xl w-full">
            <div id="carousel-inner" class="flex transition-transform duration-500 ease-in-out">
                @foreach ($toppeliculas as $pelicula)
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
                            <a href="{{ $pelicula->enlace_trailer }}" target="_blank" rel="noopener noreferrer"
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
    </div>
</div>

<div class="my-20 w-full h-[400px] relative overflow-hidden">
    <img src="/images/films/28-marcelinopanyvino/fotogrande.webp" alt="Foto de la película Marcelino, Pan y Vino (1955)" class="w-full h-full object-cover [object-position:center_40%]">
    <div class="absolute inset-0 bg-gradient-to-r from-black/90 via-black/30 to-transparent"></div>
    <div class="absolute left-48 top-1/4 p-4 w-60 font-primary-font text-3xl z-9 text-white">
        <p>70 años del estreno de <span class="italic">Marcelino, Pan y Vino</span></p>
        <a href="/pelicula/28" class="border p-2 text-xl my-6 block text-center hover:bg-black/40">Comprar entradas</a>
    </div>
</div>

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



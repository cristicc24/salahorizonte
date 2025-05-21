<div class="text-white font-primary-font px-4 py-6">
    <p class="w-full text-center text-4xl mb-8 font-bold">TOP PELÍCULAS</p>
    <div class="relative flex justify-center">
        <!-- Carrusel -->
        <div id="carousel" class="flex transition-transform duration-500 ease-in-out max-w-7xl overflow-hidden">
            @foreach ($toppeliculas as $pelicula)
                <div class="min-w-[23%] h-[400px]  box-border relative mr-8">
                    <div class="rounded-lg shadow-lg overflow-hidden h-full">
                        <a href="/pelicula/{{ $pelicula->id }}" target="_blank" rel="noopener noreferrer"> 
                            {{--noopener noreferrer: Evita que la nueva pestaña (a la que se abre el enlace) tenga acceso al objeto window.opener del sitio original --}}
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
                            class="bg-text-color hover:bg-text-color/80 text-white p-2 rounded-t-lg transition">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-5 h-5" viewBox="0 0 24 24">
                                <path d="M8 5v14l11-7z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            @endforeach+
            
        </div>
</div>
</div>

        


@include('head', ['title' =>  'Cartelera | Sala Horizonte'])
@include('cabeceraCompleta' , ['completo' => true])

<div class="text-white mt-40 px-4 font-primary-font">
    <h2 class="text-5xl font-bold text-center mb-16 block">Cartelera</h2>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-12 max-w-7xl w-full mx-auto mb-20">
        @foreach ($cartelera as $pelicula)
            <div class="w-full h-[400px] box-border relative mr-8" title="{{ $pelicula->titulo }}">
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
@include('footer');

@include('head', ['title' =>  'Cartelera | Sala Horizonte'])
@include('cabeceraCompleta' , ['completo' => true])

<div class="text-white mt-40 px-4 font-primary-font">
    <h2 class="text-5xl font-bold text-center mb-16 block">Cartelera</h2>
    
    {{-- FORMULARIO DE FILTRO --}}
    <form method="GET" action="{{ route('cartelera') }}" class="flex flex-col sm:flex-row flex-wrap gap-4 justify-center items-center mb-12">
        <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Buscar título" 
                    class="w-full sm:w-64 border border-gray-300 text-white p-2 rounded" />

        {{-- Select Género --}}
        <select name="genero" class="w-full sm:w-48 border border-gray-300 text-white p-2 rounded">
            <option value="" class="text-black">Todos los géneros</option>
            @foreach ($generos as $g)
                <option value="{{ $g }}" {{ request('genero') == $g ? 'selected' : '' }} class="text-black">{{ $g }}</option>
            @endforeach
        </select>

        {{-- Select Edad recomendada --}}
        <select name="edad" class="w-full sm:w-48 border border-gray-300 text-white p-2 rounded">
            <option value="" class="text-black">Todas las edades</option>
            @foreach ($edades as $edad)
                <option value="{{ $edad }}" {{ request('edad') == $edad ? 'selected' : '' }} class="text-black">{{ $edad }}+</option>
            @endforeach
        </select>

        {{-- Duración mínima --}}
        <input type="number" name="duracion_min" value="{{ request('duracion_min') }}" placeholder="Duración mínima (min)" class="w-full sm:w-48 border border-gray-300 text-white p-2 rounded" />
        {{-- Duración máxima --}}

        <input type="number" name="duracion_max" value="{{ request('duracion_max') }}" placeholder="Duración máxima (min)" class="w-full sm:w-48 border border-gray-300 text-white p-2 rounded" />
        <button type="submit" class="bg-text-color text-white px-4 py-2 rounded hover:bg-text-color/80">Filtrar</button>
        <a href="{{ route('cartelera') }}" id="resetFiltros" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Resetear filtros</a>
    </form>

    {{-- RESULTADOS --}}
    @if ($cartelera->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-12 max-w-7xl w-full mx-auto mb-20">
            @foreach ($cartelera as $pelicula)
                <div class="w-full h-[400px] box-border relative mr-8" title="{{ $pelicula->titulo }}">
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

        {{-- PAGINACIÓN --}}
        <div class="flex justify-center mt-10">
            {{ $cartelera->onEachSide(1)->links('components.pagination') }}
        </div>


    @else
        <p class="text-center text-lg text-white my-12">No hay películas que coincidan con los filtros seleccionados.</p>
    @endif
</div>

@include('footer');

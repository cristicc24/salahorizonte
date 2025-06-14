@include('head', ['title' =>  'Cartelera | Sala Horizonte'])
@include('cabeceraCompleta' , ['completo' => true])

<div class="text-white mt-28 sm:mt-34 md:mt-40 px-4 font-primary-font">
    <h2 class=" text-3xl sm:text-4xl md:text-5xl font-bold text-center mb-10 md:mb-16 block">Cartelera</h2>
    
    {{-- BOTÓN PARA MÓVILES --}}
<div class="md:hidden mb-4 text-center">
    <button type="button" id="toggleFiltros" class="bg-text-color text-white px-4 py-2 rounded hover:bg-text-color/80 transition">
        Mostrar filtros
    </button>
</div>

{{-- FORMULARIO DE FILTROS --}}
<div id="filtrosWrapper" class="md:block hidden">
    <form method="GET" action="{{ route('cartelera') }}"
        class="flex flex-col gap-4 sm:flex-row sm:flex-wrap sm:justify-center sm:items-end sm:gap-4 mb-12">

        {{-- Buscar título --}}
        <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Buscar título"
            class="w-full sm:w-64 border border-gray-300 text-white p-2 rounded" />

        {{-- Género --}}
        <select name="genero" class="w-full sm:w-48 border border-gray-300 text-white p-2 rounded">
            <option value="" class="text-black">Todos los géneros</option>
            @foreach ($generos as $g)
                <option value="{{ $g }}" {{ request('genero') == $g ? 'selected' : '' }} class="text-black">{{ $g }}</option>
            @endforeach
        </select>

        {{-- Edad recomendada --}}
        <select name="edad" class="w-full sm:w-48 border border-gray-300 text-white p-2 rounded">
            <option value="" class="text-black">Todas las edades</option>
            @foreach ($edades as $edad)
                <option value="{{ $edad }}" {{ request('edad') == $edad ? 'selected' : '' }} class="text-black">{{ $edad }}+</option>
            @endforeach
        </select>

        {{-- Botones --}}
        <button type="submit" class="bg-text-color text-white px-4 py-2 rounded hover:bg-text-color/80 transition">Filtrar</button>
        <a href="{{ route('cartelera') }}" id="resetFiltros" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">Resetear filtros</a>
    </form>
</div>

{{-- RESULTADOS DE PELÍCULAS --}}
@if ($cartelera->count())
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-12 max-w-7xl w-full mx-auto mb-20">
        @foreach ($cartelera as $pelicula)
            <div class="w-full h-[400px] box-border relative mr-8" title="{{ $pelicula->titulo }}">
                <div class="rounded-lg shadow-lg overflow-hidden h-full">
                    <a href="/pelicula/{{ $pelicula->id }}" rel="noopener noreferrer">
                        <img src="{{ asset($pelicula->foto_miniatura) }}" alt="{{ $pelicula->titulo }}"
                            class="w-full h-full object-cover object-top">
                    </a>
                </div>
                <div class="absolute bottom-0 w-full bg-black/45 h-[64px] flex items-center justify-center">
                    <h2 class="text-center text-white text-2xl font-semibold truncate p-4">
                        {{ $pelicula->titulo }}
                    </h2>
                </div>
                <div class="absolute top-0 left-0 w-full flex justify-start">
                    <a href="{{ $pelicula->enlace_trailer }}" rel="noopener noreferrer" target="_blank"
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
@include('footer')
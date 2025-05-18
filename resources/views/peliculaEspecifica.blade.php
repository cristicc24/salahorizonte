@include('head', ['title' => $nombrePelicula . ' | Sala Horizonte'])
@include('cabeceraCompleta' , ['completo' => true])


<div class="bg-primary-color w-full h-screen font-primary-font mt-28">
    <div class="relative w-full h-100">
        <img src="{{ $foto_grande }}" alt="" class="w-full h-full object-cover object-top">
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent pointer-events-none"></div>
        <img src="{{ $foto_miniatura }}" alt="" class="absolute top-[80%] left-[12%] w-[200px]">
        <a href="{{ $trailer }}" target="_blank" rel="noopener noreferrer" class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-10">
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
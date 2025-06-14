<div class="container mx-auto overflow-hidden mt-20 sm:mt-28">
  <div id="carousel" class="relative w-full" data-index="0">
    <!-- Carousel wrapper -->
    <div id="carousel-slides" class="flex transition-transform duration-700 ease-in-out">
      @foreach($sliders as $slider)
        <div class="w-full flex-shrink-0 relative">
          <p class="hidden text-white absolute sm:line-clamp-2 md:line-clamp-3 lg:line-clamp-4 top-[8%] left-[5%] sm:w-[40%] xl:w-[40%] text-2xl md:text-5xl xl:text-7xl font-carousel-font ">
            {{ $slider->pelicula->titulo }}
          </p>
          <img src="{{ $slider->pelicula->foto_grande }}" alt="{{ $slider->pelicula->titulo }}" class="w-full aspect-video md:h-[520px] object-cover object-top">
          <a href="/pelicula/{{ $slider->pelicula->id }}" class="absolute left-1/2 transform -translate-x-1/2 text-center right-auto md:left-auto md:right-10  bottom-6 md:bottom-14 px-5 py-3 text-xs md:text-xl text-white rounded-2xl bg-black/60 font-carousel-font hover:bg-black/80">
            Comprar entradas
          </a>
        </div>
      @endforeach
    </div>

    <!-- Indicadores del carrousel -->
    <div class="absolute z-9 md:flex hidden bottom-5 md:bottom-10 left-1/2 -translate-x-1/2 space-x-3">
      @foreach($sliders as $index => $slider)
        <button onclick="goToSlide({{ $index }})" class="lg:w-2.5 lg:h-2.5 md:w-1.5 md:h-1.5 rounded-full bg-white hover:bg-white transition-all focus:outline-none" 
          id="indicator-{{ $index }}">
        </button>
      @endforeach
    </div>

    <!-- Controls -->
    <button onclick="prevSlide()" class="absolute top-1/2 left-4 -translate-y-1/2 text-white p-2 md:p-3 z-9 hover:bg-text-color/50 rounded-full cursor-pointer">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-6 md:w-8 h-6 md:h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 19.5 8.25 12l7.5-7.5" />
      </svg>  
    </button>
    <button onclick="nextSlide()" class="absolute top-1/2 right-4 -translate-y-1/2 text-white p-2 md:p-3 z-9 hover:bg-text-color/50 rounded-full cursor-pointer">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-6 md:w-10 h-6 md:h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
      </svg>
    </button>
  </div>
</div>
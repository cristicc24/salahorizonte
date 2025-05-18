<div class="container mx-auto overflow-hidden mt-28 ">
  <div id="carousel" class="relative w-full " data-index="0">
    <!-- Carousel wrapper -->
    <div id="carousel-slides" class="flex transition-transform duration-700 ease-in-out">
      @foreach($sliders as $slider)
        <div class="w-full flex-shrink-0 relative">
          <p class="text-white absolute top-[10%] left-[5%] text-7xl overflow-ellipsis h-[350px] overflow-hidden w-[32%] font-carousel-font">{{ $slider->titulo }}</p>
          <img src="{{ $slider->foto_grande }}" alt="{{ $slider->titulo }}" class="w-full h-64 md:h-130 object-cover object-top">
        </div>
      @endforeach
    </div>
text-overflow: ellipsis;
    <!-- Indicators -->
    <div class="absolute z-10 flex bottom-10 left-1/2 -translate-x-1/2 space-x-3">
      @foreach($sliders as $index => $slider)
        <button 
          onclick="goToSlide({{ $index }})" 
          class="w-2 h-2 rounded-full bg-white/50 hover:bg-white transition-all" 
          id="indicator-{{ $index }}">
        </button>
      @endforeach
    </div>

    <button onclick="prevSlide()" class="absolute top-1/2 left-4 -translate-y-1/2 bg-black/50 text-white px-3 py-2 rounded-full z-10 hover:bg-black">‹</button>
    <button onclick="nextSlide()" class="absolute top-1/2 right-4 -translate-y-1/2 bg-black/50 text-white px-3 py-2 rounded-full z-10 hover:bg-black">›</button>
  </div>
</div>

<script>
  const carousel = document.getElementById('carousel');
  const slides = document.getElementById('carousel-slides');
  const totalSlides = {{ count($sliders) }};
  const indicators = [...document.querySelectorAll('[id^="indicator-"]')];

  function updateSlide(index) {
    slides.style.transform = `translateX(-${index * 100}%)`;
    carousel.dataset.index = index;
    indicators.forEach((btn, i) => {
      btn.classList.toggle('bg-white', i === index);
      btn.classList.toggle('bg-white/50', i !== index);
    });
  }

  function nextSlide() {
    let index = parseInt(carousel.dataset.index);
    index = (index + 1) % totalSlides;
    updateSlide(index);
  }

  function prevSlide() {
    let index = parseInt(carousel.dataset.index);
    index = (index - 1 + totalSlides) % totalSlides;
    updateSlide(index);
  }

  function goToSlide(index) {
    updateSlide(index);
  }

  let autoplayInterval = setInterval(nextSlide, 5000);
  document.querySelectorAll('[onclick]').forEach(btn => {
    btn.addEventListener('click', () => {
      clearInterval(autoplayInterval);
      autoplayInterval = setInterval(nextSlide, 5000);
    });
  });
</script>
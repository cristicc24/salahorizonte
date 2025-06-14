import './bootstrap';

// CABECERA COMPLETA
document.addEventListener('DOMContentLoaded', () => {
    const btn = document.getElementById('hamburgerBtn');
    const menu = document.getElementById('navLinks');
    const backdrop = document.getElementById('backdrop');
    const closeBtn = document.getElementById('closeBtn');

    if (btn && menu && backdrop && closeBtn) {
        function openMenu() {
            menu.classList.remove('-translate-x-full', 'opacity-0', 'pointer-events-none');
            menu.classList.add('translate-x-0', 'opacity-100', 'pointer-events-auto');
            backdrop.classList.remove('opacity-0', 'pointer-events-none');
            backdrop.classList.add('opacity-100', 'pointer-events-auto');
        }

        function closeMenu() {
            menu.classList.add('-translate-x-full', 'opacity-0', 'pointer-events-none');
            menu.classList.remove('translate-x-0', 'opacity-100', 'pointer-events-auto');
            backdrop.classList.add('opacity-0', 'pointer-events-none');
            backdrop.classList.remove('opacity-100', 'pointer-events-auto');
        }

        btn.addEventListener('click', () => {
            if (menu.classList.contains('translate-x-0')) {
                closeMenu();
            } else {
                openMenu();
            }
        });

        backdrop.addEventListener('click', closeMenu);
        closeBtn.addEventListener('click', closeMenu);
    }

    const botonLogin = document.querySelectorAll(".botonLogin");
    const btnCerrarModalLogin = document.getElementById("btnCerrarModalLogin");
    const modalLogin = document.getElementById("modalLogin");

    if (botonLogin.length && modalLogin) {
        botonLogin.forEach(button => {
            button.addEventListener("click", () => {
                modalLogin.classList.remove("hidden");
            });
        });
    }

    if (btnCerrarModalLogin && modalLogin) {
        btnCerrarModalLogin.addEventListener("click", () => {
            modalLogin.classList.add("hidden");
        });
    }
});

// SLIDER PRINCIPAL
document.addEventListener('DOMContentLoaded', () => {
    const carousel = document.getElementById('carousel');
    const slides = document.getElementById('carousel-slides');
    const indicators = Array.from(document.querySelectorAll('[id^="indicator-"]'));

    if (carousel && slides && indicators.length > 0) {
        const totalSlides = indicators.length;
        let autoplayInterval;

        function updateSlide(index) {
            slides.style.transform = `translateX(-${index * 100}%)`;
            carousel.dataset.index = index;
            indicators.forEach((btn, i) => {
                btn.classList.toggle('bg-white', i === index);
                btn.classList.toggle('bg-white/50', i !== index);
            });
        }

        function nextSlide() {
            let index = parseInt(carousel.dataset.index || '0', 10);
            index = (index + 1) % totalSlides;
            updateSlide(index);
        }

        function prevSlide() {
            let index = parseInt(carousel.dataset.index || '0', 10);
            index = (index - 1 + totalSlides) % totalSlides;
            updateSlide(index);
        }

        window.nextSlide = nextSlide;
        window.prevSlide = prevSlide;
        window.goToSlide = updateSlide;

        autoplayInterval = setInterval(nextSlide, 5000);

        document.querySelectorAll('[onclick]').forEach(btn => {
            btn.addEventListener('click', () => {
                clearInterval(autoplayInterval);
                autoplayInterval = setInterval(nextSlide, 5000);
            });
        });
    }
});

// TOP PELÍCULAS
document.addEventListener("DOMContentLoaded", () => {
    const contenedor = document.getElementById("carousel-container");
    const carrusel = document.getElementById("carousel-inner");
    const botonIzquierda = document.getElementById("prev");
    const botonDerecha = document.getElementById("next");

    if (contenedor && carrusel && botonIzquierda && botonDerecha) {
        const templates = Array.from(carrusel.children).map(el => el.outerHTML);
        let tarjetas, anchoTarjeta, visibles, total, actual, posicion;

        function initCarousel() {
            carrusel.innerHTML = "";
            templates.forEach(tpl => carrusel.insertAdjacentHTML("beforeend", tpl));
            tarjetas = Array.from(carrusel.children);
            const estilo = getComputedStyle(tarjetas[0]);
            anchoTarjeta = tarjetas[0].offsetWidth + parseInt(estilo.marginRight);
            visibles = Math.floor(contenedor.clientWidth / anchoTarjeta) || 1;
            total = templates.length;

            carrusel.innerHTML = "";
            templates.slice(-visibles).forEach(tpl => carrusel.insertAdjacentHTML("beforeend", tpl));
            templates.forEach(tpl => carrusel.insertAdjacentHTML("beforeend", tpl));
            templates.slice(0, visibles).forEach(tpl => carrusel.insertAdjacentHTML("beforeend", tpl));

            tarjetas = Array.from(carrusel.children);
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
            actual = nuevoIndice;
            posicion = -actual * anchoTarjeta;
            carrusel.style.transform = `translateX(${posicion}px)`;
        }

        carrusel.addEventListener("transitionend", () => {
            if (actual >= total + visibles) {
                saltar(visibles);
            } else if (actual < visibles) {
                saltar(total + visibles - 1);
            }
        });

        botonIzquierda.addEventListener("click", () => {
            actual--;
            posicion = -actual * anchoTarjeta;
            mover();
        });

        botonDerecha.addEventListener("click", () => {
            actual++;
            posicion = -actual * anchoTarjeta;
            mover();
        });

        initCarousel();

        let resizeTimeout;
        window.addEventListener("resize", () => {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(initCarousel, 150);
        });
    }
});

// PELÍCULAS RELACIONADAS (Película específica)
document.addEventListener("DOMContentLoaded", () => {
    const contenedor = document.getElementById("relacionadas-container");
    const carrusel = document.getElementById("relacionadas-inner");
    const botonIzquierda = document.getElementById("relacionadas-prev");
    const botonDerecha = document.getElementById("relacionadas-next");

    if (contenedor && carrusel && botonIzquierda && botonDerecha) {
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

            carrusel.innerHTML = '';
            tarjetasOriginales.forEach(t => carrusel.appendChild(t));

            calcularMedidas();

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

        botonIzquierda.addEventListener("click", () => {
            actual--;
            posicion = -actual * anchoTarjeta;
            mover();
        });

        botonDerecha.addEventListener("click", () => {
            actual++;
            posicion = -actual * anchoTarjeta;
            mover();
        });

        window.addEventListener('resize', () => {
            inicializarCarrusel();
        });

        inicializarCarrusel();
    }
});

// CARTELERA
document.addEventListener('DOMContentLoaded', () => {
    // Mostrar/Ocultar filtros en móvil
    const btnToggleFiltros = document.getElementById('toggleFiltros');
    const filtrosWrapper = document.getElementById('filtrosWrapper');

    if (btnToggleFiltros && filtrosWrapper) {
        btnToggleFiltros.addEventListener('click', () => {
            filtrosWrapper.classList.toggle('hidden');
            const visible = !filtrosWrapper.classList.contains('hidden');
            btnToggleFiltros.textContent = visible ? 'Ocultar filtros' : 'Mostrar filtros';
        });
    }

    // Reset de filtros
    const resetBtn = document.getElementById('resetFiltros');
    const form = resetBtn?.closest('form');

    if (resetBtn && form) {
        resetBtn.addEventListener('click', (e) => {
            e.preventDefault();
            form.querySelectorAll('input, select').forEach(el => {
                if (el.tagName === 'SELECT') {
                    el.selectedIndex = 0;
                } else {
                    el.value = '';
                }
            });
            form.submit();
        });
    }
});

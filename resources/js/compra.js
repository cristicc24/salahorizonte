document.addEventListener('DOMContentLoaded', () => {
    const usuarioAutenticado = document.body.dataset.usuarioAutenticado === "true";

    const mostrarMapa = function (idSesion) {
        fetch(`/sesion/${idSesion}/getMapa`)
            .then(response => response.json())
            .then(mapa => {
                const contenedor = document.getElementById('contenedor-mapa');
                contenedor.innerHTML = '';
                const mapaObjeto = JSON.parse(mapa);
                const filas = Object.keys(mapaObjeto).length;
                const columnas = Object.keys(mapaObjeto['A']).length;

                contenedor.className = `grid gap-[2px] max-w-full text-white text-xl grid-cols-${columnas + 1}`;
                contenedor.innerHTML += `<p class="text-white font-bold block col-start-1 col-end-${+columnas + 2} text-center my-4">VISTA PREVIA SALA</p>`;
                contenedor.innerHTML += `<div class="flex justify-center col-start-1 col-end-${+columnas + 2} gap-8 w-full mt-4">
                    <div class="flex items-center gap-2">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8"><use href="#v-icon_standard-available"/></svg>
                        <span class="text-white">Disponible</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8"><use href="#v-icon_standard-unavailable"/></svg>
                        <span class="text-white">Ocupado</span>
                    </div>
                </div>`;
                contenedor.innerHTML += `<div id="pantalla" class="col-start-2 col-end-${+columnas + 2} text-center bg-gray-600 mb-1 px-2">Pantalla</div>`;
                contenedor.innerHTML += `<div></div>`;
                for (let c = 1; c <= columnas; c++) {
                    contenedor.innerHTML += `<div class="text-center text-base sm:text-lg md:text-xl">${c}</div>`;
                }

                Object.keys(mapaObjeto).forEach(letra => {
                    contenedor.innerHTML += `<div class="text-center text-base sm:text-lg md:text-xl">${letra}</div>`;
                    for (let c = 1; c <= columnas; c++) {
                        contenedor.innerHTML += mapaObjeto[letra][c]
                            ? `<svg class="w-6 h-6 sm:w-8 sm:h-8"><use href="#v-icon_standard-unavailable"/></svg>`
                            : `<svg class="w-6 h-6 sm:w-8 sm:h-8"><use href="#v-icon_standard-available"/></svg>`;
                    }
                });

                contenedor.innerHTML += `<div class="col-start-2 col-end-${+columnas + 2} text-center bg-text-color mt-4 p-2 hover:bg-text-color/80">
                    <button id='comprarEntrada' data-idsesion='${idSesion}' class="cursor-pointer">Comprar entradas</button>
                </div>`;

                document.getElementById('comprarEntrada').addEventListener('click', comprarEntradas);

                // Scroll a mapa en móviles
                if (window.innerWidth < 1024) {
                    const destino = document.getElementById('vista-previa-mapa');
                    if (destino) {
                        setTimeout(() => {
                            destino.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        }, 500);
                    }
                }
            })
            .catch(error => {
                console.error('Error cargando mapa de butacas:', error);
            });
    };

    document.querySelectorAll('.btnMostrarMapa').forEach(button => {
        button.addEventListener('click', (e) => {
            if (e.currentTarget.dataset.idsesion)
                mostrarMapa(e.currentTarget.dataset.idsesion);
        });
    });

    function comprarEntradas() {
        const idSesion = this.dataset.idsesion;

        if (usuarioAutenticado) {
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
            const loginBtn = document.querySelector('.botonLogin');
            if (loginBtn) loginBtn.click();
        }
    }

    // Filtro de sesiones por día
    const contenedorDias = document.getElementById('contendor-dias');
    if (contenedorDias) {
        const primerDia = contenedorDias.querySelector('button');
        if (primerDia) {
            filtrarPorDia(primerDia.dataset.fecha, primerDia);
        }

        contenedorDias.querySelectorAll('button').forEach(btn => {
            btn.addEventListener('click', function () {
                filtrarPorDia(this.dataset.fecha, this);
            });
        });
    }

    function filtrarPorDia(fecha, botonActivo) {
        let haySesion = false;
        const contenedor = document.getElementById('contenedor-mapa');
        contenedor.innerHTML = '';

        document.querySelectorAll('.sesion').forEach(el => {
            if (el.dataset.dia === fecha) {
                el.style.display = 'block';
                haySesion = true;
            } else {
                el.style.display = 'none';
            }
        });

        document.getElementById('mensaje-no-sesiones-dia').classList.toggle('hidden', haySesion);

        document.querySelectorAll('.btn-dia').forEach(btn => {
            btn.classList.remove('bg-text-color/50', 'font-bold');
            btn.classList.add('bg-text-color', 'hover:bg-text-color/80');
        });

        botonActivo.classList.remove('bg-text-color', 'hover:bg-text-color/80');
        botonActivo.classList.add('bg-text-color/50', 'font-bold');
    }

});

// PASO 1
document.addEventListener('DOMContentLoaded', function () {
    const seleccionadas = [];
    let butacasSeleccionadas = document.getElementById('butacasSeleccionadas');
    let mensajeError = document.getElementById('mensaje-error-butacas');

    document.querySelectorAll('.butaca-disponible').forEach(el => {
        el.addEventListener('click', function () {
            const fila = this.dataset.fila;
            const columna = this.dataset.columna;
            const id = `${fila}-${columna}`;

            if (seleccionadas.includes(id)) {
                seleccionadas.splice(seleccionadas.indexOf(id), 1);
                this.querySelector('use').setAttribute('href', '#v-icon_standard-available');
            } else {
                seleccionadas.push(id);
                this.querySelector('use').setAttribute('href', '#v-icon_standard-selected');
            }

            butacasSeleccionadas.innerHTML = seleccionadas.length > 0 
                ? `<strong>Butacas seleccionadas:&nbsp;</strong><i>${seleccionadas.join(', ')}</i>`
                : '';

            // Oculta el mensaje de error si se selecciona una
            if (mensajeError && seleccionadas.length > 0) {
                mensajeError.classList.add('hidden');
            }
        });
    });

    const formContinuar = document.getElementById('formContinuar');
    if (formContinuar) {
        formContinuar.addEventListener('submit', function (e) {
            if (seleccionadas.length === 0) {
                e.preventDefault();
                if (mensajeError) mensajeError.classList.remove('hidden');
                return;
            }

            document.getElementById('inputButacas').value = JSON.stringify(seleccionadas);
        });
    }
});
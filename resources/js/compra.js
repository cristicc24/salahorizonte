//FALTA POR INCLUIR PASO 4


// Mapa de butacas y navegación al proceso de compra
document.addEventListener('DOMContentLoaded', () => {
    const usuarioAutenticado = document.body.dataset.usuarioAutenticado === "true";

    window.mostrarMapa = function (idSesion) {
        fetch(`/sesion/${idSesion}/getMapa`)
            .then(response => response.json())
            .then(mapa => {
                const contenedor = document.getElementById('contenedor-mapa');
                contenedor.innerHTML = '';
                const mapaObjeto = JSON.parse(mapa);
                const filas = Object.keys(mapaObjeto).length;
                const columnas = Object.keys(mapaObjeto['A']).length;

                contenedor.classList.add('grid-cols-' + (+columnas + 1));
                contenedor.innerHTML += `<p class="text-white font-bold block col-start-1 col-end-${+columnas + 2} text-center my-4">VISTA PREVIA SALA</p>`;
                contenedor.innerHTML += `<div class="flex justify-center col-start-1 col-end-${+columnas + 2} gap-8 w-full mt-4">
                    <div class="flex items-center gap-2">
                        <svg class="w-3 h-3 sm:w-4 sm:h-4 md:w-8 md:h-8"><use href="#v-icon_standard-available"/></svg>
                        <span class="text-white">Disponible</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-3 h-3 sm:w-4 sm:h-4 md:w-8 md:h-8"><use href="#v-icon_standard-unavailable"/></svg>
                        <span class="text-white">Ocupado</span>
                    </div>
                </div>`;
                contenedor.innerHTML += `<div id="pantalla" class="col-start-2 col-end-${+columnas + 2} text-center bg-gray-600 mb-1 px-2">Pantalla</div>`;
                contenedor.innerHTML += `<div></div>`;
                for (let c = 1; c <= columnas; c++) {
                    contenedor.innerHTML += `<div class="text-center">${c}</div>`;
                }

                Object.keys(mapaObjeto).forEach(letra => {
                    contenedor.innerHTML += `<div class="text-center">${letra}</div>`;
                    for (let c = 1; c <= columnas; c++) {
                        contenedor.innerHTML += mapaObjeto[letra][c]
                            ? `<svg class="w-3 h-3 sm:w-4 sm:h-4 md:w-8 md:h-8"><use href="#v-icon_standard-unavailable"/></svg>`
                            : `<svg class="w-3 h-3 sm:w-4 sm:h-4 md:w-8 md:h-8"><use href="#v-icon_standard-available"/></svg>`;
                    }
                });

                contenedor.innerHTML += `<div class="col-start-2 col-end-${+columnas + 2} text-center bg-text-color mt-4 p-2 hover:bg-text-color/80">
                    <button id='comprarEntrada' data-idsesion='${idSesion}' class="cursor-pointer">Comprar entradas</button>
                </div>`;

                document.getElementById('comprarEntrada').addEventListener('click', comprarEntradas);
            });
    };

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
            const loginBtn = document.getElementById('botonLogin');
            if (loginBtn) loginBtn.click();
        }
    }

    // Filtro por día en película específica
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
        document.querySelectorAll('.sesion').forEach(el => {
            el.style.display = el.dataset.dia === fecha ? 'block' : 'none';
        });

        document.querySelectorAll('.btn-dia').forEach(btn => {
            btn.classList.remove('bg-text-color/50', 'font-bold');
            btn.classList.add('bg-text-color', 'hover:bg-text-color/80');
        });

        botonActivo.classList.remove('bg-text-color', 'hover:bg-text-color/80');
        botonActivo.classList.add('bg-text-color/50', 'font-bold');
    }
});

// PASO 1
document.addEventListener('DOMContentLoaded', function(){
    const seleccionadas = [];
    let butacasSeleccionadas = document.getElementById('butacasSeleccionadas');

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
            butacasSeleccionadas.innerHTML = seleccionadas.length > 0 ? `<strong>Butacas seleccionadas:&nbsp;</strong><i> ${seleccionadas.join(', ')}</i>` : '';
        });
    });

    const formContinuar = document.getElementById('formContinuar');
    if(formContinuar) {
        formContinuar.addEventListener('submit', function(e) {
            if (seleccionadas.length === 0) {
                e.preventDefault();
                alert('Debes seleccionar al menos una butaca.');
                return;
            }

            document.getElementById('inputButacas').value = JSON.stringify(seleccionadas);
        });
    };
});

document.addEventListener('DOMContentLoaded', function () {
    const link = document.createElement('a');
    link.href = linkDownload;
    link.download = '';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
});
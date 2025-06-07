@extends('layouts.procesoCompra')

@section('Proceso de Compra')
<img src="{{ asset($infoPelicula->foto_grande) }}" class="w-full h-100 object-cover object-top" alt="Paso 1: Selección de productos">
<div class="relative font-primary-font">
    <p class="text-5xl font-bold absolute left-[25%] bottom-[-20px] text-white">{{$infoPelicula->titulo}}</p>
</div>

<div class="container mx-auto my-10 flex justify-center flex-wrap font-primary-font">

    <p class="text-white text-xl">ELIGE TUS ASIENTOS</p>

    <div class="flex justify-center gap-8 w-full mt-4">
        <div class="flex items-center gap-2">
            <svg class="w-3 h-3 sm:w-4 sm:h-4 md:w-8 md:h-8"><use href="#v-icon_standard-available"/></svg>
            <span class="text-white">Disponible</span>
        </div>
        <div class="flex items-center gap-2">
            <svg class="w-3 h-3 sm:w-4 sm:h-4 md:w-8 md:h-8"><use href="#v-icon_standard-unavailable"/></svg></svg>
            <span class="text-white">Ocupado</span>
        </div>
        <div class="flex items-center gap-2">
            <svg class="w-3 h-3 sm:w-4 sm:h-4 md:w-8 md:h-8"><use href="#v-icon_standard-selected"/></svg>
            <span class="text-white">Seleccionado</span>
        </div>
    </div>

    <div id='contenedor-mapa' class="mt-10 grid gap-[2px] w-full max-w-lg text-white text-xl grid-cols-{{ $infoPelicula->cantidadColumnas + 1 }}">
        <div id="pantalla" class="col-start-2 col-end-{{ $infoPelicula->cantidadColumnas + 2 }} text-center bg-gray-600 mb-1 px-2">Pantalla</div>

        <div></div>
        @for ($i = 1; $i <= $infoPelicula->cantidadColumnas; $i++)
            <div class="text-center">{{ $i }}</div>
        @endfor

        @php
            /*
            const mapaObjeto = JSON.parse(mapa);
            let mapaNumerico = Object.values(mapaObjeto);
            let mapaLetras = Object.keys(mapaObjeto);*/
            $mapaObjeto = json_decode($infoPelicula->butacasReservadas, true);
            $mapaNumerico = array_values($mapaObjeto);
            $mapaLetras = array_keys($mapaObjeto);
        @endphp 

        @for ($f = 0; $f < $infoPelicula->cantidadFilas; $f++)
            @php
                $letra = $mapaLetras[$f];
            @endphp

            <div class="text-center">{{ $letra }}</div>

            @for ($c = 1; $c <= $infoPelicula->cantidadColumnas; $c++)
                @if ($mapaObjeto[$letra][$c])
                    <div class="flex justify-center"><svg class="w-3 h-3 sm:w-4 sm:h-4 md:w-8 md:h-8"><use href="#v-icon_standard-unavailable"/></svg></div>
                @else
                    <div class="flex justify-center">
                        <svg class="w-3 h-3 sm:w-4 sm:h-4 md:w-8 md:h-8 cursor-pointer butaca-disponible" 
                        data-fila="{{ $letra }}" 
                        data-columna="{{ $c }}"
                        ><use href="#v-icon_standard-available"/></svg>
                    </div>
                @endif
            @endfor
        @endfor

        <div class="w-full flex justify-center mt-8">
            <form id="formContinuar" method="GET" action="{{ route('procesoCompra.paso2') }}">
                <input type="hidden" name="idSesion" value="{{ $infoPelicula->id }}">
                <input type="hidden" name="butacas" id="inputButacas">

                <button 
                    type="submit"
                    class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 mt-6"
                >
                    Continuar al resumen
                </button>
            </form>
        </div>


    </div>
</div>


@endsection

<!-- Definición del ícono de butaca -->
<svg style="display: none;">
    <symbol id="v-icon_standard-available" viewBox="0 0 35 35" fill="gray" stroke="none" xmlns="http://www.w3.org/2000/svg">
        <path fill="transparent" d="M0 0h35v35H0z"></path>
        <g transform="translate(5 4)" style="fill:#a1a7b1;stroke:#000;stroke-miterlimit:10">
            <rect width="25" height="27" rx="1"></rect>
            <rect width="24" height="26" x=".5" y=".5" rx=".5" style="fill:none"></rect>
        </g>
        <g transform="translate(28 11)" style="fill:#a1a7b1;stroke:#000;stroke-miterlimit:10">
            <rect width="3" height="15" rx="1"></rect>
            <rect width="2" height="14" x=".5" y=".5" rx=".5" style="fill:none"></rect>
        </g>
        <g transform="translate(4 11)" style="fill:#a1a7b1;stroke:#000;stroke-miterlimit:10">
            <rect width="3" height="15" rx="1"></rect>
            <rect width="2" height="14" x=".5" y=".5" rx=".5" style="fill:none"></rect>
        </g>
    </symbol>
</svg>

<svg style="display: none;">
    <symbol id="v-icon_standard-unavailable" viewBox="0 0 35 35" fill="yellow" stroke="none" xmlns="http://www.w3.org/2000/svg">
        <path fill="transparent" data-name="icon/Seat Picker/Seat/Available Standard Copy 4 background" d="M0 0h35v35H0z"></path>
        <g transform="translate(5 4)" style="fill:yellow;stroke:#000;stroke-miterlimit:10">
            <rect width="25" height="27" rx="1" style="stroke:none" stroke="none"></rect>
            <rect width="24" height="26" x=".5" y=".5" rx=".5" style="fill:none"></rect>
        </g>
        <g data-name="Rectangle" transform="translate(28 11)" style="fill:yellow;stroke:#000;stroke-miterlimit:10">
            <rect width="3" height="15" rx="1" style="stroke:none" stroke="none"></rect>
            <rect width="2" height="14" x=".5" y=".5" rx=".5" style="fill:none"></rect>
        </g>
        <g data-name="Rectangle Copy 6" transform="translate(4 11)" style="fill:yellow;stroke:#000;stroke-miterlimit:10">
            <rect width="3" height="15" rx="1" style="stroke:none" stroke="none"></rect>
            <rect width="2" height="14" x=".5" y=".5" rx=".5" style="fill:none"></rect>
        </g>
    </symbol>
</svg>

<svg style="display: none;">
    <symbol id="v-icon_standard-selected" viewBox="0 0 35 35" fill="#aa8447" stroke="none" xmlns="http://www.w3.org/2000/svg">
        <path fill="transparent" data-name="icon/Seat Picker/Seat/Available Standard Copy 4 background" d="M0 0h35v35H0z"></path>
        <g transform="translate(5 4)" style="fill:#aa8447;stroke:#000;stroke-miterlimit:10">
            <rect width="25" height="27" rx="1" style="stroke:none" stroke="none"></rect>
            <rect width="24" height="26" x=".5" y=".5" rx=".5" style="fill:none"></rect>
        </g>
        <g data-name="Rectangle" transform="translate(28 11)" style="fill:#aa8447;stroke:#000;stroke-miterlimit:10">
            <rect width="3" height="15" rx="1" style="stroke:none" stroke="none"></rect>
            <rect width="2" height="14" x=".5" y=".5" rx=".5" style="fill:none"></rect>
        </g>
        <g data-name="Rectangle Copy 6" transform="translate(4 11)" style="fill:#aa8447;stroke:#000;stroke-miterlimit:10">
            <rect width="3" height="15" rx="1" style="stroke:none" stroke="none"></rect>
            <rect width="2" height="14" x=".5" y=".5" rx=".5" style="fill:none"></rect>
        </g>
    </symbol>
</svg>



<script>
    document.addEventListener('DOMContentLoaded', function(){
        const seleccionadas = [];

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
            });
        });

        document.getElementById('formContinuar').addEventListener('submit', function(e) {
            if (seleccionadas.length === 0) {
                e.preventDefault();
                alert('Debes seleccionar al menos una butaca.');
                return;
            }

            document.getElementById('inputButacas').value = JSON.stringify(seleccionadas);
        });
    });
</script>


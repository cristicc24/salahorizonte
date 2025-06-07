@extends('layouts.procesoCompra')

@section('Proceso de Compra')
    <div class="max-w-xl mx-auto text-white mt-36 p-6 mb-10 rounded-lg shadow-md font-primary-font">
        <h2 class="text-3xl font-bold mb-6 border-b border-white/20 pb-2 text-center">
            ¡Pedido confirmado!
        </h2>

        <p class="text-center text-lg text-white/90">Gracias por tu compra.</p>

        <div class="mt-6 space-y-2 text-white/80 text-sm sm:text-base">
            <p>
                <span class="font-semibold">Película:</span> {{ $infoPelicula->titulo }}
            </p>
            <p>
                <span class="font-semibold">Fecha y hora:</span> {{ \Carbon\Carbon::parse($infoPelicula->fechaHora)->format('d F Y H:i') }}
            </p>
            <p>
                <span class="font-semibold">Sala:</span> {{ $infoPelicula->idSala }}
            </p>
            @php
                // if (is_string($butacas)) {
                //     $butacas = json_decode($butacas, true);
                // }
            @endphp

            <p>
                <span class="font-semibold">Butacas:</span>
                <span class="inline-block">
                    {{-- @php
                        $butacaArray = json_decode($butacas);
                    @endphp --}}
                    @for ($i = 0; $i < count($butacas); $i++)
                        @if ($i < count($butacas) - 1)
                            {{ $butacas[$i] . ","}}
                        @else
                            {{ $butacas[$i] }}
                        @endif
                    @endfor
                </span>
            </p>
            <p>
                <span class="font-semibold">Total:</span> {{ number_format($infoPelicula->precio, 2, ',', '.') }} €
            </p>
            <p>
                <span class="font-semibold">Método de pago:</span> {{ ucfirst(request()->query('metodo', 'no especificado')) }}
            </p>
        </div>

        <div class="mt-8 text-center">
            <a href="/" class="inline-block text-white px-6 py-2 border border-white rounded hover:text-gray-900 hover:bg-white transition duration-200">
                Volver al inicio
            </a>
        </div>
    </div>
@endsection

@if(isset($pdfPath))
    <script>
        window.addEventListener('DOMContentLoaded', function () {
            const link = document.createElement('a');
            link.href = "{{ $pdfPath }}";
            link.download = '';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        });
    </script>
@endif

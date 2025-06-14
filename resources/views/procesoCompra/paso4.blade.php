@extends('layouts.procesoCompra')

@section('Proceso de Compra')
<div class="max-w-xl mx-auto text-white mt-28 p-6 mb-8 rounded-lg shadow-md font-primary-font">
    <h2 class="text-3xl font-bold mb-6 border-b border-white/20 pb-2 text-center">¡Pedido confirmado!</h2>

    <p class="text-center text-xl">Gracias por tu compra.</p>

    <div class="mt-6 space-y-2 text-base md:text-md lg:text-lg ">
        <p><span class="font-semibold">Película:</span> {{ $infoPelicula->pelicula->titulo }}</p>
        <p><span class="font-semibold">Fecha y hora:</span> {{ \Carbon\Carbon::parse($infoPelicula->fechaHora)->format('d F Y H:i') }}</p>
        <p><span class="font-semibold">Sala:</span> {{ $infoPelicula->sala->idSala }}</p>
        <p><span class="font-semibold">Butacas:</span>
            @php $butacaArray = is_array($butacas) ? $butacas : json_decode($butacas, true); @endphp
            {{ implode(', ', $butacaArray) }}
        </p>
        <p><span class="font-semibold">Total:</span> {{ number_format($total, 2, ',', '.') }} €</p>
        <p><span class="font-semibold">Método de pago:</span> {{ ucfirst(request()->query('metodo', 'no especificado')) }}</p>
    </div>

    <div class="mt-8 text-center">
        <a href="{{ route('inicio') }}" class="inline-block text-white px-6 py-2 border border-white rounded hover:text-gray-900 hover:bg-white transition duration-200">
            Volver al inicio
        </a>
    </div>
</div>
@endsection

@if(isset($pdfPath))
<script>
    window.linkDownload = "{{ $pdfPath }}";
</script>
@endif

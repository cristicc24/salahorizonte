@extends('layouts.procesoCompra')

@section('Proceso de Compra')
    <div class="max-w-xl mx-auto text-white mt-28">
        <h2 class="text-3xl font-bold mb-6">¡Pedido confirmado!</h2>

        <p>Gracias por tu compra. Estas son tus entradas:</p>

        <ul class="mt-4 list-disc list-inside">
            @foreach($butacas as $butaca)
                <li>{{ $butaca }}</li>
            @endforeach
        </ul>

        <p class="mt-4">Método de pago: {{ ucfirst(request()->query('metodo', 'no especificado')) }}</p>

        <a href="/" class="mt-6 inline-block bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
            Volver al inicio
        </a>
    </div>
@endsection

@extends('layouts.procesoCompra')

@section('Proceso de Compra')
    <div class="max-w-2xl mx-auto text-white mt-32 p-6 my-4 mb-4 font-primary-font">
        <h2 class="text-3xl font-bold mb-6 border-b border-white/90 pb-2">Selecciona método de pago</h2>

        <ul class="space-y-4">
            @foreach([
                'tarjeta' => ['label' => 'Pago con tarjeta', 'icon' => 'credit-card'],
                'bizum' => ['label' => 'Bizum', 'icon' => 'device-phone-mobile'],
                'googlepay' => ['label' => 'Google Pay', 'icon' => 'globe-alt']
            ] as $metodo => $data)
                <li>
                    <a href="{{ route('procesoCompra.tpv', [
                        'idSesion' => $infoPelicula->id,
                        'butacas' => $butacas,
                        'metodo' => $metodo
                    ]) }}"
                    class="flex items-center gap-3 hover:bg-text-color/80 px-2 py-3 rounded transition duration-200">
                        @switch($data['icon'])
                            @case('credit-card')
                                <!-- Credit Card Icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M2.25 6.75A2.25 2.25 0 014.5 4.5h15a2.25 2.25 0 012.25 
                                          2.25v1.5H2.25v-1.5zM2.25 9.75h19.5v7.5A2.25 2.25 0 0119.5 
                                          19.5h-15a2.25 2.25 0 01-2.25-2.25v-7.5z" />
                                </svg>
                                @break

                            @case('device-phone-mobile')
                                <!-- Phone Icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M12 18.75h.008v.008H12v-.008zM6.75 3h10.5A1.5 1.5 0 
                                          0118.75 4.5v15a1.5 1.5 0 01-1.5 1.5H6.75a1.5 1.5 
                                          0 01-1.5-1.5v-15A1.5 1.5 0 016.75 3z" />
                                </svg>
                                @break

                            @case('globe-alt')
                                <!-- Globe Icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" 
                                    d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.347a1.125 
                                    1.125 0 0 1 0 1.972l-11.54 6.347a1.125 1.125 0 0 1-1.667-.986V5.653Z" />
                                </svg>

                                @break
                        @endswitch

                        <span class="text-lg">{{ $data['label'] }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
        <div>
            <p class="mt-6 text-sm text-gray-400">
                Al seleccionar un método de pago, serás redirigido a la pasarela de pago correspondiente.
                En caso de querer cancelar el pedido, se reembolsará la cantidad pagada si queda más de 1 hora para la sesión.
            </p>
        </div>

        <div class="mt-8">
            <a href="{{ url()->previous() }}" class="flex items-center gap-2 text-white border w-fit border-white px-4 py-2 rounded hover:bg-white/80 hover:text-gray-800 transition duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                     viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                     class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 15.75 3 12m0 0 3.75-3.75M3 12h18" />
                </svg>
                Volver atrás
            </a>
        </div>
    </div>
@endsection

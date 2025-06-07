@include('head', ['title' =>  'Proceso de Compra | Sala Horizonte'])
@include('cabeceraCompleta' , ['completo' => false])

{{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}
@yield('Proceso de Compra')

@include('footer');
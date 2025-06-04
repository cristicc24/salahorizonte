@extends('layouts.admin')

@section('contenido')
    <h2 class="text-2xl font-bold mb-4">Sesiones</h2>
    @foreach($sesiones as $sesion)
        {{-- <p>{{ $pelicula->titulo }}</p> --}}
    @endforeach
@endsection

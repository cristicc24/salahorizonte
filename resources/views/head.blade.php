<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playwrite+AU+SA:wght@100..400&family=Sigmar+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">    
    @vite('resources/css/app.css')

    @php
        use Illuminate\Support\Str;

        $route = Route::currentRouteName(); //web.php | devuelve el ->name
        //var_dump($route);
    @endphp

    @if (Str::startsWith($route, 'procesoCompra') || 
         Str::startsWith($route, 'pelicula'))
        @vite('resources/js/compra.js')    
    @endif

    @if (Str::startsWith($route, 'admin.'))
        @vite('resources/js/app-back.js')
    @else
        @vite('resources/js/app-front.js')
    @endif

    
    <title>{{ $title }}</title>
</head>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Entrada</title>
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: sans-serif;
            font-size: 14px;
            color: #111827;
            padding: 24px;
            line-height: 1.6;
        }
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
        .mb-2 { margin-bottom: 0.5rem; }
        .mb-4 { margin-bottom: 1rem; }
        .p-4 { padding: 1rem; }
        .rounded { border-radius: 0.5rem; }
        .border { border: 1px solid #e5e7eb; }
        .bg-gray-100 { background-color: #f3f4f6; }
        .flex { display: flex; align-items: center; gap: 0.5rem; }
        .qr img {
            max-width: 60%;
            height: auto;
        }
        svg { width: 1rem; height: 1rem; vertical-align: middle; }
    </style>
</head>
<body>

    <h2 class="text-center text-xl font-bold mb-4">Confirmación de Entrada</h2>

    <div class="border bg-gray-100 p-4 rounded">
        <p class="mb-2 flex">
            <!-- Película -->
            <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553 2.276A1 1 0 0120 13.118V18a1 1 0 01-1 1H5a1 1 0 01-1-1v-4.882a1 1 0 01.447-.842L9 10m6 0V6a3 3 0 00-6 0v4m6 0H9"/>
            </svg>
            <span><strong>Película:</strong> {{ $infoPelicula->titulo }}</span>
        </p>

        <p class="mb-2 flex">
            <!-- Reloj -->
            <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2m6-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span><strong>Sesión:</strong> {{ \Carbon\Carbon::parse($infoPelicula->fechaHora)->format('d/m/Y H:i') }}</span>
        </p>

        <p class="mb-2 flex">
            <!-- Sala -->
            <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 7.5V6a3 3 0 013-3h12a3 3 0 013 3v1.5M3 7.5v9a3 3 0 003 3h12a3 3 0 003-3v-9M3 7.5h18"/>
            </svg>
            <span><strong>Sala:</strong> {{ $infoPelicula->idSala }}</span>
        </p>

        <p class="mb-2 flex">
            <!-- Butacas -->
            <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
            </svg>
            <span><strong>Butacas:</strong> {{ implode(', ', $butacas) }}</span>
        </p>

        @if($usuario)
        <p class="mb-2 flex">
            <!-- Usuario -->
            <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 19.5a8.25 8.25 0 1115 0"/>
            </svg>
            <span><strong>Usuario:</strong> {{ $usuario->name }} ({{ $usuario->email }})</span>
        </p>
        @endif
    </div>

    <div class="qr text-center mt-6">
        <img src="data:image/png;base64,{{ $qrCode }}" alt="QR Entrada">
        <p class="text-sm text-gray-500 mt-2">Escanea este código al entrar</p>
    </div>
</body>
</html>


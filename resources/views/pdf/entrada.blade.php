<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Entrada</title>
    <style>
        body { font-family: sans-serif; font-size: 14px; color: #111; }
        .qr { margin-top: 20px; }
    </style>
</head>
<body>
    <h2>Confirmación de entrada</h2>

    <p><strong>Película:</strong> {{ $infoPelicula->titulo }}</p>
    <p><strong>Sesión:</strong> {{ \Carbon\Carbon::parse($infoPelicula->fechaHora)->format('d F Y H:i') }}</p>
    <p><strong>Sala:</strong> {{ $infoPelicula->idSala }}</p>
    <p><strong>Butacas:</strong> {{ implode(', ', $butacas) }}</p>

    @if($usuario)
        <p><strong>Usuario:</strong> {{ $usuario->name }} ({{ $usuario->email }})</p>
    @endif

    <div class="qr">
        <img src="data:image/png;base64,{{ $qrCode }}" alt="QR Entrada">
    </div>
</body>
</html>

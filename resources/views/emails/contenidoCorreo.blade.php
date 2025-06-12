<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Confirmación de Entrada</title>
</head>
<body style="font-family: sans-serif; background-color: #f9fafb; padding: 2rem; color: #111827;">

    <div style="max-width: 600px; margin: auto; background: white; padding: 1.5rem; border-radius: 0.5rem; border: 1px solid #e5e7eb;">
        <h1 style="font-size: 1.5rem; font-weight: bold; margin-bottom: 1rem;">
            Confirmación de tu entrada
        </h1>

        <p style="margin-bottom: 1rem;">Gracias por tu compra. Te adjuntamos la entrada en PDF para que la muestres desde el móvil o la imprimas.</p>

        <div style="background: #f3f4f6; padding: 1rem; border-radius: 0.375rem; margin-bottom: 1rem;">

            <p style="font-size: 14px; color: #6b7280; margin-top: 1rem; text-align: center;">
                <strong>Pedido #{{ $pedido->id }}</strong>
            </p>

            <p style="margin: 0.5rem 0; display: flex; align-items: center; gap: 0.5rem;">
                <!-- Película -->
                <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553 2.276A1 1 0 0120 13.118V18a1 1 0 01-1 1H5a1 1 0 01-1-1v-4.882a1 1 0 01.447-.842L9 10m6 0V6a3 3 0 00-6 0v4m6 0H9"/>
                </svg>
                <strong>Película:</strong> {{ $infoPelicula->titulo }}
            </p>

            <p style="margin: 0.5rem 0; display: flex; align-items: center; gap: 0.5rem;">
                <!-- Sesión -->
                <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2m6-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <strong>Sesión:</strong> {{ \Carbon\Carbon::parse($infoPelicula->fechaHora)->format('d/m/Y H:i') }}
            </p>

            <p style="margin: 0.5rem 0; display: flex; align-items: center; gap: 0.5rem;">
                <!-- Sala -->
                <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 7.5V6a3 3 0 013-3h12a3 3 0 013 3v1.5M3 7.5v9a3 3 0 003 3h12a3 3 0 003-3v-9M3 7.5h18"/>
                </svg>
                <strong>Sala:</strong> {{ $infoPelicula->idSala }}
            </p>

        </div>

        <p style="font-size: 0.875rem; color: #6b7280;">
            Disfruta la película,<br>
            El equipo de Sala Horizonte</strong>
        </p>
        
    </div>
</body>
</html>

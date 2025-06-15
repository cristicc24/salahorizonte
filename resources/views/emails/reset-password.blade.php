<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recuperación de Contraseña</title>
</head>
<body style="font-family: sans-serif; background-color: #f9fafb; padding: 2rem; color: #000;">

    <div style="max-width: 600px; margin: auto; background: white; padding: 1.5rem; border-radius: 0.5rem; border: 1px solid #e5e7eb;">

        <span style="display: none; font-size: 1px; color: #f9fafb;">
            Recuperación de contraseña - Sala Horizonte
        </span>

        <h1 style="font-size: 1.5rem; font-weight: bold; margin-bottom: 1rem; color: #000;">
            Hola {{ $user->name ?? '' }},
        </h1>

        <p style="margin-bottom: 1rem;">
            Recibimos una solicitud para restablecer tu contraseña. Haz clic en el botón para continuar:
        </p>

        <div style="text-align: center; margin: 2rem 0;">
            <a href="{{ $resetUrl }}"
               style="display: inline-block; padding: 0.75rem 1.5rem; background-color: #aa8447; color: white; text-decoration: none; border-radius: 0.375rem; font-weight: bold; font-size: 1rem;">
                Restablecer contraseña
            </a>
        </div>

        <p style="margin-top: 2rem; font-size: 0.875rem; color: #6b7280;">
            Si no hiciste esta solicitud, puedes ignorar este correo.
        </p>

        <p style="font-size: 0.875rem; color: #6b7280; margin-top: 1rem;">
            Gracias,<br>
            El equipo de Sala Horizonte 
        </p>
    </div>
</body>
</html>

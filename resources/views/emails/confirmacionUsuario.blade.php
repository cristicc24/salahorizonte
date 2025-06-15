<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mensaje Recibido</title>
</head>
<body style="font-family: sans-serif; background-color: #f9fafb; padding: 2rem; color: #000;">

    <div style="max-width: 600px; margin: auto; background: #ffffff; padding: 1.5rem; border-radius: 0.5rem; border: 1px solid #e5e7eb;">
        
        <span style="display: none; font-size: 1px; color: #f9fafb;">
            Hemos recibido tu mensaje – Sala Horizonte
        </span>

        <h1 style="font-size: 1.5rem; font-weight: bold; margin-bottom: 1rem; color: #000;">
            Mensaje recibido
        </h1>

        <p style="margin-bottom: 1rem;">Hola <strong>{{ $data['nombre'] }}</strong>,</p>

        <p style="margin-bottom: 1rem;">
            Gracias por contactarnos. Hemos recibido tu mensaje y te responderemos lo antes posible.
        </p>

        <hr style="border: none; border-top: 1px solid #e5e7eb; margin: 2rem 0;">

        <p style="font-size: 0.875rem; color: #6b7280;">
            Saludos cordiales,<br>
            <span style="color: #aa8447; font-weight: bold;">Equipo de Sala Horizonte</span>
        </p>
    </div>
</body>
</html>

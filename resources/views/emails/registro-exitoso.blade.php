<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro exitoso</title>
</head>
<body style="font-family: sans-serif; background-color: #f5f5f5; padding: 2rem;">
    <div style="background: white; padding: 2rem; border-radius: 8px; max-width: 600px; margin: auto;">
        <h2 style="color: #aa8447;">¡Hola {{ $user->name }}!</h2>
        <p>Gracias por registrarte en <strong>Sala Horizonte</strong>.</p>
        <p>Tu cuenta se ha creado con éxito. Ya puedes acceder al sitio y disfrutar de la cartelera.</p>
        <br>
        <a href="{{ route('inicio') }}" style="display: inline-block; padding: 10px 20px; background-color: #aa8447; color: white; text-decoration: none; border-radius: 4px;">
            Ir al sitio
        </a>
        <p style="margin-top: 2rem;">¡Esperamos verte pronto!</p>
        <p>El equipo de Sala Horizonte</p>
    </div>
</body>
</html>

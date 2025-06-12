@extends('layouts.admin')

@section('contenido')
<div class="max-w-2xl mx-auto bg-white p-6 rounded">
    <h2 class="text-xl font-bold mb-4">Configuración SMTP</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.smtp.update') }}" class="space-y-4">
        @csrf
        @method('PUT')

        <input type="text" name="mailer" value="{{ old('mailer', $smtp->mailer) }}" placeholder="Mailer" class="w-full border p-2 rounded">
        <input type="text" name="host" value="{{ old('host', $smtp->host) }}" placeholder="Host" class="w-full border p-2 rounded">
        <input type="number" name="port" value="{{ old('port', $smtp->port) }}" placeholder="Port" class="w-full border p-2 rounded">
        <input type="text" name="username" value="{{ old('username', $smtp->username) }}" placeholder="Usuario" class="w-full border p-2 rounded">
        <input type="password" name="password" value="{{ old('password', $smtp->password) }}" placeholder="Contraseña" class="w-full border p-2 rounded">
        <input type="text" name="encryption" value="{{ old('encryption', $smtp->encryption) }}" placeholder="Encriptación (tls/ssl)" class="w-full border p-2 rounded">
        <input type="email" name="from_address" value="{{ old('from_address', $smtp->from_address) }}" placeholder="Correo remitente" class="w-full border p-2 rounded">
        <input type="text" name="from_name" value="{{ old('from_name', $smtp->from_name) }}" placeholder="Nombre remitente" class="w-full border p-2 rounded">

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Guardar</button>
    </form>
</div>
@endsection

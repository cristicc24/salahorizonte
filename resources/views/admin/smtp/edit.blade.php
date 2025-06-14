@extends('layouts.admin')

@section('contenido')
<div class="max-w-2xl mx-auto bg-white p-6 rounded">
    <h2 class="text-xl font-bold mb-2">Configuración SMTP</h2>
    <p class="text-sm italic text-red-500 mb-2">No modificar si no tienes los conocimientos necesarios. Póngase en contacto con la desarrolladora</p>

    @if(session('success'))
        <div id="flash-message" class="fixed bottom-5 right-5 flex items-center gap-3 px-4 py-3 rounded shadow-lg z-50
            bg-green-100 border border-green-400 text-green-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <span class="text-sm font-medium flex-1">{{ session('success') }}</span>

            <button type="button" data-close-flash class="text-lg font-bold leading-none text-gray-500 hover:text-black focus:outline-none" aria-label="Cerrar notificación">
                &times;
            </button>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.smtp.update') }}" class="space-y-4">
        @csrf
        @method('PUT')

        <input type="text" name="mailer" value="{{ old('mailer', $smtp['mailer']) }}" placeholder="Mailer" class="w-full border p-2 rounded">
        <input type="text" name="host" value="{{ old('host', $smtp['host']) }}" placeholder="Host" class="w-full border p-2 rounded">
        <input type="number" name="port" value="{{ old('port', $smtp['port']) }}" placeholder="Port" class="w-full border p-2 rounded">
        <input type="text" name="username" value="{{ old('username', $smtp['username']) }}" placeholder="Usuario" class="w-full border p-2 rounded">
        <input type="password" name="password" value="{{ old('password', $smtp['password']) }}" placeholder="Contraseña" class="w-full border p-2 rounded">
        <input type="text" name="encryption" value="{{ old('encryption', $smtp['encryption']) }}" placeholder="Encriptación (tls/ssl)" class="w-full border p-2 rounded">
        <input type="email" name="from_address" value="{{ old('from_address', $smtp['from_address']) }}" placeholder="Correo remitente" class="w-full border p-2 rounded">
        <input type="text" name="from_name" value="{{ old('from_name', $smtp['from_name']) }}" placeholder="Nombre remitente" class="w-full border p-2 rounded">

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded cursor-pointer">Guardar</button>
    </form>
</div>
@endsection

@include('head', ['title' => 'Administración | Sala Horizonte'])

<div id="modalLogin" class="relative z-50 min-h-screen bg-primary-color flex items-center justify-center font-primary-font">
    <div class="w-full max-w-md bg-white rounded-lg shadow-lg overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-xl font-semibold text-gray-900">Iniciar sesión</h3>
    </div>

    <div class="px-6 py-5">
        @if ($errors->any())
        <div id="flash-message" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-sm text-center">
            {{ $errors->first() }}
        </div>
        @endif

        <form action="{{ route('admin.login') }}" method="POST" class="space-y-4">
        @csrf
            <div>
                <label for="email" class="block mb-2 text-base font-medium text-gray-900">Correo electrónico</label>
                <input type="email" name="email" id="email" required autocomplete="email" value="{{ old('email') }}"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg block w-full p-2.5 focus:outline-none focus:ring-2 focus:ring-text-color focus:border-text-color transition duration-200"
                    placeholder="x@salahorizonte.com">
            </div>

            <div>
                <label for="password" class="block mb-2 text-base font-medium text-gray-900">Contraseña</label>
                <input type="password" name="password" id="password" required autocomplete="current-password"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg block w-full p-2.5 focus:outline-none focus:ring-2 focus:ring-text-color focus:border-text-color transition duration-200"
                    placeholder="••••••••">
            </div>

            <button type="submit" class="w-full text-white bg-text-color hover:bg-[#a7926d] cursor-pointer font-medium rounded-lg text-base px-5 py-2.5 text-center">
                Iniciar sesión
            </button>
        </form>
    </div>
    </div>
</div>

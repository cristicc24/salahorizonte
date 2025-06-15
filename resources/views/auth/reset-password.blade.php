@include('head', ['title' => 'Restablecer contraseña | Sala Horizonte'])
@include('cabeceraCompleta', ['completo' => false])

<div class="max-w-md mx-auto mt-20 sm:mt-30 shadow-lg rounded-lg p-6 font-primary-font">
    <h2 class="text-3xl font-semibold text-center mb-6 text-text-color">Restablecer contraseña</h2>

    @if (session('status'))
        <div class="mb-4 text-green-600 font-medium text-center">
            {{ session('status') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-4 text-red-600 text-sm">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('password.store') }}" class="space-y-6">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">
        <input type="hidden" name="email" value="{{ $email }}">

        <div>
            <label for="password" class="block mb-1 text-lg font-medium text-white">Nueva contraseña</label>
            <input type="password" name="password" id="password" required
                class="w-full border border-gray-300 rounded-lg px-4 py-2 text-gray-900 focus:outline-none focus:ring-2 focus:ring-text-color focus:border-text-color transition duration-200" />
        </div>

        <div>
            <label for="password_confirmation" class="block mb-1 text-lg font-medium text-white">Confirmar contraseña</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required
                class="w-full border border-gray-300 rounded-lg px-4 py-2 text-gray-900 focus:outline-none focus:ring-2 focus:ring-text-color focus:border-text-color transition duration-200" />
        </div>

        <div>
            <button type="submit"
                class="w-full bg-text-color cursor-pointer hover:bg-[#a7926d] transition-colors duration-300 text-white py-2.5 px-4 rounded-lg font-semibold text-lg">
                Restablecer contraseña
            </button>
        </div>
    </form>
</div>


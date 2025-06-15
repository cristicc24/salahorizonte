@include('head', ['title' =>  'Registro | Sala Horizonte'])
@include('cabeceraCompleta' , ['completo' => false])

<div class="my-25 md:mt-34 lg:mt-40 text-white font-primary-font max-w-3xl md:mx-auto mx-3 px-4">

    {{-- Alerta de errores generales --}}
    @if ($errors->any())
        
    @endif

    <h3 class="text-center text-3xl mb-6">Registro de usuario</h3>

    <form class="space-y-4" action="" method="POST">
        @csrf

        {{-- Nombre y Apellidos --}}
        <div class="flex flex-col md:flex-row justify-around gap-4 md:gap-8">
            <div class="w-full">
                <label for="name" class="block mb-2 text-xl font-medium text-white">Nombre <span class="text-red-600">*</span></label>
                <input type="text" name="name" id="name"
                    value="{{ old('name') }}"
                    class="bg-gray-50 border {{ $errors->has('name') ? 'border-red-500' : 'border-gray-300' }} text-gray-900 text-lg rounded-lg block w-full p-2.5 focus:outline-none focus:ring-2 focus:ring-text-color focus:border-text-color transition duration-200"
                    placeholder="Nombre" required />
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="w-full">
                <label for="surname" class="block mb-2 text-xl font-medium text-white">Apellidos <span class="text-red-600">*</span></label>
                <input type="text" name="surname" id="surname"
                    value="{{ old('surname') }}"
                    class="bg-gray-50 border {{ $errors->has('surname') ? 'border-red-500' : 'border-gray-300' }} text-gray-900 text-lg rounded-lg block w-full p-2.5 focus:outline-none focus:ring-2 focus:ring-text-color focus:border-text-color transition duration-200"
                    placeholder="Apellidos" required />
                @error('surname')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Teléfono y Fecha de nacimiento --}}
        <div class="flex flex-col md:flex-row justify-around gap-4 md:gap-8">
            <div class="w-full">
                <label for="phonenumber" class="block mb-2 text-xl font-medium text-white">Teléfono</label>
                <input type="number" name="phonenumber" id="phonenumber"
                    value="{{ old('phonenumber') }}"
                    class="bg-gray-50 border {{ $errors->has('phonenumber') ? 'border-red-500' : 'border-gray-300' }} text-gray-900 text-lg rounded-lg block w-full p-2.5 focus:outline-none focus:ring-2 focus:ring-text-color focus:border-text-color transition duration-200"
                    placeholder="" />
                @error('phonenumber')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="w-full">
                <label for="birthdate" class="block mb-2 text-xl font-medium text-white">Fecha de nacimiento</label>
                <input type="date" name="birthdate" id="birthdate"
                    value="{{ old('birthdate') }}"
                    class="bg-gray-50 border {{ $errors->has('birthdate') ? 'border-red-500' : 'border-gray-300' }} text-gray-900 text-lg rounded-lg block w-full p-2.5 focus:outline-none focus:ring-2 focus:ring-text-color focus:border-text-color transition duration-200" />
                @error('birthdate')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Correo electrónico --}}
        <div>
            <label for="email_registro" class="block mb-2 text-xl font-medium text-white">Correo electrónico <span class="text-red-600">*</span></label>
            <input type="email" name="email_registro" id="email_registro"
                value="{{ old('email_registro') }}"
                class="bg-gray-50 border {{ $errors->has('email_registro') ? 'border-red-500' : 'border-gray-300' }} text-gray-900 text-lg rounded-lg block w-full p-2.5 focus:outline-none focus:ring-2 focus:ring-text-color focus:border-text-color transition duration-200"
                required />
            @error('email_registro')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Contraseña y Confirmar --}}
        <div class="flex flex-col md:flex-row justify-around gap-4 md:gap-8">
            <div class="w-full">
                <label for="password_registro" class="block mb-2 text-xl font-medium text-white">Contraseña <span class="text-red-600">*</span></label>
                <input type="password" name="password_registro" id="password_registro"
                    class="bg-gray-50 border {{ $errors->has('password_registro') ? 'border-red-500' : 'border-gray-300' }} text-gray-900 text-lg rounded-lg block w-full p-2.5 focus:outline-none focus:ring-2 focus:ring-text-color focus:border-text-color transition duration-200"
                    placeholder="••••••••" required />
                @error('password_registro')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <ul id="password-rules" class="text-sm mt-2 space-y-1 text-white">
                    <li id="rule-length" class="text-red-400">• Mínimo 8 caracteres</li>
                    <li id="rule-uppercase" class="text-red-400">• Al menos una letra mayúscula</li>
                    <li id="rule-lowercase" class="text-red-400">• Al menos una letra minúscula</li>
                    <li id="rule-number" class="text-red-400">• Al menos un número</li>
                    <li id="rule-special" class="text-red-400">• Al menos un carácter especial (@ $ ! % * # ? &)</li>
                </ul>
            </div>

            <div class="w-full">
                <label for="password_registro_confirmation" class="block mb-2 text-xl font-medium text-white">Confirmar contraseña <span class="text-red-600">*</span></label>
                <input type="password" name="password_registro_confirmation" id="password_registro_confirmation"
                    class="bg-gray-50 border {{ $errors->has('password_registro_confirmation') ? 'border-red-500' : 'border-gray-300' }} text-gray-900 text-lg rounded-lg block w-full p-2.5 focus:outline-none focus:ring-2 focus:ring-text-color focus:border-text-color transition duration-200"
                    placeholder="••••••••" required />
                @error('password_registro_confirmation')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <button type="submit"
            class="w-full text-white bg-text-color hover:bg-[#a7926d] cursor-pointer font-medium rounded-lg text-lg mt-4 px-5 py-2.5 text-center">
            Registrar
        </button>

        <div class="text-md font-medium text-gray-500 mt-4 text-center">
            <button type="button" data-dialog-target="modal" class="botonLogin cursor-pointer w-fit">
                ¿Ya tiene cuenta?
            </button>
        </div>
    </form>
</div>

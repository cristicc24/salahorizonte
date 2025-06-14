@include('head', ['title' =>  'Registro | Sala Horizonte'])
@include('cabeceraCompleta' , ['completo' => false])

<div class="my-25 md:mt-34 lg:mt-40 text-white font-primary-font max-w-3xl md:mx-auto mx-3 px-4">
    @if ($errors->any())
    <div>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <h3 class="text-center text-3xl mb-6">Registro de usuario</h3>
    <form class="space-y-4" action="" method="POST">
        @csrf
        <div class="flex flex-col md:flex-row justify-around gap-4 md:gap-8">
            <div class="w-full">
                <label for="name" class="block mb-2 text-xl font-medium text-white">Nombre <span class="text-red-600">*</span></label>
                <input type="text" name="name" id="name" value="{{ $errors->has('name') ? '' : old('name') }}"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg block w-full p-2.5" placeholder="Nombre" required />
            </div>
            <div class="w-full">
                <label for="surname" class="block mb-2 text-xl font-medium text-white">Apellidos <span class="text-red-600">*</span></label>
                <input type="text" name="surname" id="surname" value="{{ $errors->has('surname') ? '' : old('surname') }}"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg block w-full p-2.5" placeholder="Apellidos" required />
            </div>
        </div>

        <div class="flex flex-col md:flex-row justify-around gap-4 md:gap-8">
            <div class="w-full">
                <label for="phonenumber" class="block mb-2 text-xl font-medium text-white">Teléfono</label>
                <input type="number" name="phonenumber" id="phonenumber" value="{{ $errors->has('phonenumber') ? '' : old('phonenumber') }}"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg block w-full p-2.5" placeholder="" />
            </div>
            <div class="w-full">
                <label for="birthdate" class="block mb-2 text-xl font-medium text-white">Fecha de nacimiento</label>
                <input type="date" name="birthdate" id="birthdate" value="{{ $errors->has('birthdate') ? '' : old('birthdate') }}"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg block w-full p-2.5" />
            </div>
        </div>

        <label for="email" class="block mb-2 text-xl font-medium text-white">Correo electrónico <span class="text-red-600">*</span></label>
        <input type="email" name="email" id="email" value="{{ $errors->has('email') ? '' : old('email') }}"
        class="bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg block w-full p-2.5" placeholder="" required />

        <div class="flex flex-col md:flex-row justify-around gap-4 md:gap-8">
            <div class="w-full">
                <label for="password" class="block mb-2 text-xl font-medium text-white">Contraseña <span class="text-red-600">*</span></label>
                <input type="password" name="password" id="password" value="{{ $errors->has('password') ? '' : old('password') }}"
                placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg block w-full p-2.5" required />
            </div>
            <div class="w-full">
                <label for="password_confirmation" class="block mb-2 text-xl font-medium text-white">Confirmar contraseña <span class="text-red-600">*</span></label>
                <input type="password" name="password_confirmation" id="password_confirmation" value="{{ $errors->has('password_confirmation') ? '' : old('password_confirmation') }}"
                placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg block w-full p-2.5" required />
            </div>
        </div>

        <button type="submit" class="w-full text-white bg-text-color hover:bg-[#a7926d] cursor-pointer font-medium rounded-lg text-lg mt-4 px-5 py-2.5 text-center">Registrar</button>

        <div class="text-md font-medium text-gray-500">
            <button type="button" data-dialog-target="modal" class="botonLogin cursor-pointer w-fit">
                ¿Ya tiene cuenta?
            </button>
        </div>
    </form>
</div>
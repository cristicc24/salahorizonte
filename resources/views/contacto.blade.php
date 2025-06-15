@include('head', ['title' =>  'Contacto | Sala Horizonte'])
@include('cabeceraCompleta' , ['completo' => true])

<div class="mt-20 sm:mt-28 font-primary-font">
    <main class="py-12 px-4 text-white">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-12 items-start">

            <!-- Formulario -->
            <div class="p-8 rounded-lg shadow-none bg-transparent">
                <h3 class="text-3xl font-semibold mb-6">Contacto</h3>

                {{-- Alerta de éxito --}}
                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-600 text-white rounded shadow">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Alerta de errores generales --}}
                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-600 text-white rounded shadow text-center font-medium">
                        Se encontraron errores. Revisa los campos marcados.
                    </div>
                @endif

                <form action="{{ route('contacto.enviar') }}" method="POST" class="space-y-4">
                    @csrf

                    {{-- Nombre --}}
                    <input name="nombre" type="text" placeholder="Nombre" value="{{ old('nombre') }}" required
                        class="w-full px-4 py-2 border {{ $errors->has('nombre') ? 'border-red-500' : 'border-white' }} bg-transparent rounded-md placeholder-white/80 focus:outline-none focus:ring-2 focus:ring-text-color focus:border-text-color transition duration-200"
                        pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s\-]+" title="Solo letras y espacios">
                    @error('nombre')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror

                    {{-- Apellidos --}}
                    <input name="apellidos" type="text" placeholder="Apellidos" value="{{ old('apellidos') }}" required
                        class="w-full px-4 py-2 border {{ $errors->has('apellidos') ? 'border-red-500' : 'border-white' }} bg-transparent rounded-md placeholder-white/80 focus:outline-none focus:ring-2 focus:ring-text-color focus:border-text-color transition duration-200"
                        pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s\-]+" title="Solo letras y espacios">
                    @error('apellidos')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror

                    {{-- Teléfono --}}
                    <input name="telefono" type="tel" placeholder="Teléfono" value="{{ old('telefono') }}"
                        class="w-full px-4 py-2 border {{ $errors->has('telefono') ? 'border-red-500' : 'border-white' }} bg-transparent rounded-md placeholder-white/80 focus:outline-none focus:ring-2 focus:ring-text-color focus:border-text-color transition duration-200"
                        pattern="\d{9}" title="Debe tener 9 dígitos">
                    @error('telefono')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror

                    {{-- Email --}}
                    <input name="email" type="email" placeholder="Email" value="{{ old('email') }}" required
                        class="w-full px-4 py-2 border {{ $errors->has('email') ? 'border-red-500' : 'border-white' }} bg-transparent rounded-md placeholder-white/80 focus:outline-none focus:ring-2 focus:ring-text-color focus:border-text-color transition duration-200">
                    @error('email')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror

                    {{-- Comentario --}}
                    <textarea name="comentario" placeholder="Comentario" rows="4" required
                        class="w-full px-4 py-2 border {{ $errors->has('comentario') ? 'border-red-500' : 'border-white' }} bg-transparent rounded-md placeholder-white/80 focus:outline-none focus:ring-2 focus:ring-text-color focus:border-text-color transition duration-200 resize-none"
                        minlength="10" maxlength="1000">{{ old('comentario') }}</textarea>
                    @error('comentario')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror

                    <div class="pt-4">
                        <button type="submit"
                            class="bg-white cursor-pointer hover:bg-gray-200 text-black font-semibold px-6 py-2 rounded-md transition duration-300">
                            Enviar
                        </button>
                    </div>
                </form>
            </div>

            <!-- Mapa -->
            <div class="p-8 rounded-lg shadow-none">
                <h3 class="text-3xl font-semibold mb-4">Ubicación</h3>
                <div class="aspect-w-16 aspect-h-9">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3210.3226401717775!2d-5.1469894237432605!3d36.425580388726495!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd0cd6a790cb281f%3A0xd4ef7a2393dad45e!2sC.%20Real%2C%2029680%20Estepona%2C%20M%C3%A1laga!5e0!3m2!1ses!2ses!4v1733503306783!5m2!1ses!2ses" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade"
                        class="w-full h-[450px] border-0 rounded-lg shadow">
                    </iframe>
                </div>
            </div>
        </div>
    </main>
</div>

@include('footer')

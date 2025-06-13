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

                <form action="{{ route('contacto.enviar') }}" method="POST" class="space-y-4">
                    <input name="nombre" type="text" placeholder="Nombre" class="w-full px-4 py-2 border border-white bg-transparent rounded-md placeholder-white/80 focus:outline-none focus:ring-1 focus:ring-white">
                    <input name="apellidos" type="text" placeholder="Apellidos" class="w-full px-4 py-2 border border-white bg-transparent rounded-md placeholder-white/80 focus:outline-none focus:ring-1 focus:ring-white">
                    <input name="telefono" type="text" placeholder="Teléfono" class="w-full px-4 py-2 border border-white bg-transparent rounded-md placeholder-white/80 focus:outline-none focus:ring-1 focus:ring-white">
                    <input name="email" type="email" placeholder="Email" class="w-full px-4 py-2 border border-white bg-transparent rounded-md placeholder-white/80 focus:outline-none focus:ring-1 focus:ring-white">
                    <textarea name="comentario" placeholder="Comentario" rows="4" class="w-full px-4 py-2 border border-white bg-transparent rounded-md placeholder-white/80 focus:outline-none focus:ring-1 focus:ring-white resize-none"></textarea>
                    <div class="pt-4">
                        <button type="submit" class="bg-white hover:bg-gray-200 text-black font-semibold px-6 py-2 rounded-md transition duration-300">
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

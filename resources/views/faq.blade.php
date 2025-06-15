@include('head', ['title' => 'Preguntas frecuentes | Sala Horizonte'])
@include('cabeceraCompleta', ['completo' => true])

<main class="max-w-4xl mx-auto mt-24 px-6 sm:px-8 py-10 font-primary-font text-white">
    <h1 class="text-4xl font-bold mb-8 text-center">Preguntas frecuentes</h1>

    <div class="space-y-8 text-base sm:text-lg leading-relaxed">
        <section>
            <h2 class="font-semibold text-xl text-text-color mb-2">¿Cómo puedo comprar una entrada?</h2>
            <p>
                Puedes adquirir tus entradas en la sección <a href="{{ route('cartelera') }}" class="underline hover:text-[#aa8447] transition">Cartelera</a>.
                Selecciona la película, el horario y sigue los pasos indicados para completar la compra.
            </p>
        </section>

        <section>
            <h2 class="font-semibold text-xl text-text-color mb-2">¿Puedo cancelar o cambiar mi entrada?</h2>
            <p>
                No, las entradas no se pueden modificar ni cancelar una vez finalizada la compra. Te recomendamos verificar todos los datos antes de confirmar.
            </p>
        </section>

        <section>
            <h2 class="font-semibold text-xl text-text-color mb-2">¿Qué métodos de pago aceptan?</h2>
            <p>
                Aceptamos tarjetas de crédito, débito y transferencias bancarias. Todos los métodos disponibles se muestran al finalizar el proceso de compra.
            </p>
        </section>

        <section>
            <h2 class="font-semibold text-xl text-text-color mb-2">¿Puedo mostrar la entrada desde el móvil?</h2>
            <p>
                Sí. Al completar la compra, recibirás un archivo PDF por correo electrónico que puedes presentar directamente desde tu móvil al ingresar a la sala.
            </p>
        </section>
    </div>
</main>

@include('footer')

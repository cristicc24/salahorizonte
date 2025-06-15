@include('head', ['title' => 'Términos y condiciones | Sala Horizonte'])
@include('cabeceraCompleta', ['completo' => true])

<main class="max-w-4xl mx-auto mt-24 px-6 sm:px-8 py-10 font-primary-font text-white leading-relaxed">
    <h1 class="text-4xl font-bold mb-8 text-center">Términos y condiciones</h1>

    <p class="mb-6 text-lg text-gray-300">
        Bienvenido a Sala Horizonte. Al utilizar nuestro sitio web y servicios, aceptas los siguientes términos y condiciones. Te recomendamos leerlos detenidamente.
    </p>

    <section class="space-y-8 text-base sm:text-lg text-gray-200">
        <div>
            <h2 class="text-2xl font-semibold mb-2 text-text-color">1. Uso del servicio</h2>
            <p>Los usuarios se comprometen a utilizar el sitio exclusivamente con fines legales, respetando las normas de convivencia y uso responsable. Sala Horizonte se reserva el derecho de restringir el acceso a quienes infrinjan estas condiciones.</p>
        </div>

        <div>
            <h2 class="text-2xl font-semibold mb-2 text-text-color">2. Compra de entradas</h2>
            <p>Las compras son definitivas. No se admiten devoluciones ni modificaciones una vez procesado el pago, salvo en casos excepcionales determinados por la empresa.</p>
        </div>

        <div>
            <h2 class="text-2xl font-semibold mb-2 text-text-color">3. Propiedad intelectual</h2>
            <p>Todo el contenido presente en este sitio, incluyendo textos, logotipos, imágenes y gráficos, pertenece a Sala Horizonte. Queda prohibida su reproducción sin autorización previa por escrito.</p>
        </div>

        <div>
            <h2 class="text-2xl font-semibold mb-2 text-text-color">4. Protección de datos</h2>
            <p>Nos comprometemos a proteger tu información personal. Cualquier dato proporcionado será tratado de forma confidencial y conforme a nuestra política de privacidad.</p>
        </div>
    </section>

    <p class="mt-10 text-sm text-gray-500 text-center">
        Última actualización: {{ \Carbon\Carbon::now()->format('d/m/Y') }}
    </p>
</main>

@include('footer')

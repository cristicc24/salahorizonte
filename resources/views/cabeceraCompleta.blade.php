<body class="bg-primary-color" data-usuario-autenticado="{{ Auth::check() ? 'true' : 'false' }}">
    <header class="container-fluid w-full bg-primary-color h-20 sm:h-28 flex justify-between font-primary-font fixed top-0 z-10 border-1 border-b-text-color">
        <div @class(['flex', 'items-center', 'w-full', 'mx-2', 'md:justify-center' => !$completo, 'justify-between' => $completo, 'md:justify-start' => $completo])>
            <div class="flex justify-center text-text-color w-6/12 sm:w-4/12 h-fit">
                <a href="{{ route('inicio') }}" class="w-full max-w-[300px] sm:max-w-[400px] px-2">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo de la empresa" class="w-full h-auto">
                </a>
            </div>

            @if ($completo)
            <button id="hamburgerBtn" class="md:hidden text-text-color focus:outline-none mx-4 flex justify-end">
                <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
            <div id="backdrop" class="fixed inset-0 bg-black/40 opacity-0 pointer-events-none transition-opacity duration-300 ease-in-out md:hidden z-10"></div>
            <nav id="navLinks" class="md:static md:inset-auto md:transform-none md:transition-none md:translate-none md:justify-evenly md:flex md:flex-row md:space-y-0
                md:pt-0 md:px-0 md:max-w-none md:opacity-100 md:pointer-events-auto opacity-0 pointer-events-none fixed inset-y-0 left-0 z-50 w-4/5 max-w-xs bg-primary-color                     transition-transform duration-300 ease-in-out
                flex flex-col pt-16 space-y-4 px-6" >
                <!-- botón cerrar -->
                <button id="closeBtn" class="absolute top-4 right-4 md:hidden text-text-color focus:outline-none" aria-label="Cerrar menú">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                @if (Auth::check())
                <p class="text-xl xl:text-2xl text-text-color inline md:hidden italic font-bold"><span class="text-lg xl:text-xl">Hola,</span> {{ Auth::user()->name }}</p>
                @endif
                <a href="{{ route('inicio') }}"         class="text-xl xl:text-2xl text-text-color">Inicio</a>
                <a href="{{ route('cartelera') }}"      class="text-xl xl:text-2xl text-text-color">Cartelera</a>
                <a href="{{ route('contacto') }}"       class="text-xl xl:text-2xl text-text-color">Contacto</a>
                @if (Auth::check())
                    <a href="{{ route('usuario.perfil') }}" class="text-xl xl:text-2xl text-text-color inline md:hidden">Mi cuenta</a>
                    <form method="POST" action="{{ route('logout') }}" class="inline md:hidden">
                        @csrf
                        <button type="submit" class="cursor-pointer text-xl xl:text-2xl text-text-color">
                            Cerrar sesión
                        </button>
                    </form>
                @else
                    <button data-dialog-target="modal" class="botonLogin cursor-pointer text-xl xl:text-2xl text-text-color w-fit inline md:hidden">
                        Iniciar sesión
                    </button>
                @endif
            </nav>
            @endif
        </div>

        @if ($completo)
        <div class="text-text-color w-1/3 justify-around items-center z-20 hidden md:flex mr-4">
            @if (Auth::check())
                <p class="text-xl xl:text-2xl font-bold text-center mx-2"><span class="text-lg xl:text-xl italic">Hola,</span> {{ Auth::user()->name }}</p>
                <div class="flex gap-x-2">
                    <a href="{{ route('usuario.perfil') }}" class="text-text-color text-lg xl:text-xl hover:underline">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
                            </svg>
                        </button>
                    </form>
                </div>
            @else
                <button data-dialog-target="modal" class="botonLogin cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                </button>
            @endif
        </div>
        @endif
    </header>

    <div id="modalLogin" class="relative z-99 {{ $errors->has('email') ? 'block' : 'hidden' }}" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-500/75 transition-opacity" aria-hidden="true"></div>

        <div class="fixed inset-0 z-10 w-screen overflow-y-auto font-primary-font">
            <div class="flex min-h-full justify-center p-4 text-center items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all w-full max-w-lg">
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-200">
                        <h3 id="modalTitle" class="text-xl font-semibold text-gray-900">
                            Iniciar sesión
                        </h3>
                        <button type="button" id="btnCerrarModalLogin" class="end-2.5 cursor-pointer text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="authentication-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                  
                    <!-- Contenido dinámico -->
                    <div id="modalContent" class="p-4 md:p-5 bg-white">

                        <!-- FORMULARIO LOGIN -->
                        <div id="loginForm">
                            @if ($errors->has('email'))
                                <div class="mb-4 text-red-600 text-sm">
                                    {{ $errors->first('email') }}
                                </div>
                            @endif
                            <form class="space-y-4" action="{{ route('login') }}" method="POST">
                                @csrf
                                <input type="hidden" name="previous_url" value="{{ url()->current() }}">
                                <div>
                                    <label for="email" class="block mb-2 text-xl font-medium text-gray-900">Correo electrónico</label>
                                    <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:outline-none focus:ring-2 focus:ring-text-color focus:border-text-color transition duration-200 block w-full p-2.5" placeholder="tucorreo@ejemplo.com" required />
                                </div>
                                <div>
                                    <label for="password" class="block mb-2 text-xl font-medium text-gray-900">Contraseña</label>
                                    <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:outline-none focus:ring-2 focus:ring-text-color focus:border-text-color transition duration-200 block w-full p-2.5 " required />
                                </div>
                                <button type="submit" class="w-full text-white bg-text-color hover:bg-[#a7926d] font-medium rounded-lg text-lg px-5 py-2.5 text-center cursor-pointer">Iniciar sesión</button>
                                <div class="flex justify-between md:flex-row flex-col">
                                    <div class="text-md font-medium text-gray-500">
                                        <p>¿No registrado? <a href="{{ route('registro') }}" class="text-black hover:underline">Crear cuenta</a></p>
                                    </div>
                                    <div class="text-md font-medium text-gray-500">
                                        <a href="#" id="linkToRecover" class="text-black hover:underline">Recuperar contraseña</a>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- FORMULARIO RECUPERACIÓN (OCULTO) -->
                        <div id="recoverForm" class="hidden">
                            <form action="{{ route('password.email') }}" method="POST" class="space-y-4">
                                @csrf
                                <div>
                                    <label for="recoverEmail" class="block mb-2 text-xl font-medium text-gray-900">Correo electrónico</label>
                                    <input type="email" id="recoverEmail" name="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg block w-full p-2.5" placeholder="Ingresa tu correo" required>
                                </div>
                                <button type="submit" class="w-full text-white bg-text-color hover:bg-[#a7926d] font-medium rounded-lg text-lg px-5 py-2.5 text-center">Enviar enlace de recuperación</button>
                                <div class="text-center">
                                    <a href="#" id="backToLogin" class="text-sm text-gray-500 hover:underline">← Volver al inicio de sesión</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MENSAJE DE CONFIRMACIÓN PERSONALIZADO --}}
    @if(session('status'))
        <div id="flash-message" class="fixed top-5 right-5 z-50 flex items-center gap-3 px-4 py-3 rounded shadow-lg bg-white text-text-color">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[--color-text-color]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>

            <span class="text-sm font-medium flex-1">{{ session('status') }}</span>

            <button type="button" data-close-flash class="text-lg cursor-pointer font-bold leading-none text-gray-500 hover:text-black focus:outline-none" aria-label="Cerrar notificación">
                &times;
            </button>
        </div>
    @endif
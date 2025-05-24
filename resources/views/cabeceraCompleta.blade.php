<body class="bg-primary-color">
    <header class="container-fluid w-full bg-primary-color h-28 flex justify-between font-primary-font fixed top-0 z-10 border-1 border-b-text-color">
        <div @class(['flex', 'items-center', 'w-full', 'mx-2', 'justify-center' => !$completo])>
            <div class="h-fit flex text-text-color w-4/12 max-w-[400px]">
                <a class="w-full" href="{{ route('inicio') }}"><img src="{{ asset('images/logo.png') }}" alt="Logo de la empresa" class="w-full mx-2"></a>
            </div>
            @if ($completo)
             <div class="text-text-color flex justify-around w-8/12 text-2xl">
                <a href="{{ route('inicio') }}">Inicio</a>
                <a href="{{ route('cartelera') }}">Cartelera</a>
                <a href="{{ route('contacto') }}">Contacto</a>
            </div>
            @endif
       </div>
       @if ($completo)
       <div class="text-text-color w-1/4 flex justify-around items-center z-20">
            @if (Auth::check())
                <p class="text-2xl">Hola, {{ Auth::user()->name }}</p>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf <!-- {{ csrf_field() }} -->
                    <button type="submit" class="cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
                        </svg>
                    </button>
                </form>
            @else
                <button data-dialog-target="modal" id="botonLogin" class="cursor-pointer" >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                </button>
            @endif
       </div>
       @endif
    </header>
   
    @if ($completo)
    <div id="modalLogin" class="relative z-99 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-500/75 transition-opacity" aria-hidden="true"></div>

        <div class="fixed inset-0 z-10 w-screen overflow-y-auto font-primary-font">
            <div class="flex min-h-full justify-center p-4 text-center items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-200">
                        <h3 class="text-xl font-semibold text-gray-900">
                            Iniciar sesión
                        </h3>
                        <button type="button" id="btnCerrarModalLogin" class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="authentication-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-4 md:p-5 bg-white">
                        <form class="space-y-4" action="#">
                            <div>
                                <label for="email" class="block mb-2 text-xl font-medium text-gray-900">Correo electrónico</label>
                                <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg  block w-full p-2.5" placeholder="salahorizonte@gmail.com" required />
                            </div>
                            <div>
                                <label for="password" class="block mb-2 text-xl font-medium text-gray-900">Contraseña</label>
                                <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg block w-full p-2.5 " required />
                            </div>
                            <div class="flex justify-between">
                                <div class="flex items-start">
                                
                                </div>
                                <a href="#" class="text-md text-text-color hover:underline">Recuperar contraseña</a>
                            </div>
                            <button type="submit" class="w-full text-white bg-text-color hover:bg-[#a7926d] cursor-pointer font-medium rounded-lg text-lg px-5 py-2.5 text-center">Iniciar sesión</button>
                            <div class="text-md font-medium text-gray-500 ">
                                ¿No registrado? <a href="{{ route('registro') }}" class="text-black hover:underline">Crear cuenta</a>
                            </div>
                        </form> 
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    @endif

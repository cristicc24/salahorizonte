@include('head', ['title' => 'Administración | Sala Horizonte'])

<header class="w-full bg-primary-color h-20 sm:h-28 flex justify-between items-center font-primary-font fixed top-0 z-50 border-b border-text-color px-4 sm:px-10">
    <!-- Logo -->
    <div class="flex justify-center text-text-color w-6/12 sm:w-4/12">
        <a href="{{ route('inicio') }}" class="w-full max-w-[300px] sm:max-w-[400px] px-2">
            <img src="{{ asset('images/logo.png') }}" alt="Logo de la empresa" class="w-full h-auto">
        </a>
    </div>
    <p class="hidden sm:block font-black text-xl sm:text-2xl text-white text-center flex-1">Panel de Administración</p>

    <!-- Botón menú hamburguesa -->
    <button id="adminMenuBtn" class="md:hidden text-white focus:outline-none ml-auto">
        <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>

    <!-- Título -->
  

    <!-- Usuario + Logout en desktop -->
    <div class="hidden md:flex items-center gap-4 text-white ml-auto">
        <p class="text-lg">Hola, <strong>{{ auth()->guard('admin')->user()->nombre }}</strong></p>
        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit" class="hover:text-red-400 transition" title="Cerrar sesión">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                     stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 
                          2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 
                          0-3-3m0 0 3-3m-3 3H15" />
                </svg>
            </button>
        </form>
    </div>
</header>

<!-- Fondo oscuro del menú hamburguesa -->
<div id="adminMenuBackdrop" class="fixed inset-0 bg-black/40 opacity-0 pointer-events-none transition-opacity duration-300 ease-in-out z-40 md:hidden"></div>

<!-- Menú lateral hamburguesa -->
<nav id="adminMenu" class="fixed inset-y-0 left-0 w-4/5 max-w-xs bg-white z-50 transform -translate-x-full opacity-0 pointer-events-none transition duration-300 ease-in-out flex flex-col px-6 pt-20 space-y-6 md:hidden">

    <!-- Botón cerrar -->
    <button id="adminMenuClose" class="absolute top-4 right-4 text-black">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24"
             stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>

    <!-- Contenido -->
    <p class="text-xl font-bold text-black">Hola, {{ auth()->guard('admin')->user()->nombre }}</p>

    <a href="{{ route('admin.home') }}" class="text-lg text-black hover:underline flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round"
                    d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 
                    9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 
                    1.125-1.125h2.25c.621 0 1.125.504 1.125 
                    1.125V21h4.125c.621 0 1.125-.504 
                    1.125-1.125V9.75M8.25 21h8.25"/>
        </svg>Dashboard
    </a>
    <a href="{{ route('admin.peliculas') }}" class="text-lg text-black hover:underline flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 0 1-1.125-1.125M3.375 19.5h1.5C5.496 19.5 6 18.996 6 18.375m-3.75 0V5.625m0 
                    12.75v-1.5c0-.621.504-1.125 1.125-1.125m18.375 2.625V5.625m0 
                    12.75c0 .621-.504 1.125-1.125 
                    1.125m1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125m0  3.75h-1.5A1.125 1.125 0 0 1 18 
                    18.375M20.625 4.5H3.375m17.25 
                    0c.621 0 1.125.504 1.125 
                    1.125M20.625 4.5h-1.5C18.504 
                    4.5 18 5.004 18 5.625m3.75 
                    0v1.5c0 .621-.504 1.125-1.125 
                    1.125M3.375 4.5c-.621 0-1.125.504-1.125 
                    1.125M3.375 4.5h1.5C5.496 4.5 6 
                    5.004 6 5.625m-3.75 0v1.5c0 
                    .621.504 1.125 1.125 
                    1.125m0 0h1.5m-1.5 
                    0c-.621 0-1.125.504-1.125 
                    1.125v1.5c0 .621.504 1.125 1.125 
                    1.125m1.5-3.75C5.496 8.25 6 
                    7.746 6 7.125v-1.5M4.875 
                    8.25C5.496 8.25 6 8.754 6 
                    9.375v1.5m0-5.25v5.25m0-5.25C6 
                    5.004 6.504 4.5 7.125 
                    4.5h9.75c.621 0 1.125.504 1.125 
                    1.125m1.125 2.625h1.5m-1.5 
                    0A1.125 1.125 0 0 1 18 
                    7.125v-1.5m1.125 2.625c-.621 
                    0-1.125.504-1.125 
                    1.125v1.5m2.625-2.625c.621 0 
                    1.125.504 1.125 1.125v1.5c0 
                    .621-.504 1.125-1.125 
                    1.125M18 5.625v5.25M7.125 
                    12h9.75m-9.75 0A1.125 1.125 0 
                    0 1 6 10.875M7.125 12C6.504 12 
                    6 12.504 6 
                    13.125m0-2.25C6 11.496 5.496 
                    12 4.875 12M18 10.875c0 
                    .621-.504 1.125-1.125 
                    1.125M18 10.875c0 .621.504 
                    1.125 1.125 1.125m-2.25 
                    0c.621 0 1.125.504 1.125 
                    1.125m-12 
                    5.25v-5.25m0 
                    5.25c0 .621.504 1.125 1.125 
                    1.125h9.75c.621 0 1.125-.504 
                    1.125-1.125m-12 
                    0v-1.5c0-.621-.504-1.125-1.125-1.125M18 
                    18.375v-5.25m0 5.25v-1.5c0-.621.504-1.125 
                    1.125-1.125M18 
                    13.125v1.5c0 
                    .621.504 1.125 1.125 
                    1.125M18 13.125c0-.621.504-1.125 
                    1.125-1.125M6 13.125v1.5c0 
                    .621-.504 1.125-1.125 
                    1.125M6 13.125C6 12.504 
                    5.496 12 4.875 
                    12m-1.5 0h1.5m-1.5 
                    0c-.621 0-1.125.504-1.125 
                    1.125v1.5c0 
                    .621.504 1.125 1.125 
                    1.125M19.125 12h1.5m0 
                    0c.621 0 1.125.504 1.125 
                    1.125v1.5c0 
                    .621-.504 1.125-1.125 
                    1.125m-17.25 
                    0h1.5m14.25 0h1.5"/>
        </svg>Películas
    </a>
    <a href="{{ route('admin.sesiones') }}" class="text-lg text-black hover:underline flex items-center gap-2"> 
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                 stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 
                      9 9 0 0 1 18 0Z"/>
            </svg>    
        Sesiones
    </a>
    <a href="{{ route('admin.salas') }}" class="text-lg text-black hover:underline flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                 stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M3 7.5V6a3 3 0 0 1 3-3h12a3 3 0 0 1 3 
                      3v1.5m-18 0v9a3 3 0 0 0 3 
                      3h1.5m-4.5-12h18m0 0v9a3 3 0 0 1-3 
                      3h-1.5m-9 0h6"/>
        </svg>
        Salas
    </a>
    <a href="{{ route('admin.sliders') }}" class="text-lg text-black hover:underline flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                      d="M4.5 12h15M4.5 6h15M4.5 18h15"/>
        </svg>
        Sliders
    </a>
    <a href="{{ route('admin.smtp.edit') }}" class="text-lg text-black hover:underline flex items-center gap-2">Configuración SMTP</a>

    <form action="{{ route('admin.logout') }}" method="POST">
        @csrf
        <button type="submit" class="text-red-600 text-lg hover:underline">Cerrar sesión</button>
    </form>
</nav>

<!-- Layout principal -->
<div class="w-full flex mt-[115px] sm:mt-[100px]">
    @include('admin.menulateral')

    <div class="flex-1 p-4 sm:p-6">
        @yield('contenido')
    </div>
</div>

@yield('scripts')
   

   

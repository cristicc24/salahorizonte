<aside id="sidebarMenu" class="fixed md:static top-0 left-0 z-10 w-64 md:w-[30%] lg:w-[20%] h-full bg-white border-r-2 border-black px-6 py-10 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out md:block min-h-screen">

    <!-- Botón cerrar (solo visible en móvil) -->
    <button id="closeSidebar" class="md:hidden absolute top-4 right-4 text-gray-600 hover:text-black">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
             viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </button>

    <h2 class="text-2xl font-bold mb-6 mt-6 sm:mt-0">Administración</h2>

    <ul class="space-y-4 text-lg">
        <li class="flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                 stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 
                      9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 
                      1.125-1.125h2.25c.621 0 1.125.504 1.125 
                      1.125V21h4.125c.621 0 1.125-.504 
                      1.125-1.125V9.75M8.25 21h8.25"/>
            </svg>
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'font-bold text-text-color' : 'text-black' }}">
                Dashboard
            </a>
        </li>

        <li class="flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                 stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M3.375 19.5h17.25m-17.25 
                      0a1.125 1.125 0 0 1-1.125-1.125M3.375 
                      19.5h1.5C5.496 19.5 6 18.996 
                      6 18.375m-3.75 0V5.625m0 
                      12.75v-1.5c0-.621.504-1.125 
                      1.125-1.125m18.375 2.625V5.625m0 
                      12.75c0 .621-.504 1.125-1.125 
                      1.125m1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125m0 
                      3.75h-1.5A1.125 1.125 0 0 1 18 
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
            </svg>
            <a href="{{ route('admin.peliculas') }}"
               class="{{ request()->routeIs('admin.peliculas') ? 'font-bold text-text-color' : 'text-black' }}">
                Películas
            </a>
        </li>

        <li class="flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                 stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 
                      9 9 0 0 1 18 0Z"/>
            </svg>
            <a href="{{ route('admin.sesiones') }}"
               class="{{ request()->routeIs('admin.sesiones') ? 'font-bold text-text-color' : 'text-black' }}">
                Sesiones
            </a>
        </li>

        <li class="flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                 stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M3 7.5V6a3 3 0 0 1 3-3h12a3 3 0 0 1 3 
                      3v1.5m-18 0v9a3 3 0 0 0 3 
                      3h1.5m-4.5-12h18m0 0v9a3 3 0 0 1-3 
                      3h-1.5m-9 0h6"/>
            </svg>
            <a href="{{ route('admin.salas') }}"
               class="{{ request()->routeIs('admin.salas') ? 'font-bold text-text-color' : 'text-black' }}">
                Salas
            </a>
        </li>

        <li class="flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                      d="M4.5 12h15M4.5 6h15M4.5 18h15"/>
            </svg>
            <a href="{{ route('admin.sliders') }}"
               class="{{ request()->routeIs('admin.sliders') ? 'font-bold text-text-color' : 'text-black' }}">
                Sliders
            </a>
        </li>

        <li class="flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                      d="M3 8l7.89 5.26a2 2 0 0 0 2.22 0L21 
                      8M5 19h14a2 2 0 0 0 2-2V7a2 2 0 0 
                      0-2-2H5a2 2 0 0 0-2 2v10a2 2 0 0 
                      0 2 2z"/>
            </svg>
            <a href="{{ route('admin.smtp.show') }}"
               class="{{ request()->routeIs('admin.smtp.show') ? 'font-bold text-text-color' : 'text-black' }}">
                Configuración SMTP
            </a>
        </li>
    </ul>
</aside>

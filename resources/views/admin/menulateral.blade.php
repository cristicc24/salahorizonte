<div class="w-[25%] bg-white border-r-2 border-black py-10 px-6">
    <h2 class="text-2xl font-bold mb-6">Administración</h2>

    <ul class="space-y-4 text-lg">
        <li>
            <a href="{{ route('admin.home') }}"
               class="{{ request()->routeIs('admin.home') ? 'font-bold text-blue-600' : 'text-black' }}">
                🏠 Dashboard
            </a>
        </li>
        <li>
            <a href="{{ route('admin.peliculas') }}"
               class="{{ request()->routeIs('admin.peliculas') ? 'font-bold text-blue-600' : 'text-black' }}">
                🎬 Películas
            </a>
        </li>
        <li>
            <a href="{{ route('admin.sesiones') }}"
               class="{{ request()->routeIs('admin.sesiones') ? 'font-bold text-blue-600' : 'text-black' }}">
                🕒 Sesiones
            </a>
        </li>
    </ul>
</div>

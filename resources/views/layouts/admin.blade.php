@include('head', ['title' => 'Administración | Sala Horizonte'])

<header class="w-full h-30 shadow-md flex items-center justify-between px-14 fixed top-0 z-99 bg-black text-white font-primary-font">
    <img src="{{ asset('images/logo.png') }}" alt="" class="w-60">
    <p class="text-center font-black text-2xl">Panel de Administración de Sala Horizonte</p>
    <p>Hola, {{ auth()->guard('admin')->user()->nombre }}</p>
    <form action="{{ route('admin.logout') }}" method="POST">
        @csrf
        <button type="submit" class="text-white cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />                </svg>
        </button>
    </form>
</header>

<div class="w-full flex mt-30">
    @include('admin.menulateral')

    <div class="p-6 w-full">
        @yield('contenido')
    </div>
</div>    
   

   

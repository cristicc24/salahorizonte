@include('head', ['title' => 'Administración | Sala Horizonte'])

<header class="w-full h-30 shadow-md flex items-center justify-between px-14 fixed top-0 bg-black text-white">
    <img src="{{ asset('images/logo.png') }}" alt="" class="w-60">
    <p class="text-center font-black text-2xl">Panel de Administración de Sala Horizonte</p>
    <p>Hola, {{$administrador->nombre}}</p>
</header>
    <div class="w-full bg-amber-500 h-screen flex">
        <div class="w-[25%] bg-white h-full border-r-2 border-black"> 


        </div>
        <div class="w-[75%] h-full bg-gray-100">
            

        </div>
    </div>
    
   

   

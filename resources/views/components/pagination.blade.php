@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation"
         class="flex flex-wrap justify-center items-center gap-2 text-sm my-6 px-4 sm:px-0 w-full">
        
        {{-- Anterior --}}
        @if ($paginator->onFirstPage())
        @else
            <a href="{{ $paginator->previousPageUrl() }}"
               class="px-3 py-2 bg-gray-800 text-white rounded hover:bg-gray-700 transition">Anterior</a>
        @endif

        {{-- Páginas --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="px-3 py-2 text-gray-400">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="px-3 py-2 bg-text-color text-white rounded font-semibold">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}"
                           class="px-3 py-2 bg-gray-100 text-gray-800 rounded hover:bg-gray-300 transition">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Siguiente --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}"
               class="px-3 py-2 bg-gray-800 text-white rounded hover:bg-gray-700 transition">Siguiente</a>
        @else
            <span class="px-3 py-2 text-gray-400 bg-gray-200 rounded cursor-not-allowed">Siguiente</span>
        @endif
    </nav>
@endif

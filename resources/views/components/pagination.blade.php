@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation"
         class="flex flex-wrap justify-center items-center gap-2 text-sm my-6 px-4 sm:px-0 w-full">

        {{-- Primera página --}}
        @if ($paginator->currentPage() > 2)
            <a href="{{ $paginator->url(1) }}"
               class="px-3 py-2 bg-gray-100 text-gray-800 rounded hover:bg-gray-300 transition">1</a>
        @endif

        {{-- Tres puntitos antes --}}
        @if ($paginator->currentPage() > 3)
            <span class="px-3 py-2 text-gray-400">...</span>
        @endif

        {{-- Página anterior --}}
        @if (!$paginator->onFirstPage())
            <a href="{{ $paginator->previousPageUrl() }}"
               class="px-3 py-2 bg-gray-100 text-gray-800 rounded hover:bg-gray-300 transition">
                {{ $paginator->currentPage() - 1 }}
            </a>
        @endif

        {{-- Página actual --}}
        <span class="px-3 py-2 bg-text-color text-white rounded font-semibold">
            {{ $paginator->currentPage() }}
        </span>

        {{-- Página siguiente --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}"
            class="px-3 py-2 bg-gray-100 text-gray-800 rounded hover:bg-gray-300 transition">
                {{ $paginator->currentPage() + 1 }}
            </a>
        @endif

        {{-- Tres puntitos después --}}
        @if ($paginator->currentPage() < $paginator->lastPage() - 2)
            <span class="px-3 py-2 text-gray-400">...</span>
        @endif

        {{-- Última página --}}
        @if ($paginator->currentPage() < $paginator->lastPage() - 1)
            <a href="{{ $paginator->url($paginator->lastPage()) }}"
               class="px-3 py-2 bg-gray-100 text-gray-800 rounded hover:bg-gray-300 transition">
                {{ $paginator->lastPage() }}
            </a>
        @endif

    </nav>
@endif

@if ($paginator->hasPages())
    <div class="mt-6 flex justify-between items-center w-full">
        <p class="text-sm text-light-secondary dark:text-dark-secondary">
            {{ $paginator->firstItem() }}-{{ $paginator->lastItem() }} sur {{ $paginator->total() }}
        </p>

        <div class="flex space-x-2">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span
                    class="px-4 py-2 rounded-lg bg-light-primary/5 dark:bg-dark-primary/5 text-light-secondary/50 dark:text-dark-secondary/50 cursor-not-allowed">
                    Précédent
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}"
                    class="px-4 py-2 rounded-lg bg-light-primary/10 dark:bg-dark-primary/10 hover:bg-light-primary/20 dark:hover:bg-dark-primary/20 text-light-secondary dark:text-dark-secondary transition-colors">
                    Précédent
                </a>
            @endif
            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span
                        class="px-4 py-2 rounded-lg bg-light-primary/5 dark:bg-dark-primary/5 text-light-secondary dark:text-dark-secondary">
                        {{ $element }}
                    </span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span
                                class="px-4 py-2 rounded-lg bg-light-primary/20 dark:bg-dark-primary/20 text-light-accent dark:text-dark-accent font-medium">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}"
                                class="px-4 py-2 rounded-lg bg-light-primary/10 dark:bg-dark-primary/10 hover:bg-light-primary/20 dark:hover:bg-dark-primary/20 text-light-secondary dark:text-dark-secondary transition-colors">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}"
                    class="px-4 py-2 rounded-lg bg-light-primary/10 dark:bg-dark-primary/10 hover:bg-light-primary/20 dark:hover:bg-dark-primary/20 text-light-secondary dark:text-dark-secondary transition-colors">
                    Suivant
                </a>
            @else
                <span
                    class="px-4 py-2 rounded-lg bg-light-primary/5 dark:bg-dark-primary/5 text-light-secondary/50 dark:text-dark-secondary/50 cursor-not-allowed">
                    Suivant
                </span>
            @endif
        </div>
    </div>
@endif

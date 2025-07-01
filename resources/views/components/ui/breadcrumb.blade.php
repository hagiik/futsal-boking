<div class=" bg-red-800 text-white py-4 px-4 sm:px-6 lg:px-8">
    <nav class="text-sm container mx-auto" aria-label="Breadcrumb">
        <ol class="flex flex-wrap items-center space-x-1 sm:space-x-2">
            @foreach ($items as $item)
                @if (!$loop->last)
                    <li class="flex items-center">
                        <a href="{{ $item['url'] }}" class="hover:underline text-white font-medium">
                            {{ $item['label'] }}
                        </a>
                        <svg class="mx-2 h-4 w-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </li>
                @else
                    <li class="text-white font-semibold truncate">
                        {{ $item['label'] }}
                    </li>
                @endif
            @endforeach
        </ol>
    </nav>
</div>

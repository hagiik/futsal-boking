<div class="container mx-auto px-4 py-8">
    <div class="bg-white dark:bg-zinc-800 p-4 rounded-xl shadow-lg">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 items-center">
            <div class="md:col-span-3 relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-6 h-6 text-gray-500 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>
                <input type="text" wire:model.live.debounce.500ms="searchName" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full ps-10 p-2.5 dark:bg-zinc-700 dark:border-zinc-600 dark:placeholder-gray-400 dark:text-white" placeholder="Cari nama venue...">
            </div>
            <div x-data="{ open: false, selectedLabel: 'Semua Olahraga' }" class="relative" @click.away="open = false">
                <button @click="open = !open" class="relative bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 w-full p-2.5 text-left flex items-center dark:bg-zinc-700 dark:border-zinc-600 dark:text-white">
                    <div class="inset-y-0 start-0 flex items-center pe-2">
                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M6 4v10m0 0a2 2 0 1 0 0 4m0-4a2 2 0 1 1 0 4m0 0v2m6-16v2m0 0a2 2 0 1 0 0 4m0-4a2 2 0 1 1 0 4m0 0v10m6-16v10m0 0a2 2 0 1 0 0 4m0-4a2 2 0 1 1 0 4m0 0v2"/>
                        </svg>
                    </div>
                    <span x-text="selectedLabel" class="flex-1"></span>
                    <div class="inset-y-0 end-0 flex items-center ps-2">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400 transition-transform" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </button>

                <div x-show="open"
                    x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="absolute z-10 mt-2 w-full bg-white dark:bg-zinc-800 rounded-md shadow-lg border border-gray-200 dark:border-zinc-700"
                    style="display: none;">
                    
                    <div class="py-1">
                        <a href="#" 
                        @click.prevent="selectedLabel = 'Semua Olahraga'; $wire.set('searchCategory', ''); open = false;"
                        class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-zinc-700">
                            Semua Olahraga
                        </a>
                        
                        @foreach($categories as $category)
                            <a href="#" 
                            @click.prevent="selectedLabel = '{{ $category->name }}'; $wire.set('searchCategory', '{{ $category->id }}'); open = false;"
                            class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-zinc-700">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>


            <button class="w-full bg-red-700 text-white font-semibold p-2.5 rounded-lg hover:bg-red-800 transition">
                Cari Venue
            </button>
        </div>
    </div>

    <div wire:loading class="w-full text-center py-8">
        <p class="text-gray-500 dark:text-gray-400">Mencari venue...</p>
    </div>

    <div class="container mx-auto px-6 py-4" wire:loading.remove>
        <div class=" mt-12 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" >
            @forelse($fields as $field)
                <div class="bg-white dark:bg-zinc-800 border border-gray-100 shadow-sm dark:border-zinc-700 rounded-xl overflow-hidden hover:shadow-2xl hover:-translate-y-1 transition-all duration-300" 
                data-aos="fade-up"
                data-aos-delay="{{ ($loop->index % 3) * 100 + 100 }}">
                <a href="{{ route('lapangan.show', $field->slug) }}">
                    <div class="relative">
                        @if($field->image && count($field->image) > 0)
                            <img class="h-48 w-full object-cover transition-transform duration-300 group-hover:scale-105"
                                src="{{ asset('storage/' . $field->image[0]) }}"
                                alt="{{ $field->name }}" />
                        @else
                            <div class="w-full sm:w-full h-48 bg-gray-200 rounded-lg flex items-center justify-center">
                                <h2 class="text-center font-medium text-md text-gray-400">
                                    No Images
                                </h2>
                            </div>
                        @endif
                    </div>
                    <div class="p-6">
                        <a href="{{ route('lapangan.show', $field->slug) }}" class="text-xl font-bold text-gray-900 dark:text-white">{{ $field->name }}</a>
                        <h4 class="text-sm font-medium text-gray-300 dark:text-white"> {{ $field->category->name }}</h4>
                        <p class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                            {{ Str::limit($field->description, 100) }}
                        </p>
                    </div>
                </a>
                </div>
            @empty
                <div class="md:col-span-3 text-center py-12">
                     <p class="text-gray-500 dark:text-gray-400">Venue tidak ditemukan. Coba ubah filter pencarian Anda.</p>
                </div>
            @endforelse
        </div>
    </div>

    <div class="mt-12">
        {{ $fields->links() }}
    </div>
</div>
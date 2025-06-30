<x-layouts.app.mobile :title="__('Sewa Lapangan')">
    <div class="container  mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-8 lg:gap-12">

            @forelse ($fields as $field)
                @php
                    // Decode image jika masih string (meski sudah cast, data di DB bisa double-encoded)
                    $images = is_array($field->image) ? $field->image : json_decode($field->image, true);
                    $imageUrl = $images[0] ?? 'images/placeholder.jpg';
                    $imageSrc = Str::startsWith($imageUrl, 'http') ? $imageUrl : asset('storage/' . $imageUrl);
                @endphp

                  <div class="lg:col-span-3">
                    <!-- Gambar Lapangan (Slider jika >1 gambar) -->
                    <div>
                        @if(count($images) > 1)
                            <div class="swiper lapangan-slider rounded-xl shadow-md">
                                <div class="swiper-wrapper">
                                    @foreach($images as $img)
                                        @php
                                            $imgSrc = Str::startsWith($img, 'http') ? $img : asset('storage/' . $img);
                                        @endphp
                                        <div class="swiper-slide">
                                            <img src="{{ $imgSrc }}" alt="{{ $field->name }}" class="bg-white/95 dark:bg-zinc-900/95 border-b border-gray-200 dark:border-gray-600 w-full h-96 object-cover rounded-xl">
                                        </div>
                                    @endforeach
                                </div>
                                <!-- Navigasi panah -->
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                                <div class="swiper-pagination"></div>
                            </div>
                        @else
                            <img src="{{ $imageSrc }}" alt="{{ $field->name }}" class="w-full h-96 object-cover rounded-xl shadow-lg">
                        @endif
                    </div>

                    <!-- Info Lapangan -->
                        <div class="bg-white/95 dark:bg-zinc-900/95 border-b border-gray-200 dark:border-gray-600 p-6 rounded-xl mt-6 border">
                              <div class="">
                                    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white">{{ $field->name }}</h1>
                                    <span class="mt-2 inline-block bg-red-100 text-red-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">
                                    {{ $field->category?->name ?? 'Tanpa Kategori' }}
                                    </span>
                                    <p class="mt-4 text-xl font-bold text-gray-900 dark:text-white leading-relaxed">Deskripsi</p>
                                    <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                                    {{ $field->description }}
                                    </p>
                              </div>

                              <!-- Fasilitas -->
                              <div class="mt-8">
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Fasilitas</h3>
                                    <div class="mt-4 grid grid-cols-2 sm:grid-cols-3 gap-4">
                                    @foreach($field->facilities as $facility)
                                          <div class="flex items-center gap-3">
                                                <span class="bg-red-100 dark:bg-red-900/50 p-2 rounded-full">
                                                <svg class="w-5 h-5 text-red-700 dark:text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                </svg>
                                                </span>
                                                <span class="text-gray-700 dark:text-gray-300">{{ $facility->name }}</span>
                                          </div>
                                    @endforeach
                                    </div>
                              </div>
                        </div>
                  </div>

                <!-- Sidebar Booking -->
                <div class="lg:col-span-2">
                    <div class="sticky top-28">
                        <livewire:booking-scheduler :field="$field" />
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center text-gray-500 dark:text-gray-400">
                    Belum ada data lapangan.
                </div>
            @endforelse

        </div>
    </div>
</x-layouts.app.mobile>

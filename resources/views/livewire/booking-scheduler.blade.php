<div>
    <div class="bg-white/95 dark:bg-zinc-900/95 border-b border-gray-200 dark:border-gray-600 p-6 rounded-xl border">
        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Pilih Jadwal</h3>
<div class="mt-4">
    <label for="booking_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pilih Tanggal</label>
    <input type="date" id="booking_date" wire:model.live="selectedDate"
        class="mt-1 block w-full rounded-md border-gray-800 focus:border-lime-500 focus:ring-lime-500 sm:text-sm dark:bg-zinc-900/95 dark:border-zinc-600 py-2">
</div>

<div wire:loading wire:target="selectedDate" class="mt-4 text-center text-gray-500">
    Memuat jadwal...
</div>

<div wire:loading.remove wire:target="selectedDate">
    @if($timeSlots->isNotEmpty())
        <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-2">
            @foreach($timeSlots as $slot)
                @php
                    $isBooked = $bookedSlots->contains($slot['start']);
                    $isSelected = in_array($slot['start'], $selectedTimeSlots);
                @endphp
                <button wire:click="toggleTimeSlot('{{ $slot['start'] }}')" @disabled($isBooked)
                    class="p-2 rounded-md text-sm font-semibold transition-colors
                                        {{ $isBooked ? 'bg-gray-200 dark:bg-zinc-700 text-gray-400 dark:text-zinc-500 cursor-not-allowed' : '' }}
                                        {{ $isSelected ? 'bg-lime-500 text-white' : '' }}
                                        {{ !$isBooked && !$isSelected ? 'bg-white dark:bg-zinc-900 border border-gray-300 dark:border-zinc-600 hover:bg-lime-50 dark:hover:bg-zinc-700' : '' }}">
                    {{ $slot['label'] }}
                </button>
            @endforeach
        </div>
    @else
        <div class="mt-6 bg-gray-100 dark:bg-zinc-700/50 text-center p-4 rounded-md text-gray-500 dark:text-gray-400">
            Tidak ada jadwal tersedia untuk tanggal ini.
        </div>
    @endif
</div>
</div>

@if(count($selectedTimeSlots) > 0)
    @auth
        <div class="mt-6 bg-white dark:bg-zinc-900/95 p-6 rounded-xl border border-gray-200 dark:border-zinc-700"
            x-data="{ loading: false }">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white">Ringkasan Pesanan</h3>

            <div class="mt-4 space-y-2">
                <div class="flex justify-between">
                    <span class="text-gray-600 dark:text-gray-300">Jadwal Dipilih:</span>
                    <span class="font-semibold text-gray-800 dark:text-white text-right">
                        {{ count($selectedTimeSlots) }} jam
                    </span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600 dark:text-gray-300">Total Harga:</span>
                    <span class="font-bold text-lime-700 text-lg">
                        Rp {{ number_format($this->totalPrice, 0, ',', '.') }}
                    </span>
                </div>
            </div>

            <button wire:click="addToCart" wire:loading.attr="disabled"
                class="mt-6 w-full bg-lime-500 text-white font-bold py-3 rounded-lg hover:bg-lime-600 transition-colors disabled:opacity-50">
                <span wire:loading.remove wire:target="addToCart">
                    Booking Sekarang
                </span>
                <span wire:loading wire:target="addToCart">
                    Menambahkan ke Keranjang...
                </span>
            </button>
        </div>
    @else
        <div class="mt-6 text-center bg-lime-500 dark:bg-lime-500 p-4 rounded-lg">
            <p class="text-white dark:text-white">
                Anda harus <a href="{{ route('login') }}" class="font-bold underline">masuk</a> atau
                <a href="{{ route('register') }}" class="font-bold underline">mendaftar</a> untuk melanjutkan pemesanan.
            </p>
        </div>
    @endauth
@endif
</div>
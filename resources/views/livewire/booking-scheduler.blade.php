<div>
    <div class="bg-white/95 dark:bg-zinc-900/95 border-b border-gray-200 dark:border-gray-600 p-6 rounded-xl border">
        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Pilih Jadwal</h3>
        
        <div class="mt-4">
            <label for="booking_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pilih Tanggal</label>
            <input type="date" id="booking_date" wire:model.live="selectedDate" class="mt-1 block w-full rounded-md border-gray-800 focus:border-red-500 focus:ring-red-500 sm:text-sm dark:bg-zinc-900/95 dark:border-zinc-600 py-2">
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
                        <button 
                            wire:click="toggleTimeSlot('{{ $slot['start'] }}')"
                            @disabled($isBooked)
                            class="p-2 rounded-md text-sm font-semibold transition-colors
                                {{ $isBooked ? 'bg-gray-200 dark:bg-zinc-700 text-gray-400 dark:text-zinc-500 cursor-not-allowed' : '' }}
                                {{ $isSelected ? 'bg-red-700 text-white' : '' }}
                                {{ !$isBooked && !$isSelected ? 'bg-white dark:bg-zinc-900 border border-gray-300 dark:border-zinc-600 hover:bg-red-50 dark:hover:bg-zinc-700' : '' }}
                            ">
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
                    <span class="font-semibold text-gray-800 dark:text-white text-right">{{ count($selectedTimeSlots) }} jam</span>
                </div>
                 <div class="flex justify-between">
                    <span class="text-gray-600 dark:text-gray-300">Total Harga:</span>
                    <span class="font-bold text-red-700 text-lg">Rp {{ number_format($this->totalPrice, 0, ',', '.') }}</span>
                </div>
            </div>

            <button 
                class="mt-6 w-full bg-red-700 text-white font-bold py-3 rounded-lg hover:bg-red-800 transition-colors disabled:opacity-50"
                @click="
                    if (loading) return;
                    loading = true;

                    // Kirim request ke backend untuk membuat booking & dapatkan token
                    fetch('{{ route('booking.pay') }}', {
                        method: 'POST',
                        headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json', 
                            },
                        body: JSON.stringify({
                            field_id: {{ $field->id }},
                            booking_date: '{{ $selectedDate }}',
                            start_time: '{{ $selectedTimeSlots[0] }}',
                            end_time: '{{ Carbon\Carbon::parse($selectedTimeSlots[0])->addHour()->format('H:i:s') }}',
                            total_price: {{ $this->totalPrice }}
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.snap_token) {
                            // Buka popup pembayaran Midtrans Snap
                            window.snap.pay(data.snap_token, {
                                onSuccess: function(result){ alert('Pembayaran berhasil!'); window.location.reload(); },
                                onPending: function(result){ alert('Pembayaran tertunda.'); window.location.reload(); },
                                onError: function(result){ alert('Pembayaran gagal!'); loading = false; },
                                onClose: function(){ loading = false; }
                            });
                        } else {
                            alert('Gagal mendapatkan token pembayaran.');
                            loading = false;
                        }
                    })
                    .catch((error) => {
                        alert('Terjadi kesalahan.');
                        loading = false;
                    });
                "
                :disabled="loading"
            >
                <span x-show="!loading">Booking Sekarang</span>
                <span x-show="loading" class="flex items-center justify-center">
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" ...></svg>
                    Memproses...
                </span>
            </button>
        </div>
    @else
        <div class="mt-6 text-center bg-yellow-50 dark:bg-yellow-900/50 p-4 rounded-lg">
            <p class="text-yellow-800 dark:text-yellow-200">
                Anda harus <a href="{{ route('login') }}" class="font-bold underline">masuk</a> atau <a href="{{ route('register') }}" class="font-bold underline">mendaftar</a> untuk melanjutkan pemesanan.
            </p>
        </div>
    @endauth

@endif
</div>
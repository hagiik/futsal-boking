<x-layouts.app :title="__('Tiket Saya')">
    <div class="bg-white dark:bg-zinc-900/50 min-h-screen flex flex-col items-center justify-center p-4 sm:p-6">

        <header class="w-full max-w-sm text-center mb-6">
            <h1 class="text-2xl font-bold text-red-800">Tiket Anda</h1>
            <p class="text-gray-800">Terima kasih telah melakukan pemesanan!</p>
        </header>

        <div class="bg-white dark:bg-zinc-800 w-full max-w-sm rounded-2xl shadow-xl overflow-hidden border">
            
            <div>
                <img class="w-full h-48 object-cover" src="{{ asset('storage/' . $booking->field->image[0]) }}" alt="Foto {{ $booking->field->name }}">
            </div>

            <div class="p-6">
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $booking->field->category?->name ?? 'Olahraga' }}</p>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $booking->field->name }}</h2>

                <div class="mt-6 grid grid-cols-3 gap-y-4 text-center">
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Status</p>
                        <p @class([
                            'font-bold text-lg',
                            'text-yellow-600' => $booking->status === 'pending',
                            'text-blue-600' => $booking->status === 'confirmed',
                            'text-green-600' => $booking->status === 'completed',
                            'text-red-600' => $booking->status === 'cancelled',
                        ])>{{ ucfirst($booking->status) }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Tanggal</p>
                        <p class="font-bold text-lg text-gray-800 dark:text-gray-200">{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M') }}</p>
                    </div>
                     <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Tahun</p>
                        <p class="font-bold text-lg text-gray-800 dark:text-gray-200">{{ \Carbon\Carbon::parse($booking->booking_date)->format('Y') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Harga</p>
                        <p class="font-bold text-lg text-gray-800 dark:text-gray-200">Rp{{ number_format($booking->total_price / 1000, 0) }}K</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Mulai</p>
                        <p class="font-bold text-lg text-gray-800 dark:text-gray-200">{{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }}</p>
                    </div>
                     <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Selesai</p>
                        <p class="font-bold text-lg text-gray-800 dark:text-gray-200">{{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}</p>
                    </div>
                </div>
            </div>

            <div class="relative h-4">
                <div class="absolute left-0 right-0 top-1/2 h-px border-t-2 border-dashed border-gray-300"></div>
                <div class="absolute left-0 top-1/2 w-4 h-8 bg-red-700 dark:bg-red-700 rounded-r-full -translate-y-1/2"></div>
                <div class="absolute right-0 top-1/2 w-4 h-8 bg-red-700 dark:bg-red-700 rounded-l-full -translate-y-1/2"></div>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-2 gap-y-4 text-sm sm:text-base">
                    <div class="font-semibold text-gray-900 dark:text-white">Nama</div>
                    <div class="font-mono text-gray-500 dark:text-gray-400">{{ $booking->user->name }}</div>

                    <div class="font-semibold text-gray-900 dark:text-white">Booking Number</div>
                    <div class="font-mono text-gray-500 dark:text-gray-400">{{ $booking->booking_number }}</div>
                </div>
            </div>

        </div>
        <div class="mt-8 text-center">
            <a href="{{ route('profile.showlist') }}" class="text-red-700 hover:text-red-800 underline py-4 px-4 rounded-md text-sm">
                Lihat Riwayat Pesanan
            </a>
        </div>
    </div>
</x-layouts.app>
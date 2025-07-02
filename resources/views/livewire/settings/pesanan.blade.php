<?php

use Livewire\Volt\Component;
use App\Models\Booking;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination; // <-- Aktifkan paginasi

    // Method untuk membatalkan booking (kode Anda sudah benar)
    public function cancelBooking($bookingId)
    {
        $booking = Booking::where('id', $bookingId)->where('user_id', Auth::id())->firstOrFail();

        if ($booking->status === 'pending') {
            try {
                \Midtrans\Config::$serverKey = config('midtrans.server_key');
                \Midtrans\Transaction::cancel($booking->booking_number);
            } catch (\Exception $e) {
                // Abaikan error
            }
            $booking->update(['status' => 'cancelled']);
            // $this->dispatch('$refresh'); // Menggunakan with() di bawah lebih efisien daripada refresh
        }
    }

    /**
     * Mengambil data yang dibutuhkan oleh view sebelum dirender.
     * Ini akan dieksekusi setiap kali komponen di-refresh.
     */
    public function with(): array
    {
        $user = Auth::user();

        return [
            'user' => $user,
            'bookings' => $user->bookings()
                ->with(['field.category', 'payment']) // Eager load relasi penting
                ->latest()
                ->paginate(5), // Ambil 5 data per halaman
        ];
    }
}; ?>

<x-layouts.app.mobile :title="__('Profil Saya')">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Histori Pemesanan')" :subheading=" __('Menampilkan riwayat pemesanan Anda')">
        <div class="mx-auto py-16">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-6">Riwayat Pemesanan Anda</h2>

            <div class="space-y-8">
                @forelse ($bookings as $booking)
                                    <div
                                        class="relative bg-white dark:bg-zinc-800 rounded-2xl shadow-md overflow-hidden border border-gray-200 dark:border-zinc-700">

                                        {{-- Header: Booking ID & Status --}}
                                        <div class="p-4 flex justify-between items-center">
                                            <div>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">Booking ID</p>
                                                <p class="text-sm font-semibold font-mono text-gray-800 dark:text-gray-200">
                                                    {{ $booking->booking_number }}
                                                </p>
                                            </div>
                                            <span @class([
                        'px-3 py-1 text-xs font-semibold rounded-full leading-5',
                        'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' => $booking->status === 'confirmed' || $booking->status === 'completed',
                        'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' => $booking->status === 'pending',
                        'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' => $booking->status === 'cancelled',
                    ])>
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                        </div>

                                        {{-- Info Lapangan --}}
                                        <div class="p-4 flex flex-col md:flex-row gap-4">
                                            {{-- Gambar --}}
                                            @if($booking->field->image && count($booking->field->image) > 0)
                                                <img class="w-full sm:w-40 h-32 object-cover rounded-lg"
                                                    src="{{ asset('storage/' . $booking->field->image[0]) }}" alt="{{ $booking->field->name }}" />
                                            @else
                                                <div class="w-full sm:w-40 h-32 bg-gray-200 rounded-lg flex items-center justify-center">
                                                    <h2 class="text-center font-medium text-md text-gray-400">No Images</h2>
                                                </div>
                                            @endif

                                            {{-- Detail --}}
                                            <div class="flex-grow">
                                                <span class="text-xs font-medium text-lime-600 dark:text-lime-400">
                                                    {{ $booking->field->category?->name ?? 'Tanpa Kategori' }}
                                                </span>
                                                <h3 class="text-lg font-bold text-gray-900 dark:text-white mt-1">
                                                    {{ $booking->field->name }}
                                                </h3>
                                                <div class="mt-2 text-sm text-gray-600 dark:text-gray-300 space-y-1">
                                                    <p class="flex items-center gap-2">
                                                        <x-heroicon-s-calendar class="w-4 h-4 text-gray-400" />
                                                        <span>{{ \Carbon\Carbon::parse($booking->booking_date)->isoFormat('dddd, D MMMM YYYY') }}</span>
                                                    </p>
                                                    <p class="flex items-center gap-2">
                                                        <x-heroicon-s-clock class="w-4 h-4 text-gray-400" />
                                                        <span>{{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }} -
                                                            {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Garis putus-putus & notch --}}
                                        <div class="relative h-4 bg-white dark:bg-zinc-800">
                                            <div
                                                class="absolute inset-x-0 top-1/2 border-t-2 border-dashed border-gray-300 dark:border-zinc-600 transform -translate-y-1/2">
                                            </div>
                                            <div class="absolute -left-2 top-1/2 w-4 h-4 bg-white dark:bg-zinc-800 rounded-full transform -translate-y-1/2">
                                            </div>
                                            <div
                                                class="absolute -right-2 top-1/2 w-4 h-4 bg-white dark:bg-zinc-800 rounded-full transform -translate-y-1/2">
                                            </div>
                                        </div>

                                        {{-- Footer Tiket --}}
                                        <div class="p-4 flex justify-between items-center bg-gray-50 dark:bg-zinc-900">
                                            <div>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">Total Pembayaran</p>
                                                <p class="text-lg font-bold text-lime-500">
                                                    Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                                                </p>
                                            </div>

                                            {{-- Tombol Aksi --}}
                                            <div>
                                                @if ($booking->status === 'pending' && $booking->expires_at?->isFuture())
                                                                                        <div x-data="countdown('{{ $booking->expires_at?->toIso8601String() }}')">
                                                                                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1 text-center">Bayar sebelum:</p>
                                                                                            <p class="text-sm font-bold text-lime-600 mb-2 text-center" x-text="remaining"></p>

                                                                                            <div class="flex items-center gap-2" x-data="{ loading: false }">
                                                                                                <button @click="
                                                                                                                                                                                                    loading = true;
                                                                                                                                                                                                    fetch('{{ route('booking.retry', $booking) }}')
                                                                                                                                                                                                        .then(res => res.json())
                                                                                                                                                                                                        .then(data => {
                                                                                                                                                                                                            if (data.snap_token) {
                                                                                                                                                                                                                window.snap.pay(data.snap_token, {
                                                                                                                                                                                                                    onSuccess: function(result){ 
                                                        window.location.href = `/booking/success/${result.order_id}`;
                                                    },
                                                    onPending: function(result){ 
                                                        window.location.href = `/booking/success/${result.order_id}`;
                                                    },

                                                                                                                                                                                                                    onError: () => alert('Pembayaran gagal!')
                                                                                                                                                                                                                });
                                                                                                                                                                                                            } else {
                                                                                                                                                                                                                alert(data.error || 'Gagal memuat pembayaran.');
                                                                                                                                                                                                            }
                                                                                                                                                                                                        })
                                                                                                                                                                                                        .finally(() => loading = false);
                                                                                                                                                                                                "
                                                                                                    :disabled="loading"
                                                                                                    class="bg-lime-500 text-white px-3 py-2 rounded-lg text-sm hover:bg-lime-600">
                                                                                                    <template x-if="!loading">
                                                                                                        <span>Bayar Sekarang</span>
                                                                                                    </template>
                                                                                                    <template x-if="loading">
                                                                                                        <span>Memuat...</span>
                                                                                                    </template>
                                                                                                </button>
                                                                                            </div>
                                                                                        </div>
                                                @else
                                                    <a href="{{ route('booking.success', $booking->booking_number) }}"
                                                        class="bg-gray-200 text-gray-800 dark:bg-zinc-700 dark:text-gray-200 font-semibold px-4 py-2 rounded-lg hover:bg-gray-300 dark:hover:bg-zinc-600 text-sm">
                                                        Lihat Detail
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                @empty
                    <div class="text-center py-16 bg-white dark:bg-zinc-800/50 rounded-lg">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-semibold text-gray-900 dark:text-white">Tidak ada pemesanan</h3>
                        <p class="mt-1 text-sm text-gray-500">Anda belum memiliki riwayat pemesanan.</p>
                        <div class="mt-6">
                            <a href="{{ route('lapangan') }}"
                                class="inline-flex items-center rounded-md bg-lime-700 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-lime-800">
                                Cari Lapangan Sekarang
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="mt-12">
                {{ $bookings->links() }}
            </div>
        </div>
    </x-settings.layout>
</x-layouts.app.mobile>
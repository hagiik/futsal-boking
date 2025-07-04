<x-layouts.app.mobile :title="__('Keranjang Saya')">
      <div class="container mx-auto py-8">
      <h1 class="text-3xl font-bold mb-6">Keranjang Anda</h1>

      @if(empty($cartItems))
             <div class="text-center py-16 bg-white dark:bg-zinc-800/50 rounded-lg">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                aria-hidden="true">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 8H4m8 3.5v5M9.5 14h5M4 6v13a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V9a1 1 0 0 0-1-1h-5.032a1 1 0 0 1-.768-.36l-1.9-2.28a1 1 0 0 0-.768-.36H5a1 1 0 0 0-1 1Z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-semibold text-gray-900 dark:text-white">Tidak ada pemesanan</h3>
                            <p class="mt-1 text-sm text-gray-500">Anda belum memiliki riwayat pemesanan.</p>
                            <div class="mt-6">
                                <a href="{{ route('lapangan') }}"
                                    class="inline-flex items-center rounded-md bg-lime-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-lime-600">
                                    Cari Lapangan Sekarang
                                </a>
                            </div>
                        </div>
      @else
            <div class="bg-white dark:bg-zinc-800 p-6 rounded-lg shadow-md border-gray-200 dark:border-gray-200">
                  @foreach($cartItems as $id => $item)
                  <div class="flex items-center justify-between border-b py-4">
                  <div class="flex items-center">
                                @if(!empty($item['field_image']))
                                    <img class="h-20 w-20 rounded-md object-cover"
                                    src="{{ asset('storage/' . $item['field_image']) }}"
                                    alt="{{ $item['field_name'] }}" />
                              @else
                                    {{-- Fallback jika tidak ada gambar --}}
                                    <div class="h-20 w-20 bg-gray-200 rounded-md flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                              @endif
                        <div class="px-4">
                              <p class="font-bold text-lg">{{ $item['field_name'] }}</p>
                              <p class="text-sm text-gray-600 dark:text-white">{{ \Carbon\Carbon::parse($item['booking_date'])->format('d M Y') }}</p>
                              <p class="text-sm text-gray-600 dark:text-white">
                                    Jam: {{ \Carbon\Carbon::parse($item['start_time'])->format('H:i') }} - {{ \Carbon\Carbon::parse($item['end_time'])->format('H:i') }}
                              </p>
                        </div>
                  </div>
                  <div class="text-right">
                        <p class="font-bold text-lg">Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                        {{-- Tambahkan form untuk hapus item jika perlu --}}
                  </div>
                  </div>
                  @endforeach

                  <div class="mt-6">
                  <div class="flex justify-between items-center">
                        <span class="text-xl font-bold">Total</span>
                        <span class="text-xl font-bold">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                  </div>

                  <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <form action="{{ route('checkout.process') }}" method="POST">
                              @csrf
                              <input type="hidden" name="payment_method" value="cash">
                              <button type="submit" class="w-full bg-gray-700 text-white font-bold py-3 rounded-lg hover:bg-gray-800 transition-colors">
                              Bayar di Tempat
                              </button>
                        </form>

                        <button id="pay-button-midtrans" class="w-full bg-lime-500 text-white font-bold py-3 rounded-lg hover:bg-lime-600 transition-colors">
                              Bayar Sekarang (Online)
                        </button>
                  </div>
                  </div>
            </div>
      @endif
      </div>

      {{-- Script untuk Midtrans --}}
      <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
      <script type="text/javascript">
      document.getElementById('pay-button-midtrans').onclick = function(){
            fetch('{{ route('checkout.process') }}', {
                  method: 'POST',
                  headers: {
                  'Content-Type': 'application/json',
                  'X-CSRF-TOKEN': '{{ csrf_token() }}',
                  'Accept': 'application/json', 
                  },
                  body: JSON.stringify({
                  payment_method: 'midtrans'
                  })
            })
            .then(response => response.json())
            .then(data => {
                   if (data.snap_token) {
                        window.snap.pay(data.snap_token, {
                              onSuccess: function(result){ 
                              // Gunakan redirect_url dari backend kita, bukan dari Midtrans
                              window.location.href = data.redirect_url;
                              },
                              onPending: function(result){ 
                              // Arahkan juga ke halaman sukses untuk status pending
                              window.location.href = data.redirect_url;
                              },
                              onError: function(result){ 
                              alert('Pembayaran Gagal!'); 
                              },
                              onClose: function(){
                              alert('Anda menutup popup pembayaran.');
                              }
                        });
                  }else {
                  alert(data.error || 'Gagal memproses pembayaran.');
                  }
            })
            .catch(error => {
                  console.error('Error:', error);
                  alert('Terjadi kesalahan saat menghubungi server.');
            });
      };
      </script>
</x-layouts.app.mobile>

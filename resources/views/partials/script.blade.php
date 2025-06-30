    @fluxScripts
    @stack('scripts')
      <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
      <script type="text/javascript"
      src="https://app.{{ config('midtrans.is_production', false) ? 'midtrans' : 'sandbox.midtrans' }}.com/snap/snap.js"
      data-client-key="{{ config('midtrans.client_key') }}"></script>
      <script>

        AOS.init();

        const swiper = new Swiper('.hero-slider', {
            // Opsi-opsi
            direction: 'horizontal',
            loop: true, // Membuat slider berputar tanpa henti
            
            // Autoplay (slide otomatis)
            autoplay: {
                delay: 5000, // Jeda 5 detik sebelum pindah ke slide berikutnya
                disableOnInteraction: false, // Autoplay tidak berhenti setelah interaksi user
            },

            // Efek transisi (fade terlihat bagus untuk hero slider)
            effect: 'fade',
            fadeEffect: {
                crossFade: true
            },

            // Paginasi (titik-titik)
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },

            // Tombol Navigasi (panah)
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });

        const reviewSlider = new Swiper('.review-slider', {
            // loop: true, // Loop bisa diaktifkan jika slide lebih banyak dari slidesPerView
            spaceBetween: 24, // Jarak antar slide
            
            // Atur jumlah slide yang terlihat berdasarkan ukuran layar
            slidesPerView: 1,
            breakpoints: {
                // Tampilkan 1.5 slide di layar medium
                768: {
                    slidesPerView: 1.5,
                },
                // Tampilkan 2.5 slide di layar besar
                1024: {
                    slidesPerView: 2.5,
                }
            },

            // Paginasi menggunakan progress bar
            pagination: {
                el: '.review-swiper-pagination',
                type: 'progressbar',
            },

            // Navigasi menggunakan tombol panah
            navigation: {
                nextEl: '.review-swiper-button-next',
                prevEl: '.review-swiper-button-prev',
            },
        });

    function countdown(expiry) {
        return {
            expiry: expiry,
            remaining: '',
            init() {
                if (!this.expiry) return;
                this.setRemaining();
                const interval = setInterval(() => {
                    this.setRemaining();
                    if (new Date(this.expiry) - new Date() < 0) {
                        clearInterval(interval);
                    }
                }, 1000);
            },
            setRemaining() {
                const diff = new Date(this.expiry) - new Date();
                if (diff < 0) {
                    this.remaining = 'Waktu Habis';
                    return;
                }
                const hours = Math.floor(diff / 1000 / 60 / 60);
                const minutes = Math.floor(diff / 1000 / 60) % 60;
                const seconds = Math.floor(diff / 1000) % 60;
                this.remaining = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            }
        }
    }
    </script>
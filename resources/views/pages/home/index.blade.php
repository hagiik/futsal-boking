<x-layouts.app :title="__('Home')">
    <div class="swiper hero-slider h-screen">
    <div class="swiper-wrapper">

        <div class="swiper-slide">
            <section class="relative h-full bg-cover bg-center flex items-center" 
                     style="background-image: url('https://ayo.co.id/assets/img/main-hero-image.jpg');">
                <div class="absolute inset-0 bg-black/50"></div>
                <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="relative z-10 max-w-2xl">
                        <h1 class="text-5xl font-bold text-white md:text-6xl lg:text-7xl leading-tight">
                            Super Sport <br> Community App
                        </h1>
                        <p class="mt-6 text-lg text-gray-200 max-w-lg">
                            Platform all-in-one untuk sewa lapangan, cari kawan sparring, atau cari kawan main bareng.
                        </p>
                        </div>
                </div>
            </section>
        </div>

        <div class="swiper-slide">
             <section class="relative h-full bg-cover bg-center flex items-center" 
                     style="background-image: url('https://images.unsplash.com/photo-1552667466-07770ae110d0?q=80&w=2070&auto=format&fit=crop');">
                <div class="absolute inset-0 bg-black/50"></div>
                <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="relative z-10 max-w-2xl">
                        <h1 class="text-5xl font-bold text-white md:text-6xl lg:text-7xl leading-tight">
                            Temukan Lawan <br> Sparring Terbaik
                        </h1>
                        <p class="mt-6 text-lg text-gray-200 max-w-lg">
                            Tantang dirimu dan tingkatkan permainanmu dengan komunitas olahraga terbesar.
                        </p>
                         </div>
                </div>
            </section>
        </div>
        
        </div>
</div>


<section class="bg-white dark:bg-zinc-900/50 py-16 sm:py-24">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-12 gap-y-16">

            <div class="flex flex-col justify-center">
                
                <div class="flex items-center gap-2" data-aos="fade-right">
                    <button class="px-4 py-2 text-sm font-semibold rounded-full bg-lime-500 text-white">
                        PEMILIK LAPANGAN
                    </button>
                    <button class="px-4 py-2 text-sm font-semibold rounded-full bg-gray-100 hover:bg-gray-200 text-gray-600 transition">
                        PENYEWA
                    </button>
                </div>

                <h2 class="mt-8 text-3xl md:text-4xl font-bold tracking-tight text-gray-900 dark:text-white" data-aos="fade-right"
                    data-aos-delay="100">
                    Kelola venue lebih praktis dan menguntungkan.
                </h2>

                <p class="mt-6 text-base md:text-lg leading-relaxed text-gray-600 dark:text-gray-300" data-aos="fade-right"
                    data-aos-delay="200">
                    Waktunya buat venue anda lebih dari sekadar venue...
                </p>

                <a href="#" class="mt-8 inline-flex items-center gap-2 text-lime-500 hover:text-lime-600 font-semibold transition group"
                    data-aos="fade-up" data-aos-delay="300">
                    Lihat Selengkapnya
                        <svg class="w-6 h-6 transition-transform group-hover:translate-x-1"" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5m14 0-4 4m4-4-4-4"/>
                        </svg>
                </a>
            </div>

            <div class="relative flex items-start gap-4 md:gap-6" data-aos="zoom-in-up">
                <div class="flex flex-col gap-4 md:gap-6 w-1/2">
                  <div class="h-56 w-full rounded-xl shadow-lg overflow-hidden" data-aos="zoom-in" data-aos-delay="400">
                    <img src="{{ asset('https://plus.unsplash.com/premium_photo-1684713510655-e6e31536168d?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D') }}" alt="Venue 1" class="w-full h-auto object-cover rounded-xl shadow-md">
                  </div>
                  <div class="h-80 w-full rounded-xl shadow-lg overflow-hidden" data-aos="zoom-in" data-aos-delay="500">
                    <img src="{{ asset('https://images.unsplash.com/photo-1620742820748-87c09249a72a?q=80&w=627&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D') }}" alt="Venue 2" class="w-full h-auto object-cover rounded-xl shadow-md">
                  </div>
                  <div class="h-56 w-full rounded-xl shadow-lg overflow-hidden" data-aos="zoom-in" data-aos-delay="600">
                    <img src="{{ asset('https://plus.unsplash.com/premium_photo-1684106553502-e4f80cac5964?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D') }}" alt="Venue 3" class="w-full h-auto object-cover rounded-xl shadow-md">
                  </div>
                </div>
                
                <div class="flex flex-col gap-4 md:gap-6 w-1/2 mt-12 md:mt-16">
                  <div class="h-80 w-full rounded-xl shadow-lg overflow-hidden" data-aos="zoom-in" data-aos-delay="400">
                    <img src="{{ asset('https://plus.unsplash.com/premium_photo-1684106554190-dd5a5eaa8eba?q=80&w=687&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D') }}" alt="Venue 4" class="w-full h-auto object-cover rounded-xl shadow-md">
                  </div>
                  <div class="h-56 w-full rounded-xl shadow-lg overflow-hidden" data-aos="zoom-in" data-aos-delay="500">
                    <img src="{{ asset('https://images.unsplash.com/photo-1626721105368-a69248e93b32?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D') }}" alt="Venue 6" class="w-full h-auto object-cover rounded-xl shadow-md">
                  </div>
                </div>

            </div>

        </div>
    </div>
</section>

<section class="bg-white dark:bg-zinc-900/50 py-16 sm:py-24 overflow-hidden" id="competitions">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center">
            
            <h2 class="text-3xl font-bold tracking-tight text-lime-500 dark:text-white sm:text-4xl" data-aos="fade-up">
                Cari kompetisi terbaik untuk tim Anda!
            </h2>

            <p class="mt-4 max-w-full mx-auto text-lg leading-8 text-gray-600 dark:text-gray-400" data-aos="fade-up" data-aos-delay="100">
                Ikuti berbagai pilihan kompetisi dari AYO Indonesia dan operator kompetisi lainnya. Rasakan keseruan silaturahmi di lapangan bersama ribuan tim amatir lainnya sekarang juga!
            </p>

        </div>

      <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8" data-aos="fade-up" data-aos-delay="200">
          
          <div class="relative group overflow-hidden rounded-xl shadow-md" data-aos="zoom-in" data-aos-delay="300">
            <a href="#">
              <img class="w-full h-full object-cover transition duration-500 group-hover:scale-110" src="https://images.unsplash.com/photo-1583275478661-1c31970669fa?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Foto kompetisi 1">
              
              <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
              <div class="absolute bottom-0 left-0 right-0 p-6 transform translate-y-full group-hover:translate-y-0 transition-transform duration-500 ease-in-out">
                  <h3 class="text-xl font-bold text-white">Turnamen Badminton Ganda</h3>
                  <p class="mt-1 text-sm text-white/80">Diselenggarakan oleh Komunitas Raket Mania</p>
              </div>
            </a>
          </div>
          
          <div class="relative group overflow-hidden rounded-xl shadow-md" data-aos="zoom-in" data-aos-delay="400">
            <a href="#">
              <img class="w-full h-full object-cover transition duration-500 group-hover:scale-110" src="https://images.unsplash.com/photo-1722087642932-9b070e9a066e?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Foto kompetisi 2">
              
              <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
              <div class="absolute bottom-0 left-0 right-0 p-6 transform translate-y-full group-hover:translate-y-0 transition-transform duration-500 ease-in-out">
                  <h3 class="text-xl font-bold text-white">Liga Futsal Amatir</h3>
                  <p class="mt-1 text-sm text-white/80">Musim ke-5, digelar di Lapangan Garuda</p>
              </div>
            </a>
          </div>
          
          <div class="relative group overflow-hidden rounded-xl shadow-md" data-aos="zoom-in" data-aos-delay="500">
            <a href="#">
              <img class="w-full h-full object-cover transition duration-500 group-hover:scale-110" src="https://images.unsplash.com/photo-1560272564-c83b66b1ad12?q=80&w=1949&auto=format&fit=crop" alt="Foto kompetisi 3">

              <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
              <div class="absolute bottom-0 left-0 right-0 p-6 transform translate-y-full group-hover:translate-y-0 transition-transform duration-500 ease-in-out">
                  <h3 class="text-xl font-bold text-white">Kompetisi Sepak Bola U-21</h3>
                  <p class="mt-1 text-sm text-white/80">Memperebutkan piala bergengsi tahun ini</p>
              </div>
            </a>
        </div>
      </div>
        
    </div>
</section>


<section class="bg-white dark:bg-zinc-900/50 py-16 sm:py-24 overflow-hidden">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center max-w-2xl mx-auto">
            <h2 class="text-3xl font-bold tracking-tight text-lime-500 dark:text-white sm:text-4xl" data-aos="fade-up">
                Baca Review, Main dengan Percaya Diri
            </h2>
            <div class="mt-6 flex items-center justify-center gap-x-3" data-aos="fade-up" data-aos-delay="100">
                <p class="text-lg font-semibold text-gray-800 dark:text-gray-200">4.8/5</p>
                <svg class="w-6 h-6 text-yellow-400 dark:text-yellow-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M13.849 4.22c-.684-1.626-3.014-1.626-3.698 0L8.397 8.387l-4.552.361c-1.775.14-2.495 2.331-1.142 3.477l3.468 2.937-1.06 4.392c-.413 1.713 1.472 3.067 2.992 2.149L12 19.35l3.897 2.354c1.52.918 3.405-.436 2.992-2.15l-1.06-4.39 3.468-2.938c1.353-1.146.633-3.336-1.142-3.477l-4.552-.36-1.754-4.17Z"/>
                </svg>
                <p class="text-base text-gray-600 dark:text-gray-400">Berdasarkan 1250+ review</p>
            </div>
        </div>

        <div class="mt-16 grid grid-cols-1 lg:grid-cols-3 lg:gap-x-16">
            <div class="hidden lg:flex flex-col justify-center" data-aos="fade-right" data-aos-delay="100">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Apa kata customer kami</h3>
                <p class="mt-6 text-base text-gray-600 dark:text-gray-400">
                    Dengarkan pengalaman langsung dari para pemain futsal yang telah menggunakan layanan kami.
                </p>
            </div>

            <div class="lg:col-span-2" data-aos="fade-left" data-aos-delay="100">
                <div class="swiper review-slider">
                    <div class="swiper-wrapper py-4">
                        <div class="swiper-slide">
                            <figure class="bg-white dark:bg-zinc-800 p-6 rounded-2xl shadow-md h-full flex flex-col border border-gray-100">
                                <blockquote class="text-gray-600 dark:text-gray-300 flex-grow">
                                    <p>"Booking lapangan jadi lebih mudah dan cepat. Sistem pembayarannya aman, dan yang paling penting lapangannya selalu sesuai dengan yang dijanjikan. Mantap!"</p>
                                </blockquote>
                                <div class="flex items-center gap-1 mt-4">
                                  @for ($i = 0; $i < 5; $i++)
                                    <svg class="w-6 h-6 text-yellow-400 dark:text-yellow-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                      <path d="M13.849 4.22c-.684-1.626-3.014-1.626-3.698 0L8.397 8.387l-4.552.361c-1.775.14-2.495 2.331-1.142 3.477l3.468 2.937-1.06 4.392c-.413 1.713 1.472 3.067 2.992 2.149L12 19.35l3.897 2.354c1.52.918 3.405-.436 2.992-2.15l-1.06-4.39 3.468-2.938c1.353-1.146.633-3.336-1.142-3.477l-4.552-.36-1.754-4.17Z"/>
                                    </svg>
                                  @endfor
                                </div>
                                <figcaption class="mt-6 flex items-center gap-x-4 border-t border-gray-100 dark:border-zinc-700 pt-6">
                                    <img class="h-12 w-12 rounded-full object-cover" src="https://randomuser.me/api/portraits/men/32.jpg" alt="Budi">
                                    <div>
                                        <div class="font-semibold text-gray-900 dark:text-white">Budi Santoso</div>
                                        <div class="text-gray-600 dark:text-gray-400 text-sm">3 hari yang lalu</div>
                                    </div>
                                </figcaption>
                            </figure>
                        </div>

                        <div class="swiper-slide">
                            <figure class="bg-white dark:bg-zinc-800 p-6 rounded-2xl shadow-md h-full flex flex-col border border-gray-100">
                                <blockquote class="text-gray-600 dark:text-gray-300 flex-grow">
                                    <p>"Suka banget sama fitur cari tim sparring. Gak perlu lagi kesulitan nyari lawan tanding. Plus lapangannya selalu terawat dengan baik!"</p>
                                </blockquote>
                                <div class="flex items-center gap-1 mt-4">
                                  @for ($i = 0; $i < 5; $i++)
                                    <svg class="w-6 h-6 text-yellow-400 dark:text-yellow-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                      <path d="M13.849 4.22c-.684-1.626-3.014-1.626-3.698 0L8.397 8.387l-4.552.361c-1.775.14-2.495 2.331-1.142 3.477l3.468 2.937-1.06 4.392c-.413 1.713 1.472 3.067 2.992 2.149L12 19.35l3.897 2.354c1.52.918 3.405-.436 2.992-2.15l-1.06-4.39 3.468-2.938c1.353-1.146.633-3.336-1.142-3.477l-4.552-.36-1.754-4.17Z"/>
                                    </svg>
                                  @endfor
                                </div>
                                <figcaption class="mt-6 flex items-center gap-x-4 border-t border-gray-100 dark:border-zinc-700 pt-6">
                                    <img class="h-12 w-12 rounded-full object-cover" src="https://randomuser.me/api/portraits/men/45.jpg" alt="Ahmad">
                                    <div>
                                        <div class="font-semibold text-gray-900 dark:text-white">Ahmad Ridwan</div>
                                        <div class="text-gray-600 dark:text-gray-400 text-sm">1 minggu yang lalu</div>
                                    </div>
                                </figcaption>
                            </figure>
                        </div>

                        <div class="swiper-slide">
                            <figure class="bg-white dark:bg-zinc-800 p-6 rounded-2xl shadow-md h-full flex flex-col border border-gray-100">
                                <blockquote class="text-gray-600 dark:text-gray-300 flex-grow">
                                    <p>"Aplikasinya user friendly banget. Dari mulai booking sampai pembayaran smooth. Recommended buat yang sering main futsal!"</p>
                                </blockquote>
                                <div class="flex items-center gap-1 mt-4">
                                  @for ($i = 0; $i < 3; $i++)
                                    <svg class="w-6 h-6 text-yellow-400 dark:text-yellow-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                      <path d="M13.849 4.22c-.684-1.626-3.014-1.626-3.698 0L8.397 8.387l-4.552.361c-1.775.14-2.495 2.331-1.142 3.477l3.468 2.937-1.06 4.392c-.413 1.713 1.472 3.067 2.992 2.149L12 19.35l3.897 2.354c1.52.918 3.405-.436 2.992-2.15l-1.06-4.39 3.468-2.938c1.353-1.146.633-3.336-1.142-3.477l-4.552-.36-1.754-4.17Z"/>
                                    </svg>
                                  @endfor
                                </div>
                                <figcaption class="mt-6 flex items-center gap-x-4 border-t border-gray-100 dark:border-zinc-700 pt-6">
                                    <img class="h-12 w-12 rounded-full object-cover" src="https://randomuser.me/api/portraits/women/68.jpg" alt="Sarah">
                                    <div>
                                        <div class="font-semibold text-gray-900 dark:text-white">Sarah Putri</div>
                                        <div class="text-gray-600 dark:text-gray-400 text-sm">2 minggu yang lalu</div>
                                    </div>
                                </figcaption>
                            </figure>
                        </div>

                        <div class="swiper-slide">
                            <figure class="bg-white dark:bg-zinc-800 p-6 rounded-2xl shadow-md h-full flex flex-col border border-gray-100">
                                <blockquote class="text-gray-600 dark:text-gray-300 flex-grow">
                                    <p>"Aplikasinya user friendly banget. Dari mulai booking sampai pembayaran smooth. Recommended buat yang sering main futsal!"</p>
                                </blockquote>
                                <div class="flex items-center gap-1 mt-4">
                                  @for ($i = 0; $i < 4; $i++)
                                    <svg class="w-6 h-6 text-yellow-400 dark:text-yellow-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                      <path d="M13.849 4.22c-.684-1.626-3.014-1.626-3.698 0L8.397 8.387l-4.552.361c-1.775.14-2.495 2.331-1.142 3.477l3.468 2.937-1.06 4.392c-.413 1.713 1.472 3.067 2.992 2.149L12 19.35l3.897 2.354c1.52.918 3.405-.436 2.992-2.15l-1.06-4.39 3.468-2.938c1.353-1.146.633-3.336-1.142-3.477l-4.552-.36-1.754-4.17Z"/>
                                    </svg>
                                  @endfor
                                </div>
                                <figcaption class="mt-6 flex items-center gap-x-4 border-t border-gray-100 dark:border-zinc-700 pt-6">
                                    <img class="h-12 w-12 rounded-full object-cover" src="https://randomuser.me/api/portraits/women/68.jpg" alt="Sarah">
                                    <div>
                                        <div class="font-semibold text-gray-900 dark:text-white">Sarah Putri</div>
                                        <div class="text-gray-600 dark:text-gray-400 text-sm">2 minggu yang lalu</div>
                                    </div>
                                </figcaption>
                            </figure>
                        </div>

                        <div class="swiper-slide">
                            <figure class="bg-white dark:bg-zinc-800 p-6 rounded-2xl shadow-md h-full flex flex-col border border-gray-100">
                                <blockquote class="text-gray-600 dark:text-gray-300 flex-grow">
                                    <p>"Aplikasinya user friendly banget. Dari mulai booking sampai pembayaran smooth. Recommended buat yang sering main futsal!"</p>
                                </blockquote>
                                <div class="flex items-center gap-1 mt-4">
                                  @for ($i = 0; $i < 3; $i++)
                                    <svg class="w-6 h-6 text-yellow-400 dark:text-yellow-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                      <path d="M13.849 4.22c-.684-1.626-3.014-1.626-3.698 0L8.397 8.387l-4.552.361c-1.775.14-2.495 2.331-1.142 3.477l3.468 2.937-1.06 4.392c-.413 1.713 1.472 3.067 2.992 2.149L12 19.35l3.897 2.354c1.52.918 3.405-.436 2.992-2.15l-1.06-4.39 3.468-2.938c1.353-1.146.633-3.336-1.142-3.477l-4.552-.36-1.754-4.17Z"/>
                                    </svg>
                                  @endfor
                                </div>
                                <figcaption class="mt-6 flex items-center gap-x-4 border-t border-gray-100 dark:border-zinc-700 pt-6">
                                    <img class="h-12 w-12 rounded-full object-cover" src="https://randomuser.me/api/portraits/women/68.jpg" alt="Sarah">
                                    <div>
                                        <div class="font-semibold text-gray-900 dark:text-white">Sarah Putri</div>
                                        <div class="text-gray-600 dark:text-gray-400 text-sm">2 minggu yang lalu</div>
                                    </div>
                                </figcaption>
                            </figure>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

</x-layouts.app>
<x-layouts.app :title="__('Contact Us')">

    <section class="bg-white dark:bg-zinc-900">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24">

            <div class="text-center max-w-3xl mx-auto">
                <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 dark:text-white">
                    Hubungi Kami
                </h1>
                <p class="mt-4 text-lg text-gray-600 dark:text-gray-300">
                    Punya pertanyaan atau ingin bekerja sama? Kami siap mendengarkan. Silakan hubungi kami melalui informasi di bawah atau isi formulir di samping.
                </p>
            </div>

            <div class="mt-16 grid grid-cols-1 lg:grid-cols-2 gap-12">

                <div class="space-y-8">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-12 h-12 bg-lime-100 dark:bg-lime-900/50 text-lime-600 dark:text-lime-400 rounded-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Alamat</h3>
                            <p class="mt-1 text-gray-600 dark:text-gray-300">Jl. Jenderal Sudirman Kav. 52-53, Jakarta Selatan, DKI Jakarta 12190, Indonesia</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-12 h-12 bg-lime-100 dark:bg-lime-900/50 text-lime-600 dark:text-lime-400 rounded-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Email</h3>
                            <p class="mt-1 text-gray-600 dark:text-gray-300">support@domainanda.com</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-12 h-12 bg-lime-100 dark:bg-lime-900/50 text-lime-600 dark:text-lime-400 rounded-lg flex items-center justify-center">
                             <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Telepon</h3>
                            <p class="mt-1 text-gray-600 dark:text-gray-300">(021) 1234-5678</p>
                        </div>
                    </div>
                            <div class="mt-20">
                                <div class="aspect-w-16 aspect-h-9">
                                    <iframe
                                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.241071191068!2d106.80486337593259!3d-6.23192006103389!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f143c4a67599%3A0x7fe4a9585a2ac5ac!2sPacific%20Century%20Place!5e0!3m2!1sen!2sid!4v1720880029813!5m2!1sen!2sid"
                                        width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                                        referrerpolicy="no-referrer-when-downgrade" class="rounded-2xl shadow-lg"></iframe>
                </div>
            </div>
            </div>


                <div class="bg-white dark:bg-zinc-800 p-8 rounded-2xl shadow-lg">
                    <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <div>
                            <label for="name" class="font-semibold text-gray-800 dark:text-gray-200">Nama Lengkap</label>
                            <input type="text" name="name" id="name" required
                                class="mt-2 block w-full px-4 py-3 bg-gray-50 dark:bg-zinc-700 border-gray-300 dark:border-zinc-600 rounded-lg focus:ring-lime-500 focus:border-lime-500 border-1">
                        </div>
                         <div>
                            <label for="email" class="font-semibold text-gray-800 dark:text-gray-200">Alamat Email</label>
                            <input type="email" name="email" id="email" required
                                class="mt-2 block w-full px-4 py-3 bg-gray-50 dark:bg-zinc-700 border-gray-300 dark:border-zinc-600 rounded-lg focus:ring-lime-500 focus:border-lime-500 border-1">
                        </div>
                         <div>
                            <label for="subject" class="font-semibold text-gray-800 dark:text-gray-200">Subjek</label>
                            <input type="text" name="subject" id="subject" required
                                class="mt-2 block w-full px-4 py-3 bg-gray-50 dark:bg-zinc-700 border-gray-300 dark:border-zinc-600 rounded-lg focus:ring-lime-500 focus:border-lime-500 border-1">
                        </div>
                        <div>
                            <label for="message" class="font-semibold text-gray-800 dark:text-gray-200">Pesan Anda</label>
                            <textarea name="message" id="message" rows="5" required
                                class="mt-2 block w-full px-4 py-3 bg-gray-50 dark:bg-zinc-700 border-gray-300 dark:border-zinc-600 rounded-lg focus:ring-lime-500 focus:border-lime-500 border-1"></textarea>
                        </div>
                        <div>
                            <button type="submit" class="w-full bg-lime-500 text-white font-bold py-3 px-6 rounded-lg hover:bg-lime-600 transition-all duration-300">
                                Kirim Pesan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

    

        </div>
    </section>

</x-layouts.app>
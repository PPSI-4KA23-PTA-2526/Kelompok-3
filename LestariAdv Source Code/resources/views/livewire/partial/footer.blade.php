<!-- Footer -->
<footer id="kontak" class="bg-gray-100 py-8 sm:py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8">
            <div class="text-center md:text-left">
                <img src="{{ asset('images/logo.svg') }}" alt="Lestari Adv Logo"
                    class="h-10 sm:h-12 mb-3 sm:mb-4 mx-auto md:mx-0">
                <p class="text-[#22245D] text-xs sm:text-sm">
                    Solusi lengkap percetakan digital berkualitas tinggi dengan teknologi terdepan dan pelayanan
                    terpercaya sejak 2015.
                </p>
            </div>
            <div class="text-center md:text-left">
                <h3 class="text-base sm:text-lg font-bold text-[#22235D] mb-3 sm:mb-4">Layanan Kami</h3>
                <ul class="space-y-1 text-[#22245D] text-xs sm:text-sm">
                    @foreach ($categories->take(5) as $category)
                        <li>{{ $category->nama_kategori }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="text-center md:text-left">
                <h3 class="text-base sm:text-lg font-bold text-[#22235D] mb-3 sm:mb-4">Kontak Kami</h3>
                <div class="space-y-3">
                    <div class="flex items-start gap-2 justify-center md:justify-start">
                        <div class="w-7 h-7 bg-[#22245D]/80 rounded flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <p class="text-[#22245D] text-xs sm:text-sm text-left">
                            Santa Modern Market Jalan Cisanggiri, Blok AKS no 158 Kebayoran Baru, Jakarta Selatan
                            12160
                        </p>
                    </div>
                    <div class="flex items-start gap-2 justify-center md:justify-start">
                        <div class="w-7 h-7 bg-[#22245D]/80 rounded flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z">
                                </path>
                            </svg>
                        </div>
                        <p class="text-[#22245D] text-xs sm:text-sm">+62 812 8264 700</p>
                    </div>
                    <div class="flex items-start gap-2 justify-center md:justify-start">
                        <div class="w-7 h-7 bg-[#22245D]/80 rounded flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z">
                                </path>
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                            </svg>
                        </div>
                        <p class="text-[#22245D] text-xs sm:text-sm">lestariadv@gmail.com</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-6 sm:mt-8 pt-4 sm:pt-6 border-t border-gray-300 text-center text-[#22245D] text-xs sm:text-sm">
            <p>&copy; 2025 Lestari Adv. All rights reserved.</p>
        </div>
    </div>
</footer>

@extends('layouts.app')

@section('content')
    <title>Lestari Adv - Percetakan Profesional</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            font-size: 14px;
        }

        .banner {
            position: relative;
            width: 100%;
            height: 300px;
            border-radius: 20px;
            overflow: hidden;
            color: white;
            background-image: url('{{ asset('images/header.png') }}');
            background-size: cover;
            background-position: center;
            background-color: transparent;
            /* transparan */
        }

        @media (min-width: 640px) {
            .banner {
                height: 400px;
            }
        }

        @media (min-width: 1024px) {
            .banner {
                height: 530px;
            }
        }

        /* ❌ OVERLAY DIHILANGKAN AGAR TRANSPARAN
                                    .banner::before {
                                        content: "";
                                        position: absolute;
                                        inset: 0;
                                        background: rgba(0, 0, 0, 0.25);
                                        z-index: 1;
                                    }
                                    */

        .banner-content {
            position: absolute;
            bottom: 0px;
            /* kiri bawah */
            left: 25px;
            z-index: 2;
            text-align: left;
            padding-bottom: 0px;
        }

        .cta-btn {
            background-color: #944102;
            color: #ffffff;
            border: none;
            padding: 12px 40px;
            border-radius: 90px;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }

        @media (min-width: 640px) {
            .cta-btn {
                padding: 13px 60px;
                font-size: 1rem;
            }
        }

        @media (min-width: 1024px) {
            .cta-btn {
                padding: 13px 109px;
                font-size: 1.10rem;
            }
        }

        .cta-btn:hover {
            background-color: #7a3502;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(148, 65, 2, 0.3);
        }
    </style>


    <body class="bg-white">
        <!-- Hero Section -->
        <section class="pt-20 sm:pt-24 pb-8 sm:pb-12 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="banner">
                    <div class="banner-content">
                        <a href="{{ route('produk.index') }}" class="cta-btn">Cetak designmu sekarang!</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Why Choose Us -->
        <section id="antrean" class="py-8 sm:py-12 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8 items-center">
                    <div class="text-center lg:text-left">
                        <h2 class="text-xl sm:text-2xl md:text-3xl font-bold text-[#22235D] mb-3 sm:mb-4">Kenapa harus di
                            Lestari Adv?</h2>
                        <p class="text-sm sm:text-base md:text-lg text-[#22245D] mb-4 sm:mb-6">
                            Lestari ADV dipercaya karena konsisten memberikan hasil cetak berkualitas, pelayanan responsif,
                            dan harga yang bersaing.
                        </p>
                        <div class="flex flex-wrap gap-4 items-center justify-center lg:justify-start">
                            <img src="{{ asset('images/kimia-farma.jpg') }}" alt="Customer"
                                style="width: 230px; height:150px;">
                            <img src="{{ asset('images/Bumiputera.svg') }}" alt="Customer" class="h-20 sm:h-20">
                            <img src="{{ asset('images/bagikopi.png') }}" alt="Customer"
                                style="width: 150px; height:150px;">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-4">
                        <div class="stat-card bg-[#D6D7FF]/50 rounded-3xl sm:rounded-[40px] p-4 sm:p-6 text-center">
                            <p class="text-2xl sm:text-3xl md:text-4xl font-bold text-[#B54D00] mb-1 sm:mb-2">23+</p>
                            <p class="text-xs sm:text-sm md:text-base font-medium text-[#22245D]">Tahun pengalaman dalam
                                percetakan</p>
                        </div>
                        <div class="stat-card bg-[#FFD5B6]/50 rounded-3xl sm:rounded-[40px] p-4 sm:p-6 text-center">
                            <p class="text-2xl sm:text-3xl md:text-4xl font-bold text-[#B54D00] mb-1 sm:mb-2">200+</p>
                            <p class="text-xs sm:text-sm md:text-base font-medium text-[#22245D]">Pesanan dicetak
                                berkualitas tinggi</p>
                        </div>
                        <div class="stat-card bg-[#FFE1E1]/50 rounded-3xl sm:rounded-[40px] p-4 sm:p-6 text-center">
                            <p class="text-2xl sm:text-3xl md:text-4xl font-bold text-[#B54D00] mb-1 sm:mb-2">98%</p>
                            <p class="text-xs sm:text-sm md:text-base font-medium text-[#22245D]">Pelanggan puas dengan
                                hasil cetakan</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="belanja" class="py-8 sm:py-12 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Header -->
                <div class="flex items-center justify-between mb-6 sm:mb-8 gap-4">
                    <h2 class="text-xl sm:text-2xl md:text-3xl font-bold text-[#22235D]">
                        Layanan yang kami tawarkan
                    </h2>

                    <!-- Navigation Buttons (Desktop) - Next to Title -->
                    <div class="hidden sm:flex items-center gap-2">
                        <button id="prevService"
                            class="w-10 h-10 rounded-full bg-white border-2 border-[#B54D00] text-[#B54D00] flex items-center justify-center hover:bg-[#B54D00] hover:text-white transition-all duration-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                                </path>
                            </svg>
                        </button>
                        <button id="nextService"
                            class="w-10 h-10 rounded-full bg-[#B54D00] text-white flex items-center justify-center hover:bg-[#8a3a00] transition-all duration-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Carousel Container -->
                <div class="relative">
                    <!-- Carousel Wrapper -->
                    <div class="overflow-hidden">
                        <div id="serviceCarousel" class="flex transition-transform duration-500 ease-out gap-4 sm:gap-6">
                            @forelse($products as $product)
                                @php
                                    $firstVariant = $product->variants->first();
                                    $firstImage = $firstVariant?->first_image;
                                    $priceRange = $product->price_range;
                                @endphp
                                <div
                                    class="flex-shrink-0 w-[calc(50%-0.5rem)] sm:w-[calc(33.333%-1rem)] lg:w-[calc(25%-1.125rem)]">
                                    <div
                                        class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300 h-full">
                                        <!-- Product Image -->
                                        <div class="aspect-square bg-gray-100 rounded-xl m-3 overflow-hidden">
                                            @if ($firstImage)
                                                <img src="{{ asset('storage/' . $firstImage) }}"
                                                    alt="{{ $product->nama_produk }}" class="w-full h-full object-cover">
                                            @else
                                                <div
                                                    class="w-full h-full flex items-center justify-center bg-gray-200 text-gray-400">
                                                    <svg class="w-12 h-12 sm:w-16 sm:h-16" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                        </path>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Product Info -->
                                        <div class="px-3 pb-4">
                                            <h3 class="text-[#22235D] font-semibold text-sm sm:text-base mb-1 truncate">
                                                {{ $product->nama_produk }}
                                            </h3>
                                            <p class="text-[#B54D00] font-semibold text-xs sm:text-sm mb-3">
                                                {{ $priceRange }}
                                            </p>

                                            <!-- Action Buttons -->
                                            <div class="flex items-center gap-2">
                                                <a href=""
                                                    class="flex-1 bg-gray-100 text-[#22245D] py-2 rounded-full text-xs sm:text-sm font-medium hover:bg-gray-200 transition-colors text-center">
                                                    Lihat Detail
                                                </a>
                                                <button
                                                    class="w-9 h-9 rounded-full bg-gray-100 flex items-center justify-center hover:bg-[#B54D00] hover:text-white transition-colors group">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="w-full text-center py-12">
                                    <p class="text-gray-500">Belum ada produk tersedia</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Dots Indicator -->
                    <div id="carouselDots" class="flex justify-center gap-2 mt-6">
                        <!-- Dots will be generated by JavaScript -->
                    </div>
                </div>
            </div>
        </section>

        <style>
            /* Custom styles for smooth carousel transition */
            #serviceCarousel {
                scroll-behavior: smooth;
            }

            /* Dots styling */
            #carouselDots button {
                width: 8px;
                height: 8px;
                border-radius: 50%;
                background-color: #D1D5DB;
                transition: all 0.3s ease;
            }

            #carouselDots button.active {
                background-color: #B54D00;
                width: 24px;
                border-radius: 4px;
            }
        </style>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const carousel = document.getElementById('serviceCarousel');
                const prevBtn = document.getElementById('prevService');
                const nextBtn = document.getElementById('nextService');
                const dotsContainer = document.getElementById('carouselDots');

                const items = carousel.querySelectorAll('.flex-shrink-0');
                const itemCount = items.length;

                // Determine items per view based on screen size
                function getItemsPerView() {
                    if (window.innerWidth >= 1024) return 4; // lg
                    if (window.innerWidth >= 640) return 3; // sm
                    return 2; // mobile
                }

                let currentIndex = 0;
                let itemsPerView = getItemsPerView();
                const totalPages = Math.ceil(itemCount / itemsPerView);

                // Create dots
                function createDots() {
                    dotsContainer.innerHTML = '';
                    for (let i = 0; i < totalPages; i++) {
                        const dot = document.createElement('button');
                        dot.classList.add(i === 0 ? 'active' : '');
                        dot.addEventListener('click', () => goToSlide(i));
                        dotsContainer.appendChild(dot);
                    }
                }

                // Update carousel position
                function updateCarousel() {
                    const itemWidth = items[0].offsetWidth;
                    const gap = parseFloat(getComputedStyle(carousel).gap);
                    const offset = currentIndex * itemsPerView * (itemWidth + gap);
                    carousel.style.transform = `translateX(-${offset}px)`;

                    // Update dots
                    const dots = dotsContainer.querySelectorAll('button');
                    dots.forEach((dot, index) => {
                        dot.classList.toggle('active', index === currentIndex);
                    });
                }

                // Go to specific slide
                function goToSlide(index) {
                    currentIndex = index;
                    updateCarousel();
                }

                // Next slide
                function nextSlide() {
                    currentIndex = (currentIndex + 1) % totalPages;
                    updateCarousel();
                }

                // Previous slide
                function prevSlide() {
                    currentIndex = (currentIndex - 1 + totalPages) % totalPages;
                    updateCarousel();
                }

                // Event listeners
                nextBtn.addEventListener('click', nextSlide);
                prevBtn.addEventListener('click', prevSlide);

                // Handle window resize
                window.addEventListener('resize', function() {
                    const newItemsPerView = getItemsPerView();
                    if (newItemsPerView !== itemsPerView) {
                        itemsPerView = newItemsPerView;
                        currentIndex = 0;
                        createDots();
                        updateCarousel();
                    }
                });

                // Initialize
                createDots();
                updateCarousel();
            });
        </script>

        <!-- Portfolio -->
        <section id="portfolio" class="py-8 sm:py-12 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8 items-center">
                    <div class="text-center lg:text-left">
                        <h2 class="text-xl sm:text-2xl md:text-3xl font-bold text-[#22235D] mb-3 sm:mb-4">Portfolio
                            Percetakan Kami</h2>
                        <p class="text-sm sm:text-base md:text-lg text-[#22245D] mb-4 sm:mb-6">
                            Ratusan proyek cetak telah kami selesaikan dengan hasil memuaskan, bukti nyata kepercayaan dan
                            kualitas yang kami jaga
                        </p>
                        <div class="flex gap-3 justify-center lg:justify-start">
                            <button id="prevPortfolio"
                                class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-gray-200 flex items-center justify-center hover:bg-[#B54D00] hover:text-white transition">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M15 19l-7-7 7-7"></path>
                                </svg>
                            </button>
                            <button id="nextPortfolio"
                                class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-[#B54D00] text-white flex items-center justify-center hover:bg-[#8a3a00] transition">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M9 5l7 7-7 7"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div
                        class="relative rounded-2xl sm:rounded-[26px] overflow-hidden h-[250px] sm:h-[300px] md:h-[320px]">
                        <img id="portfolioGif" src="{{ asset('images/vidio.gif') }}" alt="Video Preview"
                            class="w-full h-full object-cover absolute inset-0">
                        <video id="portfolioVideo" class="w-full h-full object-cover" preload="none" controls
                            style="display: none;">
                            <source src="{{ asset('images/1129.mp4') }}" type="video/mp4">
                        </video>
                        <button id="portfolioPlayBtn"
                            class="absolute inset-0 flex items-center justify-center bg-black/40 hover:bg-black/60 transition z-10">
                            <div
                                class="w-16 h-16 sm:w-20 sm:h-20 bg-black/70 rounded-full flex items-center justify-center group">
                                <svg class="w-8 h-8 sm:w-10 sm:h-10 text-white ml-1 group-hover:scale-110 transition"
                                    fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8 5v14l11-7z" />
                                </svg>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Video Section -->
        <section class="py-8 sm:py-12 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-xl sm:text-2xl md:text-3xl lg:text-4xl font-bold text-[#22235D] text-center mb-8">
                    Melihat Lebih Dekat Percetakan Lestari Adv
                </h2>
                <div class="relative rounded-2xl sm:rounded-[26px] overflow-hidden h-[250px] sm:h-[300px] md:h-[550px]">
                    <img id="previewGif" src="{{ asset('images/Animasi.gif') }}" alt="Video Preview"
                        class="w-full h-full object-cover absolute inset-0">
                    <video id="previewVideo" class="w-full h-full object-cover" preload="none" controls
                        style="display: none;">
                        <source src="{{ asset('images/Vidio.mp4') }}" type="video/mp4">
                    </video>
                    <button id="playBtn"
                        class="absolute hidden inset-0 flex items-center justify-center bg-black/40 hover:bg-black/60 transition z-10">
                        <div
                            class="w-16 h-16 sm:w-20 sm:h-20 bg-black/70 rounded-full flex items-center justify-center group">
                            <svg class="w-8 h-8 sm:w-10 sm:h-10 text-white ml-1 group-hover:scale-110 transition"
                                fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8 5v14l11-7z" />
                            </svg>
                        </div>
                    </button>
                </div>
            </div>
        </section>



        <script>
            // Video 1 - Preview Video
            const video = document.getElementById('previewVideo');
            const playBtn = document.getElementById('playBtn');
            const previewGif = document.getElementById('previewGif');

            playBtn.addEventListener('click', () => {
                playBtn.style.display = "none";
                previewGif.style.display = "none";
                video.style.display = "block";
                video.play();
            });

            video.addEventListener('ended', () => {
                playBtn.style.display = "flex";
                video.style.display = "none";
                previewGif.style.display = "block";
            });
            video.addEventListener('pause', () => {
                if (!video.ended) playBtn.style.display = "flex";
            });
            video.addEventListener('play', () => {
                playBtn.style.display = "none";
            });

            // Video 2 - Portfolio Video
            const portfolioVideo = document.getElementById('portfolioVideo');
            const portfolioPlayBtn = document.getElementById('portfolioPlayBtn');
            const portfolioGif = document.getElementById('portfolioGif');

            portfolioPlayBtn.addEventListener('click', () => {
                portfolioPlayBtn.style.display = "none";
                portfolioGif.style.display = "none";
                portfolioVideo.style.display = "block";
                portfolioVideo.play();
            });
            portfolioVideo.addEventListener('ended', () => {
                portfolioPlayBtn.style.display = "flex";
                portfolioVideo.style.display = "none";
                portfolioGif.style.display = "block";
            });
            portfolioVideo.addEventListener('pause', () => {
                if (!portfolioVideo.ended) portfolioPlayBtn.style.display = "flex";
            });
            portfolioVideo.addEventListener('play', () => {
                portfolioPlayBtn.style.display = "none";
            });

            // Smooth scrolling
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // Carousel functionality
            const carousel = document.getElementById('serviceCarousel');
            const items = carousel.querySelectorAll('.carousel-item');
            const totalItems = items.length;
            const dotsContainer = document.getElementById('carouselDots');
            let currentIndex = 0;
            let itemsPerView = 4;

            // Calculate items per view based on screen size
            function updateItemsPerView() {
                const width = window.innerWidth;
                if (width < 640) {
                    itemsPerView = 1;
                } else if (width < 1024) {
                    itemsPerView = 2;
                } else if (width < 1280) {
                    itemsPerView = 3;
                } else {
                    itemsPerView = 4;
                }
                updateCarousel();
                createDots();
            } // Create dots for mobile function createDots() { if
            (window.innerWidth >= 641) {
                dotsContainer.innerHTML = '';
                return;
            }

            const numDots = Math.ceil(totalItems / itemsPerView);
            dotsContainer.innerHTML = '';

            for (let i = 0; i < numDots; i++) {
                const dot = document.createElement('div');
                dot.className = 'carousel-dot';
                if (i === 0) dot.classList.add('active');
                dot.addEventListener('click', () => goToSlide(i * itemsPerView));
                dotsContainer.appendChild(dot);
            }
            }

            // Update carousel position
            function updateCarousel() {
                const itemWidth = items[0].offsetWidth;
                const gap = 16;
                const offset = -(currentIndex * (itemWidth + gap));
                carousel.style.transform = `translateX(${offset}px)`;

                // Update dots
                if (window.innerWidth < 641) {
                    const dots = dotsContainer.querySelectorAll('.carousel-dot');
                    dots.forEach((dot,
                        index) => {
                        dot.classList.toggle('active', index === Math.floor(currentIndex / itemsPerView));
                    });
                }
            }

            // Go to specific slide
            function goToSlide(index) {
                currentIndex = Math.max(0, Math.min(index, totalItems - itemsPerView));
                updateCarousel();
            }

            // Next button
            document.getElementById('nextService').addEventListener('click', () => {
                currentIndex = Math.min(currentIndex + itemsPerView, totalItems - itemsPerView);
                updateCarousel();
            });

            // Previous button
            document.getElementById('prevService').addEventListener('click', () => {
                currentIndex = Math.max(currentIndex - itemsPerView, 0);
                updateCarousel();
            });

            // Touch swipe for mobile
            let touchStartX = 0;
            let touchEndX = 0;

            carousel.addEventListener('touchstart', (e) => {
                touchStartX = e.changedTouches[0].screenX;
            });

            carousel.addEventListener('touchend', (e) => {
                touchEndX = e.changedTouches[0].screenX;
                handleSwipe();
            });

            function handleSwipe() {
                const swipeThreshold = 50;
                const diff = touchStartX - touchEndX;

                if (Math.abs(diff) > swipeThreshold) {
                    if (diff > 0) {
                        // Swipe left - next
                        currentIndex = Math.min(currentIndex + 1, totalItems - itemsPerView);
                    } else {
                        // Swipe right - previous
                        currentIndex = Math.max(currentIndex - 1, 0);
                    }
                    updateCarousel();
                }
            }

            // Initialize on load
            updateItemsPerView();

            // Update on resize
            let resizeTimer;
            window.addEventListener('resize', () => {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(() => {
                    updateItemsPerView();
                }, 250);
            });

            // Portfolio buttons (placeholder)
            document.getElementById('nextPortfolio').addEventListener('click', () => {
                console.log('Next portfolio');
            });

            document.getElementById('prevPortfolio').addEventListener('click', () => {
                console.log('Previous portfolio');
            });
        </script>
    </body>
@endsection

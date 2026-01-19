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

        .banner-content {
            position: absolute;
            bottom: 0px;
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
        <section class="pt-20 pb-8 bg-white sm:pt-24 sm:pb-12">
            <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="banner">
                    <div class="banner-content">
                        <a href="{{ route('produk.index') }}" class="cta-btn">Cetak designmu sekarang!</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Why Choose Us -->
        <section id="antrean" class="py-8 bg-white sm:py-12">
            <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="grid items-center grid-cols-1 gap-6 lg:grid-cols-2 lg:gap-8">
                    <div class="text-center lg:text-left">
                        <h2 class="text-xl sm:text-2xl md:text-3xl font-bold text-[#22235D] mb-3 sm:mb-4">Kenapa harus di
                            Lestari Adv?</h2>
                        <p class="text-sm sm:text-base md:text-lg text-[#22245D] mb-4 sm:mb-6">
                            Lestari ADV dipercaya karena konsisten memberikan hasil cetak berkualitas, pelayanan responsif,
                            dan harga yang bersaing.
                        </p>
                        <div class="flex flex-wrap items-center justify-center gap-4 lg:justify-start">
                            <img src="{{ asset('images/kimia-farma.jpg') }}" alt="Customer"
                                style="width: 230px; height:150px;">
                            <img src="{{ asset('images/Bumiputera.svg') }}" alt="Customer" class="h-20 sm:h-20">
                            <img src="{{ asset('images/bagikopi.png') }}" alt="Customer"
                                style="width: 150px; height:150px;">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3 sm:gap-4">
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

        <!-- Services Section -->
        <section id="belanja" class="py-8 sm:py-12 bg-gray-50">
            <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- Header -->
                <div class="flex items-center justify-between gap-4 mb-6 sm:mb-8">
                    <h2 class="text-xl sm:text-2xl md:text-3xl font-bold text-[#22235D]">
                        Layanan yang kami tawarkan
                    </h2>

                    <!-- Navigation Buttons (Desktop) -->
                    <div class="items-center hidden gap-2 sm:flex">
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
                    <div class="overflow-hidden">
                        <div id="serviceCarousel" class="flex gap-4 transition-transform duration-500 ease-out sm:gap-6">
                            @forelse($products as $product)
                                @php
                                    $firstVariant = $product->variants->first();
                                    $firstImage = $firstVariant?->first_image;
                                    $priceRange = $product->price_range;
                                @endphp
                                <div
                                    class="flex-shrink-0 w-[calc(50%-0.5rem)] sm:w-[calc(33.333%-1rem)] lg:w-[calc(25%-1.125rem)]">
                                    <div
                                        class="h-full overflow-hidden transition-shadow duration-300 bg-white shadow-sm rounded-2xl hover:shadow-md">
                                        <!-- Product Image -->
                                        <div class="m-3 overflow-hidden bg-gray-100 aspect-square rounded-xl">
                                            @if ($firstImage)
                                                <img src="{{ asset('storage/' . $firstImage) }}"
                                                    alt="{{ $product->nama_produk }}" class="object-cover w-full h-full">
                                            @else
                                                <div
                                                    class="flex items-center justify-center w-full h-full text-gray-400 bg-gray-200">
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
                                                <a href="{{ route('product.show', ['slug' => $product->slug]) }}"
                                                    class="flex-1 bg-gray-100 text-[#22245D] py-2 rounded-full text-xs sm:text-sm font-medium hover:bg-gray-200 transition-colors text-center">
                                                    Lihat Detail
                                                </a>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="w-full py-12 text-center">
                                    <p class="text-gray-500">Belum ada produk tersedia</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Dots Indicator -->
                    <div id="carouselDots" class="flex justify-center gap-2 mt-6"></div>
                </div>
            </div>
        </section>

        <style>
            #serviceCarousel {
                scroll-behavior: smooth;
            }

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

        <!-- Portfolio Section -->
        <section id="portfolio" class="py-8 bg-white sm:py-12">
            <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="grid items-center grid-cols-1 gap-8 lg:grid-cols-2 lg:gap-12">
                    <!-- Text Content -->
                    <div class="text-center lg:text-left">
                        <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-[#22235D] mb-4">
                            Portfolio<br>Percetakan Kami
                        </h2>
                        <p class="text-base sm:text-lg text-[#22245D] mb-6 max-w-md mx-auto lg:mx-0">
                            Ratusan proyek cetak telah kami selesaikan dengan hasil memuaskan
                        </p>

                        <!-- Navigation Buttons -->
                        <div class="flex justify-center gap-4 lg:justify-start">
                            <button id="prevPortfolio"
                                class="w-12 h-12 rounded-full border-2 border-[#B54D00] text-[#B54D00] flex items-center justify-center hover:bg-[#B54D00] hover:text-white transition-all">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M15 19l-7-7 7-7"></path>
                                </svg>
                            </button>
                            <button id="nextPortfolio"
                                class="w-12 h-12 rounded-full bg-[#B54D00] text-white flex items-center justify-center hover:bg-[#8a3a00] transition-all">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M9 5l7 7-7 7"></path>
                                </svg>
                            </button>
                        </div>

                        <!-- Dots Navigation -->
                        <div class="flex justify-center gap-2 mt-6 lg:justify-start" id="portfolioDots"></div>
                    </div>

                    <!-- Images/Videos Grid -->
                    <div class="relative overflow-hidden">
                        <div id="portfolioCarousel" class="flex gap-4 transition-transform duration-500 ease-out">
                            @forelse($portfolioSlides as $slideIndex => $slide)
                                <!-- Slide {{ $slideIndex + 1 }} -->
                                <div class="flex-shrink-0 w-full">
                                    <div class="grid grid-cols-2 gap-4">
                                        @foreach ($slide as $itemIndex => $portfolio)
                                            @if ($portfolio->isImage())
                                                <!-- Image -->
                                                <div class="overflow-hidden rounded-3xl h-[280px] sm:h-[320px]">
                                                    <img src="{{ asset('storage/' . $portfolio->file_path) }}"
                                                        alt="{{ $portfolio->title }}" class="object-cover w-full h-full">
                                                </div>
                                            @else
                                                <!-- Video -->
                                                <div class="relative overflow-hidden rounded-3xl h-[280px] sm:h-[320px]">
                                                    <video class="object-cover w-full h-full" muted loop
                                                        data-video="{{ $slideIndex }}-{{ $itemIndex }}">
                                                        <source src="{{ asset('storage/' . $portfolio->file_path) }}"
                                                            type="video/mp4">
                                                    </video>
                                                    <button
                                                        class="absolute inset-0 z-10 flex items-center justify-center transition video-play-btn bg-black/40 hover:bg-black/60"
                                                        data-target="{{ $slideIndex }}-{{ $itemIndex }}">
                                                        <div
                                                            class="flex items-center justify-center w-16 h-16 rounded-full bg-black/70">
                                                            <svg class="w-8 h-8 ml-1 text-white play-icon"
                                                                fill="currentColor" viewBox="0 0 24 24">
                                                                <path d="M8 5v14l11-7z" />
                                                            </svg>
                                                            <svg class="hidden w-8 h-8 text-white pause-icon"
                                                                fill="currentColor" viewBox="0 0 24 24">
                                                                <path d="M6 4h4v16H6V4zm8 0h4v16h-4V4z" />
                                                            </svg>
                                                        </div>
                                                    </button>

                                                    @if ($portfolio->thumbnail_path)
                                                        <div class="absolute inset-0 video-thumbnail">
                                                            <img src="{{ asset('storage/' . $portfolio->thumbnail_path) }}"
                                                                alt="{{ $portfolio->title }}"
                                                                class="object-cover w-full h-full">
                                                        </div>
                                                    @endif
                                                </div>
                                            @endif
                                        @endforeach

                                        @if ($slide->count() == 1)
                                            <!-- Fill empty space if only 1 item in slide -->
                                            <div
                                                class="overflow-hidden rounded-3xl h-[280px] sm:h-[320px] bg-gray-100 flex items-center justify-center">
                                                <p class="text-gray-400">No content</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <!-- Empty State -->
                                <div class="flex-shrink-0 w-full">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div
                                            class="overflow-hidden rounded-3xl h-[280px] sm:h-[320px] bg-gray-100 flex items-center justify-center">
                                            <p class="text-gray-400">No portfolio available</p>
                                        </div>
                                        <div
                                            class="overflow-hidden rounded-3xl h-[280px] sm:h-[320px] bg-gray-100 flex items-center justify-center">
                                            <p class="text-gray-400">No portfolio available</p>
                                        </div>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Animation Section -->
        <section class="py-8 sm:py-12 bg-gray-50">
            <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <h2 class="text-xl sm:text-2xl md:text-3xl lg:text-4xl font-bold text-[#22235D] text-center mb-8">
                    Melihat Lebih Dekat Percetakan Lestari Adv
                </h2>
                <div class="relative rounded-2xl sm:rounded-[26px] overflow-hidden h-[250px] sm:h-[300px] md:h-[550px]">
                    <img src="{{ asset('images/Animasi.gif') }}" alt="Lestari Adv Animation"
                        class="object-cover w-full h-full">
                </div>
            </div>
        </section>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // ==================== VIDEO SECTION ====================
                const video = document.getElementById('previewVideo');
                const playBtn = document.getElementById('playBtn');
                const previewGif = document.getElementById('previewGif');

                if (playBtn && video && previewGif) {
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
                }

                // ==================== SERVICE CAROUSEL ====================
                const carousel = document.getElementById('serviceCarousel');
                const prevBtn = document.getElementById('prevService');
                const nextBtn = document.getElementById('nextService');
                const dotsContainer = document.getElementById('carouselDots');

                if (carousel && prevBtn && nextBtn && dotsContainer) {
                    const items = carousel.querySelectorAll('.flex-shrink-0');
                    const itemCount = items.length;

                    function getItemsPerView() {
                        if (window.innerWidth >= 1024) return 4;
                        if (window.innerWidth >= 640) return 3;
                        return 2;
                    }

                    let currentIndex = 0;
                    let itemsPerView = getItemsPerView();
                    const totalPages = Math.ceil(itemCount / itemsPerView);

                    function createDots() {
                        dotsContainer.innerHTML = '';
                        for (let i = 0; i < totalPages; i++) {
                            const dot = document.createElement('button');
                            if (i === 0) {
                                dot.classList.add('active');
                            }
                            dot.addEventListener('click', () => goToSlide(i));
                            dotsContainer.appendChild(dot);
                        }
                    }

                    function updateCarousel() {
                        const itemWidth = items[0].offsetWidth;
                        const gap = parseFloat(getComputedStyle(carousel).gap);
                        const offset = currentIndex * itemsPerView * (itemWidth + gap);
                        carousel.style.transform = `translateX(-${offset}px)`;

                        const dots = dotsContainer.querySelectorAll('button');
                        dots.forEach((dot, index) => {
                            dot.classList.toggle('active', index === currentIndex);
                        });
                    }

                    function goToSlide(index) {
                        currentIndex = index;
                        updateCarousel();
                    }

                    function nextSlide() {
                        currentIndex = (currentIndex + 1) % totalPages;
                        updateCarousel();
                    }

                    function prevSlide() {
                        currentIndex = (currentIndex - 1 + totalPages) % totalPages;
                        updateCarousel();
                    }

                    nextBtn.addEventListener('click', nextSlide);
                    prevBtn.addEventListener('click', prevSlide);

                    window.addEventListener('resize', function() {
                        const newItemsPerView = getItemsPerView();
                        if (newItemsPerView !== itemsPerView) {
                            itemsPerView = newItemsPerView;
                            currentIndex = 0;
                            createDots();
                            updateCarousel();
                        }
                    });

                    createDots();
                    updateCarousel();
                }

                // ==================== PORTFOLIO CAROUSEL ====================
                const portfolioContainer = document.getElementById('portfolioCarousel');
                const portfolioDotsContainer = document.getElementById('portfolioDots');
                const nextPortfolioBtn = document.getElementById('nextPortfolio');
                const prevPortfolioBtn = document.getElementById('prevPortfolio');

                if (portfolioContainer && portfolioDotsContainer) {
                    let portfolioCurrentIndex = 0;
                    const portfolioTotalSlides = portfolioContainer.children.length;

                    function createPortfolioDots() {
                        portfolioDotsContainer.innerHTML = '';
                        for (let i = 0; i < portfolioTotalSlides; i++) {
                            const dot = document.createElement('div');
                            dot.className = 'h-2 rounded-full cursor-pointer transition-all';
                            dot.style.width = i === 0 ? '24px' : '8px';
                            dot.style.backgroundColor = i === 0 ? '#B54D00' : '#D1D5DB';
                            dot.addEventListener('click', () => goToPortfolioSlide(i));
                            portfolioDotsContainer.appendChild(dot);
                        }
                    }

                    function updatePortfolioCarousel() {
                        portfolioContainer.style.transform = `translateX(-${portfolioCurrentIndex * 100}%)`;

                        const dots = portfolioDotsContainer.querySelectorAll('div');
                        dots.forEach((dot, index) => {
                            const isActive = index === portfolioCurrentIndex;
                            dot.style.width = isActive ? '24px' : '8px';
                            dot.style.backgroundColor = isActive ? '#B54D00' : '#D1D5DB';
                        });

                        // Pause semua video yang tidak terlihat saat slide berubah
                        pauseHiddenVideos();
                    }

                    function goToPortfolioSlide(index) {
                        portfolioCurrentIndex = index;
                        updatePortfolioCarousel();
                    }

                    if (nextPortfolioBtn) {
                        nextPortfolioBtn.addEventListener('click', () => {
                            portfolioCurrentIndex = (portfolioCurrentIndex + 1) % portfolioTotalSlides;
                            updatePortfolioCarousel();
                        });
                    }

                    if (prevPortfolioBtn) {
                        prevPortfolioBtn.addEventListener('click', () => {
                            portfolioCurrentIndex = (portfolioCurrentIndex - 1 + portfolioTotalSlides) %
                                portfolioTotalSlides;
                            updatePortfolioCarousel();
                        });
                    }

                    // Touch swipe untuk mobile
                    let portfolioTouchStartX = 0;
                    portfolioContainer.addEventListener('touchstart', (e) => {
                        portfolioTouchStartX = e.changedTouches[0].screenX;
                    });

                    portfolioContainer.addEventListener('touchend', (e) => {
                        const portfolioTouchEndX = e.changedTouches[0].screenX;
                        const diff = portfolioTouchStartX - portfolioTouchEndX;

                        if (Math.abs(diff) > 50) {
                            if (diff > 0) {
                                portfolioCurrentIndex = (portfolioCurrentIndex + 1) % portfolioTotalSlides;
                            } else {
                                portfolioCurrentIndex = (portfolioCurrentIndex - 1 + portfolioTotalSlides) %
                                    portfolioTotalSlides;
                            }
                            updatePortfolioCarousel();
                        }
                    });

                    createPortfolioDots();
                    updatePortfolioCarousel();
                }

                // ==================== PORTFOLIO VIDEO CONTROLS (DIPERBAIKI) ====================
                const videoPlayBtns = document.querySelectorAll('.video-play-btn'); // Ganti dari portfolio-play-btn

                videoPlayBtns.forEach(btn => {
                    const targetId = btn.getAttribute('data-target');
                    const videoElement = document.querySelector(`video[data-video="${targetId}"]`);
                    const playIcon = btn.querySelector('.play-icon');
                    const pauseIcon = btn.querySelector('.pause-icon');

                    console.log('Setup video control:', targetId, videoElement ? 'Video found' :
                        'Video NOT found');

                    if (videoElement && videoElement.tagName === 'VIDEO') {
                        btn.addEventListener('click', (e) => {
                            e.preventDefault();
                            e.stopPropagation();

                            console.log('Video button clicked, paused:', videoElement.paused);

                            if (videoElement.paused) {
                                // Pause semua video lain terlebih dahulu
                                document.querySelectorAll('video[data-video]').forEach(v => {
                                    if (v !== videoElement && !v.paused) {
                                        v.pause();
                                        const otherId = v.getAttribute('data-video');
                                        const otherBtn = document.querySelector(
                                            `.video-play-btn[data-target="${otherId}"]`);
                                        if (otherBtn) {
                                            const otherPlayIcon = otherBtn.querySelector(
                                                '.play-icon');
                                            const otherPauseIcon = otherBtn.querySelector(
                                                '.pause-icon');
                                            if (otherPlayIcon && otherPauseIcon) {
                                                otherPlayIcon.classList.remove('hidden');
                                                otherPauseIcon.classList.add('hidden');
                                            }
                                            otherBtn.classList.remove('bg-black/60');
                                            otherBtn.classList.add('bg-black/40');
                                        }
                                    }
                                });

                                // Play video ini
                                videoElement.play()
                                    .then(() => {
                                        console.log('Video playing successfully');
                                        playIcon.classList.add('hidden');
                                        pauseIcon.classList.remove('hidden');
                                        btn.classList.remove('bg-black/40');
                                        btn.classList.add('bg-black/60');
                                    })
                                    .catch(err => {
                                        console.error('Error playing video:', err);
                                    });
                            } else {
                                // Pause video ini
                                videoElement.pause();
                                console.log('Video paused');
                                playIcon.classList.remove('hidden');
                                pauseIcon.classList.add('hidden');
                                btn.classList.remove('bg-black/60');
                                btn.classList.add('bg-black/40');
                            }
                        });

                        // Reset button ketika video selesai
                        videoElement.addEventListener('ended', () => {
                            console.log('Video ended');
                            playIcon.classList.remove('hidden');
                            pauseIcon.classList.add('hidden');
                            btn.classList.remove('bg-black/60');
                            btn.classList.add('bg-black/40');
                            videoElement.currentTime = 0;
                        });
                    } else {
                        console.warn('Video element tidak ditemukan untuk data-target:', targetId);
                    }
                });

                // Fungsi untuk pause video yang tidak terlihat
                function pauseHiddenVideos() {
                    const portfolioContainer = document.getElementById('portfolioCarousel');
                    if (!portfolioContainer) return;

                    document.querySelectorAll('video[data-video]').forEach(video => {
                        const videoId = video.getAttribute('data-video');
                        const btn = document.querySelector(`.video-play-btn[data-target="${videoId}"]`);
                        const rect = video.getBoundingClientRect();
                        const containerRect = portfolioContainer.getBoundingClientRect();

                        // Cek apakah video masih terlihat di viewport carousel
                        const isVisible = rect.left >= containerRect.left && rect.right <= containerRect.right;

                        if (!isVisible && !video.paused) {
                            video.pause();
                            if (btn) {
                                const playIcon = btn.querySelector('.play-icon');
                                const pauseIcon = btn.querySelector('.pause-icon');
                                if (playIcon && pauseIcon) {
                                    playIcon.classList.remove('hidden');
                                    pauseIcon.classList.add('hidden');
                                }
                                btn.classList.remove('bg-black/60');
                                btn.classList.add('bg-black/40');
                            }
                        }
                    });
                }

                // ==================== SMOOTH SCROLLING ====================
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
            });
        </script>
    </body>
@endsection

@extends('layouts.app')

@section('content')
    <div class="px-4 py-8 mx-auto mt-20 max-w-7xl sm:px-6 lg:px-8">
        <div class="flex flex-col gap-8 lg:flex-row">

            {{-- SIDEBAR --}}
            <aside class="flex-shrink-0 w-full lg:w-64">
                <div class="p-6 bg-white rounded-lg shadow-sm">

                    {{-- Filter Produk --}}
                    <div class="mb-8">
                        <h3 class="mb-4 text-lg font-bold text-gray-900">
                            Filter Produk
                        </h3>
                        <ul class="space-y-2.5">
                            <li>
                                <a href="{{ route('produk.index') }}"
                                    class="text-sm font-medium transition {{ !request('category') ? 'text-blue-600' : 'text-gray-900 hover:text-blue-600' }}">
                                    Semua Produk
                                </a>
                            </li>
                            @foreach ($categories as $category)
                                <li>
                                    <a href="{{ route('produk.index', ['category' => $category->id] + request()->except('category')) }}"
                                        class="text-sm transition {{ request('category') == $category->id ? 'text-blue-600 font-medium' : 'text-gray-600 hover:text-blue-600' }}">
                                        {{ $category->nama_kategori }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    {{-- Active Filters --}}
                    @if (request('category') || request('search'))
                        <div class="pb-6 mb-6 border-b border-gray-200">
                            <div class="flex items-center justify-between mb-3">
                                <h4 class="text-sm font-semibold text-gray-900">Filter Aktif</h4>
                                <a href="{{ route('produk.index') }}" class="text-xs text-blue-600 hover:text-blue-700">
                                    Reset Semua
                                </a>
                            </div>
                            <div class="flex flex-wrap gap-2">
                                @if (request('search'))
                                    <span
                                        class="inline-flex items-center gap-1 px-3 py-1 text-xs font-medium text-gray-700 bg-gray-100 rounded-full">
                                        Search: "{{ request('search') }}"
                                        <a href="{{ route('produk.index', request()->except('search')) }}"
                                            class="text-gray-500 hover:text-gray-700">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </a>
                                    </span>
                                @endif
                                @if (request('category'))
                                    @php
                                        $selectedCat = $categories->firstWhere('id', request('category'));
                                    @endphp
                                    @if ($selectedCat)
                                        <span
                                            class="inline-flex items-center gap-1 px-3 py-1 text-xs font-medium text-blue-700 bg-blue-100 rounded-full">
                                            {{ $selectedCat->nama_kategori }}
                                            <a href="{{ route('produk.index', request()->except('category')) }}"
                                                class="text-blue-500 hover:text-blue-700">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </a>
                                        </span>
                                    @endif
                                @endif
                            </div>
                        </div>
                    @endif

                    {{-- Quick Links --}}
                    <div class="pt-6 space-y-3 border-t border-gray-200">
                        <a href="{{ route('antrean') }}"
                            class="block text-sm font-semibold text-gray-900 transition hover:text-blue-600">
                            Cek Antrean
                        </a>
                        <a href="{{ route('home') }}#portfolio"
                            class="block text-sm font-semibold text-gray-900 transition hover:text-blue-600">
                            Portfolio
                        </a>
                        <a href="{{ url('#kontak') }}"
                            class="block text-sm font-semibold text-gray-900 transition hover:text-blue-600">
                            Kontak
                        </a>
                    </div>

                </div>
            </aside>

            {{-- PRODUCT GRID --}}
            <main class="flex-1">
                {{-- Result Info --}}
                @if (request('search') || request('category'))
                    <div class="mb-6">
                        <h2 class="text-lg font-semibold text-gray-900">
                            @if (request('search') && request('category'))
                                Hasil pencarian "{{ request('search') }}" dalam kategori
                                {{ $categories->firstWhere('id', request('category'))->nama_kategori ?? '' }}
                            @elseif(request('search'))
                                Hasil pencarian "{{ request('search') }}"
                            @else
                                {{ $categories->firstWhere('id', request('category'))->nama_kategori ?? 'Kategori' }}
                            @endif
                        </h2>
                        <p class="mt-1 text-sm text-gray-600">
                            Ditemukan {{ $products->count() }} produk
                        </p>
                    </div>
                @endif

                <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4 sm:gap-6">
                    @foreach ($products as $product)
                        @php
                            $variant = $product->variants->first();
                            $image = $variant?->first_image;
                        @endphp

                        <div class="overflow-hidden transition-shadow bg-white shadow-sm rounded-2xl hover:shadow-md">

                            {{-- Product Image --}}
                            <div class="relative w-full pt-[100%] bg-gray-100">
                                @if ($image)
                                    <img src="{{ asset('storage/' . $image) }}" alt="{{ $product->nama_produk }}"
                                        class="absolute inset-0 object-cover w-full h-full">
                                @else
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            {{-- Product Info --}}
                            <div class="p-4">
                                <h3 class="mb-1 text-sm font-semibold text-gray-900 line-clamp-2">
                                    {{ $product->nama_produk }}
                                </h3>
                                <p class="mb-3 text-xs text-gray-600">
                                    {{ $product->price_range }}
                                </p>

                                <a href="{{ route('product.show', ['slug' => $product->slug]) }}"
                                    class="block w-full py-2 text-xs font-medium text-center text-gray-900 transition-colors duration-200 bg-white border border-gray-900 rounded-full hover:bg-gray-900 hover:text-white">
                                    Lihat Detail
                                </a>
                            </div>

                        </div>
                    @endforeach
                </div>

                {{-- Empty State --}}
                @if ($products->isEmpty())
                    <div class="py-16 text-center">
                        <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">
                            Tidak ada produk ditemukan
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">
                            @if (request('search') || request('category'))
                                Coba ubah filter atau kata kunci pencarian Anda.
                            @else
                                Belum ada produk yang tersedia saat ini.
                            @endif
                        </p>
                        @if (request('search') || request('category'))
                            <a href="{{ route('produk.index') }}"
                                class="inline-block px-4 py-2 mt-4 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                                Lihat Semua Produk
                            </a>
                        @endif
                    </div>
                @endif
            </main>

        </div>
    </div>
@endsection

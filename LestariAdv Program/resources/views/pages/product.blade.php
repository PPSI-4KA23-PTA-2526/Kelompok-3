@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 mt-20">
        <div class="flex flex-col lg:flex-row gap-8">

            {{-- SIDEBAR --}}
            <aside class="w-full lg:w-64 flex-shrink-0">
                <div class="bg-white rounded-lg p-6 shadow-sm">

                    {{-- Filter Produk --}}
                    <div class="mb-8">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">
                            Filter Produk
                        </h3>
                        <ul class="space-y-2.5">
                            <li>
                                <a href="#" class="text-sm font-medium text-gray-900 hover:text-blue-600 transition">
                                    Semua Produk
                                </a>
                            </li>
                            @foreach ($categories as $category)
                                <li>
                                    <a href="#" class="text-sm text-gray-600 hover:text-blue-600 transition">
                                        {{ $category->nama_kategori }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    {{-- Quick Links --}}
                    <div class="space-y-3 pt-6 border-t border-gray-200">
                        <a href="#" class="block text-sm font-semibold text-gray-900 hover:text-blue-600 transition">
                            Cek Antrean
                        </a>
                        <a href="#" class="block text-sm font-semibold text-gray-900 hover:text-blue-600 transition">
                            Portfolio
                        </a>
                        <a href="#" class="block text-sm font-semibold text-gray-900 hover:text-blue-600 transition">
                            Kontak
                        </a>
                    </div>

                </div>
            </aside>

            {{-- PRODUCT GRID --}}
            <main class="flex-1">
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
                    @foreach ($products as $product)
                        @php
                            $variant = $product->variants->first();
                            $image = $variant?->first_image;
                        @endphp

                        <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-shadow">

                            {{-- Product Image --}}
                            <div class="relative w-full pt-[100%] bg-gray-100">
                                @if ($image)
                                    <img src="{{ asset('storage/' . $image) }}" alt="{{ $product->nama_produk }}"
                                        class="absolute inset-0 w-full h-full object-cover">
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
                                <h3 class="text-sm font-semibold text-gray-900 mb-1 line-clamp-2">
                                    {{ $product->nama_produk }}
                                </h3>
                                <p class="text-xs text-gray-600 mb-3">
                                    {{ $product->price_range }}
                                </p>

                                <a href="{{ route('product.show', ['slug' => $product->slug]) }}"
                                    class="block w-full text-center text-xs font-medium
                                          text-gray-900 bg-white border border-gray-900
                                          rounded-full py-2
                                          hover:bg-gray-900 hover:text-white
                                          transition-colors duration-200">
                                    Lihat Detail
                                </a>
                            </div>

                        </div>
                    @endforeach
                </div>

                {{-- Empty State --}}
                @if ($products->isEmpty())
                    <div class="text-center py-16">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">
                            Tidak ada produk
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Belum ada produk yang tersedia saat ini.
                        </p>
                    </div>
                @endif
            </main>

        </div>
    </div>
@endsection

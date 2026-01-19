@extends('layouts.app')
@section('content')
    <div class="min-h-screen py-8 bg-gray-50">
        <div class="max-w-6xl px-4 mx-auto sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="mb-8 text-center">
                <h1 class="mb-6 text-3xl font-bold text-gray-900">Antrean Percetakan</h1>

                {{-- Search Box --}}
                <form method="GET" action="{{ route('antrean') }}" class="relative max-w-xl mx-auto">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Masukkan Nomor Antrean Anda"
                        class="w-full px-6 py-3 pr-12 text-sm text-gray-700 placeholder-gray-400 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <button type="submit" class="absolute transform -translate-y-1/2 right-4 top-1/2">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                </form>
            </div>

            {{-- Success Message --}}
            @if (session('success'))
                <div class="relative px-4 py-3 mb-6 text-green-700 bg-green-100 border border-green-400 rounded"
                    role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            {{-- Table Container --}}
            <div class="overflow-hidden bg-white rounded-lg shadow-sm">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        {{-- Table Header --}}
                        <thead>
                            <tr class="text-white bg-orange-500">
                                <th class="px-6 py-3 text-sm font-semibold text-left">ID Pesanan</th>
                                <th class="px-6 py-3 text-sm font-semibold text-left">Nama Pemesan</th>
                                <th class="px-6 py-3 text-sm font-semibold text-left">Barang Pesanan</th>
                                <th class="px-6 py-3 text-sm font-semibold text-left">Tanggal Pembelian</th>
                                <th class="px-6 py-3 text-sm font-semibold text-center">Status Pesanan</th>
                            </tr>
                        </thead>

                        {{-- Table Body --}}
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($orders as $order)
                                <tr class="transition-colors hover:bg-gray-50">
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $order->kode_order }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $order->nama_pemesan }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        {{ $order->nama_produk }}
                                        @if ($order->nama_variasi)
                                            <span class="text-gray-500">({{ $order->nama_variasi }})</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        {{ $order->paid_at ? $order->paid_at->format('d/m/Y H:i') : $order->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @php
                                            $statusColors = [
                                                'pending' => 'bg-gray-400',
                                                'menunggu' => 'bg-yellow-400',
                                                'diproses' => 'bg-blue-400',
                                                'selesai' => 'bg-green-400',
                                                'dibatalkan' => 'bg-red-400',
                                            ];
                                            $statusLabels = [
                                                'pending' => 'Pending',
                                                'menunggu' => 'Menunggu',
                                                'diproses' => 'Diproses',
                                                'selesai' => 'Selesai',
                                                'dibatalkan' => 'Dibatalkan',
                                            ];
                                            $colorClass = $statusColors[$order->status] ?? 'bg-gray-400';
                                            $statusLabel = $statusLabels[$order->status] ?? ucfirst($order->status);
                                        @endphp
                                        <span
                                            class="inline-flex items-center px-6 py-1.5 rounded-full text-xs font-medium {{ $colorClass }} text-gray-900">
                                            {{ $statusLabel }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                        @if (request('search'))
                                            Tidak ada pesanan ditemukan dengan kata kunci "{{ request('search') }}"
                                        @else
                                            Tidak ada pesanan dalam antrean saat ini
                                        @endif
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Pagination --}}
            @if ($orders->hasPages())
                <div class="flex items-center justify-between mt-6">
                    <div class="text-sm text-gray-700">
                        Menampilkan <span class="font-medium">{{ $orders->firstItem() }}</span>
                        sampai <span class="font-medium">{{ $orders->lastItem() }}</span>
                        dari <span class="font-medium">{{ $orders->total() }}</span> hasil
                    </div>
                    <div class="flex gap-2">
                        @if ($orders->onFirstPage())
                            <button
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg disabled:opacity-50 disabled:cursor-not-allowed"
                                disabled>
                                Sebelumnya
                            </button>
                        @else
                            <a href="{{ $orders->previousPageUrl() }}"
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                                Sebelumnya
                            </a>
                        @endif

                        @foreach ($orders->getUrlRange(1, $orders->lastPage()) as $page => $url)
                            @if ($page == $orders->currentPage())
                                <button
                                    class="px-4 py-2 text-sm font-medium text-white bg-orange-500 border border-orange-500 rounded-lg">
                                    {{ $page }}
                                </button>
                            @else
                                <a href="{{ $url }}"
                                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach

                        @if ($orders->hasMorePages())
                            <a href="{{ $orders->nextPageUrl() }}"
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                                Selanjutnya
                            </a>
                        @else
                            <button
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg disabled:opacity-50 disabled:cursor-not-allowed"
                                disabled>
                                Selanjutnya
                            </button>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

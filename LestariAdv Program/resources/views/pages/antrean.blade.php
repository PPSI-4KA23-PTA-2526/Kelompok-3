@extends('layouts.app')
@section('content')
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-6">Antrean Percetakan</h1>

                {{-- Search Box --}}
                <div class="max-w-xl mx-auto relative">
                    <input type="text" placeholder="Masukkan Nomor Antrean Anda"
                        class="w-full px-6 py-3 pr-12 border border-gray-300 rounded-full
                           focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                           text-sm text-gray-700 placeholder-gray-400">
                    <button class="absolute right-4 top-1/2 transform -translate-y-1/2">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Table Container --}}
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        {{-- Table Header --}}
                        <thead>
                            <tr class="bg-orange-500 text-white">
                                <th class="px-6 py-3 text-left text-sm font-semibold">ID Pesanan</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold">Nama Pemesan</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold">Barang Pesanan</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold">Tanggal Pembelian</th>
                                <th class="px-6 py-3 text-center text-sm font-semibold">Status Pesanan</th>
                            </tr>
                        </thead>

                        {{-- Table Body --}}
                        <tbody class="divide-y divide-gray-200">
                            @php
                                $dummyData = [
                                    [
                                        'id' => 'ID Pesanan',
                                        'nama' => 'Cooper Bergson',
                                        'barang' => 'Barang Pesanan',
                                        'tanggal' => 'Tanggal Pembelian',
                                        'status' => 'Menunggu',
                                    ],
                                    [
                                        'id' => 'ID Pesanan',
                                        'nama' => 'Katya Herwitz',
                                        'barang' => 'Barang Pesanan',
                                        'tanggal' => 'Tanggal Pembelian',
                                        'status' => 'Menunggu',
                                    ],
                                    [
                                        'id' => 'ID Pesanan',
                                        'nama' => 'Anika Carder',
                                        'barang' => 'Barang Pesanan',
                                        'tanggal' => 'Tanggal Pembelian',
                                        'status' => 'Menunggu',
                                    ],
                                    [
                                        'id' => 'ID Pesanan',
                                        'nama' => 'Jasson Rhiel Madsen',
                                        'barang' => 'Barang Pesanan',
                                        'tanggal' => 'Tanggal Pembelian',
                                        'status' => 'Menunggu',
                                    ],
                                    [
                                        'id' => 'ID Pesanan',
                                        'nama' => 'Madelyn Dorvin',
                                        'barang' => 'Barang Pesanan',
                                        'tanggal' => 'Tanggal Pembelian',
                                        'status' => 'Menunggu',
                                    ],
                                    [
                                        'id' => 'ID Pesanan',
                                        'nama' => 'Lia Geidt',
                                        'barang' => 'Barang Pesanan',
                                        'tanggal' => 'Tanggal Pembelian',
                                        'status' => 'Menunggu',
                                    ],
                                    [
                                        'id' => 'ID Pesanan',
                                        'nama' => 'Marilyn Westervelt',
                                        'barang' => 'Barang Pesanan',
                                        'tanggal' => 'Tanggal Pembelian',
                                        'status' => 'Menunggu',
                                    ],
                                    [
                                        'id' => 'ID Pesanan',
                                        'nama' => 'Talan Carder',
                                        'barang' => 'Barang Pesanan',
                                        'tanggal' => 'Tanggal Pembelian',
                                        'status' => 'Menunggu',
                                    ],
                                    [
                                        'id' => 'ID Pesanan',
                                        'nama' => 'Cooper Levin',
                                        'barang' => 'Barang Pesanan',
                                        'tanggal' => 'Tanggal Pembelian',
                                        'status' => 'Menunggu',
                                    ],
                                    [
                                        'id' => 'ID Pesanan',
                                        'nama' => 'Kadin Philips',
                                        'barang' => 'Barang Pesanan',
                                        'tanggal' => 'Tanggal Pembelian',
                                        'status' => 'Menunggu',
                                    ],
                                    [
                                        'id' => 'ID Pesanan',
                                        'nama' => 'Talan Passaquindici',
                                        'barang' => 'Barang Pesanan',
                                        'tanggal' => 'Tanggal Pembelian',
                                        'status' => 'Menunggu',
                                    ],
                                    [
                                        'id' => 'ID Pesanan',
                                        'nama' => 'Gustavo Press',
                                        'barang' => 'Barang Pesanan',
                                        'tanggal' => 'Tanggal Pembelian',
                                        'status' => 'Menunggu',
                                    ],
                                    [
                                        'id' => 'ID Pesanan',
                                        'nama' => 'Karya Levin',
                                        'barang' => 'Barang Pesanan',
                                        'tanggal' => 'Tanggal Pembelian',
                                        'status' => 'Menunggu',
                                    ],
                                    [
                                        'id' => 'ID Pesanan',
                                        'nama' => 'Rayna Dorwart',
                                        'barang' => 'Barang Pesanan',
                                        'tanggal' => 'Tanggal Pembelian',
                                        'status' => 'Menunggu',
                                    ],
                                    [
                                        'id' => 'ID Pesanan',
                                        'nama' => 'Maren Rosser',
                                        'barang' => 'Barang Pesanan',
                                        'tanggal' => 'Tanggal Pembelian',
                                        'status' => 'Menunggu',
                                    ],
                                    [
                                        'id' => 'ID Pesanan',
                                        'nama' => 'Alfredo Levin',
                                        'barang' => 'Barang Pesanan',
                                        'tanggal' => 'Tanggal Pembelian',
                                        'status' => 'Menunggu',
                                    ],
                                ];
                            @endphp

                            @foreach ($dummyData as $index => $data)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $data['id'] }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $data['nama'] }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $data['barang'] }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $data['tanggal'] }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <span
                                            class="inline-flex items-center px-6 py-1.5 rounded-full text-xs font-medium bg-yellow-400 text-gray-900">
                                            {{ $data['status'] }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Pagination (Optional) --}}
            <div class="mt-6 flex items-center justify-between">
                <div class="text-sm text-gray-700">
                    Menampilkan <span class="font-medium">1</span> sampai <span class="font-medium">16</span> dari <span
                        class="font-medium">16</span> hasil
                </div>
                <div class="flex gap-2">
                    <button
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
                        disabled>
                        Sebelumnya
                    </button>
                    <button
                        class="px-4 py-2 text-sm font-medium text-white bg-orange-500 border border-orange-500 rounded-lg hover:bg-orange-600">
                        1
                    </button>
                    <button
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
                        disabled>
                        Selanjutnya
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Search Functionality (Optional JavaScript) --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.querySelector('input[type="text"]');
            const tableRows = document.querySelectorAll('tbody tr');

            searchInput.addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase();

                tableRows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    if (text.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });
    </script>
@endsection

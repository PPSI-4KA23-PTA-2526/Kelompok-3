@extends('layouts.app')
@section('content')
    <div class="min-h-screen py-8 mt-20">
        <div class="max-w-6xl px-4 mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 gap-8 lg:grid-cols-2 lg:gap-12">

                {{-- LEFT SIDE - IMAGE GALLERY --}}
                <div class="space-y-4">
                    {{-- Main Image --}}
                    <div class="relative p-8 overflow-hidden bg-white shadow-sm rounded-3xl">
                        <button id="prevImage"
                            class="absolute z-10 flex items-center justify-center w-10 h-10 transition transform -translate-y-1/2 bg-white rounded-full shadow-md left-4 top-1/2 hover:bg-gray-50">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                                </path>
                            </svg>
                        </button>

                        <div class="flex items-center justify-center aspect-square">
                            <img src="{{ $defaultVariant && $defaultVariant->first_image ? asset('storage/' . $defaultVariant->first_image) : asset('/images/default-product.jpg') }}"
                                alt="{{ $product->nama_produk }}" class="object-contain max-w-full max-h-full"
                                id="mainImage">
                        </div>

                        <button id="nextImage"
                            class="absolute z-10 flex items-center justify-center w-10 h-10 transition transform -translate-y-1/2 bg-white rounded-full shadow-md right-4 top-1/2 hover:bg-gray-50">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </button>
                    </div>

                    {{-- Thumbnail Gallery --}}
                    <div class="flex justify-center gap-2" id="thumbnailIndicators">
                        {{-- Will be populated by JavaScript --}}
                    </div>
                </div>

                {{-- RIGHT SIDE - PRODUCT INFO --}}
                <div class="space-y-6">
                    {{-- Product Title & Price --}}
                    <div>
                        <h1 class="mb-2 text-3xl font-bold text-gray-900">{{ $product->nama_produk }}</h1>
                        <div class="space-y-1">
                            <p class="text-2xl font-semibold text-gray-900" id="priceDisplay">{{ $product->price_range }}
                            </p>
                            <p class="text-lg font-medium text-blue-600" id="totalPriceDisplay" style="display: none;">
                                Total: <span id="totalAmount"></span>
                            </p>
                        </div>
                        @if ($product->estimasi_pengerjaan_jam)
                            <p class="mt-2 text-sm text-gray-600">
                                <span class="font-medium">Estimasi Pengerjaan:</span>
                                {{ $product->estimasi_formatted }}
                            </p>
                        @endif
                    </div>

                    {{-- Variants Section --}}
                    <div class="space-y-4">
                        {{-- Variasi --}}
                        @if ($product->variants->count() > 0)
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-700">Variasi</label>
                                <div class="grid grid-cols-3 gap-2">
                                    @foreach ($product->variants as $index => $variant)
                                        <button type="button" data-variant-id="{{ $variant->id }}"
                                            data-variant-images='@json($variant->images ?? [])'
                                            data-variant-prices='@json($variant->price_data ?? [])'
                                            class="variant-btn px-4 py-2 border-2 rounded-lg text-sm font-medium transition
                                                {{ $index === 0 ? 'border-blue-500 text-blue-600 bg-blue-50' : 'border-gray-300 text-gray-700 hover:border-blue-500 hover:text-blue-600' }}">
                                            {{ $variant->nama_variasi }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- Ukuran --}}
                        <div id="sizeContainer" style="display: none;">
                            <label class="block mb-2 text-sm font-medium text-gray-700">Ukuran</label>
                            <div class="grid grid-cols-3 gap-2" id="sizeButtons">
                                {{-- Will be populated by JavaScript --}}
                            </div>
                        </div>

                        {{-- Jumlah --}}
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-700">Jumlah</label>
                            <div class="flex items-center w-40 gap-3">
                                <button type="button" id="decreaseQty"
                                    class="flex items-center justify-center w-10 h-10 transition border-2 border-gray-300 rounded-lg hover:bg-gray-50">
                                    <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4">
                                        </path>
                                    </svg>
                                </button>
                                <input type="number" value="1" min="1" id="quantity"
                                    class="flex-1 h-10 text-center border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                                <button type="button" id="increaseQty"
                                    class="flex items-center justify-center w-10 h-10 transition border-2 border-gray-300 rounded-lg hover:bg-gray-50">
                                    <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Ganti bagian MODAL dengan kode berikut -->

                    <!-- MODAL -->
                    <div id="orderModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black/50">
                        <div class="flex items-center justify-center min-h-screen px-4 py-6">
                            <div
                                class="relative w-full max-w-lg p-6 mx-auto bg-white rounded-lg shadow-xl max-h-[90vh] overflow-y-auto">

                                <button id="closeModal"
                                    class="absolute text-2xl text-gray-500 top-4 right-4 hover:text-gray-700">
                                    ✕
                                </button>

                                <h2 class="mb-4 text-xl font-semibold text-gray-900">
                                    Form Pemesanan
                                </h2>

                                <form id="orderForm" enctype="multipart/form-data">
                                    @csrf

                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="product_variant_id" id="formVariantId"
                                        value="{{ $defaultVariant->id ?? '' }}">
                                    <input type="hidden" name="price_index" id="formPriceIndex" value="0">
                                    <input type="hidden" name="quantity" id="formQuantity" value="1">

                                    <div class="space-y-4">
                                        <div>
                                            <label class="block mb-1 text-sm font-medium text-gray-700">Nama Lengkap <span
                                                    class="text-red-500">*</span></label>
                                            <input name="nama_pemesan" required
                                                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                placeholder="Masukkan nama lengkap">
                                        </div>

                                        <div>
                                            <label class="block mb-1 text-sm font-medium text-gray-700">No HP / WhatsApp
                                                <span class="text-red-500">*</span></label>
                                            <input name="no_hp" required type="tel"
                                                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                placeholder="Contoh: 081234567890">
                                        </div>

                                        <div>
                                            <label class="block mb-1 text-sm font-medium text-gray-700">Email</label>
                                            <input name="email" type="email"
                                                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                placeholder="email@example.com (opsional)">
                                        </div>

                                        <div>
                                            <label class="block mb-1 text-sm font-medium text-gray-700">Alamat Lengkap
                                                <span class="text-red-500">*</span></label>
                                            <textarea name="alamat" required
                                                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                rows="3" placeholder="Masukkan alamat lengkap untuk pengiriman"></textarea>
                                        </div>

                                        <div>
                                            <label class="block mb-1 text-sm font-medium text-gray-700">Catatan
                                                Tambahan</label>
                                            <textarea name="catatan_customer"
                                                class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                                rows="2" placeholder="Catatan khusus untuk pesanan Anda (opsional)"></textarea>
                                        </div>

                                        <div>
                                            <label class="block mb-1 text-sm font-medium text-gray-700">Upload
                                                Desain</label>
                                            <input type="file" name="file_desain"
                                                class="w-full p-2 text-sm border border-gray-300 rounded-lg file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                                accept="image/*,.pdf">
                                            <p class="mt-1 text-xs text-gray-500">Format: JPG, PNG, PDF (Max 5MB)</p>
                                        </div>

                                        {{-- Summary --}}
                                        <div class="p-4 space-y-2 border-2 border-blue-100 rounded-lg bg-blue-50">
                                            <p class="text-sm font-semibold text-gray-800">Ringkasan Pesanan:</p>
                                            <div class="space-y-1 text-sm text-gray-700">
                                                <div class="flex justify-between">
                                                    <span class="font-medium">Produk:</span>
                                                    <span id="modalProductName" class="text-right"></span>
                                                </div>
                                                <div class="flex justify-between">
                                                    <span class="font-medium">Variasi:</span>
                                                    <span id="modalVariant" class="text-right"></span>
                                                </div>
                                                <div id="modalSizeRow" class="flex justify-between"
                                                    style="display: none;">
                                                    <span class="font-medium">Ukuran:</span>
                                                    <span id="modalSize" class="text-right"></span>
                                                </div>
                                                <div class="flex justify-between">
                                                    <span class="font-medium">Jumlah:</span>
                                                    <span id="modalQty" class="text-right"></span>
                                                </div>
                                            </div>
                                            <div class="pt-2 mt-2 border-t border-blue-200">
                                                <div class="flex items-center justify-between">
                                                    <span class="text-base font-semibold text-gray-900">Total Bayar:</span>
                                                    <span id="modalTotal" class="text-lg font-bold text-blue-600"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit" id="submitOrderBtn"
                                        class="w-full py-3 mt-6 font-medium text-white transition rounded-lg bg-amber-600 hover:bg-amber-700 focus:ring-4 focus:ring-amber-300">
                                        Bayar Sekarang
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- CSS Tambahan untuk Responsivitas Modal -->
                    <style>
                        /* Modal scrollbar styling */
                        #orderModal>div>div {
                            scrollbar-width: thin;
                            scrollbar-color: #cbd5e0 #f7fafc;
                        }

                        #orderModal>div>div::-webkit-scrollbar {
                            width: 6px;
                        }

                        #orderModal>div>div::-webkit-scrollbar-track {
                            background: #f7fafc;
                            border-radius: 10px;
                        }

                        #orderModal>div>div::-webkit-scrollbar-thumb {
                            background: #cbd5e0;
                            border-radius: 10px;
                        }

                        #orderModal>div>div::-webkit-scrollbar-thumb:hover {
                            background: #a0aec0;
                        }

                        /* Responsive adjustments */
                        @media (max-width: 640px) {
                            #orderModal>div>div {
                                margin: 1rem;
                                max-height: calc(100vh - 2rem);
                            }
                        }
                    </style>

                    {{-- Action Buttons --}}
                    <div class="pt-4 space-y-3">
                        <button id="btnBeli"
                            class="w-full px-6 py-3 font-medium text-white transition bg-orange-500 rounded-lg hover:bg-orange-600">
                            Beli Sekarang
                        </button>

                        <div class="flex items-center gap-4">
                            <div class="text-sm leading-tight text-gray-700">
                                Ingin custom<br>
                                <span class="text-xs text-gray-500">ukuran / desain?</span>
                            </div>

                            <a href="https://wa.me/628128264700?text=Halo,%20saya%20tertarik%20dengan%20{{ urlencode($product->nama_produk) }}"
                                target="_blank"
                                class="flex items-center justify-center flex-1 gap-2 py-3 font-medium text-white transition bg-green-600 rounded-lg hover:bg-green-700">
                                <svg class="w-5 h-5" viewBox="0 0 32 32" fill="currentColor">
                                    <path
                                        d="M16.04 2.003c-7.72 0-14 6.28-14 14 0 2.47.65 4.88 1.88 7.01L2 30l7.17-1.88a13.93 13.93 0 006.87 1.8h.01c7.72 0 14-6.28 14-14s-6.28-13.94-14-13.94zm8.19 19.3c-.35.99-1.72 1.81-2.8 2.04-.74.16-1.7.29-4.94-1.07-4.14-1.72-6.8-5.93-7-6.21-.2-.27-1.69-2.25-1.69-4.3 0-2.04 1.07-3.04 1.45-3.46.38-.41.83-.52 1.11-.52.28 0 .56 0 .8.01.26.01.61-.1.96.73.35.83 1.2 2.89 1.31 3.1.11.21.18.45.03.73-.14.28-.21.45-.42.69-.21.24-.45.54-.64.72-.21.21-.43.44-.19.86.24.41 1.08 1.78 2.32 2.88 1.6 1.42 2.95 1.86 3.36 2.07.41.21.65.18.9-.11.24-.28 1.03-1.2 1.31-1.61.28-.41.56-.34.94-.2.38.14 2.41 1.14 2.82 1.35.41.21.69.31.79.48.1.17.1.99-.25 1.98z" />
                                </svg>
                                Chat Admin via WhatsApp
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- PRODUCT DESCRIPTION --}}
            <div class="p-8 mt-12 bg-white shadow-sm rounded-2xl">
                <h2 class="mb-6 text-2xl font-bold text-blue-900">Deskripsi Produk</h2>

                <div class="space-y-4 leading-relaxed text-gray-700">
                    {!! nl2br(e($product->deskripsi)) !!}
                </div>

                @if ($product->catatan)
                    <div class="p-4 mt-6 border-l-4 border-yellow-400 rounded bg-yellow-50">
                        <p class="text-sm text-yellow-800">
                            <span class="font-semibold">Catatan:</span> {{ $product->catatan }}
                        </p>
                    </div>
                @endif
            </div>

        </div>
    </div>

    {{-- JavaScript for interactivity --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let currentImages = @json($defaultVariant->images ?? []);
            let currentImageIndex = 0;
            let currentPrices = @json($defaultVariant->price_data ?? []);
            let selectedVariantId = '{{ $defaultVariant->id ?? '' }}';
            let selectedVariantName = '{{ $defaultVariant->nama_variasi ?? '' }}';
            let selectedSize = null;
            let selectedSizeName = null;
            let currentUnitPrice = 0;

            // Modal Elements
            const modal = document.getElementById('orderModal');
            const btnBeli = document.getElementById('btnBeli');
            const closeModal = document.getElementById('closeModal');
            const orderForm = document.getElementById('orderForm');

            // Quantity control
            const quantityInput = document.getElementById('quantity');
            const decreaseBtn = document.getElementById('decreaseQty');
            const increaseBtn = document.getElementById('increaseQty');

            function updateTotalPrice() {
                const quantity = parseInt(quantityInput.value) || 1;
                const totalPriceDisplay = document.getElementById('totalPriceDisplay');
                const totalAmount = document.getElementById('totalAmount');

                if (currentUnitPrice > 0 && quantity > 1) {
                    const total = currentUnitPrice * quantity;
                    totalAmount.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
                    totalPriceDisplay.style.display = 'block';
                } else {
                    totalPriceDisplay.style.display = 'none';
                }
            }

            decreaseBtn.addEventListener('click', function() {
                const currentValue = parseInt(quantityInput.value);
                if (currentValue > 1) {
                    quantityInput.value = currentValue - 1;
                    updateTotalPrice();
                }
            });

            increaseBtn.addEventListener('click', function() {
                const currentValue = parseInt(quantityInput.value);
                quantityInput.value = currentValue + 1;
                updateTotalPrice();
            });

            quantityInput.addEventListener('input', function() {
                if (parseInt(this.value) < 1) {
                    this.value = 1;
                }
                updateTotalPrice();
            });

            // Image gallery
            function updateMainImage() {
                const mainImage = document.getElementById('mainImage');
                if (currentImages.length > 0) {
                    mainImage.src = '{{ asset('storage') }}/' + currentImages[currentImageIndex];
                }
                updateThumbnailIndicators();
            }

            function updateThumbnailIndicators() {
                const container = document.getElementById('thumbnailIndicators');
                container.innerHTML = '';
                currentImages.forEach((img, index) => {
                    const dot = document.createElement('button');
                    dot.className = 'w-3 h-3 rounded-full transition ' +
                        (index === currentImageIndex ? 'bg-blue-900' : 'bg-gray-300 hover:bg-gray-400');
                    dot.addEventListener('click', () => {
                        currentImageIndex = index;
                        updateMainImage();
                    });
                    container.appendChild(dot);
                });
            }

            document.getElementById('prevImage').addEventListener('click', function() {
                if (currentImages.length > 0) {
                    currentImageIndex = (currentImageIndex - 1 + currentImages.length) % currentImages
                        .length;
                    updateMainImage();
                }
            });

            document.getElementById('nextImage').addEventListener('click', function() {
                if (currentImages.length > 0) {
                    currentImageIndex = (currentImageIndex + 1) % currentImages.length;
                    updateMainImage();
                }
            });

            // Variant selection
            document.querySelectorAll('.variant-btn').forEach(button => {
                button.addEventListener('click', function() {
                    // Update active state
                    document.querySelectorAll('.variant-btn').forEach(btn => {
                        btn.classList.remove('border-blue-500', 'text-blue-600',
                            'bg-blue-50');
                        btn.classList.add('border-gray-300', 'text-gray-700');
                    });
                    this.classList.remove('border-gray-300', 'text-gray-700');
                    this.classList.add('border-blue-500', 'text-blue-600', 'bg-blue-50');

                    // Update variant ID and name
                    selectedVariantId = this.dataset.variantId;
                    selectedVariantName = this.textContent.trim();

                    // Update images
                    currentImages = JSON.parse(this.dataset.variantImages);
                    currentImageIndex = 0;
                    updateMainImage();

                    // Update prices and sizes
                    currentPrices = JSON.parse(this.dataset.variantPrices);
                    selectedSize = null;
                    selectedSizeName = null;
                    updateSizes();
                    updatePrice();
                });
            });

            // Size selection
            function updateSizes() {
                const sizeContainer = document.getElementById('sizeContainer');
                const sizeButtons = document.getElementById('sizeButtons');

                if (Array.isArray(currentPrices) && currentPrices.length > 0) {
                    sizeContainer.style.display = 'block';
                    sizeButtons.innerHTML = '';

                    currentPrices.forEach((priceData, index) => {
                        const button = document.createElement('button');
                        button.type = 'button';
                        button.className =
                            'size-btn px-4 py-2 border-2 border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:border-blue-500 hover:text-blue-600 transition';
                        button.textContent = priceData.ukuran || priceData.size || 'N/A';
                        button.dataset.sizeIndex = index;
                        button.dataset.price = priceData.harga || priceData.price || 0;
                        button.dataset.sizeName = priceData.ukuran || priceData.size || 'N/A';

                        button.addEventListener('click', function() {
                            document.querySelectorAll('.size-btn').forEach(btn => {
                                btn.classList.remove('border-blue-500', 'text-blue-600',
                                    'bg-blue-50');
                                btn.classList.add('border-gray-300', 'text-gray-700');
                            });
                            this.classList.remove('border-gray-300', 'text-gray-700');
                            this.classList.add('border-blue-500', 'text-blue-600', 'bg-blue-50');

                            selectedSize = parseInt(this.dataset.sizeIndex);
                            selectedSizeName = this.dataset.sizeName;
                            updatePrice();
                        });

                        sizeButtons.appendChild(button);
                    });
                } else {
                    sizeContainer.style.display = 'none';
                }
            }

            function updatePrice() {
                const priceDisplay = document.getElementById('priceDisplay');

                if (selectedSize !== null && currentPrices[selectedSize]) {
                    const price = currentPrices[selectedSize].harga || currentPrices[selectedSize].price || 0;
                    currentUnitPrice = price;
                    priceDisplay.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(price);
                } else {
                    if (Array.isArray(currentPrices) && currentPrices.length > 0) {
                        const prices = currentPrices.map(p => p.harga || p.price || 0);
                        const min = Math.min(...prices);
                        const max = Math.max(...prices);
                        currentUnitPrice = min;
                        if (min === max) {
                            priceDisplay.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(min);
                        } else {
                            priceDisplay.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(min) +
                                ' - Rp ' + new Intl.NumberFormat('id-ID').format(max);
                        }
                    } else {
                        priceDisplay.textContent = '{{ $product->price_range }}';
                        currentUnitPrice = 0;
                    }
                }

                updateTotalPrice();
            }

            // Initialize
            updateThumbnailIndicators();
            updateSizes();
            updatePrice();

            // Buy Now functionality
            btnBeli.addEventListener('click', function() {
                const selectedVariant = document.querySelector('.variant-btn.border-blue-500');
                if (!selectedVariant) {
                    alert('Silakan pilih variasi terlebih dahulu');
                    return;
                }

                if (Array.isArray(currentPrices) && currentPrices.length > 0 && selectedSize === null) {
                    alert('Silakan pilih ukuran terlebih dahulu');
                    return;
                }

                const quantity = parseInt(quantityInput.value);
                const total = currentUnitPrice * quantity;

                // Update form hidden inputs
                document.getElementById('formVariantId').value = selectedVariantId;
                document.getElementById('formPriceIndex').value = selectedSize !== null ? selectedSize : 0;
                document.getElementById('formQuantity').value = quantity;

                // Update modal summary
                document.getElementById('modalProductName').textContent = '{{ $product->nama_produk }}';
                document.getElementById('modalVariant').textContent = selectedVariantName;
                document.getElementById('modalQty').textContent = quantity + ' pcs';
                document.getElementById('modalTotal').textContent = 'Rp ' + new Intl.NumberFormat('id-ID')
                    .format(total);

                const modalSizeRow = document.getElementById('modalSizeRow');
                if (selectedSizeName) {
                    document.getElementById('modalSize').textContent = selectedSizeName;
                    modalSizeRow.style.display = 'block';
                } else {
                    modalSizeRow.style.display = 'none';
                }

                // Show modal
                modal.classList.remove('hidden');
            });

            // Close modal
            closeModal.addEventListener('click', function() {
                modal.classList.add('hidden');
            });

            // Close modal when clicking outside
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    modal.classList.add('hidden');
                }
            });

            // Form submission
            orderForm.addEventListener('submit', async function(e) {
                e.preventDefault();

                const submitBtn = document.getElementById('submitOrderBtn');
                submitBtn.disabled = true;
                submitBtn.textContent = 'Memproses...';

                try {
                    const formData = new FormData(this);

                    const response = await fetch("{{ route('order.store') }}", {
                        method: "POST",
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: formData
                    });

                    const result = await response.json();

                    if (!result.snap_token) {
                        alert('Gagal membuat pembayaran. Silakan coba lagi.');
                        submitBtn.disabled = false;
                        submitBtn.textContent = 'Bayar Sekarang';
                        return;
                    }

                    // Process payment with Midtrans
                    window.snap.pay(result.snap_token, {
                        onSuccess: function(result) {
                            alert('Pembayaran berhasil! Terima kasih atas pesanan Anda.');
                            window.location.reload();
                        },
                        onPending: function(result) {
                            alert('Menunggu pembayaran Anda.');
                            window.location.reload();
                        },
                        onError: function(result) {
                            alert('Pembayaran gagal. Silakan coba lagi.');
                            submitBtn.disabled = false;
                            submitBtn.textContent = 'Bayar Sekarang';
                        },
                        onClose: function() {
                            submitBtn.disabled = false;
                            submitBtn.textContent = 'Bayar Sekarang';
                        }
                    });
                } catch (error) {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan. Silakan coba lagi.');
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'Bayar Sekarang';
                }
            });
        });
    </script>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
    </script>
@endsection

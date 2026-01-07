@extends('layouts.app')
@section('content')
    <div class="min-h-screen py-8 mt-20">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">

                {{-- LEFT SIDE - IMAGE GALLERY --}}
                <div class="space-y-4">
                    {{-- Main Image --}}
                    <div class="relative bg-white rounded-3xl overflow-hidden shadow-sm p-8">
                        <button id="prevImage"
                            class="absolute left-4 top-1/2 transform -translate-y-1/2 w-10 h-10 bg-white rounded-full shadow-md flex items-center justify-center hover:bg-gray-50 transition">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                                </path>
                            </svg>
                        </button>

                        <div class="aspect-square flex items-center justify-center">
                            <img src="{{ $defaultVariant && $defaultVariant->first_image ? asset('storage/' . $defaultVariant->first_image) : asset('/images/default-product.jpg') }}"
                                alt="{{ $product->nama_produk }}" class="max-w-full max-h-full object-contain"
                                id="mainImage">
                        </div>

                        <button id="nextImage"
                            class="absolute right-4 top-1/2 transform -translate-y-1/2 w-10 h-10 bg-white rounded-full shadow-md flex items-center justify-center hover:bg-gray-50 transition">
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
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $product->nama_produk }}</h1>
                        <p class="text-2xl font-semibold text-gray-900" id="priceDisplay">{{ $product->price_range }}</p>
                        @if ($product->estimasi_pengerjaan_jam)
                            <p class="text-sm text-gray-600 mt-2">
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
                                <label class="block text-sm font-medium text-gray-700 mb-2">Variasi</label>
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
                            <label class="block text-sm font-medium text-gray-700 mb-2">Ukuran</label>
                            <div class="grid grid-cols-3 gap-2" id="sizeButtons">
                                {{-- Will be populated by JavaScript --}}
                            </div>
                        </div>

                        {{-- Jumlah --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah</label>
                            <div class="flex items-center gap-3 w-40">
                                <button type="button" id="decreaseQty"
                                    class="w-13 h-8 flex items-center justify-center border-2 border-gray-300 rounded-lg hover:bg-gray-50 transition">
                                    <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4">
                                        </path>
                                    </svg>
                                </button>
                                <input type="number" value="1" min="1" id="quantity"
                                    class="flex-1 h-8 text-center border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                                <button type="button" id="increaseQty"
                                    class="w-13 h-8 flex items-center justify-center border-2 border-gray-300 rounded-lg hover:bg-gray-50 transition">
                                    <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- MODAL -->
                    <div id="orderModal" class="fixed inset-0 bg-black/50 hidden z-50">
                        <div class="bg-white max-w-lg mx-auto mt-20 rounded-lg p-6 relative">

                            <button id="closeModal" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
                                ✕
                            </button>

                            <h2 class="text-xl font-semibold mb-4">
                                Form Pemesanan
                            </h2>

                            <form id="orderForm" enctype="multipart/form-data">
                                @csrf

                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="product_variant_id" id="formVariantId"
                                    value="{{ $defaultVariant->id ?? '' }}">
                                <input type="hidden" name="price_index" id="formPriceIndex" value="0">
                                <input type="hidden" name="quantity" id="formQuantity" value="1">

                                <div class="space-y-3">
                                    <input name="nama_pemesan" required class="w-full border rounded p-2"
                                        placeholder="Nama Lengkap">
                                    <input name="no_hp" required class="w-full border rounded p-2"
                                        placeholder="No HP / WhatsApp">
                                    <input name="email" type="email" class="w-full border rounded p-2"
                                        placeholder="Email (opsional)">
                                    <textarea name="alamat" required class="w-full border rounded p-2" rows="3" placeholder="Alamat Lengkap"></textarea>
                                    <textarea name="catatan_customer" class="w-full border rounded p-2" rows="2"
                                        placeholder="Catatan Tambahan (opsional)"></textarea>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Upload Desain
                                            (opsional)</label>
                                        <input type="file" name="file_desain" class="w-full border rounded p-2"
                                            accept="image/*,.pdf">
                                    </div>
                                </div>

                                <button type="submit" id="submitOrderBtn"
                                    class="mt-4 w-full bg-green-600 text-white py-3 rounded hover:bg-green-700 transition font-medium">
                                    Bayar Sekarang
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="space-y-3 pt-4">
                        <button id="btnBeli"
                            class="w-full bg-orange-500 text-white px-6 py-3 rounded-lg hover:bg-orange-600 transition font-medium">
                            Beli Sekarang
                        </button>

                        <div class="flex items-center gap-4">
                            <div class="text-gray-700 text-sm leading-tight">
                                Ingin custom<br>
                                <span class="text-xs text-gray-500">ukuran / desain?</span>
                            </div>

                            <a href="https://wa.me/6281234567890?text=Halo,%20saya%20tertarik%20dengan%20{{ urlencode($product->nama_produk) }}"
                                target="_blank"
                                class="flex-1 bg-green-600 text-white font-medium py-3 rounded-lg
                                    hover:bg-green-700 transition flex items-center justify-center gap-2">
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
            <div class="mt-12 bg-white rounded-2xl shadow-sm p-8">
                <h2 class="text-2xl font-bold text-blue-900 mb-6">Deskripsi Produk</h2>

                <div class="space-y-4 text-gray-700 leading-relaxed">
                    {!! nl2br(e($product->deskripsi)) !!}
                </div>

                @if ($product->catatan)
                    <div class="mt-6 p-4 bg-yellow-50 border-l-4 border-yellow-400 rounded">
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
            let selectedSize = null;

            // Modal Elements
            const modal = document.getElementById('orderModal');
            const btnBeli = document.getElementById('btnBeli');
            const closeModal = document.getElementById('closeModal');
            const orderForm = document.getElementById('orderForm');

            // Quantity control
            const quantityInput = document.getElementById('quantity');
            const decreaseBtn = document.getElementById('decreaseQty');
            const increaseBtn = document.getElementById('increaseQty');

            decreaseBtn.addEventListener('click', function() {
                const currentValue = parseInt(quantityInput.value);
                if (currentValue > 1) {
                    quantityInput.value = currentValue - 1;
                }
            });

            increaseBtn.addEventListener('click', function() {
                const currentValue = parseInt(quantityInput.value);
                quantityInput.value = currentValue + 1;
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

                    // Update variant ID
                    selectedVariantId = this.dataset.variantId;

                    // Update images
                    currentImages = JSON.parse(this.dataset.variantImages);
                    currentImageIndex = 0;
                    updateMainImage();

                    // Update prices and sizes
                    currentPrices = JSON.parse(this.dataset.variantPrices);
                    selectedSize = null;
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

                        button.addEventListener('click', function() {
                            document.querySelectorAll('.size-btn').forEach(btn => {
                                btn.classList.remove('border-blue-500', 'text-blue-600',
                                    'bg-blue-50');
                                btn.classList.add('border-gray-300', 'text-gray-700');
                            });
                            this.classList.remove('border-gray-300', 'text-gray-700');
                            this.classList.add('border-blue-500', 'text-blue-600', 'bg-blue-50');

                            selectedSize = parseInt(this.dataset.sizeIndex);
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
                    priceDisplay.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(price);
                } else {
                    if (Array.isArray(currentPrices) && currentPrices.length > 0) {
                        const prices = currentPrices.map(p => p.harga || p.price || 0);
                        const min = Math.min(...prices);
                        const max = Math.max(...prices);
                        if (min === max) {
                            priceDisplay.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(min);
                        } else {
                            priceDisplay.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(min) +
                                ' - Rp ' + new Intl.NumberFormat('id-ID').format(max);
                        }
                    } else {
                        priceDisplay.textContent = '{{ $product->price_range }}';
                    }
                }
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

                // Update form hidden inputs
                document.getElementById('formVariantId').value = selectedVariantId;
                document.getElementById('formPriceIndex').value = selectedSize !== null ? selectedSize : 0;
                document.getElementById('formQuantity').value = quantityInput.value;

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

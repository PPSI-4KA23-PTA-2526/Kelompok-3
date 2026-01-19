<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // Produk
            $table->foreignId('product_id')->constrained()->restrictOnDelete();
            $table->foreignId('product_variant_id')->constrained()->restrictOnDelete();

            $table->string('nama_produk');
            $table->string('nama_variasi')->nullable();

            $table->integer('qty')->default(1);
            $table->decimal('harga', 15, 2);
            $table->decimal('total', 15, 2);
            $table->json('price_option')->nullable();

            // DATA CUSTOMER (sesuai permintaan)
            $table->string('nama_pemesan');
            $table->string('no_hp');
            $table->string('email')->nullable();
            $table->text('alamat');
            $table->text('catatan_customer')->nullable();
            $table->string('file_desain')->nullable();

            // MIDTRANS
            $table->string('kode_order')->unique();
            $table->string('midtrans_order_id')->unique();
            $table->string('snap_token')->nullable();
            $table->string('payment_method')->nullable();
            $table->enum('payment_status', [
                'pending',
                'paid',
                'expired',
                'failed',
                'refund'
            ])->default('pending');

            // Order workflow (produksi)
            $table->enum('status', [
                'pending',
                'diproses',
                'selesai',
                'dibatalkan'
            ])->default('pending');

            $table->timestamp('paid_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

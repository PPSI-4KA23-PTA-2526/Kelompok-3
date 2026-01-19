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
        Schema::table('orders', function (Blueprint $table) {
            $table->integer('estimasi_pengerjaan_jam')->nullable()->after('status')->comment('Estimasi dari product dalam jam');
            $table->timestamp('waktu_mulai_pengerjaan')->nullable()->after('estimasi_pengerjaan_jam');
            $table->timestamp('target_selesai')->nullable()->after('waktu_mulai_pengerjaan');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['estimasi_pengerjaan_jam', 'waktu_mulai_pengerjaan', 'target_selesai']);
        });
    }
};

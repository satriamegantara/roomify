<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penyewa_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('kos_id')->constrained('kos')->onDelete('cascade');
            $table->decimal('jumlah', 12, 2);
            $table->enum('metode', ['transfer', 'tunai', 'e_wallet'])->default('transfer');
            $table->enum('status', ['pending', 'lunas', 'terlambat'])->default('pending');
            $table->string('bukti_transfer')->nullable();
            $table->date('bulan_tahun');
            $table->timestamps();

            $table->index('penyewa_id');
            $table->index('kos_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};

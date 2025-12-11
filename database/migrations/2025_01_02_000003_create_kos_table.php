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
        Schema::create('kos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pemilik_id')->constrained('users')->onDelete('cascade');
            $table->string('alamat')->nullable();
            $table->decimal('harga_bulanan', 10, 2)->default(0);
            $table->enum('jenis_kos', ['putra', 'putri', 'campur']);
            $table->enum('status', ['aktif', 'tidak_aktif', 'penuh'])->default('aktif');
            $table->decimal('rating_rata_rata', 3, 2)->default(0);
            $table->string('foto_utama')->nullable();
            $table->json('foto_lainnya')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();

            $table->index('pemilik_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kos');
    }
};

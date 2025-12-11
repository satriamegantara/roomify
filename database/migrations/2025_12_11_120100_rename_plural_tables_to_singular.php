<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Core domain tables
        Schema::rename('bookings', 'booking');
        Schema::rename('pembayarans', 'pembayaran');
        Schema::rename('ratings_ulasans', 'rating_ulasan');
        Schema::rename('notifications', 'notification');
        Schema::rename('chats', 'chat');

        // Queue table
        Schema::rename('jobs', 'job');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('booking', 'bookings');
        Schema::rename('pembayaran', 'pembayarans');
        Schema::rename('rating_ulasan', 'ratings_ulasans');
        Schema::rename('notification', 'notifications');
        Schema::rename('chat', 'chats');
        Schema::rename('job', 'jobs');
    }
};

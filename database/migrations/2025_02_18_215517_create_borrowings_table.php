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
        Schema::create('borrowings', function (Blueprint $table) {
                $table->id();
                // $table->unsignedBigInteger('buku_id');
                // ->references('id')->on('bukus')
                $table->foreignId('buku_id')->constrained('bukus')->onDelete('cascade');
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->string('tgl_pinjam')->nullable();
                $table->string('tgl_kembali')->nullable();
                $table->enum('status', ['dipinjam','dikembalikan'])->default('dipinjam');
                $table->softDeletes();
                $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrowings');
    }
};

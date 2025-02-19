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
        Schema::create('bukus', function (Blueprint $table) {
            $table->id();
            $table->string('judul')->nullable();
            $table->string('penulis')->nullable();
            $table->string('penerbit')->nullable();
            $table->integer('tahun')->nullable();
            $table->integer('isbn')->nullable();
            $table->foreignId('kategori_id')->constrained('kategoris')->onDelete('cascade');
            $table->integer('jumlah')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bukus');
    }
};

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
        Schema::create('pengembalians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('borrowing_id')->nullable()->constrained('borrowings')->onDelete('cascade');
            $table->date('tanggal_pengembalian')->nullable();
            $table->integer('denda')->default(0);
            $table->enum('status', ['dipinjam', 'dikembalikan'])->default('dipinjam');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengembalians');
    }
};

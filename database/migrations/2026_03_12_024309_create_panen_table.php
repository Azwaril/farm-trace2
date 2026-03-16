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
        Schema::create('panen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penanaman_id')->constrained('penanaman')->cascadeOnDelete();
            $table->foreignId('riwayat_pupuk_id')->constrained('riwayat_pupuk')->cascadeOnDelete();
            $table->date('tanggal_panen');
            $table->integer('jumlah_panen');
            $table->string('satuan')->default('kg');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('panen');
    }
};

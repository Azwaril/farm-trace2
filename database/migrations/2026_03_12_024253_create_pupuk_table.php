<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pupuk', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pupuk');
            $table->text('deskripsi')->nullable();
            $table->string('image')->nullable(); // url gambar
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pupuk');
    }
};
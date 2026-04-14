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
        Schema::create('lendings', function (Blueprint $table) {
            $table->id();
            $table->string('item_id'); // Relasi ke tabel items
            $table->integer('total');
            $table->string('name'); // Nama peminjam
            $table->text('notes'); // Ket.
            $table->dateTime('date');
            $table->dateTime('returned_at')->nullable(); // Tanggal kembali
            $table->string('user_id'); // Penanggung jawab (operator)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lendings');
    }
};

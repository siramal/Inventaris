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
        Schema::create('lendings', function (Blueprint $table) {
            $table->id();
            $table->string('item_id');
            $table->integer('total');
            $table->string('name');   
            $table->text('notes'); 
            $table->dateTime('date');
            $table->dateTime('returned_at')->nullable(); 
            $table->string('user_id'); 
            $table->timestamps();
            $table->longText('signature')->nullable(); 
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

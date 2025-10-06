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
    Schema::create('katalogs', function (Blueprint $table) {
        $table->id();
        $table->string('name');          // nama produk/usaha
        $table->string('image')->nullable(); // foto produk
        $table->text('description');     // deskripsi
        $table->decimal('price', 12, 2)->nullable(); // harga (opsional)
        $table->text('address');
        $table->string('phone')->nullable;
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('katalogs');
    }
};

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
        Schema::create('u_m_k_m_s', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->text('address');
            // $table->string('phone')->nullable();
            // $table->enum('business', ['Warung Kelontong','Makanan dan Minuman','Sayur Mayur dan Daging','Pakaian','Jajanan Pasar','Jasa Fotocopy','Servis Elektronik','Jasa Sumur Bor','Yang lain']);
            // $table->enum('marketing', ['Tunai', 'Online']);
            // $table->enum('promotion', ['Facebook', 'Instagram', 'TikTok', 'Shopee', 'Tokopedia', 'Gojek/Grab', 'Lainnya']);
            // $table->enum('document', ['Nomor Induk Berusaha', 'Sertifikat Halal', 'Pangan Industri Rumah Tangga', 'Belum Punya', 'Dalam Proses']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('u_m_k_m_s');
    }
};

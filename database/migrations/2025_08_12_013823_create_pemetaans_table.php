<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
USE Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pemetaans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('umkm_id');
            $table->string('name', 100);
            $table->string('nik', 16);
            $table->text('address');
            $table->string('phone')->nullable();
            $table->enum('business', ['Warung Kelontong','Makanan dan Minuman','Sayur Mayur dan Daging','Pakaian','Jajanan Pasar','Jasa Fotocopy','Servis Elektronik','Jasa Sumur Bor','Yang Lain']);
            $table->enum('marketing', ['Tunai', 'Online']);
            $table->enum('promotion', ['Whatsapp', 'Facebook', 'Instagram', 'TikTok', 'Shopee', 'Tokopedia', 'Gojek/Grab', 'Offline','Lainnya']);
            $table->enum('document', ['Nomor Induk Berusaha', 'Sertifikat Halal', 'Pangan Industri Rumah Tangga', 'Belum Punya', 'Dalam Proses']);
            $table->timestamp('report_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->enum('status', ['process','approve', 'rejected'])->default('process');
            $table->timestamps();

            $table->foreign('umkm_id')->references('id')->on('u_m_k_m_s')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemetaans');
    }
};

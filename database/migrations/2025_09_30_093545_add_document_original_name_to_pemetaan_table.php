<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('pemetaans', function (Blueprint $table) {
            $table->string('document_original_name')->nullable()->after('document_photo');
        });
    }

    public function down()
    {
        Schema::table('pemetaans', function (Blueprint $table) {
            $table->dropColumn('document_original_name');
        });
    }
};

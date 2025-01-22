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
        Schema::create('tbl_dbeli', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_hbeli');
            $table->unsignedBigInteger('id_barang');
            $table->integer('qty');
            $table->integer('diskon');
            $table->integer('diskonrp');
            $table->integer('totalrp');
            $table->timestamps();
            $table->foreign('id_hbeli')->references('id')->on('tbl_hbeli')->onDelete('cascade');
            $table->foreign('id_barang')->references('id')->on('tbl_barang')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_dbeli');
    }
};

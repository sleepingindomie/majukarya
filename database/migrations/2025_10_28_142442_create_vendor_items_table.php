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
        Schema::create('vendor_items', function (Blueprint $table) {
            $table->id('id_vendor_item');
            $table->unsignedBigInteger('id_vendor');
            $table->unsignedBigInteger('id_item');
            $table->decimal('harga_sebelum', 20, 2);
            $table->decimal('harga_sekarang', 20, 2);
            $table->timestamps();

            $table->foreign('id_vendor')->references('id_vendor')->on('vendors')->onDelete('cascade');
            $table->foreign('id_item')->references('id_item')->on('items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_items');
    }
};

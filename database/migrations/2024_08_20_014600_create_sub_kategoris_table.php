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
        Schema::create('sub_kategoris', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kategori_id');  // Tambahkan baris ini
            $table->string('nama_sub_kategori');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('kategori_id')
                  ->references('id')
                  ->on('kategoris')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_kategoris');
        
    }
};
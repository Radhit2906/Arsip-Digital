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
        Schema::table('invoices', function (Blueprint $table) {
            // Hapus kolom 'kategori' yang lama
            $table->dropColumn('kategori');

            // Tambahkan kolom 'kategori_id' baru sebagai foreign key
            $table->unsignedBigInteger('kategori_id');

            // Tentukan 'kategori_id' sebagai foreign key yang mengacu ke tabel 'kategoris'
            $table->foreign('kategori_id')->references('id')->on('kategoris')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            // Hapus foreign key dan kolom 'kategori_id'
            $table->dropForeign(['kategori_id']);
            $table->dropColumn('kategori_id');

            // Tambahkan kembali kolom 'kategori' lama jika diperlukan
            $table->string('kategori');
        });
    }
};


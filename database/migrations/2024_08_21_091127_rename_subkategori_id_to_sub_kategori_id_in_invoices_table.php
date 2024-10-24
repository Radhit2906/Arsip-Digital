<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameSubkategoriIdToSubKategoriIdInInvoicesTable extends Migration
{
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            // Menambahkan kolom sub_kategori_id
            $table->unsignedBigInteger('sub_kategori_id')->nullable()->after('id');

            // Menambahkan foreign key jika diperlukan
            $table->foreign('sub_kategori_id')->references('id')->on('sub_kategoris')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            // Menghapus foreign key terlebih dahulu jika ada
            $table->dropForeign(['sub_kategori_id']);

            // Menghapus kolom sub_kategori_id
            $table->dropColumn('sub_kategori_id');
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSubKategorisForeignKeyConstraint extends Migration
{
    public function up()
    {
        Schema::table('sub_kategoris', function (Blueprint $table) {
            $table->dropForeign(['kategori_id']);
            $table->foreign('kategori_id')
                  ->references('id')
                  ->on('kategoris')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('sub_kategoris', function (Blueprint $table) {
            $table->dropForeign(['kategori_id']);
            $table->foreign('kategori_id')
                  ->references('id')
                  ->on('kategoris');
        });
    }
}

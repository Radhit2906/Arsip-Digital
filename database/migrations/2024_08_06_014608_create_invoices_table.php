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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('id_invoice')->unique();
            $table->string('kategori');
            $table->foreignId('subkategori_id')->constrained('sub_kategoris')->onDelete('cascade'); // Pastikan ini sudah benar
            $table->date('date');
            $table->string('seller');
            $table->string('alamat_seller');
            $table->string('payer');
            $table->string('alamat_payer');
            $table->decimal('total_biaya',10,2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};

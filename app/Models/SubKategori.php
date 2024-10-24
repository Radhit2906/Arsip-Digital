<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class SubKategori extends Model
{
    // use HasFactory,SoftDeletes;

    protected $table = 'sub_kategoris';

    protected $fillable = ['nama_sub_kategori', 'kategori_id'];

    // Relasi dengan Kategori
    public function kategori()
    {
        return $this->belongsTo(kategoris::class, 'kategori_id');
    }
    public function invoices()
    {
        return $this->hasMany(invoices::class);
    }
}

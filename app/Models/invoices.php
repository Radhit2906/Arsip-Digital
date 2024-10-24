<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class invoices extends Model
{
    use HasFactory;

    // Mendefinisikan atribut yang bisa diisi secara massal
    protected $fillable =[
        'id_invoice',
        'kategori_id',
        'subkategori_id',
        'date',
        'seller',
        'alamat_seller',
        'payer',
        'alamat_payer',
        'total_biaya',
        'pdf_path'
    ];


    // protected function image(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn ($pdf_path) => url('/storage/posts/' . $pdf_path),
    //     );
    // }

    // Mendefinisikan relasi one-to-many dengan model Keterangan

// Model Post atau Invoice
    // public function subkategori()
    // {
    //     return $this->belongsTo(SubKategori::class,'kategori_id','kategori_id');
    // }

    public function subkategori()
    {
        return $this->belongsTo(SubKategori::class, 'subkategori_id');
    }

    
    public function kategori()
    {
        return $this->belongsTo(kategoris::class,'kategori_id');
    }
    public function keterangans()
    {
        return $this->hasMany(keterangan::class, 'invoice_id');
    }
    protected static function boot()
    {
        parent::boot();

        static::deleting(function($invoice) {
            $invoice->keterangans()->delete();
        });
    }
}

// namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;

// class Invoice extends Model
// {
//     use HasFactory;

//     protected $fillable = [
//         'id_invoice',
//         'category_id', // Tambah field category_id
//         'date',
//         'seller',
//         'alamat_seller',
//         'payer',
//         'alamat_payer',
//         'total_biaya',
//     ];

//     // Definisikan relasi ke model Category
//     public function category()
//     {
//         return $this->belongsTo(Category::class);
//     }

//     public function keterangans()
//     {
//         return $this->hasMany(Keterangan::class, 'invoice_id');
//     }
// }

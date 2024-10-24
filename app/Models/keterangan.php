<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class keterangan extends Model
{
    use HasFactory;

        // Mendefinisikan atribut yang bisa diisi secara massal
        protected $fillable = [
        'invoice_id',
        'keterangan',
        'biaya'
    ];

        // Mendefinisikan relasi many-to-one dengan model invoices
        public function invoice()
        {
            return $this->belongsTo(invoices::class,'id_invoice');
        }

}

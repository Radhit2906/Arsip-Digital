<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kategoris extends Model
{
    use HasFactory;
    protected $fillable =[
        'nama_kategori',
    ];


        public function index()
    {
        $kategoris = kategoris::all();
        return view('home', compact('kategoris'));
    }
    public function subKategoris()
    {
        return $this->hasMany(SubKategori::class, 'kategori_id');
    }

    // app/Models/Kategori.php

    public function invoices()
    {
        return $this->hasMany(invoices::class);
    }
}

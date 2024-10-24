<?php

namespace App\Http\Controllers;

use App\Models\SubKategori;
use Illuminate\Http\Request;

class SubKategoriController extends Controller
{
    public function getByKategori($kategori_id)
{
    $subkategoris = SubKategori::where('kategori_id', $kategori_id)->get();
    return response()->json($subkategoris);
}

public function destroy($id)
{
    $subkategori = SubKategori::findOrFail($id);

    // Cek apakah ada invoice yang terkait dengan subkategori ini
    if ($subkategori->invoices()->count() > 0) {
        return redirect()->back()->with('error', 'Tidak bisa menghapus subkategori karena masih terkait dengan invoice.');
    }

    $subkategori->delete();
    return redirect()->back()->with('success', 'Subkategori berhasil dihapus.');
}

}

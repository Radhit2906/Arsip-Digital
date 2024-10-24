<?php

namespace App\Http\Controllers;

use App\Models\kategoris;
use App\Models\SubKategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KategoriController extends Controller
{   


        public function index()
    {
        $kategoris = kategoris::with('subkategoris')->paginate(10);
        return view('kategori.index', compact('kategoris'));
    }
    
    public function edit($id)
    {
        $kategori = kategoris::with('subkategoris')->findOrFail($id);
        return view('kategori.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $kategori = kategoris::findOrFail($id);
        $kategori->update($request->only('nama_kategori'));
    
        // Perbarui subkategori
        $submittedSubkategoriNames = $request->input('subkategori', []);
    
        foreach ($kategori->subkategoris as $subkategori) {
            if (!in_array($subkategori->nama_sub_kategori, $submittedSubkategoriNames)) {
                if ($subkategori->invoices()->count() > 0) {
                    return redirect()->back()->with('error', 'Tidak bisa menghapus subkategori karena masih terkait dengan invoice.');
                }
                $subkategori->delete();
            }
        }
    
        foreach ($submittedSubkategoriNames as $subkategoriName) {
            SubKategori::updateOrCreate(
                ['nama_sub_kategori' => $subkategoriName, 'kategori_id' => $kategori->id]
            );
        }
    
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }
    

    public function show($id)
    {
        $kategori = kategoris::find($id);

        if (!$kategori) {
            return response()->json(['message' => 'Kategori tidak ditemukan'], 404);
        }

        return view('kategori.show', compact('kategori'));
    }
    public function create()
    {
        $kategoris = kategoris::all();
        return view('kategori', compact('kategoris'));
    }

    

    public function store(Request $request)
    {
        // Validasi Input
        $request->validate([
            'nama_kategori' => 'required|string|unique:kategoris,nama_kategori|max:255',
            'subkategori' => 'required|array|min:1',
            'subkategori.*' => 'required|string|max:255',
        ]);

        // Membuat Kategori beserta Subkategori menggunakan relasi Eloquent
        $kategori = kategoris::create([
            'nama_kategori' => $request->nama_kategori,
        ]);

        // Menyimpan Subkategori terkait
        foreach ($request->subkategori as $nama_sub_kategori) {
            $kategori->subkategoris()->create([
                'nama_sub_kategori' => $nama_sub_kategori,
            ]);
        }

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('kategori.index')->with('success', 'Kategori dan subkategori berhasil ditambahkan.');
    }

    /**
     * Menyimpan Subkategori Baru untuk Kategori Tertentu
     */
    public function storeSubKategori(Request $request)
    {
        // Validasi Input
        $request->validate([
            'nama_sub_kategori' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
        ]);

        // Menyimpan Subkategori Baru
        SubKategori::create([
            'nama_sub_kategori' => $request->nama_sub_kategori,
            'kategori_id' => $request->kategori_id,
        ]);

        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Subkategori berhasil ditambahkan.');
    }

        public function getSubKategoris(Request $request)
    {
        $search = $request->input('term');
        $subkategoris = SubKategori::where('nama_sub_kategori', 'LIKE', '%' . $search . '%')->get();

        return response()->json($subkategoris);
    }


    public function destroy($id)
    {
        try {
            DB::statement('PRAGMA foreign_keys = OFF');
            
            $kategori = kategoris::findOrFail($id);
            $kategori->subKategoris()->delete();
            $kategori->delete();
            
            DB::statement('PRAGMA foreign_keys = ON');
            
            return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus');
        } catch (\Exception $e) {
            DB::statement('PRAGMA foreign_keys = ON');
            return redirect()->route('kategori.index')->with('error', 'Gagal menghapus kategori: ' . $e->getMessage());
        }
    }
}

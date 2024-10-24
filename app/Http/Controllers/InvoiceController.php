<?php

// // app/Http/Controllers/InvoiceController.php

// namespace App\Http\Controllers;

// use App\Models\invoices;
// use App\Models\Keterangan;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;

// class InvoiceController extends Controller
// {


//     // public function index(Request $request)
//     // {
//     //     $search = $request->input('search');
//     //     if ($search) {
//     //         // Lakukan pencarian berdasarkan id_invoice, kategori, atau seller dan keterangan dari tabel keterangans
//     //         $invoices = invoices::where('id_invoice', 'LIKE', "%{$search}%")
//     //                     ->orWhere('kategori', 'LIKE', "%{$search}%")
//     //                     ->orWhere('seller', 'LIKE', "%{$search}%")
//     //                     ->orWhere('payer', 'LIKE', "%{$search}%")
//     //                     ->get();
//     //     } else {
//     //         // Ambil semua data dari tabel invoices
//     //         $invoices = invoices::all();
//     //     }

//     //     return view('posts', compact('invoices'));
//     // }
//     public function index(Request $request)
// {
//     $search = $request->input('search');

//     if ($search) {
//         $invoices = invoices::Join('keterangans', 'invoices.id', '=', 'keterangans.invoice_id')
//             ->where(function ($query) use ($search) {
//                 $query->where('invoices.id_invoice', 'LIKE', "%{$search}%")
//                     ->orWhere('invoices.kategori', 'LIKE', "%{$search}%")
//                     ->orWhere('invoices.seller', 'LIKE', "%{$search}%")
//                     ->orWhere('invoices.payer', 'LIKE', "%{$search}%")
//                     ->orWhere('keterangans.keterangan', 'LIKE', "%{$search}%");
//             })
//             ->select('invoices.*')
//             ->distinct()
//             ->get();
//     }
//     else {
//         // Ambil semua data dari tabel invoices
//            $invoices = invoices::all();
//     }

//     return view('posts', compact('invoices'));
// }



//     public function store(Request $request)
//     {
//         $request->validate([
//             'id_invoice' => 'required|string|unique:invoices,id_invoice',
//             'kategori' => 'required|string',
//             'date' => 'required|date',
//             'seller' => 'required|string',
//             'alamat_seller' => 'required|string',
//             'payer' => 'required|string',
//             'alamat_payer' => 'required|string',
//             'total_biaya' => 'required|numeric',
//             'keterangan' => 'required|array',
//             'keterangan.*' => 'required|string',
//             'biaya_keterangan' => 'required|array',
//             'biaya_keterangan.*' => 'required|numeric',
//         ]);

//         $invoices = invoices::create($request->only('id_invoice','kategori', 'date', 'seller', 'alamat_seller', 'payer', 'alamat_payer', 'total_biaya'));

//         foreach ($request->keterangan as $index => $keterangan) {
//             keterangan::create([
//                 'invoice_id' => $invoices->id,
//                 'keterangan' => $keterangan,
//                 'biaya' => $request->biaya_keterangan[$index],
//             ]);
//         }

//         return redirect()->back()->with('success', 'Data berhasil disimpan.');
//     }
// }

namespace App\Http\Controllers;

use App\Models\invoices;
use App\Models\SubKategori;

use App\Models\kategoris;

use App\Models\Keterangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
{

    public function create()
{
    $kategoris = kategoris::with('subKategoris')->get();
    return view('nama_view', compact('kategoris'));
}

//     public function index(Request $request)
// {
//     // Mengambil inputan search, category, start_date, dan end_date dari request
//     $search = $request->input('search');
//     $category = $request->input('category');
//     $startDate = $request->input('start_date');
//     $endDate = $request->input('end_date');
//     $paginate = $request->input('paginate',10); // Default ke 10 jika tidak ada input

//     // Cek apakah ada input pencarian
//     $hasSearch = $search || $category || ($startDate && $endDate);

//     // Jika ada input pencarian, bentuk query dasar untuk mengambil data
//     if ($hasSearch) {
//         $query = invoices::join('keterangans', 'invoices.id', '=', 'keterangans.invoice_id')
//             ->select('invoices.*')
//             ->distinct()
//             ->orderBy('invoices.id', 'asc'); // Urutkan berdasarkan ID


//         // Jika ada kategori yang dipilih dan bukan "All categories", tambahkan kondisi where untuk filter berdasarkan kategori
//         if ($category && $category !== 'All Categories') {
//             $query->where('invoices.kategori', $category);
//         }

//         // Jika ada kata kunci pencarian, tambahkan kondisi where untuk mencari berdasarkan beberapa kolom (ID invoice, seller, payer, keterangan)
//         if ($search) {
//             $query->where(function ($q) use ($search) {
//                 $q->where('invoices.id_invoice', 'LIKE', "%{$search}%")
//                     ->orWhere('invoices.seller', 'LIKE', "%{$search}%")
//                     ->orWhere('invoices.payer', 'LIKE', "%{$search}%")
//                     ->orWhere('keterangans.keterangan', 'LIKE', "%{$search}%");
//             })->paginate(2)->appends(['search' => $request->search]);
//         }

//         // Jika ada rentang tanggal, tambahkan kondisi where untuk filter berdasarkan rentang tanggal
//         if ($startDate && $endDate) {
//             $query->whereBetween('invoices.date', [$startDate, $endDate]);
//         }

//         // Menjalankan query yang telah dibentuk dan mengambil data
//         $invoices = $query->paginate($paginate)->appends($request->except('page'));

//     } else {
//         // Jika tidak ada input pencarian, tidak mengambil data
//         $invoices = invoices::paginate($paginate)->appends($request->except('page'));
//     }

//     // Mengirimkan data ke view posts untuk ditampilkan
//     return view('posts', compact('invoices', 'hasSearch'));
// }

public function index(Request $request)
{
    $search = $request->input('search');
    $category = $request->input('category');
    $subCategory = $request->input('subkategori_id');
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');
    $paginate = $request->input('paginate', 10);
    $searchSeller = $request->input('search_seller');
    $searchBuyer = $request->input('search_payer');
    $searchDescription = $request->input('search_keterangan');

    $hasSearch = $search || $category || $subCategory || ($startDate && $endDate) || $searchSeller || $searchBuyer || $searchDescription;

    $query = invoices::join('keterangans', 'invoices.id', '=', 'keterangans.invoice_id')
        ->join('sub_kategoris', 'invoices.subkategori_id', '=', 'sub_kategoris.id')
        ->join('kategoris', 'sub_kategoris.kategori_id', '=', 'kategoris.id')
        ->select('invoices.*')
        ->distinct()
        ->orderBy('invoices.id', 'asc');

    if ($category && $category !== 'All Categories') {
        $query->where('kategoris.id', $category);
    }

    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('invoices.id_invoice', 'LIKE', "%{$search}%")
                ->orWhere('invoices.seller', 'LIKE', "%{$search}%")
                ->orWhere('invoices.payer', 'LIKE', "%{$search}%")
                ->orWhere('keterangans.keterangan', 'LIKE', "%{$search}%");
        });
    }
    if ($subCategory) {
        $query->where('sub_kategoris.id', $subCategory);
    }

    if ($startDate && $endDate) {
        $query->whereBetween('invoices.date', [$startDate, $endDate]);
    }

    if ($searchSeller) {
        $query->where('invoices.seller', $searchSeller);
    }

    if ($searchBuyer) {
        $query->where('invoices.payer', $searchBuyer);
    }



    if ($searchDescription) {
        $query->where('keterangans.keterangan', 'LIKE', "%{$searchDescription}%");
    }

    $invoices = $query->with(['kategori', 'subkategori'])->paginate($paginate)->appends($request->except('page'));

    $kategoris = kategoris::all();
    $sellers = invoices::select('seller')->distinct()->get();
    $payers = invoices::select('payer')->distinct()->get();
    // $subKategoris = SubKategori::select('id', 'nama_sub_kategori')->distinct()->get();
     // Fetch subcategories based on selected category
     if ($category && $category !== 'All Categories') {
        $subKategoris = SubKategori::where('kategori_id', $category)->select('id', 'nama_sub_kategori')->distinct()->get();
    } else {
        $subKategoris = collect(); // Empty collection when no category is selected
    }

    $selectedCategory = $category && $category !== 'All Categories' ? kategoris::find($category) : null;
    $selectedSubKategori = $subCategory ? SubKategori::find($subCategory) : null;

    return view('posts', compact(
        'invoices',
        'hasSearch',
        'kategoris',
        'subKategoris',
        'sellers',
        'payers',
        'selectedCategory',
        'selectedSubKategori'
    ));
}



    public function getSellers(Request $request)
    {
        // Mendapatkan semua seller dari database
        $sellers = invoices::select('seller')
            ->distinct()
            ->where('seller', 'LIKE', "%{$request->input('term')}%")
            ->get();

        // Mengembalikan data dalam format yang sesuai dengan select2
        return response()->json($sellers);
    }






        public function getSubcategories($id)
        {
            $kategori = kategoris::find($id);

            if ($kategori) {
                return response()->json(['sub_kategoris' => $kategori->sub_kategoris]);
            } else {
                return response()->json(['sub_kategoris' => []]);
            }
        }






    public function store(Request $request)
    {
        // Validasi data yang dikirimkan melalui request
        $request->validate([
            'id_invoice' => 'required|string|unique:invoices,id_invoice',
            'kategori_id' => 'required|exists:kategoris,id',
            'subkategori_id' => 'required|exists:sub_kategoris,id', // Validasi subkategori
            'date' => 'required|date',
            'seller' => 'required|string',
            'alamat_seller' => 'required|string',
            'payer' => 'required|string',
            'alamat_payer' => 'required|string',
            'total_biaya' => 'required|numeric',
            'keterangan' => 'required|array',
            'keterangan.*' => 'required|string',
            'biaya_keterangan' => 'required|array',
            'biaya_keterangan.*' => 'required|numeric',
            'pdf_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048', // Validasi file
        ]);

        try {
            // Mengambil data dari request dan memasukkannya ke dalam array $data
            $data = $request->only('id_invoice', 'kategori_id','subkategori_id', 'date', 'seller', 'alamat_seller', 'payer', 'alamat_payer', 'total_biaya');

            // Jika ada file PDF yang di-upload,
            if ($request->hasFile('pdf_file')) {
                // simpan file tersebut ke direktori pdfs dalam disk public
                $filePath = $request->file('pdf_file')->store('pdfs', 'public');

                // Add the file path to the data array
                $data['pdf_path'] = $filePath;
            }

            // Membuat record baru di tabel invoices menggunakan data yang telah disiapkan
            $invoice = invoices::create($data);

            // Untuk setiap keterangan yang dikirimkan, buat record baru di tabel keterangans yang berhubungan dengan invoice yang baru dibuat
            foreach ($request->keterangan as $index => $keterangan) {
                Keterangan::create([
                    'invoice_id' => $invoice->id,
                    'keterangan' => $keterangan,
                    'biaya' => $request->biaya_keterangan[$index],
                ]);
            }

            //jika berhasil, maka akan menampilkan pesan sukses
            return redirect()->back()->with('success', 'Data berhasil disimpan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'ID/Invoice sudah ada.');
        }
    }


    public function edit($id)
{
    $invoice = invoices::with('keterangans', 'subkategori', 'kategori')->findOrFail($id);
    $kategoris = kategoris::all();
    $selectedSubKategori = $invoice->subkategori;

    return view('edit', compact('invoice', 'kategoris', 'selectedSubKategori'));
}


        public function getSubKategoris($kategori_id)
    {
        // $term = $request->input('term');
        // $kategoriId = $request->input('kategori_id');

        // $query = SubKategori::query();

        // if ($kategoriId) {
        //     $query->where('kategori_id', $kategoriId);
        // }

        // if ($term) {
        //     $query->where('nama_sub_kategori', 'LIKE', "%{$term}%");
        // }

        // $subKategoris = $query->get();
          // Ambil subkategori berdasarkan ID kategori
        $subKategoris = SubKategori::where('kategori_id', $kategori_id)->select('id', 'nama_sub_kategori')->get();


        return response()->json($subKategoris);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_invoice' => 'required|string:invoices,id_invoice',
            'kategori_id' => 'required|exists:kategoris,id',
            'subkategori_id' => 'required|exists:sub_kategoris,id',
            'date' => 'required|date',
            'seller' => 'required|string',
            'alamat_seller' => 'required|string',
            'payer' => 'required|string',
            'alamat_payer' => 'required|string',
            'total_biaya' => 'required|numeric',
            'keterangan' => 'required|array',
            'keterangan.*' => 'required|string',
            'biaya_keterangan' => 'required|array',
            'biaya_keterangan.*' => 'required|numeric',
            'pdf_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048', // Validasi file
        ]);

        $invoice = invoices::findOrFail($id);
        $data = $request->only('id_invoice', 'kategori_id','subkategori_id', 'date', 'seller', 'alamat_seller', 'payer', 'alamat_payer', 'total_biaya');

        if ($request->hasFile('pdf_file')) {
            if ($invoice->pdf_path) {
                Storage::disk('public')->delete($invoice->pdf_path);
            }
            $filePath = $request->file('pdf_file')->store('pdfs', 'public');
            $data['pdf_path'] = $filePath;
        }
        $invoice->update($data);

        Keterangan::where('invoice_id', $id)->delete();
        foreach ($request->keterangan as $index => $keterangan) {
            Keterangan::create([
                'invoice_id' => $invoice->id,
                'keterangan' => $keterangan,
                'biaya' => $request->biaya_keterangan[$index],
            ]);
        }
        return redirect()->route('posts.index')->with('success', 'Data berhasil diupdate.');

    }

    public function destroy($id)
    {
        $post = Invoices::find($id);

        if ($post) {
            $post->delete();
            return redirect()->back()->with('success', 'Invoice berhasil dihapus');
        }

        return redirect()->back()->with('error', 'Invoice tidak ditemukan');
    }




}







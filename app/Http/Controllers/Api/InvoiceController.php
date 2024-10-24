<?php


namespace App\Http\Controllers\Api;

use App\Models\kategoris;
use App\Models\invoices;
use App\Models\keterangan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        // Mengambil input dari request
        $search = $request->input('search');
        $category = $request->input('category');
        $subCategory = $request->input('subkategori_id');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $paginate = $request->input('paginate', 5); // Default menampilkan 5 data per halaman
        $searchSeller = $request->input('search_seller');
        $searchBuyer = $request->input('search_payer');
        $searchDescription = $request->input('search_keterangan');

        // Inisialisasi query dengan join ke tabel keterangans dan sub_kategoris
        $query = invoices::join('keterangans', 'invoices.id', '=', 'keterangans.invoice_id')
            ->join('sub_kategoris', 'invoices.subkategori_id', '=', 'sub_kategoris.id')
            ->select('invoices.*')
            ->distinct()
            ->orderBy('invoices.id', 'asc');

        // Filter berdasarkan kategori jika dipilih
        if ($category && $category !== 'All Categories') {
            $query->where('invoices.kategori_id', $category);
        }

        // Filter berdasarkan subkategori
        if ($subCategory) {
            $query->where('invoices.subkategori_id', $subCategory);
        }
        
        // Filter berdasarkan kata kunci pencarian umum
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('invoices.id_invoice', 'LIKE', "%{$search}%")
                    ->orWhere('invoices.seller', 'LIKE', "%{$search}%")
                    ->orWhere('invoices.payer', 'LIKE', "%{$search}%")
                    ->orWhere('keterangans.keterangan', 'LIKE', "%{$search}%");
            });
        }

        // Filter berdasarkan rentang tanggal
        if ($startDate && $endDate) {
            $query->whereBetween('invoices.date', [$startDate, $endDate]);
        }

        // Filter berdasarkan penjual
        if ($searchSeller) {
            $query->where('invoices.seller', 'LIKE', "%{$searchSeller}%");
        }

        // Filter berdasarkan pembeli
        if ($searchBuyer) {
            $query->where('invoices.payer', 'LIKE', "%{$searchBuyer}%");
        }

        // Filter berdasarkan keterangan
        if ($searchDescription) {
            $query->where('keterangans.keterangan', 'LIKE', "%{$searchDescription}%");
        }

        // Paginasi hasil
        $invoices = $query->paginate($paginate)->appends($request->except('page'));
        
        // Mengembalikan hasil dalam bentuk JSON untuk API response
        return response()->json([
            'success' => true,
            'message' => 'List Data Posts',
            'data' => $invoices
        ], 200);
    }

    public function create()
    {
        $kategoris = kategoris::all(); // Mengambil semua kategori
        return view('home', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_invoice' => 'required|string|unique:invoices,id_invoice',
            'kategori_id' => 'required|exists:kategoris,id',
            'subkategori_id' => 'required|exists:sub_kategoris,id', // Pastikan ini ada
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
            'pdf_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        try {
            $data = $request->only('id_invoice', 'kategori_id', 'subkategori_id', 'date', 'seller', 'alamat_seller', 'payer', 'alamat_payer', 'total_biaya');

            if ($request->hasFile('pdf_file')) {
                $filePath = $request->file('pdf_file')->store('pdfs', 'public');
                $data['pdf_path'] = $filePath;
            }

            $invoice = invoices::create($data);

            foreach ($request->keterangan as $index => $keterangan) {
                Keterangan::create([
                    'invoice_id' => $invoice->id,
                    'keterangan' => $keterangan,
                    'biaya' => $request->biaya_keterangan[$index],
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil disimpan.',
                'invoice' => $invoice
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $post = invoices::find($id);

        if ($post) {
            return response()->json([
                'success' => true,
                'message' => 'Detail Data Post!',
                'data' => $post
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Post not found'
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'id_invoice' => 'required|string',
            'kategori_id' => 'required|exists:kategoris,id',
            'subkategori_id' => 'required|exists:sub_kategoris,id', // Pastikan ini ada
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
            'pdf_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $invoice = invoices::findOrFail($id);
        $data = $request->only('id_invoice', 'kategori_id', 'subkategori_id', 'date', 'seller', 'alamat_seller', 'payer', 'alamat_payer', 'total_biaya');

        if ($request->hasFile('pdf_file')) {
            if ($invoice->pdf_path) {
                Storage::disk('public')->delete($invoice->pdf_path);
            }
            $filePath = $request->file('pdf_file')->store('pdfs', 'public');
            $data['pdf_path'] = $filePath;
        }

        $invoice->update($data);

        keterangan::where('invoice_id', $id)->delete();
        foreach ($request->keterangan as $index => $keterangan) {
            Keterangan::create([
                'invoice_id' => $invoice->id,
                'keterangan' => $keterangan,
                'biaya' => $request->biaya_keterangan[$index],
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diupdate.',
            'invoice' => $invoice
        ], 200);
    }

    public function destroy($id)
    {
        $post = invoices::find($id);

        if ($post) {
            if ($post->pdf_path) {
                Storage::disk('public')->delete($post->pdf_path);
            }
            $post->delete();
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'message' => 'Post not found'], 404);
        }
    }
}




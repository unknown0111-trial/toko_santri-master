<?php

namespace App\Http\Controllers;

use App\Models\KitabModel;
use App\Models\KategoriModel;
use App\Models\PengarangModel;
use App\Models\PenerbitModel;
use App\Models\SupplierModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class KitabController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Kitab',
            'list' => ['Home', 'Kitab']
        ];
        $page = (object) [
            'title' => 'Daftar kitab yang tersedia di Toko Santri'
        ];
        $activeMenu = 'kitab';

        return view('kitab.index', compact('breadcrumb', 'page', 'activeMenu'));
    }

    public function list(Request $request)
    {
        $kitab = KitabModel::select('kitab_id', 'kode_kitab', 'judul_kitab', 'kategori_id', 'pengarang_id', 'penerbit_id', 'stok', 'harga_jual', 'status')
            ->with(['kategori', 'pengarang', 'penerbit']);

        return DataTables::of($kitab)
            ->addIndexColumn()
            ->addColumn('nama_kategori', function ($kitab) {
                return $kitab->kategori->nama_kategori ?? '-';
            })
            ->addColumn('nama_pengarang', function ($kitab) {
                return $kitab->pengarang->nama_pengarang ?? '-';
            })
            ->addColumn('nama_penerbit', function ($kitab) {
                return $kitab->penerbit->nama_penerbit ?? '-';
            })
            ->addColumn('harga_jual_format', function ($kitab) {
                return 'Rp ' . number_format($kitab->harga_jual, 0, ',', '.');
            })
            ->addColumn('aksi', function ($kitab) {
                $btn = '<button onclick="modalAction(\'' . url('/kitab/' . $kitab->kitab_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/kitab/' . $kitab->kitab_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/kitab/' . $kitab->kitab_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create_ajax()
    {
        $kategori = KategoriModel::select('kategori_id', 'nama_kategori')->get();
        $pengarang = PengarangModel::select('pengarang_id', 'nama_pengarang')->get();
        $penerbit = PenerbitModel::select('penerbit_id', 'nama_penerbit')->get();
        $supplier = SupplierModel::select('supplier_id', 'nama_supplier')->get();

        return view('kitab.create_ajax', compact('kategori', 'pengarang', 'penerbit', 'supplier'));
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kode_kitab' => 'required|string|min:3|max:20|unique:kitab,kode_kitab',
                'judul_kitab' => 'required|string|max:200',
                'kategori_id' => 'required|integer',
                'pengarang_id' => 'required|integer',
                'penerbit_id' => 'required|integer',
                'supplier_id' => 'nullable|integer',
                'tahun_terbit' => 'nullable|integer|min:1900|max:' . date('Y'),
                'tebal_buku' => 'nullable|integer|min:10',
                'bahasa' => 'nullable|string|max:50',
                'deskripsi' => 'nullable|string',
                'stok' => 'required|integer|min:0',
                'stok_minimal' => 'required|integer|min:0',
                'harga_beli' => 'required|numeric|min:0',
                'harga_jual' => 'required|numeric|min:0|gt:harga_beli',
                'diskon' => 'nullable|numeric|min:0|max:100',
                'status' => 'required|in:aktif,nonaktif'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            KitabModel::create($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Data kitab berhasil disimpan'
            ]);
        }
        return redirect('/');
    }

    public function show_ajax($id)
    {
        $kitab = KitabModel::with(['kategori', 'pengarang', 'penerbit', 'supplier'])->find($id);
        return view('kitab.show_ajax', ['kitab' => $kitab]);
    }

    public function edit_ajax($id)
    {
        $kitab = KitabModel::find($id);
        $kategori = KategoriModel::select('kategori_id', 'nama_kategori')->get();
        $pengarang = PengarangModel::select('pengarang_id', 'nama_pengarang')->get();
        $penerbit = PenerbitModel::select('penerbit_id', 'nama_penerbit')->get();
        $supplier = SupplierModel::select('supplier_id', 'nama_supplier')->get();

        return view('kitab.edit_ajax', compact('kitab', 'kategori', 'pengarang', 'penerbit', 'supplier'));
    }

    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kode_kitab' => 'required|string|min:3|max:20|unique:kitab,kode_kitab,' . $id . ',kitab_id',
                'judul_kitab' => 'required|string|max:200',
                'kategori_id' => 'required|integer',
                'pengarang_id' => 'required|integer',
                'penerbit_id' => 'required|integer',
                'supplier_id' => 'nullable|integer',
                'tahun_terbit' => 'nullable|integer|min:1900|max:' . date('Y'),
                'tebal_buku' => 'nullable|integer|min:10',
                'bahasa' => 'nullable|string|max:50',
                'deskripsi' => 'nullable|string',
                'stok' => 'required|integer|min:0',
                'stok_minimal' => 'required|integer|min:0',
                'harga_beli' => 'required|numeric|min:0',
                'harga_jual' => 'required|numeric|min:0|gt:harga_beli',
                'diskon' => 'nullable|numeric|min:0|max:100',
                'status' => 'required|in:aktif,nonaktif'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $kitab = KitabModel::find($id);
            if ($kitab) {
                $kitab->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data kitab berhasil diupdate'
                ]);
            }
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }
        return redirect('/');
    }

    public function confirm_ajax($id)
    {
        $kitab = KitabModel::find($id);
        return view('kitab.confirm_ajax', ['kitab' => $kitab]);
    }

    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $kitab = KitabModel::find($id);
            if ($kitab) {
                $kitab->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus'
                ]);
            }
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }
        return redirect('/');
    }
}
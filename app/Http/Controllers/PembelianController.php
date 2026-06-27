<?php

namespace App\Http\Controllers;

use App\Models\PembelianModel;
use App\Models\PembelianDetailModel;
use App\Models\SupplierModel;
use App\Models\KitabModel;
use App\Models\KaryawanModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class PembelianController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Transaksi Pembelian',
            'list' => ['Home', 'Pembelian']
        ];
        $page = (object) [
            'title' => 'Daftar transaksi pembelian kitab dari supplier'
        ];
        $activeMenu = 'pembelian';

        return view('pembelian.index', compact('breadcrumb', 'page', 'activeMenu'));
    }

    public function list(Request $request)
    {
        $pembelian = PembelianModel::select('pembelian_id', 'kode_pembelian', 'supplier_id', 'tanggal_pembelian', 'total_harga', 'status')
            ->with(['supplier']);

        return DataTables::of($pembelian)
            ->addIndexColumn()
            ->addColumn('nama_supplier', function ($pembelian) {
                return $pembelian->supplier->nama_supplier ?? '-';
            })
            ->addColumn('total_harga_format', function ($pembelian) {
                return 'Rp ' . number_format($pembelian->total_harga, 0, ',', '.');
            })
            ->addColumn('aksi', function ($pembelian) {
                $btn = '<button onclick="modalAction(\'' . url('/pembelian/' . $pembelian->pembelian_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                if ($pembelian->status == 'pending') {
                    $btn .= '<button onclick="modalAction(\'' . url('/pembelian/' . $pembelian->pembelian_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                }
                $btn .= '<button onclick="modalAction(\'' . url('/pembelian/' . $pembelian->pembelian_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create_ajax()
    {
        $supplier = SupplierModel::select('supplier_id', 'nama_supplier')->get();
        $kitab = KitabModel::select('kitab_id', 'judul_kitab', 'kode_kitab', 'harga_beli')->where('status', 'aktif')->get();
        return view('pembelian.create_ajax', compact('supplier', 'kitab'));
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'supplier_id' => 'required|integer',
                'tanggal_pembelian' => 'required|date',
                'kitab_id' => 'required|array|min:1',
                'kitab_id.*' => 'required|integer',
                'jumlah' => 'required|array',
                'jumlah.*' => 'required|numeric|min:1',
                'harga_beli' => 'required|array',
                'harga_beli.*' => 'required|numeric|min:0'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            // Generate kode pembelian
            $lastId = PembelianModel::max('pembelian_id') + 1;
            $kode_pembelian = 'PB' . str_pad($lastId, 5, '0', STR_PAD_LEFT);

            // Hitung total harga
            $total_harga = 0;
            for ($i = 0; $i < count($request->kitab_id); $i++) {
                $total_harga += $request->harga_beli[$i] * $request->jumlah[$i];
            }

            // Simpan data pembelian
            $pembelian = PembelianModel::create([
                'kode_pembelian' => $kode_pembelian,
                'supplier_id' => $request->supplier_id,
                'user_id' => 1, // sementara, nanti pakai Auth
                'tanggal_pembelian' => $request->tanggal_pembelian,
                'total_harga' => $total_harga,
                'status' => 'selesai'
            ]);

            // Simpan detail pembelian dan update stok
            for ($i = 0; $i < count($request->kitab_id); $i++) {
                PembelianDetailModel::create([
                    'pembelian_id' => $pembelian->pembelian_id,
                    'kitab_id' => $request->kitab_id[$i],
                    'jumlah' => $request->jumlah[$i],
                    'harga_beli' => $request->harga_beli[$i],
                    'subtotal' => $request->harga_beli[$i] * $request->jumlah[$i]
                ]);

                // Update stok kitab
                $kitab = KitabModel::find($request->kitab_id[$i]);
                $kitab->tambahStok($request->jumlah[$i]);
            }

            return response()->json([
                'status' => true,
                'message' => 'Transaksi pembelian berhasil disimpan'
            ]);
        }
        return redirect('/');
    }

    public function show_ajax($id)
    {
        $pembelian = PembelianModel::with(['supplier', 'detail.kitab'])->find($id);
        return view('pembelian.show_ajax', ['pembelian' => $pembelian]);
    }

    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $pembelian = PembelianModel::find($id);
            if ($pembelian) {
                // Hapus detail terlebih dahulu
                PembelianDetailModel::where('pembelian_id', $id)->delete();
                $pembelian->delete();
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
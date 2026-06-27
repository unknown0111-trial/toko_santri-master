<?php

namespace App\Http\Controllers;

use App\Models\PenjualanModel;
use App\Models\PenjualanDetailModel;
use App\Models\KitabModel;
use App\Models\PelangganModel;
use App\Models\KaryawanModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class PenjualanController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Transaksi Penjualan',
            'list' => ['Home', 'Penjualan']
        ];
        $page = (object) [
            'title' => 'Daftar transaksi penjualan kitab'
        ];
        $activeMenu = 'penjualan';

        return view('penjualan.index', compact('breadcrumb', 'page', 'activeMenu'));
    }

    public function list(Request $request)
    {
        $penjualan = PenjualanModel::select('penjualan_id', 'kode_penjualan', 'tanggal_penjualan', 'total', 'user_id', 'status')
            ->with(['user']);

        return DataTables::of($penjualan)
            ->addIndexColumn()
            ->addColumn('nama_kasir', function ($penjualan) {
                return $penjualan->user->nama ?? '-';
            })
            ->addColumn('total_format', function ($penjualan) {
                return 'Rp ' . number_format($penjualan->total, 0, ',', '.');
            })
            ->addColumn('aksi', function ($penjualan) {
                $btn = '<button onclick="modalAction(\'' . url('/penjualan/' . $penjualan->penjualan_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/penjualan/' . $penjualan->penjualan_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create_ajax()
    {
        $kitab = KitabModel::select('kitab_id', 'kode_kitab', 'judul_kitab', 'harga_jual', 'stok')
            ->where('stok', '>', 0)
            ->where('status', 'aktif')
            ->get();
        return view('penjualan.create_ajax', compact('kitab'));
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kitab_id' => 'required|array|min:1',
                'kitab_id.*' => 'required|integer',
                'jumlah' => 'required|array',
                'jumlah.*' => 'required|numeric|min:1',
                'bayar' => 'required|numeric|min:0'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            // Hitung subtotal
            $subtotal = 0;
            $items = [];
            for ($i = 0; $i < count($request->kitab_id); $i++) {
                $kitab = KitabModel::find($request->kitab_id[$i]);
                $harga = $kitab->harga_jual;
                $jumlah = $request->jumlah[$i];
                $subtotal_item = $harga * $jumlah;
                $subtotal += $subtotal_item;

                $items[] = [
                    'kitab_id' => $request->kitab_id[$i],
                    'jumlah' => $jumlah,
                    'harga_jual' => $harga,
                    'subtotal' => $subtotal_item,
                    'kitab' => $kitab
                ];
            }

            // Diskon (misal 0% dulu)
            $diskon = 0;
            $total = $subtotal - ($subtotal * $diskon / 100);
            $bayar = $request->bayar;
            $kembalian = $bayar - $total;

            if ($kembalian < 0) {
                return response()->json([
                    'status' => false,
                    'message' => 'Pembayaran kurang! Total: Rp ' . number_format($total, 0, ',', '.')
                ]);
            }

            // Generate kode penjualan
            $lastId = PenjualanModel::max('penjualan_id') + 1;
            $kode_penjualan = 'TRX' . str_pad($lastId, 5, '0', STR_PAD_LEFT);

            // Simpan penjualan
            $penjualan = PenjualanModel::create([
                'kode_penjualan' => $kode_penjualan,
                'user_id' => 1, // sementara, nanti pakai Auth
                'tanggal_penjualan' => date('Y-m-d'),
                'subtotal' => $subtotal,
                'diskon' => $diskon,
                'total' => $total,
                'bayar' => $bayar,
                'kembalian' => $kembalian,
                'status' => 'selesai'
            ]);

            // Simpan detail dan update stok
            foreach ($items as $item) {
                PenjualanDetailModel::create([
                    'penjualan_id' => $penjualan->penjualan_id,
                    'kitab_id' => $item['kitab_id'],
                    'jumlah' => $item['jumlah'],
                    'harga_jual' => $item['harga_jual'],
                    'subtotal' => $item['subtotal']
                ]);

                // Kurangi stok
                $item['kitab']->kurangiStok($item['jumlah']);
            }

            return response()->json([
                'status' => true,
                'message' => 'Transaksi penjualan berhasil!',
                'kembalian' => $kembalian,
                'total' => $total,
                'kode_penjualan' => $kode_penjualan
            ]);
        }
        return redirect('/');
    }

    public function show_ajax($id)
    {
        $penjualan = PenjualanModel::with(['user', 'detail.kitab'])->find($id);
        return view('penjualan.show_ajax', ['penjualan' => $penjualan]);
    }

    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $penjualan = PenjualanModel::find($id);
            if ($penjualan) {
                // Kembalikan stok
                foreach ($penjualan->detail as $detail) {
                    $kitab = KitabModel::find($detail->kitab_id);
                    if ($kitab) {
                        $kitab->tambahStok($detail->jumlah);
                    }
                }
                PenjualanDetailModel::where('penjualan_id', $id)->delete();
                $penjualan->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus dan stok dikembalikan'
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
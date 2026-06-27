<?php

namespace App\Http\Controllers;

use App\Models\KitabModel;
use App\Models\KategoriModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class StokController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Manajemen Stok',
            'list' => ['Home', 'Stok']
        ];
        $page = (object) [
            'title' => 'Daftar stok kitab Toko Santri'
        ];
        $activeMenu = 'stok';

        // Data untuk filter
        $kategori = KategoriModel::select('kategori_id', 'nama_kategori')->get();

        return view('stok.index', compact('breadcrumb', 'page', 'activeMenu', 'kategori'));
    }

    public function list(Request $request)
    {
        $stok = KitabModel::select('kitab_id', 'kode_kitab', 'judul_kitab', 'kategori_id', 'stok', 'stok_minimal', 'harga_jual', 'status')
            ->with('kategori');

        // Filter berdasarkan kategori
        if ($request->filter_kategori) {
            $stok->where('kategori_id', $request->filter_kategori);
        }

        // Filter status stok
        if ($request->filter_status == 'menipis') {
            $stok->whereColumn('stok', '<=', 'stok_minimal');
        } elseif ($request->filter_status == 'habis') {
            $stok->where('stok', 0);
        } elseif ($request->filter_status == 'aman') {
            $stok->whereColumn('stok', '>', 'stok_minimal');
        }

        return DataTables::of($stok)
            ->addIndexColumn()
            ->addColumn('nama_kategori', function ($stok) {
                return $stok->kategori->nama_kategori ?? '-';
            })
            ->addColumn('status_stok', function ($stok) {
                if ($stok->stok == 0) {
                    return '<span class="badge badge-danger">Habis</span>';
                } elseif ($stok->stok <= $stok->stok_minimal) {
                    return '<span class="badge badge-warning">Menipis</span>';
                } else {
                    return '<span class="badge badge-success">Aman</span>';
                }
            })
            ->addColumn('harga_jual_format', function ($stok) {
                return 'Rp ' . number_format($stok->harga_jual, 0, ',', '.');
            })
            ->addColumn('aksi', function ($stok) {
                $btn = '<button onclick="modalAction(\'' . url('/stok/' . $stok->kitab_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit Stok</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/stok/' . $stok->kitab_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button>';
                return $btn;
            })
            ->rawColumns(['status_stok', 'aksi'])
            ->make(true);
    }

    public function show_ajax($id)
    {
        $kitab = KitabModel::with(['kategori', 'pengarang', 'penerbit'])->find($id);
        return view('stok.show_ajax', ['kitab' => $kitab]);
    }

    public function edit_ajax($id)
    {
        $kitab = KitabModel::find($id);
        return view('stok.edit_ajax', ['kitab' => $kitab]);
    }

    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'stok' => 'required|integer|min:0',
                'stok_minimal' => 'required|integer|min:0'
            ];

            $validator = \Illuminate\Support\Facades\Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $kitab = KitabModel::find($id);
            if ($kitab) {
                $kitab->stok = $request->stok;
                $kitab->stok_minimal = $request->stok_minimal;
                $kitab->save();

                return response()->json([
                    'status' => true,
                    'message' => 'Stok kitab berhasil diupdate'
                ]);
            }
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }
        return redirect('/');
    }

    // Rekap stok per kategori
    public function rekap()
    {
        $rekap = KategoriModel::with(['kitab' => function ($query) {
            $query->select('kategori_id', 'stok', 'stok_minimal');
        }])->get();

        $data = [];
        foreach ($rekap as $kategori) {
            $total_stok = $kategori->kitab->sum('stok');
            $total_stok_minimal = $kategori->kitab->sum('stok_minimal');
            $kitab_menipis = $kategori->kitab->filter(function ($kitab) {
                return $kitab->stok <= $kitab->stok_minimal;
            })->count();

            $data[] = [
                'kategori' => $kategori->nama_kategori,
                'total_stok' => $total_stok,
                'total_stok_minimal' => $total_stok_minimal,
                'kitab_menipis' => $kitab_menipis
            ];
        }

        return response()->json($data);
    }
}
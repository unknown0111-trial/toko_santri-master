<?php

namespace App\Http\Controllers;

use App\Models\KaryawanModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class KaryawanController extends Controller
{
    // Menampilkan halaman utama
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Karyawan',
            'list' => ['Home', 'Karyawan']
        ];
        $page = (object) [
            'title' => 'Daftar karyawan yang terdaftar di Toko Santri'
        ];
        $activeMenu = 'karyawan';

        return view('karyawan.index', compact('breadcrumb', 'page', 'activeMenu'));
    }

    // Ambil data untuk DataTables
    public function list(Request $request)
    {
        $karyawan = KaryawanModel::select('karyawan_id', 'nik', 'nama', 'jabatan', 'departemen', 'alamat', 'no_telepon', 'jenis_kelamin', 'tanggal_masuk', 'gaji');

        return DataTables::of($karyawan)
            ->addIndexColumn()
            ->addColumn('aksi', function ($karyawan) {
                $btn = '<button onclick="modalAction(\'' . url('/karyawan/' . $karyawan->karyawan_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/karyawan/' . $karyawan->karyawan_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/karyawan/' . $karyawan->karyawan_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    // Form tambah (Ajax)
    public function create_ajax()
    {
        return view('karyawan.create_ajax');
    }

    // Simpan data (Ajax)
    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nik' => 'required|string|min:3|max:20|unique:karyawan,nik',
                'nama' => 'required|string|max:100',
                'jabatan' => 'required|string|max:50',
                'departemen' => 'required|string|max:50',
                'alamat' => 'required|string|max:255',
                'no_telepon' => 'required|string|max:15',
                'jenis_kelamin' => 'required|in:L,P',
                'tanggal_masuk' => 'required|date',
                'gaji' => 'required|numeric|min:1000000'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            KaryawanModel::create($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Data karyawan berhasil disimpan'
            ]);
        }
        return redirect('/');
    }

    // Show detail (Ajax)
    public function show_ajax($id)
    {
        $karyawan = KaryawanModel::find($id);
        return view('karyawan.show_ajax', ['karyawan' => $karyawan]);
    }

    // Form edit (Ajax)
    public function edit_ajax($id)
    {
        $karyawan = KaryawanModel::find($id);
        return view('karyawan.edit_ajax', ['karyawan' => $karyawan]);
    }

    // Update data (Ajax)
    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nik' => 'required|string|min:3|max:20|unique:karyawan,nik,' . $id . ',karyawan_id',
                'nama' => 'required|string|max:100',
                'jabatan' => 'required|string|max:50',
                'departemen' => 'required|string|max:50',
                'alamat' => 'required|string|max:255',
                'no_telepon' => 'required|string|max:15',
                'jenis_kelamin' => 'required|in:L,P',
                'tanggal_masuk' => 'required|date',
                'gaji' => 'required|numeric|min:1000000'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $karyawan = KaryawanModel::find($id);
            if ($karyawan) {
                $karyawan->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data karyawan berhasil diupdate'
                ]);
            }
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }
        return redirect('/');
    }

    // Konfirmasi hapus (Ajax)
    public function confirm_ajax($id)
    {
        $karyawan = KaryawanModel::find($id);
        return view('karyawan.confirm_ajax', ['karyawan' => $karyawan]);
    }

    // Hapus data (Ajax)
    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $karyawan = KaryawanModel::find($id);
            if ($karyawan) {
                $karyawan->delete();
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

    // ========== EXPORT ==========
    public function export_excel()
    {
        $karyawan = KaryawanModel::select('karyawan_id', 'nik', 'nama', 'jabatan', 'departemen', 'alamat', 'no_telepon', 'jenis_kelamin', 'tanggal_masuk', 'gaji')
            ->orderBy('karyawan_id')
            ->get();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'NIK');
        $sheet->setCellValue('C1', 'Nama');
        $sheet->setCellValue('D1', 'Jabatan');
        $sheet->setCellValue('E1', 'Departemen');
        $sheet->setCellValue('F1', 'Alamat');
        $sheet->setCellValue('G1', 'No Telepon');
        $sheet->setCellValue('H1', 'Jenis Kelamin');
        $sheet->setCellValue('I1', 'Tanggal Masuk');
        $sheet->setCellValue('J1', 'Gaji');

        $sheet->getStyle('A1:J1')->getFont()->setBold(true);

        $no = 1;
        $baris = 2;
        foreach ($karyawan as $key => $value) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $value->nik);
            $sheet->setCellValue('C' . $baris, $value->nama);
            $sheet->setCellValue('D' . $baris, $value->jabatan);
            $sheet->setCellValue('E' . $baris, $value->departemen);
            $sheet->setCellValue('F' . $baris, $value->alamat);
            $sheet->setCellValue('G' . $baris, $value->no_telepon);
            $sheet->setCellValue('H' . $baris, $value->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan');
            $sheet->setCellValue('I' . $baris, $value->tanggal_masuk);
            $sheet->setCellValue('J' . $baris, $value->gaji);
            $baris++;
            $no++;
        }

        foreach (range('A', 'J') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $sheet->setTitle('Data Karyawan');
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data Karyawan ' . date('Y-m-d H-i-s') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit;
    }
}
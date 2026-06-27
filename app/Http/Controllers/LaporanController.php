<?php

namespace App\Http\Controllers;

use App\Models\PenjualanModel;
use App\Models\PenjualanDetailModel;
use App\Models\KitabModel;
use App\Models\KategoriModel;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    // ==================== HALAMAN LAPORAN ====================

    public function penjualan()
    {
        $breadcrumb = (object) [
            'title' => 'Laporan Penjualan',
            'list' => ['Home', 'Laporan', 'Penjualan']
        ];
        $activeMenu = 'laporan_penjualan';

        return view('laporan.penjualan', compact('breadcrumb', 'activeMenu'));
    }

    public function persediaan()
    {
        $breadcrumb = (object) [
            'title' => 'Laporan Persediaan',
            'list' => ['Home', 'Laporan', 'Persediaan']
        ];
        $activeMenu = 'laporan_persediaan';
        $kategori = KategoriModel::all();

        return view('laporan.persediaan', compact('breadcrumb', 'activeMenu', 'kategori'));
    }

    // ==================== EXPORT EXCEL PENJUALAN ====================

    public function exportPenjualanExcel(Request $request)
    {
        $start_date = $request->start_date ?? date('Y-m-01');
        $end_date = $request->end_date ?? date('Y-m-t');

        $penjualan = PenjualanModel::with(['user', 'detail.kitab'])
            ->whereBetween('tanggal_penjualan', [$start_date, $end_date])
            ->orderBy('tanggal_penjualan', 'desc')
            ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header
        $sheet->setCellValue('A1', 'LAPORAN PENJUALAN');
        $sheet->setCellValue('A2', 'Periode: ' . date('d/m/Y', strtotime($start_date)) . ' - ' . date('d/m/Y', strtotime($end_date)));
        $sheet->mergeCells('A1:G1');
        $sheet->mergeCells('A2:G2');

        // Style header
        $sheet->getStyle('A1:A2')->getFont()->setBold(true);
        $sheet->getStyle('A1:A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Header tabel
        $sheet->setCellValue('A4', 'No');
        $sheet->setCellValue('B4', 'Kode Transaksi');
        $sheet->setCellValue('C4', 'Tanggal');
        $sheet->setCellValue('D4', 'Kasir');
        $sheet->setCellValue('E4', 'Total');
        $sheet->setCellValue('F4', 'Bayar');
        $sheet->setCellValue('G4', 'Kembalian');

        $sheet->getStyle('A4:G4')->getFont()->setBold(true);
        $sheet->getStyle('A4:G4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A4:G4')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFE0E0E0');

        // Data
        $row = 5;
        $no = 1;
        $total_keseluruhan = 0;

        foreach ($penjualan as $p) {
            $sheet->setCellValue('A' . $row, $no);
            $sheet->setCellValue('B' . $row, $p->kode_penjualan);
            $sheet->setCellValue('C' . $row, date('d/m/Y', strtotime($p->tanggal_penjualan)));
            $sheet->setCellValue('D' . $row, $p->user->nama ?? '-');
            $sheet->setCellValue('E' . $row, $p->total);
            $sheet->setCellValue('F' . $row, $p->bayar);
            $sheet->setCellValue('G' . $row, $p->kembalian);

            $sheet->getStyle('E' . $row . ':G' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $total_keseluruhan += $p->total;
            $row++;
            $no++;
        }

        // Total
        $sheet->setCellValue('D' . $row, 'TOTAL');
        $sheet->setCellValue('E' . $row, $total_keseluruhan);
        $sheet->getStyle('D' . $row . ':E' . $row)->getFont()->setBold(true);
        $sheet->getStyle('E' . $row)->getNumberFormat()->setFormatCode('#,##0');

        // Auto size kolom
        foreach (range('A', 'G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Download file
        $filename = 'Laporan_Penjualan_' . date('Y-m-d_H-i-s') . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    // ==================== EXPORT PDF PENJUALAN ====================

    public function exportPenjualanPdf(Request $request)
    {
        $start_date = $request->start_date ?? date('Y-m-01');
        $end_date = $request->end_date ?? date('Y-m-t');

        $penjualan = PenjualanModel::with(['user', 'detail.kitab'])
            ->whereBetween('tanggal_penjualan', [$start_date, $end_date])
            ->orderBy('tanggal_penjualan', 'desc')
            ->get();

        $total_keseluruhan = $penjualan->sum('total');

        $pdf = Pdf::loadView('laporan.penjualan_pdf', [
            'penjualan' => $penjualan,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'total_keseluruhan' => $total_keseluruhan
        ]);

        $pdf->setPaper('a4', 'landscape');
        return $pdf->download('Laporan_Penjualan_' . date('Y-m-d_H-i-s') . '.pdf');
    }

    // ==================== EXPORT EXCEL PERSEDIAAN ====================

    public function exportPersediaanExcel(Request $request)
    {
        $kitab = KitabModel::with('kategori');

        if ($request->kategori_id) {
            $kitab->where('kategori_id', $request->kategori_id);
        }

        $kitab = $kitab->orderBy('kode_kitab')->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header
        $sheet->setCellValue('A1', 'LAPORAN PERSEDIAAN KITAB');
        $sheet->setCellValue('A2', 'Toko Santri');
        $sheet->setCellValue('A3', 'Tanggal Cetak: ' . date('d/m/Y H:i:s'));
        $sheet->mergeCells('A1:H1');
        $sheet->mergeCells('A2:H2');
        $sheet->mergeCells('A3:H3');

        $sheet->getStyle('A1:A3')->getFont()->setBold(true);
        $sheet->getStyle('A1:A3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Header tabel
        $sheet->setCellValue('A5', 'No');
        $sheet->setCellValue('B5', 'Kode');
        $sheet->setCellValue('C5', 'Judul Kitab');
        $sheet->setCellValue('D5', 'Kategori');
        $sheet->setCellValue('E5', 'Stok');
        $sheet->setCellValue('F5', 'Stok Minimal');
        $sheet->setCellValue('G5', 'Status');
        $sheet->setCellValue('H5', 'Harga Jual');

        $sheet->getStyle('A5:H5')->getFont()->setBold(true);
        $sheet->getStyle('A5:H5')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A5:H5')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFE0E0E0');

        // Data
        $row = 6;
        $no = 1;

        foreach ($kitab as $k) {
            $status = $k->stok == 0 ? 'Habis' : ($k->stok <= $k->stok_minimal ? 'Menipis' : 'Aman');
            $statusColor = $k->stok == 0 ? 'FFDC3545' : ($k->stok <= $k->stok_minimal ? 'FFFFC107' : 'FF28A745');

            $sheet->setCellValue('A' . $row, $no);
            $sheet->setCellValue('B' . $row, $k->kode_kitab);
            $sheet->setCellValue('C' . $row, $k->judul_kitab);
            $sheet->setCellValue('D' . $row, $k->kategori->nama_kategori ?? '-');
            $sheet->setCellValue('E' . $row, $k->stok);
            $sheet->setCellValue('F' . $row, $k->stok_minimal);
            $sheet->setCellValue('G' . $row, $status);
            $sheet->setCellValue('H' . $row, $k->harga_jual);

            $sheet->getStyle('G' . $row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB($statusColor);
            $sheet->getStyle('H' . $row)->getNumberFormat()->setFormatCode('#,##0');
            $row++;
            $no++;
        }

        foreach (range('A', 'H') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $filename = 'Laporan_Persediaan_' . date('Y-m-d_H-i-s') . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    // ==================== EXPORT PDF PERSEDIAAN ====================

    public function exportPersediaanPdf(Request $request)
    {
        $kitab = KitabModel::with('kategori');

        if ($request->kategori_id) {
            $kitab->where('kategori_id', $request->kategori_id);
        }

        $kitab = $kitab->orderBy('kode_kitab')->get();

        $pdf = Pdf::loadView('laporan.persediaan_pdf', [
            'kitab' => $kitab,
            'kategori_id' => $request->kategori_id
        ]);

        $pdf->setPaper('a4', 'landscape');
        return $pdf->download('Laporan_Persediaan_' . date('Y-m-d_H-i-s') . '.pdf');
    }
}
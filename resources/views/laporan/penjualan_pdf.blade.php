<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan</title>
    <style>
        body { font-family: 'Arial', sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .title { font-size: 18px; font-weight: bold; }
        .subtitle { font-size: 14px; margin-top: 5px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; text-align: center; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .footer { margin-top: 20px; text-align: right; }
        .total { font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">LAPORAN PENJUALAN</div>
        <div class="subtitle">Toko Santri</div>
        <div>Periode: {{ date('d/m/Y', strtotime($start_date)) }} - {{ date('d/m/Y', strtotime($end_date)) }}</div>
        <div>Tanggal Cetak: {{ date('d/m/Y H:i:s') }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Transaksi</th>
                <th>Tanggal</th>
                <th>Kasir</th>
                <th class="text-right">Total</th>
                <th class="text-right">Bayar</th>
                <th class="text-right">Kembalian</th>
            </tr>
        </thead>
        <tbody>
            @foreach($penjualan as $key => $p)
            <tr>
                <td class="text-center">{{ $key + 1 }}</td>
                <td>{{ $p->kode_penjualan }}</td>
                <td class="text-center">{{ date('d/m/Y', strtotime($p->tanggal_penjualan)) }}</td>
                <td>{{ $p->user->nama ?? '-' }}</td>
                <td class="text-right">Rp {{ number_format($p->total, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($p->bayar, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($p->kembalian, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4" class="text-right">TOTAL</th>
                <th class="text-right">Rp {{ number_format($total_keseluruhan, 0, ',', '.') }}</th>
                <th colspan="2"></th>
            </tr>
        </tfoot>
    </table>
</body>
</html>
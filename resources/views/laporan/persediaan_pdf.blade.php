<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Persediaan</title>
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
        .status-habis { color: red; font-weight: bold; }
        .status-menipis { color: orange; font-weight: bold; }
        .status-aman { color: green; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">LAPORAN PERSEDIAAN KITAB</div>
        <div class="subtitle">Toko Santri</div>
        <div>Tanggal Cetak: {{ date('d/m/Y H:i:s') }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Judul Kitab</th>
                <th>Kategori</th>
                <th class="text-center">Stok</th>
                <th class="text-center">Stok Minimal</th>
                <th>Status</th>
                <th class="text-right">Harga Jual</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kitab as $key => $k)
            @php
                $status = $k->stok == 0 ? 'Habis' : ($k->stok <= $k->stok_minimal ? 'Menipis' : 'Aman');
                $statusClass = $k->stok == 0 ? 'status-habis' : ($k->stok <= $k->stok_minimal ? 'status-menipis' : 'status-aman');
            @endphp
            <tr>
                <td class="text-center">{{ $key + 1 }}</td>
                <td>{{ $k->kode_kitab }}</td>
                <td>{{ $k->judul_kitab }}</td>
                <td>{{ $k->kategori->nama_kategori ?? '-' }}</td>
                <td class="text-center">{{ $k->stok }}</td>
                <td class="text-center">{{ $k->stok_minimal }}</td>
                <td class="{{ $statusClass }}">{{ $status }}</td>
                <td class="text-right">Rp {{ number_format($k->harga_jual, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
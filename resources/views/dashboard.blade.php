@extends('layouts.template')

@section('title', 'Dashboard')
@section('content')

<!-- Stats Cards -->
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $totalKitab }}</h3>
                <p>Total Kitab</p>
            </div>
            <div class="icon">
                <i class="fas fa-book"></i>
            </div>
            <a href="{{ url('/kitab') }}" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $totalKaryawan }}</h3>
                <p>Total Karyawan</p>
            </div>
            <div class="icon">
                <i class="fas fa-users"></i>
            </div>
            <a href="{{ url('/karyawan') }}" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $totalPenjualan }}</h3>
                <p>Transaksi Penjualan</p>
            </div>
            <div class="icon">
                <i class="fas fa-cash-register"></i>
            </div>
            <a href="{{ url('/penjualan') }}" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $stokMenipis }}</h3>
                <p>Stok Menipis</p>
            </div>
            <div class="icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <a href="{{ url('/stok') }}" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>

<!-- Row 2 -->
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Grafik Penjualan {{ date('Y') }}</h3>
            </div>
            <div class="card-body">
                <canvas id="salesChart" style="height: 300px;"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Kitab Terlaris</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr><th>Judul Kitab</th><th>Terjual</th></tr>
                        </thead>
                        <tbody>
                            @forelse($kitabTerlaris as $item)
                            <tr>
                                <td>{{ $item->detail->first()->kitab->judul_kitab ?? '-' }}</td>
                                <td class="text-center">{{ $item->total_jual ?? 0 }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="2" class="text-center">Belum ada data penjualan</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Row 3 -->
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Ringkasan Keuangan</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr><th>Penjualan Hari Ini</th><td class="text-right">Rp {{ number_format($penjualanHariIni, 0, ',', '.') }}</td></tr>
                    <tr><th>Total Transaksi</th><td class="text-right">{{ $totalPenjualan }} transaksi</td></tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Informasi Cepat</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr><th>Total Kategori</th><td>{{ App\Models\KategoriModel::count() }}</td></tr>
                    <tr><th>Total Penerbit</th><td>{{ App\Models\PenerbitModel::count() }}</td></tr>
                    <tr><th>Total Supplier</th><td>{{ App\Models\SupplierModel::count() }}</td></tr>
                    <tr><th>Total Pengarang</th><td>{{ App\Models\PengarangModel::count() }}</td></tr>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@push('css')
<link rel="stylesheet" href="{{ asset('adminlte/plugins/chart.js/Chart.min.css') }}">
@endpush

@push('js')
<script src="{{ asset('adminlte/plugins/chart.js/Chart.min.js') }}"></script>
<script>
    var ctx = document.getElementById('salesChart').getContext('2d');
    var salesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($chartBulan),
            datasets: [{
                label: 'Total Penjualan (Rp)',
                data: @json($chartTotal),
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 2,
                pointRadius: 4,
                pointBackgroundColor: 'rgba(54, 162, 235, 1)',
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Rp ' + context.raw.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });
</script>
@endpush
@extends('layouts.template')

@section('title', 'Dashboard')
@section('content')

<div class="row">
    <div class="col-lg-4 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ App\Models\KaryawanModel::count() }}</h3>
                <p>Total Karyawan</p>
            </div>
            <div class="icon">
                <i class="fas fa-users"></i>
            </div>
            <a href="{{ url('/karyawan') }}" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Selamat Datang di TokoSantri</h3>
    </div>
    <div class="card-body">
        <p>Sistem Manajemen Data Karyawan Toko Santri</p>
        <p>Fitur yang tersedia:</p>
        <ul>
            <li>CRUD Data Karyawan</li>
            <li>Validasi Client & Server Side</li>
            <li>DataTables untuk pencarian dan sorting</li>
            <li>Export data ke Excel</li>
        </ul>
    </div>
</div>

@endsection
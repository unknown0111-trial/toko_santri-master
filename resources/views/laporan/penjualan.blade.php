@extends('layouts.template')

@section('title', 'Laporan Penjualan')
@section('content')

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Filter Laporan Penjualan</h3>
    </div>
    <div class="card-body">
        <form action="{{ url('/laporan/penjualan/export-excel') }}" method="GET" target="_blank">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Tanggal Awal</label>
                        <input type="date" name="start_date" class="form-control" value="{{ date('Y-m-01') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Tanggal Akhir</label>
                        <input type="date" name="end_date" class="form-control" value="{{ date('Y-m-t') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <div>
                            <button type="submit" name="format" value="excel" class="btn btn-success">
                                <i class="fas fa-file-excel"></i> Export Excel
                            </button>
                            <button type="submit" name="format" value="pdf" formaction="{{ url('/laporan/penjualan/export-pdf') }}" class="btn btn-danger">
                                <i class="fas fa-file-pdf"></i> Export PDF
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
@extends('layouts.template')

@section('title', 'Laporan Persediaan')
@section('content')

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Filter Laporan Persediaan</h3>
    </div>
    <div class="card-body">
        <form action="{{ url('/laporan/persediaan/export-excel') }}" method="GET" target="_blank">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Filter Kategori</label>
                        <select name="kategori_id" class="form-control">
                            <option value="">- Semua Kategori -</option>
                            @foreach($kategori as $k)
                                <option value="{{ $k->kategori_id }}">{{ $k->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <div>
                            <button type="submit" name="format" value="excel" class="btn btn-success">
                                <i class="fas fa-file-excel"></i> Export Excel
                            </button>
                            <button type="submit" name="format" value="pdf" formaction="{{ url('/laporan/persediaan/export-pdf') }}" class="btn btn-danger">
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
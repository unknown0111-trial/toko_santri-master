@extends('layouts.template')

@section('title', 'Manajemen Stok')
@section('content')

<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools">
            <button onclick="window.location.href='{{ url('/stok/rekap') }}'" class="btn btn-sm btn-info mt-1">
                <i class="fas fa-chart-pie"></i> Rekap Stok
            </button>
        </div>
    </div>
    <div class="card-body">
        <!-- Filter -->
        <div class="row mb-3">
            <div class="col-md-3">
                <div class="form-group">
                    <label>Filter Kategori</label>
                    <select name="filter_kategori" id="filter_kategori" class="form-control">
                        <option value="">- Semua Kategori -</option>
                        @foreach($kategori as $k)
                            <option value="{{ $k->kategori_id }}">{{ $k->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Filter Status Stok</label>
                    <select name="filter_status" id="filter_status" class="form-control">
                        <option value="">- Semua Status -</option>
                        <option value="aman">Aman (Stok > Minimal)</option>
                        <option value="menipis">Menipis (Stok ≤ Minimal)</option>
                        <option value="habis">Habis (Stok = 0)</option>
                    </select>
                </div>
            </div>
        </div>

        <table class="table table-bordered table-striped table-hover" id="table-stok">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Kitab</th>
                    <th>Judul Kitab</th>
                    <th>Kategori</th>
                    <th>Stok</th>
                    <th>Stok Minimal</th>
                    <th>Status Stok</th>
                    <th>Harga Jual</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<div id="myModal" class="modal fade animate shake" tabindex="-1" data-backdrop="static" data-keyboard="false" data-width="75%"></div>

@endsection

@push('js')
<script>
function modalAction(url = '') {
    $('#myModal').empty();
    $('#myModal').load(url, function() {
        $('#myModal').modal('show');
    });
}

$(document).ready(function() {
    var tableStok = $('#table-stok').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ url('stok/list') }}",
            type: "POST",
            data: function(d) {
                d._token = "{{ csrf_token() }}";
                d.filter_kategori = $('#filter_kategori').val();
                d.filter_status = $('#filter_status').val();
            }
        },
        columns: [
            { data: "DT_RowIndex", className: "text-center", orderable: false, searchable: false },
            { data: "kode_kitab", orderable: true, searchable: true },
            { data: "judul_kitab", orderable: true, searchable: true },
            { data: "nama_kategori", orderable: true, searchable: true },
            { data: "stok", className: "text-center", orderable: true, searchable: false },
            { data: "stok_minimal", className: "text-center", orderable: true, searchable: false },
            { data: "status_stok", className: "text-center", orderable: false, searchable: false },
            { data: "harga_jual_format", className: "text-right", orderable: true, searchable: false },
            { data: "aksi", className: "text-center", orderable: false, searchable: false }
        ]
    });

    $('#filter_kategori, #filter_status').change(function() {
        tableStok.ajax.reload();
    });
});
</script>
@endpush
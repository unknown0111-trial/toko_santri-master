@extends('layouts.template')

@section('title', 'Data Kitab')
@section('content')

<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools">
            <button onclick="modalAction('{{ url('/kitab/create_ajax') }}')" class="btn btn-sm btn-success mt-1">Tambah Kitab</button>
        </div>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <table class="table table-bordered table-striped table-hover" id="table-kitab">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Kitab</th>
                    <th>Judul Kitab</th>
                    <th>Kategori</th>
                    <th>Pengarang</th>
                    <th>Penerbit</th>
                    <th>Stok</th>
                    <th>Harga Jual</th>
                    <th>Status</th>
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
    $('#myModal').on('hidden.bs.modal', function () {
        $('#myModal').empty();
    });

    $('#table-kitab').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ url('kitab/list') }}",
            type: "POST",
            data: function(d) {
                d._token = "{{ csrf_token() }}";
            }
        },
        columns: [
            { data: "DT_RowIndex", className: "text-center", orderable: false, searchable: false },
            { data: "kode_kitab", orderable: true, searchable: true },
            { data: "judul_kitab", orderable: true, searchable: true },
            { data: "nama_kategori", orderable: true, searchable: true },
            { data: "nama_pengarang", orderable: true, searchable: true },
            { data: "nama_penerbit", orderable: true, searchable: true },
            { data: "stok", className: "text-center", orderable: true, searchable: false },
            { data: "harga_jual_format", className: "text-right", orderable: true, searchable: false },
            { data: "status", className: "text-center", orderable: true, searchable: false },
            { data: "aksi", orderable: false, searchable: false }
        ]
    });
});
</script>
@endpush
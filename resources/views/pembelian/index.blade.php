@extends('layouts.template')

@section('title', 'Transaksi Pembelian')
@section('content')

<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools">
            <button onclick="modalAction('{{ url('/pembelian/create_ajax') }}')" class="btn btn-sm btn-success mt-1">Tambah Pembelian</button>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped table-hover" id="table-pembelian">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Pembelian</th>
                    <th>Supplier</th>
                    <th>Tanggal</th>
                    <th>Total Harga</th>
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

    $('#table-pembelian').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ url('pembelian/list') }}",
            type: "POST",
            data: function(d) {
                d._token = "{{ csrf_token() }}";
            }
        },
        columns: [
            { data: "DT_RowIndex", className: "text-center", orderable: false, searchable: false },
            { data: "kode_pembelian", orderable: true, searchable: true },
            { data: "nama_supplier", orderable: true, searchable: true },
            { data: "tanggal_pembelian", orderable: true, searchable: true },
            { data: "total_harga_format", className: "text-right", orderable: true, searchable: false },
            { data: "status", className: "text-center", orderable: true, searchable: false },
            { data: "aksi", orderable: false, searchable: false }
        ]
    });
});
</script>
@endpush
@extends('layouts.template')

@section('title', 'Transaksi Penjualan')
@section('content')

<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools">
            <button onclick="modalAction('{{ url('/penjualan/create_ajax') }}')" class="btn btn-sm btn-success mt-1">
                <i class="fas fa-cash-register"></i> Transaksi Baru
            </button>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped table-hover" id="table-penjualan">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Transaksi</th>
                    <th>Tanggal</th>
                    <th>Kasir</th>
                    <th>Total</th>
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

    $('#table-penjualan').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ url('penjualan/list') }}",
            type: "POST",
            data: function(d) {
                d._token = "{{ csrf_token() }}";
            }
        },
        columns: [
            { data: "DT_RowIndex", className: "text-center", orderable: false, searchable: false },
            { data: "kode_penjualan", orderable: true, searchable: true },
            { data: "tanggal_penjualan", orderable: true, searchable: true },
            { data: "nama_kasir", orderable: true, searchable: true },
            { data: "total_format", className: "text-right", orderable: true, searchable: false },
            { data: "status", className: "text-center", orderable: true, searchable: false },
            { data: "aksi", orderable: false, searchable: false }
        ]
    });
});
</script>
@endpush
@empty($pembelian)
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">Data pembelian tidak ditemukan</div>
            </div>
        </div>
    </div>
@else
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Transaksi Pembelian</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tr><th style="width: 30%">Kode Pembelian</th><td>{{ $pembelian->kode_pembelian }}</td></tr>
                    <tr><th>Supplier</th><td>{{ $pembelian->supplier->nama_supplier ?? '-' }}</td></tr>
                    <tr><th>Tanggal Pembelian</th><td>{{ $pembelian->tanggal_pembelian }}</td></tr>
                    <tr><th>Total Harga</th><td>Rp {{ number_format($pembelian->total_harga, 0, ',', '.') }}</td></tr>
                    <tr><th>Status</th><td>{{ ucfirst($pembelian->status) }}</td></tr>
                </table>

                <h5 class="mt-3">Detail Kitab</h5>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Kode Kitab</th>
                            <th>Judul Kitab</th>
                            <th>Jumlah</th>
                            <th>Harga Beli</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pembelian->detail as $detail)
                        <tr>
                            <td>{{ $detail->kitab->kode_kitab ?? '-' }}</td>
                            <td>{{ $detail->kitab->judul_kitab ?? '-' }}</td>
                            <td class="text-center">{{ $detail->jumlah }}</td>
                            <td class="text-right">Rp {{ number_format($detail->harga_beli, 0, ',', '.') }}</td>
                            <td class="text-right">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="4" class="text-right">Grand Total :</th>
                            <th class="text-right">Rp {{ number_format($pembelian->total_harga, 0, ',', '.') }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-primary">Tutup</button>
            </div>
        </div>
    </div>
@endempty
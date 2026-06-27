@empty($penjualan)
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">Data penjualan tidak ditemukan</div>
            </div>
        </div>
    </div>
@else
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Transaksi Penjualan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-bordered">
                            <tr><th style="width: 40%">Kode Transaksi</th><td>{{ $penjualan->kode_penjualan }}</td></tr>
                            <tr><th>Tanggal</th><td>{{ $penjualan->tanggal_penjualan }}</td></tr>
                            <tr><th>Kasir</th><td>{{ $penjualan->user->nama ?? '-' }}</td></tr>
                            <tr><th>Status</th><td>{{ ucfirst($penjualan->status) }}</td></tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-bordered">
                            <tr><th style="width: 40%">Subtotal</th><td>Rp {{ number_format($penjualan->subtotal, 0, ',', '.') }}</td></tr>
                            <tr><th>Diskon</th><td>{{ $penjualan->diskon }}%</td></tr>
                            <tr><th>Total</th><td><strong>Rp {{ number_format($penjualan->total, 0, ',', '.') }}</strong></td></tr>
                            <tr><th>Bayar</th><td>Rp {{ number_format($penjualan->bayar, 0, ',', '.') }}</td></tr>
                            <tr><th>Kembalian</th><td>Rp {{ number_format($penjualan->kembalian, 0, ',', '.') }}</td></tr>
                        </table>
                    </div>
                </div>

                <h5 class="mt-3">Detail Item</h5>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Judul Kitab</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-right">Harga</th>
                            <th class="text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($penjualan->detail as $detail)
                        <tr>
                            <td>{{ $detail->kitab->kode_kitab ?? '-' }}</td>
                            <td>{{ $detail->kitab->judul_kitab ?? '-' }}</td>
                            <td class="text-center">{{ $detail->jumlah }}</td>
                            <td class="text-right">Rp {{ number_format($detail->harga_jual, 0, ',', '.') }}</td>
                            <td class="text-right">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="4" class="text-right">Grand Total :</th>
                            <th class="text-right">Rp {{ number_format($penjualan->total, 0, ',', '.') }}</th>
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
@empty($kitab)
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">Data kitab tidak ditemukan</div>
            </div>
        </div>
    </div>
@else
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Stok Kitab</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tr><th style="width: 30%">Kode Kitab</th><td>{{ $kitab->kode_kitab }}</td></tr>
                    <tr><th>Judul Kitab</th><td>{{ $kitab->judul_kitab }}</td></tr>
                    <tr><th>Kategori</th><td>{{ $kitab->kategori->nama_kategori ?? '-' }}</td></tr>
                    <tr><th>Pengarang</th><td>{{ $kitab->pengarang->nama_pengarang ?? '-' }}</td>\\
                    <tr><th>Penerbit</th><td>{{ $kitab->penerbit->nama_penerbit ?? '-' }}</td>\\
                    <tr><th>Stok Saat Ini</th><td>{{ $kitab->stok }} $kitab->stok_minimal ? '(<span class="text-danger">Menipis</span>)' : '' !!}</td>\\
                    <tr><th>Stok Minimal</th><td>{{ $kitab->stok_minimal }}</td>\\
                    <tr><th>Harga Beli</th><td>Rp {{ number_format($kitab->harga_beli, 0, ',', '.') }}</td>\\
                    <tr><th>Harga Jual</th><td>Rp {{ number_format($kitab->harga_jual, 0, ',', '.') }}</td>\\
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-primary">Tutup</button>
            </div>
        </div>
    </div>
@endempty
@empty($karyawan)
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">Data karyawan tidak ditemukan</div>
            </div>
        </div>
    </div>
@else
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Data Karyawan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tr><th style="width: 30%">NIK</th><td>{{ $karyawan->nik }}</td></tr>
                    <tr><th>Nama Lengkap</th><td>{{ $karyawan->nama }}</td></tr>
                    <tr><th>Jabatan</th><td>{{ $karyawan->jabatan }}</td></tr>
                    <tr><th>Departemen</th><td>{{ $karyawan->departemen }}</td></tr>
                    <tr><th>Alamat</th><td>{{ $karyawan->alamat }}</td></tr>
                    <tr><th>No Telepon</th><td>{{ $karyawan->no_telepon }}</td></tr>
                    <tr><th>Jenis Kelamin</th><td>{{ $karyawan->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td></tr>
                    <tr><th>Tanggal Masuk</th><td>{{ $karyawan->tanggal_masuk }}</td></tr>
                    <tr><th>Gaji</th><td>Rp {{ number_format($karyawan->gaji, 0, ',', '.') }}</td></tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-primary">Tutup</button>
            </div>
        </div>
    </div>
@endempty
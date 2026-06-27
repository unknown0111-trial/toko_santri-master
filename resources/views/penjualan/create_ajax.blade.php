<form action="{{ url('/penjualan/ajax') }}" method="POST" id="form-pos">
    @csrf
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fas fa-cash-register"></i> Point of Sale - Toko Santri</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Kolom Kiri: Daftar Kitab -->
                    <div class="col-md-7">
                        <div class="card">
                            <div class="card-header bg-info text-white">
                                <h6 class="card-title mb-0"><i class="fas fa-book"></i> Daftar Kitab</h6>
                            </div>
                            <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                                <table class="table table-sm table-bordered" id="table-kitab">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>Kode</th>
                                            <th>Judul Kitab</th>
                                            <th>Harga</th>
                                            <th>Stok</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($kitab as $k)
                                        <tr>
                                            <td>{{ $k->kode_kitab }}</td>
                                            <td>{{ $k->judul_kitab }}</td>
                                            <td class="text-right">Rp {{ number_format($k->harga_jual, 0, ',', '.') }}</td>
                                            <td class="text-center">{{ $k->stok }}</td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-sm btn-success tambah-item" 
                                                    data-id="{{ $k->kitab_id }}"
                                                    data-kode="{{ $k->kode_kitab }}"
                                                    data-judul="{{ $k->judul_kitab }}"
                                                    data-harga="{{ $k->harga_jual }}"
                                                    data-stok="{{ $k->stok }}">
                                                    <i class="fas fa-plus"></i> Tambah
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Kolom Kanan: Keranjang Belanja -->
                    <div class="col-md-5">
                        <div class="card">
                            <div class="card-header bg-success text-white">
                                <h6 class="card-title mb-0"><i class="fas fa-shopping-cart"></i> Keranjang Belanja</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                                    <table class="table table-sm table-bordered" id="table-keranjang">
                                        <thead class="bg-light">
                                            <tr>
                                                <th>Kitab</th>
                                                <th width="80">Qty</th>
                                                <th width="100">Harga</th>
                                                <th width="100">Subtotal</th>
                                                <th width="40"></th>
                                            </tr>
                                        </thead>
                                        <tbody id="keranjang-body">
                                            <tr id="empty-keranjang">
                                                <td colspan="5" class="text-center text-muted">Belum ada item</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <hr>

                                <div class="row">
                                    <div class="col-8">
                                        <label>Subtotal</label>
                                    </div>
                                    <div class="col-4 text-right">
                                        <strong id="subtotal">Rp 0</strong>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-8">
                                        <label>Diskon</label>
                                    </div>
                                    <div class="col-4 text-right">
                                        <input type="number" name="diskon" id="diskon" class="form-control form-control-sm text-right" value="0" min="0" max="100" step="1">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-8">
                                        <label><strong>Total</strong></label>
                                    </div>
                                    <div class="col-4 text-right">
                                        <strong id="total" class="text-primary" style="font-size: 1.2em;">Rp 0</strong>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-8">
                                        <label><strong>Bayar</strong></label>
                                    </div>
                                    <div class="col-4">
                                        <input type="number" name="bayar" id="bayar" class="form-control form-control-sm text-right" value="0" min="0">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-8">
                                        <label><strong>Kembalian</strong></label>
                                    </div>
                                    <div class="col-4 text-right">
                                        <strong id="kembalian" class="text-success">Rp 0</strong>
                                    </div>
                                </div>

                                <input type="hidden" name="total_hidden" id="total_hidden" value="0">
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary btn-block" id="btn-submit">
                                    <i class="fas fa-check"></i> Proses Transaksi
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
let keranjang = [];

$(document).ready(function() {
    // Tambah item ke keranjang
    $('.tambah-item').click(function() {
        let id = $(this).data('id');
        let kode = $(this).data('kode');
        let judul = $(this).data('judul');
        let harga = $(this).data('harga');
        let stok = $(this).data('stok');

        // Cek apakah item sudah ada di keranjang
        let existing = keranjang.find(item => item.id === id);
        if (existing) {
            if (existing.jumlah + 1 > stok) {
                Swal.fire({ icon: 'warning', title: 'Stok Habis', text: `Stok ${judul} hanya tersisa ${stok}` });
                return;
            }
            existing.jumlah++;
            existing.subtotal = existing.jumlah * existing.harga;
        } else {
            if (1 > stok) {
                Swal.fire({ icon: 'warning', title: 'Stok Habis', text: `Stok ${judul} habis` });
                return;
            }
            keranjang.push({
                id: id,
                kode: kode,
                judul: judul,
                harga: harga,
                jumlah: 1,
                subtotal: harga
            });
        }
        renderKeranjang();
    });

    // Render keranjang
    function renderKeranjang() {
        let html = '';
        let subtotal = 0;

        if (keranjang.length === 0) {
            html = '<tr id="empty-keranjang"><td colspan="5" class="text-center text-muted">Belum ada item</td></tr>';
        } else {
            keranjang.forEach((item, index) => {
                subtotal += item.subtotal;
                html += `
                    <tr>
                        <td><small>${item.kode}<br>${item.judul}</small></td>
                        <td>
                            <input type="number" class="form-control form-control-sm qty-item" data-index="${index}" value="${item.jumlah}" min="1" max="100">
                        </td>
                        <td class="text-right">Rp ${item.harga.toLocaleString('id-ID')}</td>
                        <td class="text-right">Rp ${item.subtotal.toLocaleString('id-ID')}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-danger remove-item" data-index="${index}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
                // Hidden inputs untuk submit
                html += `<input type="hidden" name="kitab_id[]" value="${item.id}">`;
                html += `<input type="hidden" name="jumlah[]" value="${item.jumlah}">`;
            });
        }

        $('#keranjang-body').html(html);
        $('#subtotal').text('Rp ' + subtotal.toLocaleString('id-ID'));
        
        // Hitung total setelah diskon
        hitungTotal();
        
        // Bind event untuk qty
        $('.qty-item').on('change', function() {
            let index = $(this).data('index');
            let newQty = parseInt($(this).val());
            if (newQty > 0) {
                keranjang[index].jumlah = newQty;
                keranjang[index].subtotal = keranjang[index].jumlah * keranjang[index].harga;
                renderKeranjang();
            }
        });

        // Bind event untuk remove
        $('.remove-item').click(function() {
            let index = $(this).data('index');
            keranjang.splice(index, 1);
            renderKeranjang();
        });
    }

    // Hitung total setelah diskon
    function hitungTotal() {
        let subtotal = 0;
        keranjang.forEach(item => {
            subtotal += item.subtotal;
        });
        let diskon = parseFloat($('#diskon').val()) || 0;
        let total = subtotal - (subtotal * diskon / 100);
        $('#total').text('Rp ' + total.toLocaleString('id-ID'));
        $('#total_hidden').val(total);
        hitungKembalian();
    }

    // Hitung kembalian
    function hitungKembalian() {
        let total = parseFloat($('#total_hidden').val()) || 0;
        let bayar = parseFloat($('#bayar').val()) || 0;
        let kembalian = bayar - total;
        if (kembalian < 0) kembalian = 0;
        $('#kembalian').text('Rp ' + kembalian.toLocaleString('id-ID'));
    }

    // Event listener
    $('#diskon').on('keyup change', function() {
        hitungTotal();
    });

    $('#bayar').on('keyup change', function() {
        hitungKembalian();
    });

    // Validasi form
    $("#form-pos").validate({
        rules: {
            bayar: { required: true, number: true, min: 1 }
        },
        submitHandler: function(form) {
            if (keranjang.length === 0) {
                Swal.fire({ icon: 'warning', title: 'Keranjang Kosong', text: 'Silakan tambahkan kitab terlebih dahulu!' });
                return false;
            }
            let total = parseFloat($('#total_hidden').val()) || 0;
            let bayar = parseFloat($('#bayar').val()) || 0;
            if (bayar < total) {
                Swal.fire({ icon: 'error', title: 'Pembayaran Kurang', text: `Total: Rp ${total.toLocaleString('id-ID')}` });
                return false;
            }
            
            $.ajax({
                url: form.action,
                type: form.method,
                data: $(form).serialize(),
                success: function(response) {
                    if (response.status) {
                        $('#myModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Transaksi Berhasil!',
                            html: `<strong>Kode Transaksi:</strong> ${response.kode_penjualan}<br>
                                   <strong>Total:</strong> Rp ${response.total.toLocaleString('id-ID')}<br>
                                   <strong>Kembalian:</strong> Rp ${response.kembalian.toLocaleString('id-ID')}`
                        });
                        $('#table-penjualan').DataTable().ajax.reload();
                    } else {
                        Swal.fire({ icon: 'error', title: 'Gagal', text: response.message });
                    }
                },
                error: function() {
                    Swal.fire({ icon: 'error', title: 'Error', text: 'Terjadi kesalahan, silakan coba lagi' });
                }
            });
            return false;
        }
    });
});
</script>

<style>
.modal-xl {
    max-width: 1200px;
}
</style>
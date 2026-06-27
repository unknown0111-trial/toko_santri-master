<form action="{{ url('/pembelian/ajax') }}" method="POST" id="form-tambah">
    @csrf
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Transaksi Pembelian</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Supplier</label>
                            <select name="supplier_id" class="form-control" required>
                                <option value="">- Pilih Supplier -</option>
                                @foreach($supplier as $s)
                                    <option value="{{ $s->supplier_id }}">{{ $s->nama_supplier }}</option>
                                @endforeach
                            </select>
                            <small id="error-supplier_id" class="error-text text-danger"></small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tanggal Pembelian</label>
                            <input type="date" name="tanggal_pembelian" class="form-control" value="{{ date('Y-m-d') }}" required>
                            <small id="error-tanggal_pembelian" class="error-text text-danger"></small>
                        </div>
                    </div>
                </div>

                <hr>
                <h5>Detail Kitab</h5>
                <div id="detail-kitab">
                    <div class="row mb-2" id="kitab-1">
                        <div class="col-md-4">
                            <select name="kitab_id[]" class="form-control kitab-select" required>
                                <option value="">- Pilih Kitab -</option>
                                @foreach($kitab as $k)
                                    <option value="{{ $k->kitab_id }}" data-harga="{{ $k->harga_beli }}">
                                        {{ $k->kode_kitab }} - {{ $k->judul_kitab }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="number" name="jumlah[]" class="form-control jumlah" placeholder="Jumlah" required>
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="harga_beli[]" class="form-control harga" placeholder="Harga Beli" required>
                        </div>
                        <div class="col-md-2">
                            <input type="text" name="subtotal[]" class="form-control subtotal" placeholder="Subtotal" readonly>
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn btn-danger btn-sm btn-remove">Hapus</button>
                        </div>
                    </div>
                </div>
                <div class="mt-2">
                    <button type="button" id="tambah-kitab" class="btn btn-sm btn-primary">Tambah Kitab</button>
                </div>

                <hr>
                <div class="row">
                    <div class="col-md-8"></div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Total Harga</label>
                            <input type="text" id="total_harga" class="form-control" readonly style="font-weight: bold; font-size: 1.2em;">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</form>

<script>
let kitabCount = 1;

$(document).ready(function() {
    // Hitung subtotal dan total
    function hitungTotal() {
        let total = 0;
        $('.subtotal').each(function() {
            let val = parseFloat($(this).val()) || 0;
            total += val;
        });
        $('#total_harga').val('Rp ' + total.toLocaleString('id-ID'));
        $('input[name="total_harga_hidden"]').remove();
        $('<input>').attr({
            type: 'hidden',
            name: 'total_harga',
            value: total
        }).appendTo('#form-tambah');
    }

    // Event untuk memilih kitab
    $(document).on('change', '.kitab-select', function() {
        let harga = $(this).find(':selected').data('harga');
        let row = $(this).closest('.row');
        row.find('.harga').val(harga);
        hitungSubtotal(row);
    });

    // Hitung subtotal per baris
    function hitungSubtotal(row) {
        let jumlah = row.find('.jumlah').val() || 0;
        let harga = row.find('.harga').val() || 0;
        let subtotal = jumlah * harga;
        row.find('.subtotal').val(subtotal);
        hitungTotal();
    }

    $(document).on('keyup', '.jumlah, .harga', function() {
        let row = $(this).closest('.row');
        hitungSubtotal(row);
    });

    // Tambah kitab
    $('#tambah-kitab').click(function() {
        kitabCount++;
        let newRow = `
            <div class="row mb-2" id="kitab-${kitabCount}">
                <div class="col-md-4">
                    <select name="kitab_id[]" class="form-control kitab-select" required>
                        <option value="">- Pilih Kitab -</option>
                        @foreach($kitab as $k)
                            <option value="{{ $k->kitab_id }}" data-harga="{{ $k->harga_beli }}">
                                {{ $k->kode_kitab }} - {{ $k->judul_kitab }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="number" name="jumlah[]" class="form-control jumlah" placeholder="Jumlah" required>
                </div>
                <div class="col-md-3">
                    <input type="text" name="harga_beli[]" class="form-control harga" placeholder="Harga Beli" required>
                </div>
                <div class="col-md-2">
                    <input type="text" name="subtotal[]" class="form-control subtotal" placeholder="Subtotal" readonly>
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-danger btn-sm btn-remove">Hapus</button>
                </div>
            </div>
        `;
        $('#detail-kitab').append(newRow);
    });

    // Hapus kitab
    $(document).on('click', '.btn-remove', function() {
        $(this).closest('.row').remove();
        hitungTotal();
    });

    // Validasi form
    $("#form-tambah").validate({
        rules: {
            supplier_id: { required: true, number: true },
            tanggal_pembelian: { required: true, date: true },
            'kitab_id[]': { required: true },
            'jumlah[]': { required: true, number: true, min: 1 },
            'harga_beli[]': { required: true, number: true, min: 0 }
        },
        submitHandler: function(form) {
            $.ajax({
                url: form.action,
                type: form.method,
                data: $(form).serialize(),
                success: function(response) {
                    if (response.status) {
                        $('#myModal').modal('hide');
                        Swal.fire({ icon: 'success', title: 'Berhasil', text: response.message });
                        $('#table-pembelian').DataTable().ajax.reload();
                    } else {
                        $('.error-text').text('');
                        $.each(response.msgField, function(prefix, val) {
                            $('#error-' + prefix).text(val[0]);
                        });
                        Swal.fire({ icon: 'error', title: 'Terjadi Kesalahan', text: response.message });
                    }
                }
            });
            return false;
        }
    });
});
</script>
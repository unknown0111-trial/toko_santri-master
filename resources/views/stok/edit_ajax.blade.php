<form action="{{ url('/stok/' . $kitab->kitab_id . '/update_ajax') }}" method="POST" id="form-edit">
    @csrf
    @method('PUT')
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Stok Kitab</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Kode Kitab</label>
                    <input type="text" class="form-control" value="{{ $kitab->kode_kitab }}" disabled>
                </div>
                <div class="form-group">
                    <label>Judul Kitab</label>
                    <input type="text" class="form-control" value="{{ $kitab->judul_kitab }}" disabled>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Stok Saat Ini</label>
                            <input type="number" name="stok" class="form-control" value="{{ $kitab->stok }}" required>
                            <small id="error-stok" class="error-text text-danger"></small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Stok Minimal</label>
                            <input type="number" name="stok_minimal" class="form-control" value="{{ $kitab->stok_minimal }}" required>
                            <small id="error-stok_minimal" class="error-text text-danger"></small>
                        </div>
                    </div>
                </div>
                @if($kitab->stok <= $kitab->stok_minimal && $kitab->stok > 0)
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i> Stok menipis! Segera lakukan pembelian.
                    </div>
                @endif
                @if($kitab->stok == 0)
                    <div class="alert alert-danger">
                        <i class="fas fa-times-circle"></i> Stok habis! Segera lakukan pembelian.
                    </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</form>

<script>
$(document).ready(function() {
    $("#form-edit").validate({
        rules: {
            stok: { required: true, number: true, min: 0 },
            stok_minimal: { required: true, number: true, min: 0 }
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
                        $('#table-stok').DataTable().ajax.reload();
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
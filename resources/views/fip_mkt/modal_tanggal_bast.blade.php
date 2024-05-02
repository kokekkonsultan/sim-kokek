<form class="form_default" method="POST" action="{{url('fip-mkt/ubah-tanggal-bast/' . Request::segment(3))}}">
    @csrf

    <div class="form-group">
        <label class="col-form-label font-weight-bold">Tanggal BAST <b class="text-danger">*</b></label>
        <input class="form-control" type="date" name="tanggal_bast" value="{{$fip->tanggal_bast}}" required>
    </div>

    <div class="text-right">
        <button type="button" class="btn btn-secondary btn-sm tombolCancel" data-dismiss="modal">Close</button>
        <button class="btn btn-primary font-weight-bold btn-sm tombolSubmit" type="submit">Simpan</button>
    </div>
</form>



<script>
$('.form_default').on('submit', function(e) {
    e.preventDefault();
    var formData = new FormData(this);
    // build the ajax call
    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: formData,
        beforeSend: function() {
            $('.tombolCancel').attr('disabled', 'disabled');
            $('.tombolSubmit').attr('disabled', 'disabled');
            $('.tombolSubmit').html(
                '<i class="fa fa-spin fa-spinner"></i> Sedang diproses');
        },
        complete: function() {
            $('.tombolCancel').removeAttr('disabled');
            $('.tombolSubmit').removeAttr('disabled');
            $('.tombolSubmit').html('Simpan');
        },
        success: function(response) {
            Swal.fire(
                'Sukses',
                'Berhasil mengubah data.',
                'success'
            );
            table.ajax.reload();
        },
        error: function(response) {
            alert('Error mengubah data.');
            table.ajax.reload();
        },
        contentType: false,
        processData: false
    });
})
</script>
<form class="form_default" method="POST" action="{{url('fip-mkt/edit-catatan/' . Request::Segment(3))}}">
    @csrf


    <div class="form-group row">
        <label class="col-3 col-form-label font-weight-bold">Tanggal Catatan <b class="text-danger">*</b></label>
        <div class="col-9">
            <input class="form-control" type="date" value="{{$cttn->tanggal_catatan}}" name="tanggal_catatan" required>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-3 col-form-label font-weight-bold">Isi Catatan <b class="text-danger">*</b></label>
        <div class="col-9">
            <textarea class="form-control" name="isi_catatan" id="edit_isi_catatan" rows="4">{!! $cttn->isi_catatan !!}</textarea>
        </div>
    </div>

    <hr>
    <div class="text-right">
        <button type="button" class="btn btn-secondary tombolCancel" data-dismiss="modal">Close</button>
        <button class="btn btn-primary font-weight-bold tombolSubmit" type="submit">Simpan</button>
    </div>

</form>


<script>
ClassicEditor
    .create(document.querySelector('#edit_isi_catatan'))
    .then(editor => {
        console.log(editor);
    })
    .catch(error => {
        console.error(error);
    });



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
            setTimeout( function(){
                    location.reload();
                }, 1200);
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
<form class="form_default" method="POST" action="{{url('daily-report/edit/' . $current->id)}}">
    @csrf

    @if($current->id_sub != '')
    <div class="form-group">
        <label class="col-form-label font-weight-bold">Tanggal <b class="text-danger">*</b></label>
        <input type="date" name="created_at" class="form-control" value="{{date('Y-m-d', strtotime($current->created_at))}}"
        min="{{date('Y-m-d')}}" required>
    </div>
    @endif

    <div class="form-group">
        <label class="col-form-label font-weight-bold">Aktivitas <b class="text-danger">*</b></label>
        <textarea name="aktivitas" rows="3" class="form-control" required>{{$current->aktivitas}}</textarea>
    </div>

    <div class="text-right">
        <button type="button" class="btn btn-secondary tombolCancel" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary tombolSubmit">Simpan</button>
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
            // handle error response
            alert('Error mengubah data.');
            table.ajax.reload();
        },
        contentType: false,
        processData: false
    });
})
</script>
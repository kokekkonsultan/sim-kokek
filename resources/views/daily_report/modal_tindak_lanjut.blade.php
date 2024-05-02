<form class="form_default" method="POST" action="{{url('daily-report/add_tindak_lanjut')}}">
    @csrf

    <h6 class="text-primary">Aktivitas Sebelumnya</h6>
    <hr>

    <input name="id" value="{{$current->id}}" hidden>


    <table class="table table-borderless">
        <tr>
            <th width="23%">Tanggal</th>
            <th width="5%">:</th>
            <td>{{date('d M Y', strtotime($current->created_at))}}</td>
        </tr>
        <tr>
            <th width="23%">Contact Person</th>
            <th width="5%">:</th>
            <td>{{$current->contact_person_name}}</td>
        </tr>
        <tr>
            <th width="23%">Organisasi</th>
            <th width="5%">:</th>
            <td>{{$current->organisasi}}</td>
        </tr>
        <tr>
            <th width="23%">Aktivitas</th>
            <th width="5%">:</th>
            <td>{{$current->aktivitas}}</td>
        </tr>
    </table>

   

    <br>
    <h6 class="text-primary">Tindak Lanjut Yang Dilakukan</h6>
    <hr>

    <div class="form-group row mb-5">
        <label class="col-sm-2 col-form-label font-weight-bold">Tindak Lanjut <b class="text-danger">*</b></label>
        <div class="col-sm-10">
            <textarea id="tindak_lanjut" name="tindak_lanjut" rows="5" class="form-control" required></textarea>
        </div>
    </div>

    <div class="form-group row mb-5">
        <label class="col-sm-2 col-form-label font-weight-bold">Tanggal <b class="text-danger">*</b></label>
        <div class="col-sm-10">
            <input type="date" name="follow_up_date" min="{{date('Y-m-d', strtotime($current->created_at))}}" class="form-control" required>
        </div>
    </div>

    <hr>
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
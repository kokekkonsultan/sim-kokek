<div class="modal-header bg-light">
    <h6 class="font-weight-bold">Pilih PIC | <b>Pekerjaaan {{$fip->kode}}</b></h6>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">X</button>
</div>
<div class="modal-body" id="bodyModalEdit">

    <form class="form_default" method="POST" action="{{url('fip-mo/tunjuk-pic/' . $fip->id_fip)}}">
        @csrf

        <div class="form-group row mb-5">
            <label class="col-sm-2 col-form-label font-weight-bold">PIC Adpro <b class="text-danger">*</b></label>
            <div class="col-sm-10">
                <select class="form-control" name="id_admin_proyek" required>
                    <option value="">Please Select</option>
                    @foreach(collect(DB::select("SELECT users.id AS users_id, CONCAT(users.first_name, ' ', users.last_name) AS users_name, person_authentication.id_person AS id_person
                    FROM users
                    JOIN users_groups ON users_groups.user_id = users.id
                    JOIN groups ON groups.id = users_groups.group_id
                    JOIN person_authentication ON person_authentication.id_user = users.id
                    WHERE groups.name = 'adpro' AND users.active = 1")) as $row)
                    <option value="{{$row->id_person}}" {{$fip->id_pic_adpro == $row->id_person ? 'selected' : ''}}>{{$row->users_name}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group row mb-5">
            <label class="col-sm-2 col-form-label font-weight-bold">PIC Konsultan <b class="text-danger">*</b></label>
            <div class="col-sm-10">
                <select class="form-control" name="id_konsultan" required>
                    <option value="">Please Select</option>
                    @foreach(collect(DB::select("SELECT users.id AS users_id, CONCAT(users.first_name, ' ', users.last_name) AS users_name, person_authentication.id_person AS id_person
                    FROM users
                    JOIN users_groups ON users_groups.user_id = users.id
                    JOIN groups ON groups.id = users_groups.group_id
                    JOIN person_authentication ON person_authentication.id_user = users.id
                    WHERE groups.name = 'konsultan' AND users.active = 1")) as $row)
                    <option value="{{$row->id_person}}" {{$fip->id_pic_konsultan == $row->id_person ? 'selected' : ''}}>{{$row->users_name}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <hr>
        <div class="text-right">
            <button type="button" class="btn btn-secondary tombolCancel" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary tombolSubmit">Simpan</button>
        </div>
    </form>
</div>




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
                'Berhasil menyimpan data.',
                'success'
            );
            table.ajax.reload();
        },
        error: function(response) {
            // handle error response
            alert('Error menyimpan data.');
            table.ajax.reload();
        },
        contentType: false,
        processData: false
    });
})
</script>
<form class="form_default" method="POST" action="{{url('fip-mkt/edit-biaya/' . $fip_biaya->id_fip_biaya)}}">
    @csrf


    <input name="id_fip" value="{{$fip_biaya->id_fip}}" hidden>

    <div class="mb-3">
        <label class="col-form-label font-weight-bold">Jenis Biaya <b class="text-danger">*</b></label>
        <select class="form-control" name="id_jenis_fip_biaya" required>
            <option value="1" {{$fip_biaya->id_jenis_fip_biaya == 1 ? 'selected' : ''}}>Biaya Personil</option>
            <option value="2" {{$fip_biaya->id_jenis_fip_biaya == 2 ? 'selected' : ''}}>Biaya Non Personil</option>
        </select>
    </div>

    <div class="mb-3">
        <label class="col-form-label font-weight-bold">Uraian <b class="text-danger">*</b></label>
        <input class="form-control" name="uraian" value="{{$fip_biaya->uraian}}"
            placeholder="Masukkan uraian biaya, Contoh : Biaya Akomodasi / Biaya Cetak Sertifikat" required>
    </div>

    <div class="row mb-3">
        <div class="col-6">
            <label class="col-form-label font-weight-bold">Volume 1 <b class="text-danger">*</b></label>
            <input class="form-control edit_hitung" type="number" name="volume1" id="edit_volume1" placeholder="Contoh : 4"
               value="{{$fip_biaya->volume1}}" required>
        </div>
        <div class="col-6">
            <label class="col-form-label font-weight-bold">Satuan 1 <b class="text-danger">*</b></label>
            <input class="form-control" type="text" name="satuan1" value="{{$fip_biaya->satuan1}}" placeholder="Contoh : Orang" required>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-6">
            <label class="col-form-label font-weight-bold">Volume 2</label>
            <input class="form-control edit_hitung" type="number" placeholder="Contoh : 2" name="volume2" value="{{$fip_biaya->volume2}}" id="edit_volume2">
        </div>
        <div class="col-6">
            <label class="col-form-label font-weight-bold">Satuan 2</label>
            <input class="form-control" type="text" placeholder="Contoh : Kamar, dll." name="satuan2" value="{{$fip_biaya->satuan2}}">
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-6">
            <label class="col-form-label font-weight-bold">Volume 3</label>
            <input class="form-control edit_hitung" type="number" name="volume3" id="edit_volume3" value="{{$fip_biaya->volume3}}">
        </div>
        <div class="col-6">
            <label class="col-form-label font-weight-bold">Satuan 3</label>
            <input class="form-control" type="text" name="satuan3" value="{{$fip_biaya->satuan1}}">
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-6">
            <label class="col-form-label font-weight-bold">Harga Satuan <b class="text-danger">*</b></label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Rp.</span>
                </div>
                <input class="form-control edit_hitung" type="number" name="harga_satuan" id="edit_harga_satuan" value="{{$fip_biaya->harga_satuan}}" required>
            </div>
        </div>
        <div class="col-6">
            <label class="col-form-label font-weight-bold">Jumlah <b class="text-danger">*</b></label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Rp.</span>
                </div>
                <input class="form-control" type="text" name="jumlah" id="edit_jumlah" value="{{$fip_biaya->jumlah}}" required>
            </div>
        </div>
    </div>

    <div class="mb-3">
        <label class="col-form-label font-weight-bold">Keterangan</label>
        <textarea class="form-control" name="keterangan" rows="4">{{$fip_biaya->keterangan}}</textarea>
    </div>


    <hr>
    <div class="text-right">
        <button type="button" class="btn btn-secondary tombolCancel" data-dismiss="modal">Close</button>
        <button class="btn btn-primary font-weight-bold tombolCancel" type="submit">Simpan</button>
    </div>

</form>


<script>
    $(".edit_hitung").keyup(function() {
        var edit_volume1 = $("#edit_volume1").val() == 0 ? 1 : $("#edit_volume1").val();
        var edit_volume2 = $("#edit_volume2").val() == 0 ? 1 : $("#edit_volume2").val();
        var edit_volume3 = $("#edit_volume3").val() == 0 ? 1 : $("#edit_volume3").val();
        var edit_harga_satuan = $("#edit_harga_satuan").val();
        var edit_total = (edit_volume1 * edit_volume2 * edit_volume3) * edit_harga_satuan;

        // console.log(total);
        $("#edit_jumlah").val(new Intl.NumberFormat(["ban", "id"]).format(edit_total));
    });
</script>
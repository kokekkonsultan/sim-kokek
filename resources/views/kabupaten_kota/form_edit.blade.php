@extends('include_backend/template_backend')

@section('style')

@endsection

@section('content')
<div class="container">

<div class="card">
	<div class="card-header">
		Edit Kabupaten Kota
	</div>
	<div class="card-body">

<form action='{{ url('kabupaten-kota/'.$data->id_kota_kab_indonesia) }}' method='post'>
@csrf
@method('PUT')
    <div class="mb-3 row">
        <label for="nama_kota_kab_indonesia" class="col-sm-2 col-form-label">Nama Kabupaten/ Kota <span class="text-danger">*</span></label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name='nama_kota_kab_indonesia' value="{{ $data->nama_kota_kab_indonesia }}" id="nama_kota_kab_indonesia">
        </div>
    </div>

    <div class="mb-3 row">
        <label for="nama_kota_kab_indonesia" class="col-sm-2 col-form-label">Nama Provinsi <span class="text-danger">*</span></label>
        <div class="col-sm-10">
            <select name="provinsi" id="provinsi" class="form-control" required>
            	<option value="">Pilih Provinsi</option>
            	@foreach ($provinsi as $val)
            		<option value="{{ $val->id_provinsi_indonesia }}" {{ $val->id_provinsi_indonesia == $data->provinsi['id_provinsi_indonesia'] ? "selected" : "" }} >{{ $val->nama_provinsi_indonesia }}</option>
            	@endforeach
            </select>
        </div>
    </div>

    <div class="mb-3 row">
        <label for="jurusan" class="col-sm-2 col-form-label"></label>
        <div class="col-sm-10"><button type="submit" class="btn btn-primary" name="submit">Simpan</button></div>
    </div>

</form>

	</div>
</div>

<div class="mt-5">
	<a href="/kabupaten-kota">Kembali</a>
</div>

</div>
@endsection

@section('javascript')
<script>
// Class definition
var KTSelect2 = function() {
 // Private functions
 var demos = function() {
  // basic
  $('#provinsi').select2({
   placeholder: "Pilih Provinsi"
  });
 }

 // Public functions
 return {
  init: function() {
   demos();
   modalDemos();
  }
 };
}();

// Initialization
jQuery(document).ready(function() {
 KTSelect2.init();
});
</script>
@endsection

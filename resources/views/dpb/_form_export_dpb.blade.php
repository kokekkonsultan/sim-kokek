@extends('include_backend/template_backend')

@section('style')

@endsection

@section('content')
<div class="container">
	
	<form method="post" action="{{ route('proses-export-dpb') }}">
		@csrf

		@php
	    $year = [];
	    for ($i = 2019; $i <= config('app.tahun_program')+1; $i++) { $year[]=$i; } rsort($year); @endphp 
	    <select name="tahun_anggaran" id="tahun_anggaran" class="form-control" required>
	      <option value="">Pilih Tahun</option>
	      @foreach ($year as $value)
	      <option value="{{ $value }}">{{ $value }}</option>
	      @endforeach
	     </select>

	     <br>
	     
	     <button type="submit" class="btn btn-primary font-weight-bold shadow">Submit</button>
	</form>

</div>
@endsection

@section('javascript')

@endsection
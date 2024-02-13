@extends('include_backend/template_backend')

@section('style')

@endsection

@section('content')
<div class="container">

	
<div class="card">
	<div class="card-header">
		Kabupaten Kota
	</div>
	<div class="card-body">
	<div class="pb-3">
        <form class="d-flex" action="{{ url('kabupaten-kota') }}" method="get">
            <input class="form-control me-1" type="search" name="keyword" value="{{ Request::get('keyword') }}" placeholder="Masukkan kata kunci" aria-label="Search">
            <button class="btn btn-secondary" type="submit">Cari</button>
        </form>
    </div>
    
		<div class="mt-5 mb-5 text-right">
			<a href='{{ url('kabupaten-kota/create') }}' class="btn btn-primary">Tambah Kota Kabupaten</a>
		</div>
		<table class="table">
			<tr>
				<th>No</th>
				<th>Kabupaten/ Kota</th>
				<th>Provinsi</th>
				<th></th>
			</tr>
			@foreach ($data as $value)
			<tr>
				<td>{{ ++$i }}</td>
				<td>{{ $value->nama_kota_kab_indonesia }}</td>
				<td>{{ $value->provinsi['nama_provinsi_indonesia'] }}</td>
				<td>
					<a href='{{ url('kabupaten-kota/'.$value->id_kota_kab_indonesia.'/edit') }}' class="">Edit</a>
					<form onsubmit="return confirm('Yakin akan menghapus data `{{ $value->nama_kota_kab_indonesia }}`?')" class='d-inline' action="{{ url('kabupaten-kota/'.$value->id_kota_kab_indonesia) }}" method="post">
                        @csrf 
                        @method('DELETE')
                        <button type="submit" name="submit" class="btn text-danger">Delete</button>
                    </form>
				</td>
			</tr>
			@endforeach
		</table>

		<br>
		{{ $data->links() }}
	</div>
</div>

</div>
@endsection

@section('javascript')

@endsection
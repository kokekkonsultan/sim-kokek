<p>
	<table class="table">
		<tr>
			<th>No.</th>
			<th>Keterangan Perubahan</th>
			<th>Tanggal</th>
			<th>PIC</th>
		</tr>
		@php
		$no = 1;
		@endphp
	@foreach($riwayat_dpb as $value)
		<tr>
			<td>{{ $no++ }}</td>
			<td>{{ $value->keterangan_perubahan }}</td>
			<td>{{ \Carbon\Carbon::parse($value->tanggal_perubahan_revisi)->isoFormat('D MMMM Y hh:mm A') }}</td>
			<td>{{ get_name($value->pic) }}</td>
		</tr>
	@endforeach
	</table>
</p>
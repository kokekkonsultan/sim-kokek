@extends('include_backend/template_backend')

@section('style')
<link href="{{ asset('assets/themes/metronic/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
{{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.css"> --}}
@endsection

@section('content')

<div class="container-fluid">
	<div class="card">
		<div class="card-header">DPB</div>
		<div class="card-body">
			<div class="pb-3">
		        <form class="d-flex" action="{{ url('dpb') }}" method="get">
		            {{-- <input class="form-control me-1" type="search" name="keyword" value="{{ Request::get('keyword') }}" placeholder="Masukkan kata kunci" aria-label="Search"> --}}
		            @php
		              $year = [];

		              for ($i = 2004; $i <= date('Y'); $i++) {
		                $year[] = $i;
		              }

		              rsort($year);
		            @endphp
		            <select name="keyword" id="keyword" class="form-control">
		              <option value="">Pilih Tahun</option>
		              @foreach ($year as $value)
		                <option value="{{ $value }}" {{ (Request::get('keyword') == $value) ? 'selected' : '' }}>{{ $value }}</option>
		              @endforeach
		            </select>
		            <button class="btn btn-secondary" type="submit">Cari</button>
		        </form>
		    </div>

		    <div class="table-responsive">
			<table class="table table-hover table-bordered" id="table_id">
				<thead>
				<tr class="table-secondary">
					<th>No.</th>
					<th>Kode</th>
					<th>Jenis</th>
					<th>Bidang/ Sub Bidang Pekerjaan</th>
					<th>Pemberi Kerja</th>
					<th>Nama Pekerjaan</th>
					<th>Nilai Kontrak (Rp.)</th>
					<th>Perubahan Nilai Kontrak (Rp.)</th>
					<th>Termin Pembayaran</th>
					<th>Durasi Kontrak Pekerjaan</th>
					<th>Tanggal Terima Kontrak</th>
					<th>Tanggal Terima Surat Referensi</th>
					<th>Tanggal Terima BAST</th>
					<th>PIC</th>
					<th>Perubahan Terakhir</th>
					<th>Keterangan DPB</th>
				</tr>
				</thead>
				@php
					$no = 1;
				@endphp
				@foreach ($data as $value)
				@php
					if ($value->kode_dpb != '') {

						// KODE DPB
						$kode_dpb = '';

						// DURASI
						$ht_hari = $value->durasi_pekerjaan % 30;
						$hari = ($ht_hari != 0) ? $ht_hari . ' hari' : '';
						$ht_bulan = floor($value->durasi_pekerjaan / 30);
						$bulan = ($ht_bulan != 0) ? $ht_bulan . ' bulan' : '';
						$durasi = "(" . $bulan . ' ' . $hari . ")";

						// Tanggal Terima Kontrak

						$tgl_kontrak = \Carbon\Carbon::parse($value->tgl_terima_kontrak)->isoFormat('D MMMM Y').' <a href="daftar_proyek_berjalan/tanggal_kontrak_diterima/'.$value->id_dpb.'" title="" target="popup" onclick="window.open(`/daftar_proyek_berjalan/tanggal_kontrak_diterima/'.$value->id_dpb.'`,`popup`,`width=600,height=600,scrollbars=no,resizable=no`); return false;"><i class="fas fa-exchange-alt"></i></a>';

						// Tanggal Surat Referensi

						// $tgl_surat_referensi = ($value->tgl_terima_surat_referensi != '') ? \Carbon\Carbon::parse($value->tgl_terima_surat_referensi)->isoFormat('D MMMM Y') : ''.' <a href="daftar_proyek_berjalan/surat_referensi/'.$value->id_dpb.'" title="" target="_blank"><i class="fas fa-exchange-alt"></i></a>';
						$tgl_surat_referensi = ($value->tgl_terima_surat_referensi != '') ? \Carbon\Carbon::parse($value->tgl_terima_surat_referensi)->isoFormat('D MMMM Y') : '';
						$tgl_surat_referensi .= ' <a href="daftar_proyek_berjalan/surat_referensi/'.$value->id_dpb.'" title="" target="popup" onclick="window.open(`/daftar_proyek_berjalan/surat_referensi/'.$value->id_dpb.'`,`popup`,`width=600,height=600,scrollbars=no,resizable=no`); return false;"><i class="fas fa-exchange-alt"></i></a>';

						$pt_update_id = '';

						$publish_link = '';





						$tanggal_dpb = $value->created_at;

					    // add 5 days to the current time
					    $tambah_tanggal = \Carbon\Carbon::parse($tanggal_dpb)->addDays(5)->format('Y-m-d');

					    $period = \Carbon\CarbonPeriod::create($tanggal_dpb, $tambah_tanggal);

					    $range = [];
					    // Iterate over the period
					    foreach ($period as $date) {
					        $range[] = $date->format('Y-m-d');
					    }

					    $sekarang = \Carbon\Carbon::now()->format('Y-m-d');
					    // dd($tambah_tanggal);

					    if (in_array($sekarang, $range)) {
					        // Jika range ada

					        $pt_update_id = '<span class="text-success">' . \Carbon\Carbon::parse($value->tanggal_perubahan_terakhir)->isoFormat('D MMMM Y hh:mm A') . '<br>Oleh ' . $value->perubahan_terakhir_oleh . ' </span><br>' . '<span type="" style="cursor: pointer;" class="text-primary" data-toggle="modal" data-target="#detail_perubahan_dpb" data-placement="top" data-id="' . $value->id_dpb . '" title="Informasi Perubahan DPB">Info Perubahan</span>';

					        $publish_link = '
							<li class="navi-item">
				                <a href="javascript:void(0)" class="navi-link" onclick="publish_dpb(' . "'" . $value->id_dpb . "'" . ')">
				                    <span class="navi-icon"><i class="la la-arrow-right"></i></span>
				                    <span class="navi-text">Publish ' . $value->jumlah_publish . '</span>
				                </a>
				            </li>
					 		';

					    } else {
					        // Jika range tidak ada

					        $pt_update_id = \Carbon\Carbon::parse($value->tanggal_perubahan_terakhir)->isoFormat('D MMMM Y hh:mm A') . '<br>Oleh ' . $value->perubahan_terakhir_oleh . ' <br>' . '<span type="" style="cursor: pointer;" class="text-primary" data-toggle="modal" data-target="#detail_perubahan_dpb" data-placement="top" data-id="' . $value->id_dpb . '" title="Informasi Perubahan DPB">Info Perubahan</span>';

					        $publish_link = '
							<li class="navi-item">
				                <a href="javascript:void(0)" class="navi-link" onclick="publish_dpb(' . "'" . $value->id_dpb . "'" . ')">
				                    <span class="navi-icon"><i class="la la-arrow-right"></i></span>
				                    <span class="navi-text">Publish ' . $value->jumlah_publish . '</span>
				                </a>
				            </li>
					 		';

					    }



						


					} else {

						// KODE DPB
						$kode_dpb = '';

						// DURASI
						$durasi = '';

						// Tanggal Terima Kontrak

						$tgl_kontrak = '';

						// Tanggal Surat Referensi

						$tgl_surat_referensi = '';

						$pt_update_id = '';

						$publish_link = '';




					}
				@endphp
				<tbody>
				<tr>
					<td>{{ $no++ }}</td>
					<td>
<b class="text-dark" style="font-size: 16px;">{{ $value->kode_dpb }}</b><br>
<div class="dropdown dropdown-inline">
    <a href="javascript:;" class="btn btn-sm btn-clean btn-icon mr-2" data-toggle="dropdown">
        <span class="svg-icon svg-icon-md">
            <!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Communication\Reply-all.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <rect x="0" y="0" width="24" height="24"/>
        <path d="M8.29606274,4.13760526 L1.15599693,10.6152626 C0.849219196,10.8935795 0.826147139,11.3678924 1.10446404,11.6746702 C1.11907213,11.6907721 1.13437346,11.7062312 1.15032466,11.7210037 L8.29039047,18.333467 C8.59429669,18.6149166 9.06882135,18.596712 9.35027096,18.2928057 C9.47866909,18.1541628 9.55000007,17.9721616 9.55000007,17.7831961 L9.55000007,4.69307548 C9.55000007,4.27886191 9.21421363,3.94307548 8.80000007,3.94307548 C8.61368984,3.94307548 8.43404911,4.01242035 8.29606274,4.13760526 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
        <path d="M23.2951173,17.7910156 C23.2951173,16.9707031 23.4708985,13.7333984 20.9171876,11.1650391 C19.1984376,9.43652344 16.6261719,9.13671875 13.5500001,9 L13.5500001,4.69307548 C13.5500001,4.27886191 13.2142136,3.94307548 12.8000001,3.94307548 C12.6136898,3.94307548 12.4340491,4.01242035 12.2960627,4.13760526 L5.15599693,10.6152626 C4.8492192,10.8935795 4.82614714,11.3678924 5.10446404,11.6746702 C5.11907213,11.6907721 5.13437346,11.7062312 5.15032466,11.7210037 L12.2903905,18.333467 C12.5942967,18.6149166 13.0688214,18.596712 13.350271,18.2928057 C13.4786691,18.1541628 13.5500001,17.9721616 13.5500001,17.7831961 L13.5500001,13.5 C15.5031251,13.5537109 16.8943705,13.6779456 18.1583985,14.0800781 C19.9784273,14.6590944 21.3849749,16.3018455 22.3780412,19.0083314 L22.3780249,19.0083374 C22.4863904,19.3036749 22.7675498,19.5 23.0821406,19.5 L23.3000001,19.5 C23.3000001,19.0068359 23.2951173,18.2255859 23.2951173,17.7910156 Z" fill="#000000" fill-rule="nonzero"/>
    </g>
</svg>
        </span>
    </a>
    <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
        <ul class="navi flex-column navi-hover py-2">
            <li class="navi-header font-weight-bolder text-uppercase font-size-xs text-primary pb-2">
                Choose an action:
            </li>
            <li class="navi-item">
                <a href="daftar_proyek_berjalan/rincian_proyek_berjalan/{{ $value->id_dpb }}" class="navi-link" target="_blank">
                    <span class="navi-icon"><i class="la la-arrow-right"></i></span>
                    <span class="navi-text">Rincian DPB</span>
                </a>
            </li>
            {!! $publish_link !!}
            <li class="navi-item">
                <a href="daftar_proyek_berjalan/edit_redirection_pic/{{ $value->id_dpb }}" class="navi-link">
                    <span class="navi-icon"><i class="la la-arrow-right"></i></span>
                    <span class="navi-text">Edit</span>
                </a>
            </li>
        </ul>
    </div>
</div>
					</td>
					<td><b style="color: #000000;">{{ $value->jenis_pekerjaan_dpb }}</b></td>
					<td>{{ $value->nama_bidang_pekerjaan }}</td>
					<td>{{ get_nama_pemberi_kerja($value->nama_pemberi_kerja, $value->pemberi_kerja_parent, $value->nama_kategori_instansi_dari_parent)  }}<br><span class="text-dark">{{ $value->nomor_kontrak }}</span></td>
					<td><a href="/rekap_daftar_proyek_berjalan/rincian_proyek_berjalan/{{ $value->id_dpb }}" target="_blank"><span style="color: #CB000D;" class="font-weight-bold">{{ $value->nama_pekerjaan }}</span></a></td>
					<td><div style="color:red; font-size: 14px; font-weight: bold;">{{ number_format($value->nilai_kontrak, 0, ".", ".") }}</div></td>
					<td>{{ $value->perubahan_nilai_kontrak }}</td>
					<td>{{ $value->jumlah_termin_pembayaran }}</td>
					<td>{{ \Carbon\Carbon::parse($value->jangka_waktu_mulai)->isoFormat('D MMMM Y') }} <span class="text-danger">sd</span> {{ \Carbon\Carbon::parse($value->jangka_waktu_selesai)->isoFormat('D MMMM Y') }} <br><span class="font-weight-bold text-dark">{{ $durasi }}</span></td>
					<td>{!! $tgl_kontrak !!}</td>
					<td>{!! $tgl_surat_referensi !!}</td>
					<td>{{ \Carbon\Carbon::parse($value->tgl_terima_bast)->isoFormat('D MMMM Y') }}</td>
					<td>{{ $value->pic_dpb }}</td>
					<td>{!! $pt_update_id !!}</td>
					<td>{{ $value->keterangan_dpb }}</td>
				</tr>
				</tbody>
				@endforeach
			</table>
			</div>
		</div>
	</div>
</div>


<!-- Modal Perubahan DPB -->
<div class="modal fade" id="detail_perubahan_dpb" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Informasi Perubahan Terakhir DPB</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="fetched-data"></div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('javascript')
<script src="{{ asset('assets/themes/metronic/plugins/custom/datatables/datatables.bundle.js') }}"></script>
{{-- <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script> --}}

<script>
// Class definition
var KTSelect2 = function() {
 // Private functions
 var demos = function() {
  // basic
  $('#keyword').select2({
   placeholder: "Pilih Tahun"
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

<script>
$(document).ready(function() {

	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

    $('#detail_perubahan_dpb').on('show.bs.modal', function(e) {
      var rowid = $(e.relatedTarget).data('id');
      $.ajax({
        type: 'post',
        url: '{{ route('detail.dpb') }}',
        data: 'rowid=' + rowid,
        success: function(data) {
          $('.fetched-data').html(data);
        }
      });
    });

});
</script>
<script>
$(document).ready( function () {
	$('#table_id').DataTable();
});
</script>
@endsection
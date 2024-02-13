@extends('include_backend/template_backend')

@section('style')
<link href="{{ asset('assets/themes/metronic/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@300;400;500;700&family=Inter:wght@100;400;700&display=swap" rel="stylesheet">

<style>
    table{
        font-family: 'Inter', sans-serif;

    }
    table > thead{
        background-color: #f3f3f3;
    }
  
</style>
@endsection

@section('content')
@php
    use Illuminate\Support\Facades\DB;
@endphp
<div class="container-fluid">
    <div class="card card-custom">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">
                    Pengalaman Perusahaan
                </h3>
            </div>
            <div class="card-toolbar">
                <button type="button" class="btn btn-primary btn-sm font-weight-bold mb-5" data-toggle="modal" data-target="#exampleModal">
                    Filter
                </button>
                &nbsp;
                <a href="/pengalaman-perusahaan" class="btn btn-light-primary btn-sm font-weight-bold mb-5">Reset</a>
            </div>
        </div>
        <div class="card-body">

            <div class="text-right">
            </div>


            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Filter Pengalaman Pekerjaan</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                      </button>
                    </div>
                    <div class="modal-body">

                        <form class="" action="/pengalaman-perusahaan" method="post">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">

                                    <h3>Filter Berdasarkan Jenis Pekerjaan</h3>
                                    <label for="">Jenis Pekerjaan</label>
                                    <div class="text-left" style="height: 180px; overflow: auto; border: 1px solid #DDDDDD; padding: 10px; border-radius: 5px;">
                                        @foreach ($data_jenis_pekerjaan as $jenis_pekerjaan)
                                            <label><input type="checkbox" name="jenis_pekerjaan[]" value="{{ $jenis_pekerjaan->id_jenis_pekerjaan }}"
                                                @if (Request::get('jenis_pekerjaan'))
                                                {{in_array($jenis_pekerjaan->id_jenis_pekerjaan, Request::get('jenis_pekerjaan')) ? 'checked' : ''}}
                                                @endif
                                                > {{ $jenis_pekerjaan->nama_jenis_pekerjaan }}</label><br>
                                        @endforeach

                                    </div>
                                    <br>
                                    <h3>Filter Berdasarkan Bidang Pekerjaan</h3>
                                    <p>
                                        <label for="" class="font-weight-bold">Pilih Bidang Pekerjaan</label>
                                        {{-- <select name="bidang_pekerjaan[]" id="" multiple>
                                            <option value="">Please Select</option>
                                            @foreach ($bidang_pekerjaan as $value)
                                            <option value="{{ $value->id_bidang_pekerjaan }}">{{ $value->nama_bidang_pekerjaan }}</option>
                                            @endforeach
                                        </select> --}}
                                        <br>
                                        <div class="text-left" style="height: 180px; overflow: auto; border: 1px solid #DDDDDD; padding: 10px; border-radius: 5px;">
                                            @foreach ($bidang_pekerjaan as $value)
                                                <label><input type="checkbox" name="bidang_pekerjaan[]" value="{{ $value->id_bidang_pekerjaan }}"
                                                    @if (Request::get('bidang_pekerjaan'))
                                                    {{in_array($value->id_bidang_pekerjaan, Request::get('bidang_pekerjaan')) ? 'checked' : ''}}
                                                    @endif
                                                    > {{ $value->nama_bidang_pekerjaan }}</label><br>
                                            @endforeach
                                        </div>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <h3>Filter Berdasarkan Tahun</h3>
                                    <p>
                                        <label for="">Tahun Mulai</label>
                                        {{-- <input type="text" name="tahun_mulai" value="{{ Request::get('tahun_mulai') }}"> --}}

                                        @php
                                        $year = [];

                                        for ($i = 2004; $i <= date('Y'); $i++) {
                                            $year[] = $i;
                                        }

                                        @endphp
                                        <select name="tahun_mulai" id="tahun_mulai" class="form-control form-control-sm">
                                            <option value="">Please Select</option>


                                          @foreach ($year as $value)
                                              <option value="{{ $value }}" {{ $value == Request::get('tahun_mulai') ? "selected" : "" }}>{{ $value }}</option>
                                          @endforeach


                                      </select>

                                    </p>
                                    <p>
                                        <label for="">Tahun Sampai</label>
                                        @php
                                            $year = [];

                                            for ($i = 2004; $i <= date('Y'); $i++) {
                                                $year[] = $i;
                                            }

                                            rsort($year);
                                        @endphp
                                        {{-- <input type="text" name="tahun_sampai" value="{{ Request::get('tahun_sampai') }}"> --}}

                                        <select name="tahun_sampai" id="tahun_sampai" class="form-control form-control-sm">
                                            <option value="">Please Select</option>

                                            @foreach ($year as $value)
                                              <option value="{{ $value }}" {{ $value == Request::get('tahun_sampai') ? "selected" : "" }}>{{ $value }}</option>
                                          @endforeach

                                    </select>
                                    </p>

                                    <h3>Filter Berdasarkan Nilai Kontrak</h3>
                                    <p>
                                        <label for="">Nilai Kontrak Dari</label>
                                        <input type="text" name="nilai_kontrak_dari" id="nilai_kontrak_dari" class="form-control form-control-sm" value="{{ Request::get('nilai_kontrak_dari') }}" placeholder="5.000.000" />
                                    </p>
                                    <p>
                                        <label for="">Nilai Kontrak Sampai</label>
                                        <input type="text" name="nilai_kontrak_sampai" id="nilai_kontrak_sampai" class="form-control form-control-sm" value="{{ Request::get('nilai_kontrak_sampai') }}" placeholder="10.000.000" />
                                    </p>


                                    <div class="mt-5">
                                        <h3>Filter Berdasarkan Nilai Pekerjaan</h3>
                                        <label for="">Pengurutan Nilai Pekerjaan</label>
                                        <select name="pengurutan_nilai_pekerjaan" id="" class="form-control form-control-sm">
                                            <option value="">Pengurutan Nilai Pekerjaan</option>
                                            <option value="Ascending" {{ Request::get('pengurutan_nilai_pekerjaan') == 'Ascending' ? 'selected' : '' }}>Ascending (Kecil ke besar)</option>
                                            <option value="Descending" {{ Request::get('pengurutan_nilai_pekerjaan') == 'Descending' ? 'selected' : '' }}>Descending (Besar ke kecil)</option>
                                        </select>
                                    </div>

                                </div>
                            </div>
                            <div class="row mt-5">
                                <div class="col-md-3">


                                </div>
                                <div class="col-md-3"></div>
                                <div class="col-md-3"></div>

                                <div class="col-md-3">
                                    <button class="btn btn-sm btn-primary btn-block font-weight-bold" type="submit">Filter</button>
                                </div>
                            </div>



                        </form>

                        <script type="text/javascript">
                            var nilai_kontrak_dari = document.getElementById('nilai_kontrak_dari');
                            nilai_kontrak_dari.addEventListener('keyup', function(e)
                            {
                                nilai_kontrak_dari.value = formatRupiah(this.value);
                            });

                            var nilai_kontrak_sampai = document.getElementById('nilai_kontrak_sampai');
                            nilai_kontrak_sampai.addEventListener('keyup', function(e)
                            {
                                nilai_kontrak_sampai.value = formatRupiah(this.value);
                            });

                            function formatRupiah(angka, prefix)
                            {
                                var number_string = angka.replace(/[^,\d]/g, '').toString(),
                                    split	= number_string.split(','),
                                    sisa 	= split[0].length % 3,
                                    rupiah 	= split[0].substr(0, sisa),
                                    ribuan 	= split[0].substr(sisa).match(/\d{3}/gi);

                                if (ribuan) {
                                    separator = sisa ? '.' : '';
                                    rupiah += separator + ribuan.join('.');
                                }

                                rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                                return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
                            }
                        </script>

                    </div>
                  </div>
                </div>
              </div>


            <form action="{{ url('pengalaman-perusahaan/generate-chart') }}" method="POST" target="_blank">

            @csrf

            <div class="mb-5 text-right">
                <button class="btn btn-sm btn-secondary font-weight-bold" type="submit">Generate Chart</button>
            </div>


            <div class="table-responsive">
                <table id="example" class="table table-hover display compact" cellspacing="0" width="100%" style="font-size: 12px;">
                <thead class="thead">
                    <tr>
                        <th>No</th>
                        <th>Tahun</th>
                        <th>Nama Pekerjaan</th>
                        <th>Bidang/ Sub Bidang Pekerjaan</th>
                        <th>Lokasi</th>
                        <th>Organisasi Pengguna Jasa</th>
                        <th>No Kontrak</th>
                        <th>Nilai Kontrak (Rp.)</th>
                        <th>Tanggal Mulai Kontrak</th>
                        <th>Tanggal Selesai Kontrak</th>
                        <th>Tanggal BAST</th>
                        <th>Durasi Pekerjaan</th>
                    </tr>
                </thead>
                <tbody>
            @php
                $no = 1;
                $data_pengalaman->lazy()->each(function (object $item) use (&$no) {


                // CEK LOKASI PEKERJAAN
                if ($item->is_dpb == 1) {
                        // DPB
                        $lokasi = $item->lokasi;

                    } else {

                        // MANUAL
                        if ($item->id_lokasi == null) {
                            $lokasi = $item->lokasi;
                        } else {

                            $get_obj_pengalaman_manual = DB::select("
                            SELECT branch_agency.branch_name
                            FROM objek_pekerjaan_pengalaman_perusahaan
                            JOIN branch_agency ON branch_agency.id_branch_agency = objek_pekerjaan_pengalaman_perusahaan.organization
                            WHERE id_data_pengalaman = ".$item->lokasi."
                            ");

                            $sez_pengalaman_manual = [];
                            foreach ($get_obj_pengalaman_manual as $val) {
                                $sez_pengalaman_manual[] = $val->branch_name;
                            }

                            $lokasi = implode(", ", $sez_pengalaman_manual);
                        }
                    }



                    // CEK TGL BAST
                    if ($item->tgl_bast) {
                        $tg_bast = date('d/m/Y', strtotime($item->tgl_bast));
                    } else {
                        $tg_bast = '-';
                    }

                    // DURASI
                    $ht_hari = $item->durasi_pekerjaan % 30;
                    $hari = ($ht_hari != 0)? $ht_hari.' hari' : '';
                    $ht_bulan = floor($item->durasi_pekerjaan/30);
                    $bulan = ($ht_bulan != 0)? $ht_bulan.' bulan' : '';
                    $durasi = $bulan.' '.$hari;
            @endphp
                <tr>
                    <td>
                        {{ $no++ }}
                        <input type="hidden" name="nama_pekerjaan[]" value="{{ $item->tahun }} - {{ $item->nama_pekerjaan }}">
                        <input type="hidden" name="nett_omzet[]" value="{{ $item->nilai_kontrak_kerja }}">
                    </td>
                    <td>{{ $item->tahun }}</td>
                    <td><b>{{ $item->nama_pekerjaan }}</b></td>
                    <td>{{ $item->bidang_sub_bidang }}</td>
                    <td>{!! $lokasi !!}</td>
                    <td><b>{{ $item->pengguna_jasa }}</b></td>
                    <td>{{ $item->nomor_kontrak }}</td>
                    <td>{{ number_format($item->nilai_kontrak_kerja, 0, ".", ".") }}</td>
                    <td>{{ date('d/m/Y', strtotime($item->tgl_mulai_kontrak)) }}</td>
                    <td>{{ date('d/m/Y', strtotime($item->tgl_selesai_kontrak)) }}</td>
                    <td>{{ $tg_bast }}</td>
                    <td>{{ $durasi }}</td>
                </tr>
            @php
                });
            @endphp
            </tbody>
            </table>
            </div>

            </form>











            {{-- @php
                $i = 1;//$pengalaman_perusahaan->firstItem();
            @endphp
            <div class="table-responsive">
              <table id="example" class="table table-bordered" style="width:100%">
                <thead>
                <tr class="bg-secondary">
                    <th>No</th>
                    <th>Tahun</th>
                    <th>Nama Pekerjaan</th>
                    <th>Bidang/ Sub Bidang Pekerjaan</th>
                    <th>Lokasi</th>
                    <th>Organisasi Pengguna Jasa</th>
                    <th>No Kontrak</th>
                    <th>Nilai Kontrak (Rp.)</th>
                    <th>Tanggal Mulai Kontrak</th>
                    <th>Tanggal Selesai Kontrak</th>
                    <th>Tanggal BAST</th>
                    <th>Durasi Pekerjaan</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($pengalaman_perusahaan as $item)

                    @php
                        // CEK LOKASI PEKERJAAN
                        if ($item->is_dpb == 1) {
                            // DPB
                            $lokasi = $item->lokasi;

                        } else {

                            // MANUAL
                            if ($item->id_lokasi == null) {
                                $lokasi = $item->lokasi;
                            } else {

                                $get_obj_pengalaman_manual = DB::select("
                                SELECT branch_agency.branch_name
                                FROM objek_pekerjaan_pengalaman_perusahaan
                                JOIN branch_agency ON branch_agency.id_branch_agency = objek_pekerjaan_pengalaman_perusahaan.organization
                                WHERE id_data_pengalaman = ".$item->lokasi."
                                ");

                                $sez_pengalaman_manual = [];
                                foreach ($get_obj_pengalaman_manual as $val) {
                                    $sez_pengalaman_manual[] = $val->branch_name;
                                }

                                $lokasi = implode(", ", $sez_pengalaman_manual);
                            }
                        }



                        // CEK TGL BAST
                        if ($item->tgl_bast) {
                            $tg_bast = date('d/m/Y', strtotime($item->tgl_bast));
                        } else {
                            $tg_bast = '-';
                        }

                        // DURASI
                        $ht_hari = $item->durasi_pekerjaan % 30;
                        $hari = ($ht_hari != 0)? $ht_hari.' hari' : '';
                        $ht_bulan = floor($item->durasi_pekerjaan/30);
                        $bulan = ($ht_bulan != 0)? $ht_bulan.' bulan' : '';
                        $durasi = $bulan.' '.$hari;
                    @endphp
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $item->tahun }}</td>
                    <td><b>{{ $item->nama_pekerjaan }}</b></td>
                    <td>{{ $item->bidang_sub_bidang }}</td>
                    <td>{!! $lokasi !!}</td>
                    <td><b>{{ $item->pengguna_jasa }}</b></td>
                    <td>{{ $item->nomor_kontrak }}</td>
                    <td>{{ number_format($item->nilai_kontrak_kerja, 0, ".", ".") }}</td>
                    <td>{{ date('d/m/Y', strtotime($item->tgl_mulai_kontrak)) }}</td>
                    <td>{{ date('d/m/Y', strtotime($item->tgl_selesai_kontrak)) }}</td>
                    <td>{{ $tg_bast }}</td>
                    <td>{{ $durasi }}</td>
                </tr>
                    @endforeach
                </tbody>
                <tfoot>
                <tr class="bg-secondary">
                    <th>No</th>
                    <th>Tahun</th>
                    <th>Nama Pekerjaan</th>
                    <th>Bidang/ Sub Bidang Pekerjaan</th>
                    <th>Lokasi</th>
                    <th>Organisasi Pengguna Jasa</th>
                    <th>No Kontrak</th>
                    <th>Nilai Kontrak (Rp.)</th>
                    <th>Tanggal Mulai Kontrak</th>
                    <th>Tanggal Selesai Kontrak</th>
                    <th>Tanggal BAST</th>
                    <th>Durasi Pekerjaan</th>
                </tr>
                </tfoot>
                </table>
            </div> --}}

{{-- {{ $pengalaman_perusahaan->withQueryString()->links() }} --}}
        </div>
    </div>
</div>
@endsection

@section('javascript')

<script src="{{ asset('assets/themes/metronic/plugins/custom/datatables/datatables.bundle.js') }}"></script>

<script>
var example;

$(document).ready(function() {
    example = $("#example").DataTable({
        "bFilter": true,
        "bPaginate": false,
        "responsive": false,
        "processing": true,
        "serverSide": false,
        "ordering": false,
        "searching": true,
        "paging": false,
        "scrollY": "600px",
        "scrollCollapse": true,
        "scrollX": true,
        "dom": 'Blfrtip',
        "buttons": [{
            extend: 'collection',
            text: 'Export Excel',
            buttons: [
            'excel'
            ]
        }],

    });
});
</script>

{{-- <script>
$(document).ready(function() {
    $('#example').DataTable( {

        "pageLength": 20,
        lengthMenu: [ [5, 10, 20, 25, 50, 100, -1], [5, 10, 20, 25, 50, 100, "Tampilkan semua data"] ],
        "paging": true,
        dom: 'Bflrtip',
        // "bPaginate": false,
        buttons: [
            'copy', 'excel'
        ]

    } );
} );
</script> --}}
@endsection

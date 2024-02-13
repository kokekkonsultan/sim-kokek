@extends('include_backend/template_backend')

@section('style')
<link href="{{ asset('assets/themes/metronic/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{{ asset('assets/vendor/fusioncharts-suite-xt/js/fusioncharts.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/vendor/fusioncharts-suite-xt/js/themes/fusioncharts.theme.accessibility.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/vendor/fusioncharts-suite-xt/js/themes/fusioncharts.theme.candy.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/vendor/fusioncharts-suite-xt/js/themes/fusioncharts.theme.carbon.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/vendor/fusioncharts-suite-xt/js/themes/fusioncharts.theme.fint.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/vendor/fusioncharts-suite-xt/js/themes/fusioncharts.theme.fusion.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/vendor/fusioncharts-suite-xt/js/themes/fusioncharts.theme.gammel.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/vendor/fusioncharts-suite-xt/js/themes/fusioncharts.theme.ocean.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/vendor/fusioncharts-suite-xt/js/themes/fusioncharts.theme.umber.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/vendor/fusioncharts-suite-xt/js/themes/fusioncharts.theme.zune.js') }}"></script>
<style type="text/css">
[pointer-events="bounding-box"] {
    display: none
}
</style>

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
    table > tbody > tr > td {

    }
</style>
@endsection

@section('content')
<div class="container-fluid">




  <div class="modal fade" id="grafikNilaiPekerjaan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Grafik Nilai Nett Omzet</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <i aria-hidden="true" class="ki ki-close"></i>
          </button>
        </div>
        <div class="modal-body">

            <div id="response-chart-nilai-pekerjaan">
                <div align="center">
                    <div class="spinner spinner-track spinner-primary spinner-lg mr-15"></div>
                </div>
            </div>

        </div>

      </div>
    </div>
  </div>


  <div class="modal fade" id="grafikJumlahPekerjaan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Grafik Jumlah Pekerjaan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <i aria-hidden="true" class="ki ki-close"></i>
          </button>
        </div>
        <div class="modal-body">

            <div id="response-chart-jumlah-pekerjaan">
                <div align="center">
                    <div class="spinner spinner-track spinner-primary spinner-lg mr-15"></div>
                </div>
            </div>

        </div>

      </div>
    </div>
  </div>

  <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Filter</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <i aria-hidden="true" class="ki ki-close"></i>
          </button>
        </div>
        <div class="modal-body">



            <form action="{{ route('marketing-omzet') }}" method="post">
                @csrf

                <div class="row">
                    <div class="col-md-6">

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

                        <label for="" class="mt-5">Bidang Pekerjaan</label>
                        <div class="text-left" style="height: 300px; overflow: auto; border: 1px solid #DDDDDD; padding: 10px; border-radius: 5px;">
                            @foreach ($data_bidang_pekerjaan as $bidang_pekerjaan)
                                <label><input type="checkbox" name="bidang_pekerjaan[]" value="{{ $bidang_pekerjaan->id_bidang_pekerjaan }}"
                                    @if (Request::get('bidang_pekerjaan'))
                                    {{in_array($bidang_pekerjaan->id_bidang_pekerjaan, Request::get('bidang_pekerjaan')) ? 'checked' : ''}}
                                    @endif
                                    > {{ $bidang_pekerjaan->nama_bidang_pekerjaan }}</label><br>
                            @endforeach

                        </div>

                    </div>
                    <div class="col-md-6">

                        <div class="row">
                            <div class="col-md-6">
                                <label for="">Tahun Mulai *</label>
                                <select name="tahun" id="" class="form-control form-control-sm" required />
                                    <option value="">Pilih Tahun Mulai*</option>
                                    @php
                                    $year = [];
                                    for ($i = 2004; $i <= date('Y'); $i++) {
                                    $year[] = $i;
                                    }
                                    $year;
                                    @endphp

                                    @foreach ($year as $value)
                                        <option value="{{ $value }}" {{ Request::get('tahun') == $value ? 'selected' : '' }}>{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">

                                <label for="">Tahun Sampai *</label>
                                <select name="tahun_sampai" id="" class="form-control form-control-sm" required />
                                    <option value="">Pilih Tahun Sampai*</option>
                                    @php
                                    $year = [];
                                    for ($i = 2004; $i <= date('Y'); $i++) {
                                    $year[] = $i;
                                    }
                                    rsort($year);
                                    @endphp

                                    @foreach ($year as $value)
                                        <option value="{{ $value }}" {{ Request::get('tahun_sampai') == $value ? 'selected' : '' }}>{{ $value }}</option>
                                    @endforeach
                                </select>

                            </div>

                        </div>

                        <div class="row mt-5">
                            <div class="col-md-6">
                                <label for="">Pengurutan Nilai Pekerjaan</label>
                                <select name="pengurutan_nilai_pekerjaan" id="" class="form-control form-control-sm">
                                    <option value="">Pengurutan Nilai Pekerjaan</option>
                                    <option value="Ascending" {{ Request::get('pengurutan_nilai_pekerjaan') == 'Ascending' ? 'selected' : '' }}>Ascending</option>
                                    <option value="Descending" {{ Request::get('pengurutan_nilai_pekerjaan') == 'Descending' ? 'selected' : '' }}>Descending</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="">Status Validasi Dari Keuangan</label>
                                <select name="validasi_keuangan" id="" class="form-control form-control-sm">
                                    <option value="">Pilih Status Validasi Dari Keuangan</option>
                                    <option value="Valid" {{ Request::get('validasi_keuangan') == 'Valid' ? 'selected' : '' }}>Valid</option>
                                    <option value="Tidak Valid" {{ Request::get('validasi_keuangan') == 'Tidak Valid' ? 'selected' : '' }}>Tidak Valid</option>
                                    <option value="Belum Divalidasi" {{ Request::get('validasi_keuangan') == 'Belum Divalidasi' ? 'selected' : '' }}>Belum Divalidasi</option>
                                </select>
                            </div>
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


        </div>
      </div>
    </div>
  </div>



    <div class="card card-custom">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">
                    Omzet
                </h3>
            </div>
            <div class="card-toolbar">
                <button type="button" class="btn btn-secondary btn-sm font-weight-bold" data-toggle="modal" data-target="#grafikNilaiPekerjaan">
                    Grafik Nilai Nett Omzet
                 </button>
                 &nbsp;
                 <button type="button" class="btn btn-secondary btn-sm font-weight-bold" data-toggle="modal" data-target="#grafikJumlahPekerjaan">
                    Grafik Jumlah Pekerjaan
                 </button>
                 &nbsp;
                <button type="button" class="btn btn-primary btn-sm font-weight-bold" data-toggle="modal" data-target="#filterModal">
                    Filter
                </button>
            </div>

        </div>
        <div class="card-body">

            <div class="text-center">


            <form action="{{ route('marketing-omzet') }}" method="post">
                @csrf

                {{-- <div class="">
                    <input type="text" class="form-control" name="keyword" placeholder="Input Nama Pekerjaan" value="{{ Request::get('keyword') }}" />
                </div> --}}

                <div class="row">
                <div class="col-md-3">
                    <select name="tahun" id="" class="form-control form-control-sm" />
                                <option value="">Pilih Tahun Mulai</option>
                                @php
                                $year = [];
                                for ($i = 2004; $i <= date('Y'); $i++) {
                                $year[] = $i;
                                }
                                $year;
                                @endphp

                                @foreach ($year as $value)
                                    <option value="{{ $value }}" {{ Request::get('tahun') == $value ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                </div>
                <div class="col-md-3">
                    <select name="tahun_sampai" id="" class="form-control form-control-sm" />
                                <option value="">Pilih Tahun Sampai</option>
                                @php
                                $year = [];
                                for ($i = 2004; $i <= date('Y'); $i++) {
                                $year[] = $i;
                                }
                                rsort($year);
                                @endphp

                                @foreach ($year as $value)
                                    <option value="{{ $value }}" {{ Request::get('tahun_sampai') == $value ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                </div>
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" class="form-control form-control-sm" name="keyword" placeholder="Input Nama Pekerjaan" value="{{ Request::get('keyword') }}" />
                        <div class="input-group-append">
                         <button class="btn btn-secondary btn-sm font-weight-bold" type="submit">Cari</button>
                        </div>
                       </div>
                </div>
                </div>




            </form>

            @if (Request::get('tahun') && Request::get('tahun_sampai'))
                <h4 class="mt-5 mb-5">Memfilter berdasarkan tahun
                    @if (Request::get('tahun') == Request::get('tahun_sampai'))
                    {{ Request::get('tahun') }}
                    @else
                    {{ Request::get('tahun') }} - {{ Request::get('tahun_sampai') }}
                    @endif
                    {{ Request::get('validasi_keuangan') }}
                </h4>
            @endif
            </div>


        <form action="{{ url('marketing-omzet/generate-chart') }}" method="POST" target="_blank">

            @csrf


            <div class="row mt-3">
                <div class="col-md-3"></div>
                <div class="col-md-3"></div>
                <div class="col-md-3"></div>
                <div class="col-md-3">
                    <div class="mb-5">
                        <button class="btn btn-sm btn-secondary font-weight-bold btn-block" type="submit">Generate Chart</button>
                    </div>
                </div>
            </div>



            <div class="table-responsive">
            <table id="example" class="table table-hover display compact" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Jenis</th>
                    <th>Nama Pekerjaan</th>
                    <th>Jenis Pajak</th>
                    <th>Nilai Pekerjaan (Rp.)</th>
                    {{-- <th>DPP (Rp.)</th> --}}
                    <th>PPN (Rp.)</th>
                    <th>PPH (Rp.)</th>
                    <th>Nett Omzet (Rp.)</th>
                    <th>PIC</th>
                    <th>Status Validasi Dari Keuangan</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $nilai_kontrak = 0;
                    $ppn_nilai_kontrak = 0;
                    $pph_nilai_kontrak = 0;
                    $nett_omzet_keseluruhan = 0;
                    $no = 1;
                @endphp
                @foreach ($data_omzet as $value)

                @php
                $id = $value->id_dpb;

                if ($value->besaran_persentase_pajak != '') {
                    $persentase_pajak = $value->besaran_persentase_pajak;
                } else {
                    $persentase_pajak = 10; // Jika kosong otomatis persentase pajak 10%
                }


                $nilai_ppn = ($persentase_pajak / 100);
                $nilai_pph = 0.02;
                $nilai_dpp = 1.11;

                if ($value->id_jenis_pajak == 1) { // Termasuk Pajak

                    $dpp = $value->nilai_kontrak /  $nilai_dpp;
                    $pajak_ppn = $dpp * $nilai_ppn;
                    $pajak_pph = $dpp * $nilai_pph;

                } elseif ($value->id_jenis_pajak == 2) { // Tidak Termasuk Pajak

                    $dpp = $value->nilai_kontrak /  $nilai_dpp;
                    $pajak_ppn = 0;
                    $pajak_pph = $dpp * $nilai_pph;

                } else { // Tanpa Pajak atau tidak dikenakan pajak

                    $dpp = $value->nilai_kontrak;
                    $pajak_ppn = 0;
                    $pajak_pph = 0;

                }

                $nett_omzet = ($value->nilai_kontrak - $pajak_ppn - $pajak_pph);

                $nama_pemberi_kerja = get_nama_pemberi_kerja($value->nama_pemberi_kerja, $value->pemberi_kerja_parent, $value->nama_kategori_instansi_dari_parent);

                $nilai_kontrak += $value->nilai_kontrak;
                $ppn_nilai_kontrak += $value->nilai_kontrak * $nilai_ppn;
                $pph_nilai_kontrak += $pajak_pph;
                $nett_omzet_keseluruhan += $nett_omzet;


                // JENIS PAJAK
                if($value->jenis_pajak == 1){
                    $jenis_pajak = $value->nama_jenis_pajak . " (" . $persentase_pajak . "%)";
                } elseif($value->jenis_pajak == 2){
                    $jenis_pajak = $value->nama_jenis_pajak;
                } elseif($value->jenis_pajak == 3){
                    $jenis_pajak = $value->nama_jenis_pajak;
                } else {
                    $jenis_pajak = "";
                }

                @endphp
                <tr>
                    <td>
                        {{ $no++ }}
                        <input type="hidden" name="nama_pekerjaan[]" value="{{ $value->tahun_dpb }} - {{ $value->nama_pekerjaan }}">
                        <input type="hidden" name="nett_omzet[]" value="{{ $nett_omzet }}">
                    </td>
                    <td>{{ $value->kode_dpb }}</td>
                    <td>{{ $value->jenis_pekerjaan_dpb }}<br/><small>{{ $value->nama_bidang_pekerjaan }}</small></td>
                    <td><span class="font-weight-bold" style="color: #CB000D;">{{ $value->nama_pekerjaan }}</span><br><small>{{ $nama_pemberi_kerja }}</small></td>
                    <td>{{ $jenis_pajak }}</td>
                    <td>{{ number_format($value->nilai_kontrak, 0, ".", ".") }}</td>
                    {{-- <td>{{ number_format($dpp, 0, ".", ".") }}</td> --}}
                    <td>{{ number_format($value->nilai_kontrak * $nilai_ppn, 0, ".", ".") }}</td>
                    <td>{{ number_format($pajak_pph, 0, ".", ".") }}</td>
                    <td>{{ number_format($nett_omzet, 0, ".", ".") }}</td>
                    <td>{{ $value->pic_dpb }}</td>
                    <td>
                        @if ($value->kode_dpb != null)
                            @if ($value->is_validasi_keuangan == 'Valid')
                                <span class="badge badge-success"><small>Valid</small></span>
                            @elseif($value->is_validasi_keuangan == 'Tidak Valid')
                                Tidak Valid
                            @else
                            <span class="badge badge-warning"><small>Belum Divalidasi</small></span>
                            @endif
                        @endif

                    </td>
                </tr>
                @endforeach

            </tbody>
            <tfoot>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th>{{ number_format($data_omzet->sum('nilai_kontrak'), 0, ".", ".") }}</th>
                    <th>{{ number_format($ppn_nilai_kontrak, 0, ".", ".") }}</th>
                    <th>{{ number_format($pph_nilai_kontrak, 0, ".", ".") }}</th>
                    <th>{{ number_format($nett_omzet_keseluruhan, 0, ".", ".") }}</th>
                    <th></th>
                    <th></th>
                </tr>
            </tfoot>
            </table>
            </div>

        </form>

        </div>
    </div>
</div>
@endsection

@section('javascript')
<script src="{{ asset('assets/themes/metronic/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/vendor/chartjs/chart.min.js') }}"></script>
<script src="{{ asset('assets/vendor/chartjs/utils.js') }}"></script>

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
            "searching": false,
            "paging": false,
            "scrollY": "600px",
            "scrollCollapse": true,
            "scrollX": true,
            // "dom": 'Blfrtip',
            // "buttons": [{
            //     extend: 'collection',
            //     text: 'Export Excel',
            //     buttons: [
            //     'excel'
            //     ]
            // }],

        });
    });
    </script>

<script>
    $(document).ready(function() {
        $.ajax({
            type: "GET",
            url: "marketing-omzet/get-nilai-pekerjaan",
            dataType: "html",
            success: function(response) {
                $("#response-chart-nilai-pekerjaan").html(response);
            }

        });

        $.ajax({
            type: "GET",
            url: "marketing-omzet/get-jumlah-pekerjaan",
            dataType: "html",
            success: function(response) {
                $("#response-chart-jumlah-pekerjaan").html(response);
            }

        });

    });
    </script>

    <script>
        var KTSelect2 = function() {
 // Private functions
 var demos = function() {

    $('#kt_select2_11').select2({
    placeholder: "Add a tag",
    tags: true
    });

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

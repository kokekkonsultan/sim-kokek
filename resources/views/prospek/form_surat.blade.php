@extends('include_backend/template_backend')

@section('style')
<link href="{{ asset('assets/themes/metronic/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet"
    type="text/css" />
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link
    href="https://fonts.googleapis.com/css2?family=Exo+2:wght@300;400;500;700&family=Inter:wght@100;400;700&display=swap"
    rel="stylesheet">

@endsection

@section('content')
<div class="container-fluid">
    <div class="text-center bg-light-primary mb-5" style="border:2px solid #3699FF;">
        <h2 class="text-primary font-weight-bolder" style="padding: 1em">{{strtoupper($title)}}</h2>
    </div>
    <div class="card card-custom">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <tr>
                        <th width="20%">Nama Pekerjaan</th>
                        <th width="5%">:</th>
                        <td>{{$rup->nama_pekerjaan}}</td>
                    </tr>
                    <tr>
                        <th>Organisasi</th>
                        <th>:</th>
                        <td>{{$rup->klpd}}</td>
                    </tr>
                    <tr>
                        <th>Satuan Kerja</th>
                        <th>:</th>
                        <td>{{$rup->satuan_kerja}}</td>
                    </tr>
                    <tr>
                        <th>Metode</th>
                        <th>:</th>
                        <td>{{$rup->nama_metode_pengadaan}}</td>
                    </tr>
                    <tr>
                        <th>Waktu Pemilihan</th>
                        <th>:</th>
                        <td>{{$rup->waktu_pemilihan_penyedia}}</td>
                    </tr>
                    <tr>
                        <th>Pagu</th>
                        <th>:</th>
                        <td class="text-danger">Rp. {{number_format($rup->pagu,0,",",".")}}</td>
                    </tr>
                </table>
            </div>

        </div>

        <div class="card-footer text-right">
            <a class="btn btn-secondary font-weight-bold" href="{{url('prospek/' . Session::get('id_users'))}}"><i
                    class="fa fa-arrow-left"></i> Kembali</a>

            @if(DB::table('surat_sirup')->where('id_rup', Request::segment(3))->count() > 0)
            <a class="btn btn-danger font-weight-bold" target="_blank"
                href="{{url('prospek/pdf/' . Request::segment(3))}}"><i class="fa fa-file-pdf"></i> Download PDF</a>
            @else
            <!-- <a class="btn btn-primary font-weight-bold"
                onclick="return confirm('Apakah anda yakin ingin membuat surat untuk pekerjaan ini ?')"
                href="{{url('prospek/generate-surat/' . Request::segment(3))}}"><i class="fa fa-file-pdf"></i> Generate
                Surat Sirup</a> -->

            <a class="btn btn-primary font-weight-bold" href="javascript:void(0)"
                onclick="generate_surat()"><i class="fa fa-file-pdf"></i> Generate Surat
                Sirup</a>
            @endif
        </div>
    </div>
</div>


@endsection

@section('javascript')
@if (session('alert'))
@include('sweetalert::alert', ['cdn' => "https://cdn.jsdelivr.net/npm/sweetalert2@9"])
@endif
<script src="https://cdn.jsdelivr.net/gh/lefi-andri/metronic/plugins/custom/datatables/datatables.bundle.js"></script>


<script>
function generate_surat() {
    Swal.fire({
        title: 'Informasi',
        html: "Apakah anda yakin ingin membuat surat untuk pekerjaan {{$rup->nama_pekerjaan}} ?",
        icon: 'warning',
        showCancelButton: true,
        cancelButtonText: 'Batal',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya',
        allowOutsideClick: false,
    }).then((result) => {
        if (result.value) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "{{url('prospek/generate-surat/' . Request::segment(3))}}",
                dataType: "JSON",
                beforeSend: function() {
                    Swal.fire({
                        title: 'Memproses data',
                        html: 'Mohon tunggu sebentar. Sistem sedang menyiapkan request anda.',
                        allowOutsideClick: false,
                        onOpen: () => {
                            swal.showLoading()
                        }
                    });
                },
                success: function(data) {
                    if (data.status) {
                        Swal.fire(
                            'Sukses',
                            "Berhasil membuat surat untuk pekerjaan {{$rup->nama_pekerjaan}}",
                            'success'
                        );
                        setTimeout(function(){
                            window.location.reload(1);
                        }, 1000);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error updating data!');
                }
            });
        }
    });
}
</script>
@endsection
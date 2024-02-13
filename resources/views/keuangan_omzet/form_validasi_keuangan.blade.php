@extends('include_backend/template_backend')

@section('style')

@endsection

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Validasi Bagian Keuangan</div>
        <div class="card-body">

            <div class="row mb-5">
                <div class="col-md-12 text-center">
                    <span class="badge badge-danger">Mohon diperhatikan sebelum melakukan validasi. Jika terdapat ketidaksesuaian nilai maupun jenis pajak, mohon dikoordinasikan dengan divisi Marketing terlebih dahulu.</span>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">

                    <div class="form-group row">
                        <label  class="col-2 col-form-label">KODE</label>
                        <div class="col-10">
                         <input class="form-control" type="text" value="{{ $data_omzet->kode_dpb }}" disabled>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label  class="col-2 col-form-label">JENIS</label>
                        <div class="col-10">
                         <input class="form-control" type="text" value="{{ $data_omzet->jenis_pekerjaan_dpb }}" disabled>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label  class="col-2 col-form-label">NAMA PEKERJAAN</label>
                        <div class="col-10">
                         <textarea class="form-control" cols="30" rows="10" disabled>{{ $data_omzet->nama_pekerjaan }}</textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label  class="col-2 col-form-label">PEMBERI KERJA</label>
                        <div class="col-10">
                            @php
                            $nama_pemberi_kerja = get_nama_pemberi_kerja($data_omzet->nama_pemberi_kerja, $data_omzet->pemberi_kerja_parent, $data_omzet->nama_kategori_instansi_dari_parent);
                            @endphp
                            <textarea class="form-control" cols="30" rows="10" disabled>{{ $nama_pemberi_kerja }}</textarea>
                        </div>
                    </div>


                    @php
                    if ($data_omzet->besaran_persentase_pajak != '') {
                        $persentase_pajak = $data_omzet->besaran_persentase_pajak;
                    } else {
                        $persentase_pajak = 10; // Jika kosong otomatis persentase pajak 10%
                    }

                    $nilai_ppn = ($persentase_pajak / 100);
                    $nilai_pph_lelang = 0.02;
                    $nilai_dpp = 1.1;

                    if ($data_omzet->id_jenis_pajak == 1) { // Termasuk Pajak
                        $dpp = $data_omzet->nilai_kontrak / $nilai_dpp;
                        $pajak_ppn = $dpp * $nilai_ppn;
                        $pajak_pph_lelang = ($data_omzet->nilai_kontrak - $pajak_ppn) * $nilai_pph_lelang;

                        $nett_omzet = ($data_omzet->nilai_kontrak - $pajak_ppn - $pajak_pph_lelang);
                    } elseif ($data_omzet->id_jenis_pajak == 2) { // Tidak Termasuk Pajak

                        $pajak_ppn = 0;
                        $pajak_pph_lelang = $data_omzet->nilai_kontrak * $nilai_pph_lelang;
                        $nett_omzet = ($data_omzet->nilai_kontrak - $pajak_ppn - $pajak_pph_lelang);
                    } else { // Tanpa Pajak atau tidak dikenakan pajak

                        $pajak_ppn = 0;
                        $pajak_pph_lelang = 0;
                        $nett_omzet = ($data_omzet->nilai_kontrak - $pajak_ppn - $pajak_pph_lelang);
                    }

                    $nilai_kontrak = $data_omzet->nilai_kontrak;
                    $ppn_nilai_kontrak = $data_omzet->nilai_kontrak * $nilai_ppn;
                    $pph_nilai_kontrak = $pajak_pph_lelang;
                    $nett_omzet_keseluruhan = $nett_omzet;
                    @endphp

                    <div class="form-group row">
                        <label  class="col-2 col-form-label">PIC</label>
                        <div class="col-10">
                         <input class="form-control" type="text" value="{{ $data_omzet->pic_dpb }}" disabled>
                        </div>
                    </div>

                </div>
                <div class="col-md-6">

                    <div class="form-group row">
                        <label  class="col-2 col-form-label">JENIS PAJAK</label>
                        <div class="col-10">
                         <input class="form-control" type="text" value="{!! ($data_omzet->jenis_pajak == 1) ? $data_omzet->nama_jenis_pajak . " (" . $persentase_pajak . "%)" : "" !!}" disabled>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label  class="col-2 col-form-label">NILAI PEKERJAAN</label>
                        <div class="col-10">
                         <input class="form-control" type="text" value="{{ number_format($data_omzet->nilai_kontrak, 0, ".", ".") }}" disabled>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label  class="col-2 col-form-label">PPN</label>
                        <div class="col-10">
                         <input class="form-control" type="text" value="{{ number_format($data_omzet->nilai_kontrak * $nilai_ppn, 0, ".", ".") }}" disabled>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label  class="col-2 col-form-label">PPH</label>
                        <div class="col-10">
                         <input class="form-control" type="text" value="{{ number_format($pajak_pph_lelang, 0, ".", ".") }}" disabled>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label  class="col-2 col-form-label">NETT OMZET</label>
                        <div class="col-10">
                         <input class="form-control" type="text" value="{{ number_format($nett_omzet, 0, ".", ".") }}" disabled>
                        </div>
                    </div>

                </div>
            </div>



            <div class="row mt-5">
                <div class="col-md-6">
                    <a href="{{ route('keuangan-omzet') }}">Kembali</a>
                </div>
                <div class="col-md-6 text-right">
                    <form action="{{ route('omzet.proses.validasi') }}" method="post">
                        @csrf
                        <input type="hidden" name="id_dpb" value="{{ Request::get('id_dpb') }}">
                        <button type="submit" class="font-weight-bold btn btn-primary">Validasi</button>
                    </form>
                </div>
            </div>



        </div>
    </div>
</div>
@endsection

@section('javascript')

@endsection

@extends('include_backend/template_backend')

@section('style')

@endsection

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">Omzet DPB</div>
        <div class="card-body">



            <div class="text-center">
                <form action="{{ route('keuangan-omzet') }}" method="post">
                    @csrf

                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group row">
                                <label  class="col-4 col-form-label">Pilih Tahun</label>
                                <div class="col-8">
                                    <select name="tahun" id="" class="form-control">
                                        <option value="">Please Select</option>
                                        @php
                                        $year = [];
                                        for ($i = 2004; $i <= date('Y'); $i++) {
                                        $year[] = $i;
                                        }
                                        rsort($year);
                                        @endphp

                                        @foreach ($year as $value)
                                            <option value="{{ $value }}" {{ Request::get('tahun') == $value ? 'selected' : '' }}>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                               </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group row">
                                <label  class="col-4 col-form-label">Pilih Status Validasi Dari Keuangan</label>
                                <div class="col-8">
                                    <select name="validasi_keuangan" id="" class="form-control">
                                        <option value="">Please Select</option>
                                        <option value="Valid" {{ Request::get('validasi_keuangan') == 'Valid' ? 'selected' : '' }}>Valid</option>
                                        <option value="Tidak Valid" {{ Request::get('validasi_keuangan') == 'Tidak Valid' ? 'selected' : '' }}>Tidak Valid</option>
                                        <option value="Belum Divalidasi" {{ Request::get('validasi_keuangan') == 'Belum Divalidasi' ? 'selected' : '' }}>Belum Divalidasi</option>
                                    </select>
                                </div>
                               </div>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-primary font-weight-bold" type="submit">Filter</button>
                        </div>
                    </div>

            </form>

            @if (Request::get('tahun'))
                <h4 class="mb-5">Memfilter berdasarkan tahun <span class="text-danger">{{ Request::get('tahun') }} {{ Request::get('validasi_keuangan') }}</span></h4>
            @endif
            </div>




            <table class="table table-bordered table-hover">
                <thead>
                    <tr style="background-color: #F3F3F3;">
                        <th>No</th>
                        <th>Kode</th>
                        <th>Jenis</th>
                        <th>Nama Pekerjaan</th>
                        <th>Jenis Pajak</th>
                        <th>Nilai Pekerjaan (Rp.)</th>
                        <th>PPN (Rp.)</th>
                        <th>PPH (Rp.)</th>
                        <th>Nett Omzet (Rp.)</th>
                        <th>PIC</th>
                        <th>Validasi Keuangan</th>
                        <th>Status</th>
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
                    $id         = $value->id_dpb;

                    if ($value->besaran_persentase_pajak != '') {
                        $persentase_pajak = $value->besaran_persentase_pajak;
                    } else {
                        $persentase_pajak = 10; // Jika kosong otomatis persentase pajak 10%
                    }


                    $nilai_ppn = ($persentase_pajak / 100);
                    $nilai_pph_lelang = 0.02;
                    $nilai_dpp = 1.1;

                    if ($value->id_jenis_pajak == 1) { // Termasuk Pajak
                        $dpp = $value->nilai_kontrak / $nilai_dpp;
                        $pajak_ppn = $dpp * $nilai_ppn;
                        $pajak_pph_lelang = ($value->nilai_kontrak - $pajak_ppn) * $nilai_pph_lelang;

                        $nett_omzet = ($value->nilai_kontrak - $pajak_ppn - $pajak_pph_lelang);
                    } elseif ($value->id_jenis_pajak == 2) { // Tidak Termasuk Pajak

                        $pajak_ppn = 0;
                        $pajak_pph_lelang = $value->nilai_kontrak * $nilai_pph_lelang;
                        $nett_omzet = ($value->nilai_kontrak - $pajak_ppn - $pajak_pph_lelang);
                    } else { // Tanpa Pajak atau tidak dikenakan pajak

                        $pajak_ppn = 0;
                        $pajak_pph_lelang = 0;
                        $nett_omzet = ($value->nilai_kontrak - $pajak_ppn - $pajak_pph_lelang);
                    }

                    $nama_pemberi_kerja = get_nama_pemberi_kerja($value->nama_pemberi_kerja, $value->pemberi_kerja_parent, $value->nama_kategori_instansi_dari_parent);

                    $nilai_kontrak += $value->nilai_kontrak;
                    $ppn_nilai_kontrak += $value->nilai_kontrak * $nilai_ppn;
                    $pph_nilai_kontrak += $pajak_pph_lelang;
                    $nett_omzet_keseluruhan += $nett_omzet;
                    @endphp
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $value->kode_dpb }}</td>
                        <td>{{ $value->jenis_pekerjaan_dpb }}</td>
                        <td><span class="font-weight-bold" style="color: #CB000D;">{{ $value->nama_pekerjaan }}</span><br>{{ $nama_pemberi_kerja }}</td>
                        <td>{!! ($value->jenis_pajak == 1) ? $value->nama_jenis_pajak . " (" . $persentase_pajak . "%)" : "" !!}</td>
                        <td>{{ number_format($value->nilai_kontrak, 0, ".", ".") }}</td>
                        <td>{{ number_format($value->nilai_kontrak * $nilai_ppn, 0, ".", ".") }}</td>
                        <td>{{ number_format($pajak_pph_lelang, 0, ".", ".") }}</td>
                        <td>{{ number_format($nett_omzet, 0, ".", ".") }}</td>
                        <td>{{ $value->pic_dpb }}</td>
                        <td>
                            @if ($value->kode_dpb != null)
                                @if ($value->is_validasi_keuangan == null)
                                <form action="{{ route('omzet.validasi') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="id_dpb" value="{{ $value->id_dpb }}">
                                    <button class="btn btn-secondary" type="submit"><i class="far fa-folder-open"></i></button>
                                </form>
                                @endif
                            @endif


                        </td>
                        <td>
                            @if ($value->kode_dpb != null)
                                @if ($value->is_validasi_keuangan == 'Valid')
                                    <span class="badge badge-success">Valid</span>
                                @elseif($value->is_validasi_keuangan == 'Tidak Valid')
                                    Tidak Valid
                                @else
                                <span class="badge badge-warning">Belum Divalidasi</span>
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
                        <th></th>
                    </tr>
                </tfoot>
            </table>

        </div>
    </div>
</div>
@endsection

@section('javascript')

@endsection

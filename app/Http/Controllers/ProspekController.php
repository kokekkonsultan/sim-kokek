<?php

namespace App\Http\Controllers;

use App\Models\Rup;
use App\Helpers\Pdf\MYPDF;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Helpers\Pdf\SuratSirup;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class ProspekController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->data = [];
        $this->data['title'] = "Data Prospek";

        Session::forget('id_users');
        Session::put('id_users', $request->segment(2));
        //var_dump(Session::get('id_users'));


        $rup = Rup::select('*', DB::raw('IF((SELECT id_rup FROM surat_sirup WHERE surat_sirup.id_rup = view_rencana_umum_pengadaan.id_rup) IS NULL, 0, 1) AS cetak_surat_sirup'))->where('is_diproses_di_dil', 2)->where('is_pekerjaan_prospek', 2);
        if ($request->ajax()) {
            return Datatables::of($rup)
                ->addIndexColumn()
                ->addColumn('paket', function ($row) {

                    if ($row->cetak_surat_sirup != 0) {
                        $status = '<span class="badge badge-success font-weight-bold">Surat Sudah dikirim</span>';
                        $url_surat_sirup = 'href="/prospek/pdf/' . $row->id_rup . '" target="_blank"';
                    } else {
                        $status = '';
                        $url_surat_sirup = 'href="/prospek/form-surat/' . $row->id_rup . '"';
                    }

                    $paket = '<span class="text-danger">' . $row->nama_pekerjaan . '</span><br><small>' . $row->nama_bidang_pekerjaan . '</small>
                    <br>


                    <div class="dropdown dropdown-inline">
                        <a href="javascript:;" class="btn btn-sm btn-clean btn-icon mr-2" data-toggle="dropdown">
                            <span class="svg-icon svg-icon-md">
                                <!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Communication\Reply-all.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24"></rect>
                                        <path d="M8.29606274,4.13760526 L1.15599693,10.6152626 C0.849219196,10.8935795 0.826147139,11.3678924 1.10446404,11.6746702 C1.11907213,11.6907721 1.13437346,11.7062312 1.15032466,11.7210037 L8.29039047,18.333467 C8.59429669,18.6149166 9.06882135,18.596712 9.35027096,18.2928057 C9.47866909,18.1541628 9.55000007,17.9721616 9.55000007,17.7831961 L9.55000007,4.69307548 C9.55000007,4.27886191 9.21421363,3.94307548 8.80000007,3.94307548 C8.61368984,3.94307548 8.43404911,4.01242035 8.29606274,4.13760526 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
                                        <path d="M23.2951173,17.7910156 C23.2951173,16.9707031 23.4708985,13.7333984 20.9171876,11.1650391 C19.1984376,9.43652344 16.6261719,9.13671875 13.5500001,9 L13.5500001,4.69307548 C13.5500001,4.27886191 13.2142136,3.94307548 12.8000001,3.94307548 C12.6136898,3.94307548 12.4340491,4.01242035 12.2960627,4.13760526 L5.15599693,10.6152626 C4.8492192,10.8935795 4.82614714,11.3678924 5.10446404,11.6746702 C5.11907213,11.6907721 5.13437346,11.7062312 5.15032466,11.7210037 L12.2903905,18.333467 C12.5942967,18.6149166 13.0688214,18.596712 13.350271,18.2928057 C13.4786691,18.1541628 13.5500001,17.9721616 13.5500001,17.7831961 L13.5500001,13.5 C15.5031251,13.5537109 16.8943705,13.6779456 18.1583985,14.0800781 C19.9784273,14.6590944 21.3849749,16.3018455 22.3780412,19.0083314 L22.3780249,19.0083374 C22.4863904,19.3036749 22.7675498,19.5 23.0821406,19.5 L23.3000001,19.5 C23.3000001,19.0068359 23.2951173,18.2255859 23.2951173,17.7910156 Z" fill="#000000" fill-rule="nonzero"></path>
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
                                    <a ' . $url_surat_sirup . ' class="navi-link">
                                        <span class="navi-icon"><i class="la la-arrow-right"></i></span>
                                        <span class="navi-text">Surat Sirup</span>
                                    </a>
                                </li>
                                <li class="navi-item">
                                    <a href="javascript:void(0)" class="navi-link" onclick="jadikan_tidak_prospek(' . "'" . $row->id_rup . "', '" . $row->nama_pekerjaan . "'" . ')">
                                        <span class="navi-icon"><i class="la la-arrow-right"></i></span>
                                        <span class="navi-text">Jadikan Tidak Prospek</span>
                                    </a>
                                </li>
                                <li class="navi-item">
                                    <a href="/prospek/form-edit-input/' . $row->id_rup . '" class="navi-link">
                                        <span class="navi-icon"><i class="la la-arrow-right"></i></span>
                                        <span class="navi-text">Edit</span>
                                    </a>
                                </li>
                                <li class="navi-item">
                                    <a href="javascript:void(0)" class="navi-link" onclick="delete_data(' . "'" . $row->id_rup . "', '" . $row->nama_pekerjaan . "'" . ')">
                                        <span class="navi-icon"><i class="la la-arrow-right"></i></span>
                                        <span class="navi-text">Delete</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>' . $status;
                    return $paket;
                })
                // ->addColumn('pagu_rupiah', function ($row) {
                //     $pagu_rupiah = number_format($row->pagu,0,",",".");
                //     return $pagu_rupiah;
                // })
                ->filter(function ($instance) use ($request) {
                    if ($request->get('pic') != '') {
                        $instance->where('pic', $request->get('pic'));
                    }
                    if ($request->get('bulan') != '') {
                        $instance->where('waktu_pemilihan_penyedia', 'like', '%' . $request->get('bulan') . '%');
                    }

                    if ($request->get('tahun') != '') {
                        $instance->where('tahun_anggaran', $request->get('tahun'));
                    } else {
                        $instance->where('tahun_anggaran', date('Y'));
                    }

                    if ($request->get('lokasi') != '') {
                        $instance->where('lokasi_pekerjaan', $request->get('lokasi'));
                    }

                    if ($request->get('pagu') != '') {
                        $instance->orderByRaw('CONVERT(pagu, SIGNED) ' . $request->get('pagu'));
                    } else {
                        $instance->orderBy('updated_at', 'desc');
                    }

                    if ($request->get('status_surat') != '') {
                        $instance->whereRaw("IF((SELECT id_rup FROM surat_sirup WHERE surat_sirup.id_rup = view_rencana_umum_pengadaan.id_rup) IS NULL, 0, 1) = " . $request->get('status_surat'));
                    }

                    if (!empty($request->get('search'))) {
                        $instance->where(function ($w) use ($request) {
                            $search = $request->get('search');
                            $w->orWhere('nama_pekerjaan', 'LIKE', "%$search%")
                                ->orWhere('nama_organisasi', 'LIKE', "%$search%")
                                ->orWhere('id_sis_rup', 'LIKE', "%$search%");
                        });
                    }
                })
                ->rawColumns(['paket', 'pagu_rupiah'])
                ->make(true);
        }


        return view('prospek.index', $this->data);
    }


    public function form_edit_input(Request $request)
    {
        $this->data = [];
        $this->data['title'] = "Edit Data Prospek";

        $rup = DB::table("rencana_umum_pengadaan")->where('id_rup', $request->segment(3));
        if ($rup->count() == 0) {
            return redirect('prospek/form-edit-import/' . $request->segment(3));
        }

        $this->data['rup'] = $rup->first();
        return view('prospek/form_edit_input', $this->data);
    }

    public function proses_edit_input(Request $request)
    {
        $this->data = [];
        $object = array(
            'id_jenis_produk_rup'    => $request['id_jenis_produk_rup'],
            'id_jenis_usaha'        => $request['id_jenis_usaha'],
            'organization'          => $request['id_branch_agency'],
            'id_bidang_pekerjaan'   => $request['id_bidang_pekerjaan'],
            'nama_pekerjaan'        => $request['nama_pekerjaan'],
            'tahun_anggaran'        => $request['tahun_anggaran'],
            'id_jenis_pengadaan'    => $request['id_kategori_lelang'],
            'pagu'                  => str_replace([".", ","], '', $request['pagu']),
            'id_pemilihan_penyedia' => $request['id_metode_pengadaan'],
            'bulan_waktu_pemilihan' => $request['bulan_waktu_pemilihan'],
            'tahun_waktu_pemilihan' => $request['tahun_waktu_pemilihan'],
            'lokasi_pekerjaan'      => $request['lokasi_pekerjaan'],
        );
        DB::table('rencana_umum_pengadaan')->where('id_rup', $request->segment(3))->update($object);

        Alert::success('Success', 'Berhasil Mengubah Data');
        return redirect('prospek/' . Session::get('id_users'));
    }


    public function form_edit_import(Request $request)
    {
        $this->data = [];
        $this->data['title'] = "Edit Data Prospek";
        $this->data['rup'] = DB::table("import_rencana_umum_pengadaan")->where('id_rup', $request->segment(3))->first();

        return view('prospek/form_edit_import', $this->data);
    }

    public function proses_edit_import(Request $request)
    {
        $this->data = [];
        $rup = DB::table("import_rencana_umum_pengadaan")->where('id_rup', $request->segment(3))->first();
        $object = array(
            'nama_pekerjaan'            => $request['nama_pekerjaan'],
            'pagu'                      => str_replace([".", ","], '', $request['pagu']),
            'nama_jenis_pengadaan'      => $request['nama_jenis_pengadaan'],
            'nama_metode_pengadaan'     => $request['nama_metode_pengadaan'],
            'waktu_pemilihan_penyedia'  => $request['waktu_pemilihan_penyedia'],
            'nama_instansi'             => $request['nama_instansi'],
            'nama_organisasi'           => $request['nama_organisasi'],
            'lokasi_pekerjaan'          => $request['lokasi_pekerjaan'],
            'nama_bidang_pekerjaan'     => $request['nama_bidang_pekerjaan'],
            'tahun_anggaran'            => $request['tahun_anggaran'],
            'alamat_organisasi'         => $request['alamat_organisasi'],
        );
        DB::table('import_rencana_umum_pengadaan')->where('id_rup', $request->segment(3))->update($object);

        Alert::success('Success', 'Berhasil Mengubah Data');
        return redirect('prospek/' . Session::get('id_users'));
    }


    public function delete_data($id)
    {

        if (DB::table('import_rencana_umum_pengadaan')->where('id_rup', $id)->count() > 0) {
            DB::table('import_rencana_umum_pengadaan')->where('id_rup', $id)->delete();
        } else {
            DB::table('rencana_umum_pengadaan')->where('id_rup', $id)->delete();
        }
        echo json_encode(array("status" => true));
    }



    public function ubah_ke_tidak_prospek($id)
    {
        // Cek data input atau import
        $query = DB::table('view_rencana_umum_pengadaan')->where('id_rup', $id)->first();

        if ($query->is_import == 1) {
            DB::table('import_rencana_umum_pengadaan')
                ->where('id_rup', $id)
                ->update(['is_pekerjaan_prospek' => 1, 'updated_at' => now()]);
        } else {

            DB::table('rencana_umum_pengadaan')
                ->where('id_rup', $id)
                ->update(['is_pekerjaan_prospek' => 1, 'updated_at' => now()]);
        }

        echo json_encode(array("status" => true));
    }

    public function proses_export_excel($id)
    {
        $this->data = [];
        $this->data['title'] = "Export Data Prospek";
        $prospek = Rup::where('is_diproses_di_dil', 2)->where('is_pekerjaan_prospek', 2)->get();

        $content = view('prospek.proses_export_excel', compact('prospek'));
        
        $status = 200;
        $headers = [
            'Content-Type' => 'application/vnd.ms-excel; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="prospek.xls"',
        ];

        $response = response($content, $status, $headers);
        return $response;
    }


    public function form_surat(Request $request)
    {
        $this->data = [];
        $this->data['title'] = "Detail Surat Sirup";
        $this->data['rup'] = Rup::where('id_rup', $request->segment(3))->first();
        $this->data['cek_surat_sirup'] = DB::table('surat_sirup')->where('id_rup', $request->segment(3));
        $this->data['surat_sirup'] =  $this->data['cek_surat_sirup']->first();

        return view('prospek/form_surat', $this->data);
    }
    


    public function generate_surat(Request $request)
    {
        $this->data = [];
        $bln_surat = date('m');
        $thn_surat = date('Y');
        $bulan = ['01' => 'I', '02' => 'II', '03' => 'III', '04' => 'IV', '05' => 'V', '06' => 'VI', '07' => 'VII', '08' => 'VIII', '09' => 'IX', '10' => 'X', '11' => 'XI', '12' => 'XII'];

        #insert surat proposal
        $id_proposal_template = 71;
        $id_users =  Session::get('id_users');
        // $object = [
        //     'id_proposal_template'          => $id_proposal_template,
        //     'tgl_proposal'                  => date('Y-m-d'),
        //     'id_pembuat_surat_proposal'     => $id_users,
        //     'is_surat_sirup'                => 'true'
        // ];
        // // var_dump($object);
        // DB::table("surat_proposal")->insert($object);
        // $id_surat_proposal = DB::getPdo()->lastInsertId();


        #proses pembuatan nomor surat
        $divisi = collect(DB::select("SELECT divisi_perusahaan.kode_divisi, divisi_perusahaan.id_divisi_perusahaan
        FROM person_authentication
        JOIN pegawai_divisi ON pegawai_divisi.id_person = person_authentication.id_person
        JOIN divisi_perusahaan ON divisi_perusahaan.id_divisi_perusahaan = pegawai_divisi.id_divisi_perusahaan
        WHERE person_authentication.id_user = $id_users"))->first();

        $nomor_max = collect(DB::select("SELECT MAX(no_surat) AS max
        FROM view_nomor_surat
        WHERE id_divisi_perusahaan = $divisi->id_divisi_perusahaan AND thn_surat = $thn_surat"))->first();

        $nomor_surat_selanjutnya = $nomor_max->max + 1;
        $nomor = sprintf("%04s", $nomor_surat_selanjutnya);
        $kode_nomor_surat = $nomor . '/KK-' . $divisi->kode_divisi . '/' . $bulan[$bln_surat] . '/' . $thn_surat;
        $result = [
                'no_surat'                  => $nomor_surat_selanjutnya,
                'kode_nomor_surat'          => $kode_nomor_surat,
                'tanggal_surat'             => date('d-m-Y'),
                'id_pembuat_nomor_surat'    => $id_users,
                'id_divisi_perusahaan'      => $divisi->id_divisi_perusahaan
        ];
        DB::table("nomor_surat")->insert($result);
        $id_nomor_surat = DB::getPdo()->lastInsertId();

        $object = [
            'id_rup'                => $request->segment(3),
            'id_nomor_surat'        => $id_nomor_surat,
            'created_at'            => date('Y-m-d'),
            'input_id'              => $id_users
        ];
        DB::table("surat_sirup")->insert($object);

        // Alert::success('Success', 'Berhasil Membuat Surat');
        // return redirect('prospek/form-surat/' . $request->segment(3));
        echo json_encode(array("status" => true));
        
    }


    public function pdf(Request $request)
    {
        $id_rup = $request->segment(3);
        $data = collect(DB::select("SELECT *,
        (SELECT nama_pekerjaan FROM view_rencana_umum_pengadaan WHERE view_rencana_umum_pengadaan.id_rup = surat_sirup.id_rup) AS nama_pekerjaan,
        (SELECT kode_nomor_surat FROM nomor_surat WHERE id_nomor_surat = nomor_surat.id) AS kode_surat
        FROM surat_sirup
        WHERE id_rup = '$id_rup'"))->first();

        $arr_bulan = [
            '00' => '-',
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember'
        ];
        // var_dump($data);
        
        $pdf = new SuratSirup(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Hanif');
        $pdf->SetTitle($id_rup);
        $pdf->setPrintHeader(true);
        $pdf->setPrintFooter(true);
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->SetDisplayMode('fullpage', 'SinglePage', 'UseNone');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->AddPage('P', 'A4');
        $pdf->setLeftMargin(25);
        $pdf->setRightMargin(25);
        $pdf->Ln(24);
        
        // $pdf->setJPEGQuality(300);
		// $pdf->Image('kc-bsi-logo.png', 10, 6, 80, 21, 'PNG', 'https://www.kokek.com', '', true, 1000, '', false, false, 0, false, false, false);

       

        $html = '
                <table width="100%" border="0" cellpadding="3">
                    <tr>
                        <td>' . date('d', strtotime($data->created_at)) . ' ' . $arr_bulan[date('m', strtotime($data->created_at))] . ' ' . date('Y', strtotime($data->created_at)) . '</td>
                    </tr>
                </table>
                <br/>
                <br/>
                <table width="100%" border="0" cellpadding="3">
                    <tr>
                        <td width="15%">Nomor</td>
                        <td width="5%">:</td>
                        <td width="80%">' . $data->kode_surat . '</td>
                    </tr>
                    <tr>
                        <td width="15%">Lampiran</td>
                        <td width="5%">:</td>
                        <td width="80%">1 (satu) berkas</td>
                    </tr>
                    <tr>
                        <td width="15%">Perihal</td>
                        <td width="5%">:</td>
                        <td width="80%">Penawaran Kerja Sama</td>
                    </tr>
                </table>
                <br/>
                <br/>
                <br/>
                <br/>
                <br/>
                <br/>
                <br/>
                <br/>
                <br/>
                
                <table width="100%" border="0" cellpadding="3">
                    <tr>
                        <td>
                            <p style="line-height:1.5; text-align: justify;">Dengan hormat,<br/>
                            Menindaklanjuti Sistem Informasi Rencana Umum Pengadaan bersama ini kami bermaksud menawarkan kerja sama untuk pekerjaan <b>' . $data->nama_pekerjaan . '</b>.

                            <br/>
                            <br/>

                            KOKEK Consulting telah berpengalaman 20 tahun bekerjasama dengan instansi pemerintah dalam hal Pembangunan ZI Menuju WBK/WBBM, Survei Kepuasan Masyarakat, Proses Bisnis, SOP,  Evaluasi Kelembagaan, peningkatan kapasitas ASN, dll.  Metodologi konsultansi yang kami berikan terbukti memberikan dampak yang positif bagi pelanggan kami seperti Kementerian PANRB, Kementerian Keuangan, Kementerian Perdagangan, LKPP, Mahkamah Konstitusi, LAN, dan Pemerintah Daerah.  KOKEK Consulting juga memiliki produk digital untuk membantu pelanggan kami melaksanakan survei/pengumpulan data dengan aplikasi SurveiKu.

                            <br/>
                            <br/>

                            Demikian penawaran dari kami, jika Bapak/Ibu berminat bisa menghubungi kami di <a>marketing@kokek.com</a> atau WhatsApp <b>0895 2681 4555</b> untuk presentasi maupun komunikasi lebih lanjut.  Atas perhatian dan kesempatan yang diberikan kami sampaikan terima kasih.
                            </p>
                        </td>
                    </tr>
                </table>
                <br/>
                <br/>
                <br/>
                <br/>
                
                <table width="100%" border="0" cellpadding="3">
                    <tr>
                        <td>Hormat kami,<br>KOKEK Consulting<br>
                        <img src="assets/img/kop/ttd_stamp_p_johny.png" alt="" height="80"><br><b><u>Johny Yulfan, ST, M.Si</u></b><br>Direktur
                            </td>
                        </tr>
                </table>';
            $pdf->writeHTML($html, true, false, true, false, '');

            // var_dump($html);

        $pdf->lastPage();
        $pdf->Output('Surat Sirup.pdf', 'I');
    }
}

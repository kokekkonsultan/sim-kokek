<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\CetakProposal;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use App\Helpers\Pdf\Proposal\kokek;
use App\Helpers\Pdf\Proposal\chesna;
use App\Helpers\Pdf\Proposal\beesafe;
use App\Helpers\Pdf\MYPDF;

class CetakProposalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->data = [];
        $this->data['title'] = "Cetak Proposal";

        Session::forget('id_users');
        Session::put('id_users', $request->segment(2));
        //var_dump(Session::get('id_users'));

        $cetakProposal = CetakProposal::where('grup_pembuat_nomor_surat', 'Marketing')->orderBy('id_surat_proposal', 'desc');
        if ($request->ajax()) {
            return Datatables::of($cetakProposal)
                ->addIndexColumn()
                ->addColumn('btn_pdf', function ($row) {

                    $btn_pdf = '<a href="' . url('cetak-proposal/pdf/' . $row->id_surat_proposal . '/kokek') . '" target="_blank"><i class="fa fa-file-pdf text-danger"></a>';
                    return $btn_pdf;
                })
                ->addColumn('nama_proposal', function ($row) {

                    $nama_proposal = '<span class="text-dark">' . $row->nama_proposal_template . '</span><br>
                    <small><b>Perihal : </b> . ' . $row->perihal . '</small>';
                    return $nama_proposal;
                })
                ->addColumn('kode_surat', function ($row) {

                    if ($row->collect_kode_surat != null) {

                        $ser_collect_kode_surat = unserialize($row->collect_kode_surat);
                        $jumlah_nomor = count($ser_collect_kode_surat);


                        if ($jumlah_nomor > 1) {
                            $no_akhir = $jumlah_nomor - 1;
                            $kode_surat = $ser_collect_kode_surat[0] . ' <span class="text-danger">s/d</span> ' . $ser_collect_kode_surat[$no_akhir];
                        } else {
                            $kode_surat = $ser_collect_kode_surat[0];
                        }
                    } else {
                        $kode_surat = '';
                    }
                    return $kode_surat;
                })
                ->addColumn('jumlah_surat', function ($row) {

                    if ($row->collect_kode_surat != null) {

                        $ser_collect_kode_surat = unserialize($row->collect_kode_surat);
                        $jumlah_surat = count($ser_collect_kode_surat) . ' Surat';
                    } else {
                        $jumlah_surat = 0 . ' Surat';
                    }
                    return $jumlah_surat;
                })
                ->addColumn('btn_delete', function ($row) {

                    $no = 1;
                    $array_nomor = [];
                    foreach (DB::table('view_nomor_surat')->where('id_surat_proposal', $row->id_surat_proposal)->get() as $value) {
                        $array_nomor[] = '<tr>
                                    <td>' . $no++ . '</td>
                                    <td>' . $value->kode_nomor_surat . '</td>
                                    <td>' . $value->nama_organisasi . '</td>
                                </tr>';
                    }

                    $btn_delete = '
                    <button type="button" class="btn btn-info btn-icon font-weight-bold" data-toggle="modal" data-target="#detail' . $row->id_surat_proposal . '" title="Detail Surat"><i class="fa fa-info-circle"></i></button>

                    <button class="btn btn-danger btn-icon font-weight-bold" href="javascript:void(0)" onclick="delete_data(' . $row->id_surat_proposal . ')"><i class="fa fa-trash"></i></button>
                    
                    <div class="modal fade" id="detail' . $row->id_surat_proposal . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                            <div class="modal-header bg-secondary">
                                <span class="modal-title font-weight-bolder">' . $row->nama_proposal_template . '</span>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">X</button>
                            </div>
                            <div class="modal-body">
                                <div class="table-responsive">
                                <table class="table table-hover table-bordered" width="100%">
                                    <tr>
                                        <th class="font-weight-bolder">#</th>
                                        <th class="font-weight-bolder">Kode</th>
                                        <th class="font-weight-bolder">Organisasi</th>
                                    </tr>
                                    ' . implode("", $array_nomor) . '
                                </table>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>';
                    return $btn_delete;
                })
                ->rawColumns(['btn_pdf', 'nama_proposal', 'kode_surat', 'jumlah_surat', 'btn_delete'])
                ->make(true);
        }

        return view('cetak_proposal.index', $this->data);
    }





    public function pilih_organisasi(Request $request)
    {
        $this->data = [];
        $this->data['title'] = "Pilih Organisasi";

        $organisasi = DB::table('view_organisasi_slim')
            ->Join('organisasi_surat_ditujukan', 'view_organisasi_slim.id_branch_agency', '=', 'organisasi_surat_ditujukan.id_branch_agency')
            ->select(
                'view_organisasi_slim.id_branch_agency',
                'view_organisasi_slim.id_kategori_instansi_dari_parent',
                'view_organisasi_slim.id_parent',
                'view_organisasi_slim.nama_organisasi_utama',
                'view_organisasi_slim.id_provinsi_indonesia',
                'organisasi_surat_ditujukan.id_surat_ditujukan',
                'view_organisasi_slim.nama_turunan_organisasi',
                'organisasi_surat_ditujukan.id AS id_organisasi_surat_ditujukan',
                DB::raw('(SELECT nama_surat_ditujukan FROM surat_ditujukan WHERE organisasi_surat_ditujukan.id_surat_ditujukan = surat_ditujukan.id) AS new_surat_ditujukan'),
                DB::raw('(SELECT nama_provinsi_indonesia FROM provinsi_indonesia WHERE provinsi_indonesia.id_provinsi_indonesia = view_organisasi_slim.id_provinsi_indonesia) AS nama_provinsi_indonesia')
            );

        if ($request->ajax()) {
            return Datatables::of($organisasi)
                ->addIndexColumn()
                ->addColumn('select_organisasi', function ($row) {

                    $teks = $row->nama_organisasi_utama;
                    $pecah = explode(" ", $teks);
                    $jumlah = count($pecah);

                    $target = '';
                    for ($i = 0; $i < $jumlah; $i++) {
                        // echo $i.'<br>';
                        if ($pecah[$i] == 'Kabupaten' or $pecah[$i] == 'Kota' or $pecah[$i] == 'Provinsi') {
                            $target = $i;
                        }
                    }

                    if ($target != null) {
                        $ins = '';
                        for ($j = 0; $j < $target; $j++) {
                            $ins .= $pecah[$j] . ' ';
                        }
                    } else {
                        $ins = $teks;
                    }

                    $select_organisasi = '<div class="checkbox-list"><label class="checkbox"><input type="checkbox" name="id_organisasi_surat_ditujukan[]" value="' . $row->id_organisasi_surat_ditujukan . '" class="child"><span></span>' . trim($ins) . '</label></div>';
                    return $select_organisasi;
                })
                ->rawColumns(['select_organisasi'])

                ->filter(function ($instance) use ($request) {
                    if ($request->get('id_agency_category') != '') {
                        $instance->whereIn('id_kategori_instansi_dari_parent', $request->get('id_agency_category'));
                    }

                    if ($request->get('id_agency') != '') {
                        $instance->whereIn('id_parent', $request->get('id_agency'));
                    }

                    if ($request->get('id_organisasi') != '') {
                        $instance->whereIn('id_organisasi', $request->get('id_organisasi'));
                    }

                    if ($request->get('id_provinsi_indonesia') != '') {
                        $instance->whereIn('id_provinsi_indonesia', $request->get('id_provinsi_indonesia'));
                    }

                    if ($request->get('id_surat_ditujukan') != '') {
                        $instance->whereIn('organisasi_surat_ditujukan.id_surat_ditujukan', $request->get('id_surat_ditujukan'));
                    }

                    if (!empty($request->get('search'))) {
                        $instance->where(function ($w) use ($request) {
                            $search = $request->get('search');
                            $w->orWhere('view_organisasi_slim.nama_turunan_organisasi', 'LIKE', "%$search%")
                                ->orWhere('view_organisasi_slim.nama_organisasi_utama', 'LIKE', "%$search%");
                        });
                    }
                })
                ->make(true);
        }

        return view('cetak_proposal.pilih_organisasi', $this->data);
    }


    public function buat_proposal(Request $request)
    {
        $id_users = SESSION::get('id_users');
        $tgl_surat = date('d');
        $bln_surat = date('m');
        $thn_surat = date('Y');
        $bulan = ['01' => 'I', '02' => 'II', '03' => 'III', '04' => 'IV', '05' => 'V', '06' => 'VI', '07' => 'VII', '08' => 'VIII', '09' => 'IX', '10' => 'X', '11' => 'XI', '12' => 'XII'];

        // var_dump($request['id_organisasi_surat_ditujukan']);
        $arr_org = [];
        $arr_surat_ditujukan = [];
        foreach(DB::table('organisasi_surat_ditujukan')->whereIn('id', $request['id_organisasi_surat_ditujukan'])->get() as $row){
            $arr_org[]              = $row->id_branch_agency;
            $arr_surat_ditujukan[]  =  $row->id_surat_ditujukan;
        }

        #insert surat proposal
        $object = [
            'id_proposal_template'          => $request->segment(3),
            'tgl_proposal'                  => date('Y-m-d'),
            'id_pembuat_surat_proposal'     => $id_users,
            'collect_id_branch_agency'      => serialize($arr_org),
        ];
        DB::table("surat_proposal")->insert($object);
        $id_surat_proposal = DB::getPdo()->lastInsertId();


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
        $kode_surat_arr = [];
        foreach ($arr_org as $key => $row) {

            $nomor = sprintf("%04s", ($nomor_surat_selanjutnya + $key));
            $kode_nomor_surat = $nomor . '/KK-' . $divisi->kode_divisi . '/' . $bulan[$bln_surat] . '/' . $thn_surat;

            $kode_surat_arr[] = $kode_nomor_surat;
            $result[$key] = [
                'id_surat_proposal'         => $id_surat_proposal,
                'no_surat'                  => ($nomor_surat_selanjutnya + $key),
                'kode_nomor_surat'          => $kode_nomor_surat,
                'tanggal_surat'             => date('d-m-Y'),
                'organization'              => $row,
                'id_pembuat_nomor_surat'    => $id_users,
                'id_divisi_perusahaan'      => $divisi->id_divisi_perusahaan,
                'id_surat_ditujukan'        => $arr_surat_ditujukan[$key]
            ];
            DB::table("nomor_surat")->insert($result[$key]);
        }


        $object_update = [
            'collect_kode_surat' => serialize($kode_surat_arr)
        ];
        DB::table('surat_proposal')->where('id', $id_surat_proposal)->update($object_update);

        // Alert::success('Success', 'Berhasil Membuat Surat');
        // return redirect('cetak-proposal/' . $id_users);
        echo json_encode(array("status" => true));
    }


    public function delete_data($id)
    {
        DB::table('surat_proposal')->where('id', $id)->delete();
        echo json_encode(array("status" => true));
    }


    // public function ajax_agency_category(Request $request)
    // {

    //     $term = trim($request->q);
    //     if (empty($term)) {
    //         return response()->json([]);
    //     }
    //     $tags = DB::table('agency_category')->where('agency_category_name', 'LIKE', "%$term%")->limit(5)->get();
    //     $formatted_tags = [];
    //     foreach ($tags as $tag) {
    //         $formatted_tags[] = ['id' => $tag->id_agency_category, 'text' => $tag->agency_category_name];
    //     }

    //     // return \Response::json($formatted_tags);
    //     return response()->json($formatted_tags);
    // }


    // public function ajax_agency(Request $request)
    // {
    //     $term = trim($request->q);
    //     if (empty($term)) {
    //         return response()->json([]);
    //     }
    //     $tags = DB::table('view_organisasi_slim')
    //         ->where('is_instansi', 1)
    //         ->where('nama_organisasi_utama', 'LIKE', "%$term%")
    //         ->orWhere('nama_turunan_organisasi', 'LIKE', "%$term%")
    //         ->limit(5)->get();

    //     $formatted_tags = [];
    //     foreach ($tags as $tag) {
    //         $formatted_tags[] = ['id' => $tag->id_branch_agency, 'text' => $tag->nama_organisasi_utama];
    //     }

    //     // return \Response::json($formatted_tags);
    //     return response()->json($formatted_tags);
    // }



    // public function ajax_organisasi(Request $request)
    // {
    //     $term = trim($request->q);
    //     if (empty($term)) {
    //         return response()->json([]);
    //     }
    //     $tags = DB::table('view_organisasi_slim')
    //         ->where('is_organisasi', 1)
    //         ->where('nama_organisasi_utama', 'LIKE', "%$term%")
    //         ->orWhere('nama_turunan_organisasi', 'LIKE', "%$term%")
    //         ->limit(5)->get();

    //     $formatted_tags = [];
    //     foreach ($tags as $tag) {
    //         $formatted_tags[] = ['id' => $tag->id_branch_agency, 'text' => $tag->nama_organisasi_utama];
    //     }

    //     // return \Response::json($formatted_tags);
    //     return response()->json($formatted_tags);
    // }

    // public function ajax_surat_ditujukan(Request $request)
    // {

    //     $term = trim($request->q);
    //     if (empty($term)) {
    //         return response()->json([]);
    //     }
    //     $tags = DB::table('surat_ditujukan')
    //         ->where('nama_susunan_organisasi', 'LIKE', "%$term%")
    //         ->orWhere('nama_surat_ditujukan', 'LIKE', "%$term%")
    //         ->limit(5)->get();

    //     $formatted_tags = [];
    //     foreach ($tags as $tag) {
    //         $formatted_tags[] = ['id' => $tag->id, 'text' => $tag->nama_susunan_organisasi . ' - ' . $tag->nama_surat_ditujukan];
    //     }

    //     // return \Response::json($formatted_tags);
    //     return response()->json($formatted_tags);
    // }


    public function pdf(Request $request)
    {
        $id = $request->segment(3);
        $pt = $request->segment(4);
        $data = DB::table('view_surat_proposal')
            ->select('*', 'view_surat_proposal.id_jenis_proposal as id_jenis_proposal_template')
            ->join('proposal_template', 'view_surat_proposal.id_proposal_template', '=', 'proposal_template.id')
            ->where('view_surat_proposal.id_surat_proposal', $id)->first();

        $font_size = $data->font_size;
        $line_height = 1.5;
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

        

        if ($pt == 'kokek') {
            $pdf = new kokek(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            $ln = 18;
        } elseif ($pt == 'chesna') {
            $pdf = new chesna(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            $ln = 32;
        } else {
            $pdf = new beesafe(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            $ln = 20;
        }


        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Hanif');
        $pdf->SetTitle($data->nama_proposal_template);
        $pdf->setPrintHeader(true);
        $pdf->setPrintFooter(true);
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->SetDisplayMode('fullpage', 'SinglePage', 'UseNone');
        $pdf->SetFont('helvetica', '', $font_size);



        foreach (DB::select("SELECT *, 
        (SELECT nama_surat_ditujukan FROM surat_ditujukan WHERE id = IFNULL((SELECT id_surat_ditujukan FROM nomor_surat WHERE view_nomor_surat.id_nomor_surat = nomor_surat.id), (SELECT id_surat_ditujukan FROM organisasi_surat_ditujukan WHERE view_nomor_surat.organization = organisasi_surat_ditujukan.id_branch_agency LIMIT 1))) AS nama_surat_ditujukan,

        IF((SELECT is_suborganization FROM branch_agency WHERE view_nomor_surat.organization = branch_agency.id_branch_agency) = 1, IFNULL((SELECT branch_name FROM branch_agency WHERE branch_agency.id_branch_agency = (SELECT id_suborganization_parent FROM branch_agency WHERE view_nomor_surat.organization = branch_agency.id_branch_agency)), Null), NULL) AS nama_turunan_organisasi,

        (SELECT nama_kota_kab_indonesia FROM kota_kab_indonesia WHERE id_kota_kab_indonesia = (SELECT id_kota_kab_indonesia FROM branch_agency WHERE view_nomor_surat.organization = branch_agency.id_branch_agency)) AS nama_kota_kabupaten,

        (SELECT nama_provinsi_indonesia FROM kota_kab_indonesia JOIN provinsi_indonesia ON kota_kab_indonesia.id_provinsi_indonesia = provinsi_indonesia.id_provinsi_indonesia WHERE id_kota_kab_indonesia = (SELECT id_kota_kab_indonesia FROM branch_agency WHERE view_nomor_surat.organization = branch_agency.id_branch_agency)) AS nama_provinsi_indonesia
        
        FROM view_nomor_surat
        WHERE id_surat_proposal = $id") as $row) {

            $pdf->AddPage('P', 'A4');
            $pdf->setLeftMargin(25);
            $pdf->setRightMargin(25);
            $pdf->Ln($ln);

            #PERIHAL =============================================================================
            $html_perihal = '
                <table width="100%" border="0" cellpadding="3">
                    <tr>
                        <td>' . date('d', strtotime($data->tgl_proposal)) . ' ' . $arr_bulan[date('m', strtotime($data->tgl_proposal))] . ' ' . date('Y', strtotime($data->tgl_proposal)) . '</td>
                    </tr>
                </table>
                <br/>
                <br/>
                <table width="100%" border="0" cellpadding="3">
                    <tr>
                        <td width="15%">Nomor</td>
                        <td width="5%">:</td>
                        <td width="80%">' . $row->kode_nomor_surat . '</td>
                    </tr>
                    <tr>
                        <td width="15%">Lampiran</td>
                        <td width="5%">:</td>
                        <td width="80%">' . $data->jumlah_lampiran . '</td>
                    </tr>
                    <tr>
                        <td width="15%">Perihal</td>
                        <td width="5%">:</td>
                        <td width="80%">' . $data->perihal . '</td>
                    </tr>
                </table>
                <br/>
                <br/>';
            $pdf->writeHTML($html_perihal, true, false, true, false, '');


            #KEPADA =============================================================================
            $nama_organisasi = $row->nama_organisasi != '' ? $row->nama_organisasi . '<br/>' : '';
            $nama_turunan_organisasi = $row->nama_turunan_organisasi != '' ? $row->nama_turunan_organisasi . '<br/>' : '';
            $alamat_organisasi = str_replace(['<p', '</p>'],['<', '</>'], $row->alamat_organisasi);
            $nama_kota_kabupaten = $row->nama_kota_kabupaten != '' ? ', ' . str_replace(['Kota', 'Kabupaten'],'', $row->nama_kota_kabupaten) : '';
            $nama_provinsi_indonesia = $row->nama_provinsi_indonesia != '' ? ', ' . str_replace('Provinsi','', $row->nama_provinsi_indonesia) : '';

            $html_kepada = '<table width="100%" border="0" cellpadding="3">
                            <tr>
                                <td><p style="line-height: ' . $line_height . ';">Kepada Yth.<br/>' . 
                                $row->nama_surat_ditujukan . '<br/>' . 
                                $nama_organisasi . $nama_turunan_organisasi . $alamat_organisasi . $nama_kota_kabupaten . $nama_provinsi_indonesia . '</p></td>
                            </tr>
                        </table>';
            $pdf->writeHTML($html_kepada, true, false, true, false, '');



            #ISI SURAT =============================================================================

            #Project || Custom
            if ($data->nama_jenis_proposal == 'Project' || $data->nama_jenis_proposal == 'Custom') {

                $html_isi = str_replace('<p style="', '<p style="line-height:' . $line_height . '; text-align: justify; ', $data->bagian_pembuka_surat . $data->bagian_tubuh_surat . $data->bagian_penutup_surat);

                #Public Course || In House Training
            } elseif ($data->nama_jenis_proposal == 'Public Course' || $data->nama_jenis_proposal == 'In House Training') {
                $waktu = $data->nama_jenis_proposal == 'Public Course' ? date('d-m-Y', strtotime($data->tgl_mulai)) . ' s/d ' . date('d-m-Y', strtotime($data->tgl_selesai)) : $data->jumlah_hari;

                $html_isi = '
                <table width="100%" border="0" cellpadding="1" style="line-height:' . $line_height . ';">
                    <tr>
                        <td align="justify">' . $data->bagian_pembuka_surat . '</td>
                    </tr>
                </table>
                <br/>
                <br/>
                <table width="100%" border="0" cellpadding="1" style="line-height:' . $line_height . ';">
                    <tr>
                        <td width="19%">Nama Kegiatan</td>
                        <td width="2%"><div align="center">:</div></td>
                        <td width="79%">' . $data->nama_kegiatan . '</td>
                    </tr>
                    <tr>
                        <td>Waktu</td>
                        <td><div align="center">:</div></td>
                        <td>' . $waktu . ', ' . $data->jam_mulai . ' -
                            ' . $data->jam_selesai . '&nbsp;WIB
                        </td>
                    </tr>
                    <tr>
                        <td>Biaya</td>
                        <td><div align="center">:</div></td>
                        <td>Rp. ' . number_format($data->biaya, 0, ',', '.') . ', - per peserta (' . $data->is_ppn . ')</td>
                    </tr>
                    <tr>
                        <td>Tempat</td>
                        <td><div align="center">:</div></td>
                        <td>' . $data->tempat_kegiatan . '</td>
                    </tr>
                    <tr>
                        <td>Fasilitas</td>
                        <td><div align="center">:</div></td>
                        <td>' . $data->fasilitas . '</td>
                    </tr>
                    <tr>
                        <td>Pendaftaran</td>
                        <td><div align="center">:</div></td>
                        <td><a href="https://www.kokek.com/event" style="text-decoration:none">https://www.kokek.com/event</a></td>
                    </tr>
                
                    <tr>
                        <td>Catatan</td>
                        <td><div align="center">:</div></td>
                        <td align="justify">' . $data->catatan . '</td>
                    </tr>
                </table>
                
                <br/>
                <br/>
                
                <table width="100%" border="0" cellpadding="1" style="line-height:' . $line_height . ';">
                    <tr>
                        <td align="justify">' . $data->bagian_penutup_surat . '</td>
                    </tr>
                </table>';
            } else {
                $html_isi = '';
            }
            // var_dump($html_isi);
            $html_isi .= '<br/><br/>';
            $pdf->writeHTML($html_isi, true, false, true, false, '');



            #TTD =============================================================================
            if ($pt == 'kokek') {

                $html_ttd = '
                    <table width="100%" border="0" cellpadding="3">
                    <tr><td>Hormat kami,<br>KOKEK Consulting<br>
                    <img src="assets/img/kop/ttd_stamp_p_johny.png" alt="" height="80"><br><b><u>Johny Yulfan, ST, M.Si</u></b><br>Direktur</td></tr>
                    </table>';
                
            } else if ($pt == 'chesna') {
                $html_ttd = '
                    <table width="100%" border="0" cellpadding="3">
                    <tr><td>Hormat kami,<br>PT. CHESNA<br>
                    <img src="assets/img/kop/Bu_Ni_Luh_stempel_2.png" alt="" height="90"><br><b><u>Ni Luh Adiansunyani</u></b><br>Direktur</td></tr>
                    </table>';

            } else {
                $html_ttd = '
                    <table width="100%" border="0" cellpadding="3">
                    <tr><td>Hormat kami,<br>Beesafe Indonesia<br>
                    <img src="assets/img/kop/ttd_stamp_p_johny_beesafe.png" alt="" height="80"><br><b><u>Johny Yulfan, ST, M.Si</u></b><br>Direktur</td></tr>
                    </table>';
            }
            $pdf->writeHTML($html_ttd, true, false, true, false, '');
        }

    
        $pdf->lastPage();
        $pdf->Output('Surat Proposal.pdf', 'I');
    }
}
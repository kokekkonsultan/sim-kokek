<?php

namespace App\Http\Controllers;

use App\Helpers\Pdf\MYPDF;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\SuratProposal;
use Illuminate\Support\Facades\DB;
use App\Helpers\Pdf\Proposal\kokek;
use App\Helpers\Pdf\Proposal\chesna;
use App\Helpers\Pdf\Proposal\beesafe;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;


class SuratProposalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->data = [];
        $this->data['title'] = "Surat Proposal";

        Session::forget('id_users');
        Session::put('id_users', $request->segment(2));
        //var_dump(Session::get('id_users'));

        $SuratProposal = SuratProposal::orderby('id_proposal_template', 'desc');
        if ($request->ajax()) {
            return Datatables::of($SuratProposal)
                ->addIndexColumn()
                ->addColumn('btn', function ($row) {

                    $btn = '<button href="javascript:;" type="button" class="btn btn-primary font-weight-bold btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-ellipsis-v"></i> Pratinjau</button>
                    
                    <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right" style="">
                        <ul class="navi flex-column navi-hover py-2">
                            <li class="navi-header font-weight-bolder text-uppercase font-size-xs text-primary pb-2">
                                Choose an action:
                            </li>
                            <li class="navi-item">
                                <a href="/surat-proposal/pdf/' . $row->id_proposal_template . '/kokek" class="navi-link" target="_blank">
                                    <span class="navi-icon"><i class="la la-arrow-right"></i></span>
                                    <span class="navi-text">Kokek</span>
                                </a>
                            </li>
                            <li class="navi-item">
                            <a href="/surat-proposal/pdf/' . $row->id_proposal_template . '/chesna" class="navi-link" target="_blank">
                                    <span class="navi-icon"><i class="la la-arrow-right"></i></span>
                                    <span class="navi-text">Chesna</span>
                                </a>
                            </li>
                            <li class="navi-item">
                                <a href="/surat-proposal/pdf/' . $row->id_proposal_template . '/beesafe" class="navi-link" target="_blank">
                                    <span class="navi-icon"><i class="la la-arrow-right"></i></span>
                                    <span class="navi-text">Beesafe</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    
                    <a class="btn btn-secondary btn-sm font-weight-bold" href="/surat-proposal/form-edit/' . $row->id_proposal_template . '"><i class="fa fa-edit"></i> Edit</a>
                    <button class="btn btn-secondary btn-sm font-weight-bold" href="javascript:void(0)" onclick="delete_data(' . "'" . $row->id_proposal_template . "', '" . $row->nama_proposal_template . "'" . ')"><i class="fa fa-trash"></i> Delete</button>
                ';
                    return $btn;
                })
                // ->filter(function ($instance) use ($request) {
                //     if (!empty($request->get('search'))) {
                //         $instance->where(function ($w) use ($request) {
                //             $search = $request->get('search');
                //             $w->orWhere('nama_proposal_template', 'LIKE', "%$search%")
                //                 ->orWhere('nama_bidang_pekerjaan', 'LIKE', "%$search%");
                //         });
                //     }
                // })
                ->rawColumns(['btn'])
                ->make(true);
        }


        return view('surat_proposal.index', $this->data);
    }



    public function form_add(Request $request)
    {
        $this->data = [];
        $this->data['title'] = 'Tambah Surat Proposal';
        $this->data['jenis_proposal'] = DB::table('jenis_proposal')->where('id', $request->segment(3))->first();


        return view('surat_proposal.form_add', $this->data);
    }

    public function proses_add(Request $request)
    {
        $get_produk = DB::table('view_master_proposal')->where('id', $request['id_proposal'])->first();
        $object = [
            'id_master_proposal'                => $request['id_proposal'],
            'nama_proposal_template'            => 'Surat Proposal ' . $get_produk->nama_master_proposal,
            'nama_kegiatan'                     => $get_produk->nama_master_proposal,
            'jumlah_lampiran'                   => $request['jumlah_lampiran'],
            'perihal'                           => $request['perihal'],
            'id_bidang_pekerjaan'               => $get_produk->id_bidang_pekerjaan,
            'id_jenis_instansi_proposal'        => $request['id_jenis_instansi_proposal'],
            'id_pembuat_proposal_template'      => Session::get('id_users'),
            'bagian_pembuka_surat'              => $request['bagian_pembuka_surat'],
            'bagian_penutup_surat'              => $request['bagian_penutup_surat'],
            'created_at'                        => date('Y-m-d H:i:s'),
            'font_size'                         => $request['font_size']
        ];

        #Project
        if ($request->segment(3) == 2) {
            $object['bagian_tubuh_surat'] = $request['bagian_tubuh_surat'];

            #Public Course
        } elseif ($request->segment(3) == 3) {
            $object['tgl_mulai']        = $request['tgl_mulai'];
            $object['tgl_selesai']      = $request['tgl_selesai'];
            $object['jam_mulai']        = $request['jam_mulai'];
            $object['jam_selesai']      = $request['jam_selesai'];
            $object['biaya']            = str_replace(".", "", $request['biaya']);
            $object['is_ppn']           = $request['is_ppn'];
            $object['tempat_kegiatan']  = $request['tempat_kegiatan'];
            $object['fasilitas']        = $request['fasilitas'];
            $object['catatan']          = $request['catatan'];

            #In House Training
        } elseif ($request->segment(3) == 4) {
            $object['jumlah_hari']              = $request['jumlah_hari'];
            $object['jam_mulai']                = $request['jam_mulai'];
            $object['jam_selesai']              = $request['jam_selesai'];
            $object['biaya']                    = str_replace(".", "", $request['biaya']);
            $object['is_ppn']                   = $request['is_ppn'];
            $object['max_peserta']              = $request['max_peserta'];
            $object['kelebihan_peserta_biaya']  = str_replace(".", "", $request['kelebihan_peserta_biaya']);
            $object['tempat_kegiatan']          = $request['tempat_kegiatan'];
            $object['fasilitas']                = $request['fasilitas'];
            $object['catatan']                  = $request['catatan'];


            #Custom
        } else {
            $object['bagian_tubuh_surat'] = $request['bagian_tubuh_surat'];
        }

        DB::table("proposal_template")->insert($object);

        Alert::success('Success', 'Berhasil Menambah Data');
        return redirect('surat-proposal/' . Session::get('id_users'));
    }


    public function form_edit(Request $request)
    {
        $this->data = [];
        $this->data['title'] = 'Ubah Surat Proposal';
        $this->data['proposal'] = DB::table('view_proposal_template')
        ->select('*', DB::raw('(SELECT font_size FROM proposal_template WHERE proposal_template.id = view_proposal_template.id_proposal_template) AS font_size'))
        ->where('id_proposal_template', $request->segment(3))->first();


        return view('surat_proposal.form_edit', $this->data);
    }

    public function proses_edit(Request $request)
    {
        $get_produk = DB::table('view_master_proposal')->where('id', $request['id_proposal'])->first();
        $proposal = DB::table('view_proposal_template')->where('id_proposal_template', $request->segment(3))->first();

        $object = [
            'id_master_proposal'                => $request['id_proposal'],
            'nama_proposal_template'            => 'Surat Proposal ' . $get_produk->nama_master_proposal,
            'nama_kegiatan'                     => $get_produk->nama_master_proposal,
            'jumlah_lampiran'                   => $request['jumlah_lampiran'],
            'perihal'                           => $request['perihal'],
            'id_bidang_pekerjaan'               => $get_produk->id_bidang_pekerjaan,
            'id_jenis_instansi_proposal'        => $request['id_jenis_instansi_proposal'],
            'bagian_pembuka_surat'              => $request['bagian_pembuka_surat'],
            'bagian_penutup_surat'              => $request['bagian_penutup_surat'],
            'font_size'                         => $request['font_size']
        ];

        #Project
        if ($proposal->nama_jenis_proposal == 'Project') {
            $object['bagian_tubuh_surat'] = $request['bagian_tubuh_surat'];

            #Public Course
        } elseif ($proposal->nama_jenis_proposal == 'Public Course') {
            $object['tgl_mulai']        = $request['tgl_mulai'];
            $object['tgl_selesai']      = $request['tgl_selesai'];
            $object['jam_mulai']        = $request['jam_mulai'];
            $object['jam_selesai']      = $request['jam_selesai'];
            $object['biaya']            = str_replace(".", "", $request['biaya']);
            $object['is_ppn']           = $request['is_ppn'];
            $object['tempat_kegiatan']  = $request['tempat_kegiatan'];
            $object['fasilitas']        = $request['fasilitas'];
            $object['catatan']          = $request['catatan'];

            #In House Training
        } elseif ($proposal->nama_jenis_proposal == 'In House Training') {
            $object['jumlah_hari']              = $request['jumlah_hari'];
            $object['jam_mulai']                = $request['jam_mulai'];
            $object['jam_selesai']              = $request['jam_selesai'];
            $object['biaya']                    = str_replace(".", "", $request['biaya']);
            $object['is_ppn']                   = $request['is_ppn'];
            $object['max_peserta']              = $request['max_peserta'];
            $object['kelebihan_peserta_biaya']  = str_replace(".", "", $request['kelebihan_peserta_biaya']);
            $object['tempat_kegiatan']          = $request['tempat_kegiatan'];
            $object['fasilitas']                = $request['fasilitas'];
            $object['catatan']                  = $request['catatan'];

            #Custom
        } else {
            $object['bagian_tubuh_surat'] = $request['bagian_tubuh_surat'];
        }

        // var_dump($object);

        DB::table('proposal_template')->where('id', $request->segment(3))->update($object);

        Alert::success('Success', 'Berhasil Mengubah Data');
        return redirect('surat-proposal/' . Session::get('id_users'));
    }


    public function delete_data($id)
    {
        DB::table('proposal_template')->where('id', $id)->delete();

        echo json_encode(array("status" => true));
    }


    public function pdf(Request $request)
    {
        $pt = $request->segment(4);
        $data = DB::table('view_proposal_template')->where('id_proposal_template', $request->segment(3))->first();
        $font_size = $data->font_size;
        $line_height = 1.5;

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
        $pdf->SetSubject('PROPOSAL PT KOKEK');
        $pdf->SetKeywords('PROPOSAL PT KOKEK');

        $pdf->setPrintHeader(true);
        $pdf->setPrintFooter(true);
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        $pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->SetDisplayMode('fullpage', 'SinglePage', 'UseNone');

        $pdf->SetFont('helvetica', '', $font_size);


        $pdf->AddPage('P', 'A4');
        $pdf->setPage(1, true);

        $pdf->SetY($ln);
        $pdf->Ln(13);

        $pdf->setLeftMargin(25);
        $pdf->setRightMargin(25);

        $pdf->Cell(0, 0, 'TANGGAL SURAT', 0, 1, 'L');
        $pdf->Ln(3);

        $pdf->SetFillColor(255, 255, 255);

        $pdf->MultiCell(20, 5, 'Nomor', 0, 'L', 1, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(10, 5, ':', 0, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(50, 5, 'KODE SURAT', 0, 'L', 1, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln(5);
        $pdf->MultiCell(20, 5, 'Lampiran', 0, 'L', 1, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(10, 5, ':', 0, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(50, 5, $data->jumlah_lampiran, 0, 'L', 1, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->Ln(5);
        $pdf->MultiCell(20, 5, 'Perihal', 0, 'L', 1, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(10, 5, ':', 0, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
        $pdf->MultiCell(105, 16, $data->perihal, 0, 'L', 1, 0, '', '', true, 0, false, true, 0, 'M');
        $pdf->Ln(17);

        $pdf->SetFont('helvetica', 'B', $font_size);
        $pdf->Cell(0, 0, 'Kepada Yth.', 0, 1, 'L');
        $pdf->Cell(0, 0, 'NAMA SURAT DITUJUKAN', 0, 1, 'L');
        $pdf->Cell(0, 0, 'NAMA ORGANISASI', 0, 1, 'L');
        $pdf->MultiCell(100, 16, 'ALAMAT', 0, 'L', 1, 0, '', '', true, 0, false, true, 0, 'M');

        $pdf->SetFont('helvetica', '', $font_size);
        $pdf->Ln(10);


        #Project || Custom
        if ($data->nama_jenis_proposal == 'Project' || $data->nama_jenis_proposal == 'Custom') {

            $html_isi = str_replace('style="', 'style="line-height:' . $line_height . '; text-align: justify; ', $data->bagian_pembuka_surat . $data->bagian_tubuh_surat . $data->bagian_penutup_surat);

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



        if ($pt == 'kokek') {

            $pdf->Ln(5);
            $pdf->Cell(0, 0, 'Hormat kami,', 0, 1, 'L');
            $pdf->Cell(0, 0, 'KOKEK Consulting', 0, 1, 'L');
            $pdf->Ln(20);
            $html = '<b><u>Johny Yulfan, ST, M.Si</u></b>';
            $pdf->writeHTML($html, true, false, true, false, '');

            $pdf->Cell(0, 0, 'Direktur', 0, 1, 'L');
        } else if ($pt == 'chesna') {

            $pdf->Ln(5);
            $pdf->Cell(0, 0, 'Hormat kami,', 0, 1, 'L');
            $pdf->Cell(0, 0, 'PT. CHESNA', 0, 1, 'L');
            $pdf->Ln(20);
            $html = '<b><u>Ni Luh Adiansunyani</u></b>';
            $pdf->writeHTML($html, true, false, true, false, '');

            $pdf->Cell(0, 0, 'Direktur', 0, 1, 'L');
        } else {
        }

        $pdf->lastPage();
        $pdf->Output('Surat Proposal.pdf', 'I');
    }
}
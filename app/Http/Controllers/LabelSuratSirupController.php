<?php

namespace App\Http\Controllers;

use App\Models\Rup;
use Elibyy\TCPDF\TCPDF;
use App\Helpers\Pdf\MYPDF;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class LabelSuratSirupController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $this->data = [];
        $this->data['title'] = "Cetak Label Surat Sirup";

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

        return view('label_surat_sirup.index', $this->data);
    }

    public function buat_label(Request $request)
    {
        $id_organisasi_surat_ditujukan = collect($request['id_organisasi_surat_ditujukan'])->implode(', ');

        
        $pdf = new TCPDF('P', 'mm', array(215.9, 330.2), true, 'UTF-8', false);
        $pdf->SetCreator('Hanif');
        $pdf->SetAuthor('Hanif');
        $pdf->SetTitle('Label Surat Sirup');
        $pdf->SetSubject('LABEL SURAT');
        $pdf->SetKeywords('LABEL SURAT, KOP SURAT');
        $page_format = array(
            'MediaBox' => array('llx' => 0, 'lly' => 0, 'urx' => 60, 'ury' => 40),
        );


        foreach (collect(DB::select("SELECT *,
        (SELECT nama_surat_ditujukan FROM surat_ditujukan WHERE organisasi_surat_ditujukan.id_surat_ditujukan = surat_ditujukan.id) AS nama_surat_ditujukan
        
        FROM organisasi_surat_ditujukan
        JOIN view_organisasi ON organisasi_surat_ditujukan.id_branch_agency = view_organisasi.id_branch_agency
        WHERE id IN ($id_organisasi_surat_ditujukan)")) as $row) {

            $pdf->SetAutoPageBreak(true, 0); // Mengaktifkan margin bottom
            $pdf->SetMargins(2, 2, 2, true);
            $pdf->AddPage('L', $page_format, false, false);
            $pdf->MultiCell(56, 36, '', 0, 'L', 0, 0, '', '', true, 0, false, true, 43, 'M');
            $pdf->setLeftMargin(3);
            $pdf->setRightMargin(3);


            //NAMA ORGANISASI
            if($row->nama_organisasi_utama != ''){
                $nama_organisasi = $row->nama_organisasi_utama;
            } else {
                $nama_organisasi = '';
            }

            //ALAMAT
            if($row->alamat_organisasi != ''){
                $alamat_organisasi = '<br/>' .  str_replace(['<p', '</p>'], ['<', '</>'], $row->alamat_organisasi);
            } else {
                $alamat_organisasi = '';
            }

            //KOTA KABUPATEN
            if($row->nama_kota_kabupaten != ''){

                if($row->kode_pos != ''){
                    $kode_pos = ' - ' . $row->kode_pos;
                } else {
                    $kode_pos = '';
                }

                $nama_kota_kabupaten = '<br/>' . str_replace(['Kota', 'Kabupaten'], '', $row->nama_kota_kabupaten) . $kode_pos;
            } else {
                $nama_kota_kabupaten = '';
            }

            //PROVINSI
            if($row->nama_provinsi_indonesia != ''){
                $nama_provinsi_indonesia = '<br/>' . str_replace('Provinsi', '', $row->nama_provinsi_indonesia);
            } else {
                $nama_provinsi_indonesia = '';
            }

            //NO TELEPON
            if($request['is_submit'] == 2){
                if($row->telepon != ''){
                    $no_tlpn = '<br/>Telp. ' . $row->telepon;
                } else {
                    $no_tlpn = '';
                }
            } else {
                $no_tlpn = '';
            }


            $html = '<br><b style="font-size: 8px;">Kepada Yth.<br/>' . $row->nama_surat_ditujukan . '<br/>' . $nama_organisasi .  $alamat_organisasi . $nama_kota_kabupaten . $nama_provinsi_indonesia . $no_tlpn;
            $pdf->writeHTML($html, true, false, true, false, '');
        }

        $pdf->lastPage();
        $pdf->Output('Label Surat - PT KOKEK.pdf');
    }
}

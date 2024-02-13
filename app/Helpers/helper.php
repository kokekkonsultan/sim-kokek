<?php

    use Illuminate\Support\Facades\DB;
    use App\Organisasi;

	function changeDateFormate($date,$date_format){

	    return \Carbon\Carbon::createFromFormat('Y-m-d', $date)->format($date_format);

	}

	function get_nama_pemberi_kerja($pemberi_kerja, $pemberi_kerja_parent, $nama_kategori_instansi_dari_parent)
    {
        // ORGANISASI
        $teks = $pemberi_kerja;
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
          $ins .= $pecah[$j].' ';
        }

        } else {

        $ins = $teks;

        }


        $nama_organisasi = trim($ins);

        // INSTANSI
        $teks = $pemberi_kerja_parent;
        $pecah = explode(" ", $teks);
        if ($pecah[0] == 'Pemerintah') {

            $nama_instansi = trim(preg_replace("/Pemerintah/","", $teks));

        } else {
            $nama_instansi = $teks;
        }


        $html = '';
        $html .= trim($pemberi_kerja).' ';

        if ($nama_kategori_instansi_dari_parent == 'Kementerian') {

            $html .= $nama_instansi;

        }

        return $html;
    }

    function get_name($user_id)
    {
        $user = DB::table('users')->where('id', $user_id)->first();

        return $user->first_name . " " . $user->last_name;
    }

    function get_organization_name($organization_id)
    {
        $data = Organisasi::where('id_branch_agency', $organization_id)->first();

        // $arr_jenis = ['Pemerintah Kabupaten', 'Pemerintah Kota', 'Pemerintah Provinsi'];
        $arr_jenis = ['Kementerian'];

        $html = '';

        if (in_array($data->nama_kategori_instansi_dari_parent, $arr_jenis)) {

            $html .= $data->nama_organisasi_utama.' '.$data->nama_turunan_organisasi;

        } else {

            $html .= $data->nama_organisasi_utama;

        }

        return $html;
    }

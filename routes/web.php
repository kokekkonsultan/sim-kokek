<?php

use App\Mail\SendEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DpbController;
use App\Http\Controllers\RupController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FipMoController;
use App\Http\Controllers\FipMktController;
use App\Http\Controllers\ProspekController;
use App\Http\Controllers\FipAdproController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SendEmailController;
use App\Http\Controllers\FipDireksiController;
use App\Http\Controllers\LabelSuratController;
use App\Http\Controllers\MasterUnitController;
use App\Http\Controllers\DailyReportController;
use App\Http\Controllers\SelectFilterController;
use App\Http\Controllers\TidakProspekController;
use App\Http\Controllers\CetakProposalController;
use App\Http\Controllers\KabupatenKotaController;
use App\Http\Controllers\KeuanganOmzetController;
use App\Http\Controllers\SuratProposalController;
use App\Http\Controllers\MarketingOmzetController;
use App\Http\Controllers\MasterProposalController;
use App\Http\Controllers\WeeklyPlanningController;
use App\Http\Controllers\DaftarPenawaranController;
use App\Http\Controllers\LabelSuratSirupController;
use App\Http\Controllers\MasterOrganisasiController;
use App\Http\Controllers\PicWilayahMarketingController;
use App\Http\Controllers\PengalamanPerusahaanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/direct-send-email', function () {
//     $data = [
//         'name' => 'Lefi',
//         'body' => 'Testing Kirim Email Laravel'
//     ];

//     Mail::to('lefi.andri@chesna.co.id')->send(new SendEmail($data));

//     dd("Email Berhasil dikirim.");
// });



// Auth::routes();

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
// Route::get('/export-dpb', [\App\Http\Controllers\DpbController::class, 'export_dpb'])->name('export-dpb');
// Route::post('/proses-export-dpb', [\App\Http\Controllers\DpbController::class, 'proses_export_dpb'])->name('proses-export-dpb');

// Route::get('/home', [HomeController::class, 'index'])->name('home');
// Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
// Route::resource('/kabupaten-kota', KabupatenKotaController::class);

// Route::get('/dpb', [DpbController::class, 'index'])->name('dpb');
// Route::post('/dpb/detail-perubahan', [DpbController::class, 'detail_perubahan_dpb'])->name('detail.dpb');

// Route::get('/tanggal', function () {

//     $tanggal_dpb = "2022-12-20";

//     // add 5 days to the current time
//     $tambah_tanggal = \Carbon\Carbon::parse($tanggal_dpb)->addDays(5)->format('Y-m-d');

//     $period = \Carbon\CarbonPeriod::create($tanggal_dpb, $tambah_tanggal);

//     $range = [];
//     // Iterate over the period
//     foreach ($period as $date) {
//         $range[] = $date->format('Y-m-d');
//     }

//     $sekarang = \Carbon\Carbon::now()->format('Y-m-d');
//     // dd($tambah_tanggal);

//     if (in_array($sekarang, $range)) {
//         echo 'Tanggal Ada';
//     } else {
//         echo 'Tanggal Tidak Ada';
//     }
// });



// Route::get('/nama-organisasi', function () {
//     // $dpb = DB::select("SELECT * FROM view_label_surat_organisasi LIMIT 5");
//     // dd($dpb);

//     $organisasi_id = 2792;

//     $data = Organisasi::where('id_branch_agency', $organisasi_id)->first();

//     // $arr_jenis = ['Pemerintah Kabupaten', 'Pemerintah Kota', 'Pemerintah Provinsi'];
//     $arr_jenis = ['Kementerian'];

//     $html = '';

//     if (in_array($data->nama_kategori_instansi_dari_parent, $arr_jenis)) {

//         $html .= $data->nama_organisasi_utama . ' ' . $data->nama_turunan_organisasi;
//     } else {

//         $html .= $data->nama_organisasi_utama;
//     }

//     return $html;
// });



// Route::get('/send-email', [\App\Http\Controllers\SendEmailController::class, 'index'])->name('kirim-email');
// Route::post('/post-email', [\App\Http\Controllers\SendEmailController::class, 'store'])->name('post-email');

Route::get('/send-email', [SendEmailController::class, 'index'])->name('kirim-email');
Route::get('/post-email', [SendEmailController::class, 'store'])->name('post-email');

# PENGALAMAN PERUSAHAAN
Route::get('pengalaman-perusahaan', [PengalamanPerusahaanController::class, 'index'])->name('pengalaman.perusahaan');
Route::post('pengalaman-perusahaan', [PengalamanPerusahaanController::class, 'index']);
Route::post('pengalaman-perusahaan/generate-chart', [PengalamanPerusahaanController::class, 'generate_chart']);

# KEUANGAN OMZET
Route::get('keuangan-omzet', [KeuanganOmzetController::class, 'index'])->name('keuangan-omzet');
Route::post('keuangan-omzet', [KeuanganOmzetController::class, 'index'])->name('keuangan-omzet');
Route::post('keuangan-omzet/validasi', [KeuanganOmzetController::class, 'validasi'])->name('omzet.validasi');
Route::post('keuangan-omzet/proses-validasi', [KeuanganOmzetController::class, 'proses_validasi'])->name('omzet.proses.validasi');

# MARKETING OMZET
Route::get('marketing-omzet', [MarketingOmzetController::class, 'index'])->name('marketing-omzet');
Route::post('marketing-omzet', [MarketingOmzetController::class, 'index'])->name('marketing-omzet');
Route::get('marketing-omzet/get-nilai-pekerjaan', [MarketingOmzetController::class, 'get_nilai_pekerjaan']);
Route::get('marketing-omzet/get-jumlah-pekerjaan', [MarketingOmzetController::class, 'get_jumlah_pekerjaan']);
Route::post('marketing-omzet/generate-chart', [MarketingOmzetController::class, 'generate_chart']);


#RUP
// Route::get('rup', [RupController::class, 'index'])->name('rup.index');
Route::get('rup/{id}', [RupController::class, 'index']);
Route::get('rup/form-import/{id}', [RupController::class, 'form_import']);
Route::post('rup/proses-import/{id}', [RupController::class, 'proses_import']);
Route::post('rup/preview/{id}', [RupController::class, 'preview']);
Route::get('rup/download/{id}', [RupController::class, 'download']);
Route::get('rup/form-add/{id}', [RupController::class, 'form_add']);
Route::post('rup/proses-add/{id}', [RupController::class, 'proses_add']);
Route::post('rup/ubah-ke-prospek/{id}', [RupController::class, 'ubah_ke_prospek']);
Route::post('rup/ubah-ke-tidak-prospek/{id}', [RupController::class, 'ubah_ke_tidak_prospek']);
Route::post('rup/delete-data/{id}', [RupController::class, 'delete_data']);
Route::get('rup/form-edit-input/{id}', [RupController::class, 'form_edit_input']);
Route::post('rup/proses-edit-input/{id}', [RupController::class, 'proses_edit_input']);
Route::get('rup/form-edit-import/{id}', [RupController::class, 'form_edit_import']);
Route::post('rup/proses-edit-import/{id}', [RupController::class, 'proses_edit_import']);
Route::get('rup/export/excel/{id}', [RupController::class, 'proses_export_excel']);

#PROSPEK
Route::get('prospek/{id}', [ProspekController::class, 'index']);
Route::post('prospek/ubah-ke-tidak-prospek/{id}', [ProspekController::class, 'ubah_ke_tidak_prospek']);
Route::post('prospek/delete-data/{id}', [ProspekController::class, 'delete_data']);
Route::get('prospek/form-edit-input/{id}', [ProspekController::class, 'form_edit_input']);
Route::post('prospek/proses-edit-input/{id}', [ProspekController::class, 'proses_edit_input']);
Route::get('prospek/form-edit-import/{id}', [ProspekController::class, 'form_edit_import']);
Route::post('prospek/proses-edit-import/{id}', [ProspekController::class, 'proses_edit_import']);
Route::get('prospek/export/excel/{id}', [ProspekController::class, 'proses_export_excel']);
Route::get('prospek/form-surat/{id}', [ProspekController::class, 'form_surat']);
Route::post('prospek/generate-surat/{id}', [ProspekController::class, 'generate_surat']);
Route::get('prospek/pdf/{id}', [ProspekController::class, 'pdf']);
Route::post('prospek/jadikan-daftar-penawaran/{id}', [ProspekController::class, 'jadikan_daftar_penawaran']);


#TIDAK PROSPEK
Route::get('tidak-prospek/{id}', [TidakProspekController::class, 'index']);
Route::post('tidak-prospek/ubah-ke-rup/{id}', [TidakProspekController::class, 'ubah_ke_rup']);
Route::post('tidak-prospek/ubah-ke-prospek/{id}', [TidakProspekController::class, 'ubah_ke_prospek']);


#DAFTAR PENAWARAN
Route::get('daftar-penawaran/form-add-dengan-rup', [DaftarPenawaranController::class, 'form_add_dengan_rup']);
Route::post('daftar-penawaran/add-dengan-rup', [DaftarPenawaranController::class, 'add_dengan_rup']);
Route::get('daftar-penawaran/form-add-tanpa-rup', [DaftarPenawaranController::class, 'form_add_tanpa_rup']);
Route::post('daftar-penawaran/add-tanpa-rup', [DaftarPenawaranController::class, 'add_tanpa_rup']);
Route::get('daftar-penawaran/form-edit/{id}', [DaftarPenawaranController::class, 'form_edit']);
Route::post('daftar-penawaran/proses-edit/{id}', [DaftarPenawaranController::class, 'proses_edit']);
Route::get('daftar-penawaran/{id}', [DaftarPenawaranController::class, 'index']);
Route::get('daftar-penawaran/cari-id-rup/{id}', [DaftarPenawaranController::class, 'cari_id_rup']);
Route::post('daftar-penawaran/delete-data/{id}', [DaftarPenawaranController::class, 'delete_data']);
Route::get('daftar-penawaran/form-hasil-lelang/{id}', [DaftarPenawaranController::class, 'form_hasil_lelang']);
Route::post('daftar-penawaran/ubah-hasil-lelang/{id}', [DaftarPenawaranController::class, 'ubah_hasil_lelang']);
Route::get('daftar-penawaran/form-jadwal-lelang/{id}', [DaftarPenawaranController::class, 'form_jadwal_lelang']);
Route::post('daftar-penawaran/ubah-jadwal-lelang/{id}', [DaftarPenawaranController::class, 'ubah_jadwal_lelang']);
Route::post('daftar-penawaran/ubah-jadwal-lelang/{id}', [DaftarPenawaranController::class, 'ubah_jadwal_lelang']);
Route::get('daftar-penawaran/publish/{id}', [DaftarPenawaranController::class, 'publish']);
Route::post('daftar-penawaran/add-proposal', [DaftarPenawaranController::class, 'add_proposal']);
Route::get('daftar-penawaran/form-aanwizing/{id}', [DaftarPenawaranController::class, 'form_aanwizing']);
Route::post('daftar-penawaran/publish-aanwizing/{id}', [DaftarPenawaranController::class, 'publish_aanwizing']);
Route::get('daftar-penawaran/form-sanggahan/{id}', [DaftarPenawaranController::class, 'form_sanggahan']);



#SURAT PROPOSAL
Route::get('surat-proposal/{id}', [SuratProposalController::class, 'index']);
Route::get('surat-proposal/form-add/{id}', [SuratProposalController::class, 'form_add']);
Route::post('surat-proposal/proses-add/{id}', [SuratProposalController::class, 'proses_add']);
Route::get('surat-proposal/form-edit/{id}', [SuratProposalController::class, 'form_edit']);
Route::post('surat-proposal/proses-edit/{id}', [SuratProposalController::class, 'proses_edit']);
Route::post('surat-proposal/delete-data/{id}', [SuratProposalController::class, 'delete_data']);
Route::get('surat-proposal/pdf/{id}/{pt}', [SuratProposalController::class, 'pdf']);
Route::get('surat-proposal/form-add/{id}/{id1}', [SuratProposalController::class, 'form_add']);


#MASTER PROPOSAL
Route::post('master-proposal/add', [MasterProposalController::class, 'add']);
Route::post('master-proposal/edit', [MasterProposalController::class, 'edit']);
Route::get('master-proposal/{id}', [MasterProposalController::class, 'index']);
Route::post('master-proposal/delete-data/{id}', [MasterProposalController::class, 'delete_data']);


#CETAK PROPOSAL
Route::get('cetak-proposal/ajax_agency_category', [CetakProposalController::class, 'ajax_agency_category']);
Route::get('cetak-proposal/ajax_agency', [CetakProposalController::class, 'ajax_agency']);
Route::get('cetak-proposal/ajax_organisasi', [CetakProposalController::class, 'ajax_organisasi']);
Route::get('cetak-proposal/ajax_surat_ditujukan', [CetakProposalController::class, 'ajax_surat_ditujukan']);

Route::get('cetak-proposal/{id}', [CetakProposalController::class, 'index']);
Route::get('cetak-proposal/pilih-organisasi/{id}', [CetakProposalController::class, 'pilih_organisasi']);
Route::post('cetak-proposal/buat-proposal/{id}', [CetakProposalController::class, 'buat_proposal']);
Route::post('cetak-proposal/delete-data/{id}', [CetakProposalController::class, 'delete_data']);
Route::get('cetak-proposal/pdf/{id}/{pt}', [CetakProposalController::class, 'pdf']);


#SELECT FILTER
Route::get('select-filter/ajax_agency_category', [SelectFilterController::class, 'ajax_agency_category']);
Route::get('select-filter/ajax_agency', [SelectFilterController::class, 'ajax_agency']);
Route::get('select-filter/ajax_organisasi', [SelectFilterController::class, 'ajax_organisasi']);
Route::get('select-filter/ajax_surat_ditujukan', [SelectFilterController::class, 'ajax_surat_ditujukan']);
Route::get('select-filter/ajax_instansi', [SelectFilterController::class, 'ajax_instansi']);
Route::get('select-filter/ajax_kota_kabupaten', [SelectFilterController::class, 'ajax_kota_kabupaten']);
Route::get('select-filter/ajax_contact_person', [SelectFilterController::class, 'ajax_contact_person']);


#LABEL SURAT SIRUP
Route::get('label-surat-sirup', [LabelSuratSirupController::class, 'index']);
Route::post('label-surat-sirup/buat-label', [LabelSuratSirupController::class, 'buat_label']);


#MASTER ORGANISASI
Route::get('master-organisasi/form-label-pengirim', [MasterOrganisasiController::class, 'form_label_pengirim']);
Route::get('master-organisasi/proses-label-pengirim', [MasterOrganisasiController::class, 'proses_label_pengirim']);
Route::get('master-organisasi/form-add', [MasterOrganisasiController::class, 'form_add']);
Route::post('master-organisasi/proses-add', [MasterOrganisasiController::class, 'proses_add']);
Route::get('master-organisasi/{id}', [MasterOrganisasiController::class, 'index']);
Route::get('master-organisasi/form-edit/{id}', [MasterOrganisasiController::class, 'form_edit']);
Route::post('master-organisasi/proses-edit/{id}', [MasterOrganisasiController::class, 'proses_edit']);
Route::post('master-organisasi/proses-add-surat-ditujukan/{id}', [MasterOrganisasiController::class, 'proses_add_surat_ditujukan']);
Route::post('master-organisasi/delete-surat-kepada/{id}', [MasterOrganisasiController::class, 'delete_surat_kepada']);
Route::post('master-organisasi/delete-organisasi/{id}', [MasterOrganisasiController::class, 'delete_organisasi']);
Route::get('master-organisasi/log-aktivitas/{id}', [MasterOrganisasiController::class, 'log_aktivitas']);


#LABEL SURAT ORGANISASI
Route::get('label-surat', [LabelSuratController::class, 'index']);
Route::post('label-surat/buat-label', [LabelSuratController::class, 'buat_label']);

#MASTER UNIT
Route::get('master-unit/form-add', [MasterUnitController::class, 'form_add']);
Route::post('master-unit/proses-add', [MasterUnitController::class, 'proses_add']);
Route::get('master-unit/{id}', [MasterUnitController::class, 'index']);
Route::get('master-unit/form-edit/{id}', [MasterUnitController::class, 'form_edit']);
Route::post('master-unit/proses-edit/{id}', [MasterUnitController::class, 'proses_edit']);
Route::post('master-unit/proses-add-surat-ditujukan/{id}', [MasterUnitController::class, 'proses_add_surat_ditujukan']);
Route::post('master-unit/delete-surat-kepada/{id}', [MasterUnitController::class, 'delete_surat_kepada']);
Route::post('master-unit/delete-organisasi/{id}', [MasterUnitController::class, 'delete_organisasi']);


#PIC WILAYAH MARKETING
Route::post('pic-wilayah-marketing/delete-wilayah/{id}', [PicWilayahMarketingController::class, 'delete_wilayah']);
Route::post('pic-wilayah-marketing/edit-wilayah/{id}', [PicWilayahMarketingController::class, 'edit_wilayah']);
Route::post('pic-wilayah-marketing/add-wilayah/{id}', [PicWilayahMarketingController::class, 'add_wilayah']);
Route::post('pic-wilayah-marketing/delete-data/{id}', [PicWilayahMarketingController::class, 'delete_data']);
Route::post('pic-wilayah-marketing/proses-edit/{id}', [PicWilayahMarketingController::class, 'proses_edit']);
Route::get('pic-wilayah-marketing/form-edit/{id}', [PicWilayahMarketingController::class, 'form_edit']);
Route::post('pic-wilayah-marketing/proses-add', [PicWilayahMarketingController::class, 'proses_add']);
Route::get('pic-wilayah-marketing/form-add', [PicWilayahMarketingController::class, 'form_add']);
Route::get('pic-wilayah-marketing/{id}', [PicWilayahMarketingController::class, 'index']);


#DPB
Route::get('dpb/export', [DpbController::class, 'export']);
Route::get('dpb/{id}', [DpbController::class, 'index']);
Route::get('dpb/detail/{id}', [DpbController::class, 'detail']);
Route::get('dpb/form-add/{id}', [DpbController::class, 'form_add']);
Route::get('dpb/cari-id-dil/{id}', [DpbController::class, 'cari_id_dil']);
Route::post('dpb/proses-add/{id}', [DpbController::class, 'proses_add']);
Route::get('dpb/form-next-add/{id}', [DpbController::class, 'form_next_add']);
Route::post('dpb/proses-next-add/{id}', [DpbController::class, 'proses_next_add']);
Route::get('dpb/form-edit/{id}', [DpbController::class, 'form_edit']);
Route::post('dpb/proses-edit/{id}', [DpbController::class, 'proses_edit']);
Route::post('dpb/delete-dpb/{id}', [DpbController::class, 'delete_dpb']);

Route::post('dpb/add-termin/{id}', [DpbController::class, 'add_termin']);
Route::post('dpb/delete-termin/{id}', [DpbController::class, 'delete_termin']);
Route::post('dpb/add-tenaga-ahli/{id}', [DpbController::class, 'add_tenaga_ahli']);
Route::post('dpb/edit-tenaga-ahli/{id}', [DpbController::class, 'edit_tenaga_ahli']);
Route::post('dpb/delete-tenaga-ahli/{id}', [DpbController::class, 'delete_tenaga_ahli']);
Route::post('dpb/add-objek-pekerjaan/{id}', [DpbController::class, 'add_objek_pekerjaan']);
Route::post('dpb/edit-objek-pekerjaan/{id}', [DpbController::class, 'edit_objek_pekerjaan']);
Route::post('dpb/delete-objek-pekerjaan/{id}', [DpbController::class, 'delete_objek_pekerjaan']);

Route::get('dpb/modal_tanggal_terima_kontrak/{id}', [DpbController::class, 'modal_tanggal_terima_kontrak']);
Route::post('dpb/edit_tanggal_terima_kontrak/{id}', [DpbController::class, 'edit_tanggal_terima_kontrak']);
Route::get('dpb/modal_tanggal_terima_surat_referensi/{id}', [DpbController::class, 'modal_tanggal_terima_surat_referensi']);
Route::post('dpb/edit_tanggal_terima_surat_referensi/{id}', [DpbController::class, 'edit_tanggal_terima_surat_referensi']);
Route::get('dpb/modal_info_perubahan/{id}', [DpbController::class, 'modal_info_perubahan']);
Route::post('dpb/publish/{id}', [DpbController::class, 'publish']);


#FIP MARKETING
Route::get('fip-mkt/export', [FipMktController::class, 'export']);

Route::post('fip-mkt/add-tanggapan', [FipMktController::class, 'add_tanggapan']);
Route::post('fip-mkt/delete-tanggapan/{id}', [FipMktController::class, 'delete_tanggapan']);

Route::post('fip-mkt/add-catatan', [FipMktController::class, 'add_catatan']);
Route::get('fip-mkt/modal-edit-catatan/{id}', [FipMktController::class, 'modal_edit_catatan']);
Route::post('fip-mkt/edit-catatan/{id}', [FipMktController::class, 'edit_catatan']);
Route::post('fip-mkt/delete-catatan/{id}', [FipMktController::class, 'delete_catatan']);

Route::post('fip-mkt/add-biaya', [FipMktController::class, 'add_biaya']);
Route::get('fip-mkt/modal-edit-biaya/{id}', [FipMktController::class, 'modal_edit_biaya']);
Route::post('fip-mkt/edit-biaya/{id}', [FipMktController::class, 'edit_biaya']);
Route::post('fip-mkt/delete-biaya/{id}', [FipMktController::class, 'delete_biaya']);

Route::post('fip-mkt/proses-add', [FipMktController::class, 'proses_add']);
Route::get('fip-mkt/form-add', [FipMktController::class, 'form_add']);
Route::get('fip-mkt/{id}', [FipMktController::class, 'index']);
Route::get('fip-mkt/cari-id-dpb/{id}', [FipMktController::class, 'cari_id_dpb']);
Route::get('fip-mkt/form-edit/{id}', [FipMktController::class, 'form_edit']);
Route::post('fip-mkt/proses-edit/{id}', [FipMktController::class, 'proses_edit']);
Route::post('fip-mkt/delete-data/{id}', [FipMktController::class, 'delete_data']);
Route::get('fip-mkt/form-next-edit/{id}', [FipMktController::class, 'form_next_edit']);
Route::get('fip-mkt/detail/{id}', [FipMktController::class, 'detail']);
Route::post('fip-mkt/publish/{id}', [FipMktController::class, 'publish']);

Route::get('fip-mkt/modal-tanggal-bast/{id}', [FipMktController::class, 'modal_tanggal_bast']);
Route::post('fip-mkt/ubah-tanggal-bast/{id}', [FipMktController::class, 'ubah_tanggal_bast']);


#FIP MO
Route::get('fip-mo/export', [FipMoController::class, 'export']);
Route::post('fip-mo/add-catatan', [FipMoController::class, 'add_catatan']);
Route::get('fip-mo/{id}', [FipMoController::class, 'index']);
Route::get('fip-mo/modal-tunjuk-pic/{id}', [FipMoController::class, 'modal_tunjuk_pic']);
Route::post('fip-mo/tunjuk-pic/{id}', [FipMoController::class, 'tunjuk_pic']);
Route::get('fip-mo/approved/{id}', [FipMoController::class, 'approved']);
Route::get('fip-mo/catatan/{id}', [FipMoController::class, 'catatan']);
Route::post('fip-mo/edit-catatan/{id}', [FipMoController::class, 'edit_catatan']);
Route::post('fip-mo/delete-catatan/{id}', [FipMoController::class, 'delete_catatan']);


#FIP ADPRO
Route::get('fip-adpro/export', [FipAdproController::class, 'export']);
Route::post('fip-adpro/add-catatan', [FipAdproController::class, 'add_catatan']);
Route::get('fip-adpro/{id}', [FipAdproController::class, 'index']);
Route::get('fip-adpro/modal-tunjuk-pic/{id}', [FipAdproController::class, 'modal_tunjuk_pic']);
Route::post('fip-adpro/tunjuk-pic/{id}', [FipAdproController::class, 'tunjuk_pic']);
Route::get('fip-adpro/catatan/{id}', [FipAdproController::class, 'catatan']);
Route::post('fip-adpro/edit-catatan/{id}', [FipAdproController::class, 'edit_catatan']);
Route::post('fip-adpro/delete-catatan/{id}', [FipAdproController::class, 'delete_catatan']);


#FIP DIREKSI
Route::get('fip-direksi/export', [FipDireksiController::class, 'export']);
Route::post('fip-direksi/add-catatan', [FipDireksiController::class, 'add_catatan']);
Route::get('fip-direksi/{id}', [FipDireksiController::class, 'index']);
Route::get('fip-direksi/modal-tunjuk-pic/{id}', [FipDireksiController::class, 'modal_tunjuk_pic']);
Route::post('fip-direksi/tunjuk-pic/{id}', [FipDireksiController::class, 'tunjuk_pic']);
Route::get('fip-direksi/approved/{id}', [FipDireksiController::class, 'approved']);
Route::get('fip-direksi/catatan/{id}', [FipDireksiController::class, 'catatan']);
Route::post('fip-direksi/edit-catatan/{id}', [FipDireksiController::class, 'edit_catatan']);
Route::post('fip-direksi/delete-catatan/{id}', [FipDireksiController::class, 'delete_catatan']);



#DAILY REPORT
Route::post('daily-report/add', [DailyReportController::class, 'add']);
Route::post('daily-report/add_tindak_lanjut', [DailyReportController::class, 'add_tindak_lanjut']);
Route::get('daily-report/{id}', [DailyReportController::class, 'index']);
Route::get('daily-report/show_modal_tindak_lanjut/{id}', [DailyReportController::class, 'show_modal_tindak_lanjut']);
Route::get('daily-report/show_modal_edit/{id}', [DailyReportController::class, 'show_modal_edit']);
Route::post('daily-report/edit/{id}', [DailyReportController::class, 'edit']);
Route::post('daily-report/delete/{id}', [DailyReportController::class, 'delete']);


#Weekly PLANNING
Route::get('weekly-planning/{id}', [WeeklyPlanningController::class, 'index']);

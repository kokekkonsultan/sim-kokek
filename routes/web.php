<?php

use App\Mail\SendEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DpbController;
use App\Http\Controllers\RupController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProspekController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SendEmailController;
use App\Http\Controllers\LabelSuratController;
use App\Http\Controllers\SelectFilterController;
use App\Http\Controllers\TidakProspekController;
use App\Http\Controllers\CetakProposalController;
use App\Http\Controllers\KabupatenKotaController;
use App\Http\Controllers\KeuanganOmzetController;
use App\Http\Controllers\SuratProposalController;
use App\Http\Controllers\MarketingOmzetController;
use App\Http\Controllers\MasterProposalController;
use App\Http\Controllers\DaftarPenawaranController;
use App\Http\Controllers\LabelSuratSirupController;
use App\Http\Controllers\MasterOrganisasiController;
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

// PENGALAMAN PERUSAHAAN
Route::get('pengalaman-perusahaan', [PengalamanPerusahaanController::class, 'index'])->name('pengalaman.perusahaan');
Route::post('pengalaman-perusahaan', [PengalamanPerusahaanController::class, 'index']);
Route::post('pengalaman-perusahaan/generate-chart', [PengalamanPerusahaanController::class, 'generate_chart']);

// KEUANGAN OMZET
Route::get('keuangan-omzet', [KeuanganOmzetController::class, 'index'])->name('keuangan-omzet');
Route::post('keuangan-omzet', [KeuanganOmzetController::class, 'index'])->name('keuangan-omzet');
Route::post('keuangan-omzet/validasi', [KeuanganOmzetController::class, 'validasi'])->name('omzet.validasi');
Route::post('keuangan-omzet/proses-validasi', [KeuanganOmzetController::class, 'proses_validasi'])->name('omzet.proses.validasi');

// MARKETING OMZET
Route::get('marketing-omzet', [MarketingOmzetController::class, 'index'])->name('marketing-omzet');
Route::post('marketing-omzet', [MarketingOmzetController::class, 'index'])->name('marketing-omzet');
Route::get('marketing-omzet/get-nilai-pekerjaan', [MarketingOmzetController::class, 'get_nilai_pekerjaan']);
Route::get('marketing-omzet/get-jumlah-pekerjaan', [MarketingOmzetController::class, 'get_jumlah_pekerjaan']);
Route::post('marketing-omzet/generate-chart', [MarketingOmzetController::class, 'generate_chart']);


//RUP
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

//PROSPEK
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


//TIDAK PROSPEK
Route::get('tidak-prospek/{id}', [TidakProspekController::class, 'index']);
Route::post('tidak-prospek/ubah-ke-rup/{id}', [TidakProspekController::class, 'ubah_ke_rup']);
Route::post('tidak-prospek/ubah-ke-prospek/{id}', [TidakProspekController::class, 'ubah_ke_prospek']);


//DAFTAR PENAWARAN
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


//SURAT PROPOSAL
Route::get('surat-proposal/{id}', [SuratProposalController::class, 'index']);
Route::get('surat-proposal/form-add/{id}', [SuratProposalController::class, 'form_add']);
Route::post('surat-proposal/proses-add/{id}', [SuratProposalController::class, 'proses_add']);
Route::get('surat-proposal/form-edit/{id}', [SuratProposalController::class, 'form_edit']);
Route::post('surat-proposal/proses-edit/{id}', [SuratProposalController::class, 'proses_edit']);
Route::post('surat-proposal/delete-data/{id}', [SuratProposalController::class, 'delete_data']);
Route::get('surat-proposal/pdf/{id}/{pt}', [SuratProposalController::class, 'pdf']);
Route::get('surat-proposal/form-add/{id}/{id1}', [SuratProposalController::class, 'form_add']);


//MASTER PROPOSAL
Route::post('master-proposal/add', [MasterProposalController::class, 'add']);
Route::post('master-proposal/edit', [MasterProposalController::class, 'edit']);
Route::get('master-proposal/{id}', [MasterProposalController::class, 'index']);
Route::post('master-proposal/delete-data/{id}', [MasterProposalController::class, 'delete_data']);


//CETAK PROPOSAL
Route::get('cetak-proposal/ajax_agency_category', [CetakProposalController::class, 'ajax_agency_category']);
Route::get('cetak-proposal/ajax_agency', [CetakProposalController::class, 'ajax_agency']);
Route::get('cetak-proposal/ajax_organisasi', [CetakProposalController::class, 'ajax_organisasi']);
Route::get('cetak-proposal/ajax_surat_ditujukan', [CetakProposalController::class, 'ajax_surat_ditujukan']);

Route::get('cetak-proposal/{id}', [CetakProposalController::class, 'index']);
Route::get('cetak-proposal/pilih-organisasi/{id}', [CetakProposalController::class, 'pilih_organisasi']);
Route::post('cetak-proposal/buat-proposal/{id}', [CetakProposalController::class, 'buat_proposal']);
Route::post('cetak-proposal/delete-data/{id}', [CetakProposalController::class, 'delete_data']);
Route::get('cetak-proposal/pdf/{id}/{pt}', [CetakProposalController::class, 'pdf']);


//SELECT FILTER
Route::get('select-filter/ajax_agency_category', [SelectFilterController::class, 'ajax_agency_category']);
Route::get('select-filter/ajax_agency', [SelectFilterController::class, 'ajax_agency']);
Route::get('select-filter/ajax_organisasi', [SelectFilterController::class, 'ajax_organisasi']);
Route::get('select-filter/ajax_surat_ditujukan', [SelectFilterController::class, 'ajax_surat_ditujukan']);
Route::get('select-filter/ajax_instansi', [SelectFilterController::class, 'ajax_instansi']);
Route::get('select-filter/ajax_kota_kabupaten', [SelectFilterController::class, 'ajax_kota_kabupaten']);



//LABEL SURAT SIRUP
Route::get('label-surat-sirup', [LabelSuratSirupController::class, 'index']);
Route::post('label-surat-sirup/buat-label', [LabelSuratSirupController::class, 'buat_label']);


//MASTER ORGANISASI
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


//LABEL SURAT ORGANISASI
Route::get('label-surat', [LabelSuratController::class, 'index']);
Route::post('label-surat/buat-label', [LabelSuratController::class, 'buat_label']);
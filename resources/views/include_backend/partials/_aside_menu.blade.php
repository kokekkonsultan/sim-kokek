{{-- <div class="text-center mt-5">
    <div class="symbol symbol-60 symbol-xxl-100 mr-5 align-self-start align-self-xxl-center" id="photo_profile">
       <img src="{{ asset('assets/img/photo_profile/200px.jpg') }}" alt="Maxwell Admin" style="width: 100px;
height:100px;">
<i class="symbol-badge bg-success"></i>
</div>
</div> --}}

<div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">
    <div id="kt_aside_menu" class="aside-menu my-4" data-menu-vertical="1" data-menu-scroll="1" data-menu-dropdown-timeout="500">
        <ul class="menu-nav">

            @php
            $uri_selected = Request::segment(1);
            if (in_array($uri_selected, ['dashboard'])) {
            $child_menu_active = 'menu-item-active';
            } else {
            $child_menu_active = '';
            }
            @endphp

            <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                <a href="/dashboard" class="menu-link">
                    <span class="svg-icon menu-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <polygon points="0 0 24 0 24 24 0 24" />
                                <path d="M12.9336061,16.072447 L19.36,10.9564761 L19.5181585,10.8312381 C20.1676248,10.3169571 20.2772143,9.3735535 19.7629333,8.72408713 C19.6917232,8.63415859 19.6104327,8.55269514 19.5206557,8.48129411 L12.9336854,3.24257445 C12.3871201,2.80788259 11.6128799,2.80788259 11.0663146,3.24257445 L4.47482784,8.48488609 C3.82645598,9.00054628 3.71887192,9.94418071 4.23453211,10.5925526 C4.30500305,10.6811601 4.38527899,10.7615046 4.47382636,10.8320511 L4.63,10.9564761 L11.0659024,16.0730648 C11.6126744,16.5077525 12.3871218,16.5074963 12.9336061,16.072447 Z" fill="#000000" fill-rule="nonzero" />
                                <path d="M11.0563554,18.6706981 L5.33593024,14.122919 C4.94553994,13.8125559 4.37746707,13.8774308 4.06710397,14.2678211 C4.06471678,14.2708238 4.06234874,14.2738418 4.06,14.2768747 L4.06,14.2768747 C3.75257288,14.6738539 3.82516916,15.244888 4.22214834,15.5523151 C4.22358765,15.5534297 4.2250303,15.55454 4.22647627,15.555646 L11.0872776,20.8031356 C11.6250734,21.2144692 12.371757,21.2145375 12.909628,20.8033023 L19.7677785,15.559828 C20.1693192,15.2528257 20.2459576,14.6784381 19.9389553,14.2768974 C19.9376429,14.2751809 19.9363245,14.2734691 19.935,14.2717619 L19.935,14.2717619 C19.6266937,13.8743807 19.0546209,13.8021712 18.6572397,14.1104775 C18.654352,14.112718 18.6514778,14.1149757 18.6486172,14.1172508 L12.9235044,18.6705218 C12.377022,19.1051477 11.6029199,19.1052208 11.0563554,18.6706981 Z" fill="#000000" opacity="0.3" />
                            </g>
                        </svg>
                    </span>
                    <span class="menu-text">Dashboard</span>
                </a>
            </li>

            @php
            $menu_master = ['agency_category', 'master_instansi', 'master-organisasi', 'master-unit', 'kabupaten-kota',
            'surat_ditujukan', 'contact_person', 'bidang_pekerjaan', 'jenis_proposal', 'master-proposal',
            'surat-proposal', 'kompetitor_rev', 'data_pengalaman_perusahaan', 'data_surveyor',
            'data_entry_data', 'uraian_tugas', 'pic-wilayah-marketing'];
            
            $uri_selected = Request::segment(1);
            $link_active = '';
            if (in_array($uri_selected, $menu_master)) {

            $main_menu_active = "menu-item-open menu-item-here";
            $parent_menu_active = "menu-item-open menu-item-here";

            } else {
            $main_menu_active = "";
            $parent_menu_active = "";
            }
            @endphp

            <li class="menu-item menu-item-submenu {{ $main_menu_active }}" aria-haspopup="true" data-menu-toggle="hover">
                <a href="javascript:;" class="menu-link menu-toggle">
                    <span class="svg-icon menu-icon">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Bucket.svg-->
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24" />
                                <path d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z" fill="#000000" />
                                <rect fill="#000000" opacity="0.3" transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519)" x="16.3255682" y="2.94551858" width="3" height="18" rx="1" />
                            </g>
                        </svg>
                        <!--end::Svg Icon-->
                    </span>
                    <span class="menu-text">Master</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="menu-submenu">
                    <i class="menu-arrow"></i>
                    <ul class="menu-subnav">
                        <li class="menu-item menu-item-parent" aria-haspopup="true">
                            <span class="menu-link">
                                <span class="menu-text">Themes</span>
                            </span>
                        </li>

                        @php
                        (Request::segment(1) == 'agency_category') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        @endphp
                        <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                            <a href="/agency_category" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Kategori Instansi</span>
                            </a>
                        </li>

                        @php
                        (Request::segment(1) == 'master_instansi') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        @endphp
                        <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                            <a href="/master_instansi" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Data Instansi</span>
                            </a>
                        </li>

                        @php
                        (Request::segment(1) == 'master-organisasi') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        @endphp
                        <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                            <a href="/master-organisasi/6" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Data Organisasi</span>
                            </a>
                        </li>

                        @php
                        (Request::segment(1) == 'master-unit') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        @endphp
                        <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                            <a href="/master-unit/6" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Data Unit</span>
                            </a>
                        </li>

                        @php
                        (Request::segment(1) == 'kabupaten-kota') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        @endphp
                        <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                            <a href="/kabupaten-kota" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Data Kabupaten Kota</span>
                            </a>
                        </li>

                        @php
                        (Request::segment(1) == 'surat_ditujukan') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        @endphp
                        <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                            <a href="/surat_ditujukan" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Surat Ditujukan</span>
                            </a>
                        </li>

                        @php
                        (Request::segment(1) == 'contact_person') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        @endphp
                        <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                            <a href="/contact_person" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Contact Person</span>
                            </a>
                        </li>

                        @php
                        (Request::segment(1) == 'bidang_pekerjaan') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        @endphp
                        <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                            <a href="/bidang_pekerjaan" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Produk/ Bidang Pekerjaan</span>
                            </a>
                        </li>

                        @php
                        (Request::segment(1) == 'jenis_proposal') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        @endphp
                        <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                            <a href="/jenis_proposal" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Jenis Proposal</span>
                            </a>
                        </li>

                        @php
                        (Request::segment(1) == 'master-proposal') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        @endphp
                        <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                            <a href="/master-proposal/6" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Proposal</span>
                            </a>
                        </li>

                        @php
                        (Request::segment(1) == 'surat-proposal') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        @endphp
                        <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                            <a href="/surat-proposal/6" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Surat Proposal</span>
                            </a>
                        </li>

                        @php
                        (Request::segment(1) == 'kompetitor_rev') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        @endphp
                        <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                            <a href="/kompetitor_rev" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Kompetitor</span>
                            </a>
                        </li>

                        @php
                        (Request::segment(1) == 'data_pengalaman_perusahaan') ? $child_menu_active = 'menu-item-active'
                        :
                        $child_menu_active = '';
                        @endphp
                        <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                            <a href="/data_pengalaman_perusahaan" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Data Pengalaman Perusahaan (Input Manual)</span>
                            </a>
                        </li>

                        @php
                        (Request::segment(1) == 'data_surveyor') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        @endphp
                        <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                            <a href="/data_surveyor" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Data Surveyor</span>
                            </a>
                        </li>

                        @php
                        (Request::segment(1) == 'data_entry_data') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        @endphp
                        <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                            <a href="/data_entry_data" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Data Entry Data</span>
                            </a>
                        </li>

                        @php
                        (Request::segment(1) == 'uraian_tugas') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        @endphp
                        <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                            <a href="/uraian_tugas" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Uraian Tugas</span>
                            </a>
                        </li>

                        @php
                        (Request::segment(1) == 'pic-wilayah-marketing') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        @endphp
                        <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                            <a href="/pic-wilayah-marketing/6" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Data PIC Wilayah Marketing</span>
                            </a>
                        </li>

                    </ul>
                </div>
            </li>

            @php
            $menu_master = ['dpb', 'tidak-prospek', 'data_perusahaan', 'nomor_surat', 'cetak-proposal', 'tenaga_ahli',
            'pengalaman_tenaga_ahli', 'rup', 'prospek', 'daftar-penawaran', 'daftar_informasi_seleksi',
            'dokumen_penawaran', 'data_prakualifikasi', 'daftar_proyek_berjalan', 'pekerjaan_sedang_berjalan',
            'marketing-omzet', 'keuangan-omzet', 'formulir_informasi_pekerjaan', 'pengalaman_perusahaan',
            'surat_referensi', 'data_peralatan_prakualifikasi'];
            $uri_selected = Request::segment(1);

            $link_active = '';
            if (in_array($uri_selected, $menu_master)) {

            $main_menu_active = "menu-item-open menu-item-here";
            $parent_menu_active = "menu-item-open menu-item-here";

            } else {
            $main_menu_active = "";
            $parent_menu_active = "";
            }
            @endphp

            <li class="menu-item menu-item-submenu {{ $main_menu_active }}" aria-haspopup="true" data-menu-toggle="hover">
                <a href="javascript:;" class="menu-link menu-toggle">
                    <span class="svg-icon menu-icon">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Bucket.svg-->
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24" />
                                <path d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z" fill="#000000" />
                                <rect fill="#000000" opacity="0.3" transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519)" x="16.3255682" y="2.94551858" width="3" height="18" rx="1" />
                            </g>
                        </svg>
                        <!--end::Svg Icon-->
                    </span>
                    <span class="menu-text">Marketing</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="menu-submenu">
                    <i class="menu-arrow"></i>
                    <ul class="menu-subnav">
                        <li class="menu-item menu-item-parent" aria-haspopup="true">
                            <span class="menu-link">
                                <span class="menu-text">Themes</span>
                            </span>
                        </li>

                        @php
                        (Request::segment(1) == 'data_perusahaan') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        @endphp
                        <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                            <a href="/data_perusahaan" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Data Perusahaan</span>
                            </a>
                        </li>

                        @php
                        (Request::segment(1) == 'nomor_surat') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        @endphp
                        <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                            <a href="/nomor_surat" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Nomor Surat</span>
                            </a>
                        </li>

                        @php
                        (Request::segment(1) == 'cetak-proposal') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        @endphp
                        <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                            <a href="/cetak-proposal/6" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Cetak Surat Proposal</span>
                            </a>
                        </li>

                        @php
                        (Request::segment(1) == 'tenaga-ahli') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        @endphp
                        <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                            <a href="/tenaga-ahli" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Tenaga Ahli</span>
                            </a>
                        </li>

                        @php
                        (Request::segment(1) == 'pengalaman_tenaga_ahli') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        @endphp
                        <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                            <a href="/pengalaman_tenaga_ahli" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Pengalaman Tenaga Ahli</span>
                            </a>
                        </li>

                        @php
                        (Request::segment(1) == 'rup') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        @endphp
                        <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                            <a href="/rup/6" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">RUP</span>
                            </a>
                        </li>

                        @php
                        (Request::segment(1) == 'prospek') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        @endphp
                        <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                            <a href="/prospek/6" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Prospek</span>
                            </a>
                        </li>

                        @php
                        (Request::segment(1) == 'tidak-prospek') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        @endphp
                        <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                            <a href="/tidak-prospek/6" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Tidak Prospek</span>
                            </a>
                        </li>

                        @php
                        (Request::segment(1) == 'daftar-penawaran') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        @endphp
                        <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                            <a href="/daftar-penawaran/6" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Daftar Penawaran</span>
                            </a>
                        </li>

                        @php
                        (Request::segment(1) == 'daftar_informasi_seleksi') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        @endphp
                        <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                            <a href="/daftar_informasi_seleksi" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Daftar Informasi Seleksi</span>
                            </a>
                        </li>

                        @php
                        (Request::segment(1) == 'dokumen_penawaran') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        @endphp
                        <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                            <a href="/dokumen_penawaran" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Dokumen Penawaran</span>
                            </a>
                        </li>

                        @php
                        (Request::segment(1) == 'data_prakualifikasi') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        @endphp
                        <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                            <a href="/data_prakualifikasi" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Dokumen Prakualifikasi</span>
                            </a>
                        </li>

                        @php
                        (Request::segment(1) == 'dpb') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        @endphp
                        <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                            <a href="/dpb/6" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Daftar Proyek Berjalan (DPB)</span>
                            </a>
                        </li>

                        @php
                        (Request::segment(1) == 'pekerjaan-sedang-berjalan') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        @endphp
                        <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                            <a href="/pekerjaan-sedang-berjalan" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Pekerjaan Sedang Berjalan</span>
                            </a>
                        </li>

                        @php
                        (Request::segment(1) == 'marketing-omzet') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        @endphp
                        <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                            <a href="/marketing-omzet" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Omzet</span>
                            </a>
                        </li>

                        @php
                        (Request::segment(1) == 'formulir_informasi_pekerjaan') ? $child_menu_active =
                        'menu-item-active' :
                        $child_menu_active = '';
                        @endphp
                        <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                            <a href="/formulir_informasi_pekerjaan" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Formulir Informasi Pekerjaan (FIP)</span>
                            </a>
                        </li>

                        @php
                        (Request::segment(1) == 'pengalaman_perusahaan') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        @endphp
                        <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                            <a href="/pengalaman-perusahaan" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Pengalaman Perusahaan</span>
                            </a>
                        </li>

                        @php
                        (Request::segment(1) == 'surat_referensi') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        @endphp
                        <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                            <a href="/surat_referensi" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Surat Referensi</span>
                            </a>
                        </li>

                        @php
                        (Request::segment(1) == 'data_peralatan_prakualifikasi') ? $child_menu_active =
                        'menu-item-active' :
                        $child_menu_active = '';
                        @endphp
                        <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                            <a href="/data_peralatan_prakualifikasi" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Data Peralatan Prakualifikasi</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            @php
            $menu_master = ['keuangan-omzet'];
            $uri_selected = Request::segment(1);

            $link_active = '';
            if (in_array($uri_selected, $menu_master)) {

            $main_menu_active = "menu-item-open menu-item-here";
            $parent_menu_active = "menu-item-open menu-item-here";

            } else {
            $main_menu_active = "";
            $parent_menu_active = "";
            }
            @endphp

            <li class="menu-item menu-item-submenu {{ $main_menu_active }}" aria-haspopup="true" data-menu-toggle="hover">
                <a href="javascript:;" class="menu-link menu-toggle">
                    <span class="svg-icon menu-icon">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Bucket.svg-->
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24" />
                                <path d="M5,3 L6,3 C6.55228475,3 7,3.44771525 7,4 L7,20 C7,20.5522847 6.55228475,21 6,21 L5,21 C4.44771525,21 4,20.5522847 4,20 L4,4 C4,3.44771525 4.44771525,3 5,3 Z M10,3 L11,3 C11.5522847,3 12,3.44771525 12,4 L12,20 C12,20.5522847 11.5522847,21 11,21 L10,21 C9.44771525,21 9,20.5522847 9,20 L9,4 C9,3.44771525 9.44771525,3 10,3 Z" fill="#000000" />
                                <rect fill="#000000" opacity="0.3" transform="translate(17.825568, 11.945519) rotate(-19.000000) translate(-17.825568, -11.945519)" x="16.3255682" y="2.94551858" width="3" height="18" rx="1" />
                            </g>
                        </svg>
                        <!--end::Svg Icon-->
                    </span>
                    <span class="menu-text">Keuangan</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="menu-submenu">
                    <i class="menu-arrow"></i>
                    <ul class="menu-subnav">
                        <li class="menu-item menu-item-parent" aria-haspopup="true">
                            <span class="menu-link">
                                <span class="menu-text">Themes</span>
                            </span>
                        </li>

                        @php
                        (Request::segment(1) == 'keuangan-omzet') ? $child_menu_active = 'menu-item-active' :
                        $child_menu_active = '';
                        @endphp
                        <li class="menu-item {{ $child_menu_active }}" aria-haspopup="true">
                            <a href="/keuangan-omzet" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Omzet</span>
                            </a>
                        </li>



                    </ul>
                </div>
            </li>

        </ul>
    </div>
</div>
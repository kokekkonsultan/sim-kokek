@php
$users = DB::table('users')->where('id', Session::get('id_users'))->first();
@endphp

<div id="kt_header" class="header header-fixed">
    <div class="container-fluid d-flex align-items-stretch justify-content-between">
	<div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
            <div id="kt_header_menu" class="header-menu header-menu-mobile header-menu-layout-default">
                <ul class="menu-nav">
                    <li class="menu-item menu-item-submenu menu-item-rel menu-item-active" data-menu-toggle="click"
                        aria-haspopup="true">
                        <div class="menu-link menu-toggle">
                            <span class="menu-text font-weight-bold">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-calendar3" viewBox="0 0 16 16">
                                    <path
                                        d="M14 0H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zM1 3.857C1 3.384 1.448 3 2 3h12c.552 0 1 .384 1 .857v10.286c0 .473-.448.857-1 .857H2c-.552 0-1-.384-1-.857V3.857z" />
                                    <path
                                        d="M6.5 7a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-9 3a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm3 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" />
                                </svg>
                            </span>
                        </div>
                    </li>

                    <li class="menu-item menu-item-submenu menu-item-rel menu-item-active" data-menu-toggle="click"
                        aria-haspopup="true">
                        <div class="menu-link menu-toggle">
                            <span class="menu-text font-weight-bold">

                                @php
								$bulan = array(
									1 =>   'Januari',
									'Februari',
									'Maret',
									'April',
									'Mei',
									'Juni',
									'Juli',
									'Agustus',
									'September',
									'Oktober',
									'November',
									'Desember'
								);
								$get_bulan = $bulan[(int)date("m")];

								$hari = array(
									1 =>    'Senin',
									'Selasa',
									'Rabu',
									'Kamis',
									'Jumat',
									'Sabtu',
									'Minggu'
								);
								$get_hari = $hari[(int)date("N")];

								$today = $get_hari . ', ' .  date("d") . ' ' . $get_bulan  . ' ' .  date("Y")
								@endphp

                                {!! $today !!}
                            </span>
                        </div>
                    </li>
                </ul>
            </div>
        </div>




        <div class="topbar">

            <div class="dropdown">
                <!--begin::Toggle-->
                <div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px">
                    <div class="btn btn-icon btn-clean btn-dropdown btn-lg mr-1 pulse pulse-primary">
                        <span class="svg-icon svg-icon-xl svg-icon-primary">
                            <!--begin::Svg Icon | path:assets/media/svg/icons/Code/Compiling.svg-->
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <path
                                        d="M17,12 L18.5,12 C19.3284271,12 20,12.6715729 20,13.5 C20,14.3284271 19.3284271,15 18.5,15 L5.5,15 C4.67157288,15 4,14.3284271 4,13.5 C4,12.6715729 4.67157288,12 5.5,12 L7,12 L7.5582739,6.97553494 C7.80974924,4.71225688 9.72279394,3 12,3 C14.2772061,3 16.1902508,4.71225688 16.4417261,6.97553494 L17,12 Z"
                                        fill="#000000" />
                                    <rect fill="#000000" opacity="0.3" x="10" y="16" width="4" height="4" rx="2" />
                                </g>
                            </svg>
                            <!--end::Svg Icon-->
                        </span>
                        <span class="pulse-ring"></span>
                    </div>
                </div>
                <!--end::Toggle-->
                <!--begin::Dropdown-->
                <div class="dropdown-menu p-0 m-0 dropdown-menu-right dropdown-menu-anim-up dropdown-menu-lg">
                    <form>
                        <!--begin::Header-->
                        <div class="d-flex flex-column pt-12 bgi-size-cover bgi-no-repeat rounded-top"
                            style="background-image: url({{asset('assets/themes/metronic/media/misc/bg-1.jpg')}})">
                            <!--begin::Title-->
                            <h4 class="d-flex flex-center rounded-top">
                                <span class="text-white">Notifikasi Anda</span>
                                <span class="btn btn-text btn-success btn-sm font-weight-bold btn-font-md ml-2 count">23
                                    baru</span>
                            </h4>
                            <!--end::Title-->
                            <!--begin::Tabs-->
                            <ul class="nav nav-bold nav-tabs nav-tabs-line nav-tabs-line-3x nav-tabs-line-transparent-white nav-tabs-line-active-border-success mt-3 px-8"
                                role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active show" data-toggle="tab"
                                        href="#topbar_notifications_info">Informasi</a>
                                </li>
                                <li class="nav-item link-log">
                                    <a class="nav-link" data-toggle="tab" href="#topbar_notifications_log">Log</a>
                                </li>
                            </ul>
                            <!--end::Tabs-->
                        </div>
                        <!--end::Header-->
                        <!--begin::Content-->
                        <div class="tab-content">

                            <!--begin::Tabpane-->
                            <div class="tab-pane active show" id="topbar_notifications_info" role="tabpanel">
                                <!--begin::Nav-->
                                <div class="navi navi-hover scroll my-4 navi-data" data-scroll="true" data-height="300"
                                    data-mobile-height="200">


                                </div>
                                <!--end::Nav-->
                            </div>
                            <!--end::Tabpane-->

                            <!--begin::Tabpane-->
                            <div class="tab-pane" id="topbar_notifications_log" role="tabpanel">
                                <!--begin::Nav-->
                                <div class="navi navi-hover scroll my-4 navi-data-log" data-scroll="true"
                                    data-height="300" data-mobile-height="200">


                                </div>
                                <!--end::Nav-->
                            </div>
                            <!--end::Tabpane-->

                        </div>
                        <!--end::Content-->
                    </form>
                </div>
                <!--end::Dropdown-->
            </div>




            <div class="topbar-item">
                <div class="btn btn-icon btn-icon-mobile w-auto btn-clean d-flex align-items-center btn-lg px-2"
                    id="kt_quick_user_toggle">
                    <span class="text-muted font-weight-bold font-size-base d-none d-md-inline mr-1">Hi,</span>
                    <span class="text-dark-50 font-weight-bolder font-size-base d-none d-md-inline mr-3">{{ $users->first_name }}
                        {{ $users->last_name }}</span>
                    <span class="symbol symbol-lg-35 symbol-25 symbol-light-success">
                        <span class="symbol-label font-size-h5 font-weight-bold">{{ substr($users->first_name, 0, 1) . ' ' . substr($users->last_name, 0, 1) }}</span>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<br>
<br>
<br>
<br>


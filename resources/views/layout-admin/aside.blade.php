<div class="kt-aside-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_aside_menu_wrapper">
    <div id="kt_aside_menu" class="kt-aside-menu " data-ktmenu-vertical="1" data-ktmenu-scroll="1" data-ktmenu-dropdown-timeout="500">
        <ul class="kt-menu__nav ">
            <li class="kt-menu__item @if($pages == 'dashboard')  kt-menu__item--active @endif" aria-haspopup="true">
                <a href="{{route('dashboard')}}" class="kt-menu__link "><span class="kt-menu__link-icon"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <polygon points="0 0 24 0 24 24 0 24" />
                        <path d="M12.9336061,16.072447 L19.36,10.9564761 L19.5181585,10.8312381 C20.1676248,10.3169571 20.2772143,9.3735535 19.7629333,8.72408713 C19.6917232,8.63415859 19.6104327,8.55269514 19.5206557,8.48129411 L12.9336854,3.24257445 C12.3871201,2.80788259 11.6128799,2.80788259 11.0663146,3.24257445 L4.47482784,8.48488609 C3.82645598,9.00054628 3.71887192,9.94418071 4.23453211,10.5925526 C4.30500305,10.6811601 4.38527899,10.7615046 4.47382636,10.8320511 L4.63,10.9564761 L11.0659024,16.0730648 C11.6126744,16.5077525 12.3871218,16.5074963 12.9336061,16.072447 Z" fill="#000000" fill-rule="nonzero" />
                        <path d="M11.0563554,18.6706981 L5.33593024,14.122919 C4.94553994,13.8125559 4.37746707,13.8774308 4.06710397,14.2678211 C4.06471678,14.2708238 4.06234874,14.2738418 4.06,14.2768747 L4.06,14.2768747 C3.75257288,14.6738539 3.82516916,15.244888 4.22214834,15.5523151 C4.22358765,15.5534297 4.2250303,15.55454 4.22647627,15.555646 L11.0872776,20.8031356 C11.6250734,21.2144692 12.371757,21.2145375 12.909628,20.8033023 L19.7677785,15.559828 C20.1693192,15.2528257 20.2459576,14.6784381 19.9389553,14.2768974 C19.9376429,14.2751809 19.9363245,14.2734691 19.935,14.2717619 L19.935,14.2717619 C19.6266937,13.8743807 19.0546209,13.8021712 18.6572397,14.1104775 C18.654352,14.112718 18.6514778,14.1149757 18.6486172,14.1172508 L12.9235044,18.6705218 C12.377022,19.1051477 11.6029199,19.1052208 11.0563554,18.6706981 Z" fill="#000000" opacity="0.3" />
                    </g>
                </svg></span><span class="kt-menu__link-text">Dashboard</span></a>
            </li>
            <li class="kt-menu__section ">
                <h4 class="kt-menu__section-text">Staff</h4>
                <i class="kt-menu__section-icon flaticon-more-v2"></i>
            </li>
            @if(Auth::user()->can('Manage Pengguna') || Auth::user()->can('Manage Peran') || Auth::user()->can('Manage Karyawan'))
            <li class="kt-menu__item  kt-menu__item--submenu @if($pages == 'staff')  kt-menu__item--active kt-menu__item--open @endif" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                    <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                        <span class="kt-menu__link-icon"><i class="flaticon flaticon-user"></i></span><span class="kt-menu__link-text">Staff</span><i class="kt-menu__ver-arrow la la-angle-right"></i>
                    </a>
                <div class="kt-menu__submenu"><span class="kt-menu__arrow"></span>
                    <ul class="kt-menu__subnav">
                        <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true"><span class="kt-menu__link"><span class="kt-menu__link-text">Staff</span></span></li>
                        @if(Auth::user()->can('Manage Pengguna'))
                        <li class="kt-menu__item @if($subpages == 'pengguna') kt-menu__item--active @endif" aria-haspopup="true"><a href="{{route('pengguna')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">Pengguna</span></a></li>
                        @endif
                        @if(Auth::user()->can('Manage Peran'))
                        <li class="kt-menu__item  @if($subpages == 'peran') kt-menu__item--active @endif" aria-haspopup="true"><a href="{{route('peran')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">Peran</span></a></li>
                        @endif
                        @if(Auth::user()->can('Manage Karyawan'))
                        <li class="kt-menu__item  @if($subpages == 'karyawan') kt-menu__item--active @endif"><a href="{{route('karyawan')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">Karyawan</span></a></li>
                        @endif
                    </ul>
                </div>
            </li>
            @endif
            @if(Auth::user()->can('Manage Cuti') || Auth::user()->can('Manage Kasbon')  || Auth::user()->can('Manage Izin'))
            <li class="kt-menu__item  kt-menu__item--submenu @if($pages == 'approval')  kt-menu__item--active kt-menu__item--open @endif" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                    <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                        <span class="kt-menu__link-icon"><i class="flaticon2-telegram-logo"></i></span><span class="kt-menu__link-text">Pengajuan</span><i class="kt-menu__ver-arrow la la-angle-right"></i>
                    </a>
                <div class="kt-menu__submenu"><span class="kt-menu__arrow"></span>
                    <ul class="kt-menu__subnav">
                        <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true"><span class="kt-menu__link"><span class="kt-menu__link-text">Pengajuan</span></span></li>
                        @if(Auth::user()->can('Manage Cuti'))
                        <li class="kt-menu__item @if($subpages == 'pay-leave') kt-menu__item--active @endif" aria-haspopup="true"><a href="{{route('pay-leave')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">Cuti</span></a></li>
                        @endif
                        @if(Auth::user()->can('Manage Kasbon'))
                        <li class="kt-menu__item @if($subpages == 'kas-bon') kt-menu__item--active @endif" aria-haspopup="true"><a href="{{route('kas-bon')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">Kasbon</span></a></li>
                        @endif
                        @if(Auth::user()->can('Manage Izin'))
                        <li class="kt-menu__item @if($subpages == 'clearance') kt-menu__item--active @endif" aria-haspopup="true"><a href="{{route('clearance')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">Izin</span></a></li>
                        @endif
                    </ul>
                </div>
            </li>
            @endif
            @if(Auth::user()->can('Manage Gaji') || Auth::user()->can('Manage Slipgaji'))
            <li class="kt-menu__item  kt-menu__item--submenu @if($pages == 'payroll')  kt-menu__item--active kt-menu__item--open @endif" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                    <span class="kt-menu__link-icon"><i class="la la-money"></i></span><span class="kt-menu__link-text">Payroll</span><i class="kt-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                    <ul class="kt-menu__subnav">
                        <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true"><span class="kt-menu__link"><span class="kt-menu__link-text">Payroll</span></span></li>
                        @if(Auth::user()->can('Manage Gaji'))
                        <li class="kt-menu__item @if($subpages == 'gaji') kt-menu__item--active @endif" aria-haspopup="true"><a href="{{route('gaji')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">Gaji Karyawan</span></a></li>
                        @endif
                        @if(Auth::user()->can('Manage Slipgaji'))
                        <li class="kt-menu__item @if($subpages == 'slipgaji') kt-menu__item--active @endif" aria-haspopup="true"><a href="{{route('slipgaji')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">Slip Gaji</span></a></li>
                        @endif
                    </ul>
                </div>
            </li>
            @endif
            @if(Auth::user()->can('Manage Perusahaan') || Auth::user()->can('Manage Departemen') || Auth::user()->can('Manage Jabatan') || Auth::user()->can('Manage Jenis Gaji') || Auth::user()->can('Manage Tunjangan') || Auth::user()->can('Manage Potongan') || Auth::user()->can('Manage Kontrak') || Auth::user()->can('Manage Profil Perusahaan'))
            <li class="kt-menu__item  kt-menu__item--submenu @if($pages == 'setting')  kt-menu__item--active kt-menu__item--open @endif" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                    <span class="kt-menu__link-icon"><i class="flaticon flaticon-settings"></i></span><span class="kt-menu__link-text">Pengaturan</span><i class="kt-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                    <ul class="kt-menu__subnav">
                        <li class="kt-menu__item  kt-menu__item--parent" aria-haspopup="true"><span class="kt-menu__link"><span class="kt-menu__link-text">Pengaturan</span></span></li>
                        @if(Auth::user()->can('Manage Perusahaan'))
                        <li class="kt-menu__item @if($subpages == 'branch') kt-menu__item--active @endif"><a href="{{route('branch.index')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">Perusahaan</span></a></li>
                        @endif
                        @if(Auth::user()->can('Manage Departemen'))
                        <li class="kt-menu__item @if($subpages == 'department') kt-menu__item--active @endif"><a href="{{route('department.index')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">Departemen</span></a></li>
                        @endif
                        @if(Auth::user()->can('Manage Jabatan'))
                        <li class="kt-menu__item @if($subpages == 'designation') kt-menu__item--active @endif"><a href="{{route('designation.index')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">Jabatan</span></a></li>
                        @endif
                        @if(Auth::user()->can('Manage Jenis Gaji'))
                        <li class="kt-menu__item @if($subpages == 'payslip-type') kt-menu__item--active @endif"><a href="{{route('payslip-type.index')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">Jenis Gaji</span></a></li>
                        @endif
                        @if(Auth::user()->can('Manage Tunjangan'))
                        <li class="kt-menu__item @if($subpages == 'allowance-option') kt-menu__item--active @endif"><a href="{{route('allowance-option.index')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">Pengaturan Tunjangan</span></a></li>
                        @endif
                        @if(Auth::user()->can('Manage Potongan'))
                        <li class="kt-menu__item @if($subpages == 'deduction-option') kt-menu__item--active @endif"><a href="{{route('deduction-option.index')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">Pengaturan Potongan</span></a></li>
                        @endif
                        @if(Auth::user()->can('Manage Kontrak'))
                        <li class="kt-menu__item @if($subpages == 'contract') kt-menu__item--active @endif"><a href="{{route('contract.index')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">Pengaturan Kontrak</span></a></li>
                        @endif
                        @if(Auth::user()->can('Manage Profil Perusahaan'))
                        <li class="kt-menu__item @if($subpages == 'currency') kt-menu__item--active @endif"><a href="{{route('currency.converter')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">Konversi Mata Uang</span></a></li>
                        @endif
                        @if(Auth::user()->can('Manage Profil Perusahaan'))
                        <li class="kt-menu__item @if($subpages == 'companysetting') kt-menu__item--active @endif"><a href="{{route('company.index')}}" class="kt-menu__link "><i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i><span class="kt-menu__link-text">Profil Perusahaan</span></a></li>
                        @endif
                    </ul>
                </div>
            </li>
            @endif     
        </ul>
    </div>
</div>

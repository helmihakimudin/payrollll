<div id="kt_header_mobile" class="kt-header-mobile  kt-header-mobile--fixed ">
    <div class="kt-header-mobile__logo">
        <a href="index.html">
            <img alt="Logo" src="{{ asset('logo/e-smart-logo.png')}}" width="140px;" height="30px;" class="kt-header__brand-logo-default" />
        </a>
        <div class="dropdown">
            <button type="button" class="btn btn-pill btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                <i class="flaticon2-layers"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-fit dropdown-menu-md">
                <ul class="kt-nav kt-nav--bold kt-nav--md-space kt-margin-t-20 kt-margin-b-20">
                    <li class="kt-nav__item">
                        <a class="kt-nav__link active" href="{{route('dashboard')}}">
                            <span class="kt-nav__link-icon"><i class="flaticon2-setup"></i></span>
                            <span class="kt-nav__link-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="kt-nav__item">
                        <a class="kt-nav__link" href="{{route('employee')}}">
                            <span class="kt-nav__link-icon"><i class="flaticon2-user"></i></span>
                            <span class="kt-nav__link-text">Employees</span>
                        </a>
                    </li>
                    <li class="kt-nav__item">
                        <a class="kt-nav__link" href="{{route('time')}}">
                            <span class="kt-nav__link-icon"><i class="flaticon2-menu-1"></i></span>
                            <span class="kt-nav__link-text">Time Management</span>
                        </a>
                    </li>
                    <li class="kt-nav__item">
                        <a class="kt-nav__link" href="#">
                            <span class="kt-nav__link-icon"><i class="flaticon-doc"></i></span>
                            <span class="kt-nav__link-text">Finance</span>
                        </a>
                    </li>
                    <li class="kt-nav__item">
                        <a class="kt-nav__link" href="#">
                            <span class="kt-nav__link-icon"><i class="flaticon2-file"></i></span>
                            <span class="kt-nav__link-text">Payroll</span>
                        </a>
                    </li>
                    <li class="kt-nav__item">
                        <a class="kt-nav__link" href="#">
                            <span class="kt-nav__link-icon"><i class="flaticon2-settings"></i></span>
                            <span class="kt-nav__link-text">Setting</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="kt-header-mobile__toolbar">
        <button class="kt-header-mobile__toolbar-toggler" id="kt_header_mobile_toggler"><span></span></button>
        <button class="kt-header-mobile__toolbar-topbar-toggler" id="kt_header_mobile_topbar_toggler"><i class="flaticon-more-1"></i></button>
    </div>
</div>

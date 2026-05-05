<div class="app-sidebar sidebar-shadow">
    <div class="app-header__logo">
        <div class="logo-src"></div>
        <div class="header__pane ms-auto">
            <div><button type="button" class="hamburger close-sidebar-btn hamburger--elastic"
                    data-class="closed-sidebar"><span class="hamburger-box"><span
                            class="hamburger-inner"></span></span></button></div>
        </div>
    </div>
    <div class="app-header__mobile-menu">
        <div><button type="button" class="hamburger hamburger--elastic mobile-toggle-nav"><span
                    class="hamburger-box"><span class="hamburger-inner"></span></span></button></div>
    </div>
    <div class="app-header__menu"><span><button type="button"
                class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav"><span
                    class="btn-icon-wrapper"><i class="fa fa-ellipsis-v fa-w-6"></i></span></button></span>
    </div>
    <div class="scrollbar-sidebar">
        <div class="app-sidebar__inner">
            <ul class="vertical-nav-menu">
                <li class="app-sidebar__heading">Dashboards</li>
                <li>
                    <a href="{{ url('admin/dashboard') }}" class="">
                        <i class="metismenu-icon pe-7s-graph3"></i>
                        Dashboard
                    </a>
                </li>
                <li class="app-sidebar__heading">Ajuan</li>
                <li>
                    <a href="{{ url('admin/issue/create') }}" class="">
                        <i class="metismenu-icon pe-7s-plus"></i>
                        Tambah Baru
                    </a>
                </li>
                <li>
                    <a href="{{ url('admin/issue') }}" class="">
                        <i class="metismenu-icon pe-7s-news-paper"></i>
                        Data Ajuan
                    </a>
                </li>
                @role('admin')
                <li class="app-sidebar__heading">Users Pengguna</li>
                <li>
                    <a href="{{ url('admin/user') }}" class="">
                        <i class="metismenu-icon pe-7s-users"></i>
                        Users
                    </a>
                </li>
                <li>
                    <a href="{{ url('admin/issue/create') }}" class="">
                        <i class="metismenu-icon pe-7s-settings"></i>
                        Roles & Permissions
                    </a>
                </li>
                @endrole
                <li class="app-sidebar__heading">Profil</li>
                @role('admin')
                <li>
                    <a href="{{ route('admin.profile.index') }}" class="">
                        <i class="metismenu-icon pe-7s-user"></i>
                        Profil Saya
                    </a>
                </li>
                @endrole
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="javascript:void(0)" class=""
                            onclick="event.preventDefault();this.closest('form').submit();">
                            <i class="metismenu-icon pe-7s-power"></i>
                            Keluar
                        </a>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>
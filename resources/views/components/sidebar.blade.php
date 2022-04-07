<aside class="main-sidebar sidebar-light-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="{{asset('img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-2"
            style="opacity: .8">
        <span class="brand-text font-weight-light">SIMARU</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{asset('img/user1-128x128.png')}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ auth()->user()->name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="/" class="nav-link {{ set_active('home') }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('validasi.index') }}" class="nav-link {{ set_active('validasi.*') }}">
                        <i class="nav-icon fas fa-clipboard-check"></i>
                        <p>
                            Validasi
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('lolos.index') }}" class="nav-link {{ set_active('lolos.*') }}">
                        <i class="nav-icon fas fa-user-check"></i>
                        <p>
                            Lolos Seleksi
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route("pembayaran.index") }}" class="nav-link {{ set_active("pembayaran.*") }}">
                        <i class="nav-icon fas fa-money-bill-wave"></i>
                        <p>
                            Pembayaran
                        </p>
                    </a>
                </li>
                <li class="nav-item {{ set_active("rekomendasi.*", "menu-open") }}">
                    <a href="#" class="nav-link {{ set_active("rekomendasi.*") }}">
                        <i class="nav-icon fas fa-file-signature"></i>
                        <p>
                            Rekomendasi
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('rekomendasi.internal') }}" class="nav-link {{ set_active("rekomendasi.internal") }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Internal</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('rekomendasi.eksternal') }}" class="nav-link {{ set_active("rekomendasi.eksternal") }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Eksternal</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ route("nim.index") }}" class="nav-link {{ set_active("nim.*") }}">
                        <i class="nav-icon fas fa-id-card"></i>
                        <p>
                            Nomor Induk
                        </p>
                    </a>
                </li>
                <li class="nav-header">MANAJEMEN</li>
                <li class="nav-item">
                    <a href="{{ route("prodi.index") }}" class="nav-link {{ set_active("prodi.*") }}">
                        <i class="nav-icon fas fa-university"></i>
                        <p>
                            Program Studi
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route("pengguna.index") }}" class="nav-link {{ set_active("pengguna.*") }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Pengguna
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-history"></i>
                        <p>
                            Log Aktivitas
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} | Dashboard</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{asset("plugins/fontawesome-free/css/all.min.css")}}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{asset("plugins/overlayScrollbars/css/OverlayScrollbars.min.css")}}">
    @stack("css-lib")

    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset("css/adminlte.min.css")}}">

    @stack("css")
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__wobble" src="{{asset("img/AdminLTELogo.png")}}" alt="AdminLTELogo" height="60" width="60">
        </div>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ route('grafik') }}" target="_blank" class="nav-link">Grafik</a>
                </li>
                {{-- <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Contact</a>
                </li> --}}
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <button type="button" class="btn btn-info mr-2" data-toggle="modal" data-target="#modal-password"><i class="fas fa-lock mr-1"></i>Ubah Password</button>
                </li>
                <li class="nav-item">
                    <a class="btn btn-danger" href="{{ route('logout') }}" role="button" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt mr-1"></i>Keluar
                    </a>
                </li>
            </ul>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>


        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        @include('components.sidebar')

        <!-- Content Wrapper. Contains page content -->
        @yield('content')

        <!-- Modal -->
        <div class="modal fade" id="modal-password" tabindex="-1" role="dialog" aria-labelledby="modalPassword" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Modal Password</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="" id="form-password">
                        <div class="modal-body">
                            <input type="text" class="d-none" name="id" value="{{ auth()->user()->id }}">
                            <div class="form-group">
                                <label>Password Baru</label>
                                <input type="password" class="form-control" name="password" required>
                            </div>
                            <div class="form-group">
                                <label>Ulangi Password</label>
                                <input type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <strong>Copyright &copy; {{ date('Y') }} <a href="https://github.com/benben4567">@benben4567</a></strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 1.0.0
            </div>
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <script src="{{asset("plugins/jquery/jquery.min.js")}}"></script>
    <!-- Bootstrap -->
    <script src="{{asset("plugins/bootstrap/js/bootstrap.bundle.min.js")}}"></script>
    <!-- overlayScrollbars -->
    <script src="{{asset("plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js")}}"></script>
    <!-- Sweetalert 2 -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Loading Overlay -->
    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>
    <!-- Luxon -->
    <script src="https://cdn.jsdelivr.net/npm/luxon@2.3.1/build/global/luxon.min.js"></script>
    <!-- PAGE PLUGINS -->
    @stack('js-lib')

    <!-- AdminLTE App -->
    <script src="{{asset("js/adminlte.js")}}"></script>
    <script>
        $(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('.modal').on('hidden.bs.modal', function (e) {
                $('form').trigger("reset");
            })

            $('#form-password').submit(function (e) {
                e.preventDefault();

                $.ajax({
                    type: "PUT",
                    url: "/password",
                    data: $(this).serialize(),
                    beforeSend: function () {
                        $.LoadingOverlay("show");
                    },
                    success: function (response) {
                        $.LoadingOverlay("hide");
                        $("#modal-password").modal('hide');
                        Swal.fire("Berhasil!", response.meta.message, "success");
                    },
                    error: function (xhr, status, err) {
                        $.LoadingOverlay("hide");
                        Swal.fire("Error!", "Terjadi Kesalahan di Server", "error");
                        console.log(xhr)
                    }
                });
            });

        });
    </script>

    @stack('js')
</body>

</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SIMARU | Search NIM</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">

</head>

<body class="hold-transition lockscreen">
    <div class="mt-5 mx-2">
        <div class="row justify-content-center mb-2">
            <div class="col-lg-4 col-sm-12 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <form action="{{ route('search-nim') }}" method="get" id="form-search">
                                    @csrf
                                    <div class="input-group">
                                        <input type="text" class="form-control @error('nomor') is-invalid @enderror" id="num" value="{{ old('nomor', '') }}" placeholder="Nomor Pendaftaran"
                                            name="nomor" required>
                                        <div class="input-group-append">
                                            <button class="btn btn-info" type="submit"><i class="fas fa-search ml-1"></i> Cari</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-4 col-sm-12 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <dl class="row">
                                    <dt class="col-3">Nama</dt>
                                    <dd class="col-9">: <span id="nama"></span> </dd>

                                    <dt class="col-3">Prodi</dt>
                                    <dd class="col-9">: <span id="prodi"></span></dd>

                                    <dt class="col-3">NIM</dt>
                                    <dd class="col-9">: <span id="nim"></span></dd>
                                </dl>

                                <p class="text-center mt-4"><em>
                                        Jika terdapat kesalahan data (Nama atau Program Studi) silahkan menghubungi Admin.
                                    </em></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Loading Overlay -->
    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>
    <!-- Sweetalert 2 -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Page Script -->
    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $("#num").keypress(function(e) {
                var charCode = (e.which) ? e.which : e.keyCode;
                if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                    return false;
                }
            });

            $("#form-search").submit(function(e) {
                e.preventDefault();
                var num = $("#num").val();
                $.ajax({
                    url: "{{ route('search-nim') }}",
                    type: "GET",
                    data: {
                        nomor: num
                    },
                    beforeSend: function() {
                        $.LoadingOverlay('show')
                        $("#nama").text('');
                        $("#prodi").text('');
                        $("#nim").text('');
                        $('span.badge-danger').remove()
                    },
                    success: function(response) {
                        var data = response.data;
                        $.LoadingOverlay('hide')
                        $("#nama").text(data.nama);
                        $("#prodi").text(data.prodi_lulus);
                        if (data.nim == null) {
                            $("#nim").append('<span class="badge badge-danger">BELUM</span>');
                        } else {
                            $("#nim").text(data.nim);
                        }
                    },
                    error: function(data) {
                        $.LoadingOverlay('hide')
                        if (data.status == 422) {
                            Swal.fire('Oops!', 'Nomor Pendaftaran tidak valid', 'error');
                        } else if (data.status == 404) {
                            Swal.fire('Oops!', 'Data tidak ditemukan', 'error');
                        } else {
                            Swal.fire('Error!', 'Terjadi Kesalahan di Server, silahkan coba lagi.', 'error');
                        }
                    }
                });
            });


        });
    </script>
</body>

</html>

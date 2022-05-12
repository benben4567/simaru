<!doctype html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="Aplikasi Rekapitulasi PMB ITSK Soepraoen" name="description" />
    <meta content="Benben" name="author" />
    <title>SIMARU · Grafik</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/sticky-footer-navbar/">

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
        integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

    </style>
    <!-- Custom styles for this template -->
    <link href="{{ asset('css/grafik.css') }}" rel="stylesheet">
</head>

<body class="d-flex flex-column h-100">
    <header>
        <!-- Fixed navbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light rounded">
            <a class="navbar-brand" href="#">Grafik PMB</a>
            <a class="btn btn-success my-2 my-sm-0 ml-auto" href="/export" role="button"><i class="fas fa-file-excel mr-1"></i>Download</a>
            <!-- <button class="btn btn-info my-2 my-sm-0 ml-auto" type="button" onclick="window.print()">Print</button> -->
        </nav>
    </header>

    <!-- Begin page content -->
    <main role="main" class="flex-shrink-0">
        <h3 class="text-center mt-2">Grafik PMB Tahun {{ $periode }}</h3>
        <div class="container">
            <div class="row my-2">
                <div class="col-lg-4 col-sm-12">
                    <div class="card my-2">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Bayar Pendaftaran</h5>
                        </div>
                        <div class="card-body">
                            <p class="card-text text-center">Total Pendaftar : <span class="total_pendaftar font-weight-bold">0</span></p>
                            <canvas id="chart1"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-12">
                    <div class="card my-2">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Bayar UKT</h5>
                        </div>
                        <div class="card-body">
                            <p class="card-text text-center">Total Lolos Seleksi : <span class="total_lolos font-weight-bold">0</span></p>
                            <canvas id="chart2"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-12">
                    <div class="card my-2">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Jumlah Per Gelombang</h5>
                        </div>
                        <div class="card-body">
                            <p class="card-text text-center">Total Pendaftar : <span class="total_pendaftar font-weight-bold">0</span></p>
                            <canvas id="chart3"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row my2">
                <div class="col-sm-12">
                    <div class="card my-2">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Jumlah Per Jalur</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="chart4"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="card my-2">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Jumlah Masuk Prodi</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="chart5"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="card my-2">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Prodi Pilihan 1 Pendaftar</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="chart6"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="card my-2">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Prodi Pilihan 2 Pendaftar</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="chart7"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="footer mt-auto py-3">
        <div class="container">
            <strong>Copyright &copy; {{ date('Y') }} <a href="https://github.com/benben4567">@benben4567</a></strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 1.0.0
            </div>
        </div>
    </footer>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
    <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.21/lodash.min.js"></script>
    <script src="https://unpkg.com/counterup2@2.0.2/dist/index.js">	</script>
    <script src="{{asset('js/pages/grafik.js')}}"></script>
</body>

</html>

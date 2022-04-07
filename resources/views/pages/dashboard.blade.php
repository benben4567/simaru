@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">SIMARU</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                {{-- <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard v2</li>
                </ol> --}}
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Info boxes -->
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i
                                class="fas fa-clipboard-check"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Maba Validasi</span>
                            <span class="info-box-number">
                                10
                                <small>%</small>
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-danger elevation-1"><i
                                class="fas fa-user-check"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Lolos Seleksi</span>
                            <span class="info-box-number">41,410</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->

                <!-- fix for small devices only -->
                <div class="clearfix hidden-md-up"></div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-success elevation-1"><i
                                class="fas fa-file-signature"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Rekom Internal</span>
                            <span class="info-box-number">760</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-warning elevation-1"><i
                                class="fas fa-file-signature"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Rekom Eksternal</span>
                            <span class="info-box-number">2,000</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <div class="row">
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header border-0">
                            <h3 class="card-title">REKOM INTERNAL</h3>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                                <h5 class="text-danger"><i class="fas fa-exclamation-circle mr-1"></i>
                                    BELUM DIAJUKAN</h5>
                                <p class="text-lg"><span class="font-weight-bold">1</span></p>
                            </div>
                            <!-- /.d-flex -->
                            <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                                <h5 class="text-warning"><i class="fas fa-redo mr-1"></i> PROSES</h5>
                                <p class="text-lg"><span class="font-weight-bold">1</span></p>
                            </div>
                            <!-- /.d-flex -->
                            <div class="d-flex justify-content-between align-items-center mb-0">
                                <h5 class="text-success"><i class="fas fa-check-circle mr-1"></i> SELESAI
                                </h5>
                                <p class="text-lg"><span class="font-weight-bold">1</span></p>
                            </div>
                            <!-- /.d-flex -->
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header border-0">
                            <h3 class="card-title">REKOM EKSTERNAL</h3>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                                <h5 class="text-danger"><i class="fas fa-exclamation-circle mr-1"></i>
                                    BELUM DIAJUKAN</h5>
                                <p class="text-lg"><span class="font-weight-bold">1</span></p>
                            </div>
                            <!-- /.d-flex -->
                            <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                                <h5 class="text-warning"><i class="fas fa-redo mr-1"></i> PROSES</h5>
                                <p class="text-lg"><span class="font-weight-bold">1</span></p>
                            </div>
                            <!-- /.d-flex -->
                            <div class="d-flex justify-content-between align-items-center mb-0">
                                <h5 class="text-success"><i class="fas fa-check-circle mr-1"></i> SELESAI
                                </h5>
                                <p class="text-lg"><span class="font-weight-bold">1</span></p>
                            </div>
                            <!-- /.d-flex -->
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header border-0">
                            <h3 class="card-title">INPUT NIM</h3>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                                <h5 class="text-danger"><i class="fas fa-exclamation-circle mr-1"></i>
                                    BELUM</h5>
                                <p class="text-lg"><span class="font-weight-bold">1</span></p>
                            </div>
                            <!-- /.d-flex -->
                            <div class="d-flex justify-content-between align-items-center mb-0">
                                <h5 class="text-success"><i class="fas fa-check-circle mr-1"></i> SUDAH</h5>
                                <p class="text-lg"><span class="font-weight-bold">1</span></p>
                            </div>
                            <!-- /.d-flex -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->

            <!-- Main row -->
            <div class="row">
                <!-- Left col -->
                <div class="col-md-8">
                    <!-- MAP & BOX PANE -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Grafik Validasi Maba</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <div class="d-md-flex">
                                <div class="p-1 flex-fill" style="overflow: hidden">
                                    <!-- Map will be created here -->
                                    <div id="chart">
                                        <canvas id="areaChart"
                                            style="min-height: 250px; height: 325px; max-width: 100%; overflow: hidden"></canvas>
                                    </div>
                                </div>
                                <div class="card-pane-right bg-light pt-2 pb-2 pl-4 pr-4">
                                    <h5>PEMBAYARAN</h5>
                                    <div class="description-block mb-4">
                                        <h5 class="description-header"> < 50% </h5>
                                        <span class="badge bg-info description-text"> 1234 </span>
                                    </div>
                                    <!-- /.description-block -->
                                    <div class="description-block mb-4">
                                        <h5 class="description-header"> > 50% </h5>
                                        <span class="badge bg-info description-text"> 1234 </span>
                                    </div>
                                    <!-- /.description-block -->
                                    <div class="description-block">
                                        <h5 class="description-header">LUNAS</h5>
                                        <span class="badge bg-info description-text"> 1234 </span>
                                    </div>
                                    <!-- /.description-block -->
                                </div><!-- /.card-pane-right -->
                            </div><!-- /.d-md-flex -->
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Prodi Diterima</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="chart-responsive">
                                <canvas id="pieChart" height="280"></canvas>
                            </div>
                            <!-- ./chart-responsive -->
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!--/. container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection

@push("css-lib")

@endpush

@push('js-lib')
<!-- ChartJS -->
<script src="{{asset("plugins/chart.js/Chart.min.js")}}"></script>
<script src="https://cdn.jsdelivr.net/gh/emn178/chartjs-plugin-labels/src/chartjs-plugin-labels.js"></script>
@endpush

@push('js')
    <script src="{{ asset('js/pages/dashboard.js') }}"></script>
@endpush

@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Rekomendasi {{ $jenis }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Lolos</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Data Rekom Camaba</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example2" class="table table-bordered table-hover">
                                    <thead>
                                        <tr class="text-center">
                                            <th>No. Pendaftaran</th>
                                            <th>Nama</th>
                                            <th>Nama Perekom</th>
                                            <th>Status</th>
                                            <th>File Rekom</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center align-middle">XXXXXX</td>
                                            <td class="align-middle">JOHN DOE</td>
                                            <td>
                                                FOO BAR </br>
                                                <a href="https://wa.me/6281380801441" target="_blank">081380801441</a>
                                            </td>
                                            <td class="text-center align-middle"><button type="button"
                                                    class="btn btn-danger btn-xs btn-rekom">BELUM</button></td>
                                            <td class="text-center align-middle"><button type="button"
                                                    class="btn btn-danger btn-sm" title="Download"><i
                                                        class="fas fa-file-pdf"></i></button></td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">XXXXXX</td>
                                            <td class="align-middle">JOHN DOE</td>
                                            <td>
                                                FOO BAR </br>
                                                <a href="https://wa.me/6281380801441" target="_blank">081380801441</a>
                                            </td>
                                            <td class="text-center align-middle"><button type="button"
                                                    class="btn btn-warning btn-xs btn-rekom">PROSES</button></td>
                                            <td class="text-center align-middle"><button type="button"
                                                    class="btn btn-danger btn-sm" title="Download"><i
                                                        class="fas fa-file-pdf"></i></button></td>
                                        </tr>
                                        <tr>
                                            <td class="text-center align-middle">XXXXXX</td>
                                            <td class="align-middle">JOHN DOE</td>
                                            <td>
                                                FOO BAR </br>
                                                <a href="https://wa.me/6281380801441" target="_blank">081380801441</a>
                                            </td>
                                            <td class="text-center align-middle"><button type="button"
                                                    class="btn btn-success btn-xs btn-rekom">SELESAI</button></td>
                                            <td class="text-center align-middle"><button type="button"
                                                    class="btn btn-danger btn-sm" title="Download"><i
                                                        class="fas fa-file-pdf"></i></button></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->

            <!-- Modal Input -->
            <div class="modal fade" id="modal-input" role="dialog" aria-labelledby="modalInput" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Input Data Validasi</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="post" id="form-input">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Tanggal Pengajuan</label>
                                    <input type="date" class="form-control" name="tgl_pengajuan">
                                </div>
                                <div class="form-group">
                                    <label for="">Tanggal Pencairan</label>
                                    <input type="date" class="form-control" name="tgl_pencairan">
                                </div>
                                <div class="form-group">
                                    <div class="form-group">
                                        <label>Jenis Pencairan</label>
                                        <select class="form-control" name="jenis">
                                            <option value="" disabled selected>- pilih -</option>
                                            <option value="tunai">Tunai</option>
                                            <option value="transfer">Transfer</option>
                                        </select>
                                    </div>
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

        </section>
        <!-- /.content -->
    </div>
@endsection

@push('css-lib')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endpush

@push('js-lib')
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
@endpush

@push('js')
    <script src="{{ asset('js/pages/rekomendasi.js') }}"></script>
@endpush

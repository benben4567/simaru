@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Lolos Seleksi</h1>
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
                                <h3 class="card-title">Data Lolos Seleksi Camaba</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example2" class="table table-bordered table-hover">
                                    <thead>
                                        <tr class="text-center">
                                            <th>No. Pendaftaran</th>
                                            <th>Nama</th>
                                            <th>Prodi Diterima</th>
                                            <th>Tgl Input</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
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
                            <h5 class="modal-title">Input Data Lolos</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="post" id="form-input">
                            <div class="modal-body">
                                <div class="form-row">
                                    <div class="col-sm-8">
                                        <div class="form-group">
                                            <label>No. Pendaftaran</label>
                                            <input type="text" class="form-control numeric" name="no" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <label>&nbsp;</label>
                                        <button type="button" class="btn btn-primary btn-block btn-search">Cari</button>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" class="form-control" id="nama" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Prodi Lolos</label>
                                    <select class="form-control" name="prodi_lolos" required>
                                        <option>- pilih -</option>
                                        @foreach ($prodi as $p)
                                            <option value="{{ $p->name }}">{{ $p->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label>Nilai Ujian</label>
                                            <input type="text" class="form-control nilai" name="nilai" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="">Tanggal Daftar</label>
                                            <input type="date" class="form-control" name="tgl_daftar" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal Update -->
            <div class="modal fade" id="modal-update" role="dialog" aria-labelledby="modalUpdate" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Update Data Lolos</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="post" id="form-update">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>No. Pendaftaran</label>
                                    <input type="text" class="form-control" name="no" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" class="form-control" name="nama" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Prodi Lolos</label>
                                    <select class="form-control" name="prodi_lolos" required>
                                        <option>- pilih -</option>
                                        @foreach ($prodi as $p)
                                            <option value="{{ $p->name }}">{{ $p->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label>Nilai Ujian</label>
                                            <input type="text" class="form-control nilai" name="nilai" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="">Tanggal Daftar</label>
                                            <input type="date" class="form-control" name="tgl_daftar" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal Import -->
            <div class="modal fade" id="modal-import" tabindex="-1" role="dialog" aria-labelledby="modalImport" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Import Data Lolos Seleksi</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="post" id="form-import" autocomplete="off" enctype="multipart/form-data">
                            <div class="modal-body">
                                <p>Download : <a href="{{ asset('storage/format-import-lolos.xlsx')}}" target="_blank">template_excel</a> </p>
                                <div class="form-group">
                                    <label for="exampleInputFile">File Excel</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="file" id="exampleInputFile">
                                            <label class="custom-file-label" for="exampleInputFile">Pilih</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Import</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
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
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset("plugins/select2/css/select2.min.css")}}">
    <link rel="stylesheet" href="{{ asset("plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css")}}">
@endpush

@push('js-lib')
    <!-- bs-custom-file-input -->
    <script src="{{asset("plugins/bs-custom-file-input/bs-custom-file-input.min.js")}}"></script>
    <!-- MomentJS -->
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset("plugins/select2/js/select2.full.min.js") }}"></script>
    <!-- InputMask -->
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/inputmask/jquery.inputmask.min.js') }}"></script>
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
    <script src="{{ asset('plugins/datatables-plugins/date-eu.js') }}"></script>
@endpush

@push('js')
    <script src="{{ asset('js/pages/lolos.js') }}"></script>
@endpush

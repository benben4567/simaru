@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Validasi</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Validasi</li>
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
                            <h3 class="card-title">Data Validasi Camaba</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                    <tr class="text-center">
                                        <th>No. Pendaftaran</th>
                                        <th>Nama</th>
                                        <th>Jalur</th>
                                        <th>Gelombang</th>
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
        <div class="modal fade" id="modal-input" tabindex="-1" role="dialog" aria-labelledby="modalInput"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Input Data Validasi</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="post" id="form-input" autocomplete="off" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="form-row">
                                <div class="col-lg-2 col-sm-12">
                                    <div class="form-group">
                                        <label>No. Pendaftaran</label>
                                        <input type="text" class="form-control numeric" name="no" required>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Nama Lengkap</label>
                                        <input type="text" class="form-control" name="nama" style="text-transform: uppercase;" required>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-12">
                                    <div class="form-group">
                                        <label>No. HP</label>
                                        <input type="text" class="form-control phone" name="nohp" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Prodi 1</label>
                                        <select class="form-control" name="prodi_1" required>
                                            <option selected disabled>- pilih -</option>
                                            @foreach ($prodi as $p)
                                                <option value="{{ $p->name }}">{{ $p->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Prodi 2</label>
                                        <select class="form-control" name="prodi_2" required>
                                            <option selected disabled>- pilih -</option>
                                            @foreach ($prodi as $p)
                                                <option value="{{ $p->name }}">{{ $p->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Jalur</label>
                                        <select class="form-control" name="jalur" required>
                                            <option selected disabled>- pilih -</option>
                                            <option value="REGULER">REGULER</option>
                                            <option value="PRESTASI">PRESTASI</option>
                                            <option value="TUBEL/IBEL">TUBEL/IBEL</option>
                                            <option value="ALIH JENJANG">ALIH JENJANG</option>
                                            <option value="REGSUS">REGSUS</option>
                                            <option value="PINDAHAN">PINDAHAN</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Gelombang</label>
                                        <select class="form-control" name="gelombang" required>
                                            <option selected disabled>- pilih -</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Rekomendasi</label>
                                <select class="form-control" name="rekomendasi" requried>
                                    <option value="">Tidak Ada</option>
                                    <option value="internal">Internal</option>
                                    <option value="external">Eksternal</option>
                                </select>
                            </div>
                            <div class="form-row">
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label>Nama Perekom</label>
                                        <input type="text" class="form-control" style="text-transform: uppercase;"
                                            name="nama_perekom">
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label>No.HP Perekom</label>
                                            <input type="text" class="form-control phone" name="nohp_perekom">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <div class="form-group">
                                        <label for="exampleInputFile">File Rekom</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" name="file" id="exampleInputFile">
                                                <label class="custom-file-label" for="exampleInputFile">Pilih</label>
                                            </div>
                                        </div>
                                    </div>
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
<link rel="stylesheet" href="{{ asset("plugins/datatables-bs4/css/dataTables.bootstrap4.min.css")}}">
<link rel="stylesheet" href="{{ asset("plugins/datatables-responsive/css/responsive.bootstrap4.min.css")}}">
<link rel="stylesheet" href="{{ asset("plugins/datatables-buttons/css/buttons.bootstrap4.min.css")}}">
@endpush

@push('js-lib')
<!-- bs-custom-file-input -->
<script src="{{asset("plugins/bs-custom-file-input/bs-custom-file-input.min.js")}}"></script>
<!-- InputMask -->
<script src="{{asset("plugins/moment/moment.min.js")}}"></script>
<script src="{{asset("plugins/inputmask/jquery.inputmask.min.js")}}"></script>
<!-- DataTables  & Plugins -->
<script src="{{asset("plugins/datatables/jquery.dataTables.min.js")}}"></script>
<script src="{{asset("plugins/datatables-bs4/js/dataTables.bootstrap4.min.js")}}"></script>
<script src="{{asset("plugins/datatables-responsive/js/dataTables.responsive.min.js")}}"></script>
<script src="{{asset("plugins/datatables-responsive/js/responsive.bootstrap4.min.js")}}"></script>
<script src="{{asset("plugins/datatables-buttons/js/dataTables.buttons.min.js")}}"></script>
<script src="{{asset("plugins/datatables-buttons/js/buttons.bootstrap4.min.js")}}"></script>
<script src="{{asset("plugins/jszip/jszip.min.js")}}"></script>
<script src="{{asset("plugins/pdfmake/pdfmake.min.js")}}"></script>
<script src="{{asset("plugins/pdfmake/vfs_fonts.js")}}"></script>
<script src="{{asset("plugins/datatables-buttons/js/buttons.html5.min.js")}}"></script>
<script src="{{asset("plugins/datatables-buttons/js/buttons.print.min.js")}}"></script>
<script src="{{asset("plugins/datatables-buttons/js/buttons.colVis.min.js")}}"></script>
@endpush

@push('js')
<script src="{{asset("js/pages/validasi.js")}}"></script>
@endpush

$(document).ready(function () {
    var DateTime = luxon.DateTime;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.modal').on('hidden.bs.modal', function (e) {
        $('form').trigger("reset");
    })

    const jenis = $("#jenis").val()

    var table = $('#example2').DataTable({
        "ajax": "/rekomendasi/"+jenis.toLowerCase(),
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "autoWidth": false,
        "responsive": true,
        "order": [[1, "asc"]],
        "columnDefs": [
            {
                targets: 0,
                className: "text-center align-middle",
                width: "15%",
                data: "no_pendaftaran"
            },
            {
                targets: 1,
                className: "align-middle",
                data: "nama",
            },
            {
                targets: 2,
                className: "align-middle",
                width: "35%",
                data: "nama_perekom",
                render: function (data, type, row, meta) {
                    var no = row.telp_perekom
                    var concat = "62" + no.substring(1)
                    return `${data}</br><a class="btn btn-success btn-xs mr-2" href="https://wa.me/${concat}" target="_blank" role="button" data-toggle="tooltip" title="Whatsapp"><i class="fab fa-whatsapp"></i></a>${no}`
                }

            },
            {
                targets: 3,
                className: "text-center align-middle",
                width: "12%",
                data: "tgl_pencairan",
                render: function (data, type, row, meta) {
                    var pengajuan = row.tgl_pengajuan

                    if (data != null) {
                        return `<button type="button" class="btn btn-success btn-xs btn-rekom">SELESAI</button></br>${DateTime.fromSQL(data).toFormat('dd-MM-yyyy')}`
                    } else if (pengajuan != null) {
                        return `<button type="button" class="btn btn-warning btn-xs btn-rekom">PROSES</button></br>${DateTime.fromSQL(pengajuan).toFormat('dd-MM-yyyy')}`
                    } else {
                        return `<button type="button" class="btn btn-danger btn-xs btn-rekom">BELUM</button>`
                    }
                }
            },
            {
                targets: 4,
                className: "text-center align-middle",
                width: "12%",
                data: 'file_rekom',
                render: function (data, type, row, meta) {
                    if (data) {
                        return `<a class="btn btn-danger btn-sm" href="/storage/rekomendasi/${data}" target="_blank" role="button" data-toggle="tooltip" title="Download"><i class="fas fa-file-pdf"></i></a>`
                    } else {
                        return `<a class="btn btn-secondary btn-sm" href="#" role="button"><i class="fas fa-file-pdf"></i></a>`
                    }
                }
            }
        ]
    });

    $("select[name='jenis']").val(null).change()

    $("#example2 tbody").on('click', '.btn-rekom', function () {
        var data = table.row( $(this).parents('tr') ).data();
        // console.log(data)
        $("#no").val(data.no_pendaftaran);
        $("input[name='tgl_pengajuan']").val(data.tgl_pengajuan);
        $("input[name='tgl_pencairan']").val(data.tgl_pencairan);
        $("select[name='jenis']").val(data.jenis_pencairan);
        $("#modal-input").modal('show');
    });

    $("#form-input").submit(function (e) {
        e.preventDefault();

        $.ajax({
            type: "POST",
            url: "/rekomendasi",
            data: $(this).serialize(),
            dataType: "JSON",
            beforeSend: function() {
                $.LoadingOverlay("show");
            },
            success: function(response){
                $.LoadingOverlay("hide");
                $("#modal-input").modal('hide');
                table.ajax.reload();
                Swal.fire("Berhasil!", response.meta.message, "success");
            },
            error: function(xhr, ajaxOptions, thrownError) {
                $.LoadingOverlay("hide");
                Swal.fire("Error!", xhr.statusText, "error");
                console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    });
});

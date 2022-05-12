$(document).ready(function () {
    var DateTime = luxon.DateTime;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var table = $('#example2').DataTable({
        "ajax": "/pembayaran",
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "autoWidth": false,
        "responsive": true,
        "buttons": [
            {
                text: '<i class="fas fa-download mr-1"></i> Download',
                className: 'btn-outline-warning',
                action: function (e, dt, node, config) {
                    window.location.href = '/pembayaran/export';
                },
                init: function (api, node, config) {
                    $(node).removeClass('btn-secondary')
                }
            },
        ],
        "columnDefs": [
            {
                targets: 0,
                className: "text-center",
                width: "15%",
                data: "no_pendaftaran"
            },
            {
                targets: 1,
                data: "nama",
                render: function (data, type, row, meta) {
                    return `<a href="#" class="btn-detail">${data}</a>`
                }
            },
            {
                targets: 2,
                className: "text-center",
                width: "25%",
                data: "prodi_lulus"
            },
            {
                targets: 3,
                className: "text-center",
                width: "12%",
                data: "pembayaran",
                render: function (data, type, row, meta) {
                    if (data == "lunas") {
                        return `<span class="badge bg-success">Lunas</span>`
                    } else if (data == "setengah") {
                        return `<span class="badge bg-warning">50%</span>`
                    } else {
                        return "-"
                    }
                }
            },
            {
                targets: 4,
                className: "text-center",
                width: "12%",
                type:"date-eu",
                data: "tgl_pembayaran",
                render: function (data, type, row, meta) {
                    if(data){
                        return DateTime.fromSQL(data).toFormat('dd-MM-yyyy');
                    } else {
                        return "-"
                    }
                }
            }
        ],
        "initComplete": function() {
            table.buttons().container().removeClass("btn-group").appendTo('#example2_wrapper .col-md-6:eq(0)');
        }
    });

    $("#example2 tbody").on('click', '.btn-detail', function () {
        var data = table.row( $(this).parents('tr') ).data();
        $("#no").val(data.no_pendaftaran);
        $("#nama").val(data.nama);
        $("#prodi").val(data.prodi_lulus);
        $("select[name='pembayaran']").val(data.pembayaran).change();
        $("#modal-input").modal('show')
    });

    $("#form-input").submit(function (e) {
        e.preventDefault();

        $.ajax({
            type: "POST",
            url: "/pembayaran",
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

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

    bsCustomFileInput.init();

    var table = $('#example2').DataTable({
        "ajax": "/pendaftar",
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "autoWidth": false,
        "responsive": true,
        "buttons": [{
            text: '<i class="fas fa-download mr-1"></i> Import',
            className: 'btn-outline-info',
            action: function (e, dt, node, config) {
                $("#modal-input").modal('show');
            },
            init: function (api, node, config) {
                $(node).removeClass('btn-secondary')
            }
        }],
        "columnDefs": [
            {
                targets: 0,
                className: "text-center",
                width: "15%",
                data: "no_pendaftaran",
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
                width: "15%",
                data: "jalur"
            },
            {
                targets: 3,
                className: "text-center",
                width: "12%",
                data: "gelombang"
            },
            {
                targets: 4,
                className: "text-center align-middle",
                width: "12%",
                data: "bayar_pendaftaran",
                render: function (data, type, row, meta) {
                    if (data == 'sudah') {
                        return `<i class="fas fa-check-square text-success"></i>`
                    }
                    return `<i class="fas fa-times-circle text-danger"></i>`
                }
            }
        ],
        "initComplete": function() {
            table.buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');
        }
    })

    $("#form-input").submit(function (e) {
        e.preventDefault();
        var formData = new FormData($("#form-input")[0]);
        $.ajax({
            url: "/pendaftar",
            type: "POST",
            data : formData,
            processData: false,
            contentType: false,
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
                console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            },
            statusCode: {
                422: function() {
                    Swal.fire("Error!", "Data yang dikirim tidak valid", "error");
                },
                409: function() {
                    Swal.fire("Error!", "Data sudah terdaftar", "error");
                },
                500: function() {
                    Swal.fire("Error!", "Terjadi Kesalahan di Server", "error");
                },
            }
        });
    });
});

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

    Inputmask.extendDefaults({
        'removeMaskOnSubmit': true
    });

    $('.numeric').inputmask("9999999");

    $('.phone').inputmask("9999-9999-99999");

    bsCustomFileInput.init();

    var table = $('#example2').DataTable({
        "ajax": "/validasi",
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "autoWidth": false,
        "responsive": true,
        "buttons": [{
            text: '<i class="fas fa-plus mr-1"></i> Baru',
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
                data: "jalur_pendaftaran"
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
                data: "prodi_lulus",
                render: function (data, type, row, meta) {
                    if (data) {
                        return `<i class="fas fa-check-square text-success"></i>`
                    } else {
                        return "-"
                    }
                }
            },
            {
                targets: 5,
                className: "text-center",
                width: "15%",
                data: "tgl_validasi",
                render: function (data, type, row, meta) {
                    if(data){
                        return DateTime.fromSQL(data).toFormat('dd-MM-yyyy');
                    } else {
                        return "-"
                    }
                }
            },
        ],
        "initComplete": function() {
            table.buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');
        }
    })

    $("#form-input").submit(function (e) {
        e.preventDefault();
        var formData = new FormData($("#form-input")[0]);
        $.ajax({
            url: "/validasi",
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
                Swal.fire("Error!", xhr.statusText, "error");
                console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    });

    $("#example2 tbody").on("click", ".btn-detail", function (e) {
        e.preventDefault();
        var data = table.row( $(this).parents('tr') ).data();

        $.ajax({
            type: "GET",
            url: "/validasi/show",
            data: {no: data.no_pendaftaran},
            beforeSend: function () {
                $.LoadingOverlay("show")
            },
            success: function (response) {
                $.LoadingOverlay("hide")
                $.each(response.data, function (index, value) {
                    $(`#${index}`).val(value);
                });
                $("#modal-detail").modal("show");
            },
            error: function (xhr, status, err) {
                $.LoadingOverlay("hide")
                console.log(xhr.responseJSON)
            },
            statusCode: {
                404: function() {
                    Swal.fire("Oops!", "Data tidak ditemukan", "error");
                }
            }
        });
    });

});

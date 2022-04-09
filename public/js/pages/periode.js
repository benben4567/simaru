$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.modal').on('hidden.bs.modal', function (e) {
        $('form').trigger("reset");
    })

    var table = $('#example2').DataTable({
        "ajax": "/periode",
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": false,
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
                className: "text-center align-middle",
                width: "12%",
                data: null,
                render: function(data, type, row, meta) {
                    return meta.row + 1
                }
            },
            {
                targets: 1,
                className: "text-center align-middle",
                data: "tahun"
            },
            {
                targets: 2,
                className: "text-center",
                width: "25%",
                data: "status",
                render: function(data, type, row, meta) {
                    if (data == 'buka') {
                        return `<input type="checkbox" class="toggle" checked data-toggle="toggle" data-width="100" data-height="20" data-onstyle="success" data-offstyle="danger" data-on="Buka" data-off="Tutup">`
                    }
                    return `<input type="checkbox" class="toggle" data-id="${row.id}" data-toggle="toggle" data-width="100" data-height="20" data-onstyle="success" data-offstyle="danger" data-on="Buka" data-off="Tutup">`
                }
            }
        ],
        "initComplete": function() {
            table.buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)')
            $("input[data-toggle='toggle']").bootstrapToggle();
        }
    });


    $("#form-input").submit(function (e) {
        e.preventDefault();

        $.ajax({
            type: "POST",
            url: "/periode",
            data: $(this).serialize(),
            dataType: "json",
            beforeSend: function () {
                $.LoadingOverlay("show");
            },
            success: function (response) {
                $.LoadingOverlay("hide");
                $("#modal-input").modal('hide');
                table.ajax.reload();
                Swal.fire("Berhasil!", response.meta.message, "success");
            },
            error: function (xhr, status, err) {
                $.LoadingOverlay("hide");
                Swal.fire("Error!", "Terjadi Kesalahan di Server", "error");
                console.log(xhr)
            }
        });
    });

    $("input.toggle").change(function () {
    });

    $('#example2').on('change', 'tbody input.toggle', function () {
        var cb = $(this).prop('checked');
        var id = $(this).data('id');

        if (cb) {
            var status = 'buka'
        } else {
            var status = 'tutup'
        }

        $.ajax({
            type: "PUT",
            url: "/periode",
            data: {id: id, status: status},
            success: function (response) {
                table.ajax.reload(function() {
                    $("input[data-toggle='toggle']").bootstrapToggle();
                })
                Swal.fire('Berhasil!', 'Periode Berhasil Diubah', 'success');
            },
            error: function(xhr, status, err) {
                console.log(xhr.responseJSON)
                Swal.fire('Error!', 'Terjadi Kesalahan di Server', 'error');
            }
        });
    });

    $("#form-update").submit(function (e) {
        e.preventDefault();

        $.ajax({
            type: "PUT",
            url: "/prodi",
            data: $(this).serialize(),
            beforeSend: function () {
                $.LoadingOverlay("show");
            },
            success: function (response) {
                $.LoadingOverlay("hide");
                $("#modal-update").modal('hide');
                table.ajax.reload();
                Swal.fire("Berhasil!", response.meta.message, "success");
            },
            error: function (xhr, status, err) {
                $.LoadingOverlay("hide");
                Swal.fire("Error!", "Terjadi Kesalahan di Server", "error");
                console.log(xhr.responseJSON)
            }
        });
    });
});

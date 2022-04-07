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
        "ajax": "/pengguna",
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
                className: "text-center",
                width: "7%",
                data: null,
                render: function(data, type, row, meta) {
                    return meta.row + 1
                }
            },
            {
                targets: 1,
                data: "name"
            },
            {
                targets: 2,
                className: "text-center",
                width: "25%",
                data: "email"
            },
            {
                targets: 3,
                className: "text-center",
                width: "15%",
                data: "status",
                render: function(data, type, row, meta) {
                    if (data == "enable") {
                        return `<span class="badge bg-success">${data}</span>`
                    } else {
                        return `<span class="badge bg-danger">${data}</span>`
                    }
                }
            },
            {
                targets: 4,
                className: "text-center",
                width: "15%",
                data: "id",
                render: function(data, type, row, meta) {
                    return `<button type="button" class="btn btn-sm btn-primary btn-permission" data-id="${data}" data-toggle="tooltip" title="Permission"><i class="fas fa-fingerprint"></i></button><button type="button" class="btn btn-sm btn-primary btn-password mx-1" data-id="${data}" data-toggle="tooltip" title="Password"><i class="fas fa-key"></i></button><button type="button" class="btn btn-sm btn-primary btn-detail" data-id="${data}" data-toggle="tooltip" title="Detail"><i class="fas fa-user"></i></button>`
                }
            }
        ],
        "initComplete": function() {
            table.buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');
        }
    })

    $("#example2 tbody").on('click', '.btn-permission', function() {
        var id = $(this).data("id");
        $.ajax({
            type: "get",
            url: "/pengguna/akses/"+id,
            beforeSend: function() {
                $('input:checkbox').removeAttr('checked');
            },
            success: function (response) {
                var data = response.data
                for (let index = 0; index < data.length; index++) {
                    const id = data[index].id;
                    $('#permission'+id).attr('checked','checked');
                }
                $("#modal-permission").modal('show');
            }
        });
    });

    $("#example2 tbody").on('click', '.btn-password', function() {
        $("#id").val($(this).data("id"))
        $("#modal-password").modal("show");
    });

    $("#example2 tbody").on('click', '.btn-detail', function() {
        var data = table.row( $(this).parents('tr') ).data();
        $("input[name='id']").val(data.id);
        $("#nama").val(data.name);
        $("#email").val(data.email);
        $("#status").val(data.status).change();
        $("#modal-update").modal("show");
    });

    $("#form-input").submit(function (e) {
        e.preventDefault();

        $.ajax({
            type: "POST",
            url: "/pengguna",
            data: $(this).serialize(),
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

    $("#form-permission").submit(function (e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "/pengguna/akses",
            data: $(this).serialize(),
            beforeSend: function () {
                $.LoadingOverlay("show");
            },
            success: function (response) {
                $.LoadingOverlay("hide");
                $("#modal-permission").modal('hide');
                Swal.fire("Berhasil!", response.meta.message, "success");
            },
            error: function (xhr, status, err) {
                $.LoadingOverlay("hide");
                Swal.fire("Error!", "Terjadi Kesalahan di Server", "error");
                console.log(xhr)
            }
        });
    });

    $("#form-password").submit(function (e) {
        e.preventDefault();

        $.ajax({
            type: "PUT",
            url: "/pengguna/password/",
            data: $(this).serialize(),
            beforeSend: function () {
                $.LoadingOverlay("show");
            },
            success: function (response) {
                $.LoadingOverlay("hide");
                $("#modal-password").modal('hide');
                Swal.fire("Berhasil!", response.meta.message, "success");
            },
            error: function (xhr, status, err) {
                $.LoadingOverlay("hide");
                Swal.fire("Error!", "Terjadi Kesalahan di Server", "error");
                console.log(xhr)
            }
        });
    });

    $("#form-update").submit(function (e) {
        e.preventDefault();

        $.ajax({
            type: "PUT",
            url: "/pengguna",
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
                console.log(xhr)
            }
        });
    });
});

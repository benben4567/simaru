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
        "ajax": "/prodi",
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
                width: "15%",
                data: "id",
                render: function(data, type, row, meta) {
                    return `<button type="button" class="btn btn-sm btn-warning btn-edit" data-id="${data}"><i class="fas fa-pencil-alt"></i></button>`
                }
            }
        ],
        "initComplete": function() {
            table.buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)')
        }
    });

    $("#example2 tbody").on('click', '.btn-edit', function() {
        var data = table.row( $(this).parents('tr') ).data();
        $("input[name='id']").val(data.id);
        $("input[name='nama']").val(data.name);
        $("#modal-update").modal("show");
    });

    $("#form-input").submit(function (e) {
        e.preventDefault();

        $.ajax({
            type: "POST",
            url: "/prodi",
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
                console.log(xhr)
            }
        });
    });
});

$(document).ready(function () {
    var DateTime = luxon.DateTime;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    bsCustomFileInput.init();

    Inputmask.extendDefaults({
        'removeMaskOnSubmit': true
    });

    $('.numeric').inputmask("9999999");

    $('.nilai').inputmask("999");

    $('.modal').on('hidden.bs.modal', function (e) {
        $('form').trigger("reset");
    })

    //Initialize Select2 Elements
    $('.select2').select2({
        allowClear: true,
        theme: 'bootstrap4',
        dropdownParent: $("#modal-input .modal-body"),
        placeholder: "No Pendaftaran",
    }).val('null').change();

    var table = $('#example2').DataTable({
        "ajax": "/lolos",
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "autoWidth": false,
        "responsive": true,
        "buttons": [
            {
                text: '<i class="fas fa-plus mr-1"></i> Baru',
                className: 'btn-outline-info',
                action: function (e, dt, node, config) {
                    $("#modal-input").modal('show');
                },
                init: function (api, node, config) {
                    $(node).removeClass('btn-secondary')
                }
            },
            {
                text: '<i class="fas fa-upload mr-1"></i> Import',
                className: 'btn-outline-success',
                action: function (e, dt, node, config) {
                    $("#modal-import").modal('show');
                },
                init: function (api, node, config) {
                    $(node).removeClass('btn-secondary')
                }
            },
            {
                text: '<i class="fas fa-download mr-1"></i> Download',
                className: 'btn-outline-warning',
                action: function (e, dt, node, config) {
                    window.location.href = '/lolos/export';
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
                data: "no_pendaftaran",
            },
            {
                targets: 1,
                data: "nama",
                render: function (data, type, row, meta) {
                    if (row.telp) {
                        var no = row.telp
                        var concat = "62" + no.substring(1)
                        return `<a href="#" class="btn-update">${data}</a></br><a class="btn btn-success btn-xs mr-2" href="https://wa.me/${concat}" target="_blank" role="button" data-toggle="tooltip" title="Whatsapp"><i class="fab fa-whatsapp"></i></a>${no}`
                    } else {
                        return `<a href="#" class="btn-update">${data}</a></br> -`
                    }
                }
            },
            {
                targets: 2,
                className: "text-center",
                width: "30%",
                data: "prodi_lulus"
            },
            {
                targets: 3,
                width: "12%",
                className: "text-center",
                data: "tgl_lulus",
                type:"date-eu",
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

    $(".btn-search").click(function (e) {
        e.preventDefault();
        $.ajax({
            type: "GET",
            url: "/lolos/maba/show/"+$("input[name='no']").val(),
            beforeSend: function () {
                $('#nama').val("");
                $.LoadingOverlay("show");
            },
            success: function (response) {
                $.LoadingOverlay("hide");
                $('#nama').val(response.data.nama);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                $.LoadingOverlay("hide");
                switch (xhr.status) {
                    case 404:
                        Swal.fire("Error!", "Data tidak ditemukan", "error");
                    case 409:
                        Swal.fire("Error!", "Data sudah ada", "error");
                    }
                console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            },

        });
    });

    $("#form-input").submit(function (e) {
        e.preventDefault();

        $.ajax({
            type: "POST",
            url: "/lolos",
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

    $("#example2 tbody").on("click", ".btn-update", function (e) {
        e.preventDefault();

        var data = table.row( $(this).parents('tr') ).data();

        $.ajax({
            type: "GET",
            url: "/lolos/edit/"+data.no_pendaftaran,
            beforeSend: function () {
                $.LoadingOverlay("show")
            },
            success: function (response) {
                $.LoadingOverlay("hide")
                var data = response.data
                $("input[name='no']").val(data.no_pendaftaran);
                $("input[name='nama']").val(data.nama);
                $("select[name='prodi_lolos']").val(data.prodi_lulus).change();
                $("input[name='nilai']").val(data.nilai);
                $("input[name='tgl_daftar']").val(data.tgl_pendaftaran);

                $("#modal-update").modal("show");
            },
            error: function (xhr, status, err) {
                $.LoadingOverlay("hide")
                console.log(xhr.responseJSON)
            }
        });
    })

    $("#form-update").submit(function (e) {
        e.preventDefault();

        $.ajax({
            type: "PUT",
            url: "/lolos",
            data: $(this).serialize(),
            dataType: "JSON",
            beforeSend: function() {
                $.LoadingOverlay("show");
            },
            success: function(response){
                $.LoadingOverlay("hide");
                $("#modal-update").modal('hide');
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

    $("#form-import").submit(function (e) {
        e.preventDefault();
        var formData = new FormData($("#form-import")[0]);
        $.ajax({
            url: "/lolos/import",
            type: "POST",
            data : formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                $.LoadingOverlay("show");
            },
            success: function(response){
                $.LoadingOverlay("hide");
                $("#modal-import").modal('hide');
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

$(document).ready(function () {
    var DateTime = luxon.DateTime;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

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
                data: "nama"
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
            table.buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');
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

});

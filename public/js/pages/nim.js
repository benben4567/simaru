$(document).ready(function () {

    var DateTime = luxon.DateTime;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var table = $('#example2').DataTable({
        "ajax": '/nim',
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "autoWidth": false,
        "responsive": true,
        "order": [[ 5, "desc" ]],
        "columnDefs": [
            {
                targets: 0,
                className: "text-center",
                width: "13%",
                data: "no_pendaftaran"
            },
            {
                targets: 1,
                data: "nama",
                render: function (data, type, row, meta) {
                    return `<a href="#" class="btn-nim">${data}</a>`
                }
            },
            {
                targets: 2,
                className: "text-center",
                width: "24%",
                data: "prodi_lulus"
            },
            {
                targets: 3,
                className: "text-center",
                width: "10%",
                data: "gelombang"
            },
            {
                targets: 4,
                className: "text-center",
                width: "10%",
                data: "jalur_pendaftaran"
            },
            {
                targets: 5,
                className: "text-center",
                width: "10%",
                data: "nim",
                render: function (data, type, row, meta) {
                    if(data){
                        return data;
                    } else {
                        return `<span class="badge bg-danger">BELUM</span>`
                    }
                }
            },
            {
                targets: 6,
                className: "text-center",
                width: "13%",
                data: "tgl_nim",
                render: function (data, type, row, meta) {
                    if(data){
                        return DateTime.fromSQL(data).toFormat('dd-MM-yyyy');
                    } else {
                        return "-"
                    }
                }
            }
        ]
    });

    $("#example2 tbody").on("click", ".btn-nim", function () {
        var data = table.row( $(this).parents('tr') ).data();
        $("#no").val(data.no_pendaftaran);
        $("#nama").val(data.nama);
        $("#prodi").val(data.prodi_lulus);
        $("#gelombang").val(data.gelombang);
        $("#nim").val(data.nim);
        $("#modal-input").modal('show')
    });

    $("#form-input").submit(function (e) {
        e.preventDefault();

        $.ajax({
            type: "POST",
            url: "/nim",
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

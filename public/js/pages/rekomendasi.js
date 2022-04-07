$(document).ready(function () {
    var table = $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": false,
        "autoWidth": false,
        "responsive": true,
        "columnDefs": [{
                targets: 0,
                width: "15%",
            },
            {
                targets: 1,
            },
            {
                targets: 2,
                width: "30%",
            },
            {
                targets: 3,
                width: "12%",
            },
            {
                targets: 4,
                width: "12%",
            }
        ]
    }).buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');

    $("select[name='jenis']").val(null).change()

    $("#example2 tbody").on('click', '.btn-rekom', function () {
        $("#modal-input").modal('show');
    });
});

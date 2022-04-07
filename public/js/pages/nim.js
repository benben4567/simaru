$(document).ready(function () {
    var table = $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": false,
        "autoWidth": false,
        "responsive": true,
        "columnDefs": [
            {
                targets: 0,
                width: "15%",
            },
            {
                targets: 1,
            },
            {
                targets: 2,
                width: "20%",
            },
            {
                targets: 3,
                width: "10%",
            },
            {
                targets: 4,
                width: "13%",
            },
            {
                targets: 5,
                width: "15%",
            }
        ]
    }).buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');

    $("#example2 tbody").on("click", ".btn-nim", function () {
        $("#modal-input").modal('show')
    });
});

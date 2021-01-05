"use strict"

$(function () {
    $("table").dataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
        },
        "responsive": true,
        "columnDefs": [
            { orderable: false, targets: -1 }
        ],
    });
});

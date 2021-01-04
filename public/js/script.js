"use strict"

$(function () {

    /**
     * TABLES
     */
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

/**
 * NOTIFIACIONES
 */

function notificacionEstado(estado, mensaje) {
    Swal.fire({
        position: "top-end",
        icon: estado,
        html: mensaje,
        timer: 3000,
        showConfirmButton: false,
        showClass: {
            popup: "animate__animated animate__fadeInDown"
        },
        hideClass: {
            popup: "animate__animated animate__fadeOutUp"
        },
        allowOutsideClick: false,
        backdrop: false,
        width: "auto",
    });
}

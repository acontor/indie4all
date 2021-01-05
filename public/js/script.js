"use strict"

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

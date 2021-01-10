"use strict"

/**
 * POPOVER
 */
$(".pop-info").popover();

/**
 * NOTIFICACIONES
 */

function notificacionEstado(estado, mensaje) {
    Swal.fire({
        backdrop: false,
        position: "top-end",
        icon: estado,
        html: mensaje,
        timer: 3000,
        showConfirmButton: false,
        allowOutsideClick: false,
        showClass: {
            popup: "animate__animated animate__fadeInDown"
        },
        hideClass: {
            popup: "animate__animated animate__fadeOutUp"
        }
    });
}

/**
 * INPUT IMAGES
 */

function readURL(imagen, input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            console.log(imagen)
            $('#imagen-' + imagen).attr('src', e.target.result);
            $('#imagen-' + imagen).css('display', 'block');
            $('#btn-').removeClass("btn-outline-dark");
            $('#btn-').addClass('btn-primary');
        }
        reader.readAsDataURL(input.files[0]);
    }
}

"use strict"

$(function () {

    /**
     * SOLICITUDES
     */

    $('.ver-solicitud-desarrolladora').on('click', function (e) {
        e.preventDefault();

        let fila = $(this).parent().parent().parent();
        let id = $(this).prev().val();
        let comentario = $(this).prev().prev().val();

        verSolicitud('desarrolladora', fila, id, comentario);
    });

    $('.ver-solicitud-master').on('click', function (e) {
        e.preventDefault();

        let fila = $(this).parent().parent().parent();
        let id = $(this).prev().val();
        let comentario = $(this).prev().prev().val();

        verSolicitud('master', fila, id, comentario);
    });

    function verSolicitud(tipo, fila, id, comentario) {
        Swal.fire({
            title: 'Comentario',
            html: `<p>${comentario}</p><p>Indicar el motivo si rechaza</p>`,
            input: 'text',
            confirmButtonText: 'Rechazar',
            cancelButtonText: 'Aceptar',
            showCancelButton: true,
            preConfirm: function (result) {
                if (result != '') {
                    $.ajax({
                        url: `/admin/solicitud/${tipo}/rechazar`,
                        type: 'delete',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                'content'),
                        },
                        data: {
                            id: id,
                            motivo: result,
                        },
                        success: function (resultado) {
                            notificacionEstado(resultado.estado, resultado.mensaje);
                            successSwal(fila, resultado);
                        }
                    });
                } else {
                    Swal.showValidationMessage(`Por favor, indica un motivo.`);
                }
            }
        }).then((result) => {
            if (result.isDismissed) {
                $.ajax({
                    url: `/admin/solicitud/${tipo}/aceptar`,
                    type: 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        id: id,
                    },
                    success: function (resultado) {
                        notificacionEstado(resultado.estado, resultado.mensaje);
                        successSwal(fila, resultado);
                    }
                });
            }
        });
    }

    function successSwal(fila, resultado) {
        if (resultado.estado != "error") {
            if ($('.numero-desarrolladoras').text() == 1) {
                $('.desarrolladoras').remove();
            } else {
                $('.numero-desarrolladoras').text($('.numero-desarrolladoras').text() - 1);
                fila.remove();
            }
            $('.numero-solicitudes').text($('.numero-solicitudes').text() - 1);
            if ($('.numero-solicitudes').text() > 0) {
                $('.solicitudes-count').text($('.solicitudes-count').text() - 1);
            } else {
                $('.solicitudes-li').remove();
            }
        }
    }


});

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
            $('#solicitudes-count').text($('#solicitudes-count').text() - 1);
        } else {
            $('.solicitudes-li').remove();
        }
    }
}

function ban(elemento, url, title) {
    Swal.fire({
        title: title,
        showCancelButton: true,
        cancelButtonText: 'Cancelar',
        confirmButtonText: `Ban`,
        input: 'text',
        inputAttributes: {
            autocapitalize: 'off'
        },
        preConfirm: function (motivo) {
            if (motivo != '') {
                $.ajax({
                    url: url,
                    type : 'POST',
                    headers:{
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    data: {
                        motivo: motivo,
                    }
                    ,success: function(mensaje){
                        elemento.removeClass('btn-warning btn-ban').addClass('btn-success btn-unban');
                        elemento.on('click', function() {
                            unban($(this), url.replace("ban", "unban"), motivo);
                        });
                        notificacionEstado('success', mensaje);
                    },
                    error: function() {
                        notificacionEstado('error', 'No se ha podido realizar la acción');
                    }
                });
            }else{
                Swal.showValidationMessage(`Por favor, indica un motivo.`)
            }
        }
    });
}

function unban(elemento, url, motivo, title) {
    Swal.fire({
        title: title,
        showCancelButton: true,
        cancelButtonText: 'Cancelar',
        confirmButtonText: `Aceptar`,
        html: `<p>Motivo:</p><p>${motivo}</p>`,
        preConfirm: function () {
            $.ajax({
                url: url,
                type : 'POST',
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                data: {
                    motivo: motivo,
                },
                success: function(mensaje){
                    elemento.removeClass('btn-success btn-unban').addClass('btn-warning btn-ban');
                    elemento.on('click', function() {
                        ban($(this), url.replace("unban", "ban"));
                    });
                    elemento.prev().remove();
                    notificacionEstado('success', mensaje);
                },
                error: function() {
                    notificacionEstado('error', 'No se ha podido realizar la acción');
                }
            });
        }
    });
}

function graficaUsuarios(masters, cms, usuarios) {
    var ctx = document.getElementById("myChart").getContext("2d");
    var data = {
        datasets: [{
            backgroundColor: ["#ff6384", "#A086BE", "#333333"],
            data: [masters, usuarios, cms]
        }],
        labels: ["Masters", "Fans", "Cms"]
    };
    var myBarChart = new Chart(ctx, {
        type: "doughnut",
        data: data,
    });
}

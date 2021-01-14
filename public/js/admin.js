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

    /**
     * SUBMENU CLICK EVENT
     */
    $(".submenu-items").children("li").children("a").on("click", function (e) {
        e.preventDefault();
        let item = $(this).attr("id");
        $("#contenido").children("div").addClass("d-none");
        $(`.${item}`).removeClass("d-none");
        $('.navbar-toggler').addClass('collapsed');
        $('.navbar-collapse').removeClass('show');
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
                    url: `http://www.iestrassierra.net/alumnado/curso2021/DAWS/daws2021a1/indie4all/admin/solicitud/${tipo}/rechazar`,
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
                        successSwal(tipo, fila, resultado);
                    },
                    error: function () {
                        notificacionEstado('error', 'No se ha podido realizar la acción');
                    }
                });
            } else {
                Swal.showValidationMessage(`Por favor, indica un motivo.`);
            }
        }
    }).then((result) => {
        if (result.isDismissed) {
            $.ajax({
                url: `http://www.iestrassierra.net/alumnado/curso2021/DAWS/daws2021a1/indie4all/admin/solicitud/${tipo}/aceptar`,
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: id,
                },
                success: function (resultado) {
                    notificacionEstado(resultado.estado, resultado.mensaje);
                    successSwal(tipo, fila, resultado.estado);
                },
                error: function () {
                    notificacionEstado('error', 'No se ha podido realizar la acción');
                }
            });
        }
    });
}

function successSwal(tipo, fila, resultado) {
    if (resultado != "error") {
        if ($('.numero-' + tipo + 's').text() == 1) {
            $('.' + tipo + 's').remove();
        } else {
            $('.numero-' + tipo + 's').text($('.numero-' + tipo + 's').text() - 1);
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
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    data: {
                        motivo: motivo,
                    }
                    , success: function (mensaje) {
                        elemento.removeClass('btn-warning btn-ban').addClass('btn-success btn-unban');
                        elemento.on('click', function () {
                            unban($(this), url.replace("ban", "unban"), motivo);
                        });
                        notificacionEstado('success', mensaje);
                    },
                    error: function () {
                        notificacionEstado('error', 'No se ha podido realizar la acción');
                    }
                });
            } else {
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
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                data: {
                    motivo: motivo,
                },
                success: function (mensaje) {
                    elemento.removeClass('btn-success btn-unban').addClass('btn-warning btn-ban');
                    elemento.on('click', function () {
                        ban($(this), url.replace("unban", "ban"));
                    });
                    elemento.prev().remove();
                    notificacionEstado('success', mensaje);
                },
                error: function () {
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

    let myBarChart = new Chart(ctx, {
        type: "doughnut",
        data: data,
    });
}

function graficaGeneros(generos, datos) {
    var ctx = document.getElementById("myChart").getContext("2d");

    var datos = {
        labels: generos,
        datasets: [{
            label: "Juegos",
            backgroundColor: "#ff6384",
            data: datos[0]
        },
        {
            label: "Seguidores",
            backgroundColor: "#A086BE",
            data: datos[1]
        },
        ],
    };

    let myBarChart = new Chart(ctx, {
        type: "bar",
        data: datos,
        options: {
            barValueSpacing: 20,
            scales: {
                yAxes: [{
                    ticks: {
                        min: 0,
                    }
                }]
            }
        },
        responsive: true
    });
}

function graficaLogros(logros, datos) {
    var ctx = document.getElementById("myChart").getContext("2d");

    var datos = {
        labels: logros,
        datasets: [{
            label: "Usuarios que lo han conseguido",
            backgroundColor: "#ff6384",
            data: datos
        },
        ],
    };

    var myBarChart = new Chart(ctx, {
        type: "bar",
        data: datos,
        options: {
            barValueSpacing: 20,
            scales: {
                yAxes: [{
                    ticks: {
                        min: 0,
                    }
                }]
            }
        },
        responsive: true,
    });
}


function notificacionAdmin(solicitudes, reportes) {
    let mensaje = '';
    if(solicitudes != '') {
        mensaje += `<span class="d-block">${solicitudes}</span>`;
    }
    if(reportes != '') {
        mensaje += `<span class="d-block">${reportes}</span>`;
    }
    Swal.fire({
        position: "top-end",
        icon: "info",
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

function graficaPosts(numPosts, dias) {
    let ctx = document.getElementById("posts").getContext("2d");

    let myLineChart = new Chart(ctx, {
        type: "bar",
        data: {
            labels: dias,
            datasets: [{
                label: "Posts",
                data: numPosts,
                backgroundColor: "#ff6384",
                borderWidth: 1
            }]
        },
        responsive: true,
    });
}

function graficaMensajes(numMensajes, dias) {
    let ctx = document.getElementById("mensajes").getContext("2d");

    let myLineChart = new Chart(ctx, {
        type: "bar",
        data: {
            labels: dias,
            datasets: [{
                label: "Mensajes",
                data: numMensajes,
                backgroundColor: "#ff6384",
                borderWidth: 1
            }]
        },
        responsive: true,
    });
}

"use strict"

$(function () {
    $('.js-cookie-consent-agree').addClass('btn btn-light');

    $('.js-cookie-consent-agree').on('click', function() {
        $('.nav-cookie').remove();
    })

    /**
     * BUSCADOR
     */

    $(document).on("keydown", function (event) {
        if (event.ctrlKey && event.code == "KeyY") {
            busqueda();
        }
    });

    $(".search").on("click", busqueda);

    function busqueda() {
        Swal.fire({
            position: 'top',
            title: '<div class="input-group"><div class="input-group-prepend"><span class="input-group-text bg-light"><i class="fas fa-search"></i></span></div><input type="text" class="form-control" placeholder="Buscar" id="busqueda" autocomplete="off"></div>',
            html: '<small><span class="badge badge-secondary d-none d-md-inline">Tab</span> Moverse entre los resultados <span class="badge badge-secondary ml-3">Esc</span> Cerrar búsqueda</small><div></div>',
            showCloseButton: false,
            showCancelButton: false,
            showConfirmButton: false,
            customClass: 'swal-height',
            showClass: {
                popup: 'animate__animated animate__zoomIn'
            },
            hideClass: {
                popup: 'animate__animated animate__zoomOut'
            }
        });

        $("#busqueda").on("keyup", function () {
            $(".swal2-html-container>div").html("");
            if ($("#busqueda").val() != "") {
                $.ajax({
                    url: "/busqueda",
                    datatype: "json",
                    data: {
                        q: $("#busqueda").val(),
                    },
                    success: function (data) {
                        let html = '<div class="list-group mb-4 mt-2 mr-3">';
                        if (data.length == 0) {
                            $(".swal2-html-container>div").append('<p class="mt-3">No se ha encontrado ningún resultado</p>');
                        } else {
                            data.forEach(element => {
                                if (element.tipo == "Juego") {
                                    if (html.indexOf("<h4 class='mt-2 mb-2'>Juegos</h4>") == -1) {
                                        html += `<h4 class='mt-2 mb-2'>Juegos</h4><small><a href="/juegos/lista">Ver todos</a></small><div class="owl-carousel owl-theme 1">`;
                                    }
                                    html += `<div class="item"><a href="/juego/${element.id}"><img src="https://spdc.ulpgc.es/media/ulpgc/images/thumbs/edition-44827-200x256.jpg" alt="${element.nombre}"><div class="carousel-caption mb-2" style="display: none;"><h6><strong>${element.nombre}</strong></h6></div></a></div>`;
                                } else if (element.tipo == "Campaña") {
                                    if (html.indexOf("<h4 class='mt-2 mb-2'>Campañas</h4>") == -1) {
                                        html += `</div><h4 class='mt-2 mb-2'>Campañas</h4><small><a href="/campanias/lista">Ver todas</a></small><div class="owl-carousel owl-theme 1">`;
                                    }
                                    html += `<div class="item"><a href="/campania/${element.id}"><img src="https://spdc.ulpgc.es/media/ulpgc/images/thumbs/edition-44827-200x256.jpg" alt="${element.nombre}"><div class="carousel-caption mb-2" style="display: none;"><h6><strong>${element.nombre}</strong></h6></div></a></div>`;
                                } else if (element.tipo == "Desarrolladora") {
                                    if (html.indexOf("<h4 class='mt-2 mb-2'>Desarrolladoras</h4>") == -1) {
                                        html += `</div><h4 class='mt-2 mb-2'>Desarrolladoras</h4><small><a href="/desarrolladoras/lista">Ver todas</a></small><div class="owl-carousel owl-theme 1">`;
                                    }
                                    html += `<div class="item"><a href="/desarrolladora/${element.id}"><img src="https://spdc.ulpgc.es/media/ulpgc/images/thumbs/edition-44827-200x256.jpg" alt="${element.nombre}"><div class="carousel-caption mb-2" style="display: none;"><h6><strong>${element.nombre}</strong></h6></div></a></div>`;
                                } else if (element.tipo == "Master") {
                                    if (html.indexOf("<h4 class='mt-2 mb-2'>Masters</h4>") == -1) {
                                        html += `</div><h4 class='mt-2 mb-2'>Masters</h4><small><a href="/masters/lista">Ver todas</a></small><div class="owl-carousel owl-theme 1">`;
                                    }
                                    html += `<div class="item"><a href="/master/${element.id}"><img src="https://spdc.ulpgc.es/media/ulpgc/images/thumbs/edition-44827-200x256.jpg" alt="${element.nombre}"><div class="carousel-caption mb-2" style="display: none;"><h6><strong>${element.nombre}</strong></h6></div></a></div>`;
                                }
                            });
                            html += '</div>';
                            $(".swal2-html-container>div").append(html);
                            var owl = $('.1');
                            owl.owlCarousel({
                                center: false,
                                items: 2,
                                loop: false,
                                margin: 10,
                                responsive: {
                                    0: {
                                        items: 2
                                    },
                                    600: {
                                        items: 3
                                    },
                                    1000: {
                                        items: 4
                                    }
                                }
                            });
                            $('.item').on('mouseenter', function () {
                                $(this).children('a').children('img').css('filter', 'brightness(0.2)');
                                $(this).children('a').children('div').fadeToggle(0, "linear");
                            }).on('mouseleave', function () {
                                $(this).children('a').children('img').css('filter', 'brightness(1)');
                                $(this).children('a').children('div').fadeToggle(0, "linear");
                            });
                        }
                    }
                });
            }
        });
    }

    /**
     * COMPONENTES MASTER
     */

    $(".eliminar-estado").on('click', function () {
        $(this).parent().on('submit');
        $(this).parent().parent().remove();
    });

    /**
     * FORMS
     */

    // Form de store de solicitud desarrolladora
    $('#form-solicitud-desarrolladora').on("submit", function (e) {
        if (grecaptcha.getResponse().length == 0) {
            e.preventDefault();
            $('.recaptcha-error').text('Debes realizar el captcha');
        }
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

    /**
     * PAGINGA NOTICIAS
     */

    $(".noticias, .actualizaciones, .mensajes, .analisis-div, .estados").paginga({
        maxPageNumbers: 3,
        itemsPerPage: 6
    });

    /**
     * OWL
     */

    $(".item").hover(function () {
        $(this).children('a').children('img').css('filter', 'brightness(0.2)');
        $(this).children('a').children('div').removeClass('d-none');
    }, function () {
        $(this).children('a').children('img').css('filter', 'brightness(1)');
        $(this).children('a').children('div').addClass('d-none');
    });

    /**
     * Botones lista
     */

    $('.list-buttons').on('click', function (e) {
        e.preventDefault();
        let item = $(this).attr('id');
        if (!$(this).hasClass('bg-dark')) {
            $('.list-buttons').removeClass('bg-dark text-white');
            $(this).addClass('bg-dark text-white');
        }
        $('.listado').addClass('d-none');
        $('.' + item).removeClass('d-none');
    });

    $('.list-buttons-2').on('click', function (e) {
        e.preventDefault();
        let item = $(this).attr('id');
        if (!$(this).hasClass('bg-dark')) {
            $('.list-buttons-2').removeClass('bg-dark text-white');
            $(this).addClass('bg-dark text-white');
        }
        $('.listado-2').addClass('d-none');
        $('.' + item).removeClass('d-none');
    });

    $('.list-buttons-juegos, .list-buttons-campanias, .list-buttons-masters').on('click', function (e) {
        e.preventDefault();
        let tipo = "";
        if($(this).hasClass('list-buttons-juegos')) {
            tipo = 'juegos';
        } else if ($(this).hasClass('list-buttons-campanias')) {
            tipo = 'campanias';
        } else if ($(this).hasClass('list-buttons-masters')) {
            tipo = 'masters';
        }
        let item = $(this).attr('id');
        if (!$(this).hasClass('bg-dark')) {
            $('.list-buttons-' + tipo).removeClass('bg-dark text-white');
            $(this).addClass('bg-dark text-white');
        }
        $('.listado-' + tipo).addClass('d-none');
        $('.' + item).removeClass('d-none');
    });
});

/**
 * COMPARTIR
 */

function compartir(event) {
    Swal.fire({
        html: event.data.html,
        showCloseButton: false,
        showCancelButton: false,
        showConfirmButton: false,
        showClass: {
            popup: 'animate__animated animate__slideInDown'
        },
        hideClass: {
            popup: 'animate__animated animate__zoomOutDown'
        }
    });

    $(".copiar").on('click', function () {
        $("#input-link").on('select');
        document.execCommand("copy");
        $("#input-link").on('blur');
    });
}

/**
 * LEER MAS
 */

function more(url, id, config, checkUser) {
    $.ajax({
        url: url,
        data: {
            id: id,
        },
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                'content'),
        },
        success: function (data) {
            let report = '';
            if ((data.post.juego_id != null || data.post.master_id != null || data.post.desarrolladora_id != null || data.post.campania_id != null) && checkUser) {
                report = `<input id="idPost" type="hidden" value="${data.post.id}"><button class="btn btn-danger btn-sm mr-1 float-right" id='reportePost'><i class="fas fa-exclamation-triangle"></i></button>`;
            }
            let html = `<div class='post text-justify'><h3 class="d-inline">${data.post.titulo}</h3><button class="btn btn-dark btn-sm float-right volver">Volver</button>${report}<div class="contenido-post mt-4 mb-4">${data.post.contenido}</p></div>`;
            if (checkUser) {
                html += `<textarea class="form-control" name="mensaje" id="editor"></textarea><button class="btn btn-success mt-3 mb-3" id="mensaje-form">Comentar</button><h4>Comentarios</h4><div class="mensajes">`;
                if (data.mensajes.length > 0) {
                    data.mensajes.forEach(element => {
                        let logros = '';
                        data.logros.forEach(logro => {
                            if(logro.id == element.id) {
                                logros += `<i class="${logro.icono} ml-2"></i>`;
                            }
                        });
                        html += `<div class="alert alert-dark" role="alert">${element.name}${logros} <small>${element.created_at}</small><input type="hidden" value="${element.id}"><a name="${element.id}asd" class="text-danger float-right"><i class="fas fa-exclamation-triangle" name='reportarMensaje'></i></a><p>${element.contenido}</p></div>`;
                    });
                } else {
                    html += '<div class="mensaje mt-3">No hay ningún mensaje</div>';
                }
            }
            html += '</div></div>';
            window.scrollTo({ top: 100, behavior: 'smooth' });
            $('.more-div').html(html);
            $('.more-div').css('left', 0);
            $('.volver').on('click', function (e) {
                $('.more-div').css('left', -10000);
            });
            if (checkUser) {
                CKEDITOR.replace("mensaje", {
                    customConfig: config
                });
            }
            $('#reportePost').on('click', function () {
                reporte('/reporte', $('#idPost').val(), 'post_id');
            });
            $("#mensaje-form").on('click', function (e) {
                e.preventDefault();
                let mensaje = CKEDITOR.instances.editor.getData();
                CKEDITOR.instances.editor.setData("");
                $.ajax({
                    url: '/mensaje/nuevo',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        id: data.post.id,
                        mensaje: mensaje
                    },
                    success: function (data) {
                        if ($('.mensajes').children().text() == "No hay ningún mensaje") {
                            $('.mensaje').html(`<div class="alert alert-dark" role="alert">${data.autor} <small>${data.created_at}</small><p>${data.contenido}</p></div>`);
                        } else {
                            $('.mensajes').append(`<div class="alert alert-dark" role="alert">${data.autor} <small>${data.created_at}</small><p>${data.contenido}</p></div>`);
                        }
                    }
                });
            });
            $('i[name ="reportarMensaje"]').on('click', function () {
                reporte('/reporte', $(this).parent().prev().val(), 'mensaje_id');
            });
        }
    });
}

/**
 * REPORTES
 */

function reporte(url, id, tipo) {
    Swal.fire({
        title: 'Indica el motivo del reporte',
        showCancelButton: true,
        cancelButtonText: 'Cancelar',
        confirmButtonText: `Reportar`,
        input: 'text',
        inputAttributes: {
            autocapitalize: 'off'
        },
        html: '<div id="recaptcha" class="mb-3"></div>',
        didOpen: function () {
            grecaptcha.render('recaptcha', {
                'sitekey': '6Lc2ufwZAAAAAFtjN9fasxuJc0OEf670ruHSTEfP'
            });
        },
        preConfirm: function (result) {
            if (grecaptcha.getResponse().length === 0) {
                Swal.showValidationMessage(`Por favor, verifica que no eres un robot`)
            } else if (result != '') {
                let motivo = result;
                $.ajax({
                    url: url,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    data: {
                        id: id,
                        tipo: tipo,
                        motivo: motivo,
                    },
                    success: function (data) {
                        Swal.fire(data)
                    }
                })
            } else {
                Swal.showValidationMessage(`Por favor, indica un motivo.`)
            }
        }
    });
}

/**
 * OWL
 */

function crearOwl(owl, loop, items1, items2, items3) {
    owl.owlCarousel({
        loop: loop,
        margin: 10,
        dots: true,
        responsive: {
            0: {
                items: items1
            },
            600: {
                items: items2
            },
            1000: {
                items: items3
            }
        }
    });

    mousewheel(owl);
}

function mousewheel(owl) {
    owl.on('mousewheel', '.owl-stage', function (e) {
        e.preventDefault();
        if (e.originalEvent.wheelDelta > 0) {
            owl.trigger('prev.owl');
        } else {
            owl.trigger('next.owl');
        }
    });
}

/**
 * Componente Master
 */

function nuevoEstado(csrf, config) {
    Swal.fire({
        showCloseButton: true,
        position: 'bottom',
        title: 'Nuevo estado',
        html: `<form action="/master/estado/nuevo" method="post">${csrf}<textarea class="form-control nuevo-estado" name="estado" id="editor" autofocus></textarea><button class="btn btn-success mt-3 mb-3" id="estado-form">Comentar</button></form>`,
        showCancelButton: false,
        showConfirmButton: false,
        backdrop: false,
        allowOutsideClick: false,
        showClass: {
            popup: 'animate__animated animate__bounceInUp'
        },
        hideClass: {
            popup: 'animate__animated animate__backOutDown'
        }
    });
    CKEDITOR.replace("estado", {
        customConfig: config
    });
}

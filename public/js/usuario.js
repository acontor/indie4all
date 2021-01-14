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
            html: '<small class="d-none d-md-inline"><span class="badge badge-secondary">Tab</span> Moverse entre los resultados <span class="badge badge-secondary ml-3">Esc</span> Cerrar búsqueda</small><div><p class="mt-4">Busca Juegos, Campañas, Desarrolladoras y Masters</p></div>',
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
            var interval = setInterval(function(){
                let parametro = $("#busqueda").val();
                if ($("#busqueda").val() != "") {
                    $.ajax({
                        url: "http://www.iestrassierra.net/alumnado/curso2021/DAWS/daws2021a1/indie4all/index.php/busqueda",
                        datatype: "json",
                        data: {
                            q: parametro,
                        },
                        success: function (data) {
                            console.log(data)
                            let html = '<div class="list-group mb-4 mt-2 mr-3">';
                            if (data.length == 0) {
                                $(".swal2-html-container>div").append('<p class="mt-3">No se ha encontrado ningún resultado</p>');
                            } else {
                                data.forEach(element => {
                                    let img = '';
                                    if (element.tipo == "Juego") {
                                        if (html.indexOf("<h4 class='d-inline'>Juegos</h4>") == -1) {
                                            html += `<div class="d-inline mt-4 mb-4"><h4 class='d-inline'>Juegos</h4><a class="btn btn-dark btn-sm float-right" href="http://www.iestrassierra.net/alumnado/curso2021/DAWS/daws2021a1/indie4all/juegos/lista">Ver todos</a></div><div class="owl-carousel owl-theme 1">`;
                                        }
                                        img = element.imagen_caratula == null ? `<img class="img-fluid shadow" src="http://www.iestrassierra.net/alumnado/curso2021/DAWS/daws2021a1/public/images/desarrolladoras/default-logo-juego.png" alt="${ element.nombre }">` : `<img class="img-fluid shadow" src="http://www.iestrassierra.net/alumnado/curso2021/DAWS/daws2021a1/public/images/desarrolladoras/${ element.desarrolladora }/${ element.nombre }/${ element.imagen_caratula }" alt="${ element.nombre }"></img>`;
                                        html += `<div class="item"><a href="http://www.iestrassierra.net/alumnado/curso2021/DAWS/daws2021a1/indie4all/juego/${element.id}">${img}<div class="carousel-caption" style="display: none;"><h6><strong>${element.nombre}</strong></h6></div></a></div>`;
                                    } else if (element.tipo == "Campaña") {
                                        if (html.indexOf("<h4 class='d-inline'>Campañas</h4>") == -1) {
                                            html += `</div><hr class="mt-4 mb-4 hr-busqueda"><div class="d-inline"><h4 class='d-inline'>Campañas</h4><a class="btn btn-dark btn-sm float-right" href="http://www.iestrassierra.net/alumnado/curso2021/DAWS/daws2021a1/indie4all/campanias/lista">Ver todas</a></div><div class="owl-carousel owl-theme 1">`;
                                        }
                                        img = element.imagen_caratula == null ? `<img class="img-fluid shadow" src="http://www.iestrassierra.net/alumnado/curso2021/DAWS/daws2021a1/public/images/desarrolladoras/default-logo-juego.png" alt="${ element.nombre }">` : `<img class="img-fluid shadow" src="http://www.iestrassierra.net/alumnado/curso2021/DAWS/daws2021a1/public/images/desarrolladoras/${ element.desarrolladora }/${ element.nombre }/${ element.imagen_caratula }" alt="${ element.nombre }"></img>`;
                                        html += `<div class="item"><a href="http://www.iestrassierra.net/alumnado/curso2021/DAWS/daws2021a1/indie4all/campania/${element.id}">${img}<div class="carousel-caption" style="display: none;"><h6><strong>${element.nombre}</strong></h6></div></a></div>`;
                                    } else if (element.tipo == "Desarrolladora") {
                                        if (html.indexOf("<h4 class='d-inline'>Desarrolladoras</h4>") == -1) {
                                            html += `</div><hr class="mt-4 mb-4 hr-busqueda"><div class="d-inline mt-4 mb-4"><h4 class='d-inline'>Desarrolladoras</h4><a class="btn btn-dark btn-sm float-right" href="http://www.iestrassierra.net/alumnado/curso2021/DAWS/daws2021a1/indie4all/desarrolladoras/lista">Ver todas</a></div><div class="owl-carousel owl-theme 1">`;
                                        }
                                        img = element.imagen_logo == null ? `<img class="img-fluid shadow" src="http://www.iestrassierra.net/alumnado/curso2021/DAWS/daws2021a1/public/images/desarrolladoras/default-logo-desarrolladora.png" alt="${ element.nombre }">` : `<img class="img-fluid shadow" src="http://www.iestrassierra.net/alumnado/curso2021/DAWS/daws2021a1/public/images/desarrolladoras/${ element.nombre }/${ element.imagen_logo }" alt="${ element.nombre }"></img>`;
                                        html += `<div class="item"><a href="http://www.iestrassierra.net/alumnado/curso2021/DAWS/daws2021a1/indie4all/desarrolladora/${element.id}">${img}<div class="carousel-caption" style="display: none;"><h6><strong>${element.nombre}</strong></h6></div></a></div>`;
                                    } else if (element.tipo == "Master") {
                                        if (html.indexOf("<h4 class='d-inline'>Masters</h4>") == -1) {
                                            html += `</div><hr class="mt-4 mb-4 hr-busqueda"><div class="d-inline mt-4 mb-4"><h4 class='d-inline'>Masters</h4><a class="btn btn-dark btn-sm float-right" href="http://www.iestrassierra.net/alumnado/curso2021/DAWS/daws2021a1/indie4all/masters/lista">Ver todos</a></div><div class="owl-carousel owl-theme 1">`;
                                        }
                                        img = element.imagen_logo == null ? `<img class="img-fluid shadow" src="http://www.iestrassierra.net/alumnado/curso2021/DAWS/daws2021a1/public/images/masters/default-logo.png" alt="${ element.nombre }">` : `<img class="img-fluid shadow" src="http://www.iestrassierra.net/alumnado/curso2021/DAWS/daws2021a1/public/images/masters/${ element.nombre }/${ element.imagen_logo }" alt="${ element.nombre }"></img>`;
                                        html += `<div class="item"><a href="http://www.iestrassierra.net/alumnado/curso2021/DAWS/daws2021a1/indie4all/master/${element.id}">${img}<div class="carousel-caption" style="display: none;"><h6><strong>${element.nombre}</strong></h6></div></a></div>`;
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
                clearInterval(interval);
            }, 100);
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

    $(".noticias, .actualizaciones, .mensajes, .analisis-div, .estados, .masters, .desarrolladoras, .juegos").paginga({
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
            $('.list-buttons').removeClass('bg-dark text-white').addClass('text-dark');
            $(this).addClass('bg-dark text-white').removeClass('text-dark');
        }
        $('.listado').addClass('d-none');
        $('.' + item).removeClass('d-none');
    });

    $('.list-buttons-2').on('click', function (e) {
        e.preventDefault();
        let item = $(this).attr('id');
        if (!$(this).hasClass('bg-dark')) {
            $('.list-buttons-2').removeClass('bg-dark text-white').addClass('text-dark');
            $(this).addClass('bg-dark text-white').removeClass('text-dark');
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
        $("#input-link").select();
        document.execCommand("copy");
        $("#input-link").blur();
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
            let html = `<div class='post text-justify'><h3 class="d-inline">${data.post.titulo}</h3><button class="btn btn-dark btn-sm float-right volver">Volver</button>${report}<div class="contenido-post m-4 p-4">${data.post.contenido}</p></div>`;
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
                        html += `<div class="berber">${element.name}${logros}<input type="hidden" value="${element.id}"><a name="${element.id}" class="btn btn-danger btn-sm text-white float-right"><i class="fas fa-exclamation-triangle" name='reportarMensaje'></i></a><p>${element.contenido}</p><small> ${element.created_at}</small></div>`;
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
                    url: 'http://www.iestrassierra.net/alumnado/curso2021/DAWS/daws2021a1/indie4all/mensaje/nuevo',
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
                            $('.mensaje').html(`<div class="berber">${data.autor}<p>${data.contenido}</p></div>`);
                        } else {
                            $('.mensajes').append(`<div class="berber">${data.autor}<p>${data.contenido}</p></div>`);
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
        position: 'bottom',
        title: 'Nuevo estado',
        html: `<form action="http://www.iestrassierra.net/alumnado/curso2021/DAWS/daws2021a1/indie4all/master/estado/nuevo" method="post">${csrf}<textarea class="form-control nuevo-estado" name="estado" id="editor" autofocus></textarea><button class="btn btn-success mt-3 mb-3" id="estado-form">Comentar</button></form>`,
        showCancelButton: false,
        showConfirmButton: false,
        showCloseButton: false,
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

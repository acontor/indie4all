"use strict"

$(function () {
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

        $("#busqueda").on("keyup", function() {
            $(".swal2-html-container>div").html("");
            if($("#busqueda").val() != "") {
                $.ajax({
                    url: "/busqueda",
                    datatype: "json",
                    data: {
                        q: $("#busqueda").val(),
                    },
                    success: function(data) {
                        let html = '<div class="list-group mb-4 mt-2 mr-3">';
                        if(data.length == 0) {
                            $(".swal2-html-container>div").append('<p class="mt-3">No se ha encontrado ningún resultado</p>');
                        } else {
                            data.forEach(element => {
                                if(element.tipo == "Juego") {
                                    if(html.indexOf("<h4 class='mt-2 mb-2'>Juegos</h4>") == -1) {
                                        html += `<h4 class='mt-2 mb-2'>Juegos</h4><small><a href="/juegos/lista">Ver todos</a></small><div class="owl-carousel owl-theme 1">`;
                                    }
                                    html += `<div class="item"><a href="/juego/${element.id}"><img src="https://spdc.ulpgc.es/media/ulpgc/images/thumbs/edition-44827-200x256.jpg" alt="${element.nombre}"><div class="carousel-caption mb-2" style="display: none;"><h6><strong>${element.nombre}</strong></h6></div></a></div>`;
                                } else if (element.tipo == "Desarrolladora") {
                                    if(html.indexOf("<h4 class='mt-2 mb-2'>Desarrolladoras</h4>") == -1) {
                                        html += `</div><h4 class='mt-2 mb-2'>Desarrolladoras</h4><small><a href="/desarrolladoras/lista">Ver todas</a></small><div class="owl-carousel owl-theme 1">`;
                                    }
                                    html += `<div class="item"><a href="/desarrolladora/${element.id}"><img src="https://spdc.ulpgc.es/media/ulpgc/images/thumbs/edition-44827-200x256.jpg" alt="${element.nombre}"><div class="carousel-caption mb-2" style="display: none;"><h6><strong>${element.nombre}</strong></h6></div></a></div>`;
                                } else if (element.tipo == "Master") {
                                    if(html.indexOf("<h4 class='mt-2 mb-2'>Masters</h4>") == -1) {
                                        html += `</div><h4 class='mt-2 mb-2'>Masters</h4><small><a href="/masters/lista">Ver todas</a></small><div class="owl-carousel owl-theme 1">`;
                                    }
                                    html += `<div class="item"><a href="/master/${element.id}"><img src="https://spdc.ulpgc.es/media/ulpgc/images/thumbs/edition-44827-200x256.jpg" alt="${element.nombre}"><div class="carousel-caption mb-2" style="display: none;"><h6><strong>${element.nombre}</strong></h6></div></a></div>`;
                                }
                            });
                            html += '</div>';
                            $(".swal2-html-container>div").append(html);
                            var owl = $('.1');
                            owl.owlCarousel({
                                center: true,
                                items:2,
                                loop:true,
                                margin:10,
                                responsive: {
                                    0: {
                                        items: 2.5
                                    },
                                    600: {
                                        items: 2.5
                                    },
                                    1000: {
                                        items: 3.5
                                    }
                                }
                            });
                            $('.item').on('mouseenter', function() {
                                $(this).children('a').children('img').css('filter', 'brightness(0.2)');
                                $(this).children('a').children('div').fadeToggle(0, "linear");
                            }).on('mouseleave', function() {
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
     * VERIFICAR
     */

    $(".verify-link").on("click", verificar);

    function verificar() {
        $.ajax({
            url: "{{ route('verification.resend') }}",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                $(".verify-alert").html("El correo debe haberse enviado a su bandeja de entrada. Compruebe su bandeja de spam si no le llega.")
            }
        });
    }

    /**
     * COMPONENTES MASTER
     */

    $(".estado").parent().on("click", function() {
        Swal.fire({
            position: 'bottom',
            title: 'Nuevo estado',
            html: '<textarea class="form-control" name="nuevo-estado" id="editor"></textarea><button class="btn btn-success mt-3 mb-3" id="estado-form">Comentar</button>',
            showCloseButton: false,
            showCancelButton: false,
            showConfirmButton: false,
            showClass: {
                popup: 'animate__animated animate__bounceInUp'
            },
            hideClass: {
                popup: 'animate__animated animate__backOutDown'
            }
        });
        CKEDITOR.replace("nuevo-estado", {
            customConfig: "{{ asset('js/ckeditor/config.js') }}"
        });
        $("#estado-form").click(function(e) {
            e.preventDefault();
            let estado = CKEDITOR.instances.editor.getData();
            CKEDITOR.instances.editor.setData("");
            $.ajax({
                url: '{{ route("master.estado.store") }}',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    estado: estado
                }
            });
        });
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
});

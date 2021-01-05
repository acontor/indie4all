"use strict"

$(function () {

    // Ejecuta todos los popover de la parte de usuarios
    $('.pop-info').popover();

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
    $(".submenu-items").children("li").children("a").on("click", function(e) {
        e.preventDefault();
        let item = $(this).attr("id");
        $("#contenido").children("div").addClass("d-none");
        $(`.${item}`).removeClass("d-none");
    });
});

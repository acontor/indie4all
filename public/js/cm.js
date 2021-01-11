"use strict"

$(function() {
    /**
     * SUBMENU CLICK EVENT
     */
    $(".submenu-items").children("li").children("a").on("click", function (e) {
        e.preventDefault();
        let item = $(this).attr("id");
        $("#main").children("div").addClass("d-none");
        $(`.${item}`).removeClass("d-none");
        $('.navbar-toggler').addClass('collapsed');
        $('.navbar-collapse').removeClass('show');
    });
});


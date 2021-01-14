"use strict"

function graficaUsuarios(seguidores) {
    let ctx = document.getElementById("active-users").getContext("2d");

    let diaActual = new Date();

    let dias = [];

    for (let index = 4; index >= 0; index--) {
        diaActual.setDate(diaActual.getDate() - index);
        dias.push(diaActual.getDate())
        diaActual.setDate(diaActual.getDate() + index);
    }

    let datos = [];

    dias.forEach(dia => {
        let count = 0;

        seguidores.forEach(seguidor => {
            if (seguidor.pivot.created_at.split("T")[0] == (diaActual.getFullYear() + "-" + ("0" + diaActual.getMonth() + 1).slice(-2) + "-" + ("0" + dia).slice(-2))) {
                count++;
            }
        });

        datos.push(count);
    });

    new Chart(ctx, {
        type: "line",
        data: {
            labels: dias,
            datasets: [{
                label: "Nuevos seguidores",
                data: datos,
                borderColor: "#E34E33",
                backgroundColor: "transparent",
                borderWidth: 1
            }]
        },
        responsive: true,
    });

    $("#juegos").select2({
        language: "es",
        width: "auto",
        placeholder: "Juegos",
        maximumSelectionLength: 5,
        language: {
            maximumSelected: function (e) {
                var message = "Solo puedes seleccionar " + e.maximum + " Juegos";
                return message;
            }
        }
    });
}

var tabla;

//Función que se ejecuta al inicio
function init() {
    mostrarform(false);
    listar();

    $("#formulario").on("submit", function(e) {
        guardar(e);
    })
}


//Función para guardar o editar

function guardar() {



    var datos = $("#formulario").serialize();
    console.log(datos);
    $.ajax({
        url: "../Controlador/guardar_segunda_visita_controlador.php?op=guardar",
        type: "POST",
        data: datos,


        success: function(d) {

            swal({
                title: d,

                icon: "success",
                button: "OK",

            }).then(function() {
                window.location = "../vistas/menu_supervision_vista.php";
            });


        }


    });

    //limpiar();
}




listar();
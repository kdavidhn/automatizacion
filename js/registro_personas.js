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
        url: "../Controlador/guardar_personas_controlador.php?op=guardar",
        type: "POST",
        data: datos,

        success: function(d) {
            console.log(d);
            swal({
                title: d,

                icon: "success",
                button: "OK",

            }).then(function() {
                window.location = "../vistas/menu_usuarios_vista.php";
            });


        }


    });
    console.log(data);

    //limpiar();
}


//Función Listar
function listar() {
    $('#tbllistado').DataTable({
        "language": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        },
        "ajax": {
            url: '../Controlador/guardar_personas_controlador.php?op=listar',
            type: "get",
            dataType: "json",
            error: function(e) {
                console.log(e.responseText);
            }
        }
    });
}








console.log('estoy funcionando');

listar();
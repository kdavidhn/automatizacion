var tabla;

//Función que se ejecuta al inicio
function init() {
    mostrarform(false);
    listar();

    $("#formulario").on("submit", function(e) {
        guardaryeditar(e);
    })
}

//Función limpiar
function limpiar() {

    $("#id_informe").val("", "");
    $("#id_actividad").val("");
    $("#introduccion").val("");
    $("#objetivos").val("");
    $("#desarrollo").val("");
    $("#conclusiones").val("");
    $("#fch_informe").val("");
    $("#id_repositorio").val("");
    $("#nombre_archivo").val("");
    $("#dir_repositorio").val("");
    $("#id_usuario_registro").val("");
    $("#usuario").val("");
    $("#id_estado").val("");
    $("#nombre_estado").val("");
    $("#id_actividad").val("");;
}

//Función mostrar formulario
function mostrarform(flag) {
    limpiar();
    if (flag) {
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        $("#btnGuardar").prop("disabled", false);
        $("#btnagregar").hide();
    } else {
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
        $("#btnagregar").show();
    }
}

//Función cancelarform
function cancelarform() {
    limpiar();
    mostrarform(false);
}

//Función Listar
function listar() {
    tabla = $('#tbllistado').dataTable({
        "aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
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
        dom: 'fBlrtip',//Definimos los elementos del control de tabla Bfrtilp
buttons: [ ],
        "ajax": {
            url: '../Controlador/informe_actividad_cve_controlador.php?op=listar',
            type: "get",
            dataType: "json",
            error: function(e) {
                console.log(e.responseText);
            }
        },
        "bDestroy": true,
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']],
        "iDisplayLength": 5,//Paginación
        "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
    }).DataTable();
}
//Función para guardar o editar

function guardaryeditar(e) {
    e.preventDefault(); //No se activará la acción predeterminada del evento
    $("#btnGuardar").prop("disabled", true);
    var formData = new FormData($("#formulario")[0]);

    $.ajax({
        url: "../Controlador/informe_actividad_cve_controlador.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function(datos) {

            swal({

                title: datos,
                text: " ",
                icon: "info",
                buttons: false,
                dangerMode: false,
                timer: 5000,
            });
            mostrarform(false);
            tabla.ajax.reload();

        }

    });
    limpiar();
}

function mostrar(id_informe) {
    $.post("../Controlador/informe_actividad_cve_controlador.php?op=mostrar", { id_informe: id_informe }, function(data, status) {
        data = JSON.parse(data);
        mostrarform(true);


        $("#id_informe").val(data.id_informe, data.nombre_actividad);
        $("#id_actividad").select2('val', data.id_actividad);
        $("#introduccion").val(data.introduccion);
        $("#objetivos").val(data.objetivos);
        $("#desarrollo").val(data.desarrollo);
        $("#conclusiones").val(data.conclusiones);
        $("#fch_informe").val(data.fch_informe);
        $("#id_repositorio").val(data.id_repositorio);
        $("#nombre_archivo").val(data.nombre_archivo);
        $("#dir_repositorio").val(data.dir_repositorio);
        $("#id_usuario_registro").val(data.id_usuario_registro);
        $("#usuario").val(data.usuario);
        $("#id_estado").val(data.id_estado);
        $("#nombre_estado").val(data.nombre_estado);

    })
}



function eliminar(id_informe) {
    swal({
        title: "Alerta",
        text: "¿Está seguro de eliminar el informe (Esto eliminará también la lista de asistencia)?",
        icon: "warning",
        buttons: true,
        dangerMode: false,
    }).then((result) => {
        if (result) {

            $.post("../Controlador/informe_actividad_cve_controlador.php?op=eliminar", { id_informe: id_informe }, function(e) {
                swal({

                    title: e,
                    text: " Texto 2 ",
                    icon: "info",
                    buttons: false,
                    dangerMode: false,
                    timer: 3000,
                });
                tabla.ajax.reload();
            });

        }
    })
}
init();
var tabla;
//Función que se ejecuta al inicio
function init() {
    mostrarform(false);
    listar();

    $("#formulario").on("submit", function(e) {

        guardaryeditar(e);


    })
}

//alerta modal
$(document).ready(function() {

    //alert('Texto a mostrar');
    //$('#controlBuscador').select2();
    $('#alertaModal1').hide();
    $('#btnGuardar').attr("disabled", false);


    $("#form").keypress(function(e) {
        if (e.which == 13) {
            return false;
        }
    });
});




//Función limpiar
function limpiar() {
    /*    $("#id_rol").val("");
        $("#rol").val("");
        $("#descripcion").val("");*/

}

//Función mostrar formulario
function mostrarform(flag) {
    limpiar();
    if (flag) {
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        $("#btnGuardar").prop("disabled", false);

    } else {
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
    }

}
//Función cancelarform
function cancelarform() {
    limpiar();
    mostrarform(false);
}

//Función listar
function listar() {

    var fecha_inicio = $("#fecha_inicio").val();
	var fecha_fin = $("#fecha_fin").val();
    var empresa = $("#empresa").val();
    var docente = $("#docente").val();
    console.log(fecha_fin);
    tabla = $('#tbllistado').dataTable({
        "aProcessing": true, //Activamos el procesamiento del datatables
        "aServerSide": true, //Paginación y filtrado realizados por el servidor

        "ajax": {
            url: '../Controlador/estadisticas_practica_profesional_controlador.php?op=listar',
            data:{fecha_inicio: fecha_inicio,fecha_fin: fecha_fin,empresa: empresa,docente:docente},
            type: "get",
            dataType: "json",
            error: function(e) {
                console.log(e.responseText);
            }
        },
        "bDestroy": true,
        "iDisplayLength": 10, //Paginación cada cinco registros
        "order": [
                [0, "desc"]
            ] //Ordenar (columna,orden)

    }).DataTable()
}
//Función listar
function imprimir(obj) {
    
    var fecha_inicio = $("#fecha_inicio").val();
	var fecha_fin = $("#fecha_fin").val();
    var empresa = $("#empresa").val();
    var docente = $("#docente").val();

 $(obj).attr('href','../pdf/estadisticas_practica_profesional.php?fecha_inicio='+fecha_inicio+'&fecha_fin='+fecha_fin+'&empresa='+empresa+'&docente='+docente+'');

      
}


init();
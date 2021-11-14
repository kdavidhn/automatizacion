var hoy = new Date();
fecha = hoy.getDate() + '-' + ( hoy.getMonth() + 1 ) + '-' + hoy.getFullYear();
hora = hoy.getHours() + ':' + hoy.getMinutes() + ':' + hoy.getSeconds();
fechaYHora = fecha + ' ' + hora;
var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(true);
	
	

	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	})

	
}

//Función limpiar
/*function limpiar()
{
	$("#id_persona_alumno").val("");
	$("#nombre_act").val("");
	$("#ubicacion").val("");
	$("#fecha_inicio").val("");
	$("#fecha_final").val("");
	$("#descripcion").val("");
	$("#observaciones").val("");
	$("#horas_voae").val("");
	$("#ambito").val("");
	$("#periodo").val("");

	$("#id_alumno").val("");
	$("#id_actividad").val("");
	$("#horas_alumno").val("");
	
}
*/




//Función cancelarform
function cancelarform()
{
    
	window.location = "../vistas/menu_actividades_cve_vista.php"
}
 




init();


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
function limpiar()
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

//Función mostrar formulario
function mostrarform(flag)
{
	limpiar();
	if (flag)
	{
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#formularioregistros2").hide();
		$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
		$("#btnagregarhoras").hide();
		$("#btnact").hide();
	}
	else
	{
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#formularioregistros2").hide();
		$("#btnagregar").show();
		$("#btnagregarhoras").show();
		$("#btnact").show();
	}
}
function mostrarform2(flag)
{
	limpiar();
	if (flag)
	{
		$("#listadoregistros").hide();
		$("#formularioregistros2").show();
		$("#btnGuardar2").prop("disabled",false);
		$("#btnagregar").hide();
		$("#btnagregarhoras").hide();
		$("#btnact").hide();
	}
	else
	{
		$("#listadoregistros").show();
		$("#formularioregistros2").hide();
		$("#btnagregar").show();
		$("#btnagregarhoras").show();
		$("#btnact").show();
	}
}



//Función cancelarform
function cancelarform()
{
	limpiar();
	window.location = "../vistas/menu_actividades_cve_vista.php"
}
 



//Función para guardar o editar

function guardaryeditar(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../Controlador/horas_voae_controlador.php?op=guardaryeditar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {     
	                   
	       swal({
		
		        title: datos,
				text:" ",
				icon: "success",
				buttons: false,
				dangerMode: false,
				timer: 3000,
			});
             mostrarform(false);
             tabla.ajax.reload(window.location = "../vistas/horas_voae_cve_vista.php");
			
	    }

	});
	limpiar();
}
function insertar_horas(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar2").prop("disabled",true);
	var formData = new FormData($("#formulario2")[0]);

	$.ajax({
		url: "../Controlador/horas_voae_controlador.php?op=insertar_horas",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {     
	                   
	       swal({
		
		        title: datos,
				text:" ",
				icon: "success",
				buttons: false,
				dangerMode: false,
				timer: 3000,

			});
             mostrarform2(false);
             tabla.ajax.reload();
			
	    }

	});
	limpiar();
}


init();


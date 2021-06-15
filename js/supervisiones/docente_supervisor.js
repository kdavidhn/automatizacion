var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();

	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);
	})
}

//Función limpiar
function limpiar()
{
	$("#codigo").val("");
	$("#asignatura").val("");
	$("#uv").val("");
	$("#año").val("");
	$("#calificacion").val("");
	$("#obs").val("");
}





//Función Listar
function listar()
{
	$('#tbllistado').DataTable({
		"language": {
	"sProcessing":    "Procesando...",
	"sLengthMenu":    "Mostrar _MENU_ registros",
	"sZeroRecords":   "No se encontraron resultados",
	"sEmptyTable":    "Ningún dato disponible en esta tabla",
	"sInfo":          "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
	"sInfoEmpty":     "Mostrando registros del 0 al 0 de un total de 0 registros",
	"sInfoFiltered":  "(filtrado de un total de _MAX_ registros)",
	"sInfoPostFix":   "",
	"sSearch":        "Buscar:",
	"sUrl":           "",
	"sInfoThousands":  ",",
	"sLoadingRecords": "Cargando...",
	"oPaginate": {
		"sFirst":    "Primero",
		"sLast":    "Último",
		"sNext":    "Siguiente",
		"sPrevious": "Anterior"
	},
	"oAria": {
		"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
		"sSortDescending": ": Activar para ordenar la columna de manera descendente"
	}
},
		"ajax":
				  {     
				url: '../Controlador/asignar_docente_supervisor_controlador.php?op=listar',
				type : "get",
				dataType : "json",
				error: function(e)
				{
				  console.log(e.responseText);
				}
		  }
	  });
}
//Función para guardar o editar

function editar()
{
	
	
    
    var datos = $("#formulario").serialize();
	
	$.ajax({
		url: "../Controlador/asignar_docente_supervisor_controlador.php?op=editar",
	    type: "POST",
	    data: datos,
	    

	    success: function(d)
	    {
            
	    	swal({
				  title: d,

				  icon: "success",
				  button: "OK",
				  
				}).then(function() {
					window.location = "../vistas/gestion_docente_supervisor_vista.php";
				});
				

		}
		

	});
	
	//limpiar();
}
function redirigir(idclase){
	
}
function mostrar(id_supervisor)
{
	
	
	$.post("../Controlador/asignar_docente_supervisor_controlador.php?op=mostrar",{id_supervisor : id_supervisor}, function(data, status)
	{
		
		data = JSON.parse(data);
		console.log(data);
		//mostrarform(true);

		$("#id_supervisor").val(data.id_persona);
		$("#docente").val(data.nombre);
	
		console.log(data.id_persona);

	
	 })
	
//	
	
}

//Función para desactivar registros
function desactivar(idclase)
{
	console.log(' funcion activo');
	bootbox.confirm("¿Está Seguro de desactivar la Asignatura?", function(result){
		if(result)
        {
        	$.post("../Controlador/crear_asignatura_controlador.php?op=desactivar", {id_asignatura : idclase}, function(e){
        		swal({
				  title: e,

				  icon: "success",
				  button: "OK",
				}).then(function() {
					window.location = "../vistas/gestion_asignaturas_vista.php";
				});

	            
        	});
        }
	})
}

//Función para activar registros
function activar(idclase)
{
	
	bootbox.confirm("¿Está Seguro de activar la Asignatura?", function(result){
		if(result)
        {
        	$.post("../Controlador/crear_asignatura_controlador.php?op=activar", {id_asignatura : idclase}, function(e){
        		swal({
				  title: e,

				  icon: "success",
				  button: "OK",
				}).then(function() {
					window.location = "../vistas/gestion_asignaturas_vista.php";
				});
        	});
        }
	})
}



listar();

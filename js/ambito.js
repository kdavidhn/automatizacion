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
	$("#nombre_ambito").val("");
	$("#descripcion_ambito").val("");
	$("#id_ambito").val("");
}

//Función mostrar formulario
function mostrarform(flag)
{
	limpiar();
	if (flag)
	{
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
	}
	else
	{
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
	}
}

//Función cancelarform
function cancelarform()
{
	limpiar();
	mostrarform(false);
}

//Función Listar
function listar()
{
	tabla=$('#tbllistado').dataTable(
	{
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
	    buttons: [		          
		            'copyHtml5',
		            'excelHtml5',
		            'csvHtml5',
		            'pdf'
		        ],
		"ajax":
				{
					url: '../Controlador/ambito_controlador.php?op=listar',
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"iDisplayLength": 5,//Paginación
	    "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();
}
//Función para guardar o editar

function guardaryeditar(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../Controlador/ambito_controlador.php?op=guardaryeditar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {     
	                   
	       swal({
		
		        title: datos,
				text:" ",
				icon: "info",
				buttons: false,
				dangerMode: false,
				timer: 3000,
			});
             mostrarform(false);
             tabla.ajax.reload();
			
	    }

	});
	limpiar();
}

function mostrar(id_ambito)
{
	$.post("../Controlador/ambito_controlador.php?op=mostrar",{id_ambito : id_ambito}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

		$("#nombre_ambito").val(data.nombre_ambito);
		$("#descripcion_ambito").val(data.descripcion_ambito);
 		$("#id_ambito").val(data.id_ambito);

 	})
}

//Función para desactivar registros
function desactivar(id_ambito)
{
	swal({
		
        title: "Alerta",
		text:
			"¿Está seguro de desactivar el ambito?",
		icon: "warning",
		buttons: true,
		dangerMode: false,
	}).then((result) => {
		if (result) {
			
		 	$.post("../Controlador/ambito_controlador.php?op=desactivar", {id_ambito : id_ambito}, function(e){
        		swal({
		
		        title: e,
				text:" ",
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

//Función para activar registros
function activar(id_ambito)
{
	swal({
		title: "Alerta",
		text:
			"¿Está seguro de activar el ambito?",
		icon: "warning",
		buttons: true,
		dangerMode: false,
	}).then((result) => {
		if (result) {
			
		 	$.post("../Controlador/ambito_controlador.php?op=activar", {id_ambito : id_ambito}, function(e){
        		swal({
		
		        title: e,
				text:" ",
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

function eliminar(id_ambito)
{
	swal({
		title: "Alerta",
		text:
			"¿Está seguro de eliminar el ambito?",
		icon: "warning",
		buttons: true,
		dangerMode: false,
	}).then((result) => {
		if (result) {
			
		 	$.post("../Controlador/ambito_controlador.php?op=eliminar", {id_ambito : id_ambito}, function(e){
        		swal({
		
		        title: e,
				text:" ",
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


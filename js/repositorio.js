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
	$("#nombre_repositorio").val("");
	$("#descripcion_repositorio").val("");
	$("#id_repositorio").val("");
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
					url: '../Controlador/repositorio_controlador.php?op=listar',
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
		url: "../Controlador/repositorio_controlador.php?op=guardaryeditar",
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

function mostrar(id_repositorio)
{
	$.post("../Controlador/repositorio_controlador.php?op=mostrar",{id_repositorio : id_repositorio}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

		$("#nombre_repositorio").val(data.nombre_repositorio);
		$("#descripcion_repositorio").val(data.descripcion_repositorio);
 		$("#id_repositorio").val(data.id_repositorio);

 	})
}

//Función para desactivar registros
function desactivar(id_repositorio)
{
	swal({
		
        title: "Alerta",
		text:
			"¿Está seguro de desactivar el repositorio?",
		icon: "warning",
		buttons: true,
		dangerMode: false,
	}).then((result) => {
		if (result) {
			
		 	$.post("../Controlador/repositorio_controlador.php?op=desactivar", {id_repositorio : id_repositorio}, function(e){
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
function activar(id_repositorio)
{
	swal({
		title: "Alerta",
		text:
			"¿Está seguro de activar el repositorio?",
		icon: "warning",
		buttons: true,
		dangerMode: false,
	}).then((result) => {
		if (result) {
			
		 	$.post("../Controlador/repositorio_controlador.php?op=activar", {id_repositorio : id_repositorio}, function(e){
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


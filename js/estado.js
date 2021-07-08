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
	$("#nombre_estado").val("");
	$("#descripcion_estado").val("");
	$("#id_estado").val("");
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
					url: '../Controlador/estado_controlador.php?op=listar',
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
		url: "../Controlador/estado_controlador.php?op=guardaryeditar",
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

function mostrar(id_estado)
{
	$.post("../Controlador/estado_controlador.php?op=mostrar",{id_estado : id_estado}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

		$("#nombre_estado").val(data.nombre_estado);
		$("#descripcion_estado").val(data.descripcion_estado);
 		$("#id_estado").val(data.id_estado);

 	})
}

//Función para desactivar registros
function desactivar(id_estado)
{
	swal({
		
        title: "Alerta",
		text:
			"¿Está seguro de desactivar el estado?",
		icon: "warning",
		buttons: true,
		dangerMode: false,
	}).then((result) => {
		if (result) {
			
		 	$.post("../Controlador/estado_controlador.php?op=desactivar", {id_estado : id_estado}, function(e){
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
function activar(id_estado)
{
	swal({
		title: "Alerta",
		text:
			"¿Está seguro de activar el estado?",
		icon: "warning",
		buttons: true,
		dangerMode: false,
	}).then((result) => {
		if (result) {
			
		 	$.post("../Controlador/estado_controlador.php?op=activar", {id_estado : id_estado}, function(e){
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

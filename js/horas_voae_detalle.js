var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();

	
}



//Función mostrar formulario
function mostrarform()
{
	
	
		$("#listadoregistros").show();
		

	
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
		            
		            'excelHtml5',
		            
		            'pdf'
		        ],
		"ajax":
				{
					url: '../Controlador/historial_alumno_cve_controlador.php?op=listar2',
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




function eliminar(id_asistencia)
{
	swal({
		title: "Alerta",
		text:
			"¿Está seguro de eliminar la actividad?",
		icon: "warning",
		buttons: true,
		dangerMode: false,
	}).then((result) => {
		if (result) {
			
		 	$.post("../Controlador/horas_voae_controlador.php?op=eliminar", {id_asistencia : id_asistencia}, function(e){
        		swal({
		
		        title: e,
				text:" ",
				icon: "success",
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


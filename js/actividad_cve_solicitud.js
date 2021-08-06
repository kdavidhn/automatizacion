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
		$("#no_solicitud").val("");
		$("#nombre_actividad").val("");
 		$("#ubicacion").val("");
 		$("#fch_inicial_actividad").val("");
		$("#fch_final_actividad").val("");
 		$("#descripcion").val("");
 		$("#poblacion_objetivo").val("");
		$("#presupuesto").val("");
		$("#staff_alumnos").val("");
		$("#observaciones").val("");
		$("#id_ambito").val("");
		$("#periodo").val("");
 		$("#id_actividad_voae").val("");
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
	$('.form-control').prop( "disabled", false );
	
}

//Función Listar
function listar()
{   
	tabla=$('#tbllistado').dataTable(
	{
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
	    buttons: [		          
		            'copyHtml5',
		            'excelHtml5',
		            'csvHtml5',
		            'pdf'
		        ],
		"ajax":
				{
					url: '../Controlador/actividad_cve_controlador_solicitud.php?op=listar',
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		lengthMenu: [[5, 25, 50, 100, -1], [5, 25, 50, 100, 'All']],
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
		url: "../Controlador/actividad_cve_controlador_solicitud.php?op=guardaryeditar",
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
             tabla.ajax.reload();
			
	    }

	});
	limpiar();
}

function mostrar(id_actividad_voae, tipo=0)
{
	$('.form-control').prop( "disabled", false );
	$('#btnGuardar').show();
	if (tipo==1) {
		$('.form-control').prop( "disabled", true );
		$('#btnGuardar').hide();
	
	}

	$.post("../Controlador/actividad_cve_controlador_solicitud.php?op=mostrar",{id_actividad_voae : id_actividad_voae}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

		$("#no_solicitud").val(data.no_solicitud);
		$("#nombre_actividad").val(data.nombre_actividad);
 		$("#ubicacion").val(data.ubicacion);
 		$("#fch_inicial_actividad").val(data.fch_inicial_actividad);
		$("#fch_final_actividad").val(data.fch_final_actividad);
 		$("#descripcion").val(data.descripcion);
 		$("#poblacion_objetivo").val(data.poblacion_objetivo);
		$("#presupuesto").val(data.presupuesto);
		$("#staff_alumnos").val(data.staff_alumnos);
		$("#observaciones").val(data.observaciones);
		$("#id_ambito").val(data.id_ambito);
		$("#periodo").val(data.periodo);
 		$("#id_actividad_voae").val(data.id_actividad_voae);

 	})
}


function solicitado(id_actividad_voae)

{
	swal({
		
        title: "Alerta",
		text:
			"¿Está seguro de Enviar esta Actividad para Aprobacion?",
		icon: "warning",
		buttons: true,
		dangerMode: false,
	}).then((result) => {
		if (result) {
			
		 	$.post("../Controlador/actividad_cve_controlador_solicitud.php?op=solicitado", {id_actividad_voae : id_actividad_voae}, function(e){
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


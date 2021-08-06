var hoy = new Date();
fecha = hoy.getDate() + '-' + ( hoy.getMonth() + 1 ) + '-' + hoy.getFullYear();
hora = hoy.getHours() + ':' + hoy.getMinutes() + ':' + hoy.getSeconds();
fechaYHora = fecha + ' ' + hora;

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
	    buttons: [],
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
    lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']],
    "iDisplayLength": 10,//Paginación
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


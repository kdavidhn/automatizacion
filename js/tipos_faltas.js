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
  $("#nombre_falta").val("");
  $("#descripcion_falta").val("");
  $("#id_falta").val("");
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
          url: '../Controlador/tipos_faltas_controlador.php?op=listar',
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
//Función para guardar o editar

function guardaryeditar(e)
{
  e.preventDefault(); //No se activará la acción predeterminada del evento
  $("#btnGuardar").prop("disabled",true);
  var formData = new FormData($("#formulario")[0]);

  $.ajax({
    url: "../Controlador/tipos_faltas_controlador.php?op=guardaryeditar",
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

function mostrar(id_falta)
{
  $.post("../Controlador/tipos_faltas_controlador.php?op=mostrar",{id_falta : id_falta}, function(data, status)
  {
    data = JSON.parse(data);    
    mostrarform(true);

    $("#nombre_falta").val(data.nombre_falta);
    $("#descripcion_falta").val(data.descripcion_falta);
    $("#id_falta").val(data.id_falta);

  })
}

//Función para desactivar registros
function desactivar(id_falta)
{
  swal({
    
        title: "Alerta",
    text:
      "¿Está seguro de desactivar la falta?",
    icon: "warning",
    buttons: true,
    dangerMode: false,
  }).then((result) => {
    if (result) {
      
      $.post("../Controlador/tipos_faltas_controlador.php?op=desactivar", {id_falta : id_falta}, function(e){
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
function activar(id_falta)
{
  swal({
    
        title: "Alerta",
    text:
      "¿Está seguro de activar la falta?",
    icon: "warning",
    buttons: true,
    dangerMode: false,
  }).then((result) => {
    if (result) {
      
      $.post("../Controlador/tipos_faltas_controlador.php?op=activar", {id_falta : id_falta}, function(e){
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

function eliminar(id_falta)
{
  swal({
    
        title: "Alerta",
    text:
      "¿Está seguro de eliminar la falta?",
    icon: "warning",
    buttons: true,
    dangerMode: false,
  }).then((result) => {
    if (result) {
      
      $.post("../Controlador/tipos_faltas_controlador.php?op=eliminar", {id_falta : id_falta}, function(e){
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


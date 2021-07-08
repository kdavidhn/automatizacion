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
  $("#id_falta").val("");
  $("#id_tipo_falta").val("");
  $("#fch_falta").val("");
  $("#id_persona_alumno").val("");
  $("#descripcion").val("");
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
          url: '../Controlador/registro_faltas_controlador.php?op=listar',
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
    url: "../Controlador/registro_faltas_controlador.php?op=guardaryeditar",
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
  $.post("../Controlador/registro_faltas_controlador.php?op=mostrar",{id_falta : id_falta}, function(data, status)
  {
    data = JSON.parse(data);    
    mostrarform(true);

    $("#id_falta").val(data.id_falta);
    $("#id_tipo_falta").val(data.id_tipo_falta);
    $("#fch_falta").val(data.fch_falta);
    $("#id_persona_alumno").val(data.id_persona_alumno);
    $("#descripcion").val(data.descripcion);

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
      
      $.post("../Controlador/registro_faltas_controlador.php?op=eliminar", {id_falta : id_falta}, function(e){
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

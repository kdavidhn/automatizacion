$(document).ready(function(){ 
    
    $('#btnEnviar').on('click',function(){
        
var url = "../Controlador/calculo_fecha_pps_controlador.php?op=fecha";
$.ajax({                        
   type: "POST",                 
   url: url,                     
   data: $("#formulario").serialize(), 
   success: function(data)             
   {
    $('#fecha_finalizacion').val(data);
 
   }
});
});
});
$(document).ready(function(){ 
    
    $('#btn_aprobacion_rechazo_practica').on('click',function(){
        
var url = "../Controlador/calculo_fecha_pps_controlador.php?op=update";
$.ajax({                        
   type: "POST",                 
   url: url,                     
   data: $("#formulario").serialize(), 
   success: function(data)             
   {
       if(data==0)
       {
        swal({
            title: 'Práctica aprobada con éxito',
            type: "success",
            button: "OK",
          }).then(function() {
            location.href = '../vistas/aprobar_practica_coordinacion_vista.php';
        }); 
       }
       else if(data==1)
       {
        swal({
            title: 'Práctica no se pudo aprobar',
            type: "error",
            button: "OK",
          }).then(function() {
            location.href = '../vistas/aprobar_practica_coordinacion_vista.php';
        }); 
       }
        
 
   }
});
});
});


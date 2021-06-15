
//Funcion que llena el modal de los horarios
function agregaform_u(datos){

	d=datos.split('||');

	$('#idhorario').val(d[0]);
	$('#fecha').val(d[1]);
	$('#horario').val(d[2]);
	$('#jornada').val(d[3]);
	$('#cupos').val(d[4]);
	
	
}
//funcion que actualiza los datos de los roles
function actualizaDatos_r() {

    idhorario = $('#idhorario').val( );
    fecha = $('#fecha').val( );
    horario = $('#horario').val( );
    cupos = $('#cupos').val();

   

   cadena = "idhorario=" + idhorario +
            "&fecha=" + fecha +
            "&horario=" + horario +
            "&cupos=" + cupos;



   $.ajax({
       type: "POST",
       url: "../Modelos/horario_himno_modelo.php",
       data: cadena,
       
       success: function(r) {

        if (r == 1) {
            $('#tabla').load('../Controlador/horario_himno_controlador.php');
            alertify.success("Actualizado con exito ");
        } else {
            alertify.error("Fallo el servidor ");
        }
    }
   });
  
}


$(document).ready(function() {

    //alert('Texto a mostrar');
    //$('#controlBuscador').select2();
    $('#alertaModal1').hide();
    $('#alertaModal2').hide();
    $('#alertaModal3').hide();
    $('#alertaModal4').hide();
    $('#actualizadatos').attr("disabled", false);


    $("#form").keypress(function(e) {
        if (e.which == 13) {
            return false;
        }
    });


    //Validaciones fecha
    $('#fecha').focusout(function() {
        var fecha;
        fecha = $('#fecha').val();
        console.log(fecha);
        if (fecha.length == 0) {
            $('#actualizadatos').attr("disabled", true);
            $('#alertaModal1').show();
            $('#alertaModal1').html("El campo  fecha debe llenarse");

        } else {
            $('#alertaModal1').hide();
            $('#alertaModal1').html("");
            $('#actualizadatos').attr("disabled", false);
        }
    });
    //Validaciones horario
    $('#horario').focusout(function() {
        var horario;
        horario = $('#horario').val();
        console.log(fecha);
        if (horario.length == 0) {
            $('#actualizadatos').attr("disabled", true);
            $('#alertaModal2').show();
            $('#alertaModal2').html("El campo  horario debe llenarse");

        } else {
            $('#alertaModal2').hide();
            $('#alertaModal2').html("");
            $('#actualizadatos').attr("disabled", false);
        }
    });
    //Validaciones jornada
    $('#jornada').focusout(function() {
        var jornada;
        jornada = $('#jornada').val();
        console.log(fecha);
        if (jornada.length == 0) {
            $('#actualizadatos').attr("disabled", true);
            $('#alertaModal3').show();
            $('#alertaModal3').html("El campo  jornada debe llenarse");

        } else {
            $('#alertaModal3').hide();
            $('#alertaModal3').html("");
            $('#actualizadatos').attr("disabled", false);
        }
    });
    //Validaciones cupos
    $('#cupos').focusout(function() {
        var cupos;
        cupos = $('#cupos').val();
        
        if (cupos.length == 0) {
            $('#actualizadatos').attr("disabled", true);
            $('#alertaModal4').show();
            $('#alertaModal4').html("El campo cupos debe llenarse");

        } else {
            $('#alertaModal4').hide();
            $('#alertaModal4').html("");
            $('#actualizadatos').attr("disabled", false);
        }
    });
    




});


function sonLetrasSolamente(texto) {
    var regex = /^[a-zA-Z]+$/;
    return regex.test(texto);
}

function sonNumerosSolamente(texto) {
    var regex = /^[0-9]+$/;
    return regex.test(texto);
}

function sonLetrasMayYnumerosSolamente(texto) {
    var regex = /^[A-Z][0-9]+$/;
    return regex.test(texto);
}

function EsUnCorreo(texto) {
    var regex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
    return regex.test(texto);
}

function EsUnPassword(texto) {
    var regex = /^(?=.*[a-zA-Z])(?=.*\d)(?=.*[!@#$%^&*()_+])[A-Za-z\d!@#$%^&*()_+]{8,20}$/i;
    return regex.test(texto);
}







console.log('horario himno');

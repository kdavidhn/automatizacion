function llenar_tipo_plan() {
  var cadena = "&activar=activar";
  $.ajax({
    url: "../Controlador/plan_estudio_controlador.php?op=tipo_plan",
    type: "POST",
    data: cadena,
    success: function (r) {
      $("#cbm_tipo_plan").html(r).fadeIn();
      var o = new Option("SELECCIONAR", 0);

      $("#cbm_tipo_plan").append(o);
      $("#cbm_tipo_plan").val(0);
    },
  });
}
llenar_tipo_plan();



//para guardar el plan nuevo
function crear_plan_estudio() {
  bloquea();
   var cbm_tipo_plan = $("#cbm_tipo_plan").val();
   var txt_nombre = $("#txt_nombre").val();
  var txt_num_clases = $("#txt_num_clases").val();
  var txt_codigo_plan = $("#txt_codigo_plan").val();
  var cbm_tipo_plan = $("#cbm_tipo_plan").children("option:selected").val();
  var fecha = $("#fechacreacion").val();
   var nombre_usuario = $("#id_sesion").val();
    
  var checkbox = document.getElementsByName('check[]');
  var contador = 0;
  
  for(var i=0; i< checkbox.length; i++) {
        if(checkbox[i].checked)
            contador++
    }

  var opcion_check = $("#sino").val();
  
 // console.log(seleccion_cbm_tipo_plan);

  if (
    cbm_tipo_plan == null ||
    txt_nombre.length == 0 ||
    txt_num_clases.length == 0 ||
    txt_codigo_plan.length == 0 ||
    cbm_tipo_plan == 0 ||
    fecha.length ==0
  ) {
    swal({
      title: "alerta",
      text: "Llene o seleccione los campos vacios correctamente",
      type: "warning",
      showConfirmButton: true,
      timer: 15000,
    });
  } else if (contador == 0) {
    alert("seleccione un check de plan vigente");
    
  } else {
    // var opcion_check = $("#sino").val();

    if (opcion_check == "SI") {

    
      //console.log(opcion_check);
      $.post(
        "../Controlador/plan_estudio_controlador.php?op=verificarPlan",
        {
          plan_vigente: opcion_check,
        },

        function (data, status) {
          console.log(data);
          data = JSON.parse(data);
          
          if (data.registro > 0) {
            alert("Ya existe un plan actual Vigente");
            
          }
        }
      );
    } else {

       $.post(
         "../Controlador/plan_estudio_controlador.php?op=verificarPlanNombre",
         {
           nombre: txt_nombre
         },

         function (data, status) {
           console.log(data);
           data = JSON.parse(data);

           if (data.registro > 0) {
             alert("Ya existe un plan con el mismo nombre");

           } else {
             
              $.ajax({
                url: "../Controlador/crear_plan_estudio_controlador.php",
                type: "POST",
                data: {
                  // cod_asig: ,
                  nombre: txt_nombre,
                  num_clases: txt_num_clases,
                  fecha_creacion: fecha,
                  codigo_plan: txt_codigo_plan,
                  plan_vigente: opcion_check,
                  id_tipo_plan: cbm_tipo_plan,
                  creado_por: nombre_usuario
                 
                },
              }).done(function (resp) {
                if (resp > 0) {
                 
                  swal(
                    "Buen trabajo!",
                    "Los datos se insertaron correctamente!",
                    "success"
                  );
                  document.getElementById("sino").value = "";
                  document.getElementById("txt_nombre").value = "";
                  document.getElementById("txt_num_clases").value = "";
                  document.getElementById("txt_codigo_plan").value = "";
                  document.getElementById("SI").checked = false;
                  document.getElementById("NO").checked = false;
                  
                  
                  
                } else {
                  swal(
                    "Alerta!",
                    "No se pudo insertar los datos, intente de nuevo",
                    "warning"
                  );
                 // document.getElementById("sino").value = "";
                }
              });
             
           }

         }
       );

  

      
    }
    
   
  }
}



$(document).ready(function () {
  $('[name="check[]"]').click(function () {
    var arr = $('[name="check[]"]:checked')
      .map(function () {
        return this.value;
      })
      .get();

    $("#arr").text(JSON.stringify(arr));

    $("#sino").val(arr);

   // console.log(str);
  });
});

//para bloquear el boton al dar guardar clcik
var boton = document.getElementById("guardar");
boton.addEventListener("click", bloquea, false);

function bloquea() {
  if (boton.disabled == false) {
    boton.disabled = true;

    setTimeout(function () {
      boton.disabled = false;
    }, 6000);
  }
}
//FECHA MAXIMA HOY
let today = new Date();
let dd = today.getDate();
let mm = today.getMonth() + 1; //January is 0!
let yyyy = today.getFullYear();
if (dd < 10) {
	dd = '0' + dd;
}
if (mm < 10) {
	mm = '0' + mm;
}

today = yyyy + '-' + mm + '-' + dd;

let minimum = '1990-01-01';

let search_date = document.getElementById("fechacreacion");

search_date.max = today;
search_date.min = minimum;


window.onload = function () {
  var fecha = new Date(); //Fecha actual
  var mes = fecha.getMonth() + 1; //obteniendo mes
  var dia = fecha.getDate(); //obteniendo dia
  var ano = fecha.getFullYear(); //obteniendo año
  if (dia < 10) dia = "0" + dia; //agrega cero si el menor de 10
  if (mes < 10) mes = "0" + mes; //agrega cero si el menor de 10
  document.getElementById("fechacreacion").value = ano + "-" + mes + "-" + dia;
};

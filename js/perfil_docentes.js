$(document).ready(function () {
  var pulsado = false;

  $("input")
    .keydown(function () {
      if (pulsado) return false;
      pulsado = true;
    })

    .keyup(function () {
      pulsado = false;
    });

  seleccionar();

  $("#add1").click(function () {
    let i = ContarTel();

    if (i >= 3) {
      alert("Número máximo de teléfonos es de 3");
      return false;
    } else {
      i++;
    }
    console.log(i);
  });

  $("#add_correo1").click(function () {
    let j = ContarCorreo();

    if (j >= 2) {
      alert("Número máximo de correos es de 2");
      return false;
    } else {
      j++;
    }
  });

  function eliminar() {
    let i = ContarTel();

    swal({
      title: "Estas seguro?",
      text: "¿Desea Eliminar el Número de teléfono del docente?",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    }).then((willDelete) => {
      if (willDelete) {
        var id = $(this).attr("id");
        var eliminar_tel = document.getElementById("tel1" + id).value;
        console.log(eliminar_tel);
        $("#row" + id).remove();
        console.log(id);
        $.post(
          "../Controlador/perfil_docente_controlador.php?op=EliminarTelefono",
          { eliminar_tel: eliminar_tel },
          function (e) {}
        );
        i--;
     
      }
    });
  }

  function eliminarCorreo() {
    let i = ContarCorreo();

    swal({
      title: "Estas seguro?",
      text: "¿Desea Eliminar el correo del docente?",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    }).then((willDelete) => {
      if (willDelete) {
       
        var id = $(this).attr("id");
        var eliminar_correo = document.getElementById("correo" + id).value;
        console.log(eliminar_correo);
        $("#row2" + id).remove();
        console.log(id);
        $.post(
          "../Controlador/perfil_docente_controlador.php?op=EliminarCorreo",
          { eliminar_correo: eliminar_correo },
          function (e) {}
        );
        i--;
     
      }
    });
  }
  function AgregarTel() {
    var id = $(this).attr("id");
  }

  $(document).on("click", ".btn_remove", eliminar);
  $(document).on("click", ".btn_eliminar_correo", eliminarCorreo);
  // $(document).on("click", ".btn_add", AgregarTel);
  $(document).on("click", ".btn_foto", imagen);
  $(document).on("click", ".btn_curriculum", Registrarcurriculum);

  TraerDatos();
});

/*Guardar informacion editada
----------------------------------------------------------------------
*/
function EditarPerfil(nombre, apellido, identidad, nacionalidad, estado) {
  var n = identidad.search("_");
  var id_persona = $("#id_persona").val();
  var nombre = $("#Nombre").val();
  var apellido = $("#txt_apellido").val();
  var identidad = $("#identidad").val();
  var nacionalidad = $("#nacionalidad").val();
  var estado_civil = $("#ver_estado").val();
  var genero = $("#ver_genero").val();

  if (
    nombre == "" ||
    apellido == "" ||
    nacionalidad == "" ||
    estado_civil == "" ||
    genero == ""
  ) {
    swal({
      title: "Campos Vacios!",
      text: "Tiene campos en blanco",
      type: "warning",
      showConfirmButton: true,
      timer: 10000,
    });
  } else {
    $.post(
      "../Controlador/perfil_docente_controlador.php?op=EditarPerfil",
      {
        Nombre: nombre,
        apellido: apellido,
        identidad: identidad,
        id_persona: id_persona,
        nacionalidad: nacionalidad,
        estado_civil: estado_civil,
        sexo: genero,
      },
      function (e) {}
    );
    swal({
      title: "Actualizado!",
      text: "Datos actualizados correctamente",
      type: "success",
      showConfirmButton: true,
      timer: 10000,
    });
    window.location = "../vistas/perfil_docentes_vista.php";
  }
}

//Convertir inputs a Mayusculas
function Mayuscula(text) {
  var control = document.getElementById(text);
  control.value = control.value.toUpperCase();
}

//Funcion para ingresar grados y especialidades academicas
function AgregarEspecialidad(grado, especialidad) {
  var id_persona = $("#id_persona").val();
  $.post(
    "../Controlador/perfil_docente_controlador.php?op=AgregarEpecialidad",
    { grado: grado, especialidad: especialidad, id_persona: id_persona },
    function (e) {
      swal(
        "Buen trabajo!",
        "se agrego correctamente, asegurate de actualizar tu curriculum",
        "success"
      );

      limpiartext();
      especialidad();
    }
  );
}

function limpiartext() {
  document.getElementById("especialidad").value = "";
}

//Funcion para ingresar grados y especialidades academicas
function AgregarTelefono(telefono) {
  var n = telefono.search("_");
  var id_persona = $("#id_persona").val();

  if (n != -1 || telefono.length == 0) {
    alert("Favor Completar el campo de identidad");
  } else {
    $.post(
      "../Controlador/perfil_docente_controlador.php?op=AgregarTelefono",
      { telefono: telefono, id_persona: id_persona },
      function (e) {}
    );
  }
}

//Cargar y asignar datos a los inputs
function TraerDatos() {
  var id_persona = $("#id_persona").val();
  j = ContarTel();
  k = ContarCorreo();

  $.post(
    "../Controlador/perfil_docente_controlador.php?op=CargarDatos",
    { id_persona: id_persona },
    function (data, status) {
      //console.log(data);
      data = JSON.parse(data);
      console.log(data);
      for (var i = 0; i < data.all.length; ++i) {
        if (data["all"][i].sexo == "M") {
          $("#genero").val(1);
        } else {
          $("#genero").val(2);
        }

        if (data["all"][i].estado_civil == "SOLTERO") {
          $("#estado").val(2);
        } else {
          $("#estado").val(1);
        }

        if (data["all"][i].descripcion == "CORREO") {
          k = ContarCorreo();
          let m = 1 + i;

          $("#tbDataCorreo1").append(
            '<tr id="row2' +
              m +
              '">' +
              '<td id="celda2' +
              m +
              '"><input maxlength="9"  id="correo' +
              m +
              '"  type="correo" name="correo" class="form-control name_list" value="' +
              data["all"][i].valor +
              '"/></td>' +
              '<td><button type="button" name="eliminar_correo" id="' +
              m +
              '" class="btn btn-danger btn_eliminar_correo">X</button></td>' +
              "</tr>"
          );
        } else {
          j = ContarTel();

          let n = 1 + i;

          $("#tbData2").append(
            '<tr id="row' +
              n +
              '">' +
              '<td id="celda' +
              n +
              '"><input maxlength="9"    onkeyup="javascript:mascara()" id="tel1' +
              n +
              '"  type="tel1" name="tel1" class="form-control name_list" value="' +
              data["all"][i].valor +
              '" placeholder="___-___"/></td>' +
              '<td><button type="button" name="remove" id="' +
              n +
              '" class="btn btn-danger btn_remove">X</button></td>' +
              "</tr>"
          );
        }

        // if (data["all"][i].descripcion == "TELEFONO CELULAR") {
        //   // $("#telefono").val(data['all'][i].valor);

        // }
      }

      $("#Nombre").val(data["all"][0].nombre);
      $("#txt_apellido").val(data["all"][0].apellidos);
      $("#identidad").val(data["all"][0].identidad);
      $("#categoria").val(data["all"][0].categoria);
      $("#fecha").val(data["all"][0].fecha_nacimiento);
      $("#nacionalidad").val(data["all"][0].nacionalidad);
      $("#jornada").val(data["all"][0].jornada);
      $("#foto").attr("src", data["all"][0].foto);

      MostrarEspecialidad();
      Actividades();
      Curriculum();
      Num_Empleado();
      ver_estado();
      ver_genero();
      ver_sued();
    }
  );
}

//contar los telefonos existentes para solo permitir los requeridos

function ContarTel() {
  let inputs = document.getElementsByTagName("input");
  let cont = 0;
  for (let index = 0; index < inputs.length; index++) {
    if ($(inputs[index]).attr("type") == "tel1") {
      cont++;
    }
  }
  return cont;
}

//Guardar Formacion academioca
$("#guardarFormacion").click(function () {
  var grado = $("#id_select").children("option:selected").val();
  var grado_text = $("#id_select").children("option:selected").text();
  var txt_especialidad = $("#especialidad").val().toUpperCase();

  if (grado == "SELECCIONAR" || txt_especialidad == "") {
    alert("Debe Elegir Un grado y Su especialidad.");
  } else {
    AgregarEspecialidad(grado, txt_especialidad);
    agregarFormacion(txt_especialidad);
    $("#myModal").modal("hide");
    seleccionar();
    $("#id_select").val(0);
    $("#especialidad").val("");
    especialidad();
  }
});

//agregar formacion de forma del front-end
function agregarFormacion(valor) {
  $("#ulFormacion").append("<li>" + valor + "</li>");
}

//mostrar select de Grado
function mostrar(id_empleado_valor) {
  $.post(
    "../Controlador/perfil_docente_controlador.php?op=SelectGrado",
    { id_empleado: id_empleado_valor },
    function (data, status) {
      data = JSON.parse(data);

      $("#input1").val(data.especialidad);

      var texto = $("#id_select").children("option:selected").text();

      if (texto != "SELECCIONAR") {
        $("#select_especialidad").empty();

        for (i = 0; i < data.all.length; i++) {
          var o = new Option("option text", data["all"][i].especialidad);
          $(o).html(data["all"][i].especialidad);
          $("#select_especialidad").append(o);
        }
      } else {
        $("#select_especialidad").empty();
        seleccionar();
        $("#select_especialidad").val(0);
      }
    }
  );
}

function llenar_select1() {
  var cadena = "&activar=activar";
  $.ajax({
    url: "../Controlador/perfil_docente_controlador.php?op=select1",
    type: "POST",
    data: cadena,
    success: function (r) {
      $("#id_select").html(r).fadeIn();
      var o = new Option("SELECCIONAR", 0);

      $("#id_select").append(o);
      $("#id_select").val(0);
    },
  });
}
llenar_select1();

$("#id_select").val(0);
//Agregar valor de seleccionar
function seleccionar() {
  var e = new Option("SELECCIONAR", 0);

  $("#select_especialidad").empty();
  $("#select_especialidad").append(e);
  $("#select_especialidad").val(0);
}

//MOSTRAR ESPECIALIDADES DEL DOCENTE

function MostrarEspecialidad() {
  var id_persona = $("#id_persona").val();
  $.post(
    "../Controlador/perfil_docente_controlador.php?op=MostrarEspecialidad",
    { id_persona: id_persona },
    function (data, status) {
      data = JSON.parse(data);

      for (i = 0; i < data.all.length; i++) {
        var valor = data["all"][i].ESPECIALIDAD;
        agregarFormacion(valor);
      }
    }
  );
}

//FUNCION QUE VALIDA QUE LOS NUMEROS DE TELEFONO SEAN LOCALES
function valtel(tel) {
  var expresion3 = /(9|8|3|2)\d{3}[-]\d{4}/;
  console.log(expresion3.test(tel));
  if (expresion3.test(tel)) {
    return 1;
  } else {
    return 0;
  }
}
function limpiarTEL() {
  document.getElementById("tel1").value = "";
}
//Agregar Telefono en el front
function addTel() {
  var telefono = document.getElementById("tel1");

  j = ContarTel();
  let n = 1 + j;

  var n1 = telefono.value.search("_");

  if (n1 != -1 || telefono.value.length == 0) {
    alert("Completar El Campo Telefono Por Favor");
  } else {
    if (valtel($("#tel1").val()) == 0) {
      //aqui debo validar que no se agregue a la tabla ...

      swal("Alerta", "ingresar un número válido", "warning");

      limpiarTEL();
      return false;
    } else {
      $("#tbData2").append(
        '<tr id="row' +
          n +
          '">' +
          '<td id="celda' +
          n +
          '"><input maxlength="9"    onkeyup="javascript:mascara()" id="tel1' +
          n +
          '"  type="tel1" name="tel1" class="form-control name_list" value="' +
          telefono.value +
          '" placeholder="___-___"/></td>' +
          '<td><button type="button" name="remove" id="' +
          n +
          '" class="btn btn-danger btn_remove">X</button></td>' +
          "</tr>"
      );

      AgregarTelefono(telefono.value);
      telefono.value = "";
      $("#ModalTel").modal("hide");
      console.log(n);
    }
  }
}
function correovalido(correo1) {
  var expresion1 = /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;

  //console.log(expresion1.test(correo1));
  if (expresion1.test(correo1)) {
    return 1;
  } else {
    return 0;
  }
}

// Cambiar Imagen de Perfil
function imagen() {
  var frmData = new FormData();
  var imagen = $("#imagen").val();
  if (imagen == "") {
    document.getElementById("imagen").hidden = true;
    document.getElementById("btn_foto").hidden = true;
    document.getElementById("btn_mostrar").hidden = false;
  } else {
    frmData.append("imagen", $("input[name=imagen]")[0].files[0]);
    frmData.append("id_persona", $("#id_persona").val());

    $.ajax({
      url: "../Controlador/perfil_docente_controlador.php?op=CambiarFoto",
      type: "post",
      data: frmData,
      processData: false,
      contentType: false,
      cache: false,

      success: function (data) {
        data = JSON.parse(data);

        $("#foto").attr("src", data);
        $("#imagen").val("");
        $("#btn_mostrar").removeAttr("hidden");
        $("#imagen").attr("hidden", "hidden");
        $("#btn_foto").attr("hidden", "hidden");
      },
    });

    return false;
  }
}



//============================
//      TAMAÑO DE FOTO       =
//============================
var uploadField = document.getElementById('imagen');

uploadField.onchange = function() {
	if (this.files[0].size >5242880) {
		//alert("Archivo muy grande!");
		swal('Error', 'Archivo muy grande!', 'warning');

		this.value = '';
	}
};

//============================
//      TAMAÑO DE CURRICULUM =
//============================
 var uploadField = document.getElementById('c_vitae');

uploadField.onchange = function() {
	if (this.files[0].size > 15728640) {
		//alert("Archivo muy grande!");
		swal('Error', 'Archivo muy grande!', 'warning');

		this.value = '';
	}
}; 

//CARGAR TABLA DE ACTIVIDADES
function Actividades() {
  var id_persona = $("#id_persona").val();
  $.post(
    "../Controlador/perfil_docente_controlador.php?op=Actividades",
    { id_persona: id_persona },
    function (data, status) {
      data = JSON.parse(data);

      for (i = 0; i < data.actividades.length; ++i) {
        $("#tbl_comisiones").append(
          '<tr id="row' +
            i +
            '">' +
            "<td>" +
            (i + 1) +
            "</td>" +
            "<td>" +
            data["actividades"][i].comision +
            "</td>" +
            "<td>" +
            data["actividades"][i].actividad +
            "</td>" +
            "</tr>"
        );
      }
    }
  );
}

//CARGAR CURRICULUM
function Curriculum() {
  var id_persona = $("#id_persona").val();

  $.post(
    "../Controlador/perfil_docente_controlador.php?op=Curriculum",
    { id_persona: id_persona },
    function (data, status) {
      data = JSON.parse(data);

      $("#curriculum").attr("href", data.curriculum);
    }
  );
}

//CARGAR NUMERO DE EMPLEADO
function Num_Empleado() {
  var id_persona = $("#id_persona").val();

  $.post(
    "../Controlador/perfil_docente_controlador.php?op=Num_Empleado",
    { id_persona: id_persona },
    function (data, status) {
      data = JSON.parse(data);

      $("#empleado").val(data.valor);
    }
  );
}

//CARGAR ESTADO CIVIL
function ver_estado() {
  var id_persona = $("#id_persona").val();

  $.post(
    "../Controlador/perfil_docente_controlador.php?op=ver_estado_c",
    { id_persona: id_persona },
    function (data, status) {
      data = JSON.parse(data);

      $("#ver_estado").val(data.estado_civil).html(r).fadeIn();
    }
  );
}

//bOTONES PARA ACTUALIZAR FOTO
function MostrarBoton() {
  $("#imagen").removeAttr("hidden");
  $("#btn_foto").removeAttr("hidden");
  $("#btn_mostrar").attr("hidden", "hidden");
}

function ValidarIdentidad(identidad) {
  //console.log(n);
  var n = identidad.search("_");
  console.log(n);
  var mayor_edad = $("#mayoria_edad").val();
  var depto = identidad.substring(0, 4);
  var contar = depto;

  console.log(contar);

  if (n == 5) {
    var ver = false;
    $.post(
      "../Controlador/perfil_docente_controlador.php?op=validar_depto",
      { codigo: contar },
      function (data, status) {
        console.log(data);
        data = JSON.parse(data);
        console.log(data);
        /*si no tiene datos va copiar  */
        //$("#contar_depto").val(data.regis);

        if (data.regis == 0) {
          var ver = true;

          if (ver == true) {
            swal(
              "Datos incorrectos",
              "Asegurese de Introducir los digitos correspondientes a su departamento y municipio",
              "warning"
            );
            $("#contar_depto").val("");
            $("#identidad").val("");
            $("#identidad").attr("placeholder", "____-____-_____");
          }
        }
      }
    );
  }

  if (n == 10) {
    var currentTime = new Date();
    var year = currentTime.getFullYear();
    var anio = identidad.substring(5, 9);
    //console.log(year-anio);
    if (year - anio < mayor_edad) {
      //swal("Aviso", "Debe ser mayor de edad", "warning");
      $("#Textomayor").removeAttr("hidden");
      //$("#identidad").val("");
      //$("#identidad").attr("placeholder", "____-____-_____");
    } else {
      $("#Textomayor").attr("hidden", "hidden");
    }

    if (anio == "0000") {
      swal("Aviso", "Año invalido", "warning");
      $("#identidad").val("");
      $("#identidad").attr("placeholder", "____-____-_____");
    } else {
    }
  }

  if (n == -1) {
    var ultimo = identidad.substring(10, 15);
    // console.log(anio);
    if (ultimo == "00000") {
      swal("Aviso", "no se permiten 5 ceros", "warning");
      $("#identidad").val("");
      $("#identidad").attr("placeholder", "____-____-_____");
    } else {
    }
  }
}

$(document).ready(function () {
  $.post(
    "../Controlador/perfil_docente_controlador.php?op=mayoria_edad",
    function (data) {
      data = JSON.parse(data);
      // console.log(data);
      $("#mayoria_edad").val(data.valor);
    }
  );
});
$(function () {
  $("#fecha").on("change", calcularEdad);
});

function calcularEdad() {
  fecha = $(this).val();
  var hoy = new Date();
  var cumpleanos = new Date(fecha);
  var edad = hoy.getFullYear() - cumpleanos.getFullYear();
  var m = hoy.getMonth() - cumpleanos.getMonth();

  if (m < 0 || (m === 0 && hoy.getDate() < cumpleanos.getDate())) {
    edad--;
  }
  $("#age").val(edad);
}

function valida_mayoria() {
  var valor = new Date();
  var mayoria = $("#mayoria_edad").val();
  var edad = document.getElementById("age").value;
  if (edad < mayoria) {
    $("#Textofecha").removeAttr("hidden");
    //alert("Debe ser mayor de edad!");
    $("#txt_fecha_nacimiento").val(valor);
  } else {
    $("#Textofecha").attr("hidden", "hidden");
  }
}

function ExisteIdentidad() {
  identidad = $("#identidad").val();

  identidad = $("#identidad").val();

  $.post(
    "../Controlador/perfil_docente_controlador.php?op=ExisteIdentidad",
    { identidad: identidad },
    function (data, status) {
      //console.log(data);
      data = JSON.parse(data);
      console.log(data);
      if (data.existe == 1) {
        $("#TextoIdentidad").removeAttr("hidden");
      } else {
        $("#TextoIdentidad").attr("hidden", "hidden");
      }
    }
  );
}

function MismaLetra(id_input) {
  var valor = $("#" + id_input).val();
  var longitud = valor.length;
  console.log(valor + longitud);
  if (longitud > 2) {
    var str1 = valor.substring(longitud - 3, longitud - 2);
    var str2 = valor.substring(longitud - 2, longitud - 1);
    var str3 = valor.substring(longitud - 1, longitud);
    nuevo_valor = valor.substring(0, longitud - 1);
    if (str1 == str2 && str1 == str3 && str2 == str3) {
      swal({
        title: "Alerta",
        text: "Letra escritas 3 veces consecutivas",
        type: "warning",
        showConfirmButton: true,
        timer: 10000,
      });
      $("#" + id_input).val(nuevo_valor);
    }
  }
}


$("#btn_editar_curri").click(function () {
  // document.getElementById('parrafo_numEmpleado').hidden = true;
  document.getElementById('parrafo_boton_editar').hidden = true;
  // document.getElementById('parrafo_curriculum').hidden = true;
  document.getElementById('parrafo_encuesta').hidden = true;
  // document.getElementById('parrafo_sued').hidden = true;
  document.getElementById('curriculum_parrafo').hidden = true;
  document.getElementById('icono_nombre').hidden = true;
  document.getElementById('icono_apellido').hidden = true;
  document.getElementById('icono_jornada').hidden = true;
  document.getElementById('icono_genero').hidden = true;
  document.getElementById('icono_identidad').hidden = true;
  document.getElementById('icono_nacionalidad').hidden = true;
  document.getElementById('icono_nacimiento').hidden = true;
  document.getElementById('icono_estado').hidden = true;
  document.getElementById('icono_categoria').hidden = true;
  // document.getElementById('boton_colapse').hidden = true;
  // document.getElementById('datos_docente').hidden = true;
  document.getElementById("titulo_1").hidden = false;
  // document.getElementById('eliminar_telefono_tabla').hidden = true;
  // document.getElementById('eliminar_correo_tabla').hidden = true;
  document.getElementById("foto_carrera").hidden = false;
  document.getElementById("fecha_actual").hidden = false;
  document.getElementById('btn_foto').hidden = true;
  document.getElementById('btn_editar').hidden = true;
  document.getElementById('btn_curriculum').hidden = true;
  document.getElementById('btn_guardar_edicion').hidden = true;
  // $('button').attr('hidden','hidden');

  window.print();
  // document.getElementById('parrafo_numEmpleado').hidden = false;
  // document.getElementById('parrafor_jornada').hidden = false;
  // document.getElementById('parrafo_boton_editar').hidden = false;
  // document.getElementById('parrafo_genero').hidden = false;
  // document.getElementById('parrafo_identidad').hidden = false;
  // document.getElementById('parrafo_nacionalidad').hidden = false;
  // document.getElementById('parrafo_categoria').hidden = false;
  // document.getElementById('parrafo_nacimiento').hidden = false;
  // document.getElementById('parrafo_estadoC').hidden = false;
  // document.getElementById('parrafo_curriculum').hidden = false;
  document.getElementById('curriculum_parrafo').hidden = false;
  // document.getElementById('parrafo_encuesta').hidden = false;
  // document.getElementById('parrafo_comisiones').hidden = false;
  // document.getElementById('parrafo_formacion').hidden = false;
  // document.getElementById('parrafo_sued').hidden = false;
  document.getElementById('icono_nombre').hidden = false;
  document.getElementById('icono_apellido').hidden = false;
  document.getElementById('icono_jornada').hidden = false;
  document.getElementById('icono_genero').hidden = false;
  document.getElementById('icono_identidad').hidden = false;
  document.getElementById('icono_nacionalidad').hidden = false;
  document.getElementById('icono_nacimiento').hidden = false;
  document.getElementById('icono_estado').hidden = false;
  document.getElementById('icono_categoria').hidden = false;
  // document.getElementById('boton_colapse').hidden = false;
  // document.getElementById('datos_docente').hidden = false;
  document.getElementById("titulo_1").hidden = true;
  // document.getElementById('eliminar_telefono_tabla').hidden = false;
  // document.getElementById('eliminar_correo_tabla').hidden = false;
  document.getElementById("foto_carrera").hidden = true;
  document.getElementById("fecha_actual").hidden = true;
  // $('button').removeAttr('hidden');
  // document.getElementById('btn_foto').hidden = true;
  // document.getElementById('btn_editar').hidden = true;
  // document.getElementById('btn_curriculum').hidden = true;
  // document.getElementById('btn_guardar_edicion').hidden = true;
});

//TIPO DE CONTACTOS
function TipoContacto() {
  var cadena = "&activar=activar";
  $.ajax({
    url: "../Controlador/perfil_docente_controlador.php?op=TipoContacto",
    type: "POST",
    data: cadena,
    success: function (r) {
      $("#tipo_contacto").html(r).fadeIn();
      var o = new Option("SELECCIONAR", 0);

      $("#tipo_contacto").append(o);
      $("#tipo_contacto").val(0);
    },
  });
}
TipoContacto();

$("#tipo_contacto").change(function () {
  var value_tipo = $("#tipo_contacto").children("option:selected").val();
  var tipo_contacto = $("#tipo_contacto").children("option:selected").text();

  if (tipo_contacto != "SELECIONAR") {
    $("#lbl_tipo").text(tipo_contacto);

    if (value_tipo == 1 || value_tipo == 2) {
      //$('#txt_contacto').prop('type','email');
      $("#txt_contacto_tel").removeAttr("hidden");
      $("#txt_contacto").attr("hidden", "hidden");
    } else if (value_tipo == 4) {
      $("#txt_contacto").removeAttr("hidden");
      $("#txt_contacto").attr("type", "email");
      $("#txt_contacto_tel").attr("hidden", "hidden");
    } else {
      $("#txt_contacto").removeAttr("hidden");
      $("#txt_contacto").attr("type", "email");
      $("#txt_contacto_tel").attr("hidden", "hidden");
    }

    var type = $("#txt_contacto").attr("type");
    console.log(type);
  }
});

function pregunta1() {
  $("#modalencuesta").modal({ backdrop: "static", keyboard: false });
  $("#modalencuesta").modal("show");
}
function pregunta2() {
  $("#modalencuesta2").modal({ backdrop: "static", keyboard: false });
  $("#modalencuesta2").modal("show");
}
function pregunta3() {
  $("#modalencuesta3").modal({ backdrop: "static", keyboard: false });
  $("#modalencuesta3").modal("show");
}
function ventana() {
  window.open("../vistas/encuesta_docente_vista.php", "Encuesta");
}

$("#btn_modal1").click(function () {
  var persona = $("#id_persona").val();
  console.log(persona);
  $.post(
    "../Controlador/respuesta1_carga_controlador.php",
    { id_persona: persona },

    function (data, status) {
      console.log(data);
      data = JSON.parse(data);

      console.log(data.id_area);
    }
  );

  // $.ajax({
  //   url: "../Controlador/respuesta1_carga_controlador.php",
  //   type: "POST",
  //   data: {
  //     // cod_asig: ,
  //     id_persona: persona,
  //   },
  // }).done(function (resp) {
  //   console.log(resp.id_area);
  // });
});

function alerta() {
  var chk = document.getElementById("c").value;
  alert(chk);
}

function Registrarcurriculum() {
  var formData = new FormData();
  var curriculum = $("#c_vitae")[0].files[0];
  formData.append("c", curriculum);
  formData.append("id_persona", $("#id_persona").val());

  $.ajax({
    url: "../Controlador/perfil_docente_controlador.php?op=cambiarCurriculum",
    type: "post",
    data: formData,
    contentType: false,
    processData: false,
    success: function (respuesta) {
      if ((respuesta = 1)) {
        swal("Actualizado!", "Datos actualizados correctamente!", "success");

        window.location = "../vistas/perfil_docentes_vista.php";
      }
    },
  });
  return false;
}

function AgregarCorreo(correo) {
  var id_persona = $("#id_persona").val();
  console.log(correo);

  $.post(
    "../Controlador/perfil_docente_controlador.php?op=AgregarCorreo",
    { correo: correo, id_persona: id_persona },
    function (e) {}
  );
}
//contar correos existentes para solo permitir los requeridos
function ContarCorreo() {
  let inputs = document.getElementsByTagName("input");
  let cont = 0;
  for (let index = 0; index < inputs.length; index++) {
    if ($(inputs[index]).attr("type") == "correo") {
      cont++;
    }
  }
  return cont;
}

function limpiarCor() {
  document.getElementById("correo").value = "";
}

function addCorreo() {
  l = ContarCorreo();
  let n = 1 + l;
  var correo = $("#correo").val();

  console.log(correo);

  if (correo.length == 0) {
    alert("Completar El Campo correo Por Favor");
  } else {
    if (correovalido($("#correo").val()) == 0) {
      //aqui debo validar que no se agregue a la tabla ...

      swal("Alerta", "ingresar un correo válido", "warning");

      limpiarCor();
      return false;
    } else {
      $("#tbDataCorreo1").append(
        '<tr id="row' +
          n +
          '">' +
          '<td id="celda' +
          n +
          '"><input maxlength="9" id="correo' +
          n +
          '"  type="correo" name="correo" class="form-control name_list" value="' +
          correo +
          '"/></td>' +
          '<td><button type="button" name="removeCorreo" id="' +
          n +
          '" class="btn btn-danger btn_removeCorreo">X</button></td>' +
          "</tr>"
      );

      AgregarCorreo(correo);
      correo.value = "";

      $("#ModalCorreo").modal("hide");
    }
  }
}

function MostrarBotonCurriculum() {
  $("#c_vitae").removeAttr("hidden");
  $("#btn_curriculum").removeAttr("hidden");
  $("#btn_mostrar_curriculum").attr("hidden", "hidden");
}

//      COMBOBOX ESTADO CIVIL----------------
function llenar_estado_civil() {
  var cadena = "&activar=activar";
  $.ajax({
    url: "../Controlador/perfil_docente_controlador.php?op=estado_civil",
    type: "POST",
    data: cadena,
    success: function (r) {
      // console.log(r);

      $("#estado_civil").html(r).fadeIn();
    },
  });
}
llenar_estado_civil();

function mostrar_estado_civil(id_estado_civil) {
  $.post(
    "../Controlador/perfil_docente_controlador.php?op=mostrar_estado_civil",
    { id_estado_civil: id_estado_civil },
    function (data, status) {
      data = JSON.parse(data);
    }
  );
}

//CARGAR ESTADO CIVIL
function ver_estado() {
  var id_persona = $("#id_persona").val();

  $.post(
    "../Controlador/perfil_docente_controlador.php?op=ver_estado_c",
    { id_persona: id_persona },
    function (data, status) {
      data = JSON.parse(data);

      $("#ver_estado").val(data.estado_civil);
    }
  );
}

//      PARA CUANDO CAMBIA EL VALOR DEL COMBOBOX E.C.
$("#estado_civil").change(function () {
  var id_tipo_periodo = $("#estado_civil option:selected").text();

  $("#ver_estado").val(id_tipo_periodo);
});

//      ------------------------------

//      COMBOBOX GENERO----------------
function llenar_genero() {
  var cadena = "&activar=activar";
  $.ajax({
    url: "../Controlador/perfil_docente_controlador.php?op=genero",
    type: "POST",
    data: cadena,
    success: function (r) {
      $("#genero").html(r).fadeIn();
    },
  });
}
llenar_genero();

function mostrar_genero(id_genero) {
  $.post(
    "../Controlador/perfil_docente_controlador.php?op=mostrar_genero",
    { id_genero: id_genero },
    function (data, status) {
      data = JSON.parse(data);
    }
  );
}

//CARGAR GENERO
function ver_genero() {
  var id_persona = $("#id_persona").val();

  $.post(
    "../Controlador/perfil_docente_controlador.php?op=ver_genero",
    { id_persona: id_persona },
    function (data, status) {
      data = JSON.parse(data);

      $("#ver_genero").val(data.sexo);
    }
  );
}

$("#genero").change(function () {
  var id_tipo_periodo = $("#genero option:selected").text();

  $("#ver_genero").val(id_tipo_periodo);
});

//VER SUED
function ver_sued() {
  var id_persona = $("#id_persona").val();

  $.post(
    "../Controlador/perfil_docente_controlador.php?op=ver_sued",
    { id_persona: id_persona },
    function (data, status) {
      data = JSON.parse(data);

      $("#sued").val(data.valor);
    }
  );
}

//       -------------------------

function habilitar_editar() {
  document.getElementById("estado_civil").hidden = false;
  document.getElementById("ver_estado").hidden = true;
  document.getElementById("Nombre").disabled = false;
  document.getElementById("txt_apellido").disabled = false;
  document.getElementById("identidad").disabled = false;
  document.getElementById("btn_guardar_edicion").hidden = false;
  document.getElementById("editar_info").hidden = true;
  document.getElementById("btn_editar").hidden = false;
  document.getElementById("genero").hidden = false;
  document.getElementById("ver_genero").hidden = true;
}

function desabilitar() {
  document.getElementById("estado_civil").hidden = true;
  document.getElementById("ver_estado").hidden = false;
  document.getElementById("Nombre").disabled = true;
  document.getElementById("txt_apellido").disabled = true;
  document.getElementById("identidad").disabled = true;
  document.getElementById("editar_info").hidden = false;
  document.getElementById("btn_editar").hidden = true;
  document.getElementById("btn_guardar_edicion").hidden = true;
  document.getElementById("genero").hidden = true;
  document.getElementById("ver_genero").hidden = false;
}

function ver_estado_civil() {
  document.getElementById("estado_civil").hidden = true;
  document.getElementById("ver_estado").hidden = false;
}

function insertar_pregunta1() {
  var id_persona = $("#id_persona").val();
  var id_area = $('[name="areas[]"]:checked')
    .map(function () {
      return this.value;
    })
    .get();

  console.log(id_area);
  console.log(id_persona);
  $.ajax({
    type: "POST",
    url: "../Controlador/encuesta1_docente_controlador.php",
    //  data: { array: id_area}, //capturo array
    data: { array_prefe: JSON.stringify(id_area), id_persona: id_persona },
    success: function (data) {
      swal("Ingresado!", "Datos ingresados correctamente!", "success");
    },
  });
}
function insertar_pregunta2() {
  var id_persona = $("#id_persona").val();

  var id_area = $('[name="areas2[]"]:checked')
    .map(function () {
      return this.value;
    })
    .get();

  console.log(id_area);
  console.log(id_persona);
  $.ajax({
    type: "POST",
    url: "../Controlador/encuesta2_docente_controlador.php",
    //  data: { array: id_area}, //capturo array
    data: { array_prefe1: JSON.stringify(id_area), id_persona: id_persona },
    success: function (data) {
      swal("Ingresado!", "Datos ingresados correctamente!", "success");
    },
  });
}
function insertar_pregunta3() {
  var id_persona = $("#id_persona").val();

  var id_asignatura = $('[name="asignatura3[]"]:checked')
    .map(function () {
      return this.value;
    })
    .get();

  console.log(id_asignatura);
  console.log(id_persona);
  $.ajax({
    type: "POST",
    url: "../Controlador/encuesta3_docente_controlador.php",
    //  data: { array: id_area}, //capturo array
    data: {
      array_prefe1: JSON.stringify(id_asignatura),
      id_persona: id_persona,
    },
    success: function (data) {
      swal("Ingresado!", "Datos ingresados correctamente!", "success");
    },
  });
}
function insertar_pregunta4() {
  var id_persona = $("#id_persona").val();

  var id_asignatura = $('[name="asignatura4[]"]:checked')
    .map(function () {
      return this.value;
    })
    .get();

  console.log(id_asignatura);
  console.log(id_persona);
  $.ajax({
    type: "POST",
    url: "../Controlador/encuesta4_docente_controlador.php",
    //  data: { array: id_area}, //capturo array
    data: {
      array_prefe1: JSON.stringify(id_asignatura),
      id_persona: id_persona,
    },
    success: function (data) {
      swal("Ingresado!", "Datos ingresados correctamente!", "success");
    },
  });
}

function eliminar_pregunta1(persona) {
  $.post(
    "../Controlador/perfil_docente_controlador.php?op=EliminarPregunta1",
    { id_persona: persona },
    function (e) {}
  );
}
function eliminar_pregunta2(persona) {
  $.post(
    "../Controlador/perfil_docente_controlador.php?op=EliminarPregunta2",
    { id_persona: persona },
    function (e) {}
  );
}
function eliminar_pregunta3(persona) {
  $.post(
    "../Controlador/perfil_docente_controlador.php?op=EliminarPregunta3",
    { id_persona: persona },
    function (e) {}
  );
}
function eliminar_pregunta4(persona) {
  $.post(
    "../Controlador/perfil_docente_controlador.php?op=EliminarPregunta4",
    { id_persona: persona },
    function (e) {}
  );
}

function enviarpregunta1() {
  var id_persona = $("#id_persona").val();

  $.post(
    "../Controlador/perfil_docente_controlador.php?op=contarPregunta1",
    { id_persona: id_persona },

    function (data, status) {
      console.log(data);
      data = JSON.parse(data);
      /*si no tiene datos va copiar  */

      if (data.registro == 0) {
        insertar_pregunta1();
      } else {
        // if (data.registro > 0) {
        eliminar_pregunta1(id_persona);

        insertar_pregunta1();
      }
    }
  );
}
function enviarpregunta2() {
  var id_persona = $("#id_persona").val();

  $.post(
    "../Controlador/perfil_docente_controlador.php?op=contarPregunta2",
    { id_persona: id_persona },

    function (data, status) {
      console.log(data);
      data = JSON.parse(data);
      /*si no tiene datos va copiar  */

      if (data.registro == 0) {
        insertar_pregunta2();
      } else {
        eliminar_pregunta2(id_persona);

        insertar_pregunta2();
      }
    }
  );
}
function enviarpregunta3() {
  var id_persona = $("#id_persona").val();

  $.post(
    "../Controlador/perfil_docente_controlador.php?op=contarPregunta3",
    { id_persona: id_persona },

    function (data, status) {
      console.log(data);
      data = JSON.parse(data);
      /*si no tiene datos va copiar  */

      if (data.registro == 0) {
        insertar_pregunta3();
      } else {
        eliminar_pregunta3(id_persona);

        insertar_pregunta3();
      }
    }
  );
}
function enviarpregunta4() {
  var id_persona = $("#id_persona").val();

  $.post(
    "../Controlador/perfil_docente_controlador.php?op=contarPregunta4",
    { id_persona: id_persona },

    function (data, status) {
      console.log(data);
      data = JSON.parse(data);
      /*si no tiene datos va copiar  */

      if (data.registro == 0) {
        insertar_pregunta4();
      } else {
        eliminar_pregunta4(id_persona);

        insertar_pregunta4();
      }
    }
  );
}

function especialidad() {
  var id_persona = $("#id_persona").val();

  $.post(
    "../Controlador/perfil_docente_controlador.php?op=especialidad",
    { id_persona: id_persona },
    function (data, status) {
      data = JSON.parse(data);
      console.log(data);
      for (i = 0; i < data.especialidad.length; i++) {
        $("#tbl_especialidad").append(
          '<tr id="rowe' +
            i +
            '">' +
            '<td id="celda' +
            i +
            '"><input maxlength="9" id="tel1' +
            i +
            '" type="tel" name="tel"readonly hidden class="form-control name_list" value="' +
            data["especialidad"][i].id_grado_aca_personas +
            '" placeholder="___-___"/></td>' +
            "<td>" +
            data["especialidad"][i].grado_academico +
            "</td>" +
            "<td>" +
            data["especialidad"][i].especialidad +
            "</td>" +
            '<td><button type="button" name="remove" id="' +
            i +
            '" class="btn btn-danger btn_remove_espe">X</button></td>' +
            "</tr>"
        );
      }
    }
  );
  limpiar();
}

function limpiar() {
  $("#tbl_especialidad").empty();
}
$(document).ready(function () {
  function eliminar_espe() {
    var id_persona = $("#id_persona").val();
    var confirmLeave = confirm("¿Desea eliminar la formación del docente?");
    if (confirmLeave == true) {
      var id = $(this).attr("id");
      var eliminar_formacion = document.getElementById("tel1" + id).value;
      console.log(eliminar_formacion);
      $("#rowe" + id).remove();
      console.log(id);
      $.post(
        "../Controlador/perfil_docente_controlador.php?op=eliminar_formacion",
        { eliminar_formacion: eliminar_formacion, id_persona: id_persona },
        function (e) {}
      );

      swal("Buen trabajo!", "¡ Se eliminaron !", "success");
    }
  }

  $(document).on("click", ".btn_remove_espe", eliminar_espe);

  especialidad();
});

// var table2;
// function TablaEspecialidad() {

//   var id_persona_ = $("#id_persona").val();
//   table2 = $("#tabla_especialidad_grado").DataTable({

//     autoWidth: true,
//     responsive: true,

//     destroy: true,
//     async: false,
//     processing: true,
//     ajax: {
//       url: "../Controlador/tabla_especialidad_controlador.php",
//       type: "POST",
//       data: { id_persona: id_persona_},
//     },
//     columns: [
//       {
//         defaultContent:
//           " <button id='borrar' class='borrar btn btn-danger btn-m '><i class='fas fa-trash-alt'></i></button></div></div>",
//       },
//       { data: "id_grado_aca_personas" },
//       { data: "grado_academico" },
//       { data: "especialidad" },
//     ],

//     language: idioma_espanol,
//     select: true,
//   });
// }
// $("#tabla_especialidad_grado").dataTable({
//   paging: false, //Ocultar paginación
// });

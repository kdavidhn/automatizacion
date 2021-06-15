// COMBOBOX DE DOCENTE ------------------------------------------------------------------

function mostrar(id_persona_valor) {
  $.post(
    "../Controlador/reporte_carga_controlador.php?op=mostrar",
    { id_persona: id_persona_valor },
    function (data, status) {
      data = JSON.parse(data);
      console.log(data);
      $("#txt_hra_salida").val(data.Hora_Salida);
      $("#txt_hra_entrada").val(data.Hora_Entrada);
      $("#txt_num_doc").val(data.numero_empleado);
    }
  );
}

function llenar_select1() {
  var cadena = "&activar=activar";
  $.ajax({
    url: "../Controlador/reporte_carga_controlador.php?op=select1",
    type: "POST",
    data: cadena,
    success: function (r) {
      // console.log(r);

      $("#id_select").html(r).fadeIn();
    },
  });
}
llenar_select1();

function mostrar_docente(id_persona_valor) {
  $.post(
    "../Controlador/reporte_carga_controlador.php?op=mostrar_docente",
    { id_persona: id_persona_valor },
    function (data, status) {
      data = JSON.parse(data);
      console.log(data);
      // mostrarform(true);
      $("#id").val(data.id_persona);
      $("#input2").val(data.Categoria);
      $("#input5").val(data.Hora_Salida);
      $("#input6").val(data.Hora_Entrada);
      $("#input7").val(data.Jornada);
      $("#input8").val(data.nombre);
      // $("#txt_num_doc").val(data.num_empleado);
      var tr = "<tr>";
      (tr += "<th>" + data.formacion_academica + "</th>");
      (tr += "<th>" + data.pregunta1 + "</th>");
      (tr += "<th>" + data.pregunta2 + "</th>");
      (tr += "<th>" + data.pregunta3 + "</th>");
      (tr += "<th>" + data.pregunta4 + "</th>");
      tr += "</tr>";
      $("#id_profe").html(tr);
      // console.log(tr);
    }
  );
}

function llenar_select7() {
  var cadena = "&activar=activar";
  $.ajax({
    url: "../Controlador/reporte_carga_controlador.php?op=select5",
    type: "POST",
    data: cadena,
    success: function (r) {
      // console.log(r);

      $("#id_select2").html(r).fadeIn();
    },
  });
}
llenar_select7();

//---------------------------------------------------------
function valida_horario() {
  var hora_inicial = document.getElementById("hora_inicial").value;
  var hora_final = document.getElementById("hora_final").value;
  var horas_validas = document.getElementById("txt_hras_validas").value;
  if (hora_inicial > hora_final) {
    alert("Hora inicial incorrecta");
    document.getElementById("hora_inicial").value = "";
    document.getElementById("hora_final").value = "";
  }

  if (hora_inicial == hora_final) {
    alert("Las horas son iguales");
    document.getElementById("hora_inicial").value = "";
    document.getElementById("hora_final").value = "";
  }

  if (
    hora_final - hora_inicial > horas_validas * 100 &&
    hora_final - hora_inicial > horas_validas * 100 != 4
  ) {
    alert("Sobrepasa el horario establecido por el tipo de periodo");
    document.getElementById("hora_inicial").value = "";
    document.getElementById("hora_final").value = "";
  }
}
// ----------------- COMBOBOX DE ASIGNATURA----------------
function llenar_select2() {
  var cadena = "&activar=activar";
  $.ajax({
    url: "../Controlador/reporte_carga_controlador.php?op=select2",
    type: "POST",
    data: cadena,
    success: function (r) {
      // console.log(r);

      $("#select2").html(r).fadeIn();
    },
  });
}
llenar_select2();

function mostrar2(codigo) {
  $.post(
    "../Controlador/reporte_carga_controlador.php?op=mostrar2",
    { Id_asignatura: codigo },
    function (data, status) {
      data = JSON.parse(data);
      // console.log(data);
      //mostrarform(true);
      $("#txt_cod_asignatura").val(data.codA);
      $("#txt_unid_valora").val(data.uv);
    }
  );
}

// ------------------------- COMBOBOX MODALIDAD ------------------
function llenar_modalidad() {
  var cadena = "&activar=activar";
  $.ajax({
    url: "../Controlador/reporte_carga_controlador.php?op=select6",
    type: "POST",
    data: cadena,
    success: function (r) {
      // console.log(r);

      $("#modalidad").html(r).fadeIn();
      $("#cbm_modalidad_edita").html(r).fadeIn();
    },
  });
}
llenar_modalidad();

function mostrar_modalidad(modalidad) {
  $.post(
    "../Controlador/reporte_carga_controlador.php?op=mostrar6",
    { id_modalidad: modalidad },
    function (data, status) {
      data = JSON.parse(data);
      // console.log(data);
      //mostrarform(true);
    }
  );
}

// ------------------------- COMBOBOX HORARIO------------------
function llenar_hora() {
  var cadena = "&activar=activar";
  $.ajax({
    url: "../Controlador/reporte_carga_controlador.php?op=select7",
    type: "POST",
    data: cadena,
    success: function (r) {
      // console.log(r);

      $("#hora_inicial").html(r).fadeIn();
      $("#hora_final").html(r).fadeIn();
      $("#cbm_hi_edita").html(r).fadeIn();
      $("#cbm_hf_edita").html(r).fadeIn();
    },
  });
}
llenar_hora();

function mostrar_hora(hora) {
  $.post(
    "../Controlador/reporte_carga_controlador.php?op=mostrar7",
    { hora: hora },
    function (data, status) {
      data = JSON.parse(data);
      // console.log(data);
      //mostrarform(true);
    }
  );
}

// function bloqueo_periodo() {
//   var hoy = new Date();
//   var fecha_desbloqueo = document.getElementById("fecha_desbloqueo").value;

//   if (Date.parse(hoy) > Date.parse(fecha_desbloqueo)) {
//     document.getElementById("btn_guardar_periodo").disabled = false;
//   } else {
//     document.getElementById("btn_guardar_periodo").disabled = true;
//   }
// }

//-------------------- COMBOBOX DE LOS DIAS ----------------------
function llenar_select3() {
  var cadena = "&activar=activar";
  $.ajax({
    url: "../Controlador/reporte_carga_controlador.php?op=select3",
    type: "POST",
    data: cadena,
    success: function (r) {
      // console.log(r);

      $("#select3").html(r).fadeIn();
    },
  });
}
llenar_select3();

function mostrar3(dia) {
  $.post(
    "../Controlador/reporte_carga_controlador.php?op=mostrar3",
    { Id_dia: dia },
    function (data, status) {
      data = JSON.parse(data);
      // console.log(data);
      //mostrarform(true);
    }
  );
}

//----------------------------------------------------------------

//-------------------- COMBOBOX DE LOS EDIFICIO ----------------------
function llenar_select5() {
  var cadena = "&activar=activar";
  $.ajax({
    url: "../Controlador/reporte_carga_controlador.php?op=select5",
    type: "POST",
    data: cadena,
    success: function (r) {
      // console.log(r);

      $("#select5").html(r).fadeIn();
    },
  });
}
llenar_select5();

function mostrar5(nombre) {
  $.post(
    "../Controlador/reporte_carga_controlador.php?op=mostrar5",
    { id_edificio: nombre },
    function (data, status) {
      data = JSON.parse(data);
      // console.log(data);
      //mostrarform(true);
    }
  );
}

//----------------------------------------------------------------

function llenar_tipo_p() {
  var cadena = "&activar=activar";
  $.ajax({
    url: "../Controlador/reporte_carga_controlador.php?op=select8",
    type: "POST",
    data: cadena,
    success: function (r) {
      // console.log(r);

      $("#tipo_periodo").html(r).fadeIn();
    },
  });
}
llenar_tipo_p();

function mostrar_tipo_periodo(descripcion) {
  $.post(
    "../Controlador/reporte_carga_controlador.php?op=mostrar8",
    { descripcion: descripcion },
    function (data, status) {
      data = JSON.parse(data);
      // console.log(data);
      //mostrarform(true);
    }
  );
}

$("#tipo_periodo").change(function () {
  var id_tipo_periodo = $(this).val();

  $("#tipo_p").val(id_tipo_periodo);
});

//-------------------- COMBOBOX TIPO AULA ----------------------
function llenar_select6() {
  var cadena = "&activar=activar";
  $.ajax({
    url: "../Controlador/reporte_carga_controlador.php?op=select6",
    type: "POST",
    data: cadena,
    success: function (r) {
      // console.log(r);

      $("#select6").html(r).fadeIn();
    },
  });
}
llenar_select6();

function mostrar6(tipo_aula) {
  $.post(
    "../Controlador/reporte_carga_controlador.php?op=mostrar6",
    { id_tipo_aula: tipo_aula },
    function (data, status) {
      data = JSON.parse(data);
      // console.log(data);
      //mostrarform(true);
    }
  );
}

//----------------------------------------------------------------
// function blo_desblo_periodo() {
//   var fech1 = new Date();
//   var fech2 = document.getElementById("fecha_adic_canc").value;
//   var fech3 = document.getElementById("fecha_desbloqueo").value;

//   if ((Date.parse(fech1)) >= (Date.parse(fech2))) {
//     document.getElementById('btn_guardar_periodo').disabled = true;
//     document.getElementById('fecha_inicio').disabled = true;
//     document.getElementById('fecha_final').disabled = true;
//     document.getElementById('fecha_adic_canc').disabled = true;
//   } else {
//   }

//   if ((Date.parse(fech1)) >= (Date.parse(fech3))) {
//     document.getElementById('btn_guardar_periodo').disabled = false;
//     document.getElementById('fecha_inicio').disabled = false;
//     document.getElementById('fecha_final').disabled = false;
//     document.getElementById('fecha_adic_canc').disabled = false;
//   } else {

//   }
// }

//----------------- CARGA ACADEMICA CON MODAL --------------------

$(document).ready(function () {
  $('[name="checks[]"]').click(function () {
    var arr = $('[name="checks[]"]:checked')
      .map(function () {
        return this.value;
      })
      .get();

    var str = arr.join(",");

    $("#arr").text(JSON.stringify(arr));

    $("#str").text(str);

    $("#dias").val(str);

    console.log(str);
  });
});


$("#modalidad").change(function () {
  var selected_modalidad = modalidad.options[modalidad.selectedIndex].text;

  if (selected_modalidad == "Virtual") {

    $("#edificio").prop("disabled", true);
    $("#aula").prop("disabled", true);

    $.post("../Controlador/edificio.php").done(function (respuesta) {
      $("#edificio").html(respuesta);
    });

    $.post("../Controlador/aula.php").done(function (respuesta) {
      $("#aula").html(respuesta);
    });

    document.getElementById("capacidad").value = "";


  } else {
    $("#edificio").prop("disabled", false);
    $("#aula").prop("disabled", false);

    $.post("../Controlador/edificio.php").done(function (respuesta) {
      $("#edificio").html(respuesta);
    });

    $.post("../Controlador/aula.php").done(function (respuesta) {
      $("#aula").html(respuesta);
    });

    document.getElementById("capacidad").value = "";
  }

});


// GUARDAR CARGA NUEVO
function crear_carga_academica() {
  var id_doc = $("#id_select").val();
  var aula = $("#aula").val();
  var num_doc = $("#txt_num_doc").val();
  var control = $("#txt_control").val();
  var id_asignatura = $("#select2").val();
  var id_modalidad = $("#modalidad").val();
  var cod_asignatura = $("#txt_cod_asignatura").val();
  var seccion = $("#txt_seccion").val();
  var hora_inicial = $("#hora_inicial").val();
  var hora_final = $("#hora_final").val();
  var dias = $("#dias").val();
  var unid_valora = document.getElementById("txt_unid_valora");
  var matri = $("#txt_matriculados").val();
  var id_periodo = $("#txt_id_periodo").val();
  var tipo_periodo = $("#txt_tipo_periodo").val();
  var selected_modalidad = modalidad.options[modalidad.selectedIndex].text;

  if (selected_modalidad == "Virtual") {

    if (
      $("#txt_seccion").val().length == 0 ||
      hora_inicial.value == 0 ||
      hora_final.value == 0 ||
      $("#hora_inicial").val().value == "" ||
      $("#hora_final").val().value == "" ||
      $("#txt_matriculados").val().length == 0 ||
      $("#id_select").val().length == 0 ||
      $("#dias").val().length == 0
    ) {
      swal({
        title: "alerta",
        text: "Llene o seleccione los campos vacios",
        type: "warning",
        showConfirmButton: true,
        timer: 15000,
      });
      
    }else{
      var hora_inicial = document.getElementById("hora_inicial").value;
      var hora_final = document.getElementById("hora_final").value;
      var horas_validas = document.getElementById("txt_hras_validas").value;

      if (hora_inicial > hora_final) {
        swal({
          title: "alerta",
          text: "Hora inicial incorrecta",
          type: "warning",
          showConfirmButton: true,
          timer: 20000,
        });
        document.getElementById("hora_inicial").value = "";
        document.getElementById("hora_final").value = "";
      } else if (hora_inicial == hora_final) {
        swal({
          title: "alerta",
          text: "Las horas son iguales",
          type: "warning",
          showConfirmButton: true,
          timer: 20000,
        });
        // alert("Las horas son iguales");
        document.getElementById("hora_final").value = "";
      } else {

        $.post(
          "../Controlador/reporte_carga_controlador.php?op=contar_carga",
          {
            id_persona: id_doc,
          },

          function (data, status) {
            console.log(data);
            data = JSON.parse(data);
            $("#txt_contar_carga").val(data.carga);
            var contar = $("#txt_contar_carga").val();

            if (contar >= 3) {
              swal({
                title: "Alerta!",
                text:
                  "Este docente tiene 3 cargas asignadas, desea continuar?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
              }).then((willDelete) => {
                if (willDelete) {
                  $("#txt_registro_crear").val(data.registro);
                  var registro = $("#txt_registro_crear").val();

                  if (registro > 0) {
                    swal({
                      title: "Alerta",
                      text:
                        "Ya hay una carga asignada a esa hora, Hora Inicial: " +
                        hora_inicial +
                        ",Hora Final: " +
                        hora_final,
                      type: "warning",
                      showConfirmButton: true,
                      timer: 6000,
                    });
                    document.getElementById("txt_registro_crear").value = "";
                  } else {
                    $.ajax({
                      url: "../Controlador/crear_carga_virtual_controlador.php",
                      type: "POST",
                      data: {
                        control: control,
                        seccion: seccion,
                        num_alumnos: matri,
                        id_persona: id_doc,
                        id_asignatura: id_asignatura,
                        dias: dias,
                        id_modalidad: id_modalidad,
                        hora_inicial: hora_inicial,
                        hora_final: hora_final,
                      },
                    }).done(function (resp) {
                      if (resp > 0) {
                        $("#ModalTask").modal("hide");
                        swal(
                          "Buen trabajo!",
                          "datos actualizados correctamente!",
                          "success"
                        );
                        document.getElementById("txt_registro_crear").value = "";

                        limpiar();
                        table.ajax.reload();
                      } else {
                        swal(
                          "Alerta!",
                          "No se pudo completar la actualización",
                          "warning"
                        );
                        document.getElementById("txt_registro_crear").value = "";
                      }
                    });
                  }
                } else {
                  swal("Cancelado!");

                }
              });

              document.getElementById("txt_contar_carga").value = "";
            } else {
              $("#txt_registro_crear").val(data.registro);
              var registro = $("#txt_registro_crear").val();

              if (registro > 0) {
                swal({
                  title: "Alerta",
                  text:
                    "Ya hay una carga asignada a esa hora, Hora Inicial: " +
                    hora_inicial +
                    ",Hora Final: " +
                    hora_final,
                  type: "warning",
                  showConfirmButton: true,
                  timer: 6000,
                });
                document.getElementById("txt_registro_crear").value = "";
              } else {
                $.ajax({
                  url: "../Controlador/crear_carga_virtual_controlador.php",
                  type: "POST",
                  data: {
                    control: control,
                    seccion: seccion,
                    num_alumnos: matri,
                    id_persona: id_doc,
                    id_asignatura: id_asignatura,
                    dias: dias,
                    id_modalidad: id_modalidad,
                    hora_inicial: hora_inicial,
                    hora_final: hora_final,
                  },
                }).done(function (resp) {
                  if (resp > 0) {
                    $("#ModalTask").modal("hide");
                    swal(
                      "Buen trabajo!",
                      "Datos actualizados correctamente!",
                      "success"
                    );
                    document.getElementById("txt_registro_crear").value = "";

                    limpiar();
                    table.ajax.reload();
                  } else {
                    swal(
                      "Alerta!",
                      "No se pudo completar la actualización",
                      "warning"
                    );
                    document.getElementById("txt_registro_crear").value = "";
                  }
                });
              }
            }

          }
        );
      }
    }

  } else {

    if (
      $("#txt_seccion").val().length == 0 ||
      hora_inicial.value == 0 ||
      hora_final.value == 0 ||
      $("#modalidad").val().length == 0 ||
      $("#hora_inicial").val().value == "" ||
      $("#hora_final").val().value == "" ||
      $("#txt_matriculados").val().length == 0 ||
      $("#capacidad").val().length == 0 ||
      $("#aula").val().length == 0 ||
      $("#edificio").val().length == 0

    ) {

      swal({
        title: "alerta",
        text: "Llene o seleccione los campos vacios",
        type: "warning",
        showConfirmButton: true,
        timer: 15000,
      });
    } else {
      swal({
        title: "alerta",
        text: "Por favor espere",
        type: "warning",
        showConfirmButton: false,
        timer: 20000,
      });

      var hora_inicial = document.getElementById("hora_inicial").value;
      var hora_final = document.getElementById("hora_final").value;
      var horas_validas = document.getElementById("txt_hras_validas").value;

      if (hora_inicial > hora_final) {
        swal({
          title: "alerta",
          text: "Hora inicial incorrecta",
          type: "warning",
          showConfirmButton: true,
          timer: 20000,
        });
        document.getElementById("hora_inicial").value = "";
        document.getElementById("hora_final").value = "";
      } else if (hora_inicial == hora_final) {
        swal({
          title: "alerta",
          text: "Las horas son iguales",
          type: "warning",
          showConfirmButton: true,
          timer: 20000,
        });
        // alert("Las horas son iguales");
        document.getElementById("hora_final").value = "";
      } else {

        $.post(
          "../Controlador/reporte_carga_controlador.php?op=contar_carga",
          {
            id_persona: id_doc,
          },

          function (data, status) {
            console.log(data);
            data = JSON.parse(data);
            $("#txt_contar_carga").val(data.carga);
            var contar = $("#txt_contar_carga").val();

            if (contar >= 3) {
              swal({
                title: "Alerta!",
                text:
                  "Este docente tiene 3 cargas asignadas, desea continuar?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
              }).then((willDelete) => {
                if (willDelete) {
                  $.post(
                    "../Controlador/reporte_carga_controlador.php?op=existe_carga",
                    {
                      hora_inicial: hora_inicial,
                      id_periodo: id_periodo,
                      hora_final: hora_final,
                      id_aula: aula
                    },

                    function (data, status) {
                      console.log(data);
                      data = JSON.parse(data);
                      /*si no tiene datos va copiar  */
                      $("#txt_registro_crear").val(data.registro);
                      var registro = $("#txt_registro_crear").val();

                      if (registro > 0) {
                        swal({
                          title: "Alerta",
                          text:
                            "Ya hay una carga asignada a esa hora, Hora Inicial: " +
                            hora_inicial +
                            ",Hora Final: " +
                            hora_final,
                          type: "warning",
                          showConfirmButton: true,
                          timer: 6000,
                        });
                        document.getElementById("txt_registro_crear").value = "";
                      } else {
                        $.ajax({
                          url: "../Controlador/crear_carga_controlador.php",
                          type: "POST",
                          data: {
                            control: control,
                            seccion: seccion,
                            num_alumnos: matri,
                            id_persona: id_doc,
                            id_aula: aula,
                            id_asignatura: id_asignatura,
                            dias: dias,
                            id_modalidad: id_modalidad,
                            hora_inicial: hora_inicial,
                            hora_final: hora_final,
                          },
                        }).done(function (resp) {
                          if (resp > 0) {
                            $("#ModalTask").modal("hide");
                            swal(
                              "Buen trabajo!",
                              "datos actualizados correctamente!",
                              "success"
                            );
                            document.getElementById("txt_registro_crear").value = "";

                            limpiar();
                            table.ajax.reload();
                          } else {
                            swal(
                              "Alerta!",
                              "No se pudo completar la actualización",
                              "warning"
                            );
                            document.getElementById("txt_registro_crear").value = "";
                          }
                        });
                      }
                    }
                  );
                } else {
                  swal("Cancelado!");

                }
              });

              document.getElementById("txt_contar_carga").value = "";
            } else {
              $.post(
                "../Controlador/reporte_carga_controlador.php?op=existe_carga",
                {
                  hora_inicial: hora_inicial,
                  id_periodo: id_periodo,
                  hora_final: hora_final,
                  id_aula: aula
                },

                function (data, status) {
                  console.log(data);
                  data = JSON.parse(data);
                  /*si no tiene datos va copiar  */
                  $("#txt_registro_crear").val(data.registro);
                  var registro = $("#txt_registro_crear").val();

                  if (registro > 0) {
                    swal({
                      title: "Alerta",
                      text:
                        "Ya hay una carga asignada a esa hora, Hora Inicial: " +
                        hora_inicial +
                        ",Hora Final: " +
                        hora_final,
                      type: "warning",
                      showConfirmButton: true,
                      timer: 6000,
                    });
                    document.getElementById("txt_registro_crear").value = "";
                  } else {
                    $.ajax({
                      url: "../Controlador/crear_carga_controlador.php",
                      type: "POST",
                      data: {
                        control: control,
                        seccion: seccion,
                        num_alumnos: matri,
                        id_persona: id_doc,
                        id_aula: aula,
                        id_asignatura: id_asignatura,
                        dias: dias,
                        id_modalidad: id_modalidad,
                        hora_inicial: hora_inicial,
                        hora_final: hora_final,
                      },
                    }).done(function (resp) {
                      if (resp > 0) {
                        $("#ModalTask").modal("hide");
                        swal(
                          "Buen trabajo!",
                          "Datos actualizados correctamente!",
                          "success"
                        );
                        document.getElementById("txt_registro_crear").value = "";

                        limpiar();
                        table.ajax.reload();
                      } else {
                        swal(
                          "Alerta!",
                          "No se pudo completar la actualización",
                          "warning"
                        );
                        document.getElementById("txt_registro_crear").value = "";
                      }
                    });
                  }
                }
              );
            }
          }
        );
      }
    }
  }
}

function limpiar() {
  document.getElementById("txt_control").value = "";
  document.getElementById("txt_cod_asignatura").value = "";
  document.getElementById("txt_seccion").value = "";
  document.getElementById("hora_inicial").value = "";
  document.getElementById("hora_final").value = "";
  document.getElementById("txt_matriculados").value = "";
  document.getElementById("capacidad").value = "";
  document.getElementById("edificio").value = "";
  document.getElementById("aula").value = "";
  document.getElementById("select2").value = "";
  document.getElementById("id_select").value = "";
  document.getElementById("txt_num_doc").value = "";
  document.getElementById("modalidad").value = "";
  document.getElementById("txt_unid_valora").value = "";
  document.getElementById("Lu").checked = false;
  document.getElementById("Ma").checked = false;
  document.getElementById("Mi").checked = false;
  document.getElementById("Ju").checked = false;
  document.getElementById("Vi").checked = false;
  document.getElementById("Sa").checked = false;
  document.getElementById("Do").checked = false;
  document.getElementById("id_select").focus();
}

//--------------------------------------


//--------------------------------------

//LLENAR COMBOBOX EDIFICIO Y AULA
$(function () {
  // Lista de edificios
  $.post("../Controlador/edificio.php").done(function (respuesta) {
    $("#edificio").html(respuesta);
  });

  // lista deaulas
  $("#edificio").change(function () {
    var el_edificio = $(this).val();
    // console.log(el_edificio);
    // Lista deaulas
    $.post("../Controlador/aula.php", {
      id_edificio: el_edificio,
    }).done(function (respuesta) {
      $("#aula").html(respuesta);
    });
  });

  $.post("../Controlador/aula.php").done(function (respuesta) {
    $("#aula").html(respuesta);
  });

  $("#aula").change(function () {
    var id_aula = $(this).val();

    // Lista deaulas
    $.post(
      "../Controlador/reporte_carga_controlador.php?op=capacidad",
      { id_aula: id_aula },
      function (data_, status) {
        data_ = JSON.parse(data_);

        // console.log(data_.capacidad);
        $("#capacidad").val(data_.capacidad);
      }
    );
  });
});

function RegistarPeriodo(num_periodo, num_anno, fecha_inicio, fecha_final) {
  num_periodo = num_periodo.toUpperCase();
  num_anno = num_anno.toUpperCase();

  $.post(
    "../Controlador/reporte_carga_controlador.php?op=registar",
    {
      num_periodo: num_periodo,
      num_anno: num_anno,
      fecha_inicio: fecha_inicio,
      fecha_final: fecha_final,
    },
    function (e) {
      window.location.href = window.location.href;
    }
  );
}

function AgregarEdificio(nombre_edif, codigo_edif) {
  nombre_edif = nombre_edif.toUpperCase();
  codigo_edif = codigo_edif.toUpperCase();

  $.post(
    "../Controlador/reporte_carga_controlador.php?op=agregar",
    { nombre: nombre_edif, codigo: codigo_edif },
    function (e) {
      window.location.href = window.location.href;
    }
  );
}

function RegistrarAula(codigo, descripcion, capacidad, select5, select6) {
  $.post(
    "../Controlador/reporte_carga_controlador.php?op=registrar_aula",
    {
      codigo: codigo,
      descripcion: descripcion,
      capacidad: capacidad,
      id_edificio: select5,
      id_tipo_aula: select6,
    },
    function (e) {
      window.location.href = window.location.href;
    }
  );
}

function abrirmodalcarga() {
  $("#ModalTask").modal({ backdrop: "static", keyboard: false });
  $("#ModalTask").modal("show");
}

function abrirmodalinformaciondocente() {
  $("#modal2").modal({ backdrop: "static", keyboard: false });
  $("#modal2").modal("show");
}

function valida_entrada_crear() {
  var hraEntrada = document.getElementById("txt_hra_entrada").value;
  var hora_inicial = document.getElementById("hora_inicial").value;

  var nombre_doc = $("#id_select option:selected").text();
  if (hora_inicial < hraEntrada) {
    swal({
      title: "alerta",
      text:
        "Ha seleccionado una hora para la asignatura que no corresponde al horarario de entrada del docente: " +
        nombre_doc +
        " ,Hora de entrada: " +
        hraEntrada +
        "",
      type: "warning",
      showConfirmButton: true,
      timer: 10000,
    });
  }
}


function horario_docente_crear(id) {
  // //  console.log();
  $.post(
    "../Controlador/reporte_carga_controlador.php?op=horario_docente",
    { id_persona: id },
    function (data, status) {
      data = JSON.parse(data);
      // console.log(data);
      //mostrarform(true);
      $("#txt_hra_entrada").val(data.Hora_Entrada);
      $("#txt_hra_salida").val(data.Hora_Salida);
    }
  );
}

$(document).click(function () {
  var checked = $(".CheckedAK:checked").length;
  var unid_valorativas = document.getElementById("txt_unid_valora").value;

  if (unid_valorativas == '5' && checked == '6') {
    swal({
      title: "Alerta",
      text:
        "Solo se permiten 5 dias como maximo ",
      type: "warning",
      showConfirmButton: true,
      timer: 10000,
    });

    document.getElementById("Lu").checked = false;
    document.getElementById("Ma").checked = false;
    document.getElementById("Mi").checked = false;
    document.getElementById("Ju").checked = false;
    document.getElementById("Vi").checked = false;
    document.getElementById("Sa").checked = false;
    document.getElementById("Do").checked = false;
  } else {

  }

  if (unid_valorativas == '4' && checked == '5') {
    swal({
      title: "Alerta",
      text:
        "Solo se permiten 4 dias como maximo ",
      type: "warning",
      showConfirmButton: true,
      timer: 10000,
    });

    document.getElementById("Lu").checked = false;
    document.getElementById("Ma").checked = false;
    document.getElementById("Mi").checked = false;
    document.getElementById("Ju").checked = false;
    document.getElementById("Vi").checked = false;
    document.getElementById("Sa").checked = false;
    document.getElementById("Do").checked = false;
  } else {

  }

  if (unid_valorativas == '3' && checked == '4') {
    swal({
      title: "Alerta",
      text:
        "Solo se permiten 3 dias como maximo ",
      type: "warning",
      showConfirmButton: true,
      timer: 10000,
    });

    document.getElementById("Lu").checked = false;
    document.getElementById("Ma").checked = false;
    document.getElementById("Mi").checked = false;
    document.getElementById("Ju").checked = false;
    document.getElementById("Vi").checked = false;
    document.getElementById("Sa").checked = false;
    document.getElementById("Do").checked = false;
  } else {

  }

  if (unid_valorativas == '2' && checked == '3') {
    swal({
      title: "Alerta",
      text:
        "Solo se permiten 2 dias como maximo ",
      type: "warning",
      showConfirmButton: true,
      timer: 10000,
    });

    document.getElementById("Lu").checked = false;
    document.getElementById("Ma").checked = false;
    document.getElementById("Mi").checked = false;
    document.getElementById("Ju").checked = false;
    document.getElementById("Vi").checked = false;
    document.getElementById("Sa").checked = false;
    document.getElementById("Do").checked = false;
  } else {

  }
})
  .trigger("click");

function valida_horario_crear() {
  var hora_inicial = document.getElementById("hora_inicial").value;
  var hora_final = document.getElementById("hora_final").value;
  var horas_validas = document.getElementById("txt_hras_validas").value;
  var hra_salida = document.getElementById("txt_hra_salida").value;

  var nombre_docente = $("#id_select option:selected").text();

  if (
    hora_final - hora_inicial > horas_validas * 100 &&
    hora_final - hora_inicial > horas_validas * 100 != 4
  ) {
    swal({
      title: "Alerta",
      text: "Sobrepasa el horario establecido para el tipo de periodo!",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    })
      .then((willDelete) => {
        if (willDelete) {


        } else {

          document.getElementById("hora_final").value = "";
        }
      });
  }

  if (hora_final > hra_salida) {
    swal({
      title: "Alerta",
      text: "El horario de salida sobrepasa el establecido para el docente!",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    })
      .then((willDelete) => {
        if (willDelete) {


        } else {

          document.getElementById("hora_final").value = "";
        }
      });
  }
}

function valida_matriculados() {
  var capacidad = document.getElementById("capacidad").value;
  var matriculados = document.getElementById("txt_matriculados").value;
  var selected_modalidad = modalidad.options[modalidad.selectedIndex].text;
  if (matriculados > capacidad && selected_modalidad != "Virtual") {
    swal({
      title: "Alerta",
      text: "Esta excediendo la capacidad, desea continuar?",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    }).then((willDelete) => {
      if (willDelete) {
      } else {
        document.getElementById("txt_matriculados").value = "";
      }
    });
  }

}

// function prueba() {
//   var fech1 = new Date();
//   var fech2 = document.getElementById("fecha_adic_canc").value;
//   var fech3 = document.getElementById("fecha_desbloqueo").value;

//   if ((Date.parse(fech1)) >= (Date.parse(fech2))) {
//       document.getElementById('nueva_carga').disabled = true;
//       document.getElementById('guardar').disabled = true;
//       document.getElementById("aceptar_eliminar").disabled = true;
//   } else {}

//   if ((Date.parse(fech1)) >= (Date.parse(fech3))) {
//       document.getElementById('nueva_carga').disabled = false;
//       document.getElementById('guardar').disabled = false;
//       document.getElementById("aceptar_eliminar").disabled = false;
//   } else {

//   }
// }

$(document).ready(function () {

  $('.select2').select2({
    placeholder: 'Select una opcion',
    theme: 'bootstrap4',
    tags: true,
  });

});

function comprobar() {

  var periodo_num = document.getElementById('num_periodo').value;
  var max_periodo = document.getElementById('max_periodo').value;
  if (periodo_num > max_periodo) {
    document.getElementById('num_periodo').value = max_periodo;

  } else {

  }

}



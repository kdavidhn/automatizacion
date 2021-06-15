//DE AQUI COMIENZA LA GESTION DE PLAN
var table;
function TablaPlanEstudio() {
  table = $("#tabla_plan_estudio").DataTable({
    paging: true,
    lengthChange: true,
    ordering: true,
    info: true,
    autoWidth: true,
    responsive: true,
    // LengthChange: false,
    searching: { regex: true },
    lengthMenu: [
      [10, 25, 50, 100, -1],
      [10, 25, 50, 100, "All"],
    ],
    sortable: false,
    pageLength: 15,
    destroy: true,
    async: false,
    processing: true,
    ajax: {
      url: "../Controlador/tabla_plan_estudio_controlador.php",
      type: "POST",
    },

    columns: [
      {
        defaultContent:
          // "<button style='font-size:13px;' type='button' class='editar btn btn-primary'><i class='fas fa-edit'></i></button><button style='font-size:10px;' type='button' class='eliminar btn btn-primary'><i class='fas fa-trash-alt'></i></button>",

          "<button style='font-size:13px;' type='button' class='editar btn btn-primary '><i class='fas fa-edit'></i></button>",
      },
      { data: "nombre_plan" },
      { data: "num_clases" },
      { data: "codigo_plan" },
      { data: "nombre_tipo_plan" },
      { data: "plan_vigente" },
      {
        defaultContent:
          "<button style='font-size:13px;' type='button' class='desactivar btn btn-danger'></i><i class='fas fa-ban'></i></button>&nbsp;<button style='font-size:13px;' type='button' class='activar btn btn-success'><i class='fa fa-check-circle'></i></button>",
      },
    ],

    language: idioma_espanol,
    select: true,
  });
}

$("#tabla_plan_estudio").on("click", ".editar", function () {
  var data = table.row($(this).parents("tr")).data();
  if (table.row(this).child.isShown()) {
    var data = table.row(this).data();
  }


  $("#modal_editar").modal({ backdrop: "static", keyboard: false });
  $("#modal_editar").modal("show");
});
function mostrar() {
	console.log('mostrar se ejecuto');

	$.post("../Controlador/reporte_docentes_controlador.php?op=mostrar", function (data, status) {
		data = JSON.parse(data);
		console.log(data);
		//mostrarform(true);

		$("#docente").val(data.docente);
	})

	//	

}

//solo permite numeros
function Numeros(e) {
	tecla = (document.all) ? e.keyCode : e.which;

	//Tecla de retroceso para borrar, siempre la permite
	if (tecla == 8) {
		return true;
	}

	// Patron de entrada, en este caso solo acepta  letras
	patron = /[0-9]/;
	tecla_final = String.fromCharCode(tecla);
	return patron.test(tecla_final);
}
function RegistrarJornada(jornada, descripcion) {
	jornada = jornada.toUpperCase();
	descripcion = descripcion.toUpperCase();
	
	$.post("../Controlador/reporte_docentes_controlador.php?op=registrar", { jornada: jornada, descripcion: descripcion }, function (e) {
		
		window.location.href = window.location.href;

	})

}
function RegistrarComision(comision, carrera) {
	comision = comision.toUpperCase();
	carrera = carrera.toUpperCase();

	$.post("../Controlador/reporte_docentes_controlador.php?op=registrarcomision", { comision: comision, carrera: carrera }, function (e) {
		
		window.location.href = window.location.href;

	})

}

function RegistrarCategoria(categoria, descripcion) {
	categoria = categoria.toUpperCase();
	descripcion = descripcion.toUpperCase();

	$.post("../Controlador/reporte_docentes_controlador.php?op=registrarcategorias", { categoria: categoria, descripcion: descripcion }, function (e) {

		window.location.href = window.location.href;

	})

}
function RegistrarGrado(grado_academico, descripcion) {
	grado_academico = grado_academico.toUpperCase();
	descripcion = descripcion.toUpperCase();

	$.post("../Controlador/reporte_docentes_controlador.php?op=registrargrados", { grado_academico: grado_academico, descripcion: descripcion }, function (e) {

		window.location.href = window.location.href;

	})

}
//No permite doble Espacio
function DobleEspacio(campo, event) {

	CadenaaReemplazar = "  ";
	CadenaReemplazo = " ";
	CadenaTexto = campo.value;
	CadenaTextoNueva = CadenaTexto.split(CadenaaReemplazar).join(CadenaReemplazo);
	campo.value = CadenaTextoNueva;

}
 /* tabla carga */
 var table;
function TablaCarga1() {
	var id_persona_ = $("#id_persona").val();
	
	table = $("#tabla").DataTable({
		ordering: true,
		bLengthChange: false,
		searching: { regex: false },
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
			url: "../Controlador/tabla1_reporte_controlador.php",
			type: "POST",
			data: { id_persona_: id_persona_ },
		},
		columns: [
			{ data: "codigo" },
			{ data: "asignatura" },
			{ data: "seccion" },
			{ data: "hra_inicial" },
			{ data: "hra_final" },
			{ data: "dia" },
			{ data: "aula" },
			{ data: "edificio" },
			{ data: "num_alumnos" }
		],

		language: idioma_espanol,
		select: true,
	});
} 
var table1;
 //var id_sesion = $("id_sesion").val(); */
/* var id_sesion_ = 2; */
 
function TablaCarga() {
	
	var id_usuario_ = $("#id_sesion").val();
	 table1 = $("#tabla1").DataTable({

		
		ordering: false,
		bLengthChange: false,
		searching: { regex: false },
		lengthMenu: [
			[10, 25, 50, 100, -1],
			[10, 25, 50, 100, "All"],
		],
		pageLength: 15,
		destroy: true,
		async: false,
		processing: true,
		ajax: {
			url: "../Controlador/tabla_reporte_controlador.php",
			type: "POST",
			data: { id_usuario_: id_usuario_},
		},
		 columns: [
			
			{ data: "id_actividad" },
			{ data: "comision" },
			{ data: "actividad" },
			{ data: "horas_semanales" },
			{
				defaultContent:
					"<button style='font-size:13px;' type='button' class='editar btn btn-primary '><i class='fas fa-edit'></i></button>",
			}
		
		],

		language: idioma_espanol,
		select: true,
	});
	/* document.getElementById("tabla_carga_filter").style.display = "none";
	$("input.global_filter").on("keyup click", function () {
		filterGlobal();
	});
	$("input.column_filter").on("keyup click", function () {
		filterColumn($(this).parents("tr").attr("data-column"));
	}); */
	
}
$("#tabla1").on("click", ".editar", function () {

	var data = table1.row($(this).parents("tr")).data()
	if (table1.row(this).child.isShown()) {

		var data = table1.row(this).data();
	}
	$("#modal_editar").modal({ backdrop: "static", keyboard: false });
	$("#modal_editar").modal("show");
	$("#txt_idactividad").val(data.id_actividad);
	$("#txt_comision").val(data.comision);
	$("#txt_actividad").val(data.actividad);
	$("#txt_horas").val(data.horas_semanales);
});

function modificar_horas() {
	var id_actividad = $("#txt_idactividad").val();
	var horas_semanales = $("#txt_horas").val();

	if (id_actividad.length == 0 || horas_semanales.length == 0) {
		alert("Llene los campos vacios");
		
	} else {
		$.ajax({
			url: "../Controlador/modificar_horas_controlador.php",
			type: "POST",
			data: {
				id_actividad: id_actividad,
				horas_semanales: horas_semanales,
			}

		}).done(function (resp) {
			if (resp > 0) {
					$("#modal_editar").modal("hide");
					swal("Buen trabajo!", "datos actualizados correctamente!", "success");
					table1.ajax.reload();
				
				
			} else {
				swal("Error!", "No se pudo eliminar!", "warning");
			}

			
		
		});

	
	}  
} 
/* function abrirmodal() {
	
	$('#modal_editar').modal({ backdrop: 'static', keyboard: false });
	$('#modal_editar').modal('show');
	
} */
/* listar();
mostrar(); */




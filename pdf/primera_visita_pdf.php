<?php 

	 session_start();

require 'fpdf/fpdf.php';
require_once ('../clases/Conexion.php');


$id_persona=$_GET["id"];

$sql = "SELECT 
p.documento, p.nombre, 
ep.nombre_empresa, ep.jefe_inmediato, ep.titulo_jefe_inmediato, ep.correo_jefe_inmediato, ep.telefono_jefe_inmediato,
fp.funciones_analisis, fp.funciones_diseno, fp.funciones_redes, fp.funciones_capacitacion, fp.funciones_seguridad, fp.funciones_auditoria, fp.funciones_base, fp.funciones_soporte, fp.funciones_programacion,
ca.comentario_evaluacion, ca.area_refuerzo, ca.calificacion_global, ca.solicitar_practicante, ca.oportunidad_empleo, ca.nombre_representante, ca.lugar, ca.fecha,
dp.asistencia_practicante, dp.horario_practicante, dp.adaptacion_practicante, dp.cumplimiento_practicante, dp.calidad_trabajo_practicante, dp.percepcion_conocimiento, dp.percepcion_habilidades,
evp.comunicacion, evp.puntualidad, evp.responsabilidad, evp.creatividad, evp.presentacion, evp.atencion_cliente, evp.colaborativo, evp.trabajo_equipo, evp.proactivo_iniciativa, evp.relacion_interpersonal, evp.analisis_sistema, evp.diseno_aplicacion, evp.programador_aplicacion, evp.mantenimiento_aplicacion, evp.aspecto_auditoria, evp.aspecto_seguridad, ep.labora_dentro
FROM 
tbl_personas p, tbl_empresas_practica ep, tbl_funciones_practica fp, tbl_comentarios_alumnos ca, tbl_desempeno_practica dp, tbl_evaluaciones_practica evp where fp.numero_visita='Primera Supervision' and ca.numero_visita='Primera Supervision' and evp.numero_visita='Primera Supervision' and ep.id_persona='$id_persona' AND p.id_persona=ep.id_persona AND fp.id_persona='$id_persona' AND ca.id_persona='$id_persona'  AND evp.id_persona='$id_persona'";

class PDF extends FPDF
	{
		function Header()
		{
			if ($this->PageNo() != 2 AND $this->PageNo() != 3){
				//date_default_timezone_get('America/Tegucigalpa');
			$this->Image('../dist/img/logo_ia.jpg', 12,8,30);
				$this->Image('../dist/img/logo-unah.jpg', 172,8, 22 );
			}
	

		}
function Footer()
		{
			$fecha_actual=date("Y-m-d H:i:s");
			$this->SetY(-15);
			$this->SetFont('Arial','I', 8);
			$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');

		}	

}
//date_default_timezone_get('America/Tegucigalpa');

$resultado = mysqli_query($connection, $sql);
	
	

		$row = mysqli_fetch_array($resultado);
		if(empty($row) || $row['labora_dentro']=='NO' )
		{
			echo '<script>alert("La primera supervisión para este alumno aún no ha sido generada ó no labora dentro de la empresa.");window.location.href="../vistas/gestion_practicantes_vista.php";</script>';
		}
		else
		{
			
		

	

	$pdf = new PDF();
	$pdf->AliasNbPages();
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont('Arial','B',15);
	$pdf->cell(0,6,utf8_decode('Universidad Nacional Autónoma de Honduras'),0,1,'C');
	$pdf->ln(2);
	$pdf->cell(0,6,utf8_decode('Facultad de Ciencias Económicas'),0,1,'C');
	$pdf->ln(2);
	$pdf->cell(0,6,utf8_decode('Departamento de Informática Administrativa'),0,1,'C');
	$pdf->ln();
	
	$pdf->SetFont('Arial','', 10);
	$pdf->ln(5);
    $pdf->Cell(0,5,utf8_decode('PRIMERA SUPERVISIÓN'),0,1,'C');
    $pdf->ln(5);
    
    $pdf->SetFont('Arial','BU',12);
	$pdf->ln(2);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode('DATOS GENERALES '),0);
	$pdf->SetX(20);
    $pdf->ln(2);

    $pdf->SetFont('Arial','',12);
	$pdf->ln(2);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode('Nombre de la Institución	: '.$row['nombre_empresa'].''),0);
	$pdf->SetX(20);
    $pdf->ln(2);
	$pdf->ln(2);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode('Nombre del Jefe Inmediato: '.$row['jefe_inmediato'].''),0);
	$pdf->SetX(20);
    $pdf->ln(2);
    $pdf->ln(2);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode('Titulo del Jefe Inmediato: '.$row['titulo_jefe_inmediato'].''),0);
	$pdf->SetX(20);
    $pdf->ln(2);
    $pdf->ln(2);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode('Dirección de correo Electrónico	: '.$row['correo_jefe_inmediato'].''),0);
	$pdf->SetX(20);
    $pdf->ln(2);
	$pdf->ln(2);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode('No. de Teléfono: '.$row['telefono_jefe_inmediato'].''),0);
	$pdf->SetX(20);
    $pdf->ln(2);
    $pdf->ln(2);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode('Nombre del Estudiante: '.$row['nombre'].''),0);
	$pdf->SetX(20);
    $pdf->ln(2);
	$pdf->ln(2);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode('Cuenta del Estudiante: '.$row['documento'].''),0);
	$pdf->SetX(20);
    $pdf->ln(2);
    $pdf->ln(2);
	$pdf->SetX(20);
	//$pdf->multicell(170,5,utf8_decode('Nombre del puesto que desempe�a el estudiante: '.$row['sps_puesto_sv'].''),0);
	$pdf->SetX(20);
    $pdf->ln(10);

    $pdf->SetFont('Arial','BU',12);
	$pdf->ln(2);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode('FUNCIONES QUE REALIZA '),0);
	$pdf->SetX(20);
	$pdf->ln(2);
	
	
    $pdf->SetFont('Arial','',12);
	$pdf->ln(2);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode(' '.$row['funciones_analisis'].' '),0);
	$pdf->SetX(20);
	$pdf->ln(2);
	$pdf->ln(2);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode(' '.$row['funciones_diseno'].' '),0);
	$pdf->SetX(20);
	$pdf->ln(2);
	$pdf->ln(2);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode(' '.$row['funciones_redes'].' '),0);
	$pdf->SetX(20);
	$pdf->ln(2);
	$pdf->ln(2);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode(' '.$row['funciones_capacitacion'].' '),0);
	$pdf->SetX(20);
	$pdf->ln(2);
	$pdf->ln(2);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode(' '.$row['funciones_seguridad'].' '),0);
	$pdf->SetX(20);
	$pdf->ln(2);
	$pdf->ln(2);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode(' '.$row['funciones_auditoria'].' '),0);
	$pdf->SetX(20);
	$pdf->ln(2);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode(' '.$row['funciones_base'].' '),0);
	$pdf->SetX(20);
	$pdf->ln(2);
	$pdf->ln(2);
	$pdf->SetX(20);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode(' '.$row['funciones_soporte'].' '),0);
	$pdf->SetX(20);
	$pdf->ln(2);
	$pdf->ln(2);
	$pdf->SetX(20);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode(' '.$row['funciones_programacion'].' '),0);
	$pdf->SetX(20);
	$pdf->ln(2);
	$pdf->ln(70);
	
	
    
	
	$pdf->SetFont('Arial','BU',12);
	$pdf->ln(2);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode('EVALUACIÓN  PERSONAL '),0);
	$pdf->SetX(20);
    $pdf->ln(2);
    $pdf->SetFont('Arial','',12);
	$pdf->ln(2);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode('Valores y cualidades: '),0);
	$pdf->SetX(20);
    $pdf->ln(2);
    $pdf->SetFont('Arial','',12);
	$pdf->ln(2);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode('Comunicación: '.$row['comunicacion'].' '),0);
	$pdf->SetX(20);
	$pdf->ln(2);
	$pdf->ln(2);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode('Puntualidad: '.$row['puntualidad'].' '),0);
	$pdf->SetX(20);
	$pdf->ln(2);
	$pdf->ln(2);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode('Responsabilidad: '.$row['responsabilidad'].' '),0);
	$pdf->SetX(20);
	$pdf->ln(2);
	$pdf->ln(2);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode('Creatividad: '.$row['creatividad'].' '),0);
	$pdf->SetX(20);
	$pdf->ln(2);
	$pdf->ln(2);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode('Presentación: '.$row['presentacion'].' '),0);
	$pdf->SetX(20);
	$pdf->ln(2);
	$pdf->ln(2);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode('Atención al Cliente: '.$row['atencion_cliente'].' '),0);
	$pdf->SetX(20);
	$pdf->ln(10);
	
	
	
	
	

	$pdf->SetFont('Arial','BU',12);
	$pdf->ln(2);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode('COMPETENCIAS/CAPACIDADES OBSERVADAS '),0);
	$pdf->SetX(20);
    $pdf->ln(2);
    $pdf->SetFont('Arial','',12);
	$pdf->ln(2);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode('Colaborativo: '.$row['colaborativo'].' '),0);
	$pdf->SetX(20);
	$pdf->ln(2);
	$pdf->ln(2);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode('Trabajo en Equipo: '.$row['trabajo_equipo'].' '),0);
	$pdf->SetX(20);
	$pdf->ln(2);
	$pdf->ln(2);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode('Proactivo con Inciativa: '.$row['proactivo_iniciativa'].' '),0);
	$pdf->SetX(20);
	$pdf->ln(2);
	$pdf->ln(2);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode('Relaciones Interpersonales: '.$row['relacion_interpersonal'].' '),0);
	$pdf->SetX(20);
	$pdf->ln(2);
	$pdf->ln(2);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode('Análisis de Sistemas: '.$row['analisis_sistema'].' '),0);
	$pdf->SetX(20);
	$pdf->ln(2);
	$pdf->ln(2);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode('Diseño de Aplicaciones: '.$row['diseno_aplicacion'].' '),0);
	$pdf->SetX(20);
	$pdf->ln(2);
	$pdf->ln(2);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode('Programador de Aplicaciones: '.$row['programador_aplicacion'].' '),0);
	$pdf->SetX(20);
	$pdf->ln(2);
	$pdf->ln(2);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode('Mantenimiento de Aplicaciones: '.$row['mantenimiento_aplicacion'].' '),0);
	$pdf->SetX(20);
	$pdf->ln(2);
	$pdf->ln(2);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode('Aspectos de Auditoria en Sistemas: '.$row['aspecto_auditoria'].' '),0);
	$pdf->SetX(20);
	$pdf->ln(2);
	$pdf->ln(2);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode('Aspectos de Seguridad Informática:: '.$row['aspecto_seguridad'].' '),0);
	$pdf->SetX(20);
	$pdf->ln(2);
	$pdf->ln(6);
	
   

	
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode('Observaciones que crea pertinentes: '.$row['comentario_evaluacion'].' '),0);
	$pdf->SetX(20);
    $pdf->ln(2);
	$pdf->ln(2);
	
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode('¿Solicitaría nuevamente uno de nuestros estudiantes para práctica profesional supervisada en su empresa?: '.$row['solicitar_practicante'].' '),0);
	$pdf->SetX(20);
	$pdf->ln(2);
	$pdf->ln(2);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode('Nombre completo del representante de la carrera de inform�tica que se le ha contactado: '.$row['nombre_representante'].' '),0);
	$pdf->SetX(20);
    $pdf->ln(2);
	$pdf->ln(2);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode('Lugar: '.$row['lugar'].' '),0);
	$pdf->SetX(20);
	$pdf->ln(2);
	$pdf->ln(2);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode('Fecha: '.$row['fecha'].' '),0);
	$pdf->SetX(20);
	$pdf->ln();
	
    
    

	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','I',12);
	$pdf->SetX(20);
	$pdf->SetX(20);


	$pdf->ln();
	$pdf->SetFont('Arial','I',10);
	$pdf->SetX(20);
    $pdf->multicell(0,5,utf8_decode('Comité de Vinculación Universidad Sociedad'),0,1,'C');
	$pdf->SetX(20);
    $pdf->multicell(0,5,utf8_decode('Práctica Profesional Supervisada'),0,1,'C');
	$pdf->Output();
	
	
	$pdf->Output();

		}

?>
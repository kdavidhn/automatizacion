<?php 

	 session_start();

require 'fpdf/fpdf.php';
require_once ('../clases/Conexion.php');
$id_persona=$_GET["id"];
$sql = "SELECT 
p.documento, p.nombre, 
ep.nombre_empresa, ep.jefe_inmediato, ep.titulo_jefe_inmediato, ep.correo_jefe_inmediato, ep.telefono_jefe_inmediato,
ca.comentario_evaluacion, ca.area_refuerzo, ca.calificacion_global, ca.solicitar_practicante, ca.oportunidad_empleo, ca.nombre_representante, ca.lugar, ca.fecha,
dp.asistencia_practicante, dp.horario_practicante, dp.adaptacion_practicante, dp.cumplimiento_practicante, dp.calidad_trabajo_practicante, dp.percepcion_conocimiento, dp.percepcion_habilidades, ep.labora_dentro
FROM 
tbl_personas p, tbl_empresas_practica ep, tbl_comentarios_alumnos ca, tbl_desempeno_practica dp where p.id_persona='$id_persona' and ca.numero_visita='Segunda Supervisión' and dp.numero_visita='Segunda Supervisión' and  ep.id_persona='$id_persona' and ca.id_persona='$id_persona' and dp.id_persona='$id_persona' ";

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
			echo '<script>alert("La segunda supervisión para este alumno aún no ha sido generada.");window.location.href="../vistas/supervisiones_realizadas_vista.php";</script>';
		}
		else
		{

	$pdf = new PDF();
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont('Arial','B',15);
	$pdf->cell(0,6,utf8_decode('Universidad Nacional Autónoma de Honduras'),0,1,'C');
	$pdf->ln(2);
	$pdf->cell(0,6,utf8_decode('Facultad de Ciencias Económicas'),0,1,'C');
	$pdf->ln(2);
	$pdf->cell(0,6,utf8_decode('Departamento de Informática Administrativa'),0,1,'C');
	$pdf->ln();
	$pdf->SetFont('Arial','B',15);
	$pdf->cell(0,6,utf8_decode(''),0,1,'C');
	$pdf->ln(2);
	$pdf->SetFont('Arial','', 10);
	$pdf->ln(5);
    $pdf->Cell(0,5,utf8_decode('SEGUNDA SUPERVISIÓN'),0,1,'C');
    $pdf->ln(10);
    
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

    $pdf->ln(2);
	$pdf->ln(2);

	$pdf->SetFont('Arial','BU',12);
	$pdf->ln(2);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode('EVALUACIÓN DEL DESEMPEÑO '),0);
	$pdf->SetX(20);
    $pdf->ln(2);
    $pdf->SetFont('Arial','',12);
	$pdf->ln(2);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode('Aspectos relevantes: '),0);
	$pdf->SetX(20);
    $pdf->ln(2);
    $pdf->SetFont('Arial','',12);
	$pdf->ln(2);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode('1.	La asistencia del practicante durante el periodo de práctica a su lugar de trabajo fue: '.$row['asistencia_practicante'].' '),0);
	$pdf->SetX(20);
    $pdf->ln(2);
	$pdf->ln(2);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode('2.	Los horarios establecidos por la empresa para el practicante fueron cumplidos en forma: '.$row['horario_practicante'].' '),0);
	$pdf->SetX(20);
    $pdf->ln(2);
	$pdf->ln(2);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode('3.	La adaptación del practicante al equipo de trabajo asignado y al medio ambiente laboral fue: '.$row['adaptacion_practicante'].' '),0);
	$pdf->SetX(20);
    $pdf->ln(2);
	$pdf->ln(2);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode('4.	El grado de cumplimiento de las tareas encomendadas al practicante fue: '.$row['cumplimiento_practicante'].' '),0);
	$pdf->SetX(20);
    $pdf->ln(2);
	$pdf->ln(2);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode('5.	La calidad del trabajo desarrollado por el practicante fue: '.$row['calidad_trabajo_practicante'].' '),0);
	$pdf->SetX(20);
    $pdf->ln(2);
	$pdf->ln(2);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode('6.	Su percepción  respecto a la preparación del alumno en términos de conocimientos para realizar su trabajo de práctica fue: '.$row['percepcion_conocimiento'].' '),0);
	$pdf->SetX(20);
    $pdf->ln(2);
	$pdf->ln(2);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode('7.	Su percepción respecto a la preparación del alumno en términos de habilidades para realizar su trabajo de práctica fue: '.$row['percepcion_habilidades'].' '),0);
	$pdf->SetX(20);
	$pdf->ln(2);
	$pdf->ln(2);
	$pdf->ln(2);
	$pdf->ln(2);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode('Comentarios sobre la evaluación del desempeño: '.$row['comentario_evaluacion'].' '),0);
	$pdf->SetX(20);
    $pdf->ln(2);
	$pdf->ln(10);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode('Por favor anotar ¿Cuales áreas cree usted que debe reforzar o adquirir nuevos conocimientos?	: '.$row['area_refuerzo'].' '),0);
	$pdf->SetX(20);
    $pdf->ln(2);
	$pdf->ln(2);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode('Calificación: '.$row['calificacion_global'].' '),0);
	$pdf->SetX(20);
    $pdf->ln(2);
	$pdf->ln(2);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode('¿Solicitaría nuevamente uno de nuestros estudiantes para práctica profesional supervisada en su empresa? :'.$row['solicitar_practicante'].' '),0);
	$pdf->SetX(20);
    $pdf->ln(2);
	$pdf->ln(2);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode('Nombre completo del representante de la carrera de informática que se le ha contactado: '.$row['nombre_representante'].' '),0);
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
    $pdf->ln(2);
	$pdf->ln(150);
	
    
    

	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','I',12);
	$pdf->SetX(20);
	$pdf->SetX(20);


	$pdf->ln(30);
	$pdf->SetFont('Arial','I',10);
	$pdf->SetX(20);
    $pdf->multicell(0,5,utf8_decode('Comité de Vinculación Universidad Sociedad'),0,1,'C');
	$pdf->SetX(20);
    $pdf->multicell(0,5,utf8_decode('Práctica Profesional Supervisada'),0,1,'C');
	$pdf->Output();
	
	$pdf->Output();

		}

?>
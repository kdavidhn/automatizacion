<?php 

	 session_start();

require 'fpdf/fpdf.php';
require_once ('../clases/Conexion.php');


  $_SESSION["id_persona"]= $_GET['id_persona_']; 




$sql = "select count(aa.id_persona) as cantidad_clase, (( count(aa.id_persona))*100)/52 as porcentaje_clase ,concat(p.nombres,' ',p.apellidos) as estudiante, px.valor as cuenta
from tbl_asignaturas_aprobadas aa, tbl_personas p, tbl_personas_extendidas px where px.id_atributo=12 and px.id_persona=p.id_persona and p.id_persona=aa.id_persona and aa.id_persona=$_SESSION[id_persona] GROUP BY px.valor ";





class PDF extends FPDF
	{
		function Header()
		{
			//date_default_timezone_get('America/Tegucigalpa');
		$this->Image('../dist/img/logo_ia.jpg', 12,8,30);
			$this->Ln(5);
						$this->Ln(5);

						$this->Image('../dist/img/logo-unah.jpg', 172,8, 22 );
		}
	

}
//date_default_timezone_get('America/Tegucigalpa');

function fechaCastellano ($fecha) {
  $fecha = substr($fecha, 0, 10);
  $numeroDia = date('d', strtotime($fecha));
  $mes = date('F', strtotime($fecha));
  $anio = date('Y', strtotime($fecha));
$meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
  $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
  $nombreMes = str_replace($meses_EN, $meses_ES, $mes);
  return $numeroDia." de ".$nombreMes." de ".$anio;
}

$fecha=date("Y-m-d H:i:s");



	$resultado = mysqli_query($connection, $sql);
	$row = mysqli_fetch_array($resultado);

	$pdf = new PDF();
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont('Arial','B',15);

	$pdf->cell(0,6,utf8_decode('Universidad Nacional Autonoma de Honduras'),0,1,'C');
	$pdf->ln(2);
	$pdf->cell(0,6,utf8_decode('Facultad de Ciencias Economicas'),0,1,'C');
	$pdf->ln(2);
	$pdf->cell(0,6,utf8_decode('Departamento de Informatica Administrativa'),0,1,'C');
	$pdf->ln(5);
	$pdf->SetFont('Arial','',12);
    $pdf->ln(5);

	$pdf->ln(5);
	$pdf->ln(5);
	

	$pdf->Cell(0,5,utf8_decode('CONSTANCIA '),0,1,'C');
	$pdf->ln(5);
	$pdf->ln(5);



	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','I',12);
	$pdf->ln(5);
	$pdf->ln(5);
	$pdf->ln(5);

	$pdf->SetX(20);
    $pdf->multicell(170,9,utf8_decode('La Suscrita Coordinadora de la Carrera de Informática Administrativa de la UNAH, por este medio hace constar Que: '.$row['estudiante'].' con número de cuenta '.$row['cuenta'].' ha aprobado un total de: ('.$row['cantidad_clase'].')  asignaturas  lo  cual  totaliza  un  '.$row['porcentaje_clase'].'%   del Plan  de   Estudios  de la Licenciatura en Informática. '),0);
	$pdf->ln(5);
	$pdf->SetX(20);
    $pdf->multicell(170,9,utf8_decode('Y  para   efectos   de   realizar   su   Práctica   Profesional   Supervisada   firmo   la presente en la Ciudad Universitaria "José Trinidad Reyes" el '.fechaCastellano($fecha).'. '),0);
	$pdf->ln(5);
	$pdf->SetX(20);



    $pdf->ln(60);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(60,5,utf8_decode(''),0,0,'C');
	$pdf->Cell(70,5,utf8_decode('Coordinador Carrera Informática Administrativa'),'T',0,'C');


	$pdf->Output();

?>
<?php 
require 'fpdf/fpdf.php';
require_once ('../clases/Conexion.php');

$jornada="";
if(!empty($_GET)) {
	$jornada=$_GET['control'];


}

$sql = "select DISTINCTROW px.valor, concat(p.nombres,' ',p.apellidos) as nombre, cp.no_constancia, cp.jornada as jornada from tbl_personas p,tbl_personas_extendidas px, tbl_charla_practica cp WHERE p.id_persona=cp.id_persona and cp.jornada='$jornada' and px.id_atributo=12 and px.id_persona=cp.id_persona";

class PDF extends FPDF
	{
		function Header()
		{
			//date_default_timezone_get('America/Tegucigalpa');
			$this->Image('../dist/img/logo_ia.jpg', 10,8,37);
			$this->Ln(5);
						$this->Image('../dist/img/logo-unah.jpg', 245, 8, 25 );


		}
function Footer()
		{
			$this->SetY(-15);
			$this->SetFont('Arial','I', 8);
			$this->Cell(0,10, 'Pagina '.$this->PageNo().'/{nb}',0,0,'C' );
		}	

}
//date_default_timezone_get('America/Tegucigalpa');
$fecha_actual=date("Y-m-d H:i:s");

	
	$pdf = new PDF('L','mm','Letter');
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont('Arial','B',15);
	$pdf->cell(0,6,utf8_decode('Universidad Nacional Autonoma de Honduras'),0,1,'C');
	$pdf->ln(2);
	$pdf->cell(0,6,utf8_decode('Facultad de Ciencias Economicas'),0,1,'C');
	$pdf->ln(2);
	$pdf->cell(0,6,utf8_decode('Departamento de Informatica Administrativa'),0,1,'C');
	$pdf->ln(7);
	$pdf->SetFont('Arial','B',15);
	$pdf->cell(0,6,utf8_decode('Listado de asistencia a Charla de Practica'),0,1,'C');
	$pdf->ln(5);
	$pdf->SetFont('Arial','',12);
	$pdf->SetX(30);	
	$pdf->multicell(170,5,utf8_decode('FECHA: '.$fecha_actual.'.'),0);
	$pdf->ln(5);
	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','I',12);
	$pdf->SetX(30);
	$pdf->Cell(85,6,'NOMBRE',1,0,'C',1);
	$pdf->Cell(40,6,'CUENTA',1,0,'C',1);
	$pdf->Cell(40,6,'NO. CONSTANCIA',1,0,'C',1);
	$pdf->Cell(60,6,'FIRMA',1,1,'C',1);

	$pdf->SetFont('Arial','',10);
	

	$resultado = mysqli_query($connection, $sql);
	while($row = $resultado->fetch_assoc())
	{
        $pdf->SetX(30);
		$pdf->Cell(85,6,utf8_decode(strtoupper($row['nombre'])),1,0,'T');
		$pdf->Cell(40,6,utf8_decode($row['valor']),1,0,'C');
		$pdf->Cell(40,6,utf8_decode($row['no_constancia']),1,0,'C');
		$pdf->Cell(60,6,utf8_decode(''),1,1,'L');
		
	}

	$pdf->ln(30);
	$pdf->SetFont('Arial','I',10);
	$pdf->Cell(90,5,utf8_decode(''),0,0,'C');
	$pdf->Cell(90,5,utf8_decode('FIRMA Y NOMBRE DEL ENCARGADO '),'T',0,'C');

	$pdf->Output();

?>

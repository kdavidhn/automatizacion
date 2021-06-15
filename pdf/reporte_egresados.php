<?php 
require 'fpdf/fpdf.php';
require_once ('../clases/Conexion.php');



$sql =  json_decode( file_get_contents('http://localhost:80/Automatizacion/api/egresados_api.php'), true );

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
	$pdf->cell(0,6,utf8_decode('Listado de Egresados Existentes'),0,1,'C');
	$pdf->ln(5);
	$pdf->SetFont('Arial','',12);
	$pdf->SetX(30);	
	$pdf->multicell(170,5,utf8_decode('FECHA: '.$fecha_actual.'.'),0);
	$pdf->ln(5);
	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','I',12);
	$pdf->SetX(30);
	$pdf->Cell(60,6,'NOMBRE',1,0,'C',1);
	$pdf->Cell(40,6,'TELEFONO',1,0,'C',1);
	$pdf->Cell(30,6,'CELULAR',1,0,'C',1);
	$pdf->Cell(70,6,'CORREO ELCTRONICO',1,1,'C',1);
	
	$pdf->SetFont('Arial','',10);
	


   $counter = 0;
	  while ($counter< count($sql["ROWS"])) 
	{
		$pdf->SetX(30);
		$pdf->Cell(60,6,utf8_decode($sql["ROWS"][$counter]["nombre"]),1,0,'L');
       	$pdf->Cell(40,6,utf8_decode($sql["ROWS"][$counter]["telefono_egresado"]),1,0,'L');//el 0 fue el  cambio
		$pdf->Cell(30,6,utf8_decode($sql["ROWS"][$counter]["celular_egresado"]),1,0,'L');
		$pdf->Cell(70,6,utf8_decode($sql["ROWS"][$counter]["correo_electronico"]),1,1,'L');


			 $counter = $counter + 1; 
	}

	$pdf->ln(30);
	$pdf->SetFont('Arial','I',10);
	$pdf->Cell(90,5,utf8_decode(''),0,0,'C');
	$pdf->Cell(90,5,utf8_decode('FIRMA Y NOMBRE DEL ENCARGADO '),'T',0,'C');

	$pdf->Output();

?>

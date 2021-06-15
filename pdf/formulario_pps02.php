<?php 

	 session_start();

require 'fpdf/fpdf.php';
require_once ('../clases/Conexion.php');
$usuario=$_SESSION['id_usuario'];
 $id=("select id_persona from tbl_usuarios where id_usuario='$usuario'");
$result= mysqli_fetch_assoc($mysqli->query($id));
$id_persona=$result['id_persona'];

$sql = "select concat(p.nombres,' ',p.apellidos) as nombre, px.valor from tbl_personas p, tbl_personas_extendidas px where px.id_persona='$id_persona' and p.id_persona='$id_persona'";


class PDF extends FPDF
	{
		function Header()
		{
			//date_default_timezone_get('America/Tegucigalpa');
		$this->Image('../dist/img/logo_ia.jpg', 12,8,30);
			$this->Image('../dist/img/logo-unah.jpg', 172,8, 22 );


		}
function Footer()
		{
			$fecha_actual=date("Y-m-d H:i:s");
			$this->SetY(-15);
			$this->SetFont('Arial','I', 8);
		}	

}
//date_default_timezone_get('America/Tegucigalpa');

$resultado = mysqli_query($connection, $sql);
	$row = mysqli_fetch_array($resultado);

	

	$pdf = new PDF();
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont('Arial','B',15);
	$pdf->cell(0,6,utf8_decode('Universidad Nacional Autónoma de Honduras'),0,1,'C');
	$pdf->ln(2);
	$pdf->cell(0,6,utf8_decode('Facultad de Ciencias Economicas'),0,1,'C');
	$pdf->ln(2);
	$pdf->cell(0,6,utf8_decode('Departamento de Informática Administrativa'),0,1,'C');
	$pdf->ln();
	$pdf->SetFont('Arial','BU',15);
	$pdf->cell(0,6,utf8_decode('Solicitud Para Realizar Práctica Pprofesional Supervisada'),0,1,'C');
	$pdf->ln(2);
	$pdf->SetFont('Arial','', 10);
	$pdf->ln(5);
	$pdf->Cell(0,5,utf8_decode('IA-PPS-02'),0,1,'C');
	
	
	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','B',12);
	$pdf->ln(10);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode('Señores Comité Práctica Profesional '),0);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode('Carrera de Informática Administrativa '),0);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode('Presente. '),0);
	$pdf->SetX(20);
	$pdf->ln(2);
    

    
	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','I',12);
	$pdf->ln(5);
	$pdf->SetX(20);
    $pdf->multicell(170,9,utf8_decode('Estimados Señores: '),0);
	$pdf->ln(5);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode('Yo '.$row['nombre'].' estudiante de la Carrera de Informática Administrativa, con número de cuenta '.$row['valor'].'  respetuosamente comparezco ante usted solicitando se me autorice realizar mi Práctica Profesional Supervisada en:  '),0);
	$pdf->ln(5);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode('El Departamento de Informática Administrativa de la UNAH. '),0);
	$pdf->ln(5);
	$pdf->SetX(20);




	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','B',12);
	$pdf->ln(2);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode('Tengo claro y entendido que no puedo empezar a realizar la Práctica Profesional hasta que sea aprobada formalmente y por escrito (email) de parte del Comité de Vinculación Universidad Sociedad. '),0);
	$pdf->SetX(20);
	$pdf->ln(2);

	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','I',12);
	$pdf->ln(5);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode('Tegucigalpa MDC '.date('d-m-Y')),0);
	$pdf->ln(5);
	$pdf->SetX(20);


	$pdf->ln(40);
	$pdf->SetFont('Arial','I',10);
	$pdf->SetX(20);
    $pdf->multicell(0,5,utf8_decode('Comité de Vinculación Universidad Sociedad'),0,1,'C');
	$pdf->SetX(20);
    $pdf->multicell(0,5,utf8_decode('Práctica Profesional Supervisada'),0,1,'C');
	$pdf->Output();
	





	$pdf->Output();

?>
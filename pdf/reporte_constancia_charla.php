<?php 

	 session_start();

require 'fpdf/fpdf.php';
require_once ('../clases/Conexion.php');



$usuario=$_SESSION['id_usuario'];
        $id=("select id_persona from tbl_usuarios where id_usuario='$usuario'");
       $result= mysqli_fetch_assoc($mysqli->query($id));
       $id_persona=$result['id_persona'];
/* Manda a llamar todos las datos de la tabla para llenar el gridview  */
$sqltabla="select concat(p.nombres,'',p.apellidos)AS nombre, px.valor , cp.no_constancia, cp.fecha_valida , cp.fecha_recibida , cp.jornada as jornada from tbl_personas p, tbl_charla_practica cp, tbl_personas_extendidas px where p.id_persona=cp.id_persona and cp.estado_asistencia_charla=1 and p.id_persona='$id_persona' AND px.id_atributo=12 and px.id_persona='$id_persona'";


class PDF extends FPDF
	{
		function Header()
		{
			//date_default_timezone_get('America/Tegucigalpa');
		$this->Image('../dist/img/logo_ia.jpg', 15,8,37);
			$this->Ln(5);
						$this->Image('../dist/img/logo-unah.jpg', 240, 8, 25 );
		}
function Footer()
		{


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

			$this->SetY(-15);
			$this->SetFont('Arial','I', 8);
			$this->Cell(0,10, ''.fechaCastellano($fecha).'',0,0,'C' );
		}	

}
//date_default_timezone_get('America/Tegucigalpa');


	$resultado = mysqli_query($connection, $sqltabla);
	$row = mysqli_fetch_array($resultado);


   if ($row['jornada']=="MATUTINA") {

      $sqlimpartida="select valor from tbl_parametros where parametro='DOCENTE_VINCULACION_MATUTINA_1'";
         //Obtener la fila del query
        $Impartida = mysqli_fetch_assoc($mysqli->query($sqlimpartida)); 
                $sqlimpartida2="select valor from tbl_parametros where Parametro='DOCENTE_VINCULACION_MATUTINA_2'";
                $Impartida2 = mysqli_fetch_assoc($mysqli->query($sqlimpartida2));  
 //Obtener la fila del query
    }
    else
    {
        $sqlimpartida="select valor from tbl_parametros where parametro='DOCENTE_VINCULACION_VESPERTINA_1'";
         //Obtener la fila del query
        $Impartida = mysqli_fetch_assoc($mysqli->query($sqlimpartida)); 
                $sqlimpartida2="select valor from tbl_parametros where Parametro='DOCENTE_VINCULACION_VESPERTINA_2'";
                $Impartida2 = mysqli_fetch_assoc($mysqli->query($sqlimpartida2));  
 
}

$_SESSION['impartida']=$Impartida["valor"] . " /".$Impartida2["valor"];



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
	$pdf->cell(0,6,utf8_decode('Constancia de Asistencia de charla previa a PPS'),0,1,'C');
	$pdf->ln(5);
	$pdf->SetFont('Arial','',12);
    $pdf->ln(5);

	$pdf->ln(5);
	$pdf->Cell(0,5,utf8_decode('CONSTANCIA N° '.$row['no_constancia'].'.'),0,1,'C');



	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','I',12);
	$pdf->ln(5);
	$pdf->ln(5);
	$pdf->ln(5);

	$pdf->SetX(20);
    $pdf->multicell(170,5,utf8_decode('Por este medio hacemos constar que el (la)estudiante: '),0);
	$pdf->ln(5);
	$pdf->SetX(20);
    $pdf->multicell(170,5,utf8_decode('Cuenta: '.$row['valor'].'. '),0);
	$pdf->ln(5);
	$pdf->SetX(20);
    $pdf->multicell(170,5,utf8_decode('Nombre: '.$row['nombre'].'. '),0);
	$pdf->ln(5);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode('Ha cumplido con el requisito de recibir la charla de Orientacion a Practica Profesional, '),0);
	$pdf->ln(5);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode('En la fecha: '.$row['fecha_recibida'].'        Valida hasta: '.$row['fecha_valida'].''),0);
    $pdf->ln(5);
    $pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode('Impartida por  '.$_SESSION['impartida'].'.'),0);



	


	$pdf->ln(40);
	$pdf->SetFont('Arial','I',10);
	$pdf->SetX(20);
    $pdf->multicell(0,5,utf8_decode('Comité de Vinculación Universidad Sociedad'),0,1,'C');
	$pdf->SetX(20);
    $pdf->multicell(0,5,utf8_decode('Práctica Profesional Supervisada'),0,1,'C');
	$pdf->Output();

?>
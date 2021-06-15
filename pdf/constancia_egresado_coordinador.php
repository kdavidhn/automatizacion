<?php
require('fpdf/fpdf.php');
session_start();
class PDF extends FPDF
{
// Cabecera de página
function Header()
{
   
    // Arial bold 15
    $this->SetFont('Arial','B',18);
    // Movernos a la derecha
   
    // Salto de línea
    $this->Ln(50);
}

// Pie de página
function Footer()
{
    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Número de página
    
}
}

require_once ('../clases/Conexion.php');
$cuenta= $_GET['cuenta'];

$consulta = "SELECT * FROM tbl_personas WHERE documento='$cuenta'";
$resultado = $mysqli->query($consulta);
$row = $resultado->fetch_assoc();
$monthNum  = date("m");

switch($monthNum)
{   
    case 1:
    $monthNameSpanish = "Enero";
    break;

    case 2:
    $monthNameSpanish = "Febrero";
    break;

    case 3:
    $monthNameSpanish = "Marzo";
    break;

    case 4:
        $monthNameSpanish = "Abril";
        break;

    case 5:
    $monthNameSpanish = "Mayo";
    break;
    case 6:
    $monthNameSpanish = "Junio";
    break;
    case 7:
    $monthNameSpanish = "Julio";
    break;
    case 8:
    $monthNameSpanish = "Agosto";
    break;
    case 9:
    $monthNameSpanish = "Septiembre";
    break;
    case 10:
    $monthNameSpanish = "Octubre";
    break;
    case 11:
    $monthNameSpanish = "Noviembre";
    break;
    case 12:
    $monthNameSpanish = "Diciembre";
    break;
}

$nombre= $row['nombre'];


$pdf = new PDF();
$pdf->AddPage('portraid','letter');//*horientacion,tamaño y se le puede agregar una rotacion
$pdf->SetFont('Arial','U',16);//tipo de letra,estilo(b negrita,u subrayado) y tamaño
$pdf->Cell(0,0,'CONSTANCIA DE EGRESADO DEL COORDINADOR',0,0,'C',0);
$pdf->Ln(20);
$pdf->SetFont('Arial','',11);
$pdf->SetMargins(30, 25 , 30); 
$pdf->Ln(5);
$pdf->MultiCell(160,4,utf8_decode("El Suscrito Coordinador (a) de la Carrera de Informática Administrativa, hace constar que el (a) joven ''".ucwords($nombre)."'', con número de cuenta ".$row['documento'].", matriculado(a) en la carrera de Informatica Administrativa a la fecha ha aprobado un total de XX asignaturas del Plan de Estudios, haciendo un total de  en letras (XX en números) unidades valorativas, contemplando el 100% del plan de estudio correspondiente.

Por tanto, se autoriza a la Secretaría Académica de esta Facultad, emitir la carta de egresado.

Dado en la Ciudad Universitaria a los ".date("d")." días del mes de ".$monthNameSpanish." del ".date("Y").".
"));
$pdf->Ln(80);
$pdf->Cell(0,0,'_____________________________',0,0,'C',0);
$pdf->Ln(5);
$pdf->Cell(0,0,"Msc. ".$_SESSION["usuario"]." ",0,0,'C',0);
$pdf->Ln(5);
$pdf->Cell(0,0,utf8_decode('Coordinador de la Carrera de Informática Administrativa'),0,0,'C',0);
$pdf->Ln(5);
$pdf->Cell(0,0,utf8_decode('Facultad de Ciencias Económicas'),0,0,'C',0);
$pdf->Ln(5);
$pdf->Cell(0,0,utf8_decode('Administrativas y Contables'),0,0,'C',0);

$pdf->AddPage('portraid','letter');//*horientacion,tamaño y se le puede agregar una rotacion
$pdf->SetFont('Arial','U',14);//tipo de letra,estilo(b negrita,u subrayado) y tamaño
$pdf->Cell(0,0,'CONSTANCIA DE EGRESADO',0,0,'C',0);
$pdf->Ln(20);
$pdf->SetFont('Arial','',11);
$pdf->MultiCell(160,4,utf8_decode("La suscrita Secretaria de la Facultad de Ciencias Económicas, Administrativa y Contable, de la Universidad Nacional Autónoma de Honduras (UNAH), por este medio hace constar que: el alumno (a) ".ucwords($nombre)." matriculado (a) en la carrera de Informática Administrativa, en el periodo XX- XX, con número de cuenta ".$row['documento'].", ha completado todas sus asignatura y unidades valorativas del plan de estudio correspondiente. Por lo tanto, se le extiende la presente Constancia de Egresado, de conformidad a la solicitud presentada a esta secretaria por el (a) Master XX, Coordinador de la carrera de Informática Administrativa.

Dado en la ciudad universitaria a los ".date("d")." días del mes de ".$monthNameSpanish." del ".date("Y").". Dicha constancia tiene una vigencia de seis (6) meses.
"));
$pdf->Ln(80);
$pdf->Cell(0,0,'_____________________________',0,0,'C',0);
$pdf->Ln(5);
$pdf->Cell(0,0,'Msc. Marcela Rivera Alvarado ',0,0,'C',0);
$pdf->Ln(5);
$pdf->Cell(0,0,utf8_decode('Secretaria Académica'),0,0,'C',0);
$pdf->Ln(5);
$pdf->Cell(0,0,utf8_decode('Facultad de Ciencias Económicas Administrativas'),0,0,'C',0);
$pdf->Ln(5);
$pdf->Cell(0,0,utf8_decode('y Contables'),0,0,'C',0);

$pdf->Output();

?>
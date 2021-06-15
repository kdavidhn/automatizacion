<?php
require('fpdf/fpdf.php');

class PDF extends FPDF
{
// Cabecera de página
function Header()
{
   
    // Arial bold 15
    $this->SetFont('Arial','B',18);
    // Movernos a la derecha
    //$this->Image('imagenes/logounah.png',0,10,50,'','png');//recibe(ruta,posicionx,posiciony,alto,ancho,tipo,link)
    $this->Cell(80);
    // Título
   // $this->Cell(30,10,'UNAH',0,0,'C');
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
    $this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');//recibe ancho,alto,texto,borde,alineacion,rellenar,link
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

$nombre=$row['nombre'];



$pdf = new PDF();
$pdf -> AliasNbPages();
$pdf->AddPage('portraid','letter');//*horientacion,tamaño y se le puede agregar una rotacion
$pdf->SetFont('Arial','U',14);//tipo de letra,estilo(b negrita,u subrayado) y tamaño
$pdf->Cell(0,0,'CONSTANCIA DEL HIMNO NACIONAL',0,0,'C',0);
$pdf->Ln(20);
$pdf->SetFont('Arial','',11);
$pdf->SetMargins(30, 25 , 30); 
$pdf->Ln(5);
$pdf->MultiCell(160,4,utf8_decode("El suscrito (a) Coordinador de la Carrera de Informática Administrativa, por este medio hace constar que el (a) joven ``".ucwords($nombre)."´´, No. de Cuenta ".$row['documento'].", estudiante de la Carrera de Informática Administrativa, realizó el examen correspondiente al HIMNO NACIONAL DE HONDURAS, y habiendo sido ``APROBADO´´ satisfactoriamente, se le extiende la presente constancia en la Ciudad Universitaria a los ".date("d")." días del mes de ".$monthNameSpanish." del ".date("Y").""),0,'J',0);
$pdf->Ln(80);
$pdf->Cell(0,0,'_____________________________',0,0,'C',0);
$pdf->Ln(5);
$pdf->Cell(0,0,'MSC. XX',0,0,'C',0);
$pdf->Ln(5);
$pdf->Cell(0,0,utf8_decode('Coordinador de la Carrera de Informática Administrativa'),0,0,'C',0);
$pdf->Ln(5);
$pdf->Cell(0,0,utf8_decode('Facultad de Ciencias Económicas'),0,0,'C',0);
$pdf->Ln(5);
$pdf->Cell(0,0,utf8_decode('Administrativas y Contables '),0,0,'C',0);
$pdf->Output();

?>
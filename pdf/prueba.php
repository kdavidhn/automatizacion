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
    $this->Image('imagenes/logounah.png',0,10,50,'','png');//recibe(ruta,posicionx,posiciony,alto,ancho,tipo,link)
    $this->Cell(80);
    // Título
    $this->Cell(30,10,'UNAH',0,0,'C');
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

require'cn.php';

$consulta = "SELECT nombre,apellido,correo,cuenta FROM usuarios WHERE id=7";
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





$pdf = new PDF();
$pdf -> AliasNbPages();
$pdf->AddPage('portraid','letter');//*horientacion,tamaño y se le puede agregar una rotacion
$pdf->SetFont('Arial','U',16);//tipo de letra,estilo(b negrita,u subrayado) y tamaño
$pdf->Cell(0,0,'CONSTANCIA DE BUENA CONDUCTA',0,0,'C',0);
$pdf->Ln(20);
$pdf->SetFont('Arial','',11);
$pdf->write(5,utf8_decode("Por medio de la presente hago constar que el (a) joven ".$row['nombre']." con número de identidad xx y número de cuenta ".$row['cuenta']." es estudiante de la carrera de Informatica Administrativa en la Universidad Nacional Autónoma de Honduras desde el año xx con un índice académico de xx % el cual en su trayectoria estudiantil ha tenido un comportamiento con MUY BUENA CONDUCTA.  
Y para los fines que el interesado convenga se extiende la presente a los ".date("d")." días del mes de ".$monthNameSpanish." del ".date("Y").".
"));
$pdf->Ln(80);
$pdf->Cell(0,0,'Msc. Xx ',0,0,'C',0);
$pdf->Ln(5);
$pdf->Cell(0,0,utf8_decode('Coordinador de la Carrera de Informática Administrativa'),0,0,'C',0);
$pdf->Ln(5);
$pdf->Cell(0,0,utf8_decode('Facultad de Ciencias Económicas'),0,0,'C',0);
$pdf->Ln(5);
$pdf->Cell(0,0,utf8_decode('Administrativas y Contables'),0,0,'C',0);
$pdf->Output();

?>
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


$pdf = new PDF();
$pdf -> AliasNbPages();
$pdf->AddPage('portraid','letter');//*horientacion,tamaño y se le puede agregar una rotacion
$pdf->SetFont('Arial','U',16);//tipo de letra,estilo(b negrita,u subrayado) y tamaño
$pdf->Cell(0,0,'Cambio de Carrera',0,0,'C',0);
$pdf->Ln(20);
$pdf->SetFont('Arial','',11);
$pdf->SetMargins(30, 25 , 30); 
$pdf->Ln(5);
$pdf->MultiCell(160,4,utf8_decode("REQUISITOS:

1.Índice no menor de 70%.
2.Haber cursado tres periodos académicos consecutivos.
3.Haber cursado como mínimo ocho asignaturas.

DOCUMENTACIÓN A ADJUNTAR:

1.Historial académico vigente.
2.Constancia extendida por la Vicerrectoría de Orientación y Asuntos estudiantiles [VOAE],     de haber realizado la Prueba de Orientación Profesional (Tiene vigencia de un año).
3.Copia de la tarjeta de identidad.
4.Fotografía tamaño carné.
5.Copia del Carné Estudiantil.
6.Constancia de conducta de la Carrera que cursa Actualmente."));

$pdf->Output();

?>
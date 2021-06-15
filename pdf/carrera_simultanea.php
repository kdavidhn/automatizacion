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
$pdf->Cell(0,0,'Carrera Simultanea ',0,0,'C',0);
$pdf->Ln(20);
$pdf->SetFont('Arial','',11);
$pdf->SetMargins(30, 25 , 30); 
$pdf->Ln(5);
$pdf->MultiCell(160,4,utf8_decode("Procedimiento

1.Debe cumplir con los requisitos y llevar la documentación a las oficinas de la Coordinación de Carrera, ubicada en el tercer piso del Edificio C2 .

2.Llevar el dictamen de aprobación de la simultaneidad de la Carrera a las oficinas de registro (el cuál será entregado 3 días hábiles posteriores a la solicitud en la Coordinación de Carrera).

3.El Sistema de Registro notificará vía correo electrónico el dictamen de la Activación de la Segunda Carrera.

4.Verificar el Cambio de Carrera en el sistema de registro (DIPP-UNAH) www.registro.unah.edu.hn

Requisitos

1.Haber cursado el sexto periodo académico y registrando un índice académico igual o mayor a ochenta por ciento (80%) en la primera Carrera cursada.

2.Mantener un índice académico mayor o igual a setenta (70%) en ambas carreras. Si este índice no es mantenido, el estudiante continuara cursando únicamente la primera Carrera elegida.


DOCUMENTACIÓN A ADJUNTAR:

1.Solicitud.
2.Historial Académico Original.
3.Copia de la tarjeta de identidad.
4.Copia del Carné Estudiantil."));

$pdf->Output();

?>
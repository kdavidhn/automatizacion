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
$pdf->Cell(0,0,'Cancelar Clases excepcional ',0,0,'C',0);
$pdf->Ln(20);
$pdf->SetFont('Arial','',11);
$pdf->SetMargins(30, 25 , 30); 
$pdf->Ln(5);
$pdf->MultiCell(160,4,utf8_decode("1. Para realizar la solicitud habrán campos obligatorios a llenar.
2. Recuerde de adjuntar los documentos solicitados.
3. La información que brinde será utilizada para realizar el tramite correspondiente.



REQUISITOS
Normas Académicas. Artículo 223.-La Coordinación de Carrera dictaminará si la solicitud de cancelación de las asignaturas solicitadas por el estudiante en forma total o parcial de asignaturas es o no procedente, fundamentada en las siguientes causas:

a)	Enfermedades o problemas de salud incapacitantes
b)	Problemas de Transporte
c)	Calamidad Familiar(evidencias)
d)	Por separación o muerte del conyugue, padres e hijos.
e)	Por problemas de  cambios laborales

Documentos Soporte
como ser Constancia de trabajo, defunción, certificación medica
calamidad familiar con el testimonio de los padres o encargados, según sea el caso


DOCUMENTACIÓN A ADJUNTAR
Presentar ( Adjuntar)  en Digital la Siguiente Documentación:

 Solicitud indicando el motivo de la Cancelación
 Documento de soporte que justifica la cancelación
 Copia de la Forma 03
 Copia de identidad"));

$pdf->Output();

?>
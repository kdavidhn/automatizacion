<?php
require_once('../clases/conexion_mantenimientos.php');
require_once('../clases/Conexion.php');
require_once('../Reporte/pdf/fpdf.php');
$instancia_conexion = new conexion();

$falta = $_POST["pdfHtml5"];


  
class myPDF extends FPDF{
    function header(){


        date_default_timezone_set("America/Tegucigalpa");
        $fecha= date('d-m-Y H:i:s');
        // 
        $this->Cell(45);
        $this->Image('../dist/img/logo_ia.jpg', 20, 10, 25);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(276, 10, utf8_decode("UNIVERSIDAD NACIONAL AUTÓNOMA DE HONDURAS"), 0, 0, 'C');

        $this->ln();
        $this->Cell(45);

        $this->SetFont('Arial', 'B', 12);
        $this->Cell(276, 10, utf8_decode("FACULTAD DE CIENCIAS ECONÓMICAS, ADMINISTRATIVAS Y CONTABLES"), 0, 0, 'C');

        $this->ln();
        $this->Cell(45);

        $this->SetFont('Arial', 'B', 12);
        $this->Cell(276, 10, utf8_decode("DEPARTAMENTO DE INFORMÁTICA ADMINISTRATIVA"), 0, 0, 'C');
        
        $this->ln();
        $this->Cell(45);

        $this->SetFont('Arial', 'B', 12);
        $this->Cell(276, 10, utf8_decode("COMITÉ DE VIDA ESTUDIANTIL"), 0, 0, 'C');

        $this->ln();
        $this->Cell(45);
        $this->SetFont('Arial', 'B', 18);
        $this->Cell(276, 10, utf8_decode("REPORTE DE FALTAS"), 0, 0, 'C');
        $this->ln(10);
        $this->SetFont('Arial', 'B', 12);
      
       

        $this->ln(20);
        $this->SetFont('times', '', 12);
        $this->Cell(50, 10, "FECHA: ".$fecha, 0, 0, 'C');
        $this->ln(10);
        
       
        
        
    }
    function footer(){
        $this->SetY(-15);
        $this->SetFont('Arial', '', 10);
        $this->cell(0,10, utf8_decode('Página').$this->PageNo().'/{nb}',0,0,'C');
       

    }
    function headerTable(){
        global $falta;
        $this->SetFont('Times', 'B', 10);
        $this->SetLineWidth(0.2);
        
        $this->Cell(75, 7, "FECHA FALTA", 1, 0, 'C');
        // $this->Cell(23, 7, "#EMPLEADO", 1, 0, 'C');
        $this->Cell(40, 7, "TIPO FALTA", 1, 0, 'C');
        $this->Cell(90, 7, "DESCRIPCION", 1, 0, 'C');
        $this->Cell(90, 7, "ALUMNO", 1, 0, 'C');
        $this->Cell(40, 7, "CUENTA ALUMNO", 1, 0, 'C');
    

        $this->ln();

        global $instancia_conexion;
        $sql = "select * from view_faltas_conducta";
        $stmt = $instancia_conexion->ejecutarConsulta($sql);
        while ($reg = $stmt->fetch_object()) {

            $this->SetFont('Times', '', 10);
            $this->Cell(75, 7, utf8_decode($reg->fch_falta), 1, 0, 'C');
            $this->Cell(40, 7, utf8_decode($reg->nombre_falta), 1, 0, 'C');
            $this->Cell(90, 7, utf8_decode($reg->descripcion), 1, 0, 'C');
            $this->Cell(90, 7, utf8_decode($reg->nombres), 1, 0, 'C');
            $this->Cell(40, 7, utf8_decode($reg->valor), 1, 0, 'C');
            $this->ln();
        

    }
        
    }
   
   
}


$pdf = new myPDF();
$pdf->AliasNbPages();
$pdf->AddPage('C', 'Legal', 0);
$pdf->headerTable();
//$pdf->viewTable($instancia_conexion);

//$pdf->viewTable2($instancia_conexion);
$pdf->SetFont('Arial', '', 15);

$pdf->Output();

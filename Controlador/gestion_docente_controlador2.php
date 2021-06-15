<?php
require_once('../clases/conexion_mantenimientos.php');
require_once "../Modelos/gestion_docente_modelo.php";
require_once('../Reporte/pdf/fpdf2.php');
$instancia_conexion = new conexion();
 

   
class myPDF extends FPDF{
    function header(){
        // h::i::s
        date_default_timezone_set("America/Tegucigalpa");
        $fecha=date('d-m-Y h:i:s');
// $fecha=date('Y-m-d');

        global $mysqli;

        //$stmt = $instancia_conexion->query("SELECT tp.nombres FROM tbl_personas tp INNER JOIN tbl_usuarios us ON us.id_persona=tp.id_persona WHERE us.Id_usuario= 8");
        $sql = "SELECT tp.nombres FROM tbl_personas tp INNER JOIN tbl_usuarios us ON us.id_persona=tp.id_persona WHERE us.Id_usuario= 8";
        $resultado = $mysqli->query($sql);

        $this->Image('../dist/img/logo_ia.jpg', 25, 15, 30);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(400, 5, "UNIVERSIDAD NACIONAL AUTONOMA DE HONDURAS", 0, 0, 'C');
        $this->ln();
        $this->Cell(400, 10, "FACULTAD DE CIENCIAS ECONOMICAS,", 0, 0, 'C');
        $this->ln();
        $this->Cell(400, 5, "ADMINISTRATIVAS Y CONTABLES", 0, 0, 'C');
        $this->ln();
        $this->Cell(400, 10, "DEPARTAMENTO DE INFORMATICA ADMINISTRATIVA", 0, 0, 'C');
        $this->ln();
        $this->Cell(400, 10, "GESTION DOCENTE", 0, 0, 'C');
        $this->ln(20);
        $this->Cell(600, 10, "FECHA:" . $fecha, 0, 0, 'C');
        $this->ln(20);
        $this->SetFont('times', '', 12);
        // $this->Cell(45, 10, "Gestion Docente", 0, 0, 'C');
        // $this->ln(20);
        
    }
    function footer(){
        $this->SetY(-15);
        $this->SetFont('Arial', '', 10);
        $this->cell(0,10, 'Page'.$this->PageNo().'/{nb}',0,0,'C');

    }
    function headerTable(){
        $this->SetFont('Times', 'B', 8);
        $this->SetLineWidth(0.3);
        
        $this->Cell(15, 10, "N_Empleado", 1, 0, 'C');
        $this->Cell(25, 10, "Fecha Ingreso", 1, 0, 'C');
        $this->Cell(50, 10, "Nombre", 1, 0, 'C');
        $this->Cell(25, 10, "Jornada", 1, 0, 'C');
        $this->Cell(20, 10, "Categoria", 1, 0, 'C');
        $this->Cell(30, 10, "Comision", 1, 0, 'C');
        $this->Cell(60, 10, "Actividad", 1, 0, 'C');
        $this->Cell(125, 10, "Formacion Academica", 1, 0, 'C');
        $this->Cell(60, 10, "Correos", 1, 0, 'C');
        // $this->Cell(37, 10, "Contactos", 1, 0, 'C');
        $this->ln();

        global $instancia_conexion;
        $sql = "call proc_gestion_docente()";
        $stmt = $instancia_conexion->ejecutarConsulta($sql);
        while ($reg = $stmt->fetch_object()) {

            $this->SetFont('Times', '', 8);
            $this->Cell(15, 10, $reg->numero_empleado, 1, 0, 'C');
            $this->Cell(25, 10, $reg->fecha_ingreso, 1, 0, 'C');
            $this->Cell(50, 10, $reg->nombre, 1, 0, 'C');
            $this->Cell(25, 10, $reg->jornada, 1, 0, 'C');
            $this->Cell(20, 10, $reg->categoria, 1, 0, 'C');
            $this->Cell(30, 10, $reg->comision, 1, 0, 'C');
            $this->Cell(60, 10, $reg->actividad, 1, 0, 'C');
            $this->Cell(125, 10, $reg->formacion_academica, 1, 0, 'C');
            $this->Cell(60, 10, $reg->correos, 1, 0, 'C');
            // $this->Cell(37, 10, $reg->contactos, 1, 0, 'C');
            $this->ln();
        

    }
        
    }
   
   
}


$pdf = new myPDF();
$pdf->AliasNbPages();
$pdf->AddPage('C', 'Legal', 0);
$pdf->headerTable();
//$pdf->viewTable();
//$pdf->viewTable2($instancia_conexion);
$pdf->SetFont('Arial', '', 10);


$pdf->Output();
?>
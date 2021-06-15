<?php
require_once('../clases/conexion_mantenimientos.php');
require_once('../Reporte/pdf/fpdf.php');
$instancia_conexion = new conexion();

$periodo = $_POST["txt_count1"];
//$stmt = $instancia_conexion->query("SELECT tp.nombres FROM tbl_personas tp INNER JOIN tbl_usuarios us ON us.id_persona=tp.id_persona WHERE us.Id_usuario= 8");

  
class myPDF extends FPDF{
    function header(){
//         global $periodo;
//         global $mysqli;
//         $sql2 = $mysqli->prepare("SELECT tbl_periodo.id_periodo AS id_periodo, tbl_periodo.num_periodo AS num_periodo, tbl_periodo.num_anno AS num_anno, tbl_periodo.fecha_adic_canc AS fecha_adic_canc, tbl_periodo.fecha_desbloqueo AS fecha_desbloqueo,
// (SELECT tp.descripcion FROM tbl_tipo_periodo AS tp INNER JOIN tbl_periodo AS pdo ON tp.id_tipo_periodo=pdo.id_tipo_periodo
// 			WHERE tp.id_tipo_periodo= tbl_periodo.id_tipo_periodo LIMIT 1) AS tipo_periodo,
// 			(SELECT tp.horas_validas FROM tbl_tipo_periodo AS tp INNER JOIN tbl_periodo AS pdo ON tp.id_tipo_periodo=pdo.id_tipo_periodo
// 			WHERE tp.id_tipo_periodo= tbl_periodo.id_tipo_periodo LIMIT 1) AS horas_validas
// FROM tbl_periodo WHERE id_periodo=$periodo;
// ORDER BY id_periodo DESC LIMIT 1;");
//         $sql2->execute();
//         $resultado2 = $sql2->get_result();
//         $row2 = $resultado2->fetch_array(MYSQLI_ASSOC);

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
        $this->SetFont('Arial', 'B', 18);
        $this->Cell(276, 10, utf8_decode("REPORTE DE CARGA ACADÉMICA"), 0, 0, 'C');
        $this->ln(10);
        $this->SetFont('Arial', 'B', 12);
       // $this->Cell(363, 10, "Periodo " . $row2['num_periodo'] . utf8_decode(" del " . $row2['num_anno']), 0, 0, 'C');
       

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
        global $periodo;
        $this->SetFont('Times', 'B', 10);
        $this->SetLineWidth(0.2);
        
        $this->Cell(75, 7, "NOMBRE DOCENTE", 1, 0, 'C');
        // $this->Cell(23, 7, "#EMPLEADO", 1, 0, 'C');
        $this->Cell(20, 7, utf8_decode("CÓDIGO"), 1, 0, 'C');
        $this->Cell(90, 7, "ASIGNATURA", 1, 0, 'C');
        $this->Cell(19, 7, utf8_decode("SECCIÓN"), 1, 0, 'C');
        $this->Cell(15, 7, "HI", 1, 0, 'C');
        $this->Cell(15, 7, "HF", 1, 0, 'C');
        $this->Cell(19, 7, "EDIFICIO", 1, 0, 'C');
        $this->Cell(24, 7, utf8_decode("DÍAS"), 1, 0, 'C');
        $this->Cell(15, 7, "AULA", 1, 0, 'C');
        $this->Cell(24, 7, utf8_decode("MATRÍCULA"), 1, 0, 'C');

        $this->ln();

        global $instancia_conexion;
        $sql = "call sel_reporte_carga($periodo)";
        $stmt = $instancia_conexion->ejecutarConsulta($sql);
        while ($reg = $stmt->fetch_object()) {

            $this->SetFont('Times', '', 9);
            $this->Cell(75, 7, utf8_decode($reg->nombres), 1, 0, 'C');
            // $this->Cell(23, 7, $reg->num_empleado, 1, 0, 'C');
            $this->Cell(20, 7, utf8_decode($reg->codigo), 1, 0, 'C');
            $this->Cell(90, 7, utf8_decode( $reg->asignatura), 1, 0, 'C');
            $this->Cell(19, 7, $reg->seccion, 1, 0, 'C');
            $this->Cell(15, 7, $reg->hra_inicio, 1, 0, 'C');
            $this->Cell(15, 7, $reg->hra_final, 1, 0, 'C');
            $this->Cell(19, 7, $reg->edificio, 1, 0, 'C');
            $this->Cell(24, 7, $reg->dia, 1, 0, 'C');
            $this->Cell(15, 7, $reg->aula, 1, 0, 'C');
            $this->Cell(24, 7, $reg->num_alumnos, 1, 0, 'C');
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

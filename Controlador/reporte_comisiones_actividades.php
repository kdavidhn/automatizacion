<?php
session_start();
require_once('../clases/conexion_mantenimientos.php');
require_once "../Modelos/reporte_docentes_modelo.php";
require_once('../clases/Conexion.php');
require_once('../Reporte/pdf/fpdf.php');
$instancia_conexion = new conexion();


//$stmt = $instancia_conexion->query("SELECT tp.nombres FROM tbl_personas tp INNER JOIN tbl_usuarios us ON us.id_persona=tp.id_persona WHERE us.Id_usuario= 8");


 
class myPDF extends FPDF{
    function header(){
        //h:i:s
        date_default_timezone_set("America/Tegucigalpa");
        $fecha=date('d-m-Y h:i:s');
        //$fecha = date("Y-m-d ");
        global $mysqli;
        $id = $_SESSION['id_usuario'];
        $sql2 = $mysqli->prepare("SELECT tbl_periodo.id_periodo AS id_periodo, tbl_periodo.num_periodo AS num_periodo, tbl_periodo.num_anno AS num_anno, tbl_periodo.fecha_adic_canc AS fecha_adic_canc, tbl_periodo.fecha_desbloqueo AS fecha_desbloqueo,
(SELECT tp.descripcion FROM tbl_tipo_periodo AS tp INNER JOIN tbl_periodo AS pdo ON tp.id_tipo_periodo=pdo.id_tipo_periodo
			WHERE tp.id_tipo_periodo= tbl_periodo.id_tipo_periodo LIMIT 1) AS tipo_periodo,
			(SELECT tp.horas_validas FROM tbl_tipo_periodo AS tp INNER JOIN tbl_periodo AS pdo ON tp.id_tipo_periodo=pdo.id_tipo_periodo
			WHERE tp.id_tipo_periodo= tbl_periodo.id_tipo_periodo LIMIT 1) AS horas_validas
FROM tbl_periodo
ORDER BY id_periodo DESC LIMIT 1;");
        $sql2->execute();
        $resultado2 = $sql2->get_result();
        $row2 = $resultado2->fetch_array(MYSQLI_ASSOC);
        $sql = "SELECT tp.nombres, tp.apellidos FROM tbl_personas tp INNER JOIN tbl_usuarios us ON us.id_persona=tp.id_persona WHERE us.Id_usuario= $id";
        $resultado = $mysqli->query($sql);
        while ($row = $resultado->fetch_array(MYSQLI_ASSOC)) {
            
        $this->Image('../dist/img/logo_ia.jpg',20, 10, 30);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(276, 10, utf8_decode("UNIVERSIDAD NACIONAL AUTÓNOMA DE HONDURAS"), 0, 0, 'C');
        $this->ln(7);
        $this->Cell(276, 10, utf8_decode("FACULTAD DE CIENCIAS ECONÓMICAS, ADMINISTRATIVAS Y CONTABLES"), 0, 0, 'C');
        $this->ln(7);
        $this->Cell(276, 10, utf8_decode("DEPARTAMENTO DE INFORMÁTICA "), 0, 0, 'C');
        $this->ln(10);
        $this->SetFont('times', 'B', 20);
        $this->Cell(276, 10, utf8_decode("REPORTE DE CARGA ACADÉMICA DOCENTE"), 0, 0, 'C');
        $this->ln(15);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(276, 10, "PERIODO: " . $row2['num_periodo'] . utf8_decode(" AÑO: " . $row2['num_anno']), 0, 0, 'C');
            $this->ln(17);
        $this->SetFont('times', '', 12);
        $this->Cell(48, 10, "ACTIVIDAD DOCENTE: ", 0, 0, 'C' );
        $this->Cell(400, 10, "FECHA: " . $fecha, 0, 0, 'C');
        $this->ln();
        $this->Cell(80, 10, "" . utf8_decode($row['nombres']. ' ' .$row['apellidos']), 0, 0, 'C');
       
        }
   
       
        
    }
    function footer(){
        $this->SetY(-15);
        $this->SetFont('Arial', '', 10);
        $this->cell(0,10, 'Pagina'.$this->PageNo().'/{nb}',0,0,'C');

    }

    function headerTable(){
        $this->SetFont('Times', '', 12);
        $this->ln(10);
        $this->Cell(156, 10, utf8_decode("ACTIVIDADES DE INVESTIGACIÓN, VINCULACIÓN UNAH-SOCIEDAD, U OTRAS"), 0, 0, 'C');
        $this->ln(15);
        $this->SetFont('Times', 'B', 12);
        $this->SetLineWidth(0.3);
        $this->Cell(120, 10, utf8_decode("COMISIÓN / COORDINACIÓN"), 1, 0, 'C');
        $this->Cell(120, 10, "ACTIVIDADES", 1, 0, 'C');
        $this->Cell(33, 10, "HORAS", 1, 0, 'C');
        $this->ln();

        
              
        
    }
    function viewTable(){
        global $instancia_conexion;
        $id = $_SESSION['id_usuario'];
        $sql = "call sel_comisiones_reporte('$id')";
        $stmt = $instancia_conexion->ejecutarConsulta($sql);
        while ($reg = $stmt->fetch_object()) {

        
            $this->SetFont('Times', '', 12);
            $this->Cell(120, 10, $reg->comision, 1, 0, 'C');
            $this->Cell(120, 10, $reg->actividad, 1, 0, 'C');
            $this->Cell(33, 10, $reg->horas_semanales, 1, 0, 'C');
            $this->ln();


    }
   
}
}


$pdf = new myPDF();
$pdf->AliasNbPages();
$pdf->AddPage('C', 'A4', 0);
$pdf->headerTable();
$pdf->viewTable();

//$pdf->viewTable2($instancia_conexion);
$pdf->SetFont('Arial', '', 12);


$pdf->Output();

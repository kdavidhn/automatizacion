<?php
session_start();
require_once('../clases/conexion_mantenimientos.php');
require_once "../Modelos/reporte_docentes_modelo.php";
require_once('../clases/Conexion.php');
require_once('../Reporte/pdf/fpdf.php');
$instancia_conexion = new conexion();
$instancia_conexion2 = new conexion();




//$stmt = $instancia_conexion->query("SELECT tp.nombres FROM tbl_personas tp INNER JOIN tbl_usuarios us ON us.id_persona=tp.id_persona WHERE us.Id_usuario= 8");



class myPDF extends FPDF
{
    function header()
    {
        //h:i:s
        date_default_timezone_set("America/Tegucigalpa");
        $fecha = date('d-m-Y h:i:s');
        // $hora = date("h:i:s ");


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

            $this->Image('../dist/img/logo_ia.jpg', 20, 10, 30);
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
            $this->Cell(48, 10, "ACTIVIDAD DOCENTE: ", 0, 0, 'C');
            $this->Cell(400, 10, "FECHA: " . $fecha, 0, 0, 'C');
            $this->ln();
            $this->Cell(90, 10, "" . utf8_decode($row['nombres'] . ' ' . $row['apellidos']), 0, 0, 'C');
        }



        $this->ln(20);
    }
    function footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', '', 10);
        $this->cell(0, 10, 'Pagina' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    function headerTable()
    {
        $this->SetFont('Times', 'B', 10);
        $this->SetLineWidth(0.3);
        $this->Cell(45, 10, utf8_decode("CÓDIGO ASIGNATURA"), 1, 0, 'C');
        $this->Cell(100, 10, "NOMBRE DE LA ASIGNATURA", 1, 0, 'C');
        $this->Cell(20, 10, utf8_decode("SECCIÓN"), 1, 0, 'C');
        $this->Cell(15, 10, "HI", 1, 0, 'C');
        $this->Cell(15, 10, "HF", 1, 0, 'C');
        $this->Cell(25, 10, utf8_decode("DÍAS"), 1, 0, 'C');
        $this->Cell(15, 10, "AULA", 1, 0, 'C');
        $this->Cell(20, 10, "EDIFICIO", 1, 0, 'C');
        $this->Cell(25, 10, "N. ALUMNOS", 1, 0, 'C');
        $this->ln();
    }

    function headerTable1()
    {
        $this->ln();
        $this->SetFont('times', '', 12);
        $this->Cell(156, 10, utf8_decode("ACTIVIDADES DE INVESTIGACIÓN, VINCULACIÓN UNAH-SOCIEDAD, U OTRAS"), 0, 0, 'C');
        $this->ln();
        $this->SetFont('Times', 'B', 10);
        $this->SetLineWidth(0.3);
        $this->Cell(100, 10, "COMISIONES", 1, 0, 'C');
        $this->Cell(125, 10, "ACTIVIDADES", 1, 0, 'C');
        $this->Cell(50, 10, "HORAS SEMANALES", 1, 0, 'C');
        $this->ln();
    }


    function viewTable()
    {

        global $instancia_conexion;
        $id = $_SESSION['id_persona'];
        $sql = "call sel_reporte_docente('$id')";
        $stmt = $instancia_conexion->ejecutarConsulta($sql);
        while ($reg = $stmt->fetch_object()) {

            $this->SetFont('Times', '', 10);
            $this->Cell(45, 10, $reg->codigo, 1, 0, 'C');
            $this->Cell(100, 10, utf8_decode($reg->asignatura), 1, 0, 'C');
            $this->Cell(20, 10, $reg->seccion, 1, 0, 'C');
            $this->Cell(15, 10, $reg->hra_inicial, 1, 0, 'C');
            $this->Cell(15, 10, $reg->hra_final, 1, 0, 'C');
            $this->Cell(25, 10, $reg->dia, 1, 0, 'C');
            $this->Cell(15, 10, $reg->aula, 1, 0, 'C');
            $this->Cell(20, 10, $reg->edificio, 1, 0, 'C');
            $this->Cell(25, 10, $reg->num_alumnos, 1, 0, 'C');
            $this->ln();
        }
    }

    function viewTable1()
    {
       
        $id1 = $_SESSION['id_usuario'];

        $mysqli = new mysqli('167.114.169.207', 'informat_admin', 'HLo{Q3e{)II^', 'informat_automatizacion');

        if (mysqli_connect_errno()) {
            printf("Falló la conexión: %s\n", mysqli_connect_error());
            exit();
        }

        $consulta = "call sel_comisiones_reporte('$id1')";

        if ($sentencia = $mysqli->prepare($consulta)) {

            $sentencia->execute();

            $sentencia->bind_result($id_actividad, $comision, $actividad, $horas_semanales);

            while ($sentencia->fetch()) {
                $this->SetFont('Times', '', 10);
                $this->Cell(100, 10, $comision, 1, 0, 'C');
                $this->Cell(125, 10, $actividad, 1, 0, 'C');
                $this->Cell(50, 10, $horas_semanales, 1, 0, 'C');
                $this->ln();
            }

            $sentencia->close();
        }

        $mysqli->close();

    }
}



$pdf = new myPDF();
$pdf->AliasNbPages();
$pdf->AddPage('C', 'A4', 0);
$pdf->headerTable();
$pdf->viewTable();
$pdf->headerTable1();
$pdf->viewTable1();
//$pdf->viewTable2($instancia_conexion);
$pdf->SetFont('Arial', '', 10);


$pdf->Output();

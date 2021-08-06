<?php

session_start();
require_once('../clases/conexion_mantenimientos.php');
require_once ('../clases/Conexionvoae.php');
require_once ('../Reporte/pdf/fpdf.php');

$instancia_conexion = new conexion();
//$mem = new memorandum();

class pdf extends FPDF
{

 public function header()
{
$this->SetFillColor(15,57,117);
$this->rect(0,0,220,40,'F');
$this->SetFont('Arial','B',10);
$this->SetTextColor(255,255,255);
$this->setY(13);
$this->Image('../dist/img/kkk.png', 8, 10, 25);

 $this->setX(200);
$this->setY(13);
$this->Image('../dist/img/logo_unah2.png', 180, 10,25,25);

 $this->setX(35);
$this->write(5,'Universidad Nacional Autonoma de Honduras');
$this->ln();
$this->setX(35);
$this->write(5,'Facultad de Ciencias Economicas, Administrativas y Contables');
$this->ln();
$this->setX(35);
$this->write(5,'Departamento de Informatica Administrativa');
$this->ln();
$this->setX(35);
$this->write(5,'Comite de Vida Estudiantil');
$this->ln();
$this->SetX(35);
$this->SetFont('Arial','B',8);
$this->SetTextColor(255,255,255);
$this->write(5,'Fecha de documento:');
$this->SetTextColor(255,255,255);
date_default_timezone_set("America/Tegucigalpa");
$fecha= date('d-m-Y H:i');
$this->write(5,' '.$fecha);

 $this->ln();
$this->SetFont('Arial','B',10);
$this->SetTextColor(15,57,117);
$this->setY(60);
$this->setX(85);
$this->write(5,'HISTORIAL DE HORAS');


 $this->setX(25);
$this->setY(75);
$this->write(5,'Nombre: ');
$this->setX(25);
$this->setY(80);
$this->write(5,'Cuenta: ');

$this->ln();
$nombre = $_SESSION['nombre'];
$cuenta = $_SESSION['cuenta'];
//$id_memo = 6;
global $instancia_conexion;
$sql="select * from tbl_voae_asistencias where nombre_alumno = '$nombre'";
$stmt = $instancia_conexion->ejecutarConsulta($sql);

     while ($reg = $stmt->fetch_object()) {

     $this->ln();
    $this->setY(75);
    $this->SetX(28);
    $this->SetFont('Arial','B',10);
    $this->SetTextColor(15,57,117);
    $this->write(5, $reg->nombre_alumno);

     $this->setY(80);
    $this->SetX(28);
    $this->SetFont('Arial','B',10);
    $this->SetTextColor(15,57,117);
    $this->write(5, $reg->cuenta);
    }

        $this->SetFont('Arial','B',10);
        $this->SetFillColor(45, 65, 84);
        $this->SetTextColor(255,255,255);
        $this->SetY(90);
        $this->SetX(5);
        $this->Cell(50, 7, "ACTIVIDAD", 'B', 0, 'C',1,'F');
        // $this->Cell(23, 7, "#EMPLEADO", 1, 0, 'C');
        $this->Cell(40, 7, "FECHA", 'B', 0, 'C',1,'F');
        $this->Cell(50, 7, "AMBITO", 'B', 0, 'C',1,'F');
        $this->Cell(20, 7, "HORAS", 'B', 0, 'C',1,'F');
        $this->Cell(45, 7, "TIPO DE ACTIVIDAD", 'B', 0, 'C',1,'F');
        $this->ln();
 
}

 public function cuerpo()
{
       
    
    $nombre = $_SESSION['nombre'];
    $cuenta = $_SESSION['cuenta'];
    //$id_memo = 6;
    global $instancia_conexion;
    //$sql="select * from tbl_voae_asistencias where nombre_alumno = '$nombre'";
    $sql="SELECT tbl_voae_asistencias.id_asistencia, tbl_voae_asistencias.id_actividad_voae, tbl_voae_asistencias.nombre_alumno, tbl_voae_actividades.nombre_actividad, tbl_voae_actividades.fch_inicial_actividad, tbl_voae_ambitos.nombre_ambito AS ambito, tbl_voae_asistencias.cant_horas,tbl_voae_actividades.tipo_actividad FROM tbl_voae_asistencias JOIN tbl_voae_actividades ON tbl_voae_asistencias.id_actividad_voae= tbl_voae_actividades.id_actividad_voae JOIN tbl_voae_ambitos ON tbl_voae_actividades.id_ambito = tbl_voae_ambitos.id_ambito where cuenta = '$cuenta'";

    $stmt = $instancia_conexion->ejecutarConsulta($sql);

        while ($reg = $stmt->fetch_object()) {
            $this->SetFont('Arial','',10);
            $this->SetTextColor(0,0,0);
            $this->SetX(5);

            $this->Cell(50, 7, $reg->nombre_actividad, 'B', 0, 'C');
            $this->Cell(40, 7, $reg->fch_inicial_actividad, 'B', 0, 'C');
            $this->Cell(50, 7, $reg->ambito, 'B', 0, 'C');
            $this->Cell(20, 7, $reg->cant_horas, 'B', 0, 'C');
            $this->Cell(45, 7, $reg->tipo_actividad, 'B', 0, 'C');
            $this->ln();
        }


}


 


 public function footer()
{
$this->SetFillColor(15,57,117);
$this->rect(0,270,120,10,'F');

 $this->SetFillColor(255, 204, 15);
$this->rect(120,270,120,10,'F');
$this->SetFont('Arial','B',10);
$this->SetTextColor(255,255,255);
$this->setY(270);
$this->setX(210);
$this->cell(0,10, utf8_decode('Página').$this->PageNo().'/{nb}',0,1,'C');

 }
}

$fpdf = new pdf('P', 'mm', 'legal', true);
$fpdf->AddPage('portraid', 'Letter',0);
//$fpdf->setY(60);

$fpdf->cuerpo();
$fpdf->AliasNbPages();
$fpdf->SetMargins(20,30,30,20);
$fpdf->output();
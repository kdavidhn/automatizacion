<?php

require_once ('../clases/funcion_permisos.php');
require_once ('../clases/Conexion.php');
require_once('../clases/conexion_mantenimientos.php');
require_once ('../clases/Conexionvoae.php');
require_once ('../clases/funcion_visualizar.php');
require_once "../Modelos/memorandum_cve_modelo.php";
require_once ('../clases/funcion_bitacora.php');
require_once ('../pdf/fpdf/fpdf.php');


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
        $this->SetFont('Arial','B',10);
        $this->SetTextColor(15,57,117);
        $this->setY(60);
        $this->setX(75);
        $this->write(5,'REPORTE DE MEMORANDUM');
        $this->ln();
        $this->ln();

        $this->SetFont('Arial','B',10);
        $this->SetTextColor(15,57,117);
        //$this->write(5,'Fecha de documento:');
        $this->SetTextColor(82, 86, 89);
            date_default_timezone_set("America/Tegucigalpa");
            $fecha= date('d-m-Y H:i');
        //$this->write(5,'    '.$fecha);

        $this->ln();
        $this->setY(80);
        $this->SetFont('Arial','B',10);
        $this->SetTextColor(15,57,117);
        $this->setY(80);
        $this->setX(80);
        $this->write(7,  "MEMORANDUM  " );
        $this->SetTextColor(82, 86, 89);
        $this->setY(90);
        $this->setX(20);
        $this->write(7,  "PARA:  ");
        $this->setY(120);
        $this->setX(20);
        $this->write(7,  "DE:  ");
        $this->setY(150);
        $this->setX(20);
        $this->write(7,  "FECHA:  ");
        $this->setY(170);
        $this->setX(20);
        $this->write(7,  "ASUNTO:  ");
        $this->ln();


    }

    public function cuerpo()
    {  
        //llenado de tabla 
        $this->ln();
        $id_memo = $_POST["id_memo"];
        //$id_memo = 6;
        global $instancia_conexion;
        $sql="SELECT m.id_memo as 'id_memo', m.no_memo as 'no_memo', tm.nombre_tipo_memorandum as 'nombre_tipo_memorandum', m.remitente as 'remitente',m.destinatario as 'destinatario', m.fecha as 'fecha', m.asunto as 'asunto' ,m.contenido as 'contenido'
            FROM tbl_voae_memorandums AS m
            INNER JOIN tbl_voae_tipo_memorandum AS tm
            ON m.id_tipo_memo = tm.id_tipo_memorandum
            where m.id_memo = '$id_memo'";


        $stmt = $instancia_conexion->ejecutarConsulta($sql);

        while ($reg = $stmt->fetch_object()) {

            $this->ln();
            $this->setY(80);
            $this->SetFont('Arial','B',10);
            $this->SetTextColor(15,57,117);
            $this->setY(80);
            $this->setX(110);
            $this->write(7,  $reg->no_memo );
            $this->SetFont('Arial','',10);
            $this->SetTextColor(82, 86, 89);
            $this->setY(90);
            $this->setX(40);
            $this->write(7,  $reg->remitente);
            $this->setY(120);
            $this->setX(40);
            $this->write(7,  $reg->destinatario);
            $this->setY(150);
            $this->setX(40);
            $this->write(7,  $reg->fecha);
            $this->setY(170);
            $this->setX(40);
            $this->SetFont('Arial','B',10);
            $this->write(7,  $reg->asunto);
            $this->ln();
            $this->setY(180);
            $this->setX(40);
            $this->SetFont('Arial','',10);
            $this->multicell(160,10, utf8_decode($reg->contenido), 0,'J',0);
           /// $pdf->Multicell(160, 10, $texto, 0, 'L', 0);
            //$this->write(7,  $reg->contenido);
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


$fpdf = new pdf('P', 'mm', 'letter', true);
$fpdf->AddPage('portraid', 'Letter',0);
//$fpdf->setY(60);

$fpdf->cuerpo();    
$fpdf->AliasNbPages();
$fpdf->SetMargins(20,30,30,20);
$fpdf->output();
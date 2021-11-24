<?php


require_once('../clases/conexion_mantenimientos.php');
require_once ('../clases/Conexion.php');
require_once ('../Reporte/pdf/fpdf.php');
//require_once ('../pdf/fpdf/fpdf.php');


$instancia_conexion = new conexion();
//$mem = new memorandum();


class mypdf extends FPDF
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
        $this->write(5,'    '.$fecha);



    }

    public function portada()
    {  
        $this->SetFont('Arial','B',28);
        $this->SetTextColor(15,57,117);
        $this->setY(90);
        $this->setX(38);
        $this->multicell(150,10, utf8_decode('INFORME DE ACTIVIDAD' ), 0,'C',0);
        //$this->write(5,'INFORME DE ACTIVIDAD');

        $this->ln();
        $id_informe = $_POST["id_informe"];
        global $instancia_conexion;
        $sql="SELECT id_informe, id_actividad, no_solicitud, nombre_actividad, introduccion, objetivos, desarrollo, 
        conclusiones, fch_informe, id_repositorio, nombre_archivo, dir_repositorio, id_usuario_registro, Usuario, 
        id_estado, nombre_estado
             FROM  view_informes_actividades_completa where id_informe= '$id_informe'";



        $stmt = $instancia_conexion->ejecutarConsulta($sql);

        while ($reg = $stmt->fetch_object()) {

            $this->ln();
            $this->setY(125);
            $this->setX(35);
            $this->SetFont('Arial','',25);
            $this->SetTextColor(0,0,0);
            $this->multicell(150,10, utf8_decode($reg->nombre_actividad), 0,'C',0);
            $this->ln();
            $this->setY(135);
            $this->setX(33.5);
            $this->multicell(150,10, utf8_decode('('.$reg->fch_informe.')'), 0,'C',0);
           
            //$this->write(7,  $reg->nombre_actividad);
            $this->ln();
            $this->Image('../dist/img/lucemaspicio.jpg', 130, 150, 100,120);
        

        }

    }

    

    public function introduccion()
    {  
        $this->SetFont('Arial','B',10);
        $this->SetTextColor(15,57,117);
        $this->setY(60);
        $this->setX(90);
        $this->write(5,'INTRODUCCION');

        $this->ln();
        $id_informe = $_POST["id_informe"];
        global $instancia_conexion;
        $sql="SELECT id_informe, id_actividad, no_solicitud, nombre_actividad, introduccion, objetivos, desarrollo, conclusiones, fch_informe, id_repositorio, nombre_archivo, dir_repositorio, id_usuario_registro, Usuario, id_estado, nombre_estado
             FROM  view_informes_actividades_completa where id_informe= '$id_informe'";



        $stmt = $instancia_conexion->ejecutarConsulta($sql);

        while ($reg = $stmt->fetch_object()) {

            $this->ln();
            $this->setY(80);
            $this->setX(35);
            $this->SetFont('Arial','',10);
            $this->SetTextColor(0,0,0);
            $this->multicell(150,10, utf8_decode($reg->introduccion), 0,'J',0);
           /// $pdf->Multicell(160, 10, $texto, 0, 'L', 0);
            //$this->write(7,  $reg->contenido);
            $this->ln();
        

        }

    }

    public function objetivos()
    {  
        $this->SetFont('Arial','B',10);
        $this->SetTextColor(15,57,117);
        $this->setY(60);
        $this->setX(90);
        $this->write(5,'OBJETIVOS'); 

        $this->ln();
        $id_informe = $_POST["id_informe"];
        global $instancia_conexion;
        $sql="SELECT id_informe, id_actividad, no_solicitud, nombre_actividad, introduccion, objetivos, desarrollo, conclusiones, fch_informe, id_repositorio, nombre_archivo, dir_repositorio, id_usuario_registro, Usuario, id_estado, nombre_estado
             FROM  view_informes_actividades_completa where id_informe= '$id_informe'";



        $stmt = $instancia_conexion->ejecutarConsulta($sql);

        while ($reg = $stmt->fetch_object()) {

            $this->ln();
            $this->setY(80);
            $this->setX(35);
            $this->SetFont('Arial','',10);
            $this->SetTextColor(0,0,0);
            $this->multicell(150,10, utf8_decode($reg->objetivos), 0,'J',0);
           /// $pdf->Multicell(160, 10, $texto, 0, 'L', 0);
            //$this->write(7,  $reg->contenido);
            $this->ln();
        

        }

    }
    public function desarrollo()
    {  
        $this->SetFont('Arial','B',10);
        $this->SetTextColor(15,57,117);
        $this->setY(60);
        $this->setX(90);
        $this->write(5,'DESARROLLO DE LA ACTIVIDAD'); 

        $this->ln();
        $id_informe = $_POST["id_informe"];
        global $instancia_conexion;
        $sql="SELECT id_informe, id_actividad, no_solicitud, nombre_actividad, introduccion, objetivos, desarrollo, conclusiones, fch_informe, id_repositorio, nombre_archivo, dir_repositorio, id_usuario_registro, Usuario, id_estado, nombre_estado
             FROM  view_informes_actividades_completa where id_informe= '$id_informe'";



        $stmt = $instancia_conexion->ejecutarConsulta($sql);

        while ($reg = $stmt->fetch_object()) {

            $this->ln();
            $this->setY(80);
            $this->setX(35);
            $this->SetFont('Arial','',10);
            $this->SetTextColor(0,0,0);
            $this->multicell(150,10, utf8_decode($reg->desarrollo), 0,'J',0);
           /// $pdf->Multicell(160, 10, $texto, 0, 'L', 0);
            //$this->write(7,  $reg->contenido);
            $this->ln();
        

        }

    }

    public function conclusiones()
    {  
        $this->SetFont('Arial','B',10);
        $this->SetTextColor(15,57,117);
        $this->setY(60);
        $this->setX(90);
        $this->write(5,'CONCLUSIONES'); 

        $this->ln();
        $id_informe = $_POST["id_informe"];
        global $instancia_conexion;
        $sql="SELECT id_informe, id_actividad, no_solicitud, nombre_actividad, introduccion, objetivos, desarrollo, conclusiones, fch_informe, id_repositorio, nombre_archivo, dir_repositorio, id_usuario_registro, Usuario, id_estado, nombre_estado
             FROM  view_informes_actividades_completa where id_informe= '$id_informe'";



        $stmt = $instancia_conexion->ejecutarConsulta($sql);

        while ($reg = $stmt->fetch_object()) {

            $this->ln();
            $this->setY(80);
            $this->setX(35);
            $this->SetFont('Arial','',10);
            $this->SetTextColor(0,0,0);
            $this->multicell(150,10, utf8_decode($reg->conclusiones), 0,'J',0);
           /// $pdf->Multicell(160, 10, $texto, 0, 'L', 0);
            //$this->write(7,  $reg->contenido);

            $this->ln();
        

        }

    }


    public function footer()
    {
        //Texto footer
        $this->SetFillColor(15,57,117);
        $this->rect(0,270,120,10,'F');
        //$this->SetFont('Arial','B',10);
        //$this->SetTextColor(0,0,0);
        //$this->cell(0,236, utf8_decode('Tegucigalpa Ciudad Universitaria '),0,1,'L');

        // Texto de orden de pagina
        $this->SetFillColor(255, 204, 15);
        $this->rect(120,270,120,10,'F');
        $this->SetFont('Arial','B',10);
        $this->SetTextColor(15,57,117);
        $this->setY(270);
        $this->setX(210);
        $this->cell(0,10, utf8_decode('Página').$this->PageNo().'/{nb}',0,1,'C');

    }
}


$fpdf = new mypdf('P', 'mm', 'letter', true);
$fpdf->AddPage('portraid', 'Letter',0);
$fpdf->portada();
$fpdf->AddPage('portraid', 'Letter',0);
$fpdf->introduccion();
$fpdf->AddPage('portraid', 'Letter',0);
$fpdf->objetivos();
$fpdf->AddPage('portraid', 'Letter',0);
$fpdf->desarrollo();
$fpdf->AddPage('portraid', 'Letter',0);
$fpdf->conclusiones();
$fpdf->AliasNbPages();
$fpdf->SetMargins(20,30,30,20);
$fpdf->output();

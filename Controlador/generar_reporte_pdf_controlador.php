<?php 
require_once('../clases/conexion_mantenimientos.php');
require_once ('../clases/Conexionvoae.php');
require_once ('../Reporte/pdf/fpdf.php');


//Var_dump($_POST);

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
        $this->multicell(150,10, utf8_decode('REPORTE DE ACTIVIDADES' ), 0,'C',0);
        $this->ln();
        $this->multicell(200,10, utf8_decode('REALIZADAS DEL '.$f_inicial = $_POST['fch_inicial_actividad'].' AL '.$f_final = $_POST['fch_final_actividad']), 0,'C',0);
        //$this->write(5,'INFORME DE ACTIVIDAD');

        $this->ln();
    }

    

    public function CuerpodelReporte()
    {  
        $this->SetFont('Arial','B',10);
        $this->SetTextColor(15,57,117);
        $this->setY(60);
        $this->setX(75);
        $this->write(5,'Reporte de Actividades Realizadas');

        $this->ln();
        $this->ln();
        $this->SetFont('Arial','',12);
        $this->SetFillColor(70, 116, 202);
        $this->SetTextColor(255,255,255);
        $this->SetDrawColor(255, 192, 0);
        $this->cell(200,5,'Listado o Resumen de Actividades',0,0,'C',1);
        $this->ln();
        $this->SetFont('Arial','',10);
        $this->cell(23,5,'Periodo',0,0,'C',1);
        $this->cell(50,5,'Actividad',0,0,'C',1);
        $this->cell(25,5,'Fecha Solicitud',0,0,'C',1);
        $this->cell(80,5,'Descripcion',0,0,'C',1);
        $this->cell(22,5,'Presupuesto',0,0,'C',1);

        $f_inicial=$_POST['fch_inicial_actividad'];
        $f_final=$_POST['fch_final_actividad'];
        $periodo=$_POST['periodo'];
        $ambito=$_POST['id_ambito'];
        $estado=$_POST['id_estado'];

        if($ambito = "TODOS"){      
            global $instancia_conexion;
            $sql="SELECT * FROM tbl_voae_actividades WHERE 
            fch_inicial_actividad >= '$f_inicial' 
            AND fch_final_actividad <= '$f_final'
            AND id_estado = '$estado'
            AND periodo = '$periodo'";
        
        }elseif($estado = "TODOS"){  
            global $instancia_conexion;
            $sql="SELECT * FROM tbl_voae_actividades WHERE 
            fch_inicial_actividad >= '$f_inicial' 
            AND fch_final_actividad <= '$f_final'
            AND id_ambito = '$ambito'
            AND periodo = '$periodo'";
            
        }

        /*$sql="SELECT * FROM tbl_voae_actividades WHERE fch_solicitud BETWEEN '2021-08-06' AND '2021-10-17' AND periodo = 'PRIMER PERIODO' AND id_ambito = 23 AND id_estado = 7
        GROUP by fch_solicitud Asc";*/

        $stmt = $instancia_conexion->ejecutarConsulta($sql);

        while ($reg = $stmt->fetch_object()) {

            $this->ln();
            $this->SetFont('Arial','',8);
            $this->SetFillColor(247, 246, 246);
            $this->SetTextColor(0,0,0);
            $this->cell(30,5,utf8_decode($reg->periodo),0,0,'L',1);
            $this->cell(50,5,utf8_decode($reg->nombre_actividad),0,0,'L',1);
            $this->cell(30,5,utf8_decode($reg->fch_solicitud),0,0,'L',1);
            $this->cell(68,5,utf8_decode($reg->descripcion),0,0,'L',1);
            $this->cell(22,5,utf8_decode($reg->presupuesto),0,0,'C',1);
            $this->Ln();
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

$fpdf->CuerpodelReporte();
$fpdf->AliasNbPages();

$fpdf->SetMargins(20,30,30,20);
$fpdf->output();

?>
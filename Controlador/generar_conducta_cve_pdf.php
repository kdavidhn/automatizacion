<?php


require_once('../clases/conexion_mantenimientos.php');
require_once ('../clases/Conexionvoae.php');
require_once ('../Reporte/pdf/fpdf.php');


$instancia_conexion = new conexion();




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
        //$this->SetX(35);
        //$this->SetFont('Arial','B',8);
        //$this->SetTextColor(255,255,255);
        //$this->write(5,'Fecha de documento:');
        //$this->SetTextColor(255,255,255);
          //  date_default_timezone_set("America/Tegucigalpa");
            //$fecha= date('d-m-Y H:i');
        //$this->write(5,'    '.$fecha);


        

        $this->ln();
        $this->SetFont('Arial','B',10);
        $this->SetTextColor(15,57,117);
        $this->setY(60);
        $this->setX(75);
        $this->write(5,'CONSTANCIA DE CONDUCTA');
        $this->ln();
        $this->ln();

        
        
        /*$this->SetTextColor(82, 86, 89);
            date_default_timezone_set("America/Tegucigalpa");
            $fecha= date('d-m-Y H:i');
        $this->setY(80);
        $this->setX(100);
        $this->SetFont('Arial','B',10);
        $this->SetTextColor(0,0,0);
            $this->write(5,'Tegucigalpa, M.D.C '.$fecha);*/
        

       


    }
    public function cuerpo(){
        $id_persona = $_POST['id_persona'];
        
        global $instancia_conexion;
        $sql="select concat(tbl_personas.nombres,' ',tbl_personas.apellidos) AS nombres, tbl_personas_extendidas.valor as cuenta from tbl_personas join tbl_personas_extendidas on tbl_personas.id_persona = tbl_personas_extendidas.id_persona where tbl_personas.id_persona ='$id_persona'";

        $stmt = $instancia_conexion->ejecutarConsulta($sql);

        while ($reg = $stmt->fetch_object()) {

            $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
             
            date_default_timezone_set("America/Tegucigalpa");
            $fecha= date('d-m-Y H:i');
            $dia= date('d');
            $mes= date("F");
            $anio= date("Y");


        $this->SetFont('Arial','',10);
        $this->SetTextColor(0,0,0);
        $this->setX(30);
        $this->multicell(150,10, utf8_decode('
A quien corresponda:


El comite de vida Estudiantil, de la Universidad Nacional Autonoma de Honduras (UNAH), por medio de la presente que el Alumno(a): '. $reg->nombres . ', con numero de cuenta: '. $reg->cuenta . ',  durante su proceso estudiantil ha demostrado una EXCELENTE CONDUCTA. 
Y, para los fines que al interesado(a) estime conserniente, se le extiende la presente en la Ciudad de Tegucigalpa a los  '.$dia. ' dias del mes de '. $meses[date('n')-1] . ' del '. $anio .'
    
Atte.


Lic. Marvin  Merino
'), 0,'J',0);

            
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
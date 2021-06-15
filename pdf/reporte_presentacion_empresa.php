<?php 

	 session_start();

require 'fpdf/fpdf.php';
require_once ('../clases/Conexion.php');



$usuario=$_SESSION['id_usuario'];
        $id=("select id_persona from tbl_usuarios where id_usuario='$usuario'");
       $result= mysqli_fetch_assoc($mysqli->query($id));
       $id_persona=$result['id_persona'];
/* Manda a llamar todos las datos de la tabla para llenar el gridview  */
$sqltabla="select ep.nombre_empresa, ep.jefe_inmediato, ep.titulo_jefe_inmediato,ep.cargo_jefe_inmediato, concat(p.nombres,'',p.apellidos)AS nombre, px.valor from tbl_empresas_practica ep, tbl_personas p, tbl_personas_extendidas px where ep.id_persona=p.id_persona and p.id_persona='$id_persona' AND px.id_atributo=12 and px.id_persona='$id_persona'";


class PDF extends FPDF
	{
		function Header()
		{
			//date_default_timezone_get('America/Tegucigalpa');
		$this->Image('../dist/img/logo_ia.jpg', 12,8,30);
			$this->Image('../dist/img/logo-unah.jpg', 172,8, 22 );


		}
function Footer()
		{
			$fecha_actual=date("Y-m-d H:i:s");
			$this->SetY(-15);
			$this->SetFont('Arial','I', 8);
		}	

}
//date_default_timezone_get('America/Tegucigalpa');

$resultado = mysqli_query($connection, $sqltabla);
	$row = mysqli_fetch_array($resultado);

	

	$pdf = new PDF();
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont('Arial','B',15);
	$pdf->cell(0,6,utf8_decode('Universidad Nacional Autonoma de Honduras'),0,1,'C');
	$pdf->ln(2);
	$pdf->cell(0,6,utf8_decode('Facultad de Ciencias Economicas'),0,1,'C');
	$pdf->ln(2);
	$pdf->cell(0,6,utf8_decode('Departamento de Informatica Administrativa'),0,1,'C');
	$pdf->SetFont('Arial','',12);
    $pdf->ln(5);
        $pdf->ln(5);
    $pdf->ln(5);
	$pdf->Cell(70,5,utf8_decode(' '.$row['titulo_jefe_inmediato'].'.'.' '.$row['jefe_inmediato'].' '),0,1,'C');
	$pdf->Cell(50,5,utf8_decode(''.'Cargo: '.$row['cargo_jefe_inmediato'].'  '),0,1,'C');
	$pdf->Cell(54,5,utf8_decode(' '.'Empresa:'.$row['nombre_empresa'].' '),0,1,'C');
	$pdf->ln(5);



	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','I',12);
	$pdf->ln(5);
	$pdf->SetX(20);
    $pdf->multicell(170,9,utf8_decode('Estimado '),0);
	$pdf->ln(5);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode('Por este medio me permito presentar a : '.$row['nombre'].'  con numero de cuenta '.$row['valor'].'  estudiante de la carrera de Informatica Administrativa, quien desea realizar la practica profecional en tan prestigiosa empresa. '),0);
	$pdf->ln(5);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode('La Practica Profesional es una actividad formativa del alumno, consistente en la asuncion supervisada y gradual, del rol profesional, a traves de su insercion a un arealida o ambiente laboral especifico, al mismo tiempo se convierte en un aporte desde su capacidad,habilidad y conocimientos adquiridos, cuya meta es producir algun producto o aporte significativo dentro de la institucion. '),0);
	$pdf->ln(5);
	$pdf->SetX(20);
    $pdf->multicell(170,5,utf8_decode('Este es un requisito de graduacion para los estudiantes de las carreras de la Facultad de Ciencias Economicas Administrativas y Contables, la cual tiene una duracion de 800 horas y puede ser realizada a partir de que los alumnos hayan cursado como minimo el 80% de las A signaturas del plan de estudios de su Carrera. Para continuar con los tramites relacionados con la practica profesional le solicitamos lo siguiente: '),0);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode('
		a.Perfil de la empresa: Mision, Vision, objetivos/metas y datos generales de los contactos de la empresa.
		b.El detalle de las actividades que realizara el estudiante de acuerdo al perfil de la carrera de Informatica Adminstrativa que consiste en las catividades como: analisis, diseño, codificacion e implementacion de sistemas de informacion; diseño, manejo y adminstracion de bases de datos, redes y comunicacion de datos, soporte de aplicaciones, y otros relacionados con el area tecnologica.
		Una vez recibida la documentacion solicitada, el comite de Practica Profesional de esta Carrera procedera autorizar al estudiante este requisito de graduacion, dependiendo del analisis de la informacion proporcionada.'),0);
	$pdf->ln(5);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode('
		Sin otro particular, me suscribo de usted
		Atentamente, '),0);
	$pdf->ln(5);
	$pdf->SetX(20);



    $pdf->ln(30);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(60,5,utf8_decode(''),0,0,'C');
	$pdf->Cell(70,5,utf8_decode('Coordinador Carrera Informática Administrativa'),'T',0,'C');


	$pdf->Output();

?>
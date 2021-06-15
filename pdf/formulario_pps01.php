<?php 

	 session_start();

require 'fpdf/fpdf.php';
require_once ('../clases/Conexion.php');

$usuario=$_SESSION['id_usuario'];
 $id=("select id_persona from tbl_usuarios where id_usuario='$usuario'");
$result= mysqli_fetch_assoc($mysqli->query($id));
$id_persona=$result['id_persona'];
$sql = "SELECT px.valor, concat(a.nombres,' ',a.apellidos) as nombre, ep.nombre_empresa, ep.direccion_empresa, pe.docente_supervisor, pe.fecha_inicio, pe.fecha_finaliza, c.valor Correo, e.valor Celular, h.valor Fijo, i.valor Direccion, ep.tipo_empresa, ep.departamento_empresa, ep.jefe_inmediato, ep.titulo_jefe_inmediato, ep.cargo_jefe_inmediato, ep.correo_jefe_inmediato, ep.telefono_jefe_inmediato, ep.labora_dentro, a.id_persona, pe.horas, px.valor, a.identidad, a.fecha_nacimiento

FROM

tbl_empresas_practica AS ep
JOIN tbl_personas AS a
ON ep.id_persona = a.id_persona
JOIN tbl_practica_estudiantes AS pe
ON pe.id_persona = a.id_persona
JOIN tbl_contactos c ON a.id_persona = c.id_persona
JOIN tbl_tipo_contactos d ON c.id_tipo_contacto = d.id_tipo_contacto AND d.descripcion = 'CORREO'
JOIN tbl_contactos e ON a.id_persona = e.id_persona
JOIN tbl_tipo_contactos f ON e.id_tipo_contacto = f.id_tipo_contacto AND f.descripcion = 'TELEFONO CELULAR'
JOIN tbl_contactos h ON a.id_persona = h.id_persona
JOIN tbl_tipo_contactos j ON h.id_tipo_contacto = j.id_tipo_contacto AND j.descripcion = 'TELEFONO FIJO'
JOIN tbl_contactos i ON a.id_persona = i.id_persona
JOIN tbl_tipo_contactos k ON i.id_tipo_contacto = k.id_tipo_contacto AND k.descripcion = 'DIRECCION'
join tbl_personas_extendidas as px on px.id_atributo=12 and px.id_persona=a.id_persona
WHERE a.id_persona='$id_persona'";

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

$resultado = mysqli_query($connection, $sql);
	$row = mysqli_fetch_array($resultado);

	

	$pdf = new PDF();
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont('Arial','B',15);
	$pdf->cell(0,6,utf8_decode('Universidad Nacional Autónoma de Honduras'),0,1,'C');
	$pdf->ln(2);
	$pdf->cell(0,6,utf8_decode('Facultad de Ciencias Economicas'),0,1,'C');
	$pdf->ln(2);
	$pdf->cell(0,6,utf8_decode('Departamento de Informática Administrativa'),0,1,'C');
	$pdf->ln();
	$pdf->SetFont('Arial','B',15);
	$pdf->cell(0,6,utf8_decode('Informacion del solicitante de práctica profesional'),0,1,'C');
	$pdf->ln(2);
	$pdf->SetFont('Arial','', 10);
	$pdf->ln(5);
    $pdf->Cell(0,5,utf8_decode('IA-PPS-01'),0,1,'C');
    $pdf->ln(10);
    
    $pdf->SetFont('Arial','BU',12);
	$pdf->ln(2);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode('DATOS PERSONALES '),0);
	$pdf->SetX(20);
    $pdf->ln(2);

    $pdf->SetFont('Arial','',12);
	$pdf->ln(2);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode('Numero de cuenta: '.$row['valor'].''),0);
	$pdf->SetX(20);
    $pdf->ln(2);
	$pdf->ln(2);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode('Identidad: '.$row['identidad'].''),0);
	$pdf->SetX(20);
    $pdf->ln(2);
    $pdf->ln(2);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode('Nombre del Alumno: '.$row['nombre'].''),0);
	$pdf->SetX(20);
    $pdf->ln(2);
    $pdf->ln(2);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode('Fecha de nacimiento: '.$row['fecha_nacimiento'].' Tel. Fijo: '.$row['Fijo'].'   Tel. Celular: '.$row['Celular'].''),0);
	$pdf->SetX(20);
    $pdf->ln(2);
    $pdf->ln(2);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode('Dirección: '.$row['Direccion'].''),0);
	$pdf->SetX(20);
    $pdf->ln(2);
    $pdf->ln(2);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode('Correo electrónico: '.$row['Correo'].''),0);
	$pdf->SetX(20);
    $pdf->ln(10);

    $pdf->SetFont('Arial','BU',12);
	$pdf->ln(2);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode('DATOS PRACTICA PROFESIONAL '),0);
	$pdf->SetX(20);
    $pdf->ln(2);
    $pdf->SetFont('Arial','',12);
	$pdf->ln(2);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode('Nombre de la institución: '.$row['nombre_empresa'].''),0);
    $pdf->SetX(20);
    $pdf->ln(2);
    $pdf->ln(2);
    $pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode('Tipo de empresa: '.$row['tipo_empresa'].' '),0);
    $pdf->SetX(20);
    $pdf->ln(2);
    $pdf->ln(2);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode('Dirección: '.$row['direccion_empresa'].''),0);
    $pdf->SetX(20);
    $pdf->ln(2);
    $pdf->ln(2);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode('Trabaja en la empresa: '.$row['labora_dentro'].' '),0);
    $pdf->SetX(20);
    $pdf->ln(2);
    $pdf->ln(2);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode('Nombre del jefe inmediato: '.$row['jefe_inmediato'].' '),0);
    $pdf->SetX(20);
    $pdf->ln(2);
    $pdf->ln(2);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode('Nombre del puesto: '.$row['cargo_jefe_inmediato'].' '),0);
    $pdf->SetX(20);
    $pdf->ln(2);
    $pdf->ln(2);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode('Titulo profesional: '.$row['titulo_jefe_inmediato'].' '),0);
    $pdf->SetX(20);
    $pdf->ln(2);
    $pdf->ln(2);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode('Correo electronico: '.$row['correo_jefe_inmediato'].' '),0);
    $pdf->SetX(20);
    $pdf->ln(2);
    $pdf->ln(2);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode('Fecha estimanda  de inicio de práctica: '.$row['fecha_inicio'].'     Fecha estimanda fin de práctica: '.$row['fecha_finaliza'].' '),0);

   
    
    
	
	
	
    

    
	

	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','I',12);
	$pdf->SetX(20);
	$pdf->SetX(20);


	$pdf->ln(30);
	$pdf->SetFont('Arial','I',10);
	$pdf->SetX(20);
    $pdf->multicell(0,5,utf8_decode('Comité de Vinculación Universidad Sociedad'),0,1,'C');
	$pdf->SetX(20);
    $pdf->multicell(0,5,utf8_decode('Práctica Profesional Supervisada'),0,1,'C');
	$pdf->Output();
	





	$pdf->Output();

?>
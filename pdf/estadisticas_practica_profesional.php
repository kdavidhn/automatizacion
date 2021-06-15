<?php
$fecha_inicio=$_GET["fecha_inicio"];
$fecha_fin=$_GET["fecha_fin"];
$empresa=$_GET["empresa"];
$docente=$_GET["docente"];
if(empty($fecha_fin) && empty($fecha_inicio) && empty($empresa) && empty($docente))
		{

//Inlcuímos a la clase PDF_MC_Table
require('PDF_MC_Table_h.php');			
//Instanciamos la clase para generar el documento pdf
$pdf=new PDF_MC_Table_h();
$pdf=new PDF_MC_Table_h('L','mm','Legal');
//Agregamos la primera página al documento pdf
$pdf->AddPage();

//Seteamos el inicio del margen superior en 25 pixeles 
$y_axis_initial = 25;
$pdf->Ln(10);

//Seteamos el tipo de letra y creamos el título de la página. No es un encabezado no se repetirá
$pdf->SetFont('Arial','B',17);

$pdf->Cell(5,6,'',0,0,'C');
$pdf->cell(0,6,utf8_decode('Universidad Nacional Autónoma de Honduras'),0,1,'C');
$pdf->ln(2);
$pdf->Cell(5,6,'',0,0,'C');
$pdf->cell(0,6,utf8_decode('Facultad de Ciencias Económicas'),0,1,'C');
$pdf->ln(2);
$pdf->Cell(5,6,'',0,0,'C');
$pdf->cell(0,6,utf8_decode('Departamento de Informática'),0,1,'C');
$pdf->Ln(30);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(20,6,'',0,0,'C');
$pdf->Cell(40,10,date('d/m/Y'),1,0,'C');
$pdf->Ln(1);
$pdf->Cell(120,6,'',0,0,'C');
$pdf->Cell(100,8,utf8_decode('REPORTE DE PRACTICANTES'),1,0,'C'); 
$pdf->Ln(15);

//$pdf->Cell(40,10,utf8_decode('Fecha de reporte'),1,0,'C'); 

//Creamos las celdas para los títulos de cada columna y le asignamos un fondo gris y el tipo de letra
$pdf->SetFillColor(232,232,232); 
$pdf->SetFont('Arial','B',10);
$pdf->Cell(10,6,'',0,0,'C');
$pdf->Cell(45,6,utf8_decode('Nombre Completo'),1,0,'C',1); 
$pdf->Cell(45,6,utf8_decode('Número de cuenta'),1,0,'C',1);
$pdf->Cell(45,6,utf8_decode('Empresa'),1,0,'C',1);
$pdf->Cell(45,6,utf8_decode('Dirección'),1,0,'C',1);
$pdf->Cell(45,6,utf8_decode('Supervisor Asignado'),1,0,'C',1);
$pdf->Cell(45,6,utf8_decode('Fecha de inicio'),1,0,'C',1);
$pdf->Cell(45,6,utf8_decode('Fecha de finalización'),1,0,'C',1);
$pdf->Ln(9);

//Comenzamos a crear las filas de los registros según la consulta mysql
require_once "../Modelos/estadisticas_practica_profesional_modelo.php";
$estadistica = new Estadisticas();

$rspta = $estadistica->listar();

//Implementamos las celdas de la tabla con los registros a mostrar

$pdf->SetWidths(array(45,45,45,45,45,45,45));


while($reg= $rspta->fetch_object())
{  
	$nombre=$reg->nombre;
	$valor=$reg->valor;
	$nombre_empresa=$reg->nombre_empresa;
	$direccion_empresa=$reg->direccion_empresa;
	$docente_supervisor=$reg->docente_supervisor;
    $fecha_inicio1=$reg->fecha_inicio;
    $fecha_finaliza=$reg->fecha_finaliza;

    $pdf->SetFont('Arial','',10);
    $pdf->Cell(10,6,'',0,0,'C');
    $pdf->Row(array(utf8_decode($nombre),utf8_decode($valor),utf8_decode($nombre_empresa),utf8_decode($direccion_empresa),utf8_decode($docente_supervisor),utf8_decode($fecha_inicio1),utf8_decode($fecha_finaliza)));
}
$pdf->ln(58);
$pdf->SetFont('Arial','I',10);
$pdf->SetX(20);
$pdf->multicell(0,5,utf8_decode('Comité de Vinculación Universidad Sociedad'),0,1,'C');
$pdf->SetX(20);
$pdf->multicell(0,5,utf8_decode('Práctica Profesional Supervisada'),0,1,'C');

//Mostramos el documento pdf
$pdf->Output();
		}
		elseif(empty($empresa) && empty($docente))
		{
			//Inlcuímos a la clase PDF_MC_Table
require('PDF_MC_Table_h.php');
			//Instanciamos la clase para generar el documento pdf
$pdf=new PDF_MC_Table_h();
$pdf=new PDF_MC_Table_h('L','mm','Legal');
//Agregamos la primera página al documento pdf
$pdf->AddPage();

//Seteamos el inicio del margen superior en 25 pixeles 
$y_axis_initial = 25;
$pdf->Ln(10);

//Seteamos el tipo de letra y creamos el título de la página. No es un encabezado no se repetirá
$pdf->SetFont('Arial','B',17);

$pdf->Cell(5,6,'',0,0,'C');
$pdf->cell(0,6,utf8_decode('Universidad Nacional Autónoma de Honduras'),0,1,'C');
$pdf->ln(2);
$pdf->Cell(5,6,'',0,0,'C');
$pdf->cell(0,6,utf8_decode('Facultad de Ciencias Económicas'),0,1,'C');
$pdf->ln(2);
$pdf->Cell(5,6,'',0,0,'C');
$pdf->cell(0,6,utf8_decode('Departamento de Informática'),0,1,'C');
$pdf->Ln(30);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(20,6,'',0,0,'C');
$pdf->Cell(40,10,date('d/m/Y'),1,0,'C');
$pdf->Ln(1);
$pdf->Cell(120,6,'',0,0,'C');
$pdf->Cell(100,8,utf8_decode('REPORTE DE PRACTICANTES'),1,0,'C'); 
$pdf->Ln(15);

//$pdf->Cell(40,10,utf8_decode('Fecha de reporte'),1,0,'C'); 

//Creamos las celdas para los títulos de cada columna y le asignamos un fondo gris y el tipo de letra
$pdf->SetFillColor(232,232,232); 
$pdf->SetFont('Arial','B',10);
$pdf->Cell(10,6,'',0,0,'C');
$pdf->Cell(45,6,utf8_decode('Nombre Completo'),1,0,'C',1); 
$pdf->Cell(45,6,utf8_decode('Número de cuenta'),1,0,'C',1);
$pdf->Cell(45,6,utf8_decode('Empresa'),1,0,'C',1);
$pdf->Cell(45,6,utf8_decode('Dirección'),1,0,'C',1);
$pdf->Cell(45,6,utf8_decode('Supervisor Asignado'),1,0,'C',1);
$pdf->Cell(45,6,utf8_decode('Fecha de inicio'),1,0,'C',1);
$pdf->Cell(45,6,utf8_decode('Fecha de finalización'),1,0,'C',1);
$pdf->Ln(9);

//Comenzamos a crear las filas de los registros según la consulta mysql
require_once "../Modelos/estadisticas_practica_profesional_modelo.php";
$estadistica = new Estadisticas();

$rspta = $estadistica->listar_fechas($fecha_inicio,$fecha_fin);

//Implementamos las celdas de la tabla con los registros a mostrar

$pdf->SetWidths(array(45,45,45,45,45,45,45));


while($reg= $rspta->fetch_object())
{  
	$nombre=$reg->nombre;
	$valor=$reg->valor;
	$nombre_empresa=$reg->nombre_empresa;
	$direccion_empresa=$reg->direccion_empresa;
	$docente_supervisor=$reg->docente_supervisor;
    $fecha_inicio1=$reg->fecha_inicio;
    $fecha_finaliza=$reg->fecha_finaliza;

    $pdf->SetFont('Arial','',10);
    $pdf->Cell(10,6,'',0,0,'C');
    $pdf->Row(array(utf8_decode($nombre),utf8_decode($valor),utf8_decode($nombre_empresa),utf8_decode($direccion_empresa),utf8_decode($docente_supervisor),utf8_decode($fecha_inicio1),utf8_decode($fecha_finaliza)));
}
$pdf->ln(58);
$pdf->SetFont('Arial','I',10);
$pdf->SetX(20);
$pdf->multicell(0,5,utf8_decode('Comité de Vinculación Universidad Sociedad'),0,1,'C');
$pdf->SetX(20);
$pdf->multicell(0,5,utf8_decode('Práctica Profesional Supervisada'),0,1,'C');

//Mostramos el documento pdf
$pdf->Output();
		}
		elseif( empty($empresa))
		{
						//Inlcuímos a la clase PDF_MC_Table
require('PDF_MC_Table_h.php');
//Instanciamos la clase para generar el documento pdf
$pdf=new PDF_MC_Table_h();
$pdf=new PDF_MC_Table_h('L','mm','Legal');
//Agregamos la primera página al documento pdf
$pdf->AddPage();

//Seteamos el inicio del margen superior en 25 pixeles 
$y_axis_initial = 25;
$pdf->Ln(10);

//Seteamos el tipo de letra y creamos el título de la página. No es un encabezado no se repetirá
$pdf->SetFont('Arial','B',17);

$pdf->Cell(5,6,'',0,0,'C');
$pdf->cell(0,6,utf8_decode('Universidad Nacional Autónoma de Honduras'),0,1,'C');
$pdf->ln(2);
$pdf->Cell(5,6,'',0,0,'C');
$pdf->cell(0,6,utf8_decode('Facultad de Ciencias Económicas'),0,1,'C');
$pdf->ln(2);
$pdf->Cell(5,6,'',0,0,'C');
$pdf->cell(0,6,utf8_decode('Departamento de Informática'),0,1,'C');
$pdf->Ln(30);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(20,6,'',0,0,'C');
$pdf->Cell(40,10,date('d/m/Y'),1,0,'C');
$pdf->Ln(1);
$pdf->Cell(120,6,'',0,0,'C');
$pdf->Cell(100,8,utf8_decode('REPORTE DE PRACTICANTES'),1,0,'C'); 
$pdf->Ln(15);

//$pdf->Cell(40,10,utf8_decode('Fecha de reporte'),1,0,'C'); 

//Creamos las celdas para los títulos de cada columna y le asignamos un fondo gris y el tipo de letra
$pdf->SetFillColor(232,232,232); 
$pdf->SetFont('Arial','B',10);
$pdf->Cell(10,6,'',0,0,'C');
$pdf->Cell(45,6,utf8_decode('Nombre Completo'),1,0,'C',1); 
$pdf->Cell(45,6,utf8_decode('Número de cuenta'),1,0,'C',1);
$pdf->Cell(45,6,utf8_decode('Empresa'),1,0,'C',1);
$pdf->Cell(45,6,utf8_decode('Dirección'),1,0,'C',1);
$pdf->Cell(45,6,utf8_decode('Supervisor Asignado'),1,0,'C',1);
$pdf->Cell(45,6,utf8_decode('Fecha de inicio'),1,0,'C',1);
$pdf->Cell(45,6,utf8_decode('Fecha de finalización'),1,0,'C',1);
$pdf->Ln(9);

//Comenzamos a crear las filas de los registros según la consulta mysql
require_once "../Modelos/estadisticas_practica_profesional_modelo.php";
$estadistica = new Estadisticas();

$rspta = $estadistica->listar_fechas_docente($fecha_inicio,$fecha_fin,$docente);

//Implementamos las celdas de la tabla con los registros a mostrar

$pdf->SetWidths(array(45,45,45,45,45,45,45));


while($reg= $rspta->fetch_object())
{  
$nombre=$reg->nombre;
$valor=$reg->valor;
$nombre_empresa=$reg->nombre_empresa;
$direccion_empresa=$reg->direccion_empresa;
$docente_supervisor=$reg->docente_supervisor;
$fecha_inicio1=$reg->fecha_inicio;
$fecha_finaliza=$reg->fecha_finaliza;

$pdf->SetFont('Arial','',10);
$pdf->Cell(10,6,'',0,0,'C');
$pdf->Row(array(utf8_decode($nombre),utf8_decode($valor),utf8_decode($nombre_empresa),utf8_decode($direccion_empresa),utf8_decode($docente_supervisor),utf8_decode($fecha_inicio1),utf8_decode($fecha_finaliza)));
}
$pdf->ln(58);
$pdf->SetFont('Arial','I',10);
$pdf->SetX(20);
$pdf->multicell(0,5,utf8_decode('Comité de Vinculación Universidad Sociedad'),0,1,'C');
$pdf->SetX(20);
$pdf->multicell(0,5,utf8_decode('Práctica Profesional Supervisada'),0,1,'C');

//Mostramos el documento pdf
$pdf->Output();
		}
		elseif(empty($fecha_fin) && empty($fecha_inicio) && empty($docente))
		{
									//Inlcuímos a la clase PDF_MC_Table
require('PDF_MC_Table_h.php');
//Instanciamos la clase para generar el documento pdf
$pdf=new PDF_MC_Table_h();
$pdf=new PDF_MC_Table_h('L','mm','Legal');
//Agregamos la primera página al documento pdf
$pdf->AddPage();

//Seteamos el inicio del margen superior en 25 pixeles 
$y_axis_initial = 25;
$pdf->Ln(10);

//Seteamos el tipo de letra y creamos el título de la página. No es un encabezado no se repetirá
$pdf->SetFont('Arial','B',17);

$pdf->Cell(5,6,'',0,0,'C');
$pdf->cell(0,6,utf8_decode('Universidad Nacional Autónoma de Honduras'),0,1,'C');
$pdf->ln(2);
$pdf->Cell(5,6,'',0,0,'C');
$pdf->cell(0,6,utf8_decode('Facultad de Ciencias Económicas'),0,1,'C');
$pdf->ln(2);
$pdf->Cell(5,6,'',0,0,'C');
$pdf->cell(0,6,utf8_decode('Departamento de Informática'),0,1,'C');
$pdf->Ln(30);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(20,6,'',0,0,'C');
$pdf->Cell(40,10,date('d/m/Y'),1,0,'C');
$pdf->Ln(1);
$pdf->Cell(120,6,'',0,0,'C');
$pdf->Cell(100,8,utf8_decode('REPORTE DE PRACTICANTES'),1,0,'C'); 
$pdf->Ln(15);

//$pdf->Cell(40,10,utf8_decode('Fecha de reporte'),1,0,'C'); 

//Creamos las celdas para los títulos de cada columna y le asignamos un fondo gris y el tipo de letra
$pdf->SetFillColor(232,232,232); 
$pdf->SetFont('Arial','B',10);
$pdf->Cell(10,6,'',0,0,'C');
$pdf->Cell(45,6,utf8_decode('Nombre Completo'),1,0,'C',1); 
$pdf->Cell(45,6,utf8_decode('Número de cuenta'),1,0,'C',1);
$pdf->Cell(45,6,utf8_decode('Empresa'),1,0,'C',1);
$pdf->Cell(45,6,utf8_decode('Dirección'),1,0,'C',1);
$pdf->Cell(45,6,utf8_decode('Supervisor Asignado'),1,0,'C',1);
$pdf->Cell(45,6,utf8_decode('Fecha de inicio'),1,0,'C',1);
$pdf->Cell(45,6,utf8_decode('Fecha de finalización'),1,0,'C',1);
$pdf->Ln(9);

//Comenzamos a crear las filas de los registros según la consulta mysql
require_once "../Modelos/estadisticas_practica_profesional_modelo.php";
$estadistica = new Estadisticas();

$rspta = $estadistica->listar_empresa($empresa);

//Implementamos las celdas de la tabla con los registros a mostrar

$pdf->SetWidths(array(45,45,45,45,45,45,45));


while($reg= $rspta->fetch_object())
{  
$nombre=$reg->nombre;
$valor=$reg->valor;
$nombre_empresa=$reg->nombre_empresa;
$direccion_empresa=$reg->direccion_empresa;
$docente_supervisor=$reg->docente_supervisor;
$fecha_inicio1=$reg->fecha_inicio;
$fecha_finaliza=$reg->fecha_finaliza;

$pdf->SetFont('Arial','',10);
$pdf->Cell(10,6,'',0,0,'C');
$pdf->Row(array(utf8_decode($nombre),utf8_decode($valor),utf8_decode($nombre_empresa),utf8_decode($direccion_empresa),utf8_decode($docente_supervisor),utf8_decode($fecha_inicio1),utf8_decode($fecha_finaliza)));
}
$pdf->ln(58);
$pdf->SetFont('Arial','I',10);
$pdf->SetX(20);
$pdf->multicell(0,5,utf8_decode('Comité de Vinculación Universidad Sociedad'),0,1,'C');
$pdf->SetX(20);
$pdf->multicell(0,5,utf8_decode('Práctica Profesional Supervisada'),0,1,'C');

//Mostramos el documento pdf
$pdf->Output();
		}
		elseif(empty($fecha_fin) && empty($fecha_inicio) && empty($empresa))
		{
												//Inlcuímos a la clase PDF_MC_Table
require('PDF_MC_Table_h.php');
//Instanciamos la clase para generar el documento pdf
$pdf=new PDF_MC_Table_h();
$pdf=new PDF_MC_Table_h('L','mm','Legal');
//Agregamos la primera página al documento pdf
$pdf->AddPage();

//Seteamos el inicio del margen superior en 25 pixeles 
$y_axis_initial = 25;
$pdf->Ln(10);

//Seteamos el tipo de letra y creamos el título de la página. No es un encabezado no se repetirá
$pdf->SetFont('Arial','B',17);

$pdf->Cell(5,6,'',0,0,'C');
$pdf->cell(0,6,utf8_decode('Universidad Nacional Autónoma de Honduras'),0,1,'C');
$pdf->ln(2);
$pdf->Cell(5,6,'',0,0,'C');
$pdf->cell(0,6,utf8_decode('Facultad de Ciencias Económicas'),0,1,'C');
$pdf->ln(2);
$pdf->Cell(5,6,'',0,0,'C');
$pdf->cell(0,6,utf8_decode('Departamento de Informática'),0,1,'C');
$pdf->Ln(30);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(20,6,'',0,0,'C');
$pdf->Cell(40,10,date('d/m/Y'),1,0,'C');
$pdf->Ln(1);
$pdf->Cell(120,6,'',0,0,'C');
$pdf->Cell(100,8,utf8_decode('REPORTE DE PRACTICANTES'),1,0,'C'); 
$pdf->Ln(15);

//$pdf->Cell(40,10,utf8_decode('Fecha de reporte'),1,0,'C'); 

//Creamos las celdas para los títulos de cada columna y le asignamos un fondo gris y el tipo de letra
$pdf->SetFillColor(232,232,232); 
$pdf->SetFont('Arial','B',10);
$pdf->Cell(10,6,'',0,0,'C');
$pdf->Cell(45,6,utf8_decode('Nombre Completo'),1,0,'C',1); 
$pdf->Cell(45,6,utf8_decode('Número de cuenta'),1,0,'C',1);
$pdf->Cell(45,6,utf8_decode('Empresa'),1,0,'C',1);
$pdf->Cell(45,6,utf8_decode('Dirección'),1,0,'C',1);
$pdf->Cell(45,6,utf8_decode('Supervisor Asignado'),1,0,'C',1);
$pdf->Cell(45,6,utf8_decode('Fecha de inicio'),1,0,'C',1);
$pdf->Cell(45,6,utf8_decode('Fecha de finalización'),1,0,'C',1);
$pdf->Ln(9);

//Comenzamos a crear las filas de los registros según la consulta mysql
require_once "../Modelos/estadisticas_practica_profesional_modelo.php";
$estadistica = new Estadisticas();

$rspta = $estadistica->listar_empresa($empresa);

//Implementamos las celdas de la tabla con los registros a mostrar

$pdf->SetWidths(array(45,45,45,45,45,45,45));


while($reg= $rspta->fetch_object())
{  
$nombre=$reg->nombre;
$valor=$reg->valor;
$nombre_empresa=$reg->nombre_empresa;
$direccion_empresa=$reg->direccion_empresa;
$docente_supervisor=$reg->docente_supervisor;
$fecha_inicio1=$reg->fecha_inicio;
$fecha_finaliza=$reg->fecha_finaliza;

$pdf->SetFont('Arial','',10);
$pdf->Cell(10,6,'',0,0,'C');
$pdf->Row(array(utf8_decode($nombre),utf8_decode($valor),utf8_decode($nombre_empresa),utf8_decode($direccion_empresa),utf8_decode($docente_supervisor),utf8_decode($fecha_inicio1),utf8_decode($fecha_finaliza)));
}
$pdf->ln(58);
$pdf->SetFont('Arial','I',10);
$pdf->SetX(20);
$pdf->multicell(0,5,utf8_decode('Comité de Vinculación Universidad Sociedad'),0,1,'C');
$pdf->SetX(20);
$pdf->multicell(0,5,utf8_decode('Práctica Profesional Supervisada'),0,1,'C');

//Mostramos el documento pdf
$pdf->Output();
		}
		else
		{
															//Inlcuímos a la clase PDF_MC_Table
require('PDF_MC_Table_h.php');
//Instanciamos la clase para generar el documento pdf
$pdf=new PDF_MC_Table_h();
$pdf=new PDF_MC_Table_h('L','mm','Legal');
//Agregamos la primera página al documento pdf
$pdf->AddPage();

//Seteamos el inicio del margen superior en 25 pixeles 
$y_axis_initial = 25;
$pdf->Ln(10);

//Seteamos el tipo de letra y creamos el título de la página. No es un encabezado no se repetirá
$pdf->SetFont('Arial','B',17);

$pdf->Cell(5,6,'',0,0,'C');
$pdf->cell(0,6,utf8_decode('Universidad Nacional Autónoma de Honduras'),0,1,'C');
$pdf->ln(2);
$pdf->Cell(5,6,'',0,0,'C');
$pdf->cell(0,6,utf8_decode('Facultad de Ciencias Económicas'),0,1,'C');
$pdf->ln(2);
$pdf->Cell(5,6,'',0,0,'C');
$pdf->cell(0,6,utf8_decode('Departamento de Informática'),0,1,'C');
$pdf->Ln(30);
$pdf->SetFont('Arial','B',12);
$pdf->Cell(20,6,'',0,0,'C');
$pdf->Cell(40,10,date('d/m/Y'),1,0,'C');
$pdf->Ln(1);
$pdf->Cell(120,6,'',0,0,'C');
$pdf->Cell(100,8,utf8_decode('REPORTE DE PRACTICANTES'),1,0,'C'); 
$pdf->Ln(15);

//$pdf->Cell(40,10,utf8_decode('Fecha de reporte'),1,0,'C'); 

//Creamos las celdas para los títulos de cada columna y le asignamos un fondo gris y el tipo de letra
$pdf->SetFillColor(232,232,232); 
$pdf->SetFont('Arial','B',10);
$pdf->Cell(10,6,'',0,0,'C');
$pdf->Cell(45,6,utf8_decode('Nombre Completo'),1,0,'C',1); 
$pdf->Cell(45,6,utf8_decode('Número de cuenta'),1,0,'C',1);
$pdf->Cell(45,6,utf8_decode('Empresa'),1,0,'C',1);
$pdf->Cell(45,6,utf8_decode('Dirección'),1,0,'C',1);
$pdf->Cell(45,6,utf8_decode('Supervisor Asignado'),1,0,'C',1);
$pdf->Cell(45,6,utf8_decode('Fecha de inicio'),1,0,'C',1);
$pdf->Cell(45,6,utf8_decode('Fecha de finalización'),1,0,'C',1);
$pdf->Ln(9);

//Comenzamos a crear las filas de los registros según la consulta mysql
require_once "../Modelos/estadisticas_practica_profesional_modelo.php";
$estadistica = new Estadisticas();

$rspta = $estadistica->listar_fechas_docente_empresa($fecha_inicio,$fecha_fin,$empresa,$docente);

//Implementamos las celdas de la tabla con los registros a mostrar

$pdf->SetWidths(array(45,45,45,45,45,45,45));


while($reg= $rspta->fetch_object())
{  
$nombre=$reg->nombre;
$valor=$reg->valor;
$nombre_empresa=$reg->nombre_empresa;
$direccion_empresa=$reg->direccion_empresa;
$docente_supervisor=$reg->docente_supervisor;
$fecha_inicio1=$reg->fecha_inicio;
$fecha_finaliza=$reg->fecha_finaliza;

$pdf->SetFont('Arial','',10);
$pdf->Cell(10,6,'',0,0,'C');
$pdf->Row(array(utf8_decode($nombre),utf8_decode($valor),utf8_decode($nombre_empresa),utf8_decode($direccion_empresa),utf8_decode($docente_supervisor),utf8_decode($fecha_inicio1),utf8_decode($fecha_finaliza)));
}
$pdf->ln(58);
$pdf->SetFont('Arial','I',10);
$pdf->SetX(20);
$pdf->multicell(0,5,utf8_decode('Comité de Vinculación Universidad Sociedad'),0,1,'C');
$pdf->SetX(20);
$pdf->multicell(0,5,utf8_decode('Práctica Profesional Supervisada'),0,1,'C');

//Mostramos el documento pdf
$pdf->Output();
		}
?>
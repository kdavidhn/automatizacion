<?php
require_once "../Modelos/asignar_docente_supervisor_modelo.php";
require_once "corre_supervisor.php";



$modelo=new asignaturas();
$id_supervisor=isset($_POST["id_supervisor"])? $instancia_conexion->limpiarCadena($_POST["id_supervisor"]):"";
$nombre_alumno=isset($_POST["nombre_alumno"]);
$cuenta=isset($_POST["cuenta"]);
$docente=isset($_POST["docente"])? $instancia_conexion->limpiarCadena($_POST["docente"]):"";



switch ($_GET["op"]){

	

	case 'editar':

			$rspta=$modelo->editar($docente,$id_supervisor);


			echo $rspta ? "DOCENTE SUPERVISOR ASIGNADO CORRECTAMENTE." : "DOCENTE SUPERVISOR NO SE PUDO ASIGNAR";
			//query para los datos de alumnos
		

			$rspta1=$modelo->mostrar_datos_alumno($id_supervisor)->fetch_all();
				foreach ($rspta1 as $key => $value) {

				$estudiante= $value[1];
				$num_cuenta= $value[0];
				$ecorreo= $value[6];
				$celular= $value[7];
				$empresa= $value[2];
				$direccion= $value[3];
				$fechai= $value[4];
				$fechan= $value[5];
				$jefe= $value[8];
				$titulo= $value[9];
				$correo= new correo();
					
				
				
			} // fin del query para los datos del alumno
//query para los datos del docente
				$rspta2=$modelo->mostrar_datos_docente($docente)->fetch_all();
			foreach ($rspta2 as $key => $value)
			 {
				$asunto_docente="ASIGNACIÓN DE SUPERVISIÓN DE PRACTICA PROFESIONAL";
				$asunto_estudiante="ASIGNACIÓN DE DOCENTE SUPERVISOR";
				$destino = $value[1];
				$nombre_destino= $value[0];
			
	   		}// fin del query de los datos del docente

			//Correo de docente

			
			//print_r($->fetch_all());
			//cuerpo del correo del docente
			$cuerpo='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml" xmlns="http://www.w3.org/1999/xhtml">
			<head>
			<meta name="viewport" content="width=device-width, initial-scale=1.0" />
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
			<title>------------</title>

			</head>
			<body style="-webkit-text-size-adjust: none; box-sizing: border-box; color: #74787E; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; height: 100%; line-height: 1.4; margin: 0; width: 100% !important;" bgcolor="#F2F4F6"><style type="text/css">
			body {
			width: 100% !important; height: 100%; margin: 0; line-height: 1.4; background-color: #F2F4F6; color: #74787E; -webkit-text-size-adjust: none;
			}
			@media only screen and (max-width: 600px) {
			.email-body_inner {
			width: 100% !important;
			}
			.email-footer {
			width: 100% !important;
			}
			}
			@media only screen and (max-width: 500px) {
			.button {
			width: 100% !important;
			}
			}
			</style>
			<table class="email-wrapper" width="100%" cellpadding="0" cellspacing="0" style="box-sizing: border-box; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; margin: 0; padding: 0; width: 100%;" bgcolor="#F2F4F6">
			<tr>
			<td align="center" style="box-sizing: border-box; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; word-break: break-word;">
			<table class="email-content" width="100%" cellpadding="0" cellspacing="0" style="box-sizing: border-box; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; margin: 0; padding: 0; width: 100%;">
				<tr>
					<td class="email-masthead" style="box-sizing: border-box; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; padding: 25px 0; word-break: break-word;" align="center">
						<h2  class="email-masthead_name" style="box-sizing: border-box; color: #000000; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; font-size: 16px; font-weight: bold; text-decoration: none; text-shadow: 0 1px 0 white;">
			Comité de Vinculación Universidad Sociedad 
			</h2>
					</td>
				</tr>

				<tr>
					<td class="email-body" width="100%" cellpadding="0" cellspacing="0" style="-premailer-cellpadding: 0; -premailer-cellspacing: 0; border-bottom-color: #EDEFF2; border-bottom-style: solid; border-bottom-width: 1px; border-top-color: #EDEFF2; border-top-style: solid; border-top-width: 1px; box-sizing: border-box; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; margin: 0; padding: 0; width: 100%; word-break: break-word;" bgcolor="#FFFFFF">
						<table class="email-body_inner" align="center" width="800" cellpadding="0" cellspacing="0" style="box-sizing: border-box; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; margin: 0 auto; padding: 0; width: 570px;" bgcolor="#FFFFFF">


							<tr>
								<td class="content-cell" style="box-sizing: border-box; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; padding: 35px; word-break: break-word;">
									<h4 style="box-sizing: border-box; color: #2F3133; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; font-size: 19px; font-weight: bold; margin-top: 0;" align="left">Estimado: '.$nombre_destino.' </h4>


									<table class="body-action" align="center" width="100%" cellpadding="0" cellspacing="0" style="box-sizing: border-box; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; margin: 30px auto; padding: 0; text-align: center; width: 100%;">
										<tr>
											<td align="center" style="box-sizing: border-box; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; word-break: break-word;">

												<table width="100%" border="0" cellspacing="0" cellpadding="0" style="box-sizing: border-box; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;">
													<tr>
														<td align="center" style="box-sizing: border-box; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; word-break: break-word;">
															<table border="0" cellspacing="0" cellpadding="0" style="box-sizing: border-box; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;">
																<tr>
																	<td style="box-sizing: border-box; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; word-break: break-word;">

																	</td>
																</tr>
															</table>
														</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
									<p style="box-sizing: border-box; color: #000000; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; font-size: 16px; line-height: 1.5em; margin-top: 0;" align="left"> Reciba un cordial saludo. La presente comunicación, tiene por objeto proporcionar la oportunidad de garantizar como docente los principios de La universidad Nacional Autónoma de Honduras para dignificar la función social de la enseñanza universitaria, descrita en la Ley Orgánica, que indica la docencia exhibirá la variedad de sus formas (Docencia, Investigación y extensión).
			En esta ocasión a través de la extensión dándole la oportunidad de supervisar al estudiante con los siguientes datos:<br>
			<br> 1.	Nombre del estudiante: '.$estudiante.'
			<br> 2.	Número cuenta: '.$num_cuenta.'
			<br> 3.	Correo del estudiante: '.$ecorreo.'
			<br> 4.	teléfono del Estudiante: '.$celular.'
			<br> 5.	Nombre Empresa: '.$empresa.'
			<br> 6.	Ubicada en: '.$direccion.'
			<br> 7.	Contacto en la empresa: '.$jefe.'
			<br> 8.	Fecha de inicio: '.$fechai.'
			<br> 9.	Fecha de finalización: '.$fechan.'
			<br>
			<br>Usted puede consultar los datos dentro del Sistema de gestión administrativa del Departamento de Informática (SGADI), tambien puede comunicarse al correo uvinculacion.dia@unah.edu.hn.
			Agradeciendo su atención,
			</p>
									<p style="box-sizing: border-box; color: #000000; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; font-size: 16px; line-height: 1.5em; margin-top: 0;" align="left">
										<br />Coordinación del Departamento de Informática</p>

									<table class="body-sub" style="border-top-color: #EDEFF2; border-top-style: solid; border-top-width: 1px; box-sizing: border-box; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; margin-top: 25px; padding-top: 25px;">
										<tr>
											<td style="box-sizing: border-box; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; word-break: break-word;">

											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td style="box-sizing: border-box; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; word-break: break-word;">
						<table class="email-footer" align="center" width="570" cellpadding="0" cellspacing="0" style="box-sizing: border-box; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; margin: 0 auto; padding: 0; text-align: center; width: 570px;">
							<tr>
								<td class="content-cell" align="center" style="box-sizing: border-box; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; padding: 35px; word-break: break-word;">
									<p class="sub align-center" style="box-sizing: border-box; color: #000000; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; font-size: 12px; line-height: 1.5em; margin-top: 0;" align="center">Facultad de Ciencias Económicas <br/>Departamento de Informatica Administrativa <br/>Comité de Vinculación Universidad Sociedad</p>
									<p class="sub align-center" style="box-sizing: border-box; color: #000000; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; font-size: 12px; line-height: 1.5em; margin-top: 0;" align="center">

									</p>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			</td>
			</tr>
			</table>
			</body>
			</html>
			';
		$correo->enviarEmailDocente($cuerpo,$asunto_docente,$destino,$nombre_destino);
		//cuerpo de correo del estudiante
		$cuerpo_estudiante='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml" xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>------------</title>

		</head>
		<body style="-webkit-text-size-adjust: none; box-sizing: border-box; color: #74787E; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; height: 100%; line-height: 1.4; margin: 0; width: 100% !important;" bgcolor="#F2F4F6"><style type="text/css">
		body {
		width: 100% !important; height: 100%; margin: 0; line-height: 1.4; background-color: #F2F4F6; color: #74787E; -webkit-text-size-adjust: none;
		}
		@media only screen and (max-width: 600px) {
		.email-body_inner {
		width: 100% !important;
		}
		.email-footer {
		width: 100% !important;
		}
		}
		@media only screen and (max-width: 500px) {
		.button {
		width: 100% !important;
		}
		}
		</style>
		<table class="email-wrapper" width="100%" cellpadding="0" cellspacing="0" style="box-sizing: border-box; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; margin: 0; padding: 0; width: 100%;" bgcolor="#F2F4F6">
		<tr>
		<td align="center" style="box-sizing: border-box; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; word-break: break-word;">
		<table class="email-content" width="100%" cellpadding="0" cellspacing="0" style="box-sizing: border-box; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; margin: 0; padding: 0; width: 100%;">
			<tr>
				<td class="email-masthead" style="box-sizing: border-box; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; padding: 25px 0; word-break: break-word;" align="center">
					<h2  class="email-masthead_name" style="box-sizing: border-box; color: #000000; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; font-size: 16px; font-weight: bold; text-decoration: none; text-shadow: 0 1px 0 white;">
		Comité de Vinculación Universidad Sociedad 
		</h2>
				</td>
			</tr>

			<tr>
				<td class="email-body" width="100%" cellpadding="0" cellspacing="0" style="-premailer-cellpadding: 0; -premailer-cellspacing: 0; border-bottom-color: #EDEFF2; border-bottom-style: solid; border-bottom-width: 1px; border-top-color: #EDEFF2; border-top-style: solid; border-top-width: 1px; box-sizing: border-box; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; margin: 0; padding: 0; width: 100%; word-break: break-word;" bgcolor="#FFFFFF">
					<table class="email-body_inner" align="center" width="800" cellpadding="0" cellspacing="0" style="box-sizing: border-box; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; margin: 0 auto; padding: 0; width: 570px;" bgcolor="#FFFFFF">


						<tr>
							<td class="content-cell" style="box-sizing: border-box; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; padding: 35px; word-break: break-word;">
								<h4 style="box-sizing: border-box; color: #2F3133; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; font-size: 19px; font-weight: bold; margin-top: 0;" align="left">Estimado estudiante: '.$estudiante.' </h4>


								<table class="body-action" align="center" width="100%" cellpadding="0" cellspacing="0" style="box-sizing: border-box; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; margin: 30px auto; padding: 0; text-align: center; width: 100%;">
									<tr>
										<td align="center" style="box-sizing: border-box; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; word-break: break-word;">

											<table width="100%" border="0" cellspacing="0" cellpadding="0" style="box-sizing: border-box; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;">
												<tr>
													<td align="center" style="box-sizing: border-box; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; word-break: break-word;">
														<table border="0" cellspacing="0" cellpadding="0" style="box-sizing: border-box; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;">
															<tr>
																<td style="box-sizing: border-box; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; word-break: break-word;">

																</td>
															</tr>
														</table>
													</td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
								<p style="box-sizing: border-box; color: #000000; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; font-size: 16px; line-height: 1.5em; margin-top: 0;" align="left">
		Reciba un cordial saludo. La presente comunicación, tiene por objeto proporcionar la información de su docente supervisor:<br/>
		<br/> 1.	Nombre del docente: '.$nombre_destino.'
		<br/> 2.	Correo institucional: '.$destino.'
		<br/>
		<br/>Su docente supervisor se estará comunicado con Usted, en caso contrario, y transcurrido exactamente un mes, después de la fecha de aprobación de su Práctica Profesional comuníquese con su docente supervisor a través del correo institucional, y envié copia al correo  uvinculacion.dia@unah.edu.hn,
		</p>
								<p style="box-sizing: border-box; color: #000000; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; font-size: 16px; line-height: 1.5em; margin-top: 0;" align="left">
									<br />Coordinación del Departamento de Informática</p>

								<table class="body-sub" style="border-top-color: #EDEFF2; border-top-style: solid; border-top-width: 1px; box-sizing: border-box; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; margin-top: 25px; padding-top: 25px;">
									<tr>
										<td style="box-sizing: border-box; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; word-break: break-word;">

										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td style="box-sizing: border-box; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; word-break: break-word;">
					<table class="email-footer" align="center" width="570" cellpadding="0" cellspacing="0" style="box-sizing: border-box; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; margin: 0 auto; padding: 0; text-align: center; width: 570px;">
						<tr>
							<td class="content-cell" align="center" style="box-sizing: border-box; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; padding: 35px; word-break: break-word;">
								<p class="sub align-center" style="box-sizing: border-box; color: #000000; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; font-size: 12px; line-height: 1.5em; margin-top: 0;" align="center">Facultad de Ciencias Económicas <br/>Departamento de Informatica Administrativa <br/>Comité de Vinculación Universidad Sociedad</p>
								<p class="sub align-center" style="box-sizing: border-box; color: #000000; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif; font-size: 12px; line-height: 1.5em; margin-top: 0;" align="center">

								</p>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		</td>
		</tr>
		</table>
		</body>
		</html>
		';
		$correo->enviarEmailPracticante($cuerpo_estudiante,$asunto_estudiante,$ecorreo,$estudiante);
	break;

	case 'desactivar':
		$rspta=$modelo->desactivar($id_asignatura);
 		echo $rspta ? "Asignatura Desactivada con exito" : "Asignatura no se puede desactivar";
 		break;

	case 'activar':
		$rspta=$modelo->activar($id_asignatura);
 		echo $rspta ? "Asignatura activada con exito" : "Asignatura no se puede activar";
 		break;

	case 'mostrar':
		$rspta=$modelo->mostrar($id_supervisor);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
 		break;

	case 'listar':
		$rspta=$modelo->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){

			 $estado="";
			 $botones='<center><div class="input-group mr-2" ><form  action="../vistas/docente_supervisor_vista.php?id_persona='.$reg->id_persona.'" method="post"><button class="btn btn-primary btn-raised btn-sm" onclick="mostrar('.$reg->id_persona.')" name="id_asignatura" value="'.$reg->id_persona.'"> <i class="fa fa-edit"></i> </button></form></div></center>';



 			$data[]=array(

 				"0"=>$botones,
       			"1"=>$reg->nombre,
 				"2"=>$reg->valor,
				"3"=>$reg->nombre_empresa,
				"4"=>$reg->direccion_empresa,
				"5"=>$reg->fecha_inicio,
				"6"=>$reg->fecha_finaliza


 				);
		 }

 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;
}


?>

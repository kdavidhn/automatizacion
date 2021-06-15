<?php 
require_once "../Modelos/estadisticas_practica_profesional_modelo.php";

$estadistica = new Estadisticas();

switch ($_GET["op"]){
	    
	case 'listar':

		$fecha_inicio=$_REQUEST["fecha_inicio"];
		$fecha_fin=$_REQUEST["fecha_fin"];
		$empresa=$_REQUEST["empresa"];
		$docente=$_REQUEST["docente"];

		if(empty($fecha_fin) && empty($fecha_inicio) && empty($empresa) && empty($docente))
		{
			$rspta=$estadistica->listar();
			//Vamos a declarar un array
			$data= Array();
            
			while ($reg=$rspta->fetch_object()){
                $primera_supervision='<center><a href="../pdf/primera_visita_pdf.php?id="'.$reg->id_persona.'"" target="_blank"  class="btn btn-secondary btn-raisedx btn-xs" >PDF</a><center>';
                $segunda_supervicion='<center><a href="../pdf/segunda_visita_pdf.php?id="'.$reg->id_persona.'""  target="_blank" class="btn btn-secondary btn-raisedx btn-xs" >PDF</a></center>';
                $unica_supervision='<center><a href="../pdf/unica_visita_pdf.php?id="'.$reg->id_persona.'""  target="_blank" class="btn btn-secondary btn-raisedx btn-xs" >PDF</a></center>';
				$data[]=array(
					"0"=>$reg->nombre,
					"1"=>$reg->valor,
					"2"=>$reg->nombre_empresa,
					"3"=>$reg->direccion_empresa,
					"4"=>$reg->docente_supervisor,
                    "5"=>$reg->fecha_inicio,
                    "6"=>$reg->fecha_finaliza,
                    "7"=>$primera_supervision,
                    "8"=>$segunda_supervicion,
                    "9"=>$unica_supervision
							
					);
			}
			$results = array(
				"sEcho"=>1, //Información para el datatables
				"iTotalRecords"=>count($data), //enviamos el total registros al datatable
				"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
				"aaData"=>$data);
			echo json_encode($results);
		}
		elseif(empty($empresa) && empty($docente))
		{
			$rspta=$estadistica->listar_fechas($fecha_inicio,$fecha_fin);
			//Vamos a declarar un array
			$data= Array();
            
			while ($reg=$rspta->fetch_object()){
                $primera_supervision='<center><a href="../pdf/primera_visita_pdf.php?id="'.$reg->id_persona.'"" target="_blank"  class="btn btn-secondary btn-raisedx btn-xs" >PDF</a><center>';
                $segunda_supervicion='<center><a href="../pdf/segunda_visita_pdf.php?id="'.$reg->id_persona.'""  target="_blank" class="btn btn-secondary btn-raisedx btn-xs" >PDF</a></center>';
                $unica_supervision='<center><a href="../pdf/unica_visita_pdf.php?id="'.$reg->id_persona.'""  target="_blank" class="btn btn-secondary btn-raisedx btn-xs" >PDF</a></center>';
				$data[]=array(
					"0"=>$reg->nombre,
					"1"=>$reg->valor,
					"2"=>$reg->nombre_empresa,
					"3"=>$reg->direccion_empresa,
					"4"=>$reg->docente_supervisor,
                    "5"=>$reg->fecha_inicio,
                    "6"=>$reg->fecha_finaliza,
                    "7"=>$primera_supervision,
                    "8"=>$segunda_supervicion,
                    "9"=>$unica_supervision
							
					);
			}
			$results = array(
				"sEcho"=>1, //Información para el datatables
				"iTotalRecords"=>count($data), //enviamos el total registros al datatable
				"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
				"aaData"=>$data);
			echo json_encode($results);
		}
		elseif( empty($empresa))
		{
			$rspta=$estadistica->listar_fechas_docente($fecha_inicio,$fecha_fin,$docente);
			//Vamos a declarar un array
			$data= Array();
            
			while ($reg=$rspta->fetch_object()){
                $primera_supervision='<center><a href="../pdf/primera_visita_pdf.php?id="'.$reg->id_persona.'"" target="_blank"  class="btn btn-secondary btn-raisedx btn-xs" >PDF</a><center>';
                $segunda_supervicion='<center><a href="../pdf/segunda_visita_pdf.php?id="'.$reg->id_persona.'""  target="_blank" class="btn btn-secondary btn-raisedx btn-xs" >PDF</a></center>';
                $unica_supervision='<center><a href="../pdf/unica_visita_pdf.php?id="'.$reg->id_persona.'""  target="_blank" class="btn btn-secondary btn-raisedx btn-xs" >PDF</a></center>';
				$data[]=array(
					"0"=>$reg->nombre,
					"1"=>$reg->valor,
					"2"=>$reg->nombre_empresa,
					"3"=>$reg->direccion_empresa,
					"4"=>$reg->docente_supervisor,
                    "5"=>$reg->fecha_inicio,
                    "6"=>$reg->fecha_finaliza,
                    "7"=>$primera_supervision,
                    "8"=>$segunda_supervicion,
                    "9"=>$unica_supervision
							
					);
			}
			$results = array(
				"sEcho"=>1, //Información para el datatables
				"iTotalRecords"=>count($data), //enviamos el total registros al datatable
				"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
				"aaData"=>$data);
			echo json_encode($results);
		}
		elseif(empty($fecha_fin) && empty($fecha_inicio) && empty($docente))
		{
			$rspta=$estadistica->listar_empresa($empresa);
			//Vamos a declarar un array
			$data= Array();
            
			while ($reg=$rspta->fetch_object()){
                $primera_supervision='<center><a href="../pdf/primera_visita_pdf.php?id="'.$reg->id_persona.'"" target="_blank"  class="btn btn-secondary btn-raisedx btn-xs" >PDF</a><center>';
                $segunda_supervicion='<center><a href="../pdf/segunda_visita_pdf.php?id="'.$reg->id_persona.'""  target="_blank" class="btn btn-secondary btn-raisedx btn-xs" >PDF</a></center>';
                $unica_supervision='<center><a href="../pdf/unica_visita_pdf.php?id="'.$reg->id_persona.'""  target="_blank" class="btn btn-secondary btn-raisedx btn-xs" >PDF</a></center>';
				$data[]=array(
					"0"=>$reg->nombre,
					"1"=>$reg->valor,
					"2"=>$reg->nombre_empresa,
					"3"=>$reg->direccion_empresa,
					"4"=>$reg->docente_supervisor,
                    "5"=>$reg->fecha_inicio,
                    "6"=>$reg->fecha_finaliza,
                    "7"=>$primera_supervision,
                    "8"=>$segunda_supervicion,
                    "9"=>$unica_supervision
							
					);
			}
			$results = array(
				"sEcho"=>1, //Información para el datatables
				"iTotalRecords"=>count($data), //enviamos el total registros al datatable
				"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
				"aaData"=>$data);
			echo json_encode($results);
		}
		elseif(empty($fecha_fin) && empty($fecha_inicio) && empty($empresa))
		{
			$rspta=$estadistica->listar_docente($docente);
			//Vamos a declarar un array
			$data= Array();
            
			while ($reg=$rspta->fetch_object()){
                $primera_supervision='<center><a href="../pdf/primera_visita_pdf.php?id="'.$reg->id_persona.'"" target="_blank"  class="btn btn-secondary btn-raisedx btn-xs" >PDF</a><center>';
                $segunda_supervicion='<center><a href="../pdf/segunda_visita_pdf.php?id="'.$reg->id_persona.'""  target="_blank" class="btn btn-secondary btn-raisedx btn-xs" >PDF</a></center>';
                $unica_supervision='<center><a href="../pdf/unica_visita_pdf.php?id="'.$reg->id_persona.'""  target="_blank" class="btn btn-secondary btn-raisedx btn-xs" >PDF</a></center>';
				$data[]=array(
					"0"=>$reg->nombre,
					"1"=>$reg->valor,
					"2"=>$reg->nombre_empresa,
					"3"=>$reg->direccion_empresa,
					"4"=>$reg->docente_supervisor,
                    "5"=>$reg->fecha_inicio,
                    "6"=>$reg->fecha_finaliza,
                    "7"=>$primera_supervision,
                    "8"=>$segunda_supervicion,
                    "9"=>$unica_supervision
							
					);
			}
			$results = array(
				"sEcho"=>1, //Información para el datatables
				"iTotalRecords"=>count($data), //enviamos el total registros al datatable
				"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
				"aaData"=>$data);
			echo json_encode($results);
		}
		else
		{
			$rspta=$estadistica->listar_fechas_docente_empresa($fecha_inicio,$fecha_fin,$empresa,$docente);
			//Vamos a declarar un array
			$data= Array();
            
			while ($reg=$rspta->fetch_object()){
                $primera_supervision='<center><a href="../pdf/primera_visita_pdf.php?id="'.$reg->id_persona.'"" target="_blank"  class="btn btn-secondary btn-raisedx btn-xs" >PDF</a><center>';
                $segunda_supervicion='<center><a href="../pdf/segunda_visita_pdf.php?id="'.$reg->id_persona.'""  target="_blank" class="btn btn-secondary btn-raisedx btn-xs" >PDF</a></center>';
                $unica_supervision='<center><a href="../pdf/unica_visita_pdf.php?id="'.$reg->id_persona.'""  target="_blank" class="btn btn-secondary btn-raisedx btn-xs" >PDF</a></center>';
				$data[]=array(
					"0"=>$reg->nombre,
					"1"=>$reg->valor,
					"2"=>$reg->nombre_empresa,
					"3"=>$reg->direccion_empresa,
					"4"=>$reg->docente_supervisor,
                    "5"=>$reg->fecha_inicio,
                    "6"=>$reg->fecha_finaliza,
                    "7"=>$primera_supervision,
                    "8"=>$segunda_supervicion,
                    "9"=>$unica_supervision
							
					);
			}
			$results = array(
				"sEcho"=>1, //Información para el datatables
				"iTotalRecords"=>count($data), //enviamos el total registros al datatable
				"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
				"aaData"=>$data);
			echo json_encode($results);
		}

	break;
}
    
    /*if(ISSET($_POST['search'])){
		$date1 = date("Y-m-d", strtotime($_POST['date1']));
        $date2 = date("Y-m-d", strtotime($_POST['date2']));
        $Docente = $_POST['Docente'];
        $empresa = $_POST['empresa'];
		$query=mysqli_query($conexion, "SELECT px.valor, concat(a.nombres,' ',a.apellidos) as nombre, ep.nombre_empresa, ep.direccion_empresa, pe.docente_supervisor, pe.fecha_inicio, pe.fecha_finaliza, c.valor Correo, e.valor Celular, ep.tipo_empresa, ep.departamento_empresa, ep.jefe_inmediato, ep.titulo_jefe_inmediato, ep.cargo_jefe_inmediato, ep.correo_jefe_inmediato, ep.telefono_jefe_inmediato, ep.labora_dentro, a.id_persona, pe.horas

        FROM tbl_empresas_practica AS ep
        JOIN tbl_personas AS a
        ON ep.id_persona = a.id_persona
        JOIN tbl_practica_estudiantes AS pe
        ON pe.id_persona = a.id_persona
        JOIN tbl_contactos c ON a.id_persona = c.id_persona
        JOIN tbl_tipo_contactos d ON c.id_tipo_contacto = d.id_tipo_contacto AND d.descripcion = 'CORREO'
        JOIN tbl_contactos e ON a.id_persona = e.id_persona
        JOIN tbl_tipo_contactos f ON e.id_tipo_contacto = f.id_tipo_contacto AND f.descripcion = 'TELEFONO CELULAR'
        join tbl_personas_extendidas as px on px.id_atributo=12 and px.id_persona=a.id_persona
        WHERE NOT (pe.docente_supervisor <=> '')  AND pe.docente_supervisor='$Docente' AND ep.nombre_empresa='$empresa' AND ep.Fecha_creacion BETWEEN '$date1' AND '$date2' ") or die(mysqli_error());
		$row=mysqli_num_rows($query);
		if($row>0){
			while($fetch=mysqli_fetch_array($query)){
?>
	<tr align="center" >
    <td><?php echo $fetch['nombre']?></td>
		<td><?php echo $fetch['valor']?></td>
		<td><?php echo $fetch['nombre_empresa']?></td>
		<td><?php echo $fetch['direccion_empresa']?></td>
        <td><?php echo $fetch['docente_supervisor']?></td>
        <td><?php echo $fetch['fecha_inicio']?></td>
        <td><?php echo $fetch['fecha_finaliza']?></td>
        <td><center><a href="../pdf/primera_visita_pdf.php?id=<?php echo $fetch['id_persona']?>" target="_blank"  class="btn btn-secondary btn-raisedx btn-xs" >PDF</a><center></td>
		<td><center><a href="../pdf/segunda_visita_pdf.php?id=<?php echo $fetch['id_persona']?>" target="_blank" class="btn btn-secondary btn-raisedx btn-xs" >PDF</a></center></td>																
		<td><center><a href="../pdf/unica_visita_pdf.php?id=<?php echo $fetch['id_persona']?>" target="_blank" class="btn btn-secondary btn-raisedx btn-xs" >PDF</a></center></td>
	</tr>
<?php
			}
		}
	}
	if(ISSET($_POST['search'])){
		$date1 = date("Y-m-d", strtotime($_POST['date1']));
		$date2 = date("Y-m-d", strtotime($_POST['date2']));
		$query=mysqli_query($conexion, "SELECT px.valor, concat(a.nombres,' ',a.apellidos) as nombre, ep.nombre_empresa, ep.direccion_empresa, pe.docente_supervisor, pe.fecha_inicio, pe.fecha_finaliza, c.valor Correo, e.valor Celular, ep.tipo_empresa, ep.departamento_empresa, ep.jefe_inmediato, ep.titulo_jefe_inmediato, ep.cargo_jefe_inmediato, ep.correo_jefe_inmediato, ep.telefono_jefe_inmediato, ep.labora_dentro, a.id_persona, pe.horas

        FROM tbl_empresas_practica AS ep
        JOIN tbl_personas AS a
        ON ep.id_persona = a.id_persona
        JOIN tbl_practica_estudiantes AS pe
        ON pe.id_persona = a.id_persona
        JOIN tbl_contactos c ON a.id_persona = c.id_persona
        JOIN tbl_tipo_contactos d ON c.id_tipo_contacto = d.id_tipo_contacto AND d.descripcion = 'CORREO'
        JOIN tbl_contactos e ON a.id_persona = e.id_persona
        JOIN tbl_tipo_contactos f ON e.id_tipo_contacto = f.id_tipo_contacto AND f.descripcion = 'TELEFONO CELULAR'
        join tbl_personas_extendidas as px on px.id_atributo=12 and px.id_persona=a.id_persona
        WHERE NOT (pe.docente_supervisor <=> '') AND ep.Fecha_creacion BETWEEN '$date1' AND '$date2'") or die(mysqli_error());
		$row=mysqli_num_rows($query);
		if($row>0){
			while($fetch=mysqli_fetch_array($query)){
?>
	<tr align="center" >
    <td><?php echo $fetch['nombre']?></td>
		<td><?php echo $fetch['valor']?></td>
		<td><?php echo $fetch['nombre_empresa']?></td>
		<td><?php echo $fetch['direccion_empresa']?></td>
        <td><?php echo $fetch['docente_supervisor']?></td>
        <td><?php echo $fetch['fecha_inicio']?></td>
        <td><?php echo $fetch['fecha_finaliza']?></td>
        <td><center><a href="../pdf/primera_visita_pdf.php?id=<?php echo $fetch['id_persona']?>" target="_blank"  class="btn btn-secondary btn-raisedx btn-xs" >PDF</a><center></td>
		<td><center><a href="../pdf/segunda_visita_pdf.php?id=<?php echo $fetch['id_persona']?>" target="_blank" class="btn btn-secondary btn-raisedx btn-xs" >PDF</a></center></td>																
		<td><center><a href="../pdf/unica_visita_pdf.php?id=<?php echo $fetch['id_persona']?>" target="_blank" class="btn btn-secondary btn-raisedx btn-xs" >PDF</a></center></td>
	</tr>
<?php
			}
		}
	}
    //aqui 


    if(ISSET($_POST['search'])){
		$Docente = $_POST['Docente'];
		$query=mysqli_query($conexion, "SELECT px.valor, concat(a.nombres,' ',a.apellidos) as nombre, ep.nombre_empresa, ep.direccion_empresa, pe.docente_supervisor, pe.fecha_inicio, pe.fecha_finaliza, c.valor Correo, e.valor Celular, ep.tipo_empresa, ep.departamento_empresa, ep.jefe_inmediato, ep.titulo_jefe_inmediato, ep.cargo_jefe_inmediato, ep.correo_jefe_inmediato, ep.telefono_jefe_inmediato, ep.labora_dentro, a.id_persona, pe.horas

        FROM tbl_empresas_practica AS ep
        JOIN tbl_personas AS a
        ON ep.id_persona = a.id_persona
        JOIN tbl_practica_estudiantes AS pe
        ON pe.id_persona = a.id_persona
        JOIN tbl_contactos c ON a.id_persona = c.id_persona
        JOIN tbl_tipo_contactos d ON c.id_tipo_contacto = d.id_tipo_contacto AND d.descripcion = 'CORREO'
        JOIN tbl_contactos e ON a.id_persona = e.id_persona
        JOIN tbl_tipo_contactos f ON e.id_tipo_contacto = f.id_tipo_contacto AND f.descripcion = 'TELEFONO CELULAR'
        join tbl_personas_extendidas as px on px.id_atributo=12 and px.id_persona=a.id_persona
        WHERE NOT (pe.docente_supervisor <=> '') AND pe.docente_supervisor='$Docente'") or die(mysqli_error());
		$row=mysqli_num_rows($query);
		if($row>0){
			while($fetch=mysqli_fetch_array($query)){
?>
	<tr  align="center" >
    <td><?php echo $fetch['nombre']?></td>
		<td><?php echo $fetch['valor']?></td>
		<td><?php echo $fetch['nombre_empresa']?></td>
		<td><?php echo $fetch['direccion_empresa']?></td>
        <td><?php echo $fetch['docente_supervisor']?></td>
        <td><?php echo $fetch['fecha_inicio']?></td>
        <td><?php echo $fetch['fecha_finaliza']?></td>
        <td><center><a href="../pdf/primera_visita_pdf.php?id=<?php echo $fetch['id_persona']?>" target="_blank"  class="btn btn-secondary btn-raisedx btn-xs" >PDF</a><center></td>
		<td><center><a href="../pdf/segunda_visita_pdf.php?id=<?php echo $fetch['id_persona']?>" target="_blank" class="btn btn-secondary btn-raisedx btn-xs" >PDF</a></center></td>																
		<td><center><a href="../pdf/unica_visita_pdf.php?id=<?php echo $fetch['id_persona']?>" target="_blank" class="btn btn-secondary btn-raisedx btn-xs" >PDF</a></center></td>
	</tr>
<?php
			}
		}
	}
	if(ISSET($_POST['search'])){
		$empresa = $_POST['empresa'];
		$query=mysqli_query($conexion, "SELECT px.valor, concat(a.nombres,' ',a.apellidos) as nombre, ep.nombre_empresa, ep.direccion_empresa, pe.docente_supervisor, pe.fecha_inicio, pe.fecha_finaliza, c.valor Correo, e.valor Celular, ep.tipo_empresa, ep.departamento_empresa, ep.jefe_inmediato, ep.titulo_jefe_inmediato, ep.cargo_jefe_inmediato, ep.correo_jefe_inmediato, ep.telefono_jefe_inmediato, ep.labora_dentro, a.id_persona, pe.horas

        FROM tbl_empresas_practica AS ep
        JOIN tbl_personas AS a
        ON ep.id_persona = a.id_persona
        JOIN tbl_practica_estudiantes AS pe
        ON pe.id_persona = a.id_persona
        JOIN tbl_contactos c ON a.id_persona = c.id_persona
        JOIN tbl_tipo_contactos d ON c.id_tipo_contacto = d.id_tipo_contacto AND d.descripcion = 'CORREO'
        JOIN tbl_contactos e ON a.id_persona = e.id_persona
        JOIN tbl_tipo_contactos f ON e.id_tipo_contacto = f.id_tipo_contacto AND f.descripcion = 'TELEFONO CELULAR'
        join tbl_personas_extendidas as px on px.id_atributo=12 and px.id_persona=a.id_persona
        WHERE NOT (pe.docente_supervisor <=> '') AND ep.nombre_empresa='$empresa'") or die(mysqli_error());
		$row=mysqli_num_rows($query);
		if($row>0){
			while($fetch=mysqli_fetch_array($query)){
?>
	<tr  align="center" >
    <td><?php echo $fetch['nombre']?></td>
		<td><?php echo $fetch['valor']?></td>
		<td><?php echo $fetch['nombre_empresa']?></td>
		<td><?php echo $fetch['direccion_empresa']?></td>
        <td><?php echo $fetch['docente_supervisor']?></td>
        <td><?php echo $fetch['fecha_inicio']?></td>
        <td><?php echo $fetch['fecha_finaliza']?></td>
        <td><center><a href="../pdf/primera_visita_pdf.php?id=<?php echo $fetch['id_persona']?>" target="_blank"  class="btn btn-secondary btn-raisedx btn-xs" >PDF</a><center></td>
		<td><center><a href="../pdf/segunda_visita_pdf.php?id=<?php echo $fetch['id_persona']?>" target="_blank" class="btn btn-secondary btn-raisedx btn-xs" >PDF</a></center></td>																
		<td><center><a href="../pdf/unica_visita_pdf.php?id=<?php echo $fetch['id_persona']?>" target="_blank" class="btn btn-secondary btn-raisedx btn-xs" >PDF</a></center></td>
	</tr>
<?php
			}
		}else{
			
		}
	}else{
		$query=mysqli_query($conexion, "SELECT px.valor, concat(a.nombres,' ',a.apellidos) as nombre, ep.nombre_empresa, ep.direccion_empresa, pe.docente_supervisor, pe.fecha_inicio, pe.fecha_finaliza, c.valor Correo, e.valor Celular, ep.tipo_empresa, ep.departamento_empresa, ep.jefe_inmediato, ep.titulo_jefe_inmediato, ep.cargo_jefe_inmediato, ep.correo_jefe_inmediato, ep.telefono_jefe_inmediato, ep.labora_dentro, a.id_persona, pe.horas

        FROM tbl_empresas_practica AS ep
        JOIN tbl_personas AS a
        ON ep.id_persona = a.id_persona
        JOIN tbl_practica_estudiantes AS pe
        ON pe.id_persona = a.id_persona
        JOIN tbl_contactos c ON a.id_persona = c.id_persona
        JOIN tbl_tipo_contactos d ON c.id_tipo_contacto = d.id_tipo_contacto AND d.descripcion = 'CORREO'
        JOIN tbl_contactos e ON a.id_persona = e.id_persona
        JOIN tbl_tipo_contactos f ON e.id_tipo_contacto = f.id_tipo_contacto AND f.descripcion = 'TELEFONO CELULAR'
        join tbl_personas_extendidas as px on px.id_atributo=12 and px.id_persona=a.id_persona
        WHERE NOT (pe.docente_supervisor <=> '')") or die(mysqli_error());
		while($fetch=mysqli_fetch_array($query)){
?>
	<tr  align="center" >
		<td><?php echo $fetch['nombre']?></td>
		<td><?php echo $fetch['valor']?></td>
		<td><?php echo $fetch['nombre_empresa']?></td>
		<td><?php echo $fetch['direccion_empresa']?></td>
        <td><?php echo $fetch['docente_supervisor']?></td>
        <td><?php echo $fetch['fecha_inicio']?></td>
        <td><?php echo $fetch['fecha_finaliza']?></td>
        <td><center><a href="../pdf/primera_visita_pdf.php?id=<?php echo $fetch['id_persona']?>" target="_blank"  class="btn btn-secondary btn-raisedx btn-xs" >PDF</a><center></td>
		<td><center><a href="../pdf/segunda_visita_pdf.php?id=<?php echo $fetch['id_persona']?>" target="_blank" class="btn btn-secondary btn-raisedx btn-xs" >PDF</a></center></td>																
		<td><center><a href="../pdf/unica_visita_pdf.php?id=<?php echo $fetch['id_persona']?>" target="_blank" class="btn btn-secondary btn-raisedx btn-xs" >PDF</a></center></td>
	</tr>
<?php
		}
	}*/
?>

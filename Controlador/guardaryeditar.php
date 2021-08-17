if (empty($id_actividad_voae)) {
				
			
				//SE MANDA A LA BITACORA LA ACCION DE INSERTAR
				$rspta=$externa->insertar($nombre_act,$ubicacion,$fecha_inicio,$fecha_final,$descripcion,$ente,$usuario,$ambito,$periodo);
				echo $rspta ? "Actividad Registrada" : "No se pudo registrar";
				 bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'INSERTO', 'LA ACTIVIDAD EXTERNA: "' . $nombre_act . '"');
				
			

		} else {
			$valor = "select nombre_actividad, ubicacion , fch_inicial_actividad, fch_final_actividad, descripcion , staff_alumnos, id_ambito, periodo from tbl_voae_actividades WHERE id_actividad_voae= '$id_actividad_voae'";
				$result_valor = $mysqli->query($valor);
				$valor_viejo = $result_valor->fetch_array(MYSQLI_ASSOC);

				$sql = "select nombre_ambito from tbl_voae_ambitos WHERE id_ambito= '$ambito'";
				$result_valor2 = $mysqli->query($sql);
				$valor_viejo2 = $result_valor2->fetch_array(MYSQLI_ASSOC);

				if ($valor_viejo['nombre_actividad'] <> $nombre_act and $valor_viejo['ubicacion'] <> $ubicacion and $valor_viejo['fch_inicial_actividad'] <> $fecha_inicio and $valor_viejo['fch_final_actividad'] <> $fecha_final and $valor_viejo['descripcion'] <> $descripcion and $valor_viejo['staff_alumnos'] <> $ente and $valor_viejo['id_ambito'] <> $ambito and $valor_viejo['periodo'] <> $periodo) {
					
					

			$rspta=$externa->editar($id_actividad_voae,$nombre_act,$ubicacion,$fecha_inicio,$fecha_final,$descripcion,$ente,$usuario,$ambito,$periodo);
				echo $rspta ? "Actividad Actualizada" : "No se pudo actualizar";
				bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', ' LA ACTIVIDAD EXTERNA CON EL ID ' . $id_actividad_voae . ': CAMBIO NOMBRE: "'.$valor_viejo['nombre_actividad'] . '" POR: "'.$nombre_act . '"; CAMBIO UBICACION: "'.$valor_viejo['ubicacion'] . '" POR: "'.$ubicacion . '"; CAMBIO FECHA INICIO: "'.$valor_viejo['fch_inicial_actividad'] . '" POR: "'.$fecha_inicio . '";  CAMBIO FECHA FINAL: "'.$valor_viejo['fch_final_actividad'] . '" POR: "'.$fecha_final . '"; CAMBIO ENTE: "'.$valor_viejo['staff_alumnos'] . '" POR: "'.$ente . '";  CAMBIO AMBITO: "'.$valor_viejo2['nombre_ambito'] . '" POR: "'.$ambito . '";  CAMBIO PERIODO: "'.$valor_viejo['periodo'] . '" POR: "'.$periodo . '";');

		} 


			
		}//FIN
	break;
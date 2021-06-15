<?php
require_once "../Modelos/perfil_docente_modelo.php";
$id_empleado = isset($_POST["id_empleado"]) ? limpiarCadena1($_POST["id_empleado"]) : "";
$identidad = isset($_POST["identidad"]) ? limpiarCadena1($_POST["identidad"]) : "";
$nombre = isset($_POST["Nombre"]) ? limpiarCadena1($_POST["Nombre"]) : "";
$apellido = isset($_POST["apellido"]) ? limpiarCadena1($_POST["apellido"]) : "";
$correo = isset($_POST["correo"]) ? limpiarCadena1($_POST["correo"]) : "";
$grado = isset($_POST["grado"]) ? limpiarCadena1($_POST["grado"]) : "";
$especialidad = isset($_POST["especialidad"]) ? limpiarCadena1($_POST["especialidad"]) : "";
$telefono = isset($_POST["telefono"]) ? limpiarCadena1($_POST["telefono"]) : "";
$eliminar_tel = isset($_POST["eliminar_tel"]) ? limpiarCadena1($_POST["eliminar_tel"]) : "";
$eliminar_formacion = isset($_POST["eliminar_formacion"]) ? limpiarCadena1($_POST["eliminar_formacion"]) : "";
$eliminar_correo = isset($_POST["eliminar_correo"]) ? limpiarCadena1($_POST["eliminar_correo"]) : "";
$id_persona = isset($_POST["id_persona"]) ? limpiarCadena1($_POST["id_persona"]) : "";
$nacionalidad = isset($_POST["nacionalidad"]) ? limpiarCadena1($_POST["nacionalidad"]) : "";
$estado_civil = isset($_POST["id_estado_civil"]) ? limpiarCadena1($_POST["id_estado_civil"]) : "";
$valor = isset($_POST["valor"]) ? limpiarCadena1($_POST["valor"]) : "";
$curriculum = isset($_POST["curriculum"]) ? limpiarCadena1($_POST["curriculum"]) : "";
$estado = isset($_POST["estado_civil"]) ? limpiarCadena1($_POST["estado_civil"]) : "";
$codigo = isset($_POST["codigo"]) ? limpiarCadena1($_POST["codigo"]) : "";
$id_genero = isset($_POST["id_genero"]) ? limpiarCadena1($_POST["id_genero"]) : "";
$genero = isset($_POST["genero"]) ? limpiarCadena1($_POST["genero"]) : "";
$sexo = isset($_POST["sexo"]) ? limpiarCadena1($_POST["sexo"]) : "";

$id_persona_prueba = '10';


$instancia_modelo = new modelo_perfil_docentes();

if (isset($_GET['op'])) {

    switch ($_GET['op']) {
        case 'CargarDatos':
            $rspta = $instancia_modelo->mostrar($id_persona);
            //echo '<pre>';print_r($rspta);echo'</pre>';
            //Codificar el resultado utilizando json
            echo json_encode($rspta);
            break;

        case 'SelectGrado':
            $rspta = $instancia_modelo->mostrarSelect($id_empleado);
            //Codificar el resultado utilizando json
            echo json_encode($rspta);
            break;

        case 'select1':
            $data = array();
            $respuesta = $instancia_modelo->listar_select1();
            // echo '<pre>';print_r($respuesta);echo'</pre>';
            while ($r = $respuesta->fetch_object()) {


                # code...
                echo "<option value='" . $r->id_grado_academico . "'> " . $r->grado_academico . " </option>";
                // echo "<option value='1'> 1 </option>";
            }

            break;

        case 'EditarPerfil':

            $rspta = $instancia_modelo->Actualizar($nombre, $apellido, $identidad, $id_persona, $nacionalidad, $estado, $sexo);
            break;

        case 'AgregarEpecialidad':


            $rspta = $instancia_modelo->AgregarEspecialidad($grado, $especialidad, $id_persona);
            break;

        case 'MostrarEspecialidad':


            $rspta = $instancia_modelo->MostrarEspecialidad($id_persona);
            echo json_encode($rspta);
            break;

        case 'AgregarTelefono':


            $rspta = $instancia_modelo->AgregarTelefono($telefono, $id_persona);
            break;

        case 'AgregarCorreo':


            $rspta = $instancia_modelo->AgregarCorreo($id_persona, $correo);

            break;

        case 'EliminarTelefono':


            $rspta = $instancia_modelo->EliminarTelefono($eliminar_tel);

            break;

        case 'EliminarCorreo':


            $rspta = $instancia_modelo->EliminarCorreo($eliminar_correo);

            break;


        case 'CambiarFoto':


            $ruta_carpeta = "../Imagenes_Perfil_Docente/";
            $nombre_archivo = "imagen" . date("dHis") . "." . pathinfo($_FILES["imagen"]["name"], PATHINFO_EXTENSION);


            $ruta_guardar_archivo = $ruta_carpeta . $nombre_archivo;
            //echo $ruta_guardar_archivo;
            move_uploaded_file($_FILES["imagen"]["tmp_name"], $ruta_guardar_archivo);
            $rspta = $instancia_modelo->CambiarFoto($ruta_guardar_archivo, $id_persona);
            echo json_encode($ruta_guardar_archivo);



            break;

        case 'Actividades':

            $rspta = $instancia_modelo->Actividades($id_persona);
            echo json_encode($rspta);

            break;

        case 'Curriculum':


            $rspta = $instancia_modelo->Curriculum($id_persona);
            echo json_encode($rspta);

            break;

        case 'Num_Empleado':


            $rspta = $instancia_modelo->Num_Empleado($id_persona);
            echo json_encode($rspta);

            break;

        case 'ver_estado_c':


            $rspta = $instancia_modelo->ver_estado_c($id_persona);
            echo json_encode($rspta);

            break;

        case 'ver_genero':


            $rspta = $instancia_modelo->ver_genero($id_persona);
            echo json_encode($rspta);

            break;

        case 'ver_sued':


            $rspta = $instancia_modelo->ver_sued($id_persona);
            echo json_encode($rspta);

            break;

        case 'ExisteIdentidad':


            $rspta = $instancia_modelo->ExisteIdentidad($identidad);
            echo json_encode($rspta);

            break;
        case 'cambiarCurriculum':

            if (is_array($_FILES) && count($_FILES) > 0) {

                if (move_uploaded_file($_FILES["c"]["tmp_name"], "../curriculum_docentes/" . $_FILES["c"]["name"])) {
                    $nombrearchivo2 = '../curriculum_docentes/' . $_FILES["c"]["name"];
                    $consulta = $instancia_modelo->Registrar_curriculum($nombrearchivo2, $id_persona);
                    echo json_encode($nombrearchivo2);
                } else {
                    return 0;
                }
            } else {
                return 0;
            }

            break;

        case 'TipoContacto':


            $data = array();
            $respuesta = $instancia_modelo->TipoContacto();
            // echo '<pre>';print_r($respuesta);echo'</pre>';
            while ($r = $respuesta->fetch_object()) {


                # code...
                echo "<option value='" . $r->id_tipo_contacto . "'> " . $r->descripcion . " </option>";
                // echo "<option value='1'> 1 </option>";
            }

            break;




        default:
            # code...
            break;



        case 'mayoria_edad':
            $rspta = $instancia_modelo->mayoria_edad();
            //Codificar el resultado utilizando json
            echo json_encode($rspta);
            break;

        case 'validar_depto':
            $respuesta = $instancia_modelo->validardepto($codigo);
            echo json_encode($respuesta);

            break;

        case 'mostrar_estado_civil':
            $rspta2 = $instancia_modelo->mostrar_estado_civil($estado_civil);
            //Codificar el resultado utilizando json
            echo json_encode($rspta2);
            break;
        case 'estado_civil':

            $data = array();
            $respuesta2 = $instancia_modelo->listar_estado_civil();

            while ($r2 = $respuesta2->fetch_object()) {


                # code...
                echo "<option value='" . $r2->id_estado_civil . "'> " . $r2->estado_civil . " </option>";
            }
            break;

        case 'mostrar_genero':
            $rspta2 = $instancia_modelo->mostrar_genero($genero);
            echo json_encode($rspta2);
            break;
        case 'genero':

            $data = array();
            $respuesta2 = $instancia_modelo->listar_genero();

            while ($r2 = $respuesta2->fetch_object()) {


                # code...
                echo "<option value='" . $r2->id_genero . "'> " . $r2->genero . " </option>";
            }
            break;

        case 'EliminarPregunta1':


            $rspta = $instancia_modelo->EliminarPregunta1($id_persona);

            break;

        case 'contarPregunta1':

            $rspta = $instancia_modelo->Existepregunta1($id_persona);
            echo json_encode($rspta);

            break;

        case 'EliminarPregunta2':


            $rspta = $instancia_modelo->EliminarPregunta2($id_persona);

            break;

        case 'contarPregunta2':

            $rspta = $instancia_modelo->Existepregunta2($id_persona);
            echo json_encode($rspta);

            break;
        case 'EliminarPregunta3':


            $rspta = $instancia_modelo->EliminarPregunta3($id_persona);

            break;

        case 'contarPregunta3':

            $rspta = $instancia_modelo->Existepregunta3($id_persona);
            echo json_encode($rspta);

            break;

        case 'EliminarPregunta4':


            $rspta = $instancia_modelo->EliminarPregunta4($id_persona);

            break;

        case 'contarPregunta4':

            $rspta = $instancia_modelo->Existepregunta4($id_persona);
            echo json_encode($rspta);

            break;
        case 'especialidad':

            $rspta = $instancia_modelo->especialidad($id_persona);
            echo json_encode($rspta);

            break;

        case 'eliminar_formacion':


            $rspta = $instancia_modelo->eliminar_formacion($eliminar_formacion, $id_persona);

            break;
    }
}

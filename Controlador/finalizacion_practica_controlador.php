<?php
	
require_once ('../clases/Conexion.php');

        if(isset($_POST['txt_nombre'])){
            $nombre = $_POST['txt_nombre'];
            $verificado1 = $_POST['txt_verificado1'];
            $verificado2 = $_POST['txt_verificado2'];
            $ncuenta = $_POST['txt_cuenta'];
            $correo = $_POST['txt_correo'];
            $empresa = $_POST['txt_empresa'];
            $encargado =$_POST['txt_jefe'];
            $archivo = $_FILES['txt_archivo'];
            if ($nombre==!""  && $ncuenta==!"" && $correo==!"" && $empresa==!"" && $encargado==!"" && $_FILES['txt_archivo']['name']!=null) 
            {

                $sql=$mysqli->prepare("select p.nombres,p.apellidos
                                       from tbl_personas p, tbl_personas_extendidas pe
                                       where p.id_persona = pe.id_persona
                                       AND pe.valor = ?");
                $sql->bind_param("i",$ncuenta);
                $sql->execute();
                $resultado = $sql->get_result();

                if($resultado->num_rows>=1){

                    if($verificado1!=="" && $verificado2!==""){
                        $insertanombre ="call upd_nombre('$ncuenta','$verificado1','$verificado2')";
                        $resultadon = $mysqli->query($insertanombre);
                    }

                    $micarpeta = '../archivos/finalizacion/'.$ncuenta;
                    if (!file_exists($micarpeta)) {
                         mkdir($micarpeta, 0777, true);
                        }else{
                            $documento = glob('../archivos/finalizacion/'.$ncuenta.'/*'); // obtiene los documentos
                            foreach($documento as $documento){ // itera los documentos
                            if(is_file($documento)) 
                            unlink($documento); // borra los documentos
                            } 
                        }

                    $nombre_temporal = $_FILES['txt_archivo']['tmp_name'];
                    $nombrearchivo= $_FILES['txt_archivo']['name'];
                    $ruta= '../archivos/finalizacion/'.$ncuenta.'/'.$nombrearchivo;
                    

                    $sql = "call  ins_finalizacion_practica('$ncuenta',' $ruta','$correo')";
                    $resultado = $mysqli->query($sql);

                    if($resultado == true) {
                        move_uploaded_file($nombre_temporal,'../archivos/finalizacion/'.$ncuenta.'/'.$nombrearchivo);
                        echo '<script type="text/javascript">
                                        swal({
                                            title:"",
                                            text:"Solicitud enviada...",
                                            type: "success",
                                            showConfirmButton: false,
                                            timer: 1500
                                            });
                                            $(".FormularioAjax")[0].reset();
                                        </script>'; 
                        
                                    } 
                        else 
                        {
                        echo "Error: " . $sql ;
                        }

                }else{
                echo '<script type="text/javascript">
                        swal({
                                title:"",
                                text:"El numero de cuenta es incorrecto....",
                                type: "error",
                                showConfirmButton: false,
                                timer: 1500
                            });
                            $(".FormularioAjax")[0];
                      </script>'; 
                    }

            }
            else
            {
                echo '<script type="text/javascript">
                                swal({
                                    title:"",
                                    text:"Faltan campos por llenar....",
                                    type: "error",
                                    showConfirmButton: false,
                                    timer: 1500
                                    });
                                    $(".FormularioAjax")[0];
                                </script>'; 
            }
    }else{
           
        if(isset($_POST['aprobado']) && $_POST['aprobado']!=""){

            $aprobar = $_POST['aprobado'];
            $observacion= $_POST['txt_observacion'];
            $ncuenta = $_POST['txt_cuenta'];

            if($observacion==!""){
                $consulta = "call  upd_finalizacion_practica_observacion('$aprobar','$observacion','$ncuenta')";
            $resultado1 = $mysqli->query($consulta);

            if($resultado1 == true) {
                echo '<script type="text/javascript">
                                swal({
                                    title:"",
                                    text:"Los datos se guardaron...",
                                    type: "success",
                                    allowOutsideClick:false,
                                    showConfirmButton: true,
                                    }).then(function () {
                                        window.location.href = "revision_finalizacion_vista.php";
                                    });
                                    $(".FormularioAjax")[0].reset();        
                                </script>'; 
                            } 
                             
                else 
                {
                echo "Error: " . $consulta ;
                }
                
            }else{
                $consulta = "call  upd_finalizacion_practica('$aprobar','$ncuenta')";
                $resultado1 = $mysqli->query($consulta);

            if($resultado1 == true) {
                echo '<script type="text/javascript">
                                swal({
                                    title:"",
                                    text:"Los datos se guardaron...",
                                    type: "success",
                                    allowOutsideClick:false,
                                    showConfirmButton: true,
                                    }).then(function () {
                                        window.location.href = "revision_finalizacion_vista.php";
                                    });
                                    $(".FormularioAjax")[0].reset();        
                                </script>'; 
                            } 
                             
                else 
                {
                echo "Error: " . $sql ;
                }
            }

            
        }else{
            echo '<script type="text/javascript">
            swal({
                 title:"",
                 text:"No a seleccionado la aprobacion",
                 type: "error",
                 showConfirmButton: false,
                 timer: 1500
              });
              $(".FormularioAjax")[0];
          </script>'; 
        }
    }
?>

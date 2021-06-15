<?php
	
require_once ('../clases/Conexion.php');
            
       if(isset($_POST['txt_nombre']) && $_POST['txt_nombre']==!""  && isset($_POST['txt_cuenta']) && $_POST['txt_cuenta']==!"" 
       && $_POST['txt_correo']==!"" && isset( $_POST['txt_centrore']) && $_POST['txt_centrore']==!"" && $_POST['txt_facultad']==!"" && $_POST['txt_razon']==!""){

            $ncuenta = $_POST['txt_cuenta'];
            $razon = $_POST['txt_razon'];
            $centro = $_POST['txt_centrore'];
            $facultad = $_POST['txt_facultad'];
            $verificado1 = $_POST['txt_verificado1'];
            $verificado2 = $_POST['txt_verificado2'];
            $correo = $_POST['txt_correo'];

            

            $sql=$mysqli->prepare("SELECT p.nombres,p.apellidos
                                   FROM tbl_usuarios u, tbl_personas p
                                   WHERE u.id_persona = p.id_persona  AND u.Usuario =?");
            $sql->bind_param("i",$ncuenta);
            $sql->execute();
            $resultado = $sql->get_result();


            if($resultado->num_rows>=1){
                if($_FILES['txt_historial']['name']!=null && $_FILES['txt_voae']['name']!=null && $_FILES['txt_identidad']['name']!=null
                   && $_FILES['txt_foto']['name']!=null && $_FILES['txt_carne']['name']!=null && $_FILES['txt_conducta']['name']!=null){
                    $documento_nombre[] = $_FILES['txt_historial']['name'];
                    $documento_nombre[] = $_FILES['txt_voae']['name'];
                    $documento_nombre[] = $_FILES['txt_identidad']['name'];
                    $documento_nombre[] = $_FILES['txt_foto']['name'];
                    $documento_nombre[] = $_FILES['txt_carne']['name'];
                    $documento_nombre[] = $_FILES['txt_conducta']['name'];

                    $documento_nombre_temporal[] = $_FILES['txt_historial']['tmp_name'];
                    $documento_nombre_temporal[] = $_FILES['txt_voae']['tmp_name'];
                    $documento_nombre_temporal[] = $_FILES['txt_identidad']['tmp_name'];
                    $documento_nombre_temporal[] = $_FILES['txt_foto']['tmp_name'];
                    $documento_nombre_temporal[] = $_FILES['txt_carne']['tmp_name'];
                    $documento_nombre_temporal[] = $_FILES['txt_conducta']['tmp_name'];

                    if($verificado1!=="" && $verificado2!==""){
                        $insertanombre ="call upd_nombre('$ncuenta','$verificado1','$verificado2')";
                        $resultadon = $mysqli->query($insertanombre);
                        $resultadon->free();
                        $mysqli->next_result();
                    }

                   
                    $micarpeta = '../archivos/cambio/interno/'.$ncuenta;
                    if (!file_exists($micarpeta)) {
                         mkdir($micarpeta, 0777, true);
                        }else{
                            $documento = glob('../archivos/cambio/interno/'.$ncuenta.'/*'); // obtiene los documentos
                            foreach($documento as $documento){ // itera los documentos
                            if(is_file($documento)) 
                            unlink($documento); // borra los documentos
                            } 
                        }
                    for ($i = 0; $i <=count($documento_nombre_temporal)-1 ; $i++) {
                        
                        move_uploaded_file($documento_nombre_temporal[$i],"$micarpeta/$documento_nombre[$i]");
                        $ruta= '../archivos/cambio/interno/'.$ncuenta.'/'.$documento_nombre[$i];
                        $direccion[]= $ruta;

                    }
                    $documento = json_encode($direccion);

                    
                    
                    $sqlp = "call ins_cambio_carrera('$ncuenta','$razon','$centro','$facultad','$documento','INTERNO','$correo')";
                    $resultadop = $mysqli->query($sqlp);
                    if($resultadop == true){
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
                    else {
                        echo "Error: " . $sqlp;
                        }
                     
                    

                }else{
                        echo '<script type="text/javascript">
                                    swal({
                                            title:"",
                                            text:"Faltan documentos por subir....",
                                            type: "error",
                                            showConfirmButton: false,
                                            timer: 1500
                                        });
                                        $(".FormularioAjax")[0];
                              </script>'; 
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
       }elseif(isset($_POST['txt_nombre']) && $_POST['txt_nombre']!==""  && $_POST['txt_correo']!=="" && isset($_POST['txt_u']) && $_POST['txt_u']!==""){
                
        $nombre= $_POST['txt_nombre'];

        if($_FILES['txt_solicitud']['name']!=null && $_FILES['txt_copia']['name']!=null && $_FILES['txt_certificado']['name']!=null
        && $_FILES['txt_identidad']['name']!=null && $_FILES['txt_conducta']['name']!=null && $_FILES['txt_fotografia']['name']!=null){
            $documento_nombre[] = $_FILES['txt_solicitud']['name'];
            $documento_nombre[] = $_FILES['txt_copia']['name'];
            $documento_nombre[] = $_FILES['txt_certificado']['name'];
            $documento_nombre[] = $_FILES['txt_identidad']['name'];
            $documento_nombre[] = $_FILES['txt_conducta']['name'];
            $documento_nombre[] = $_FILES['txt_fotografia']['name'];

            $documento_nombre_temporal[] = $_FILES['txt_solicitud']['tmp_name'];
            $documento_nombre_temporal[] = $_FILES['txt_copia']['tmp_name'];
            $documento_nombre_temporal[] = $_FILES['txt_certificado']['tmp_name'];
            $documento_nombre_temporal[] = $_FILES['txt_identidad']['tmp_name'];
            $documento_nombre_temporal[] = $_FILES['txt_conducta']['tmp_name'];
            $documento_nombre_temporal[] = $_FILES['txt_fotografia']['tmp_name'];

            $micarpeta = '../archivos/ou/'.$nombre;
            if (!file_exists($micarpeta)) {
                  mkdir($micarpeta, 0777, true);
            }else{
                $documento = glob('../archivos/ou/'.$nombre.'/*'); // obtiene los documentos
                            foreach($documento as $documento){ // itera los documentos
                            if(is_file($documento)) 
                            unlink($documento); // borra los documentos
                            } 
            }
            for ($i = 0; $i <=count($documento_nombre_temporal)-1 ; $i++) {
                        
                move_uploaded_file($documento_nombre_temporal[$i],"$micarpeta/$documento_nombre[$i]");
                $ruta= '../archivos/ou/'.$nombre.'/'.$documento_nombre[$i];
                $direccion[]= $ruta;
            }
            $documento = json_encode($direccion);

            $sqlp = "call ins_cambio_carrera('$ncuenta','$razon','$centro','$facultad','$documento','EXTERNO')";
                    $resultadop = $mysqli->query($sqlp);
                    if($resultadop == true){
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
                    else {
                        echo "Error: " . $sql ;
                        }

        }
        else{
            echo '<script type="text/javascript">
                        swal({
                                title:"",
                                text:"Faltan documentos por subir....",
                                type: "error",
                                showConfirmButton: false,
                                timer: 1500
                            });
                            $(".FormularioAjax")[0];
                </script>'; 
        }
       }elseif(isset($_POST['txt_simultanea']) && $_POST['txt_nombre']!=="" && $_POST['txt_correo']!=="" && $_POST['txt_cuenta']!=="" ){
               
                $ncuenta = $_POST['txt_cuenta'];
                $verificado1 = $_POST['txt_verificado1'];
                $verificado2 = $_POST['txt_verificado2'];
                $correo = $_POST['txt_correo'];

                $sql=$mysqli->prepare("SELECT p.nombres,p.apellidos
                FROM tbl_usuarios u, tbl_personas p
                WHERE u.id_persona = p.id_persona  AND u.Usuario =?");
                $sql->bind_param("i",$ncuenta);
                $sql->execute();
                $resultado = $sql->get_result();


                if($resultado->num_rows>=1){

                    if($_FILES['txt_solicitud']['name']!=null && $_FILES['txt_historial']['name']!=null && $_FILES['txt_identidad']['name']!=null
                && $_FILES['txt_carne']['name']!=null){

                    $cuenta = $_POST['txt_cuenta'];

                    $documento_nombre[] = $_FILES['txt_solicitud']['name'];
                    $documento_nombre[] = $_FILES['txt_historial']['name'];
                    $documento_nombre[] = $_FILES['txt_identidad']['name'];
                    $documento_nombre[] = $_FILES['txt_carne']['name'];

                    $documento_nombre_temporal[] = $_FILES['txt_solicitud']['tmp_name'];
                    $documento_nombre_temporal[] = $_FILES['txt_historial']['tmp_name'];
                    $documento_nombre_temporal[] = $_FILES['txt_identidad']['tmp_name'];
                    $documento_nombre_temporal[] = $_FILES['txt_carne']['tmp_name'];

                    $micarpeta = '../archivos/cambio/simultanea/'.$cuenta;
                        if (!file_exists($micarpeta)) {
                         mkdir($micarpeta, 0777, true);
                        }else{
                            $documento = glob('../archivos/cambio/simultanea/'.$cuenta.'/*'); // obtiene los documentos
                            foreach($documento as $documento){ // itera los documentos
                            if(is_file($documento)) 
                            unlink($documento); // borra los documentos
                            } 
                        }
                        
                    for ($i = 0; $i <=count($documento_nombre_temporal)-1 ; $i++) {
                    
                        move_uploaded_file($documento_nombre_temporal[$i],"$micarpeta/$documento_nombre[$i]");
                        $ruta= '../archivos/cambio/simultanea/'.$cuenta.'/'.$documento_nombre[$i];
                        $direccion[]= $ruta;
                    }
                    $documento = json_encode($direccion);

                    if($verificado1!=="" && $verificado2!==""){
                        $insertanombre ="call upd_nombre('$cuenta','$verificado1','$verificado2')";
                        $resultadon = $mysqli->query($insertanombre);
                        $resultadon->free();
                        $mysqli->next_result();
                    }

                    $sqlp = "call ins_cambio_carrera('$cuenta','','1','1','$documento','SIMULTANEA','$correo')";
                    $resultadop = $mysqli->query($sqlp);
                    if($resultadop == true){
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
                    else {
                        echo "Error: " . $sql ;
                        }
                    

            }else{
                echo '<script type="text/javascript">
                        swal({
                                title:"",
                                text:"Faltan documentos por subir....",
                                type: "error",
                                showConfirmButton: false,
                                timer: 1500
                            });
                            $(".FormularioAjax")[0];
                     </script>'; 
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


        
            
       }elseif(isset($_POST['txt_no_graduado']) && $_POST['txt_no_graduado']!=="" &&  $_POST['txt_nombre']!=="" &&
               $_POST['txt_apellido']!=="" &&  $_POST['txt_correo']!=="" ){

            if($_FILES['txt_solicitud']['name']!=null && $_FILES['txt_copia']['name']!=null && $_FILES['txt_certificado']['name']!=null
                && $_FILES['txt_identidad']['name']!=null && $_FILES['txt_constancia']['name']!=null && $_FILES['txt_foto']['name']!=null){
                    
                    $nombre=$_POST['txt_nombre'];

                    $documento_nombre[] = $_FILES['txt_solicitud']['name'];
                    $documento_nombre[] = $_FILES['txt_copia']['name'];
                    $documento_nombre[] = $_FILES['txt_certificado']['name'];
                    $documento_nombre[] = $_FILES['txt_identidad']['name'];
                    $documento_nombre[] = $_FILES['txt_constancia']['name'];
                    $documento_nombre[] = $_FILES['txt_foto']['name'];

                    $documento_nombre_temporal[] = $_FILES['txt_solicitud']['tmp_name'];
                    $documento_nombre_temporal[] = $_FILES['txt_copia']['tmp_name'];
                    $documento_nombre_temporal[] = $_FILES['txt_certificado']['tmp_name'];
                    $documento_nombre_temporal[] = $_FILES['txt_identidad']['tmp_name'];
                    $documento_nombre_temporal[] = $_FILES['txt_constancia']['tmp_name'];
                    $documento_nombre_temporal[] = $_FILES['txt_foto']['tmp_name'];

                    $micarpeta = '../archivos/cen/'.$nombre;
                        if (!file_exists($micarpeta)) {
                         mkdir($micarpeta, 0777, true);
                        }else{
                            $documento = glob('../archivos/cen/'.$nombre.'/*'); // obtiene los documentos
                            foreach($documento as $documento){ // itera los documentos
                            if(is_file($documento)) 
                            unlink($documento); // borra los documentos
                            } 
                        }
                    for ($i = 0; $i <=count($documento_nombre_temporal)-1 ; $i++) {
                
                        move_uploaded_file($documento_nombre_temporal[$i],"$micarpeta/$documento_nombre[$i]");
                        $ruta= '../archivos/cen/'.$nombre.'/'.$documento_nombre[$i];
                        $direccion[]= $ruta;
                    }
                    $documento = json_encode($direccion);
                    
                    
            }else{
                echo '<script type="text/javascript">
                        swal({
                                title:"",
                                text:"Faltan documentos por subir....",
                                type: "error",
                                showConfirmButton: false,
                                timer: 1500
                            });
                            $(".FormularioAjax")[0];
                    </script>';
            }

       }elseif(isset($_POST['aprobado']) && $_POST['aprobado']!==""){
        $cuenta = $_POST['txt_cuenta1'];
        $aprobado = $_POST['aprobado'];
        $observacion = $_POST['txt_observacion'];
        $tipo = $_POST['txt_tipo'];

            $sql=$mysqli->prepare("select p.nombres,p.apellidos,p.id_persona
                                   from tbl_personas p,tbl_personas_extendidas pe
                                   where p.id_persona = pe.id_persona
                                   AND pe.valor= ?");
            $sql->bind_param("i",$cuenta);
            $sql->execute();
            $resultado = $sql->get_result();
            $row = $resultado->fetch_array(MYSQLI_ASSOC);
            $id = $row['id_persona'];
        

        if($observacion!==""){
            $sqlp = "UPDATE `tbl_cambio_carrera` 
            SET `aprobado` = '$aprobado', `fecha_creacion` = now(),
            observacion = '$observacion'
            WHERE id_persona = '$id'
            AND tipo = '$tipo'";
            $resultadop = $mysqli->query($sqlp);
            if($resultadop == true){
                echo '<script type="text/javascript">
                        swal({
                            title:"",
                            text:"Solicitud enviada...",
                            type: "success",
                            allowOutsideClick:false,
                            showConfirmButton: true,
                            }).then(function () {
                            window.location.href = "menu_revision_cambio.php";
                            });
                            $(".FormularioAjax")[0].reset();
                        </script>'; 
                 } 
            else {
                echo "Error: " . $sqlp ;
                }
           
        }else{
            
            $sqlp = "UPDATE `tbl_cambio_carrera` 
                    SET `aprobado` = '$aprobado', `fecha_creacion` = now()
                    WHERE id_persona = '$id'
                    AND tipo = '$tipo'";
            $resultadop = $mysqli->query($sqlp);
            if($resultadop >= 1){
                echo '<script type="text/javascript">
                        swal({
                            title:"",
                            text:"Solicitud enviada...",
                            type: "success",
                            allowOutsideClick:false,
                            showConfirmButton: true,
                            }).then(function () {
                            window.location.href = "menu_revision_cambio.php";
                            });
                            $(".FormularioAjax")[0].reset();
                        </script>'; 
                 } 
            else {
                echo "Error: " . $sqlp ;
                }
        }

       }
       else{
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

?>

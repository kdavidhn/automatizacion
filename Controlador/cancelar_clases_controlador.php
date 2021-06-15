<?php
	
require_once ('../clases/Conexion.php');

if(isset($_POST['txt_nombre']) && $_POST['txt_nombre']!=="" && $_POST['txt_cuenta']!=="" && $_POST['txt_correo']!==""){ 
    if($_FILES['txt_finalizacion']['name']!=null && $_FILES['txt_certificado']['name']!=null
        && $_FILES['txt_comunitario']['name']!=null && $_FILES['txt_identidad']['name']!=null){
            
            $ncuenta = $_POST['txt_cuenta'];
            $correo = $_POST['txt_correo'];
            $verificado1 = $_POST['txt_verificado1'];
            $verificado2 = $_POST['txt_verificado2'];

            $sql="SELECT p.nombres,p.apellidos,pe.valor
                  FROM tbl_personas p, tbl_personas_extendidas pe
                  WHERE p.id_persona = pe.id_persona
                  AND pe.valor = $ncuenta";
            $resultado = $mysqli->query($sql);

            if($resultado->num_rows>=1){

                $documento_nombre[] = $_FILES['txt_finalizacion']['name'];
                $documento_nombre[] = $_FILES['txt_certificado']['name'];
                $documento_nombre[] = $_FILES['txt_comunitario']['name'];
                $documento_nombre[] = $_FILES['txt_identidad']['name'];

                $documento_nombre_temporal[] = $_FILES['txt_finalizacion']['tmp_name'];
                $documento_nombre_temporal[] = $_FILES['txt_certificado']['tmp_name'];
                $documento_nombre_temporal[] = $_FILES['txt_comunitario']['tmp_name'];
                $documento_nombre_temporal[] = $_FILES['txt_identidad']['tmp_name'];

                $micarpeta = '../archivos/carta_egresado/'.$ncuenta;
                    if (!file_exists($micarpeta)) {
                         mkdir($micarpeta, 0777, true);
                        }else{
                            $documento = glob('../archivos/carta_egresado/'.$ncuenta.'/*'); // obtiene los documentos
                            foreach($documento as $documento){ // itera los documentos
                            if(is_file($documento)) 
                            unlink($documento); // borra los documentos
                        }
                        }
                for ($i = 0; $i <=count($documento_nombre_temporal)-1 ; $i++) {
                
                    move_uploaded_file($documento_nombre_temporal[$i],"$micarpeta/$documento_nombre[$i]");
                    $ruta= '../archivos/carta_egresado/'.$ncuenta.'/'.$documento_nombre[$i];
                    $direccion[]= $ruta;
                }
                $documento = json_encode($direccion);

                if($verificado1!=="" && $verificado2!==""){
                    $insertanombre ="call upd_nombre('$ncuenta','$verificado1','$verificado2')";
                    $resultadon = $mysqli->query($insertanombre);
                    $resultadon->free();
                    $mysqli->next_result();
                }

                $sqlp = "call ins_carta_egresado('$ncuenta','$documento','$correo')";
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
                    echo "Error: " . $sqlp ;
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

    }else{
        echo '<script type="text/javascript">
                swal({
                    title:"",
                    text:"Faltan Documentos por subir....",
                    type: "error",
                    showConfirmButton: false,
                    timer: 1500
                    });
                    $(".FormularioAjax")[0];
              </script>'; 
    }
}
elseif(isset($_POST['aprobado']) && $_POST['aprobado']!==""){

    $aprobado = $_POST['aprobado'];
    $cuenta = $_POST['txt_cuenta'];
    $observacion = $_POST['txt_observacion'];

    if($observacion!==""){
        $sqlp = "call upd_carta_egresado_observacion('$aprobado','$observacion','$cuenta')";
        $resultadop = $mysqli->query($sqlp);
        if($resultadop == true){

            $resultadop->free();
            $mysqli->next_result();

            if($aprobado==="aprobado"){
                $consulta= "call ins_himno('$cuenta')";
                $consultar =  $mysqli->query($consulta);
                $consultar->free();
                $mysqli->next_result();
            }

            echo '<script type="text/javascript">
                    swal({
                        title:"",
                        text:"Solicitud enviada...",
                        type: "success",
                        allowOutsideClick:false,
                        showConfirmButton: true,
                        }).then(function () {
                        window.location.href = "revision_carta_egresado_vista.php";
                        });
                        $(".FormularioAjax")[0].reset();
                    </script>'; 
             } 
        else {
            echo "Error: " . $sql ;
            }
       
    }else{
        $sqlp = "call upd_carta_egresado('$aprobado','$cuenta')";
        $resultadop = $mysqli->query($sqlp);
        if($resultadop == true){
            $resultadop->free();
            $mysqli->next_result();

            if($aprobado==="aprobado"){
                $consulta= "call ins_himno('$cuenta')";
                $consultar =  $mysqli->query($consulta);
                $consultar->free();
                $mysqli->next_result();
        
                }

            echo '<script type="text/javascript">
                    swal({
                        title:"",
                        text:"Solicitud enviada...",
                        type: "success",
                        allowOutsideClick:false,
                        showConfirmButton: true,
                        }).then(function () {
                        window.location.href = "revision_carta_egresado_vista.php";
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

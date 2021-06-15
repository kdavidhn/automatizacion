<?php
	
require_once ('../clases/Conexion.php');

if(isset($_POST['txt_horario']) && $_POST['txt_horario']!==""){
  $id= $_POST['id'];
  $cuenta = $_POST['txt_cuenta'];
 
  $cupos="SELECT cupos FROM `tbl_horario_himno` WHERE id_horario_himno = '$id'";
  $resultado = $mysqli->query($cupos);  
  $row = $resultado->fetch_array(MYSQLI_ASSOC);

      if( $row['cupos']>=1){
            $sqlp = "call ins_himno ('$cuenta','$id')";
            $resultadop = $mysqli->query($sqlp);
            $resultadop->free();
            $mysqli->next_result();

            if($resultadop == true){
              
              $sql="UPDATE tbl_horario_himno SET cupos = cupos - 1
              WHERE id_horario_himno = '$id'";
              $resultado = $mysqli->query($sql); 
              

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
                title:"No hay cupos disponibles",
                text:"Seleccione otra Jornada....",
                type: "error",
                showConfirmButton: false,
                timer: 1500
            });
            $(".FormularioAjax")[0];
      </script>'; 
      }

}else if(isset($_POST['aprobado'])){

    $cuenta= $_POST['txt_cuenta'];
    $aprobado = $_POST['aprobado'];
    $jornada = $_POST['txt_jornada'];

    $sqlp = "call upd_himno('$aprobado','$cuenta','$jornada')";
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
                            window.location.href = "menu_revision_himno.php";
                            });
                            $(".FormularioAjax")[0].reset();
                        </script>'; 
                 } 
            else {
                echo "Error: " . $sqlp ;
                }

}
else{
    echo '<script type="text/javascript">
    swal({
            title:"",
            text:"Seleccione su Jornada....",
            type: "error",
            showConfirmButton: false,
            timer: 1500
        });
        $(".FormularioAjax")[0];
  </script>'; 
}


?>
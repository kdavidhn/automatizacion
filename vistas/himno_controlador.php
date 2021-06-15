<?php
	
require_once ('../clases/Conexion.php');

if(isset($_POST['aprobado'])){

    $cuenta= $_POST['txt_cuenta'];
    $aprobado = $_POST['aprobado'];

    $sqlp = "call upd_himno('$aprobado','$cuenta')";
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
                            window.location.href = "lista_alumnos_himno.php";
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
                        text:"No a seleccionado su aprobación....",
                        type: "error",
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $(".FormularioAjax")[0];
              </script>'; 
}
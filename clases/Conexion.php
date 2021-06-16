<?php



    $servidor= "127.0.0.1";
    $usuario= "root";
    $password = "";
    $base= "automatizacion";

	$mysqli = new mysqli($servidor, $usuario,$password,$base);
	$connection = mysqli_connect($servidor, $usuario,$password,$base) or die("Error " . mysqli_error($connection));
	
	if($mysqli->connect_error){
		echo "Nuestro sitio presenta fallas....";
		die('Error en la conexion' . $mysqli->connect_error);
		exit();	
	}
    $conexion = new mysqli('127.0.0.1', 'root', '', 'automatizacion');
if (!mysqli_set_charset($mysqli, "utf8")) {
        printf("Error cargando el conjunto de caracteres utf8: %s\n", mysqli_error($mysqli));
        exit();
    } else {
        printf("");
    }

?>
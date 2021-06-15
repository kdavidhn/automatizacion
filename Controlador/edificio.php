<?php
 require "../clases/conexion_mantenimientos.php";

$instancia_conexion = new conexion();

$query = $instancia_conexion->ejecutarConsulta("SELECT * FROM tbl_edificios");


while ( $row = $query->fetch_assoc() )
{
	echo '<option value="' . $row['id_edificio']. '">' . $row['nombre'] . '</option>' . "\n";
}
?>
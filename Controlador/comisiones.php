<?php
require "../clases/conexion_mantenimientos.php";

$instancia_conexion = new conexion();




$query = $instancia_conexion->ejecutarConsulta("SELECT * FROM tbl_comisiones");

//echo '<option value="0">Seleccione</option>';

while ( $row = $query->fetch_assoc() )
{
	echo '<option value="' . $row['id_comisiones']. '">' . $row['comision'] . '</option>' . "\n";
}

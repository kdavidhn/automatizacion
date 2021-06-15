<?php
require "../clases/conexion_mantenimientos.php";

$instancia_conexion = new conexion();

$la_comision = $_POST['id_comisiones'];

$query = $instancia_conexion->ejecutarConsulta("SELECT * FROM tbl_actividades WHERE id_comisiones = $la_comision");

//echo '<option value="0">Seleccione</option>';

while ( $row = $query->fetch_assoc() )
{
	echo '<option value="' . $row['id_actividad']. '">' . $row['actividad'] . '</option>' . "\n";
}
?>
<?php
 require "../clases/conexion_mantenimientos.php";

 $instancia_conexion = new conexion();
 
$el_edificio = $_POST['id_edificio'];
$aula= $_POST['id_aula'];

$query = $instancia_conexion->ejecutarConsulta("SELECT * FROM tbl_aula WHERE id_edificio = $el_edificio");



while ( $row = $query->fetch_assoc() )
{
	// if($row['id_aula']==$aula){
	// 	echo '<option selected value="' . $row['id_aula']. '">' . $row['codigo'] . '</option>' . "\n";
	// }else{
		echo '<option value="' . $row['id_aula'] . '">' . $row['codigo'] . '</option>' . "\n";
	// }

	// echo '<input type="text" value="' . $row['capacidad']. '">';
}


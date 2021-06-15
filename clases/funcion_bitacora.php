   <?php


	class bitacora {
		public static function evento_bitacora($id_objeto,$id_usuario,$accion,$descripcion)
		{
			   require ('../clases/Conexion.php');
			   
			   		$sql = "INSERT INTO  tbl_bitacora (Id_objeto, id_usuario,Fecha, Accion , Descripcion)
    			 VALUES ('$id_objeto', '$id_usuario' , sysdate(), '$accion', '$descripcion')";
		
			$resultado = $mysqli->query($sql);
		}
		
}
		?>
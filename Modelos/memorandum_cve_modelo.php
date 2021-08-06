<?php 
//Incluímos inicialmente la conexión a la base de datos
//require "../clases/Conexion.php";
require "../clases/Conexionvoae.php";

Class memorandum
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}


	//Implementamos un método para insertar registros  
	public function insertar($no_memo,$id_tipo_memo,$remitente,$destinatario,$asunto,$contenido)
	{
		$sql="INSERT INTO tbl_voae_memorandums (no_memo,id_tipo_memo,remitente,destinatario,fecha,asunto,contenido)
		VALUES (upper(trim('$no_memo')),upper(trim('$id_tipo_memo')),upper(trim('$remitente')),
		upper(trim('$destinatario')),now(),upper(trim('$asunto')),upper(trim('$contenido')))";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($id_memo,$no_memo,$id_tipo_memo,$remitente,$destinatario,$asunto,$contenido)
	{
		$sql="UPDATE tbl_voae_memorandums SET id_memo=upper(trim('$id_memo')),  no_memo= upper(trim('$no_memo')),
		id_tipo_memo=upper(trim('$id_tipo_memo')), remitente= upper(trim('$remitente')), 
		destinatario= upper(trim('$destinatario')),  asunto= upper(trim('$asunto')),
		contenido= upper(trim('$contenido')) WHERE id_memo='$id_memo'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para eliminar un memorandum
	public function eliminar($id_memo)
	{
		$sql="DELETE FROM tbl_voae_memorandums WHERE id_memo='$id_memo'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($id_memo)
	{
		$sql="SELECT * FROM tbl_voae_memorandums WHERE id_memo='$id_memo'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		//$sql="SELECT * FROM tbl_voae_memorandums";
		//return ejecutarConsulta($sql);		

		$sql="SELECT m.id_memo as 'id_memo', m.no_memo as 'no_memo', tm.nombre_tipo_memorandum as 'nombre_tipo_memorandum',
		 m.remitente as 'remitente',m.destinatario as 'destinatario', m.fecha as 'fecha', m.asunto as 'asunto',
		  m.contenido as 'contenido' FROM tbl_voae_memorandums AS m
		   INNER JOIN tbl_voae_tipo_memorandum AS tm ON m.id_tipo_memo = tm.id_tipo_memorandum";
			return ejecutarConsulta($sql);
	}
}

?>
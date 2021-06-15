<?php 

 

function permiso_ver($pantalla)


{


require ('../clases/Conexion.php');

$sql_permisos="select pu.visualizar as Ver from tbl_permisos_usuarios pu ,tbl_objetos p,tbl_usuarios u ,tbl_roles r where r.id_rol=pu.id_rol and r.id_rol=u.id_rol and pu.id_objeto=p.id_objeto and u.id_usuario=$_SESSION[id_usuario] and p.id_objeto=$pantalla ";

$resultado_permisos = $mysqli->query($sql_permisos);


$permiso_ver= mysqli_fetch_array($resultado_permisos);


 

return $permiso_ver['Ver'];

}

?>
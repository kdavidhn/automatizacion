<?php

class permisos {



public static function permiso_modificar($permiso_modificar)

                   {

 require ('../clases/Conexion.php');

                    $sql_permiso_mod="select pu.modificar as modificar from tbl_permisos_usuarios pu ,tbl_objetos p,tbl_usuarios u ,tbl_roles r where r.id_rol=pu.id_rol and r.id_rol=u.id_rol and pu.id_objeto=p.id_objeto and id_usuario=".$_SESSION['id_usuario']." and p.id_objeto='$permiso_modificar' ";

                  $resultado_permiso_mod = $mysqli->query($sql_permiso_mod);

                  $permisos= $resultado_permiso_mod->fetch_row();

                   return $permisos[0];
                
                   }



public static function permiso_insertar($permiso_insertar)

                   {


 require ('../clases/Conexion.php');

                    $sql_permiso_in="select pu.insertar as insertar from tbl_permisos_usuarios pu ,tbl_objetos p,tbl_usuarios u ,tbl_roles r where r.id_rol=pu.id_rol and r.id_rol=u.id_rol and pu.id_objeto=p.id_objeto and id_usuario=".$_SESSION['id_usuario']." and p.id_objeto='$permiso_insertar' ";

                  $resultado_permiso_in = $mysqli->query($sql_permiso_in);

                  $permisos= $resultado_permiso_in->fetch_row();

                   return $permisos[0];
                
                   }    

public static function permiso_eliminar($permiso_eliminar)

                   {


 require ('../clases/Conexion.php');

 session_start();
                    $sql_permiso_eliminar="select pu.eliminar as eliminar from tbl_permisos_usuarios pu ,tbl_objetos p,tbl_usuarios u ,tbl_roles r where r.id_rol=pu.id_rol and r.id_rol=u.id_rol and pu.id_objeto=p.id_objeto and id_usuario=".$_SESSION['id_usuario']." and p.id_objeto='$permiso_eliminar' ";

                  $resultado_permiso_eliminar = $mysqli->query($sql_permiso_eliminar);

                  $permisos= $resultado_permiso_eliminar->fetch_row();

                   return $permisos[0];
                
                   }                                  

}
                   ?>
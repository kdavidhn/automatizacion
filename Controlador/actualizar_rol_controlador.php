<?php
  
session_start();
    
require_once ('../clases/Conexion.php');
require_once ('../clases/funcion_bitacora.php');


  $Rol=strtoupper ($_POST['txtnombrerol']);
  $Descripcion=strtoupper ($_POST['txtdescripcionrol']);
  $Id_rol= $_GET['Id_rol']; 
  $var=0;

  /* Iniciar la variable de sesion y la crea */


///Logica para el rol que se repite
 $sqlexiste=("select count(Rol) as rol  from tbl_roles where Rol='$Rol' and Id_rol<>'$Id_rol' ;");
 //Obtener la fila del query
$existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));



if ($existe['rol']==1 )
{/*
header("location: ../contenidos/editarRoles-view.php?msj=1&Rol=$Rol2 ");*/

                        header("location:../vistas/gestion_roles_vista.php?msj=1"); 

}
else
{


  if (isset($_POST['checkboxactivomodificar']) && $_POST['checkboxactivomodificar'] == 'true') 
  {
  $var=1;
  }
  else
  {
  $var=0;
  } 


   $sql = "call proc_actualizar_rol('$Rol','$Descripcion',$var,'$_SESSION[usuario]','$Id_rol' )";






 

    $valor="select Rol, Descripcion, Estado from tbl_roles WHERE Id_rol= '$Id_rol'";
    $result_valor=$mysqli->query($valor);
    $valor_viejo=$result_valor->fetch_array(MYSQLI_ASSOC);

    if ($valor_viejo['Rol']<>$Rol and $valor_viejo['Descripcion']<>$Descripcion and $valor_viejo['Estado']<>$var )
        {
          
      $Id_objeto=6 ;
        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'MODIFICO' , ' EL ROL '.$valor_viejo['Rol'].' POR '.$Rol. ', LA DESCRIPCION DE EL ROL ' .$Rol .', EL ESTADO DE' .$Rol. ' ');  
        


           /* Hace el query para que actualize*/
        $resultado = $mysqli->query($sql);

        if ($resultado==true) {
                        header("location:../vistas/gestion_roles_vista.php?msj=2"); 


}
else
{
           header("location:../vistas/gestion_roles_vista.php?msj=3"); 

}


        

          }


      elseif ($valor_viejo['Rol']<>$Rol and $valor_viejo['Descripcion']<>$Descripcion )
          {
            
        $Id_objeto=6 ;
          bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'Modifico' , ' '.$valor_viejo['Rol'].' por '.$Rol. ', La descripción de el rol ' .$Rol .' '); 
             /* Hace el query para que actualize*/
    
          $resultado = $mysqli->query($sql);

       if ($resultado==true) {
                        header("location:../vistas/gestion_roles_vista.php?msj=2"); 


}
else
{
           header("location:../vistas/gestion_roles_vista.php?msj=3"); 

}

      
            }


          elseif ($valor_viejo['Rol']<>$Rol and  $valor_viejo['Estado']<>$var )
              {
                
            $Id_objeto=6 ;
              bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'Modifico' , ' '.$valor_viejo['Rol'].' por '.$Rol. ', El Estatus de el rol ' .$Rol. ' '); 
                 /* Hace el query para que actualize*/
               
              $resultado = $mysqli->query($sql);

       if ($resultado==true) {
                        header("location:../vistas/gestion_roles_vista.php?msj=2"); 


}
else
{
           header("location:../vistas/gestion_roles_vista.php?msj=3"); 

}

           

                }


              elseif ($valor_viejo['Descripcion']<>$Descripcion and $valor_viejo['Estado']<>$var )
                  {
                    
                $Id_objeto=6 ;
                  bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'Modifico' , ' '. ' La descripción de el rol ' .$Rol .', El Estatus de el rol ' .$Rol. ' ');  
                     /* Hace el query para que actualize*/
                               $resultado = $mysqli->query($sql);
                                      if ($resultado==true) {
                        header("location:../vistas/gestion_roles_vista.php?msj=2"); 


}
else
{
           header("location:../vistas/gestion_roles_vista.php?msj=3"); 

}


                    }

                  elseif ($valor_viejo['Rol']<>$Rol)
                      {
                        
                    $Id_objeto=6 ; 
                         bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'Modifico' , ' ' . $valor_viejo['Rol'].' por '.$Rol.' ' ); 
                         /* Hace el query para que actualize*/
        
                      $resultado = $mysqli->query($sql);
                             if ($resultado==true) {
                        header("location:../vistas/gestion_roles_vista.php?msj=2"); 


}
else
{
           header("location:../vistas/gestion_roles_vista.php?msj=3"); 

}
                        }

                              elseif ($valor_viejo['Descripcion']<>$Descripcion)
                              {
                                
                            $Id_objeto=6 ; 
                                bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'Modifico' , ' La descripción de el rol ' .$Rol. ' ' );


                                   /* Hace el query para que actualize*/
                           
                              $resultado = $mysqli->query($sql);
                                     if ($resultado==true) {
                        header("location:../vistas/gestion_roles_vista.php?msj=2"); 


}
else
{
           header("location:../vistas/gestion_roles_vista.php?msj=3"); 

}

                                 
                                } 

                                      elseif ($valor_viejo['Estado']<>$var)
                                    {
                                      
                                  $Id_objeto=6 ; 
                                       bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'Modifico' , 'El Estatus de el rol ' .$Rol.' ' );
                                          /* Hace el query para que actualize*/

                              
                                    $resultado = $mysqli->query($sql);
                                           if ($resultado==true) {
                        header("location:../vistas/gestion_roles_vista.php?msj=2"); 


}
else
{
           header("location:../vistas/gestion_roles_vista.php?msj=3"); 

}
 
                                      }  
          else
          {
          /*header("location: ../contenidos/editarRoles-view.php?msj=3&Rol=$Rol2 ");*/
             header("location:../vistas/gestion_roles_vista.php?msj=3"); 

          } 



        

    
}


?>

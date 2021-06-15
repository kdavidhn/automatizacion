<?php
        
		session_unset(); /*Elimina los valores de la sesion*/
		session_destroy();/*Elimina la ssesion*/
     header('location: ../index.php');

?>
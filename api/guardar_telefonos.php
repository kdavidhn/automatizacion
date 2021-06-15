<?php
require_once('../clases/Conexion.php');
//SELECT LAST_INSERT_ID() AS id_carga_academica; BASE AL FINAL DEL PROCEDIMIENTO
$body = file_get_contents("php://input");
$data = json_decode($body, true);

$id = $data['id'];

$list = $data['data'];
echo $list;
$info = array();
foreach($list as $item){
    $sql = "call proc_insertar_telefonos(:telefono)";
    $stmt =  $connect->prepare($sql);
    $stmt->bindParam(":telefono",$item['telefono'],PDO::PARAM_STR);
   
    
    $stmt->execute();
    $idTask = $stmt->fetchAll(PDO::FETCH_ASSOC)[0]['id_contacto'];
    array_push($info,$idTask);
}
$send = array("info"=>$info, "status" => 200);
http_response_code(200);
echo json_encode($send);
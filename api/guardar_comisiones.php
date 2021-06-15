<?php
require_once('../clases/Conexion.php');
//SELECT LAST_INSERT_ID() AS id_carga_academica; BASE AL FINAL DEL PROCEDIMIENTO
$body = file_get_contents("php://input");
$data = json_decode($body, true);

$id = $data['id'];

$list = $data['data'];

$info = array();
foreach($list as $item){
    $sql = "CALL proc_prueba_api(:actividades, :id_persona);";
    $stmt =  $connect->prepare($sql);
    $stmt->bindParam(":actividades",$item['actividades'],PDO::PARAM_INT);
    $stmt->bindParam(":id_persona",$item['id_persona'],PDO::PARAM_INT);
   
    
    $stmt->execute();
    $idTask = $stmt->fetchAll(PDO::FETCH_ASSOC)[0]['id_act_persona'];
    array_push($info,$idTask);
}
$send = array("info"=>$info, "status" => 200);
http_response_code(200);
echo json_encode($send);
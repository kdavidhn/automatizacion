<?php
require_once('../clases/Conexion.php');

// $id_area = $_POST['id_area'];
//$id_persona = $_POST['id_persona'];


$id_persona = json_decode($_POST['id_persona']);
//$data = $_POST['array'];
$data = json_decode($_POST['array_prefe1']);

//var_dump($data);
var_dump($id_persona);

foreach ($data as $item) {
    $sql = "CALL proc_insert_exp_area_docen(:id_area, :id_persona)";
    $stmt =  $connect->prepare($sql);
    $stmt->bindParam(":id_area", $item, PDO::PARAM_INT);
    $stmt->bindParam(":id_persona", $id_persona, PDO::PARAM_INT);



    $stmt->execute();

    // $idTask = $stmt->fetchAll(PDO::FETCH_ASSOC)[0]['id_pref_area_doce'];
    // array_push($info, $idTask);  

}
// //var_dump($item);

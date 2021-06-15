<?php 

$data = json_decode(file_get_contents("http://localhost:8055/apiproyecto/equivalencias.php"),true);
echo('<pre>');
print_r($data);
echo('</pre>');

$counter=0;
 while ($counter< count($data["ROWS"])) { 
  echo $data["ROWS"][$counter]["nombre_completo"];
  echo "<br>";  
  $counter = $counter + 1; }

?>

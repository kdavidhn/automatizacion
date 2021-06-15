
<?php
//export.php  
$servidor = "den1.mysql3.gear.host";
$usuario = "automatizacion2";
$password = "Be50i?1!guh3";
$base = "automatizacion2";


$connect = mysqli_connect($servidor, $usuario, $password, $base);
$output = '';
if (isset($_POST["export"])) {
    $query = "call sel_reporte_docente()";
    $result = mysqli_query($connect, $query);
    if (mysqli_num_rows($result) > 0) {
        $output .= '
        
   <table class="table" bordered="1">  
     <h1>Reporte Carga Academica Docente </h1>
                    <tr>  
                        <th>CODIGO ASIGNATURA</th>  
                        <th>ASIGNATURA</th>  
                        <th>SECCION</th>
                        <th>HI</th>
                        <th>HF</th>
                        <th>EDIFICIO</th>
                        <th>DIAS</th>
                        <th>AULA</th>
                        <th>N. ALUMNOS</th>
                    </tr>
  ';
        while ($row = mysqli_fetch_array($result)) {
            $output .= '
    <tr>                         
                            <td>' . $row["codigo"] . '</td>  
                            <td>' . $row["asignatura"] . '</td>  
                            <td>' . $row["seccion"] . '</td>  
                            <td>' . $row["hra_inicio"] . '</td>
                            <td>' . $row["hra_final"] . '</td>
                            <td>' . $row["edificio"] . '</td> 
                            <td>' . $row["dia"] . '</td> 
                            <td>' . $row["aula"] . '</td> 
                            <td>' . $row["num_alumnos"] . '</td>
                    </tr>
   ';
        }
        $output .= '</table>';
        header('Content-Type: application/xls');
        header('Content-Disposition: attachment; filename=reporte_carga.xls');

        echo $output;
    }
}
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<?php
	session_start();
	require_once "../clases/Conexion.php";


 ?>
 <!DOCTYPE html>
 <html>
 <head>
 
<link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.css">
<link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" src="../plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script type="text/javascript" src="../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
 </head>
	<center><h2>CONTROL DE HORARIOS DE EXAMEN DEL HIMNO</h2></center>
	<table id="example" class="table table-striped table-bordered table-condensed" style="text-align:center;">


			<tr>
				<center><td>FECHA DEL EXAMEN</td></center>
				<center><td>HORARIO DEL EXAMEN</td></center>
				<center><td>JORNADA DEL EXAMEN</td></center>
				<center><td>CUPOS</td></center>
				<center><td>EDITAR HORARIOS</td></center>
			</tr>

			<?php

				if(isset($_SESSION['consulta'])){
					if($_SESSION['consulta'] > 0){
						$idp=$_SESSION['consulta'];
						$sql="SELECT * from tbl_horario_himno";
					}else{
							$sql="SELECT * from tbl_horario_himno";
					}
				}else{
					$sql="SELECT * from tbl_horario_himno";
				}

				$result=mysqli_query($connection,$sql);
				while($ver=mysqli_fetch_row($result)){

					$datos=$ver[0]."||".
							$ver[1]."||".
							$ver[2]."||".
							$ver[3]."||".
							$ver[4];

														
				?>

				<tr>
				<td><center><?php echo $ver[1] ?></center></td>
				<td><center><?php echo $ver[2] ?></center></td>
				<td><center><?php echo $ver[3] ?></center></td>
				<td><center><?php echo $ver[4] ?></center></td>
				<td><center><button class="btn btn-primary" data-toggle="modal" data-target="#modalHorario" onclick="agregaform_u('<?php echo $datos ?>')">          <i  class="far fa-edit" "></i></button></center>
				</tr>
				<?php
			}
				?>
			</table>


		</html>
<script type="text/javascript" src="../plugins/sweetalert2/sweetalert2.min.js" ></script>
<script type="text/javascript">

$(document).ready(function() {
    $('#example').DataTable();
} );
</script>



<?php
	session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
		exit;
        }
	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos	
	$active_reporte="active";
	$title="HPL";
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include("head.php");?>
  </head>
  <body>
	<?php
	include("navbar.php");
	?>
    <div class="container">
	<div class="panel panel-success">
		<div class="panel-heading">
			<h4><i class='glyphicon glyphicon-book'></i> Reportes de Inventario</h4>
		</div>
		<div class="panel-body">
			<?php
			include("modal/registro_productos.php");
			include("modal/editar_productos.php");
			?>
			<form class="form-horizontal" method="get" role="form" action="reporte_inventario.php" target="_blank">
				<div class="row">
					<div class='col-md-4'>
						<label>Desde</label>
						<input type="date" class="form-control" name="desde" required>
					</div>
					<div class='col-md-4'>
						<label>Hasta</label>
						<input type="date" class="form-control" name="hasta" required>
					</div>
					<!-- Busqueda categoria esta 100% -->
					<div class='col-md-4'>
					<label>Categoria</label>
					<select class='form-control' name='categoria' id='categoria' >
						<option value="nada" selected>Selecciona una categoria</option>
							<?php 
							$query_categoria=mysqli_query($con,"select * from categorias order by nombre_categoria");
							while($rw=mysqli_fetch_array($query_categoria))	{
								?>
								<option value="<?php echo $rw['nombre_categoria'];?>"><?php echo $rw['nombre_categoria'];?></option>			
								<?php
							}
							?>
					</select>
					</div>
				
				</div>
				<hr>
				<div class='row-fluid'>
					<h1 hidden>Reporte</h1>
					<input type="submit" class="btn btn-lg btn-success" name="Imprimir" value="Generar">
				</div>
	
			</form>	
							
  </div>
</div>	 
</div>
	<hr>
	<?php
	include("footer.php");
	?>
  </body>
</html>

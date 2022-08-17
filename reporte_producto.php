<?php
	session_start();
	if (!isset($_SESSION['user_login_status']) && $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
		exit;
        }
        date_default_timezone_set('America/El_Salvador');
	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos	
	$active_reporte="active";
	$title="HPL";

    $result = mysqli_query($con, "SELECT * FROM products");
	$array = array();
	if($result){
		while ($row = mysqli_fetch_array($result)) {
			$productos = utf8_encode($row['nombre_producto']);
			array_push($array, $productos); // productos guardados arreglo
		}
	}
?>
<!DOCTYPE html>
<html lang="en">

<head>
<?php include("head.php");?>
    <script type="text/javascript" src="jquery/jquery-1.12.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="jquery/jquery-ui.css">
    <script type="text/javascript" src="jquery/jquery-ui.js"></script>
</head>

<body>
    <?php
	include("navbar.php");
	?>
    <div class="container">
        <div class="panel panel-success">
            <div class="panel-heading">
                <h4><i class='glyphicon glyphicon-book'></i> Reportes por Producto</h4>
            </div>
            <div class="panel-body">
                <?php
			include("modal/registro_productos.php");
			include("modal/editar_productos.php");
			?>
                <form class="form-horizontal" method="get" role="form" action="reporte_por_producto.php" target="_blank">

                    <div class="row">
                        <div class='col-md-4'>
                            <label>Producto</label>
                            <input class="form-control" id="buscar_producto" type="text" name="buscar_producto" placeholder="Buscar producto"
                                spellcheck="false" required>
                        </div>

                        <div class='col-md-3'>
                            <label>Desde</label>
                            <input type="date" class="form-control" name="desde" value=<?php echo date("Y-m-01"); ?>
                                required>
                        </div>
                        <div class='col-md-3'>
                            <label>Hasta</label>
                            <input type="date" class="form-control" name="hasta" value=<?php echo date("Y-m-d"); ?>
                                required>
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
    <script type="text/javascript">
    $(document).ready(function() {
        $(function() {
            var itemsProductos = <?= json_encode($array) ?>

            $('#buscar_producto').autocomplete({
                source: itemsProductos
            });
        });
    });
    </script>
</body>

</html>
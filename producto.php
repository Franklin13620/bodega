<?php
	date_default_timezone_set('America/El_Salvador');
	session_start();
	if (!isset($_SESSION['user_login_status']) && $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
		exit;
        }

	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
	include("funciones.php");
	
	$active_productos="active";
	$active_clientes="";
	$active_usuarios="";	
	$title="Producto";

	if (isset($_GET['id'])){
		$id_producto=intval($_GET['id']);
		$query=mysqli_query($con,"select * from products where id_producto='$id_producto'");
		$row=mysqli_fetch_array($query);
		
	} else {
		die("Producto no existe");
	}
	
	if (isset($_POST['reference']) && isset($_POST['quantity'])){
		$tipo=0;
		$quantity=intval($_POST['quantity']);
		$entrada_producto=$quantity;
		$salida_producto= 0;
		$reference=mysqli_real_escape_string($con,(strip_tags($_POST["reference"],ENT_QUOTES)));
		$id_producto=intval($_GET['id']);
		$user_id=$_SESSION['user_id'];
		$firstname=$_SESSION['firstname'];
		$nota="$firstname agrego $quantity producto(s) al inventario";
		$fecha=date("Y-m-d"); 
		$hora = date("H:i:s");// Segundos: H:i:s
		$motivo = 0;
		guardar_historial($id_producto,$user_id,$fecha,$nota,$reference,$quantity,$tipo, $motivo, $hora);
		
		$update=agregar_stock($id_producto,$quantity);
		if ($update==1){
			$message=1;
		} else {
			$error=1;
		}
	}
	if (isset($_POST['reference_remove']) && isset($_POST['quantity_remove']) && isset($_POST['motivo'])){
		// Validar stock inventario
		if ($row['stock'] <= 0){
			$errorInventario = 1;
		}else{
		if ($_POST['quantity_remove'] > $row['stock']) {
		$errorInventarioMenorAlDescargo = 1;
		}else{
		$tipo=1;
		$motivo = $_POST['motivo'];
		$quantity=intval($_POST['quantity_remove']);
		$entrada_producto= 0;
		$salida_producto=$quantity;
		$reference=mysqli_real_escape_string($con,(strip_tags($_POST["reference_remove"],ENT_QUOTES)));
		$id_producto=intval($_GET['id']);
		$user_id=$_SESSION['user_id'];
		$firstname=$_SESSION['firstname'];
		$nota="$firstname descargo $quantity producto(s) del inventario";
		$fecha=date("Y-m-d");
		$hora = date("H:i:s");// Segundos: H:i:s

		guardar_historial($id_producto,$user_id,$fecha,$nota,$reference,$quantity,$tipo,$motivo, $hora);
		
		$update=eliminar_stock($id_producto,$quantity);
		if ($update==1){
			$message=1;
		} else {
			$error=1;
		}
	}
}
}
if (isset($_GET['id'])){
	$id_producto=intval($_GET['id']);
	$query=mysqli_query($con,"select * from products where id_producto='$id_producto'");
	$row=mysqli_fetch_array($query);
	
} else {
	die("Producto no existe");
}


?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include("head.php");?>
  </head>
  <body>
	<?php
	include("navbar.php");
	include("modal/agregar_stock.php");
	include("modal/eliminar_stock.php");
	include("modal/editar_productos.php");
	
	?>
	
	<div class="container">

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-body">
            <div class="row">
              <div class="col-sm-4 col-sm-offset-2 text-center">
				 <img class="item-img img-responsive" src="
				 <?php
				$path =  'img/productos'.$row['imagen_producto']; 
				if(file_exists($path)){
					echo "img/productos". $row['imagen_producto'];
				}else{
					echo "img/stock.png";
				} ?>"
				 
				  alt=""> 
				  <br>
				<?php 
					if($_SESSION['tipo_usuario'] == "Admin"){?>
                    <a href="#" class="btn btn-danger" onclick="eliminar('<?php echo $row['id_producto'];?>')" title="Eliminar"> <i class="glyphicon glyphicon-trash"></i> Eliminar </a> 
					<a href="#myModal2" data-toggle="modal" data-codigo='<?php echo $row['codigo_producto'];?>' data-nombre='<?php echo $row['nombre_producto'];?>' data-categoria='<?php echo $row['id_categoria']?>' data-precio='<?php echo $row['precio_producto']?>' data-stock='<?php echo $row['stock'];?>' data-id='<?php echo $row['id_producto'];?>' class="btn btn-info" title="Editar"> <i class="glyphicon glyphicon-pencil"></i> Editar </a>	
				<?php 
					}else{?>
                    <a class="btn btn-danger" title="Eliminar" disabled><i class="glyphicon glyphicon-trash"></i> Eliminar </a> 
					<a class="btn btn-info" title="Editar" disabled><i class="glyphicon glyphicon-pencil"></i> Editar </a>	
					<?php } ?>
					
              </div>
			  
              <div class="col-sm-4 text-left">
                <div class="row margin-btm-20">
                    <div class="col-sm-12">
                      <span class="item-title"> <?php echo $row['codigo_producto'];?></span>
                    </div>
					<div class="col-sm-12">
                      <span class="current-stock"> Nombre </span>
                    </div>
                    <div class="col-sm-12 margin-btm-10">
                      <span class="item-quantity"><?php echo $row['nombre_producto'];?></span>
                    </div>
                    <div class="col-sm-12 margin-btm-10">
                    </div>
                    <div class="col-sm-12">
                      <span class="current-stock">Stock disponible</span>
                    </div>
                    <div class="col-sm-12 margin-btm-10">
                      <span class="item-quantity"><?php echo number_format($row['stock'],0);?></span>
                    </div>
					<div class="col-sm-12">
                      <span class="current-stock"> Precio </span>
                    </div>
					<div class="col-sm-12">
                      <span class="item-price">$ <?php echo number_format($row['precio_producto'],2);?></span>
                    </div>
					
                    <div class="col-sm-12 margin-btm-10">
					</div>
                    <div class="col-sm-6 col-xs-6 col-md-4 ">
                      <a href="" data-toggle="modal" data-target="#add-stock"><img width="100px"  src="img/stock-in.png"></a>
                    </div>
                    <div class="col-sm-6 col-xs-6 col-md-4">
                      <a href="" data-toggle="modal" data-target="#remove-stock"><img width="100px"  src="img/stock-out.png"></a>
                    </div>
                    <div class="col-sm-12 margin-btm-10">
                    </div>
                    
                   
                                    </div>
              </div>
            </div>
            <br>
            <div class="row">

            <div class="col-sm-8 col-sm-offset-2 text-left">
                  <div class="row">
                    <?php
						if (isset($message)){
							?>
						<div class="alert alert-success alert-dismissible" role="alert">
						  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						  <strong>Aviso!</strong> Datos procesados exitosamente.
						</div>	
							<?php
						}
						if (isset($error)){
							?>
						<div class="alert alert-danger alert-dismissible" role="alert">
						  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						  <strong>Error!</strong> No se pudo procesar los datos.
						</div>	
							<?php
						}
						if (isset($errorInventario)){
							?>
						<div class="alert alert-danger alert-dismissible" role="alert">
						  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						  <strong>Error!</strong> No hay existencias.
						</div>	
							<?php
						}
						if (isset($errorInventarioMenorAlDescargo)){
							?>
						<div class="alert alert-danger alert-dismissible" role="alert">
						  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						  <strong>Error!</strong> No se puede descargar un numero mayor a la cantidad existente.
						</div>	
							<?php
						}
					?>	
					 <table class='table table-bordered'>
						<tr>
							<th class='text-center' colspan=7 >HISTORIAL DE INVENTARIO BODEGA</th>
						</tr>
						<tr>
							<td class='text-center'>Fecha</td>
							<td class='text-center'>Categoria</td>
							<td class='text-center'>Descripci??n</td>
							<td class='text-center'>Motivo</td>
							<td class='text-center'>Codigo</td>
							<td class='text-center'>Tipo</td>	
							<td class='text-center'>Total</td>
						</tr>
						<?php
							$query=mysqli_query($con,"SELECT * from products
							INNER JOIN categorias
							ON products.id_categoria = categorias.id_categoria
							INNER JOIN historial
							ON products.id_producto = historial.id_producto WHERE historial.id_producto='$id_producto'");
							while ($row=mysqli_fetch_array($query)){
						?>
						<tr>
							<td class='text-center'><?php echo date('d/m/Y', strtotime($row['fecha']));?></td>
							<!-- <td>//echo date('H:i:s', strtotime($row['fecha']));?></td> -->
							<td class='text-center'><?php echo $row['nombre_categoria'];?></td>
							<td><?php echo $row['nota'];?></td>
							<?php 
							if ($row['motivo'] == 0){
								$motivo = "---";
							}elseif($row['motivo'] == 1){
								$motivo = "Uso";
							}elseif($row['motivo'] == 2){
								$motivo = "Da??ado";
							}elseif($row['motivo'] == 3){
								$motivo = "Devolucion";
							}elseif($row['motivo'] == 4){
								$motivo = "Inv Inicial";
							}else{
								$motivo = "Desconocido";
							}
							?>
							<td class='text-center'><?php echo $motivo;?></td>
							<td class='text-center'><?php echo $row['referencia'];?></td>
							<td class='text-center'><?php if ($row['tipo']<=0){echo "Carga";}else{echo "Descargo";}?></td>							
							<td class='text-center'><?php echo number_format($row['cantidad'],2);?></td>
						</tr>		
								<?php
							}
						?>
					 </table>
                  </div>
                                    
                	<!-- PAGINACION PENDIENTE  -->
				</div>
            </div>
          </div>
        </div>
    </div>
</div>



</div>

	
	<?php
	include("footer.php");
	?>
	<script type="text/javascript" src="js/productos.js"></script>
  </body>
</html>
<script>
$( "#editar_producto" ).submit(function( event ) {
  $('#actualizar_datos').attr("disabled", true);
  
//var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/editar_producto.php",
			//data: parametros, //formData
			data: new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
			 beforeSend: function(objeto){
				$("#resultados_ajax2").html("Mensaje: Cargando...");
			  },
			success: function(datos){
			$("#resultados_ajax2").html(datos);
			$('#actualizar_datos').attr("disabled", false);
			// load(1);
			window.setTimeout(function() {
				$(".alert").fadeTo(500, 0).slideUp(500, function(){
				$(this).remove();});
				location.replace('http://bodega.hpl/producto.php?id=<?php echo $_GET['id'];?>');
			}, 500);
	
		  }
	});
  event.preventDefault();
})

$('#myModal2').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget) // Button that triggered the modal
		var codigo = button.data('codigo') // Extract info from data-* attributes
		var nombre = button.data('nombre')
		var categoria = button.data('categoria')
		var precio = button.data('precio')
		var stock = button.data('stock')
		var id = button.data('id')
		// imagen edit pendiente->
		var modal = $(this)
		modal.find('.modal-body #mod_codigo').val(codigo)
		modal.find('.modal-body #mod_nombre').val(nombre)
		modal.find('.modal-body #mod_categoria').val(categoria)
		modal.find('.modal-body #mod_precio').val(precio)
		modal.find('.modal-body #mod_stock').val(stock)
		modal.find('.modal-body #mod_id').val(id)
	})
	
	function eliminar (id){
		var q= $("#q").val();
		if (confirm("Realmente deseas eliminar el producto")){	
			location.replace('stock.php?delete='+id);
		}
	}
</script>
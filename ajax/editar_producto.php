<?php
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['mod_id'])) {
           $errors[] = "ID vacío";
        }else if (empty($_POST['mod_codigo'])) {
           $errors[] = "Código vacío";
        } else if (empty($_POST['mod_nombre'])){
			$errors[] = "Nombre del producto vacío";
		} else if ($_POST['mod_categoria']==""){
			$errors[] = "Selecciona la categoría del producto";
		} else if (empty($_POST['mod_precio'])){
			$errors[] = "Precio de venta vacío";
		} else if (
			!empty($_POST['mod_id']) &&
			!empty($_POST['mod_codigo']) &&
			!empty($_POST['mod_nombre']) &&
			$_POST['mod_categoria']!="" &&
			!empty($_POST['mod_precio'])
		){
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		// escaping, additionally removing everything that could be (html/javascript-) code
		$codigo=mysqli_real_escape_string($con,(strip_tags($_POST["mod_codigo"],ENT_QUOTES)));
		$nombre=mysqli_real_escape_string($con,(strip_tags($_POST["mod_nombre"],ENT_QUOTES)));
		$categoria=intval($_POST['mod_categoria']);
		$stock=intval($_POST['mod_stock']);
		$precio_venta=floatval($_POST['mod_precio']);
		$id_producto=$_POST['mod_id'];

		if (empty($_FILES['file']['name'])){
		$sql="UPDATE products SET codigo_producto='".$codigo."', nombre_producto='".$nombre."', id_categoria='".$categoria."', precio_producto='".$precio_venta."', stock='".$stock." ' WHERE id_producto='".$id_producto."'";
		
		} elseif (!empty($_FILES['file']['name'])){
		$nombre_imagen = basename($_FILES['file']['name']); //nombre
		$nombre_imagen_final = date("d-m-y"). "-". date("H-i-s")."-". $nombre_imagen;
		$file_imagen = $_FILES['file']['tmp_name']; //el archivo
		$ruta_destino = "../img/productos";
		$ruta_imagen = "/". $nombre_imagen_final;
		$subir_archivo = move_uploaded_file ($file_imagen, $ruta_destino .$ruta_imagen);
		$sql="UPDATE products SET codigo_producto='".$codigo."', nombre_producto='".$nombre."', id_categoria='".$categoria."', precio_producto='".$precio_venta."', stock='".$stock."', imagen_producto='".$ruta_imagen."' WHERE id_producto='".$id_producto."'";
		}else{
			$errors [] = "Ha ocurrido un error";
		}


		$query_update = mysqli_query($con,$sql);
			if ($query_update){
				$messages[] = "Producto ha sido actualizado satisfactoriamente.";
			} else{
				$errors []= "Lo siento algo ha salido mal intenta nuevamente.".mysqli_error($con);
			}
		} else {
			$errors []= "Error desconocido.";
		}
		
		if (isset($errors)){
			
			?>
			<div class="alert alert-danger" role="alert">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>Error!</strong> 
					<?php
						foreach ($errors as $error) {
								echo $error;
							}
						?>
			</div>
			<?php
			}
			if (isset($messages)){
				
				?>
				<div class="alert alert-success" role="alert">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<strong>¡Bien hecho!</strong>
						<?php
							foreach ($messages as $message) {
									echo $message;
								}
							?>
				</div>
				<?php
			}
			

?>
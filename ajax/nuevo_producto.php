<?php
// date_default_timezone_set('America/El_Salvador');
include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
		
	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['codigo'])) {
           $errors[] = "Código vacío";
        } else if (empty($_POST['nombre'])){
			$errors[] = "Nombre del producto vacío";
		} else if ($_POST['stock']==""){
			$errors[] = "Stock del producto vacío";
		} else if (empty($_POST['precio'])){
			$errors[] = "Precio de venta vacío";
		// } else if (empty($_FILES['file'])){
		//  	$errors[] = "La imagen esta vacia";
			
		} else if (
			!empty($_POST['codigo']) &&
			!empty($_POST['nombre']) &&
			$_POST['stock']!="" &&
			!empty($_POST['precio'])
			// && !empty($_FILES['file'])
		){
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		include("../funciones.php");
		// escaping, additionally removing everything that could be (html/javascript-) code
		$codigo=mysqli_real_escape_string($con,(strip_tags($_POST["codigo"],ENT_QUOTES)));
		$nombre=mysqli_real_escape_string($con,(strip_tags($_POST["nombre"],ENT_QUOTES)));
		$stock=intval($_POST['stock']);
		$id_categoria=intval($_POST['categoria']);
		$precio_venta=floatval($_POST['precio']);
		$date_added=date("Y-m-d");
		$entrada_producto = $stock;
		$salida_producto = 0;
		// img
		$nombre_imagen = basename($_FILES['file']['name']); //nombre
		$nombre_imagen_final = date("d-m-y"). "-". date("H-i-s")."-". $nombre_imagen;
		$file_imagen = $_FILES['file']['tmp_name']; //el archivo
		$ruta_destino = "../img/productos";
		$ruta_imagen = "/". $nombre_imagen_final;

		$subir_archivo = move_uploaded_file ($file_imagen, $ruta_destino .$ruta_imagen);

		$sql="INSERT INTO products (codigo_producto, nombre_producto, date_added, precio_producto, stock, id_categoria, entrada_producto, salida_producto, imagen_producto) 
		VALUES ('$codigo','$nombre','$date_added','$precio_venta', '$stock','$id_categoria', '$entrada_producto','$salida_producto', '$ruta_imagen')";
		$query_new_insert = mysqli_query($con,$sql);
			if ($query_new_insert){
				$messages[] = "Producto ha sido ingresado satisfactoriamente.";
				$id_producto=get_row('products','id_producto', 'codigo_producto', $codigo);
				$user_id=$_SESSION['user_id'];
				$firstname=$_SESSION['firstname'];
				$nota="$firstname agrego $stock producto(s) al inventario";
				$tipo = 0;
				$motivo = 4;
				$hora = date("H:i:s");

				guardar_historial($id_producto,$user_id,$date_added,$nota,$codigo,$stock,$tipo,$motivo,$hora);
				
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
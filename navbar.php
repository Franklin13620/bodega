	<?php
		if (isset($title))
		{
	?>
<nav class="navbar navbar-default ">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">HPL - BODEGA</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="<?php if (isset($active_productos)){echo $active_productos;}?>"><a href="stock.php"><i class='glyphicon glyphicon-barcode'></i> &nbspInventario</a></li>
		<li class="<?php if (isset($active_categoria)){echo $active_categoria;}?>"><a href="categorias.php"><i class='glyphicon glyphicon-tags'></i> &nbspCategorias</a></li>
		<!-- <li class="<?php //if (isset($active_reporte)){echo $active_reporte;}?>"><a href="reporte.php"><i  class='glyphicon glyphicon-book'></i> &nbspReportes</a></li> -->
   <li class="<?php if (isset($active_reporte)){echo $active_reporte;}?>">
    <a  href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class='glyphicon glyphicon-book'></i> &nbspReporte
      <span class="caret"></span>
    </a>
    <ul class="dropdown-menu">
      <li><a href="reporte.php">Reporte de Inventario</a></li>
      <li><a href="reporte_producto.php">Reporte por Producto</a></li>
    </ul>
   </li>
   <?php 
    if ($_SESSION['tipo_usuario'] == "Admin"){ ?>
		<li class="<?php if (isset($active_usuarios)){echo $active_usuarios;}?>"><a href="usuarios.php"><i  class='glyphicon glyphicon-user'></i> &nbspUsuarios</a></li>
    <?php 
    }else{ ?>
		<li class="hidden"><a href="#"><i  class='glyphicon glyphicon-user'></i> &nbspUsuarios</a></li>
    <?php } ?>
       </ul>
      <ul class="nav navbar-nav navbar-right">
		<li><a href="login.php?logout"><i class='glyphicon glyphicon-off'></i> Salir</a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
	<?php
		}
	?>
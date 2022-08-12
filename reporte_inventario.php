<?php
	date_default_timezone_set('America/El_Salvador');
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
	require_once('fpdf/fpdf.php');

    if(!isset($_GET['desde']) AND !isset($_GET['hasta'])) {
        header("location: error.php");
		exit;
    }
   $desde = $_GET["desde"];
   $hasta = $_GET["hasta"];
   $categoria = $_GET['categoria'];
    //fecha pendiente

class PDF extends FPDF{
    function Header()
    {
        $desdee=$GLOBALS['desde'];
        $this->Image('img/logo-hpl.png',10,8,33);
        $this->SetFont('Arial','B',12);
        $this->Cell(70);
        $this->Cell(42,30, utf8_decode('Reporte de Inventario'));
        $this->Ln(10);
        $this->Cell(70);
        $this->Cell(79,30, utf8_decode('Bodega Mantenimiento'));
        $this->Ln(40);
        $this->Cell(20,10, "Codigo",1, 0,'C', 0);
        $this->Cell(30,10, "Producto",1, 0,'C', 0);
        $this->Cell(30,10, "Categoria",1, 0,'C', 0);
        $this->Cell(20,10, "Entrada",1, 0,'C', 0);
        $this->Cell(20,10, "Salida",1, 0,'C', 0);
        $this->Cell(20,10, "Precio",1, 0,'C', 0);
        $this->Cell(20,10, "Exist",1, 0,'C', 0);
        $this->Cell(30,10, "Total",1, 1,'C', 0);

    }
    function Footer()
    { 
        $desdee=$GLOBALS['desde'];
        $hastaa=$GLOBALS['hasta'];
        $this->SetY(-15);
        $this->Cell(20,18, utf8_decode("Reporte de inventario del $desdee al $hastaa Espanil"));
        $this->SetFont('Arial','I',8);
        $this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
    }
}
    if($categoria=="nada"){
        $query ="SELECT * FROM products 
        INNER JOIN categorias 
        ON products.id_categoria = categorias.id_categoria WHERE products.date_added BETWEEN '$desde' AND '$hasta'";
    } else {
        $query ="SELECT * FROM categorias 
        INNER JOIN products 
        ON categorias.id_categoria = products.id_categoria WHERE products.date_added BETWEEN '$desde' AND '$hasta' AND nombre_categoria='$categoria'";
    }
    $query2 = "SELECT * FROM products";
    $resultado = $con->query($query);
    // Instancia 
    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('Arial','',10);

    $total=0;
    $total_precio=0;
    $total_entrada_producto=0;
    $total_salida_producto=0;
    $total_existencias=0;
    $contador_totales = 0;

    // Recorrido
    while($row = $resultado->fetch_assoc()){
        $precio = $row['precio_producto'];
        $stock = $row['stock'];
        $entrada_producto = $row['entrada_producto'];
        $salida_producto = $row['salida_producto'];
        $pdf->Cell(20,10, $row['codigo_producto'],1, 0,'C', 0);
        $pdf->Cell(30,10, $row['nombre_producto'],1, 0,'C', 0);
        $pdf->Cell(30,10, $row['nombre_categoria'],1, 0,'C', 0);
        $pdf->Cell(20,10, number_format($entrada_producto, 0),1, 0,'C', 0);
        $pdf->Cell(20,10, number_format($salida_producto, 0),1, 0,'C', 0);
        $pdf->Cell(20,10, "$ " . number_format($precio, 2) ,1, 0,'C', 0);
        $pdf->Cell(20,10, number_format($stock, 0),1, 0,'C', 0);
        // operaciones
        $total_entrada_producto = $total_entrada_producto + $entrada_producto;
        $total_salida_producto = $total_salida_producto + $salida_producto;
        $total_existencias = $total_existencias + $stock;
        $total_precio = $total_precio + $precio;
        $total = $precio*$stock;
        $contador_totales = $contador_totales + $total;
        $pdf->Cell(30,10, "$ " . number_format($total, 2),1, 1,'C', 0); 
    }

    $pdf->Cell(80,10, "TOTAL",1, 0,'C', 0);
    $pdf->Cell(20,10, number_format($total_entrada_producto, 0),1, 0,'C', 0);
    $pdf->Cell(20,10, number_format($total_salida_producto, 0),1, 0,'C', 0);
    $pdf->Cell(20,10, "$ " . number_format($total_precio, 2),1, 0,'C', 0);
    $pdf->Cell(20,10, number_format($total_existencias, 0),1, 0,'C', 0);
    $pdf->Cell(30,10, "$ ". number_format($contador_totales, 2) ,1, 1,'C', 0);
    $pdf->Output();
?>
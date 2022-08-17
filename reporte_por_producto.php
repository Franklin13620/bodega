<?php
	date_default_timezone_set('America/El_Salvador');
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
	require_once('fpdf/fpdf.php');

    if(isset($_GET['buscar_producto']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
        $desde = $_GET["desde"];
        $hasta = $_GET["hasta"];
        $nombre_producto = $_GET['nombre_producto']; 
        $buscar_producto = $_GET['buscar_producto'];     
    }else{
        header("location: error.php");
        // echo "<script languaje='javascript' type='text/javascript'>window.close();</script>";
    }

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
        $this->Cell(45,10, "Fecha",1, 0,'C', 0);
        $this->Cell(30,10, "Producto",1, 0,'C', 0);
        $this->Cell(25,10, "Tipo",1, 0,'C', 0);
        $this->Cell(25,10, "Cantidad",1, 0,'C', 0);
        $this->Cell(28,10, "Precio",1, 0,'C', 0);
        $this->Cell(35,10, "Total",1, 1,'C', 0);

    }
    function Footer()
    { 
        $desdee=$GLOBALS['desde'];
        $hastaa=$GLOBALS['hasta'];
        $this->SetY(-15);
        $this->Cell(20,18, utf8_decode("Reporte de inventario del $desdee al $hastaa"));
        $this->SetFont('Arial','I',8);
        $this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
    }
}

    $query ="SELECT * FROM historial  
    INNER JOIN products 
    ON historial.id_producto = products.id_producto WHERE nombre_producto = '$buscar_producto' AND historial.fecha BETWEEN '$desde' AND '$hasta'";
    $resultado = $con->query($query);
    // Instancia 
    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('Arial','',10);

    $total=0;
    $total_precio=0;
    $total_cantidad=0;
    $contador_totales = 0;

    // Recorrido
    while($row = $resultado->fetch_assoc()){
        $precio = $row['precio_producto'];
        $stock = $row['stock'];
        $tipo = $row['tipo'];
        $cantidad = $row['cantidad'];

        $pdf->Cell(45,10, $row['fecha'],1, 0,'C', 0);
        $pdf->Cell(30,10, $row['nombre_producto'],1, 0,'C', 0);
        $tipo == 0 ? $tipo = "CARGA" : $tipo = "Descargo";
        $pdf->Cell(25,10, $tipo, 1, 0,'C', 0);
        $pdf->Cell(25,10, number_format($cantidad,0),1, 0,'C', 0);
        $pdf->Cell(28,10, "$ " . number_format($precio, 2) ,1, 0,'C', 0);

        // operaciones
        $total_cantidad = $total_cantidad + $cantidad;
        $total_precio = $total_precio + $precio;
        $total = $precio*$cantidad;
        $contador_totales = $contador_totales + $total;
        $pdf->Cell(35,10, "$ " . number_format($total, 2),1, 1,'C', 0); 
    }

    $pdf->Cell(100,10, "TOTAL",1, 0,'C', 0);
    $pdf->Cell(25,10, number_format($total_cantidad, 0),1, 0,'C', 0);
    $pdf->Cell(28,10, "$ " . number_format($total_precio, 2),1, 0,'C', 0);
    $pdf->Cell(35,10, "$ ". number_format($contador_totales, 2) ,1, 1,'C', 0);
    $pdf->Output();
?>
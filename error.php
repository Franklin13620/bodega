<?php
session_start();
if (!isset($_SESSION['user_login_status']) && $_SESSION['user_login_status'] != 1) {
    header("location: login.php");
    exit;
    }
?>

<!DOCTYPE html>
<html>

<head>
    <link type="text/css" rel="stylesheet" href="404-templates/space/css/404.css" />
</head>

<body class="permission_denied">
    <div id="tsparticles"></div>
    <div class="denied__wrapper">
        <h1>ERROR</h1>
        <h3>No hay parametros necesarios <span>PDF</span> Intenta volver atras</h3>
        <img id="astronaut" src="404-templates/space/images/astronaut.svg" />
        <img id="planet" src="404-templates/space/images/planet.svg" />
        <a href="reporte.php"><button class="denied__link">Volver</button></a>
    </div>

    <script type="text/javascript"
        src="https://cdn.jsdelivr.net/npm/tsparticles@1.18.11/dist/tsparticles.min.js"></script>
    <script type="text/javascript" src="js/404.js"></script>

</html>
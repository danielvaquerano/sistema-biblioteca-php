<?php
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Limpiar Sesión</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <div class="header">
        <div class="container">
            <div class="nav">
                <div class="logo"> Biblioteca</div>
            </div>
        </div>
    </div>
    
    <div class="container">
        <div class="content">
            <h1> Sesión Limpiada</h1>
            <div class="alert alert-success">
                 La sesión ha sido limpiada correctamente.
            </div>
            <a href="index.php" class="btn"> Volver al Inicio</a>
        </div>
    </div>
</body>
</html>
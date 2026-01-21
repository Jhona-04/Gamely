<?php 
    // Conexión a la BDD MySQL usando PDO
    $conexion = "mysql:dbname=gamely_bdd;host=127.0.0.1;charset=utf8mb4";
    $user = "root";
    $clave = "";

    try {
        $pdo = new PDO($conexion, $user, $clave);

        
    } catch (Exception $e) {
        echo("Error con la base de datos: " . $e->getMessage());
    }
?>

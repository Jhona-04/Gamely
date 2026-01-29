<?php
    require_once "../config/database.php";

    // Crear tabla usuarios si no existe
    try {
        $sql = "
        CREATE TABLE IF NOT EXISTS usuarios (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nombre VARCHAR(100) NOT NULL,
            usuario VARCHAR(50) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL
        )
        ";

        $pdo->exec($sql);
        echo "Tabla 'usuarios' creada correctamente.";

    } catch (PDOException $e) {
        echo "Error al crear la tabla: " . $e->getMessage();
    }
?>

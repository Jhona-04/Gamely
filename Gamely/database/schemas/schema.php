<?php
    require_once "../config/database.php";

    try {
        // Crear tabla usuarios si no existe
        $sql = "
        CREATE TABLE IF NOT EXISTS usuarios (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nombre VARCHAR(100) NOT NULL,
            usuario VARCHAR(50) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            rol VARCHAR(20) DEFAULT 'cliente'
        )
        ";

        $pdo->exec($sql);
        echo "Tabla 'usuarios' creada correctamente.<br>";

        // Crear usuario admin si no existe
        $usuarioAdmin = "admin";
        $passwordAdmin = "123456";
        $passwordAdminHash = password_hash($passwordAdmin, PASSWORD_DEFAULT);
        $nombreAdmin = "Administrador";

        $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE usuario = ?");
        $stmt->execute([$usuarioAdmin]);

        if (!$stmt->fetch()) {
            $stmt = $pdo->prepare(
                "INSERT INTO usuarios (nombre, usuario, password, rol) VALUES (?, ?, ?, 'admin')"
            );
            $stmt->execute([$nombreAdmin, $usuarioAdmin, $passwordAdminHash]);
            echo "Usuario admin creado correctamente.<br>";
            echo "Usuario: admin<br>";
            echo "Contraseña: 123456<br>";
        } else {
            echo "El usuario admin ya existe.<br>";
        }

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
?>
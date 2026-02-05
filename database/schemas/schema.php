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

        // ============================================
        // TABLA JUEGOS
        // ============================================
        $sql = "
        CREATE TABLE IF NOT EXISTS juegos (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nombre VARCHAR(150) NOT NULL,
            precio DECIMAL(10, 2) NOT NULL,
            precio_original DECIMAL(10, 2) NULL,
            descuento INT NULL,
            seccion VARCHAR(30) NOT NULL COMMENT 'recomendados | mejores | tarjetas',
            imagen VARCHAR(300) NULL,
            plataformas VARCHAR(100) NULL COMMENT 'Separadas por coma: PC, PS5, XBOX, Switch'
        )
        ";
        $pdo->exec($sql);
        echo "Tabla 'juegos' creada correctamente.<br>";

        // Insertar juegos solo si la tabla está vacía
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM juegos");
        $totalJuegos = $stmt->fetch()['total'];

        if ($totalJuegos === 0) {
            $juegos = [
                // ---- RECOMENDADOS ----
                ['Baldur\'s Gate 3',                     47.99, 59.99, 20, 'recomendados', 'galeria_cliente/Baldur\'s_Gate_3.jpg',                     'PC, PS5, XBOX'],
                ['Elden Ring: Shadow of the Erdtree',    39.99, null,  null,'recomendados', 'galeria_cliente/Elden_Ring_Shadow_of_the_Erdtree.jpg',     'PC, PS5, XBOX'],
                ['Cyberpunk 2077: Ultimate Edition',     38.99, 59.99, 35, 'recomendados', 'galeria_cliente/Cyberpunk_2077_Ultimate_Edition.jpg',      'PC, PS5, XBOX'],
                ['Starfield',                            69.99, null,  null,'recomendados', 'galeria_cliente/Starfield.jpg',                            'PC, XBOX'],
                ['Hogwarts Legacy',                      44.99, 59.99, 25, 'recomendados', 'galeria_cliente/Hogwarts_Legacy.jpg',                     'PC, PS5, XBOX, Switch'],
                ['Zelda: Tears of the Kingdom',          59.99, null,  null,'recomendados', 'galeria_cliente/Zelda_Tears_of_the_Kingdom.jpg',          'Switch'],

                // ---- MEJORES JUEGOS ----
                ['Red Dead Redemption 2',               29.99, 59.99, 50, 'mejores',      'galeria_cliente/Red_Dead_Redemption_2.jpg',                'PC, PS5, XBOX'],
                ['God of War Ragnarök',                  59.99, null,  null,'mejores',      'galeria_cliente/God_of_War_Ragnarok.jpg',                  'PC, PS5'],
                ['Final Fantasy XVI',                    48.99, 69.99, 30, 'mejores',      'galeria_cliente/Final_Fantasy_XVI.png',                    'PC, PS5'],
                ['Marvel\'s Spider-Man 2',               69.99, null,  null,'mejores',      'galeria_cliente/Marvel\'s_Spider-Man_2.jpg',               'PS5'],
                ['Resident Evil 4 Remake',               35.99, 59.99, 40, 'mejores',      'galeria_cliente/Resident_Evil_4_Remake.jpg',               'PC, PS5, XBOX'],
                ['Alan Wake 2',                          49.99, null,  null,'mejores',      'galeria_cliente/Alan_Wake_2.jpg',                          'PC, PS5, XBOX'],

                // ---- TARJETAS REGALO ----
                ['Amazon (12 meses)',                   59.99, null,  null,'tarjetas',     'galeria_cliente/amazon.jpg', null],
                ['Discord (12 meses)',                  143.88,null,  null,'tarjetas',     'galeria_cliente/discord.jpg', null],
                ['Google play (12 meses)',              19.99, null,  null,'tarjetas',     'galeria_cliente/google_play.jpg', null],
                ['iTunes (12 meses)',                   29.99, null,  null,'tarjetas',     'galeria_cliente/itunes.jpg', null],
                ['Netflix (12 meses)',                  50.00, null,  null,'tarjetas',     'galeria_cliente/netflix.jpg', null],
                ['Spotify (12 meses)',                  179.88,null,  null,'tarjetas',     'galeria_cliente/spotify.jpg', null],
            ];

            $stmt = $pdo->prepare("
                INSERT INTO juegos (nombre, precio, precio_original, descuento, seccion, imagen, plataformas)
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ");

            foreach ($juegos as $juego) {
                $stmt->execute($juego);
            }

            echo "Juegos insertados correctamente.<br>";
        } else {
            echo "Los juegos ya existen en la base de datos.<br>";
        } 

        // ============================================
        // TABLA CLIENTES (Relacionada con usuarios y juegos)
        // ============================================
        $sql = "
        CREATE TABLE IF NOT EXISTS clientes (
            id INT AUTO_INCREMENT PRIMARY KEY,
            usuario_id INT NOT NULL,
            email VARCHAR(150) NOT NULL,
            telefono VARCHAR(20) NULL,
            direccion VARCHAR(255) NULL,
            ciudad VARCHAR(100) NULL,
            codigo_postal VARCHAR(10) NULL,
            pais VARCHAR(50) DEFAULT 'España',
            fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
            UNIQUE KEY (usuario_id)
        )
        ";
        $pdo->exec($sql);
        echo "Tabla 'clientes' creada correctamente.<br>";

        // ============================================
        // TABLA COMPRAS (Historial de compras de clientes)
        // ============================================
        $sql = "
        CREATE TABLE IF NOT EXISTS compras (
            id INT AUTO_INCREMENT PRIMARY KEY,
            cliente_id INT NOT NULL,
            juego_id INT NOT NULL,
            precio_pagado DECIMAL(10, 2) NOT NULL,
            fecha_compra DATETIME DEFAULT CURRENT_TIMESTAMP,
            estado VARCHAR(30) DEFAULT 'completada' COMMENT 'completada | pendiente | cancelada',
            metodo_pago VARCHAR(50) NULL COMMENT 'tarjeta | paypal | transferencia',
            FOREIGN KEY (cliente_id) REFERENCES clientes(id) ON DELETE CASCADE,
            FOREIGN KEY (juego_id) REFERENCES juegos(id) ON DELETE CASCADE
        )
        ";
        $pdo->exec($sql);
        echo "Tabla 'compras' creada correctamente.<br>";

        // ============================================
        // TABLA FAVORITOS (Juegos favoritos de clientes)
        // ============================================
        $sql = "
        CREATE TABLE IF NOT EXISTS favoritos (
            id INT AUTO_INCREMENT PRIMARY KEY,
            cliente_id INT NOT NULL,
            juego_id INT NOT NULL,
            fecha_agregado DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (cliente_id) REFERENCES clientes(id) ON DELETE CASCADE,
            FOREIGN KEY (juego_id) REFERENCES juegos(id) ON DELETE CASCADE,
            UNIQUE KEY (cliente_id, juego_id)
        )
        ";
        $pdo->exec($sql);
        echo "Tabla 'favoritos' creada correctamente.<br>";

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
?>
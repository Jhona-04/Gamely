<?php
    // Iniciar sesión si no está iniciada
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // ============================================
    // FUNCIONES DE AUTENTICACIÓN
    // ============================================

    function estaLogueado() {
        return isset($_SESSION['user_id']);
    }

    function limpiar($data) {
        return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
    }

    function redirigirRol() {
        if (!isset($_SESSION['rol'])) return;

        if ($_SESSION['rol'] === 'admin') {
            header('Location: admin/admin_dashboard.php');
            exit();
        } elseif ($_SESSION['rol'] === 'cliente') {
            header('Location: client/catalogo.php');
            exit();
        }
    }

    function esAdmin() {
        return isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin';
    }

    function requiereAdmin() {
        if (!estaLogueado()) {
            header('Location: ../index.php');
            exit();
        }
        if (!esAdmin()) {
            header('Location: ../client/catalogo.php');
            exit();
        }
    }

    // ============================================
    // FUNCIONES CRUD DE USUARIOS
    // ============================================

    // CREATE - Crear usuario
    function crearUsuario($pdo, $nombre, $usuario, $password, $rol = 'cliente') {
        try {
            // Verificar si el usuario ya existe
            $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE usuario = ?");
            $stmt->execute([$usuario]);
            
            if ($stmt->fetch()) {
                return ['success' => false, 'message' => 'El usuario ya existe'];
            }

            // Crear usuario
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, usuario, password, rol) VALUES (?, ?, ?, ?)");
            
            if ($stmt->execute([$nombre, $usuario, $password_hash, $rol])) {
                return ['success' => true, 'message' => 'Usuario creado correctamente'];
            } else {
                return ['success' => false, 'message' => 'Error al crear usuario'];
            }
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
    }

    // READ - Obtener todos los usuarios
    function obtenerUsuarios($pdo) {
        try {
            $stmt = $pdo->query("SELECT id, nombre, usuario, rol FROM usuarios ORDER BY id ASC");
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return [];
        }
    }
?>
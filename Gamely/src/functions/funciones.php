<?php
    // Iniciar sesión si no está iniciada
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    // FUNCIONES DE LOGIN
    function estaLogueado() {
        return isset($_SESSION['user_id']);
    }

    function limpiar($data) {
        return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
    }

    // Función para redirigar si es cliente o admin
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
?>
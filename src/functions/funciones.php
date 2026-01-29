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
?>
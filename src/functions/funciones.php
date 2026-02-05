<?php
    // ============================================
    // CONFIGURACIÓN DE SESIÓN - 24 HORAS
    // ============================================
    
    //Configurar tiempo de vida de la sesión a 24 horas (86400 segundos)
    ini_set('session.gc_maxlifetime', 86400);
    session_set_cookie_params(86400);
    
    function registrarLog($mensaje, $tipo = 'INFO') {
        $logFile = __DIR__ . '/../../logs/app.log';
        $timestamp = date('Y-m-d H:i:s');
        
        $logMessage = "[$timestamp] [$tipo] $mensaje" . PHP_EOL;
        
        return file_put_contents($logFile, $logMessage, FILE_APPEND);
    }

    //Iniciar sesión si no está iniciada
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    //Verificar si la sesión ha expirado (24 horas)
    if (isset($_SESSION['LAST_ACTIVITY'])) {
        $tiempoTranscurrido = time() - $_SESSION['LAST_ACTIVITY'];
        
        //Si han pasado más de 24 horas (86400 segundos)
        if ($tiempoTranscurrido > 86400) {
            //Destruir la sesión
            session_unset();
            session_destroy();
            
            //Iniciar nueva sesión
            session_start();
            
            //Redirigir al login
            header('Location: ./../index.php?session_expired=1');
            exit();
        }
    }
    
    //Actualizar el tiempo de última actividad
    $_SESSION['LAST_ACTIVITY'] = time();
    
    //Si es un login nuevo, establecer el tiempo de inicio
    if (!isset($_SESSION['SESSION_START'])) {
        $_SESSION['SESSION_START'] = time();
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
        if (!isset($_SESSION['rol'])) {
            header("Location: ./../index.php");
            exit();
        }

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
            //Verificar si el usuario ya existe
            $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE usuario = ?");
            $stmt->execute([$usuario]);
            
            if ($stmt->fetch()) {
                return ['success' => false, 'message' => 'El usuario ya existe'];
            }

            //Crear usuario
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

    // UPDATE - Editar usuario
    function editarUsuario($pdo, $id, $nombre, $usuario, $rol) {
        try {
            //Verificar si el usuario existe
            $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE id = ?");
            $stmt->execute([$id]);
            $usuarioActual = $stmt->fetch();
            
            if (!$usuarioActual) {
                return ['success' => false, 'message' => 'El usuario no existe'];
            }

            //Proteger al usuario admin por defecto: no se puede cambiar su nombre de usuario ni su rol
            if ($usuarioActual['usuario'] === 'admin') {
                if ($usuario !== 'admin' || $rol !== 'admin') {
                    return ['success' => false, 'message' => 'No se puede modificar el usuario "admin" por defecto'];
                }
            }

            //Actualizar usuario
            $stmt = $pdo->prepare("UPDATE usuarios SET nombre = ?, usuario = ?, rol = ? WHERE id = ?");
            
            if ($stmt->execute([$nombre, $usuario, $rol, $id])) {
                return ['success' => true, 'message' => 'Usuario actualizado correctamente'];
            } else {
                return ['success' => false, 'message' => 'Error al actualizar usuario'];
            }
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
    }

    // DELETE - Eliminar usuario
    function eliminarUsuario($pdo, $id) {
        try {
            //Verificar si el usuario existe
            $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE id = ?");
            $stmt->execute([$id]);
            $usuarioActual = $stmt->fetch();
            
            if (!$usuarioActual) {
                return ['success' => false, 'message' => 'El usuario no existe'];
            }

            //Proteger al usuario admin por defecto: no se puede eliminar
            if ($usuarioActual['usuario'] === 'admin') {
                return ['success' => false, 'message' => 'No se puede eliminar el usuario "admin" por defecto'];
            }

            //Eliminar usuario
            $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = ?");
            
            if ($stmt->execute([$id])) {
                return ['success' => true, 'message' => 'Usuario eliminado correctamente'];
            } else {
                return ['success' => false, 'message' => 'Error al eliminar usuario'];
            }
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
    }

    // ============================================
    // FUNCIONES DE TIEMPO DE SESIÓN
    // ============================================

    //Obtiene el tiempo restante de sesión en minutos
    
    function getTiempoRestanteSesion() {
        if (!isset($_SESSION['LAST_ACTIVITY'])) {
            return 0;
        }
        
        $tiempoTranscurrido = time() - $_SESSION['LAST_ACTIVITY'];
        $tiempoRestante = 900 - $tiempoTranscurrido; // 15 minutos en segundos
        
        return max(0, floor($tiempoRestante / 60)); // Convertir a minutos
    }

    //Obtiene el tiempo de sesión activa en horas

    function getTiempoSesionActiva() {
        if (!isset($_SESSION['SESSION_START'])) {
            return 0;
        }
        
        $tiempoActivo = time() - $_SESSION['SESSION_START'];
        return floor($tiempoActivo / 3600); // Convertir a horas
    }
?>
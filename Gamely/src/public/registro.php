<?php
    require "./../../database/config/database.php";
    require "./../functions/funciones.php";

    if (estaLogueado()) {
        redirigirRol();
    }

    $error = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre = trim($_POST['nombre']);
        $usuario = trim($_POST['usuario']);
        $password = $_POST['password'];

        if (empty($nombre) || empty($usuario) || empty($password)) {
            $error = "Todos los campos son obligatorios";
        } elseif (strlen($password) < 6) {
            $error = "La contraseña debe tener al menos 6 caracteres";
        } else {
            // Verificar si el usuario ya existe
            $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE usuario = ?");
            $stmt->execute([$usuario]);

            if ($stmt->fetch()) {
                $error = "El usuario ya existe";
            } else {
                // Crear nuevo usuario SIN rol (solo admin tiene rol)
                $password_hash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("INSERT INTO usuarios (usuario, password, nombre) VALUES (?, ?, ?)");
                
                if ($stmt->execute([$usuario, $password_hash, $nombre])) {
                    header('Location: index.php');
                    exit();
                } else {
                    $error = "Error al registrar usuario";
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Gamely</title>
    <!-- FONTS -->
        <!-- ROBOTO -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

        <!-- POPPINS -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/login/login.css">
    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
</head>
<body class="body">
    <main class="main__log">
        <section class="log__container">
            <h1 class="log__title">&#127918; Gamely</h1>
            <h2 class="log__subtitle">Crear cuenta</h2>
            
            <!-- Mensajes de error -->
            <?php if (!empty($error)): ?>
                <div class="error"><?php echo $error; ?></div>
            <?php endif; ?>   

            <!-- Formulario de registro -->
            <article class="form">
                <form method="POST">
                    <!-- Nombre -->
                    <div class="form-group">
                        <label class="form-group__label">Nombre completo:</label>
                        <input class="form-group__input" type="text" name="nombre" value="<?php echo isset($_POST['nombre']) ? $_POST['nombre'] : ''; ?>" required>
                    </div>
                    <!-- Usuario -->
                    <div class="form-group">
                        <label class="form-group__label">Usuario:</label>
                        <input class="form-group__input" type="text" name="usuario" value="<?php echo isset($_POST['usuario']) ? $_POST['usuario'] : ''; ?>" required>
                    </div>
                    <!-- Contraseña -->
                    <div class="form-group">
                        <label class="form-group__label">Contraseña</label>
                        <input class="form-group__input" type="password" name="password" required>
                    </div>
                    <!-- Botón de registro -->
                    <button class="login__in" type="submit">Registrarse</button>

                </form>
            </article>
            <!-- Iniciar sesión -->
            <article class="login__info">
                <p class="login__text">¿Ya tienes cuenta?</p>
                <button class="login__button">
                    <a class="login__link" href="index.php">Inicia sesión</a><br>
                </button>
            </article>

            <!-- Autenticación social -->
            <article class="login__social">
                <p class="login__text">O registrarte con</p>
                <div class="login__icons">
                    <i class="login__icon fa-brands fa-google"></i>
                    <i class="login__icon fa-brands fa-facebook-f"></i>
                    <i class="login__icon fa-brands fa-twitter"></i>
                </div>
            </article>
        </section>      
    </main>
</body>
</html>
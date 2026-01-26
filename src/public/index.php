<?php
    require "./../../database/config/database.php";
    require "./../functions/funciones.php";

    // Verificar si el usuario ya está logueado
    if (estaLogueado()) {
        redirigirRol();
    }

    $error = '';

    // Validaciones
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $usuario = trim($_POST['usuario']);
        $password = $_POST['password'];

        if (empty($usuario) || empty($password)) {
            $error = "Completa todos los campos";
        } else {
            $stmt = $pdo->prepare("SELECT id, usuario, password, nombre, rol FROM usuarios WHERE usuario = ?");
            $stmt->execute([$usuario]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['usuario'] = $user['usuario'];
                $_SESSION['nombre'] = $user['nombre'];
                $_SESSION['rol'] = $user['rol'];

                redirigirRol();
            } else {
                $error = "Usuario o contraseña incorrectos";
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Gamely</title>
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
<body>
    <main class="main__log">
        <section class="log__container"> 
            <h1 class="log__title">&#127918; Gamely</h1>
            <h2 class="log__subtitle">Iniciar sesión</h2>

            <!-- Mensajes de error -->
            <?php if ($error): ?>
                <article class="error"><?php echo limpiar($error); ?></article>
            <?php endif; ?>

            <!-- Formulario de inicio de sesión -->
            <article class="form">
                <form method="POST">
                    <div class="form-group">
                        <label class="form-group__label">Usuario:</label>
                        <input class="form-group__input" type="text" name="usuario" required>
                    </div>

                    <div class="form-group">
                        <label class="form-group__label">Contraseña:</label>
                        <input class="form-group__input" type="password" name="password" required>
                    </div>

                    <button class="login__in" type="submit">Ingresar</button>
                </form>
            </article>
            
            <!-- Registro -->
            <article class="login__info">
                <p class="login__text">¿No tienes cuenta?</p>
                <button class="login__button">
                    <a class="login__link" href="registro.php">Regístrate aquí</a>
                </button>
            </article>
            
            <!-- Autenticación social -->
            <article class="login__social">
                <p class="login__text">O inicia sesión con</p>
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
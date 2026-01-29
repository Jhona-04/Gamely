<?php
    session_start();

    if (!isset($_SESSION['usuario'])) {
        header("Location: ./../index.php"); // página de login
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Catalogo - Gamely</title>

        <!-- Estilos CSS -->
        <link rel="stylesheet" href="../../assets/css/style.css">
        <link rel="stylesheet" href="../../assets/css/catalogo/catalogo.css">
        <link rel="stylesheet" href="../../assets/css/header.css">
        <link rel="stylesheet" href="../../assets/css/menu.css">
        <link rel="stylesheet" href="../../assets/css/footer.css">

        <!-- *FONTS* -->
        <!-- ROBOTO -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

        <!-- POPPINS -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    
        <!-- FONT AWESOME -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">

    </head>
    <body>
        <div class="container">
            <header class="header">
                <!-- PARTE SUPERIOR -->
                <section class="header-superior">
                    <section class="header-superior__size">
                        <!-- Logo a la izquierda -->
                        <section class="header-superior__logo">
                            <h1 class="header-superior__logo-logo">&#127918; Gamely</h1>
                        </section>
                        
                        <!-- Usuario a la derecha -->
                        <section class="header-superior__user">
                            <h2 class="header-superior__welcome">
                                <i class="fa-solid fa-user"></i>
                                Bienvenido/a, <?php echo htmlspecialchars($_SESSION['nombre']); ?>!
                            </h2>
                        </section>
                    </section>
                </section>

                <!-- PARTE INFERIOR -->
                <nav class="header-inferior">
                    <!-- Espacio vacío para balancear -->
                    <div class="header-inferior__spacer"></div>
                    
                    <!-- Menú de navegación centrado -->
                    <div class="header-inferior__center">
                        <a href="#" class="header-inferior__link">Inicio</a>
                        <a href="#" class="header-inferior__link">Recomendados</a>
                        <a href="#" class="header-inferior__link">Mejores juegos</a>
                        <a href="#" class="header-inferior__link">Tarjetas Regalo</a>
                    </div>
                    
                    <!-- Acciones de usuario (derecha) -->
                    <div class="header-inferior__nav-right">
                        <a class="header-inferior__action-link" href="../carrito.php">
                            <i class="fa-solid fa-cart-shopping"></i>
                            <span>Lista Compra</span>
                        </a>
                        <a class="header-inferior__action-link" href="../logout.php">
                            <i class="fa-solid fa-arrow-right-from-bracket"></i>
                            <span>Cerrar sesión</span>
                        </a>
                    </div>
                </nav>
            </header>

            <!-- Imagen principal con animación -->
            <section class="imagen-principal">
                <img class="imagen-principal__img" src="./../../assets/images/imagen_principal.png" alt="Imagen Principal">
            </section>

            <!-- Contenido principal del catálogo -->
            <main class="main__catalogo">
                <div>
                    <section>
                        <h2 class="catalogo__title">Recomendaciones</h2>
                        <div class="catalogo__grid">
                            <!-- Aquí irían los productos recomendados -->
                            <article></article>
                        </div>
                    </section>
                </div>
            </main>
        </div>
    </body>
</html>
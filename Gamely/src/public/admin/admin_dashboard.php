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
    <title>Gamely</title>

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
                <section class="header-superior">
                    <section class="header-superior__size">
                        <section class="header-superior__logo">
                            <h1 class="header-superior__logo-logo">&#127918; Gamely</h1>
                        </section>
                        <section>
                            <h2 class="header-superior__welcome"><i class="fa-solid fa-user"></i>Bienvenido/a, <?php echo htmlspecialchars($_SESSION['nombre']); ?>!</h2>
                            <nav class="header-superior__nav">
                                <a class="header-superior__link" href="../carrito.php"><i class="fa-solid fa-cart-shopping"></i>&nbsp;Lista Compra</a>
                                <a class="header-superior__link" href="../logout.php"><i class="fa-solid fa-arrow-right-from-bracket"></i>&nbsp;</i>Cerrar sesión</a>
                            </nav>
                        </section>

                    </section>
                </section>

                <nav class="header-inferior">
                    <ul class="header-inferior__list">
                        <li class="header-inferior__item"><a href="#" class="header-inferior__link">Inicio</a></li>
                        <li class="header-inferior__item"><a href="#" class="header-inferior__link">Recomendados</a></li>
                        <li class="header-inferior__item"><a href="#" class="header-inferior__link">Mejores juegos</a></li>
                        <li class="header-inferior__item"><a href="#" class="header-inferior__link">Tarjetas Regalo</a></li>
                    </ul>
                </nav>
            </header>
            <section class="imagen-principal">
                <img class="imagen-principal__img" src="./../../assets/images/imagen_principal.png" alt="Imagen Principal">
            </section>
        </div>
</body>
</html>
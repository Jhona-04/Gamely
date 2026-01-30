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
                            <span>Carrito</span>
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

            <!-- Footer -->
            <footer class="footer">
                <section class= "footer__top">
                    <article class="about">
                        <h3 class="footer__title">Sobre <span class="footer__color">Nosotros</span></h3>
                        <p class="footer__text">Desbloquea equipo exclusivo, aspectos raros y mejoras poderosas. Mejora tu experiencia de juego con artículos premium disponibles directamente en la tienda del juego.</p>
                        
                        <nav class="footer__nav">
                            <ul class="footer__list">
                                <li class="footer__item"><a href="#" class="footer__link">Inicio</a></li>
                                <li class="footer__item"><a href="#" class="footer__link">Recomendados</a></li>
                                <li class="footer__item"><a href="#" class="footer__link">Mejores juegos</a></li>
                                <li class="footer__item"><a href="#" class="footer__link">Tarjetas Regalo</a></li>
                            </ul>

                            <ul class="footer__list">
                                <li class="footer__item"><a href="#" class="footer__link">Soporte</a></li>
                                <li class="footer__item"><a href="#" class="footer__link">Términos de Servicio</a></li>
                                <li class="footer__item"><a href="#" class="footer__link">Política de Privacidad</a></li>
                                <li class="footer__item"><a href="#" class="footer__link">Contacto</a></li>
                            </ul>
                        </nav>
                    </article>

                    <!-- LASTEST -->
                    <article class="latest">
                        <h3 class="footer__title">Últimas <span class="footer__color">Noticias</span></h3>
                        <div class="footer__cards">
                            <!-- CARD1 -->
                            <div class="footer__card">
                                <img src="./../../assets/images/footer_images/gallery-3-90x65.jpg" alt="foto1" class="footer__card-img">
                                <div class="footer__card-content">
                                    <h4 class="footer__card-title">Lanzamiento de nuevo juego</h4>
                                    <div class="footer__card-divider">
                                        <i class="footer__card-text fa-regular fa-clock"></i>
                                        <p class="footer__card-text">Enero 2, 2024</p>
                                    </div>                               
                                </div>
                            </div>
                            <!-- CARD2 -->
                            <div class="footer__card">
                                <img src="./../../assets/images/footer_images/post-1-90x65.jpg" alt="foto2" class="footer__card-img">
                                <div class="footer__card-content">
                                    <h4 class="footer__card-title">¡Se ha lanzado un nuevo tráiler!</h4>
                                    <div class="footer__card-divider">
                                        <i class="footer__card-text fa-regular fa-clock"></i>
                                        <p class="footer__card-text">Enero 12, 2024</p>
                                    </div> 
                                </div>
                            </div>
                            <!-- CARD3 -->
                            <div class="footer__card">
                                <img src="./../../assets/images/footer_images/video-post-90x65.jpg" alt="foto3" class="footer__card-img">
                                <div class="footer__card-content">
                                    <h4 class="footer__card-title">Lista de precios de los juegos</h4>
                                    <div class="footer__card-divider">
                                        <i class="footer__card-text fa-regular fa-clock"></i>
                                        <p class="footer__card-text">Enero 25, 2024</p>
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </article>
                    <!-- APP & PLATAFORMAS -->
                    <article class="apps-platforms">
                        <h3 class="footer__title">APP <span class="footer__color">& PLATAFORMAS</span></h3>
                        <div class="app__container">
                            <!-- app1 -->
                            <div class="app__card">
                                <i class="app__icon fa-brands fa-apple"></i>
                                <p class="app__text">Comprar ahora a través de Google Play</p>
                            </div>
                            <!-- app2 -->
                            <div class="app__card">
                                <i class="app__icon fa-brands fa-google-play"></i>
                                <p class="app__text">Comprar ahora a través de App Store</p>
                            </div>
                            <!-- app3 -->
                            <div class="app__card">
                                <i class="app__icon fa-brands fa-steam"></i>
                                <p class="app__text">Comprar ahora a través de Steam</p>
                            </div>
                            <!-- app4 -->
                            <div class="app__card">
                                <i class="app__icon fa-brands fa-amazon"></i>
                                <p class="app__text">Comprar ahora a través de Amazon</p>
                            </div>
                            <!-- app5 -->
                            <div class="app__card">
                                <i class="app__icon fa-brands fa-windows"></i>
                                <p class="app__text">Comprar ahora a través de Microsoft</p>
                            </div>
                            <!-- app6 -->
                            <div class="app__card">
                                <i class="app__icon fa-brands fa-paypal"></i>
                                <p class="app__text">Comprar ahora a través de PayPal</p>
                            </div>
                        </div>
                    </article>
                </section>
                <section class="footer__bottom">
                    <p class="footer__text">&copy; 2026 Gamely. Todos los derechos reservados.</p>
                </section>
            </footer>
        </div>
    </body>
</html>
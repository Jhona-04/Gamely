<?php
    require "./../../../database/config/database.php";
    require "./../../functions/funciones.php";

    if (!isset($_SESSION['usuario'])) {
        header("Location: ./../index.php");
        exit();
    }

    // Obtener juegos desde la base de datos
    $juegosRecomendados = $pdo->query("SELECT * FROM juegos WHERE seccion = 'recomendados'")->fetchAll();
    $juegosMejores = $pdo->query("SELECT * FROM juegos WHERE seccion = 'mejores'")->fetchAll();
    $tarjetasRegalo = $pdo->query("SELECT * FROM juegos WHERE seccion = 'tarjetas'")->fetchAll();

    // Calcular cantidad de items en el carrito
    $cantidadCarrito = 0;
    if (isset($_SESSION['carrito'])) {
        foreach ($_SESSION['carrito'] as $item) {
            $cantidadCarrito += $item['cantidad'];
        }
    }
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Catalogo - Gamely</title>

        <!-- Estilos CSS -->
        <link rel="stylesheet" href="../../assets/css/style.css">
        <link rel="stylesheet" href="../../assets/css/catalogo/catalogo.css">
        <link rel="stylesheet" href="../../assets/css/carrito/carrito.css">
        <link rel="stylesheet" href="../../assets/css/header.css">
        <link rel="stylesheet" href="../../assets/css/footer.css">

        <!-- FONTS -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
    
        <!-- FONT AWESOME -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    </head>
    <body>
        <article class="container">
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
                            <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin'): ?>
                                <a href="./../admin/admin_dashboard.php" class="header-superior__welcome">
                                    <i class="fa-solid fa-user"></i>
                                    Bienvenido/a, <?php echo htmlspecialchars($_SESSION['nombre']); ?>!
                                </a>
                            <?php else: ?>
                                <span class="header-superior__welcome">
                                    <i class="fa-solid fa-user"></i>
                                    Bienvenido/a, <?php echo htmlspecialchars($_SESSION['nombre']); ?>!
                                </span>
                            <?php endif; ?>
                        </section>
                    </section>
                </section>

                <!-- PARTE INFERIOR -->
                <nav class="header-inferior">
                    <section class="header-inferior__spacer"></section>
                    
                    <nav class="header-inferior__center">
                        <a href="./catalogo.php" class="header-inferior__link">Inicio</a>
                        <a href="#recomendados" class="header-inferior__link">Recomendados</a>
                        <a href="#mejores" class="header-inferior__link">Mejores juegos</a>
                        <a href="#tarjetas" class="header-inferior__link">Tarjetas Regalo</a>
                    </nav>
                    
                    <nav class="header-inferior__nav-right">
                        <a class="header-inferior__action-link" href="../carrito.php">
                            <i class="fa-solid fa-cart-shopping"></i>
                            <span>Carrito</span>
                            <?php if ($cantidadCarrito > 0): ?>
                                <span class="carrito-contador"><?php echo $cantidadCarrito; ?></span>
                            <?php endif; ?>
                        </a>
                        <a class="header-inferior__action-link" href="../logout.php">
                            <i class="fa-solid fa-arrow-right-from-bracket"></i>
                            <span>Cerrar sesión</span>
                        </a>
                    </nav>
                </nav>
            </header>

            <!-- Imagen principal con animación -->
            <section class="imagen-principal">
                <img class="imagen-principal__img" src="./../../assets/images/imagen_principal.png" alt="Imagen Principal">
            </section>

            <!-- Contenido principal del catálogo -->
            <main class="main__catalogo">
                <!-- JUEGOS RECOMENDADOS -->
                <section id="recomendados" class="section">
                    <header class="section__header">
                        <h2 class="section__title">Juegos Recomendados 2025</h2>
                        <nav class="carousel__controls">
                            <button class="carousel__button">‹</button>
                            <button class="carousel__button">›</button>
                        </nav>
                    </header>
                    <article class="carousel-container">
                        <section class="carousel" id="recommended-carousel">
                            <?php foreach ($juegosRecomendados as $juego): ?>
                                <article class="game-card">
                                    <?php if ($juego['imagen']): ?>
                                        <img src="./../../assets/images/<?php echo htmlspecialchars($juego['imagen']); ?>" alt="<?php echo htmlspecialchars($juego['nombre']); ?>" class="game-card__image">
                                    <?php endif; ?>
                                    <section class="game-card__info">
                                        <h3 class="game-card__name"><?php echo htmlspecialchars($juego['nombre']); ?></h3>
                                        <?php if ($juego['plataformas']): ?>
                                            <section class="game-card__platforms">
                                                <?php 
                                                $plataformas = explode(', ', $juego['plataformas']);
                                                foreach ($plataformas as $plataforma): 
                                                ?>
                                                    <span class="game-card__platform-badge"><?php echo htmlspecialchars($plataforma); ?></span>
                                                <?php endforeach; ?>
                                            </section>
                                        <?php endif; ?>
                                        <section class="game-card__price">
                                            <?php if ($juego['descuento']): ?>
                                                <span class="game-card__discount-badge">-<?php echo $juego['descuento']; ?>%</span>
                                            <?php endif; ?>
                                            <span>€<?php echo number_format($juego['precio'], 2); ?></span>
                                            <?php if ($juego['precio_original']): ?>
                                                <span class="game-card__original-price">€<?php echo number_format($juego['precio_original'], 2); ?></span>
                                            <?php endif; ?>
                                        </section>
                                    </section>
                                    <a href="../carrito.php?agregar=<?php echo $juego['id']; ?>" class="game-card__button">
                                        <i class="fa-solid fa-cart-plus"></i> Añadir al carrito
                                    </a>
                                </article>
                            <?php endforeach; ?>
                        </section>
                    </article>
                </section>

                <!-- MEJORES JUEGOS -->
                <section id="mejores" class="section">
                    <header class="section__header">
                        <h2 class="section__title">Mejores Juegos</h2>
                        <nav class="carousel__controls">
                            <button class="carousel__button">‹</button>
                            <button class="carousel__button">›</button>
                        </nav>
                    </header>
                    <article class="carousel-container">
                        <section class="carousel" id="best-carousel">
                            <?php foreach ($juegosMejores as $juego): ?>
                                <article class="game-card">
                                    <?php if ($juego['imagen']): ?>
                                        <img src="./../../assets/images/<?php echo htmlspecialchars($juego['imagen']); ?>" alt="<?php echo htmlspecialchars($juego['nombre']); ?>" class="game-card__image">
                                    <?php endif; ?>
                                    <section class="game-card__info">
                                        <h3 class="game-card__name"><?php echo htmlspecialchars($juego['nombre']); ?></h3>
                                        <?php if ($juego['plataformas']): ?>
                                            <section class="game-card__platforms">
                                                <?php 
                                                $plataformas = explode(', ', $juego['plataformas']);
                                                foreach ($plataformas as $plataforma): 
                                                ?>
                                                    <span class="game-card__platform-badge"><?php echo htmlspecialchars($plataforma); ?></span>
                                                <?php endforeach; ?>
                                            </section>
                                        <?php endif; ?>
                                        <section class="game-card__price">
                                            <?php if ($juego['descuento']): ?>
                                                <span class="game-card__discount-badge">-<?php echo $juego['descuento']; ?>%</span>
                                            <?php endif; ?>
                                            <span>€<?php echo number_format($juego['precio'], 2); ?></span>
                                            <?php if ($juego['precio_original']): ?>
                                                <span class="game-card__original-price">€<?php echo number_format($juego['precio_original'], 2); ?></span>
                                            <?php endif; ?>
                                        </section>
                                    </section>
                                    <a href="../carrito.php?agregar=<?php echo $juego['id']; ?>" class="game-card__button">
                                        <i class="fa-solid fa-cart-plus"></i> Añadir al carrito
                                    </a>
                                </article>
                            <?php endforeach; ?>
                        </section>
                    </article>
                </section>

                <!-- TARJETAS REGALO -->
                <section id="tarjetas" class="section">
                    <header class="section__header">
                        <h2 class="section__title">Tarjetas Regalo</h2>
                        <nav class="carousel__controls">
                            <button class="carousel__button">‹</button>
                            <button class="carousel__button">›</button>
                        </nav>
                    </header>
                    <article class="carousel-container">
                        <section class="carousel" id="gift-carousel">
                            <?php foreach ($tarjetasRegalo as $tarjeta): ?>
                                <article class="game-card game-card--gift">
                                    <?php if ($tarjeta['imagen']): ?>
                                        <img src="./../../assets/images/<?php echo htmlspecialchars($tarjeta['imagen']); ?>" alt="<?php echo htmlspecialchars($tarjeta['nombre']); ?>" class="game-card__image">
                                    <?php endif; ?>
                                    <section class="game-card__info">
                                        <h3 class="game-card__name"><?php echo htmlspecialchars($tarjeta['nombre']); ?></h3>
                                        <section class="game-card__price">
                                            <span>€<?php echo number_format($tarjeta['precio'], 2); ?></span>
                                        </section>
                                    </section>
                                    <a href="../carrito.php?agregar=<?php echo $tarjeta['id']; ?>" class="game-card__button">
                                        <i class="fa-solid fa-cart-plus"></i> Añadir al carrito
                                    </a>
                                </article>
                            <?php endforeach; ?>
                        </section>
                    </article>
                </section>
            </main>
        </article>

        <!-- FOOTER -->
        <footer class="footer">
            <section class="footer__top">
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

                <article class="latest">
                    <h3 class="footer__title">Últimas <span class="footer__color">Noticias</span></h3>
                    <section class="footer__cards">
                        <article class="footer__card">
                            <img src="./../../assets/images/footer_images/gallery-3-90x65.jpg" alt="foto1" class="footer__card-img">
                            <section class="footer__card-content">
                                <h4 class="footer__card-title">Lanzamiento de nuevo juego</h4>
                                <section class="footer__card-divider">
                                    <i class="footer__card-text fa-regular fa-clock"></i>
                                    <p class="footer__card-text">Enero 2, 2024</p>
                                </section>                               
                            </section>
                        </article>
                        <article class="footer__card">
                            <img src="./../../assets/images/footer_images/post-1-90x65.jpg" alt="foto2" class="footer__card-img">
                            <section class="footer__card-content">
                                <h4 class="footer__card-title">¡Se ha lanzado un nuevo tráiler!</h4>
                                <section class="footer__card-divider">
                                    <i class="footer__card-text fa-regular fa-clock"></i>
                                    <p class="footer__card-text">Enero 12, 2024</p>
                                </section> 
                            </section>
                        </article>
                        <article class="footer__card">
                            <img src="./../../assets/images/footer_images/video-post-90x65.jpg" alt="foto3" class="footer__card-img">
                            <section class="footer__card-content">
                                <h4 class="footer__card-title">Lista de precios de los juegos</h4>
                                <section class="footer__card-divider">
                                    <i class="footer__card-text fa-regular fa-clock"></i>
                                    <p class="footer__card-text">Enero 25, 2024</p>
                                </section> 
                            </section>
                        </article>
                    </section>
                </article>

                <article class="apps-platforms">
                    <h3 class="footer__title">APP <span class="footer__color">& PLATAFORMAS</span></h3>
                    <section class="app__container">
                        <article class="app__card">
                            <i class="app__icon fa-brands fa-apple"></i>
                            <p class="app__text">Comprar ahora a través de App Store</p>
                        </article>
                        <article class="app__card">
                            <i class="app__icon fa-brands fa-google-play"></i>
                            <p class="app__text">Comprar ahora a través de Google Play</p>
                        </article>
                        <article class="app__card">
                            <i class="app__icon fa-brands fa-steam"></i>
                            <p class="app__text">Comprar ahora a través de Steam</p>
                        </article>
                        <article class="app__card">
                            <i class="app__icon fa-brands fa-amazon"></i>
                            <p class="app__text">Comprar ahora a través de Amazon</p>
                        </article>
                        <article class="app__card">
                            <i class="app__icon fa-brands fa-windows"></i>
                            <p class="app__text">Comprar ahora a través de Microsoft</p>
                        </article>
                        <article class="app__card">
                            <i class="app__icon fa-brands fa-paypal"></i>
                            <p class="app__text">Comprar ahora a través de PayPal</p>
                        </article>
                    </section>
                </article>
            </section>
            <footer class="footer__bottom">
                <p class="footer__text">&copy; 2026 Gamely. Todos los derechos reservados.</p>
            </footer>
        </footer>
        <?php require_once '../../components/cookie_banner.php'; ?>
    </body>
</html>
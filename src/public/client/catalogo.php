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
                        <a href="./catalogo.php" class="header-inferior__link">Inicio</a>
                        <a href="#recomendados" class="header-inferior__link">Recomendados</a>
                        <a href="#mejores" class="header-inferior__link">Mejores juegos</a>
                        <a href="#tarjetas" class="header-inferior__link">Tarjetas Regalo</a>
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
                <section id="recomendados" class="section">
                    <div class="section__header">
                        <h2 class="section__title">Juegos Recomendados 2025</h2>
                        <div class="carousel__controls">
                            <button class="carousel__button">‹</button>
                            <button class="carousel__button">›</button>
                        </div>
                    </div>
                    <div class="carousel-container">
                        <div class="carousel" id="recommended-carousel">
                            <!-- Baldur's Gate 3 -->
                            <div class="game-card">
                                <img src="./../../assets/images/galeria_cliente/Baldur's_Gate_3.jpg" alt="Baldur's Gate 3" class="game-card__image">
                                <div class="game-card__info">
                                    <h3 class="game-card__name">Baldur's Gate 3</h3>
                                    <div class="game-card__platforms">
                                        <span class="game-card__platform-badge">PC</span>
                                        <span class="game-card__platform-badge">PS5</span>
                                        <span class="game-card__platform-badge">XBOX</span>
                                    </div>
                                    <div class="game-card__price">
                                        <span class="game-card__discount-badge">-20%</span>
                                        <span>€47.99</span>
                                        <span class="game-card__original-price">€59.99</span>
                                    </div>
                                    <button class="game-card__button">Añadir al carrito</button>
                                </div>
                            </div>

                            <!-- Elden Ring: Shadow of the Erdtree -->
                            <div class="game-card">
                                <img src="./../../assets/images/galeria_cliente/Elden_Ring_Shadow_of_the_Erdtree.jpg" alt="Elden Ring DLC" class="game-card__image">
                                <div class="game-card__info">
                                    <h3 class="game-card__name">Elden Ring: Shadow of the Erdtree</h3>
                                    <div class="game-card__platforms">
                                        <span class="game-card__platform-badge">PC</span>
                                        <span class="game-card__platform-badge">PS5</span>
                                        <span class="game-card__platform-badge">XBOX</span>
                                    </div>
                                    <div class="game-card__price">
                                        <span>€39.99</span>
                                    </div>
                                    <button class="game-card__button">Añadir al carrito</button>
                                </div>
                            </div>

                            <!-- Cyberpunk 2077: Phantom Liberty -->
                            <div class="game-card">
                                <img src="./../../assets/images/galeria_cliente/Cyberpunk_2077_Ultimate_Edition.jpg" alt="Cyberpunk 2077" class="game-card__image">
                                <div class="game-card__info">
                                    <h3 class="game-card__name">Cyberpunk 2077: Ultimate Edition</h3>
                                    <div class="game-card__platforms">
                                        <span class="game-card__platform-badge">PC</span>
                                        <span class="game-card__platform-badge">PS5</span>
                                        <span class="game-card__platform-badge">XBOX</span>
                                    </div>
                                    <div class="game-card__price">
                                        <span class="game-card__discount-badge">-35%</span>
                                        <span>€38.99</span>
                                        <span class="game-card__original-price">€59.99</span>
                                    </div>
                                    <button class="game-card__button">Añadir al carrito</button>
                                </div>
                            </div>

                            <!-- Starfield -->
                            <div class="game-card">
                                <img src="./../../assets/images/galeria_cliente/Starfield.jpg" alt="Starfield" class="game-card__image">
                                <div class="game-card__info">
                                    <h3 class="game-card__name">Starfield</h3>
                                    <div class="game-card__platforms">
                                        <span class="game-card__platform-badge">PC</span>
                                        <span class="game-card__platform-badge">XBOX</span>
                                    </div>
                                    <div class="game-card__price">
                                        <span>€69.99</span>
                                    </div>
                                    <button class="game-card__button">Añadir al carrito</button>
                                </div>
                            </div>

                            <!-- Hogwarts Legacy -->
                            <div class="game-card">
                                <img src="./../../assets/images/galeria_cliente/Hogwarts_Legacy.jpg" alt="Hogwarts Legacy" class="game-card__image">
                                <div class="game-card__info">
                                    <h3 class="game-card__name">Hogwarts Legacy</h3>
                                    <div class="game-card__platforms">
                                        <span class="game-card__platform-badge">PC</span>
                                        <span class="game-card__platform-badge">PS5</span>
                                        <span class="game-card__platform-badge">XBOX</span>
                                        <span class="game-card__platform-badge">Switch</span>
                                    </div>
                                    <div class="game-card__price">
                                        <span class="game-card__discount-badge">-25%</span>
                                        <span>€44.99</span>
                                        <span class="game-card__original-price">€59.99</span>
                                    </div>
                                    <button class="game-card__button">Añadir al carrito</button>
                                </div>
                            </div>

                            <!-- The Legend of Zelda: Tears of the Kingdom -->
                            <div class="game-card">
                                <img src="./../../assets/images/galeria_cliente/Zelda_Tears_of_the_Kingdom.jpg" alt="Zelda TOTK" class="game-card__image">
                                <div class="game-card__info">
                                    <h3 class="game-card__name">Zelda: Tears of the Kingdom</h3>
                                    <div class="game-card__platforms">
                                        <span class="game-card__platform-badge">Switch</span>
                                    </div>
                                    <div class="game-card__price">
                                        <span>€59.99</span>
                                    </div>
                                    <button class="game-card__button">Añadir al carrito</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Mejores Juegos -->
                <section id="mejores" class="section">
                    <div class="section__header">
                        <h2 class="section__title">Mejores Juegos</h2>
                        <div class="carousel__controls">
                            <button class="carousel__button" onclick="scrollCarousel('best', -1)">‹</button>
                            <button class="carousel__button" onclick="scrollCarousel('best', 1)">›</button>
                        </div>
                    </div>
                    <div class="carousel-container">
                        <div class="carousel" id="best-carousel">
                            <!-- Red Dead Redemption 2 -->
                            <div class="game-card">
                                <img src="./../../assets/images/galeria_cliente/Red_Dead_Redemption_2.jpg" alt="Red Dead Redemption 2" class="game-card__image">
                                <div class="game-card__info">
                                    <h3 class="game-card__name">Red Dead Redemption 2</h3>
                                    <div class="game-card__platforms">
                                        <span class="game-card__platform-badge">PC</span>
                                        <span class="game-card__platform-badge">PS5</span>
                                        <span class="game-card__platform-badge">XBOX</span>
                                    </div>
                                    <div class="game-card__price">
                                        <span class="game-card__discount-badge">-50%</span>
                                        <span>€29.99</span>
                                        <span class="game-card__original-price">€59.99</span>
                                    </div>
                                    <button class="game-card__button">Añadir al carrito</button>
                                </div>
                            </div>

                            <!-- God of War Ragnarök -->
                            <div class="game-card">
                                <img src="./../../assets/images/galeria_cliente/God_of_War_Ragnarok.jpg" alt="God of War" class="game-card__image">
                                <div class="game-card__info">
                                    <h3 class="game-card__name">God of War Ragnarök</h3>
                                    <div class="game-card__platforms">
                                        <span class="game-card__platform-badge">PC</span>
                                        <span class="game-card__platform-badge">PS5</span>
                                    </div>
                                    <div class="game-card__price">
                                        <span>€59.99</span>
                                    </div>
                                    <button class="game-card__button">Añadir al carrito</button>
                                </div>
                            </div>

                            <!-- Final Fantasy XVI -->
                            <div class="game-card">
                                <img src="./../../assets/images/galeria_cliente/Final_Fantasy_XVI.png" alt="Final Fantasy XVI" class="game-card__image">
                                <div class="game-card__info">
                                    <h3 class="game-card__name">Final Fantasy XVI</h3>
                                    <div class="game-card__platforms">
                                        <span class="game-card__platform-badge">PC</span>
                                        <span class="game-card__platform-badge">PS5</span>
                                    </div>
                                    <div class="game-card__price">
                                        <span class="game-card__discount-badge">-30%</span>
                                        <span>€48.99</span>
                                        <span class="game-card__original-price">€69.99</span>
                                    </div>
                                    <button class="game-card__button">Añadir al carrito</button>
                                </div>
                            </div>

                            <!-- Spider-Man 2 -->
                            <div class="game-card">
                                <img src="./../../assets/images/galeria_cliente/Marvel's_Spider-Man_2.jpg" alt="Spider-Man 2" class="game-card__image">
                                <div class="game-card__info">
                                    <h3 class="game-card__name">Marvel's Spider-Man 2</h3>
                                    <div class="game-card__platforms">
                                        <span class="game-card__platform-badge">PS5</span>
                                    </div>
                                    <div class="game-card__price">
                                        <span>€69.99</span>
                                    </div>
                                    <button class="game-card__button">Añadir al carrito</button>
                                </div>
                            </div>

                            <!-- Resident Evil 4 Remake -->
                            <div class="game-card">
                                <img src="./../../assets/images/galeria_cliente/Resident_Evil_4_Remake.jpg" alt="Resident Evil 4" class="game-card__image">
                                <div class="game-card__info">
                                    <h3 class="game-card__name">Resident Evil 4 Remake</h3>
                                    <div class="game-card__platforms">
                                        <span class="game-card__platform-badge">PC</span>
                                        <span class="game-card__platform-badge">PS5</span>
                                        <span class="game-card__platform-badge">XBOX</span>
                                    </div>
                                    <div class="game-card__price">
                                        <span class="game-card__discount-badge">-40%</span>
                                        <span>€35.99</span>
                                        <span class="game-card__original-price">€59.99</span>
                                    </div>
                                    <button class="game-card__button">Añadir al carrito</button>
                                </div>
                            </div>

                            <!-- Alan Wake 2 -->
                            <div class="game-card">
                                <img src="./../../assets/images/galeria_cliente/Alan_Wake_2.jpg" alt="Alan Wake 2" class="game-card__image">
                                <div class="game-card__info">
                                    <h3 class="game-card__name">Alan Wake 2</h3>
                                    <div class="game-card__platforms">
                                        <span class="game-card__platform-badge">PC</span>
                                        <span class="game-card__platform-badge">PS5</span>
                                        <span class="game-card__platform-badge">XBOX</span>
                                    </div>
                                    <div class="game-card__price">
                                        <span>€49.99</span>
                                    </div>
                                    <button class="game-card__button">Añadir al carrito</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Tarjetas Regalo -->
                <section id="tarjetas" class="section">
                    <div class="section__header">
                        <h2 class="section__title">Tarjetas Regalo</h2>
                        <div class="carousel__controls">
                            <button class="carousel__button" onclick="scrollCarousel('gift', -1)">‹</button>
                            <button class="carousel__button" onclick="scrollCarousel('gift', 1)">›</button>
                        </div>
                    </div>
                    <div class="carousel-container">
                        <div class="carousel" id="gift-carousel">
                            <!-- PlayStation Plus -->
                            <div class="game-card game-card--gift">
                                <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 200 150'%3E%3Crect fill='%230070cc' width='200' height='150'/%3E%3Ctext x='50%25' y='50%25' text-anchor='middle' dy='.3em' fill='white' font-size='24' font-weight='bold'%3EPS Plus%3C/text%3E%3C/svg%3E" alt="PlayStation Plus" class="game-card__image">
                                <div class="game-card__info">
                                    <h3 class="game-card__name">PlayStation Plus (12 meses)</h3>
                                    <div class="game-card__price">
                                        <span>€59.99</span>
                                    </div>
                                    <button class="game-card__button">Añadir al carrito</button>
                                </div>
                            </div>

                            <!-- Xbox Game Pass Ultimate -->
                            <div class="game-card game-card--gift">
                                <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 200 150'%3E%3Crect fill='%23107c10' width='200' height='150'/%3E%3Ctext x='50%25' y='50%25' text-anchor='middle' dy='.3em' fill='white' font-size='20' font-weight='bold'%3EGame Pass%3C/text%3E%3C/svg%3E" alt="Xbox Game Pass" class="game-card__image">
                                <div class="game-card__info">
                                    <h3 class="game-card__name">Xbox Game Pass Ultimate (12 meses)</h3>
                                    <div class="game-card__price">
                                        <span>€143.88</span>
                                    </div>
                                    <button class="game-card__button">Añadir al carrito</button>
                                </div>
                            </div>

                            <!-- Nintendo Switch Online -->
                            <div class="game-card game-card--gift">
                                <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 200 150'%3E%3Crect fill='%23e60012' width='200' height='150'/%3E%3Ctext x='50%25' y='50%25' text-anchor='middle' dy='.3em' fill='white' font-size='18' font-weight='bold'%3ENintendo Online%3C/text%3E%3C/svg%3E" alt="Nintendo Switch Online" class="game-card__image">
                                <div class="game-card__info">
                                    <h3 class="game-card__name">Nintendo Switch Online (12 meses)</h3>
                                    <div class="game-card__price">
                                        <span>€19.99</span>
                                    </div>
                                    <button class="game-card__button">Añadir al carrito</button>
                                </div>
                            </div>

                            <!-- EA Play -->
                            <div class="game-card game-card--gift">
                                <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 200 150'%3E%3Crect fill='%23ff6c00' width='200' height='150'/%3E%3Ctext x='50%25' y='50%25' text-anchor='middle' dy='.3em' fill='white' font-size='24' font-weight='bold'%3EEA Play%3C/text%3E%3C/svg%3E" alt="EA Play" class="game-card__image">
                                <div class="game-card__info">
                                    <h3 class="game-card__name">EA Play (12 meses)</h3>
                                    <div class="game-card__price">
                                        <span>€29.99</span>
                                    </div>
                                    <button class="game-card__button">Añadir al carrito</button>
                                </div>
                            </div>

                            <!-- Steam Wallet -->
                            <div class="game-card game-card--gift">
                                <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 200 150'%3E%3Crect fill='%23171a21' width='200' height='150'/%3E%3Ctext x='50%25' y='50%25' text-anchor='middle' dy='.3em' fill='white' font-size='22' font-weight='bold'%3ESteam Card%3C/text%3E%3C/svg%3E" alt="Steam Wallet" class="game-card__image">
                                <div class="game-card__info">
                                    <h3 class="game-card__name">Tarjeta Steam €50</h3>
                                    <div class="game-card__price">
                                        <span>€50.00</span>
                                    </div>
                                    <button class="game-card__button">Añadir al carrito</button>
                                </div>
                            </div>

                            <!-- Ubisoft+ -->
                            <div class="game-card game-card--gift">
                                <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 200 150'%3E%3Crect fill='%232a5bd7' width='200' height='150'/%3E%3Ctext x='50%25' y='50%25' text-anchor='middle' dy='.3em' fill='white' font-size='24' font-weight='bold'%3EUbisoft%2B%3C/text%3E%3C/svg%3E" alt="Ubisoft+" class="game-card__image">
                                <div class="game-card__info">
                                    <h3 class="game-card__name">Ubisoft+ (12 meses)</h3>
                                    <div class="game-card__price">
                                        <span>€179.88</span>
                                    </div>
                                    <button class="game-card__button">Añadir al carrito</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </main>
        </div>
        <!-- Script JS -->
        <script src="../../assets/scripts/script.js"></script>
    </body>
</html>
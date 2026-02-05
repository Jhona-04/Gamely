<?php
    require "./../../database/config/database.php";
    require "./../functions/funciones.php";

    //Verificar que el usuario esté logueado
    if (!isset($_SESSION['usuario'])) {
        header("Location: ./../index.php");
        exit();
    }

    //Inicializar carrito si no existe
    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }

    $mensaje = '';
    $error = '';

    //AÑADIR AL CARRITO
    if (isset($_GET['agregar'])) {
        $idJuego = (int)$_GET['agregar'];
        
        //Obtener datos del juego
        $stmt = $pdo->prepare("SELECT id, nombre, precio FROM juegos WHERE id = ?");
        $stmt->execute([$idJuego]);
        $juego = $stmt->fetch();
        
        if ($juego) {
            //Verificar si ya existe en el carrito
            $existe = false;
            foreach ($_SESSION['carrito'] as &$item) {
                if ($item['id'] == $juego['id']) {
                    $item['cantidad']++;
                    $existe = true;
                    break;
                }
            }
            
            //Si no existe, agregarlo
            if (!$existe) {
                $_SESSION['carrito'][] = [
                    'id' => $juego['id'],
                    'nombre' => $juego['nombre'],
                    'precio' => $juego['precio'],
                    'cantidad' => 1
                ];
            }
            
            $mensaje = "Juego añadido al carrito correctamente";
        } else {
            $error = "El juego no existe";
        }
    }

    //ELIMINAR DEL CARRITO
    if (isset($_GET['eliminar'])) {
        $idEliminar = (int)$_GET['eliminar'];
        
        foreach ($_SESSION['carrito'] as $key => $item) {
            if ($item['id'] == $idEliminar) {
                unset($_SESSION['carrito'][$key]);
                $_SESSION['carrito'] = array_values($_SESSION['carrito']); // Reindexar
                $mensaje = "Juego eliminado del carrito";
                break;
            }
        }
    }

    //PROCESAR COMPRA
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comprar'])) {
        $nombre_cliente = trim($_POST['nombre_cliente']);
        $correo = trim($_POST['correo']);
        
        if (empty($nombre_cliente) || empty($correo)) {
            $error = "Debes completar todos los campos";
        } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            $error = "El correo electrónico no es válido";
        } elseif (empty($_SESSION['carrito'])) {
            $error = "El carrito está vacío";
        } else {
            
            //Calcular total
            $total = 0;
            foreach ($_SESSION['carrito'] as $item) {
                $total += $item['precio'] * $item['cantidad'];
            }
            
            //Preparar contenido del email para mailto
            $asunto = "Pedido Gamely - " . date('d/m/Y H:i');
            
            $cuerpoEmail = "Hola Gamely,%0D%0A%0D%0A";
            $cuerpoEmail .= "Mi nombre es " . urlencode($nombre_cliente) . " y quiero realizar el siguiente pedido:%0D%0A%0D%0A";
            $cuerpoEmail .= "=== RESUMEN DEL PEDIDO ===%0D%0A%0D%0A";
            
            foreach ($_SESSION['carrito'] as $item) {
                $subtotal = $item['precio'] * $item['cantidad'];
                $cuerpoEmail .= "- " . urlencode($item['nombre']) . "%0D%0A";
                $cuerpoEmail .= "  Precio: €" . number_format($item['precio'], 2) . " x " . $item['cantidad'] . " = €" . number_format($subtotal, 2) . "%0D%0A%0D%0A";
            }
            
            $cuerpoEmail .= "========================%0D%0A";
            $cuerpoEmail .= "TOTAL: €" . number_format($total, 2) . "%0D%0A";
            $cuerpoEmail .= "========================%0D%0A%0D%0A";
            $cuerpoEmail .= "Por favor, confirmen la disponibilidad y los métodos de pago.%0D%0A%0D%0A";
            $cuerpoEmail .= "Saludos,%0D%0A";
            $cuerpoEmail .= urlencode($nombre_cliente) . "%0D%0A";
            $cuerpoEmail .= "Email: " . urlencode($correo);
            
            //Crear el enlace mailto
            $mailtoLink = "mailto:ebrumelisa.abdulgani@gamelyriberadeltajo.es?subject=" . urlencode($asunto) . "&body=" . $cuerpoEmail;
            
            //Guardar el enlace en sesión para redirigir
            $_SESSION['mailto_link'] = $mailtoLink;
            $_SESSION['pedido_procesado'] = true;
            
            //Mensaje de éxito (se mostrará después de abrir mailto)
            $mensaje = "Preparando tu pedido...";
            
            //NO vaciar el carrito todavía, se vaciará después de confirmar
            //Establecer cookie SIN EXPIRACIÓN (permanente hasta que el usuario la borre)
            setcookie('pedido_pendiente', '1', time() + (10 * 365 * 24 * 60 * 60), '/'); // 10 años
        }
    }

    //Si hay un pedido procesado y el usuario vuelve, vaciar el carrito
    if (isset($_GET['confirmar_envio']) && isset($_SESSION['pedido_procesado'])) {
        $_SESSION['carrito'] = [];
        unset($_SESSION['pedido_procesado']);
        unset($_SESSION['mailto_link']);
        $mensaje = "¡Pedido enviado! Recibirás una respuesta pronto.";
    }

    //Calcular totales
    $totalCarrito = 0;
    $cantidadTotal = 0;
    foreach ($_SESSION['carrito'] as $item) {
        $totalCarrito += $item['precio'] * $item['cantidad'];
        $cantidadTotal += $item['cantidad'];
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito - Gamely</title>

    <!-- Estilos CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/carrito/carrito.css">
    <link rel="stylesheet" href="../assets/css/header.css">
    <link rel="stylesheet" href="../assets/css/footer.css">

    <!-- FONTS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">

    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    
    <?php if (isset($_SESSION['mailto_link'])): ?>
    <script>
        // Abrir mailto automáticamente
        window.onload = function() {
            window.location.href = '<?php echo $_SESSION['mailto_link']; ?>';
            
            // Redirigir después de 3 segundos
            setTimeout(function() {
                window.location.href = 'carrito.php?confirmar_envio=1';
            }, 3000);
        };
    </script>
    <?php endif; ?>
</head>
<body>
    <section class="page-wrapper">
        <!-- HEADER -->
        <header class="header">
            <!-- PARTE SUPERIOR -->
            <section class="header-superior">
                <section class="header-superior__size">
                    <section class="header-superior__logo">
                        <h1 class="header-superior__logo-logo">&#127918; Gamely</h1>
                    </section>
                    
                    <section class="header-superior__user">
                        <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin'): ?>
                            <a href="./admin/admin_dashboard.php" class="header-superior__welcome">
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
                
                <section class="header-inferior__center">
                    <a href="./client/catalogo.php" class="header-inferior__link">Inicio</a>
                    <a href="./client/catalogo.php#recomendados" class="header-inferior__link">Recomendados</a>
                    <a href="./client/catalogo.php#mejores" class="header-inferior__link">Mejores juegos</a>
                    <a href="./client/catalogo.php#tarjetas" class="header-inferior__link">Tarjetas Regalo</a>
                </section>
                
                <nav class="header-inferior__nav-right">
                    <a class="header-inferior__action-link header-inferior__action-link--active" href="carrito.php">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <span>Carrito</span>
                        <?php if ($cantidadTotal > 0): ?>
                            <span class="carrito-contador"><?php echo $cantidadTotal; ?></span>
                        <?php endif; ?>
                    </a>
                    <a class="header-inferior__action-link" href="logout.php">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        <span>Cerrar sesión</span>
                    </a>
                </nav>
            </nav>
        </header>

        <!-- MAIN -->
        <main class="carrito-main">
            <!-- Título de la página -->
            <header class="carrito-header">
                <h1 class="carrito-header__title">
                    <i class="fa-solid fa-cart-shopping"></i> Tu Carrito
                </h1>
                <?php if (!empty($_SESSION['carrito'])): ?>
                    <span class="carrito-header__count"><?php echo $cantidadTotal; ?> artículo<?php echo $cantidadTotal !== 1 ? 's' : ''; ?></span>
                <?php endif; ?>
            </header>

            <!-- Mensajes de éxito / error -->
            <?php if ($mensaje): ?>
                <article class="carrito-mensaje carrito-mensaje--success">
                    <i class="fa-solid fa-check-circle"></i> <?php echo htmlspecialchars($mensaje); ?>
                    <?php if (isset($_SESSION['mailto_link'])): ?>
                        <br><small>Se abrirá tu cliente de correo. Si no se abre automáticamente, 
                        <a href="<?php echo $_SESSION['mailto_link']; ?>" style="color: white; text-decoration: underline;">haz click aquí</a></small>
                    <?php endif; ?>
                </article>
            <?php endif; ?>
            <?php if ($error): ?>
                <article class="carrito-mensaje carrito-mensaje--error">
                    <i class="fa-solid fa-circle-exclamation"></i> <?php echo htmlspecialchars($error); ?>
                </article>
            <?php endif; ?>

            <?php if (empty($_SESSION['carrito'])): ?>
                <!-- CARRITO VACÍO -->
                <article class="carrito-vacio">
                    <i class="fa-solid fa-cart-shopping carrito-vacio__icono"></i>
                    <h2 class="carrito-vacio__titulo">Tu carrito está vacío</h2>
                    <p class="carrito-vacio__texto">Añade juegos desde el catálogo para comenzar.</p>
                    <a href="./client/catalogo.php" class="carrito-btn carrito-btn--primary">
                        <i class="fa-solid fa-gamepad"></i> Ir al Catálogo
                    </a>
                </article>

            <?php else: ?>
                <!-- CARRITO CON CONTENIDO -->
                <section class="carrito-contenido">

                    <!-- Lista de juegos -->
                    <article class="carrito-lista">
                        <header class="carrito-lista__cabecera">
                            <span class="carrito-lista__col--nombre">Juego</span>
                            <span class="carrito-lista__col--precio">Precio</span>
                            <span class="carrito-lista__col--cant">Cant.</span>
                            <span class="carrito-lista__col--subtotal">Subtotal</span>
                            <span class="carrito-lista__col--eliminar"></span>
                        </header>

                        <?php foreach ($_SESSION['carrito'] as $item): ?>
                            <?php $subtotal = $item['precio'] * $item['cantidad']; ?>
                            <article class="carrito-item">
                                <section class="carrito-item__nombre">
                                    <i class="fa-solid fa-gamepad carrito-item__icono"></i>
                                    <span><?php echo htmlspecialchars($item['nombre']); ?></span>
                                </section>
                                <section class="carrito-item__precio">€<?php echo number_format($item['precio'], 2); ?></section>
                                <section class="carrito-item__cantidad"><?php echo $item['cantidad']; ?></section>
                                <section class="carrito-item__subtotal">€<?php echo number_format($subtotal, 2); ?></section>
                                <a href="carrito.php?eliminar=<?php echo (int)$item['id']; ?>" class="carrito-item__eliminar" title="Eliminar del carrito">
                                    <i class="fa-solid fa-xmark"></i>
                                </a>
                            </article>
                        <?php endforeach; ?>

                        <!-- Total de la lista -->
                        <footer class="carrito-lista__total">
                            <span class="carrito-lista__total-etiqueta">Total</span>
                            <span class="carrito-lista__total-valor">€<?php echo number_format($totalCarrito, 2); ?></span>
                        </footer>
                    </article>

                    <!-- Formulario de datos del cliente + envío -->
                    <article class="carrito-formulario">
                        <h2 class="carrito-formulario__titulo">
                            <i class="fa-solid fa-envelope"></i> Datos de envío
                        </h2>
                        <p class="carrito-formulario__desc">
                            Rellena los campos y se abrirá tu cliente de correo con el pedido preparado.
                        </p>

                        <form method="POST">
                            <section class="carrito-formulario__grupo">
                                <label class="carrito-formulario__label" for="nombre_cliente">
                                    <i class="fa-solid fa-user"></i> Nombre completo
                                </label>
                                <input
                                    class="carrito-formulario__input"
                                    type="text"
                                    id="nombre_cliente"
                                    name="nombre_cliente"
                                    placeholder="Ej: Juan García"
                                    value="<?php echo isset($_POST['nombre_cliente']) ? htmlspecialchars($_POST['nombre_cliente']) : ''; ?>"
                                    required
                                >
                            </section>

                            <section class="carrito-formulario__grupo">
                                <label class="carrito-formulario__label" for="correo">
                                    <i class="fa-solid fa-envelope"></i> Correo electrónico
                                </label>
                                <input
                                    class="carrito-formulario__input"
                                    type="email"
                                    id="correo"
                                    name="correo"
                                    placeholder="Ej: juan@correo.com"
                                    value="<?php echo isset($_POST['correo']) ? htmlspecialchars($_POST['correo']) : ''; ?>"
                                    required
                                >
                            </section>

                            <!-- Resumen rápido antes de enviar -->
                            <section class="carrito-formulario__resumen">
                                <span class="carrito-formulario__resumen-items"><?php echo $cantidadTotal; ?> juego<?php echo $cantidadTotal !== 1 ? 's' : ''; ?></span>
                                <span class="carrito-formulario__resumen-total">€<?php echo number_format($totalCarrito, 2); ?></span>
                            </section>

                            <button type="submit" name="comprar" class="carrito-btn carrito-btn--enviar">
                                <i class="fa-solid fa-paper-plane"></i> Enviar Pedido por Email
                            </button>
                        </form> 
                    </article>
                </section>
            <?php endif; ?>
        </main>

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
                            <img src="./../assets/images/footer_images/gallery-3-90x65.jpg" alt="foto1" class="footer__card-img">
                            <section class="footer__card-content">
                                <h4 class="footer__card-title">Lanzamiento de nuevo juego</h4>
                                <section class="footer__card-divider">
                                    <i class="footer__card-text fa-regular fa-clock"></i>
                                    <p class="footer__card-text">Enero 2, 2024</p>
                                </section>                               
                            </section>
                        </article>
                        <article class="footer__card">
                            <img src="./../assets/images/footer_images/post-1-90x65.jpg" alt="foto2" class="footer__card-img">
                            <section class="footer__card-content">
                                <h4 class="footer__card-title">¡Se ha lanzado un nuevo tráiler!</h4>
                                <section class="footer__card-divider">
                                    <i class="footer__card-text fa-regular fa-clock"></i>
                                    <p class="footer__card-text">Enero 12, 2024</p>
                                </section> 
                            </section>
                        </article>
                        <article class="footer__card">
                            <img src="./../assets/images/footer_images/video-post-90x65.jpg" alt="foto3" class="footer__card-img">
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
    </section>
</body>
</html>
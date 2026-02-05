<?php
//Verificar si ya se aceptaron las cookies
$cookiesAceptadas = isset($_COOKIE['cookies_aceptadas']) && $_COOKIE['cookies_aceptadas'] === '1';

//Si no se han aceptado, mostrar el banner
if (!$cookiesAceptadas):
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cookies</title>

    <style>
    /*  ============================================
        BANNER DE COOKIES
        ============================================ */
        .cookie-banner {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(135deg, #2d2d44 0%, #1a1a2e 100%);
            padding: 20px;
            box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.3);
            z-index: 9999;
            border-top: 3px solid #6c5ce7;
            animation: slideUp 0.5s ease-out;
        }

        @keyframes slideUp {
            from {
                transform: translateY(100%);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .cookie-banner__contenido {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .cookie-banner__texto {
            display: flex;
            align-items: center;
            gap: 15px;
            flex: 1;
            min-width: 250px;
        }

        .cookie-banner__texto i {
            font-size: 2rem;
            color: #6c5ce7;
        }

        .cookie-banner__texto p {
            margin: 0;
            color: #b8b8d1;
            font-size: 0.9rem;
            line-height: 1.5;
        }

        .cookie-banner__texto strong {
            color: #ffffff;
            font-size: 1rem;
        }

        .cookie-banner__link {
            color: #00cec9;
            text-decoration: underline;
            transition: color 0.3s;
        }

        .cookie-banner__link:hover {
            color: #6c5ce7;
        }

        .cookie-banner__acciones {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .cookie-banner__btn {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 8px;
            font-family: 'Poppins', sans-serif;
        }

        .cookie-banner__btn--aceptar {
            background: linear-gradient(135deg, #6c5ce7, #00cec9);
            color: white;
        }

        .cookie-banner__btn--aceptar:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(108, 92, 231, 0.4);
        }

        .cookie-banner__btn--rechazar {
            background: rgba(255, 255, 255, 0.1);
            color: #b8b8d1;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .cookie-banner__btn--rechazar:hover {
            background: rgba(255, 255, 255, 0.15);
            color: white;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .cookie-banner {
                padding: 15px;
            }
            
            .cookie-banner__contenido {
                flex-direction: column;
                text-align: center;
            }
            
            .cookie-banner__texto {
                flex-direction: column;
                text-align: center;
            }
            
            .cookie-banner__acciones {
                width: 100%;
                justify-content: center;
            }
            
            .cookie-banner__btn {
                flex: 1;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <!-- Banner de Cookies -->
    <div id="cookie-banner" class="cookie-banner">
        <div class="cookie-banner__contenido">
            <div class="cookie-banner__texto">
                <i class="fa-solid fa-cookie-bite"></i>
                <p>
                    <strong>🍪 Aceptar cookies</strong><br>
                    Este sitio utiliza cookies para mejorar tu experiencia. Al continuar navegando, aceptas nuestro uso de cookies.
                    <a href="#" class="cookie-banner__link">Más información</a>
                </p>
            </div>
            <div class="cookie-banner__acciones">
                <button onclick="aceptarCookies()" class="cookie-banner__btn cookie-banner__btn--aceptar">
                    <i class="fa-solid fa-check"></i> Aceptar
                </button>
                <button onclick="rechazarCookies()" class="cookie-banner__btn cookie-banner__btn--rechazar">
                    <i class="fa-solid fa-xmark"></i> Rechazar
                </button>
            </div>
        </div>
    </div>
</body>
<script>
// ============================================
// FUNCIONALIDAD DE COOKIES
// ============================================
function aceptarCookies() {
    //Establecer cookie sin expiración
    const fechaExpiracion = new Date();
    fechaExpiracion.setFullYear(fechaExpiracion.getFullYear() + 10);
    
    document.cookie = 'cookies_aceptadas=1; expires=' + fechaExpiracion.toUTCString() + '; path=/';
    
    //Ocultar el banner con animación
    const banner = document.getElementById('cookie-banner');
    banner.style.animation = 'slideDown 0.5s ease-out';
    
    setTimeout(function() {
        banner.style.display = 'none';
    }, 500);
}

//Función para rechazar cookies
function rechazarCookies() {
    //Solo ocultar el banner sin establecer la cookie
    const banner = document.getElementById('cookie-banner');
    banner.style.animation = 'slideDown 0.5s ease-out';
    
    setTimeout(function() {
        banner.style.display = 'none';
    }, 500);
}

//Animación de salida
const style = document.createElement('style');
style.textContent = `
    @keyframes slideDown {
        from {
            transform: translateY(0);
            opacity: 1;
        }
        to {
            transform: translateY(100%);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);
</script>
</html>
<?php endif; ?>

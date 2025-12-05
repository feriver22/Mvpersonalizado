<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{pageTitle}} - MVPersonalizados</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="public/css/style.css">
    <link rel="stylesheet" href="public/css/responsive.css">
</head>
<body>
    <header class="header">
        <div class="container">
            <div class="logo">
                <i class="fas fa-gift"></i> MVPersonalizados
            </div>
            <nav class="navbar">
                <ul class="nav-list">
                    {{foreach NavItems as $item}}
                    <li><a href="{{$item->nav_url}}" class="nav-link">{{$item->nav_label}}</a></li>
                    {{/foreach}}
                </ul>
            </nav>
        </div>
    </header>

    <main class="main-content">
        <div class="container">
            {{{page_content}}}
        </div>
    </main>

    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>Contacto</h3>
                    <ul>
                        <li><a href="https://wa.me/50488884218" target="_blank"><i class="fab fa-whatsapp"></i> WhatsApp</a></li>
                        <li><a href="https://instagram.com/mvpersonalizados.03" target="_blank"><i class="fab fa-instagram"></i> Instagram</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Información</h3>
                    <ul>
                        <li><a href="index.php?page=Home">Inicio</a></li>
                        <li><a href="index.php?page=Home_About">Sobre Nosotros</a></li>
                        <li><a href="index.php?page=Home_Contact">Contáctanos</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Legal</h3>
                    <ul>
                        <li><a href="#">Términos y Condiciones</a></li>
                        <li><a href="#">Política de Privacidad</a></li>
                        <li><a href="#">Política de Devoluciones</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; {{CURRENT_YEAR}} MVPersonalizados. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <script src="public/js/cart.js"></script>
</body>
</html>

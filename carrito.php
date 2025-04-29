<?php
session_start();
require "connection.php";

// Procesar eliminar del carrito
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    if (isset($_SESSION['carrito'][$id])) {
        unset($_SESSION['carrito'][$id]);
        $_SESSION['mensaje'] = "Producto eliminado del carrito";
        $_SESSION['mensaje_tipo'] = "exito";
    }
    header("Location: carrito.php");
    exit();
}

// Procesar compra
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['finalizar_compra'])) {
    // Aquí normalmente procesarías la compra, guardarías en BD, etc.
    // Pero para este ejemplo solo mostramos mensaje y vaciamos el carrito

    $_SESSION['mensaje'] = "¡Compra realizada con éxito! (simulación)";
    $_SESSION['mensaje_tipo'] = "exito";
    unset($_SESSION['carrito']);
    
    // header("Location: index.php");
    // exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras | Verdulandia</title>
    <link rel="stylesheet" href="./assets/css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&family=Rubik:wght@400;700&display=swap" rel="stylesheet">
</head>

<body>
    <header class="pixel-header">
        <div class="container">
            <h1 class="logo">VERDULANDIA</h1>
            <nav class="main-nav">
                <ul>
                    <li><a href="index.php">Inicio</a></li>
                    <li><a href="index.php#productos">Productos</a></li>
                    <li><a href="index.php#contacto">Contacto</a></li>
                </ul>
            </nav>
            <div class="cart-icon">
                <a href="carrito.php" class="cart-link">
                    <span class="cart-count">
                        <?php
                        if (isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])) {
                            echo array_sum(array_column($_SESSION['carrito'], 'cantidad'));
                        } else {
                            echo '0';
                        }
                        ?>
                    </span>
                    <img src="assets/imgs/carrito-icon.png" alt="Carrito de compras" width="32" height="32">
                </a>
            </div>
        </div>
    </header>

    <main class="container">
        <section class="cart-section">
            <h2 class="section-title">TU CARRITO</h2>

            <?php if (isset($_SESSION['mensaje'])): ?>
                <div class="pixel-message <?php echo $_SESSION['mensaje_tipo']; ?>">
                    <?php echo $_SESSION['mensaje']; ?>
                </div>
                <?php
                unset($_SESSION['mensaje']);
                unset($_SESSION['mensaje_tipo']);
                ?>
            <?php endif; ?>

            <?php if (empty($_SESSION['carrito'])): ?>
                <div class="empty-cart pixel-card">
                    <p>¡Tu carrito está vacío!</p>
                    <a href="index.php" class="pixel-button">Volver a la tienda</a>
                </div>
            <?php else: ?>
                <div class="cart-items">
                    <?php
                    $total = 0;
                    foreach ($_SESSION['carrito'] as $id => $item):
                        $subtotal = $item['precio'] * $item['cantidad'];
                        $total += $subtotal;
                    ?>
                        <div class="cart-item pixel-card">
                            <div class="cart-item-info">
                                <h3><?php echo htmlspecialchars($item['nombre']); ?></h3>
                                <p><?php echo $item['cantidad'] . " " . $item['unidad']; ?></p>
                                <p>$<?php echo number_format($item['precio'], 0, ',', '.'); ?> c/u</p>
                            </div>
                            <div class="cart-item-subtotal">
                                <p>$<?php echo number_format($subtotal, 0, ',', '.'); ?></p>
                                <a href="carrito.php?eliminar=<?php echo $id; ?>" class="pixel-button small">Eliminar</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="cart-total pixel-card">
                    <h3>TOTAL: $<?php echo number_format($total, 0, ',', '.'); ?></h3>
                </div>

                <form method="post" class="checkout-form pixel-card">
                    <h3>Información de Envío</h3>
                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        <input type="text" id="nombre" name="nombre" required class="pixel-input">
                    </div>
                    <div class="form-group">
                        <label for="email">Correo Electrónico:</label>
                        <input type="email" id="email" name="email" required class="pixel-input">
                    </div>
                    <div class="form-group">
                        <label for="direccion">Dirección:</label>
                        <textarea id="direccion" name="direccion" required class="pixel-input"></textarea>
                    </div>
                    <button type="submit" name="finalizar_compra" class="pixel-button large">FINALIZAR COMPRA</button>
                </form>
            <?php endif; ?>
        </section>
    </main>

    <footer class="pixel-footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3 class="footer-title">Horario</h3>
                    <p>Lunes a Viernes: 8:00 - 20:00</p>
                    <p>Sábados: 9:00 - 18:00</p>
                </div>
                <div class="footer-section">
                    <h3 class="footer-title">Contacto</h3>
                    <p>info@verdulandia.com</p>
                    <p>Tel: +569 1234 5678</p>
                </div>
                <div class="footer-section">
                    <h3 class="footer-title">Síguenos</h3>
                    <div class="social-icons">
                        <a href="#"><img src="assets/imgs/facebook-icon.png" alt="Facebook" width="24" height="24"></a>
                        <a href="#"><img src="assets/imgs/twitter-icon.png" alt="Twitter" width="24" height="24"></a>
                        <a href="#"><img src="assets/imgs/instagram-icon.png" alt="Instagram" width="24" height="24"></a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 Verdulandia - Todos los derechos reservados</p>
            </div>
        </div>
    </footer>
</body>

</html>
<?php
session_start();
require "connection.php";

// Inicializar carrito si no existe
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Procesar agregar al carrito
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregar_carrito'])) {
    $id = $_POST['id'];
    $cantidad = floatval($_POST['cantidad']);

    // Verificar límite (2kg máximo por producto)
    if ($cantidad > 2) {
        $_SESSION['mensaje'] = "¡Ups! El límite es de 2kg por producto";
        $_SESSION['mensaje_tipo'] = "error";
    } else {
        if (isset($_SESSION['carrito'][$id])) {
            $nueva_cantidad = $_SESSION['carrito'][$id]['cantidad'] + $cantidad;
            if ($nueva_cantidad > 2) {
                $_SESSION['mensaje'] = "¡Superaste el límite de 2kg para este producto!";
                $_SESSION['mensaje_tipo'] = "error";
            } else {
                $_SESSION['carrito'][$id]['cantidad'] = $nueva_cantidad;
                $_SESSION['mensaje'] = "Producto actualizado en el carrito";
                $_SESSION['mensaje_tipo'] = "exito";
            }
        } else {
            $sql = "SELECT nombre, precio, unidad_medida FROM verduras WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $producto = $result->fetch_assoc();
                $_SESSION['carrito'][$id] = [
                    'nombre' => $producto['nombre'],
                    'precio' => $producto['precio'],
                    'cantidad' => $cantidad,
                    'unidad' => $producto['unidad_medida']
                ];
                $_SESSION['mensaje'] = "Producto agregado al carrito";
                $_SESSION['mensaje_tipo'] = "exito";
            }
        }
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// CONSULTA PRINCIPAL PARA OBTENER LOS PRODUCTOS
$sql_productos = "SELECT * FROM verduras";
$result_productos = $conn->query($sql_productos);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verdulandia | Tu verdulería pixelada</title>
    <meta name="description" content="Verduras frescas con estilo de videojuego">
    <link rel="stylesheet" href="./assets/css/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&family=Rubik:wght@400;700&display=swap" rel="stylesheet">
</head>

<body>
    <header class="pixel-header">
        <div class="container">
            <h1 class="logo">VERDULANDIA</h1>
            <nav class="main-nav">
                <ul>
                    <li><a href="#inicio">Inicio</a></li>
                    <li><a href="#productos">Productos</a></li>
                    <li><a href="#contacto">Contacto</a></li>
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
        <section id="productos" class="products-section">
            <h2 class="section-title">Nuestros Productos Frescos</h2>
            <div class="products-grid">
                <?php
                if ($result_productos->num_rows > 0) {
                    // Mostrar cada verdura como una tarjeta
                    while ($row = $result_productos->fetch_assoc()) {
                        // Determinar si mostrar badge
                        $badge = "";
                        if ($row["es_nuevo"]) {
                            $badge = '<div class="product-badge">¡Nuevo!</div>';
                        } else if ($row["es_oferta"]) {
                            $badge = '<div class="product-badge">Oferta</div>';
                        } elseif ($row["es_popular"]) {
                            $badge = '<div class="product-badge">Popular</div>';
                        }

                        echo '
                        <article class="product-card pixel-card">
                            ' . $badge . '
                            <img src="./assets/imgs/productos/' . $row["nombre"] . '.png" alt="' . $row["nombre"] . '" class="product-image" width="200" height="200">
                            <div class="product-info">
                                <h3 class="product-title">' . $row["nombre"] . '</h3>
                                <p class="product-description">' . $row["descripción"] . '</p>
                                <div class="product-price">$' . number_format($row["precio"], 0, ',', '.') . ' <span class="price-unit">/' . $row["unidad_medida"] . '</span></div>

                                <form method="post" class="add-to-cart-form">
                                    <input type="hidden" name="id" value="' . $row["id"] . '">
                                    <div class="quantity-selector">
                                        <label for="cantidad_' . $row["id"] . '">Cantidad (kg):</label>
                                        <input type="number" name="cantidad" id="cantidad_' . $row["id"] . '" 
                                               min="0.1" max="2" step="0.1" value="0.5" required>
                                    </div>
                                    <button type="submit" name="agregar_carrito" class="add-to-cart pixel-button">
                                        Agregar al carrito
                                    </button>
                                </form>
                            </div>
                        </article>';
                    }
                } else {
                    echo '<p class="no-products">No hay productos disponibles en este momento.</p>';
                }
                ?>
            </div>
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

<?php
// Cerrar conexión
$conn->close();
?>
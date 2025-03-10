
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/index_adm.css">
</head>
<style>

.menu-icon {
    display: none;
    font-size: 24px;
    cursor: pointer;
    color: #fff;
}

    @media (max-width: 1024px) {
    .navbar h1 {
        font-size: 22px; /* Tamaño de fuente más pequeño para tablets */
    }

    .navbar ul li a {
        font-size: 14px; /* Tamaño de fuente más pequeño para enlaces */
    }
}

@media (max-width: 768px) {
    .navbar ul {
        display: none; /* Oculta el menú en pantallas pequeñas */
        flex-direction: column;
        background-color: #333;
        position: absolute;
        top: 60px;
        right: 20px;
        width: 200px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
    }

    .navbar ul.active {
        display: flex; /* Muestra el menú cuando está activo */
    }

    .navbar ul li {
        text-align: center;
        padding: 10px;
    }

    .navbar ul li a {
        font-size: 14px;
    }

    .menu-icon {
        display: block; /* Muestra el ícono del menú hamburguesa */
    }
}

@media (max-width: 480px) {
    .navbar {
        padding: 10px; /* Menos padding en pantallas muy pequeñas */
    }

    .navbar h1 {
        font-size: 20px; /* Tamaño de fuente más pequeño para móviles */
    }

    .navbar ul {
        top: 50px;
        right: 10px;
        width: 180px; /* Menú más estrecho para móviles */
    }

    .navbar ul li a {
        font-size: 12px; /* Tamaño de fuente más pequeño para enlaces */
    }
}

@media (max-width: 320px) {
    .navbar h1 {
        font-size: 18px; /* Tamaño de fuente más pequeño para móviles muy pequeños */
    }

    .navbar ul {
        width: 150px; /* Menú aún más estrecho */
    }

    .navbar ul li a {
        font-size: 12px;
    }
}
</style>
<body>
    <!-- Barra de navegación -->
    <div class="navbar">
        <h1>Panel de Administración</h1>
        <!-- Ícono del menú hamburguesa -->
        <div class="menu-icon" onclick="toggleMenu()">&#9776;</div>
        <!-- Menú de navegación -->
        <ul id="nav-menu">
            <li><a href="index.php">Menu</a></li>
            <li><a href="subir_img.php">Subir Imágenes</a></li>
            <li><a href="#">Historial</a></li>
            <li><a href="../../includes/exit.php">Cerrar Sesión</a></li>
        </ul>
    </div>

    <!-- Script para el menú hamburguesa -->
    <script>
        function toggleMenu() {
            const navMenu = document.getElementById("nav-menu");
            navMenu.classList.toggle("active");
        }
    </script>
</body>
</html>
<?php
session_start();
?>
<nav class="navbar navbar-expand-lg">
    <a class="navbar-brand" href="#">
        <img src="../vistas/imagenes/Logo.png" alt="Logo de North Peak" class="logo-image">

        <?php if (isset($_SESSION['nombre'])): ?>
            <span class="navbar-text collapse navbar-collapse" style="margin-left:20px; color:#7d7979; font-size: 16px;">
                ¡Bienvenido <?php echo htmlspecialchars($_SESSION['nombre']); ?>!
            </span>
        <?php endif; ?>
    </a>

    <div class="collapse navbar-collapse">
        <span class="navbar-text centered-text">ENVÍO GRATIS DESDE 19€</span>
    </div>
    <form class="buscador">
        <input class="form-control w-100" type="search" placeholder="Buscar">
    </form>
    <div id="logosJuntos">
        <a href="validarse.php" id="logoUsuario">
            <img src="../vistas/imagenes/logoUsuario.png" alt="iconoUsuario">
        </a>
        <a href="" id="logoCarrito">
            <img src="../vistas/imagenes/logoCarrito.png" alt="iconoCarrito">
        </a>
    </div>
</nav>
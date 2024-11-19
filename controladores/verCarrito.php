<?php
session_start();
include '../vistas/inicio.html';
include '../vistas/nav.php';
include '../vistas/carrito/body.html';
include '../vistas/footer.html';
?>
<script src="../vistas/js/styleCarrito.js"></script>
<?php
include '../vistas/mostrarCarrito.php';
include '../vistas/final.html';
?>
<?php
session_start();
include '../vistas/inicio.html';
include '../vistas/nav.php';
include '../vistas/carrito/body.html';
include '../vistas/footer.html';
?>
<script>
    var idUnico = '<?php echo $_SESSION['idUnico']; ?>'
</script>
<script src="../vistas/js/styleCarrito.js"></script>
<script src="../vistas/js/mostrarCarrito.js"></script>
<?php
include '../vistas/final.html';
?>
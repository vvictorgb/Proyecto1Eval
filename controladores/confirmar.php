<?php
require "../config/autocarga.php";
$base = new Base();
$link = $base->link;
session_start();
if (!isset($_SESSION['dniCliente'])) {
    header('Location: validarse.php');
} else {
    try {
        //InsertarPedido
        $link->beginTransaction();
        $dniCliente = $_SESSION['dniCliente'];
        $fecha = date('Y-m-d');
        $idPedido = Pedido::obtenerID($link) + 1;
        $cli = new Cliente($_SESSION['dniCliente']);
        $dirEntrega = $cli->direccionCliente($link);
        $pedidoNuevo = new Pedido($idPedido, $fecha, $dniCliente, $dirEntrega);
        $pedidoNuevo->nuevoPedido($link);

        $mostrarFactura = "
        <h3>Dni Cliente:
        $dniCliente
        </h3><br>
        <h3>Fecha:
            $fecha
        </h3><br>
        <h3>Numero Pedido:
            $idPedido
        </h3><br>
        <h3>Direccion entrega:
            $dirEntrega
        </h3><br>";

        //Insertar Lineas
        $api = 'http://localhost/GomezBalaguerV%c3%adctorProyecto1T/Proyecto1Eval/carrito/carrito.php?idUnico=' . $_SESSION['idUnico'];
        $carr = json_decode(file_get_contents($api), true);
        $lineasPedidos = lineasPedido::InsertarTodas($link, $carr, $idPedido);
        $link->commit();
        $mostrarFactura .= $lineasPedidos;
        echo $mostrarFactura;
        exit();
    } catch (PDOException $e) {
        $link->rollback();
        $dato = "¡Error!: " . $e->getMessage() . "<br/>";
        require "../vistas/mensaje.php";
        die();
    }
}

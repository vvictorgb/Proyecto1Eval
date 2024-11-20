<?php
require "../config/autocarga.php";
$base = new Base();
$link = $base->link;
session_start();
if (!isset($_SESSION['dniCliente'])) {
    header('Location: validarse.php');
} else {
    //Insertar pedido
    $dniCliente = $_SESSION['dniCliente'];
    $fecha = date('Y-m-d');
    $idPedido = Pedido::obtenerID($link) + 1;
    $cli = new Cliente($_SESSION['dniCliente']);
    $dirEntrega = $cli->direccionCliente($link);
    $pedidoNuevo = new Pedido($idPedido, $fecha, $dniCliente, $dirEntrega);
    $pedidoNuevo->nuevoPedido($link);
}

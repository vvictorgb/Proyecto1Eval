<?php
require "config/autocarga.php";
$base = new Base();
$link = $base->link;
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['idUnico'])) {
        $_SESSION['idUnico'] = uniqid();
    }
    $vector = json_decode(file_get_contents("php://input"), true);

    if (isset($_SESSION['dniCliente'])) {
        $carrito = new Carrito($_SESSION['idUnico'], $vector['idProducto'], $vector['cantidad'], $_SESSION['dniCliente']);
    } else {
        $carrito = new Carrito($_SESSION['idUnico'], $vector['idProducto'], $vector['cantidad']);
    }
    try {
        $link->beginTransaction();
        $carrito->guardar($link);
        $link->commit();
        echo json_encode(["registro" => true,]);
    } catch (PDOException $e) {
        $link->rollback();
        $dato = "¡Error!: " . $e->getMessage();
        header("HTTP/1.1 400 Bad Request");
        echo json_encode(["registro" => false, "error" => $dato]);
        exit();
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
    try {
        $carrito = new Carrito($_GET['idUnico'], "", "");
        $elementosCarrito = $carrito->carritoID($link);
        header("HTTP/1.1 200 OK");
        echo json_encode($elementosCarrito);
        exit();
    } catch (PDOException $e) {
        $dato = "¡Error!: " . $e->getMessage();
        echo json_encode(["error" => $dato]);
        exit();
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    $vector = json_decode(file_get_contents('php://input'), true);
    $idProducto = $vector['idProducto'];
    $idUnico = $vector['idUnico'];
    try {
        $carrito = new Carrito($idUnico, $idProducto, "");
        $carrito->eliminarProductoCarrito($link);
        echo json_encode(["success" => true]);
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "error" => $e->getMessage()]);
        exit();
    }
}

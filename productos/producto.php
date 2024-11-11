<?php
require "config/autocarga.php";
$base = new Base();
$vector = json_decode(file_get_contents("php://input"), true);
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($vector['idProducto'])) {
        //Mostrar un Cliente
        $pro = new Producto($vector['idProducto']);
        $dato = $pro->buscar($base->link);
        header("HTTP/1.1 200 OK");
        echo json_encode($dato);
        exit();
    } else {
        //Mostrar lista de clientes
        $dato = Producto::getAll($base->link);
        $dato->setFetchMode(PDO::FETCH_ASSOC);
        header("HTTP/1.1 200 OK");
        echo json_encode($dato->fetchAll());
        exit();
    }
}
header("HTTP/1.1 400 Bad Request");

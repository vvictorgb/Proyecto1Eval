<?php
require "config/autocarga.php";
$base = new Base();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['idProducto'])) {
        try {
            $pro = new Producto($_GET['idProducto']);
            $base->link->beginTransaction();
            $dato = $pro->buscar($base->link);
            header("HTTP/1.1 200 OK");
            echo json_encode($dato);
            $base->link->commit();
            exit();
        } catch (PDOException $e) {
            $base->link->rollback();
            $dato = "¡Error!: " . $e->getMessage();
            echo json_encode(["error" => $dato]);
            exit();
        }
    } else {

        try {
            $base->link->beginTransaction();
            $dato = Producto::getAll($base->link);
            $dato->setFetchMode(PDO::FETCH_ASSOC);
            header("HTTP/1.1 200 OK");
            echo json_encode($dato->fetchAll());
            $base->link->commit();
            exit();
        } catch (PDOException $e) {
            $base->link->rollback();
            $dato = "¡Error!: " . $e->getMessage();
            echo json_encode(["error" => $dato]);
            exit();
        }
    }
}
header("HTTP/1.1 400 Bad Request");

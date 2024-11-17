<?php
require "config/autocarga.php";
$base = new Base();
$link = $base->link;
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vector = json_decode(file_get_contents("php://input"), true);
    $contraseña = password_hash($vector['pwd'], PASSWORD_DEFAULT);
    $cli = new Cliente($vector['dniCliente'], $vector['nombre'], $vector['direccion'], $vector['email'], $contraseña);
    try {
        $link->beginTransaction();
        if (!$cli->buscar($link)) {
            $cli->guardar($link);
            header("HTTP/1.1 200 OK");
            $_SESSION['dniCliente'] = $vector['dniCliente'];
            $_SESSION['nombre'] = $vector['nombre'];
            echo json_encode(["registro" => true]);
            $link->commit();
            exit();
        } else {
            header("HTTP/1.1 401 Unauthorized");
            echo json_encode(["registro" => false, "error" => "El DNI ya está registrado."]);
            exit();
        }
    } catch (PDOException $e) {
        $link->rollback();
        $dato = "¡Error!: " . $e->getMessage();
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(["registro" => false, "error" => $dato]);
        exit();
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
    try {

        $link->beginTransaction();
        $contraseñaIngresada = $_GET['pwd'];
        $cli = new Cliente($_GET['dniCliente'], "", "", "", "");
        $contraseñaAlmacenada = $cli->obtenerPwd($link);

        if (password_verify($contraseñaIngresada, $contraseñaAlmacenada)) {
            header("HTTP/1.1 200 OK");
            $datosCliente = $cli->buscar($link);
            $_SESSION['nombre'] = $datosCliente['nombre'];
            $_SESSION['dniCliente'] = $_GET['dniCliente'];
            echo json_encode(["registro" => true]);
            $link->commit();
            exit();
        } else {

            header("HTTP/1.1 401 Unauthorized");
            echo json_encode(["registro" => false, "error" => "Contraseña o DNI incorrectos"]);
            exit();
        }
    } catch (PDOException $e) {

        $link->rollback();
        $dato = "¡Error!: " . $e->getMessage();
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(["registro" => false, "error" => $dato]);
        exit();
    }
}

header("HTTP/1.1 400 Bad Request");

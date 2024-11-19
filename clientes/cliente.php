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
        if (!$cli->buscar($link)) {
            $link->beginTransaction();
            $cli->guardar($link);
            header("HTTP/1.1 200 OK");
            $link->commit();
            $_SESSION['dniCliente'] = $vector['dniCliente'];
            $_SESSION['nombre'] = $vector['nombre'];
            if (isset($_SESSION['idUnico'])) {
                $idUnico = $_SESSION['idUnico'];
                $carrito = new Carrito($idUnico, "", "", $vector['dniCliente']);
                $carrito->actualizarDniCliente($link);
            }
            echo json_encode(["registro" => true]);
            exit();
        } else {
            header("HTTP/1.1 200 OK");
            echo json_encode(["registro" => false, "error" => "El DNI ya está registrado."]);
            exit();
        }
    } catch (PDOException $e) {
        $link->rollback();
        $dato = "¡Error!: " . $e->getMessage();
        header("HTTP/1.1 400 Bad Request");
        echo json_encode(["registro" => false, "error" => $dato]);
        exit();
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
    try {
        $contraseñaIngresada = $_GET['pwd'];
        $cli = new Cliente($_GET['dniCliente'], "", "", "", "");
        $datosCliente = $cli->buscar($link);
        if ($datosCliente) {
            $contraseñaAlmacenada = $cli->obtenerPwd($link);
            if (password_verify($contraseñaIngresada, $contraseñaAlmacenada)) {
                header("HTTP/1.1 200 OK");
                $_SESSION['nombre'] = $datosCliente['nombre'];
                $_SESSION['dniCliente'] = $_GET['dniCliente'];
                if (isset($_SESSION['idUnico'])) {
                    $idUnico = $_SESSION['idUnico'];
                    $carrito = new Carrito($idUnico, "", "", $_GET['dniCliente']);
                    $carrito->actualizarDniCliente($link);
                    echo json_encode(["registro" => true]);
                    exit();
                }
                echo json_encode(["registro" => true]);
                exit();
            } else {
                header("HTTP/1.1 200 OK");
                echo json_encode(["registro" => false, "error" => "Contraseña o DNI incorrectos"]);
                exit();
            }
        } else {
            header("HTTP/1.1 200 OK");
            echo json_encode(["registro" => false, "error" => "Contraseña o DNI incorrectos"]);
            exit();
        }
    } catch (PDOException $e) {
        $dato = "¡Error!: " . $e->getMessage();
        header("HTTP/1.1 400 Bad Request");
        echo json_encode(["registro" => false, "error" => $dato]);
        exit();
    }
}
header("HTTP/1.1 400 Bad Request");

<?php
require "config/autocarga.php";
$base = new Base();
$link = $base->link;
//crear nuevo cliente
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $contraseña = password_hash($_POST['pwd'], PASSWORD_DEFAULT);
    $cli = new Cliente($_POST['dni'], $_POST['nombre'], $_POST['direccion'], $_POST['email'], $contraseña);
    $cli->guardar($link);
    header('Location:lineas.php');
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') { {
        //validar cliente
        $cli = new Cliente($_GET['dniCliente'], '', '', '', '');
        $dato = $cli->validar($base->link);
        header("HTTP/1.1 200 OK");
        echo json_encode($dato);
        exit();
    }
}

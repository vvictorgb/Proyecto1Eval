<?php
require "config/autocarga.php";
$base = new Base();
$link = $base->link;
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $dniCliente = $_POST['dniCliente'];
    $direccion = $_POST['direccion'];
    $contraseña = password_hash($_POST['pwd'], PASSWORD_DEFAULT);
    $cli = new Cliente($dniCliente, $nombre, $direccion, $email, $contraseña);
    if ($cli->guardar($link)) {
        header("HTTP/1.1 200 OK");
        $_SESSION['usuario'] = $nombre;
        $_SESSION['dniCliente'] = $dniCliente;
        echo json_encode(["registro" => true]);
    } else {
        header("HTTP/1.1 400 Bad Request");
        echo json_encode(["registro" => false]);
    }
}

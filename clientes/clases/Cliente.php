<?php

class Cliente
{
    private $dniCliente;
    private $nombre;
    private $direccion;
    private $email;
    private $pwd;

    function __construct($dni, $nombre, $direccion, $email, $pwd)
    {
        $this->dniCliente = $dni;
        $this->nombre = $nombre;
        $this->direccion = $direccion;
        $this->email = $email;
        $this->pwd = $pwd;
    }
    function __get($var)
    {
        return $this->$var;
    }
    function guardar($link)
    {
        try {
            $consulta = $link->prepare("INSERT into pedidos (dniCliente, nombre, direccion, email, pwd) values ('$this->dniCliente','$this->nombre','$this->direccion', '$this->email','$this->pwd')");
            $consulta->execute();
        } catch (PDOException $e) {
            $dato = "¡Error!: " . $e->getMessage() . "<br/>";
            require "../vistas/mensaje.php";
            die();
        }
    }
    function validar($link)
    {
        $consulta = $link->prepare("SELECT pwd FROM clientes WHERE dniCliente = '$this->dniCliente'");
        $consulta->execute();
    }
}

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
            $consulta = $link->prepare("INSERT into clientes (dniCliente, nombre, direccion, email, pwd) values ('$this->dniCliente','$this->nombre','$this->direccion', '$this->email','$this->pwd')");
            return $consulta->execute();
        } catch (PDOException $e) {
            error_log("Error en guardar: " . $e->getMessage());
            return false;
        }
    }
    function validar($link)
    {
        $consulta = $link->prepare("SELECT pwd FROM clientes WHERE dniCliente = '$this->dniCliente'");
        $consulta->execute();
    }
}

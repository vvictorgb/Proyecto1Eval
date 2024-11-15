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
        $consulta = $link->prepare("INSERT into clientes (dniCliente, nombre, direccion, email, pwd) values ('$this->dniCliente','$this->nombre','$this->direccion', '$this->email','$this->pwd')");
        return $consulta->execute();
    }


    function obtenerPwd($link)
    {
        $consulta = $link->prepare("SELECT pwd FROM clientes WHERE dniCliente = :dniCliente");
        $consulta->bindParam(':dniCliente', $this->dniCliente);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        return $resultado['pwd'];
    }

    function buscar($link)
    {
        $consulta = "SELECT * FROM clientes where dniCliente='$this->dniCliente'";
        $result = $link->prepare($consulta);
        $result->execute();
        return $result->fetch(PDO::FETCH_ASSOC);
    }
}

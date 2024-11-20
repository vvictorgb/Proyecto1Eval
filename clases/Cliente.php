<?php

class Cliente
{
    private $dniCliente;
    function direccionCliente($link)
    {
        $consulta = "SELECT direccion FROM clientes WHERE dniCliente = '$this->dniCliente'";
        $result = $link->prepare($consulta);
        $result->execute();
        $dato = $result->fetch(PDO::FETCH_ASSOC);
        return $dato['direccion'];
    }
    function __construct($dniCliente)
    {
        $this->dniCliente = $dniCliente;
    }
    function __get($var)
    {
        return $this->$var;
    }
}

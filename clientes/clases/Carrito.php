<?php
class Carrito
{
    private $idUnico;
    private $idProducto;
    private $dniCliente;
    private $cantidad;
    function __construct($idUnico, $idProducto, $cantidad, $dniCliente)
    {
        $this->idUnico = $idUnico;
        $this->idProducto = $idProducto;
        $this->dniCliente = $dniCliente;
        $this->cantidad = $cantidad;
    }

    function __get($var)
    {
        return $this->$var;
    }

    function actualizarDniCliente($link)
    {
        $consulta = $link->prepare("UPDATE carrito SET dniCliente = '$this->dniCliente' WHERE idUnico = '$this->idUnico'");
        return $consulta->execute();
    }
}

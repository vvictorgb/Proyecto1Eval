<?php
class Carrito
{
    private $idUnico;
    private $idProducto;
    private $dniCliente;
    private $cantidad;
    function __construct($idUnico, $idProducto, $cantidad, $dniCliente = NULL)
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

    function guardar($link)
    {
        $consulta = $link->prepare("INSERT into carrito (idUnico, idProducto, dniCliente, cantidad) values ('$this->idUnico','$this->idProducto','$this->dniCliente', '$this->cantidad')");
        return $consulta->execute();
    }
    function carritoID($link)
    {
        $consulta = "SELECT * FROM carrito WHERE idUnico ='$this->idUnico'";
        $result = $link->prepare($consulta);
        $result->execute();
        return $result->fetch(PDO::FETCH_ASSOC);
    }
    function eliminarProductoCarrito($link)
    {
        $consulta = $link->prepare("DELETE FROM carrito WHERE idProducto = '$this->idProducto' AND idUnico = '$this->idUnico'");
        return $consulta->execute();
    }
}

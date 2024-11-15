<?php

class Producto
{
    private $idProducto;

    function __construct($idProducto)
    {
        $this->idProducto = $idProducto;
    }

    function buscar($link)
    {
        $consulta = "SELECT * FROM productos where idProducto='$this->idProducto'";
        $result = $link->prepare($consulta);
        $result->execute();
        return $result->fetch(PDO::FETCH_ASSOC);
    }

    static function getAll($link)
    {
        $consulta = $link->prepare("SELECT * FROM productos");
        $consulta->execute();
        return $consulta;
    }
}

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
        try {
            $consulta = "SELECT * FROM productos where idProducto='$this->idProducto'";
            $result = $link->prepare($consulta);
            $result->execute();
            return $result->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $dato = "¡Error!: " . $e->getMessage() . "<br/>";
            return $dato;
            die();
        }
    }
    static function getAll($link)
    {
        $consulta = $link->prepare("SELECT * FROM productos");
        $consulta->execute();
        return $consulta;
    }
}

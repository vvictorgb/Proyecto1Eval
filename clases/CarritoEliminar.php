<?php
class CarritoEliminar
{
    private $idUnico;

    function __construct($idUnico)
    {
        $this->idUnico = $idUnico;
    }

    function __get($var)
    {
        return $this->$var;
    }

    function borrarTodo($link)
    {
        $consulta = "DELETE FROM carrito WHERE idUnico = '$this->idUnico'";
        $resultado = $link->prepare($consulta);
        return $resultado->execute();
    }
}

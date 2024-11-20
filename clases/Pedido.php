<?php
class Pedido
{
    private $idPedido;
    private $fecha;
    private $dniCliente;
    private $dirEntrega;

    function __construct($idPedido, $fecha, $dniCliente, $dirEntrega)
    {
        $this->idPedido = $idPedido;
        $this->fecha = $fecha;
        $this->dniCliente = $dniCliente;
        $this->dirEntrega = $dirEntrega;
    }


    static function obtenerID($link)
    {
        $consulta = "SELECT MAX(idPedido) AS max_id FROM pedidos";
        $resultado = $link->prepare($consulta);
        $resultado->execute();
        $dato = $resultado->fetch(PDO::FETCH_ASSOC);
        return $dato['max_id'];
    }
    function nuevoPedido($link)
    {
        $consulta = "INSERT INTO pedidos (idPedido,fecha,dniCliente,dirEntrega) VALUES('$this->idPedido','$this->fecha','$this->dniCliente','$this->dirEntrega')";
        $resultado = $link->prepare($consulta);
        return $resultado->execute();
    }
}

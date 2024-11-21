<?php
class lineasPedido
{
    private $idPedido;
    private $nlinea;
    private $idProducto;
    private $cantidad;

    function __construct($idPedido, $nlinea, $idProducto, $cantidad)
    {
        $this->idPedido = $idPedido;
        $this->nlinea = $nlinea;
        $this->idProducto = $idProducto;
        $this->cantidad = $cantidad;
    }

    static function InsertarTodas($link, $carrito, $idPedidoInsertar)
    {
        $aux = 0;
        $factura = "";
        $consulta = $link->prepare("INSERT INTO lineaspedidos (idPedido, nlinea, idProducto, cantidad) VALUES (:idPedido, :nlinea, :idProducto, :cantidad)");

        try {
            foreach ($carrito as $value) {
                $aux += 1;

                $idPedido = $idPedidoInsertar;
                $nlinea = $aux;
                $idProducto = $value['idProducto'];
                $cantidad = $value['cantidad'];

                $factura .= "<p>Linea: $nlinea, Id del producto: $idProducto, Cantidad: $cantidad</p><br>";

                $consulta->bindParam(':idPedido', $idPedido);
                $consulta->bindParam(':nlinea', $nlinea);
                $consulta->bindParam(':idProducto', $idProducto);
                $consulta->bindParam(':cantidad', $cantidad);
                $consulta->execute();
            }
            return $factura;
        } catch (Exception $e) {
            echo "Error de ejecución: " . $e->getMessage() . "\n";
        }
    }
}

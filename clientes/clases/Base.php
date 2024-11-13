<?php
include __DIR__ . '/../config/config.php';
class Base
{
    private $link;
    function __construct()
    {

        try {

            $this->link = new PDO("mysql:host=" . HOST . ";dbname=" . BASE, USUARIO, PASS, OPCIONES);
        } catch (PDOException $e) {
            $dato = "¡Error!: " . $e->getMessage() . "<br/>";
            require "vistas/mensaje.php";
            die();
        }
    }

    function __get($var)
    {
        return $this->$var;
    }
}

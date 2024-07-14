<?php


class Conexion
{
    public static function conectar()
    {
        $server = "127.0.0.1";
        $user = "root";
        $pass = "";
        $db = "RESERVA";
        $stringconnection = mysqli_connect($server, $user, $pass, $db);
        return $stringconnection;}
}
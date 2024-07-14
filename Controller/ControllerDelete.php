<?php

if ($_POST['form'] == 'deleteRut') {
    echo "<a href='../index.php' >Volver al Inicio</a> <br> </br>";
    echo "<a href='../View/ListadoReservas.php' >Volver al Listado</a> <br> </br>";
    include('../Model/ModelCRUDReserva.php');
    $rut = $_POST['rut'];
    $objdeleterut = new ModelCRUDReserva();
    $respuesta = $objdeleterut->DeleteRut($rut);
    echo "Reserva Eliminada";
}
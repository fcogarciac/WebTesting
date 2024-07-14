<?php

include('../View/ActualizaReserva.php');

$_POST['nac']++;
$men = '';

if (isset($_POST['form']) && $_POST['form'] == 'UpdateRut') {
    $men = "";
    if (empty($_POST['rut']) || ($_POST['rut'] < 1)) {
        $men .= "Falta completar el RUT.<br>";
    }
    if
    (empty($_POST['ape'])) {
        $men .= "Falta ingresar el apellido.<br>";
    }
    if
    (!isset($_POST['nac']) && empty($_POST['nac'])) {
        $men .= "Falta ingresar el numero de acompañantes.<br>";
    }
    if (empty($_POST['diasres']) || ($_POST['diasres'] < 1)) {
        $men .= "Falta ingresar la cantidad de días de la reserva.<br>";
    }
    if
    (empty($_POST['fecinicio'])) {
        $men .= "Falta ingresar la fecha de inicio de la reserva .<br>";
    }
    if (empty($_POST['tamcab']) || ($_POST['tamcab'] < 1)) {
        $men .= "Falta ingresar el tamaño de la cabaña.<br>";
    }
}

echo "<a href='../index.php'>Volver al Inicio</a> <br> </br>";

if (!empty($men)) {
    echo "<a href='../View/ListadoReservas.php' >Volver atrás</a>";
    echo "<br>";
    echo "1er if de validacion";
    $men .= "<br> Debe ingresar todos los datos correctamente. ";
} else {
    $maxocupacion = [
        4 => 4,
        8 => 8,
        12 => 12
    ];

    $tipocabaña = $_POST['tamcab'];

    if (array_key_exists($tipocabaña, $maxocupacion)) {
        echo "2 if valida cabaña";
        $cantpersonas = $_POST['nac'];
        $capacidad_maxima = $maxocupacion[$tipocabaña];

        if ($cantpersonas > $capacidad_maxima) {
            echo "3 if valida capacidad";
            echo "<a href='../index.php'>Volver al inicio</a> <br> </br>";
            $men .= "La cantidad de usuarios supera la capacidad máxima de $capacidad_maxima, seleccione una cabaña con más capacidad.<br>";
            echo "++ No se ingresa ++";
            echo $cantpersonas;
        } else {
            echo "<a href='../index.php'>Volver al inicio</a> <br> </br>";
            include('../Model/ModelCRUDReserva.php');
            $rut = $_POST['rut'];
            $nom = $_POST['nom'];
            $ape = $_POST['ape'];
            $nac = $_POST['nac'];
            $diasres = $_POST['diasres'];
            $fecinicio = $_POST['fecinicio'];
            $tamcab = $_POST['tamcab'];
            $objactualiza = new ModelCRUDReserva();

            // Verificación de disponibilidad
            if ($objactualiza->ValidaFecha($fecinicio, $diasres, $tamcab)) {
                echo "3 if disponibilidad";
                $respuesta = $objactualiza->UpdateReserva($rut, $nom, $ape, $nac, $diasres, $fecinicio, $tamcab);
                echo $respuesta;
            } else {
                $men .= "Las fechas seleccionadas ya están reservadas. Por favor, elija otras fechas.<br>";
            }
        }
    }
}

print $men;

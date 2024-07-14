
<?php
include('../Model/ModelCRUDReserva.php');
$_POST['filtro']=isset($_POST['filtro']) ? $_POST['filtro'] : '';;
$objlistado = new ModelCRUDReserva();
$returnlistado = $objlistado->ListadoReservas($_POST['filtro']);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Listado de Reservas</title>
</head>
<a href='../index.php'>Volver al inicio</a> <br> </br>
<h1> Listado de reservas</h1>

<a>Buscar por tipo de cabaña</a>
<?php

$objlistcab = new ModelCRUDReserva();
$respuesta = $objlistcab->ListadoCabañas(); ?>

<form action="ListadoReservas.php" name="filtro" method="post">
    <select name="filtro" id="filtro"> <?php
        foreach ($respuesta as $value) {

            echo "<option name='tamcab' value='" . $value['VCH_CABAÑA_SOLICITANTE'] . "'>" . $value['VCH_CABAÑA_SOLICITANTE'] . "</option>";
        } ?>
        <option name="tamcab" value='' selected>Todas las cabañas</option>
    </select>
    <button type="submit" name="form" value="filtro">Filtrar</button>

</form>
<br>


<body>
<table border="1">
    <tr>
        <td>Rut Solicitante</td>
        <td>Rut</td>
        <td>Nombre</td>
        <td>Apellido</td>
        <td>N. de Acompañantes</td>
        <td>Días de arriendo</td>
        <td>Fech de inicio</td>
        <td>Fech de Termino</td>
        <td>Tamaño de cabaña</td>
        <td>Eliminar</td>
        <td>Actualizar</td>
    </tr>

    <?php foreach ($returnlistado as $value) :
        $fechainicial = $value['DATE_FECHA_INICIO_SOLICITANTE'];
        $dias = (int)$value['INT_CAT_DIAS_SOLICITANTE'];
        $fecha = new DateTime($fechainicial);
        $fecha->modify("+$dias days");
        $fechafinal = $fecha->format('d-m-Y');
        $feciniformato = (new DateTime($fechainicial))->format('d-m-Y')
        ?>
        <tr>
            <td><?= $value['RUT_SOLICITANTE'] ?></td>
            <td><?= $value['VCH_DV_SOLICITANTE'] ?></td>
            <td><?= $value['VCH_NOMBRES_SOLICITANTE'] ?></td>
            <td><?= $value['VCH_APELLIDOS_SOLICITANTE'] ?></td>
            <td><?= $value['INT_CAT_ACOM_SOLICITANTE'] ?></td>
            <td><?= $value['INT_CAT_DIAS_SOLICITANTE'] ?></td>
            <td><?= $feciniformato ?></td>
            <td><?= $fechafinal ?></td>
            <td><?= $value['VCH_CABAÑA_SOLICITANTE'] ?></td>
            <td align="center">
                <form action="../Controller/ControllerDelete.php" method="post">
                    <input type="hidden" name="rut" value="<?= $value['RUT_SOLICITANTE'] ?>">
                    <button type="submit" name="form" value="deleteRut">Eliminar</button>
                </form>
            </td>
            <td align="center">
                <form action="../Controller/ControllerUpdate.php" method="post">
                    <input type="hidden" name="rut" value="<?= $value['RUT_SOLICITANTE'] ?>">
                    <button type="submit" name="form" value="UpdateRut">Actualizar</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
</body>
</html>

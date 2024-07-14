<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reservas</title>
</head>
<a href='../index.php'>Volver al inicio</a> <br><br>
<body>
<form action="../Controller/ControllerInsert.php" method="post">
    <table border="1">
        <tr>
            <td colspan="3" align="center">
                Formulario de Reservas
            </td>
        </tr>
        <tr>
            <td>
                rut solicitante
            </td>
            <td>
                <input type="number" name="rut" id="rut" min="1">
            </td>
            <td>
                <input type="text" name="dv" id="dv" placeholder="Ingrese el DV">
            </td>
        </tr>
        <tr>
            <td>
                Nombres
            </td>
            <td>
                <input type="text" name="nom" id="nom">
            </td>
        </tr>
        <tr>
            <td>
                Apellidos
            </td>
            <td>
                <input type="text" name="ape" id="ape">
            </td>
        </tr>
        <tr>
            <td>
                Cantidad de acompañantes
            </td>
            <td>
                <input type="number" name="nac" id="nac" min="0" value="0">
            </td>
        </tr>
        <tr>
            <td>
                Cantidad de días
            </td>
            <td>
                <input type="number" name="diasres" id="diasres" min="1">
            </td>
        </tr>
        <tr>
            <td>
                Fecha de inicio
            </td>
            <td>
                <input type="date" name="fecinicio" id="fecinicio" min="<?php echo date("Y-m-d"); ?>">
            </td>
        </tr>
        <tr>
            <td>
                Tamaño de la cabaña
            </td>
            <td>
                <select name="tamcab">
                    <option name="tamcab" value="4">
                        Pequeña - hasta 4 personas
                    </option>
                    <option name="tamcab" value="8">
                        Mediana - hasta 8 personas
                    </option>
                    <option name="tamcab" value="12">
                        Grande - hasta 12 personas
                    </option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="3" align="center">
                <button type="submit" name="form" value="insertReserva">Ingresar</button>
            </td>
        </tr>
    </table>
</form>
</body>
</html>

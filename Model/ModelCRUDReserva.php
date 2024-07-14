<?php

include('Conexion.php');

class ModelCRUDReserva
{
    public function InsertReserva($rut, $dv, $nom, $ape, $nac, $diasres, $fecinicio, $tamcab)
    {
        $stringconnection = Conexion::conectar();

        try {
            $query = "INSERT INTO tbl_reserva(RUT_SOLICITANTE, VCH_DV_SOLICITANTE, VCH_NOMBRES_SOLICITANTE, VCH_APELLIDOS_SOLICITANTE, 
                          INT_CAT_ACOM_SOLICITANTE, INT_CAT_DIAS_SOLICITANTE, DATE_FECHA_INICIO_SOLICITANTE, VCH_CABAÑA_SOLICITANTE) 
                          VALUES ('$rut','$dv','$nom','$ape','$nac','$diasres','$fecinicio','$tamcab');";
            $control = mysqli_query($stringconnection, $query);

            if (!$control) {
                if (mysqli_errno($stringconnection) == 1062) {
                    throw new Exception("El RUT ya está registrado en el sistema." . mysqli_error($stringconnection));
                } else {
                    throw new Exception("Error al insertar la reserva: " . mysqli_error($stringconnection));
                }
            }
            mysqli_commit($stringconnection);
            echo "<br>";
            echo "Se ingresa Reserva:<br><br>";
            echo "Rut: $rut<br>";
            echo "DV: $dv<br>";
            echo "Nombre: $nom<br>";
            echo "Apellido: $ape<br>";
            echo "Número de acompañantes: $nac<br>";
            echo "Días de reserva: $diasres<br>";
            echo "Fecha de inicio: $fecinicio<br>";
            echo "Tamaño de la cabaña: $tamcab<br><br>";
            return "Reserva ingresada con éxito";

        } catch (Exception $e) {
            mysqli_rollback($stringconnection);
            return "Rut ya tiene asignada una reservación<br> " . $e->getMessage();
        } finally {
            mysqli_close($stringconnection);
        }
    }

    public function UpdateReserva($rut, $nom, $ape, $nac, $diasres, $fecinicio, $tamcab)
    {
        $stringconnection = Conexion::conectar();

        try {
            // Verificar disponibilidad de fechas
            if ($this->ValidaFecha($fecinicio, $diasres, $tamcab)) {
                // Verificar capacidad de la cabaña
                $maxocupacion = [
                    4 => 4,
                    8 => 8,
                    12 => 12
                ];

                if ($nac > $maxocupacion[$tamcab]) {
                    throw new Exception("La cantidad de acompañantes supera la capacidad máxima de la cabaña.");
                }

                $query = "UPDATE tbl_reserva 
                          SET VCH_NOMBRES_SOLICITANTE = '$nom', 
                              VCH_APELLIDOS_SOLICITANTE = '$ape', 
                              INT_CAT_ACOM_SOLICITANTE = '$nac', 
                              INT_CAT_DIAS_SOLICITANTE = '$diasres', 
                              DATE_FECHA_INICIO_SOLICITANTE = '$fecinicio', 
                              VCH_CABAÑA_SOLICITANTE = '$tamcab' 
                          WHERE RUT_SOLICITANTE = '$rut';";
                $result = mysqli_query($stringconnection, $query);

                if (!$result) {
                    throw new Exception("Error al actualizar la reserva: " . mysqli_error($stringconnection));
                }

                mysqli_commit($stringconnection);
                return "Reserva actualizada con éxito";
            } else {
                throw new Exception("Las fechas seleccionadas ya están reservadas. Por favor, elija otras fechas.");
            }

        } catch (Exception $e) {
            mysqli_rollback($stringconnection);
            return $e->getMessage();
        } finally {
            mysqli_close($stringconnection);
        }
    }


    public function ListadoReservas($cab = false)

    {
        $stringconnection = Conexion::conectar();

        if (empty($_POST['filtro'])) {
            $query = "select * from tbl_reserva";
            $result = mysqli_query($stringconnection, $query);
        } else {
            $query = "select * from tbl_reserva where VCH_CABAÑA_SOLICITANTE = '$cab'";
            $result = mysqli_query($stringconnection, $query);
        }


        return $result;

    }

    public function DeleteRut($rut)
    {
        $stringconnection = Conexion::conectar();

        $query = ("delete from tbl_reserva where RUT_SOLICITANTE = '$rut';");
        $result = mysqli_query($stringconnection, $query);
        mysqli_commit($stringconnection);
        mysqli_close($stringconnection);
        return $result;
    }

    public function ListadoCabañas()
    {
        $stringconnection = Conexion::conectar();

        $query = "select distinct VCH_CABAÑA_SOLICITANTE from tbl_reserva";

        $result = mysqli_query($stringconnection, $query);
        return $result;
    }
    public function BuscaRut($rut)
    {
        $stringconnection = Conexion::conectar();

        $query = "select * from tbl_reserva where RUT_SOLICITANTE = '$rut'";

        $result = mysqli_query($stringconnection, $query);
        return $result;
    }

    public function ValidaFecha($fecinicio, $diasres, $tamcab)
    {
        $stringconnection = Conexion::conectar();

        $fecfin = date('Y-m-d', strtotime($fecinicio . ' + ' . $diasres . ' days'));

        $query = "SELECT COUNT(*) AS count FROM tbl_reserva
                  WHERE VCH_CABAÑA_SOLICITANTE = '$tamcab'
                  AND ('$fecinicio' <= DATE_ADD(DATE_FECHA_INICIO_SOLICITANTE, INTERVAL INT_CAT_DIAS_SOLICITANTE DAY)
                  AND '$fecfin' >= DATE_FECHA_INICIO_SOLICITANTE)";

        $result = mysqli_query($stringconnection, $query);

        if (!$result) {
            throw new Exception("Error en la consulta de validación de fechas: " . mysqli_error($stringconnection));
        }

        $row = mysqli_fetch_assoc($result);

        return $row['count'] == 0;

    }

}

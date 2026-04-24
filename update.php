<?php
include("../con_varios.php");
$datos = sqlsrv_query($conn,"Select * from gr_roedores");
/*function convertir_fecha($fecha_string) {
    $fecha = DateTime::createFromFormat('d/m/Y', $fecha_string);
    if (!$fecha) {
        return "Fecha inválida";
    } else {
        return $fecha->format('Y-m-d');
    }
}
while($reg = sqlsrv_fetch_array($datos))
{
    echo "<br>".$reg[1];
    try{
        $fecha_ingresada = $reg[1];
        $fecha_formateada = convertir_fecha($fecha_ingresada);
        $id = $reg[0];
        sqlsrv_query($conn,"Update gr_roedores set fecha_real='$fecha_formateada' where id='$id'");
        echo "  ---------- ".$fecha_formateada;
    }
    catch (Exception $e){
        echo "--------- sin fecha".$e->getMessage();
    }
}*/
echo date("Y-m-d");
?>
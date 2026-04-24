<?php
// Conexión a la base de datos SQL Server
include("../con_varios.php");

if ($conn === false) {
    die(json_encode(array("mensaje" => "Error en la conexión con la base de datos")));
}

// Leer la entrada JSON
$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    echo json_encode(array("mensaje" => "No se recibió ningún dato"));
    exit;
}
function convertir_fecha($fecha_string) {
    $fecha = DateTime::createFromFormat('d/m/Y', $fecha_string);
    if (!$fecha) {
        return "Fecha inválida";
    } else {
        return $fecha->format('Y-m-d');
    }
}
// Preparar la consulta SQL para insertar datos
$sql = "INSERT INTO GR_medicacion (fecha, lote, edad, galpon, etapa, animales_tratador, producto, via_admin, dosis, total_dos, responsable, usuario,fecha_real) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$insertCount = 0; // Contador de registros insertados correctamente
foreach ($data as $row) {
    if($row['fecha']==""){
        $fecha = date("Y-m-d");
    }else{
        try{
            $fecha_ingresada = $row['fecha'];
            $fecha = convertir_fecha($fecha_ingresada);
        }
        catch (Exception $e){
            $fecha = date("Y-m-d");
        }
    }
    $params = array(
        $row['fecha'], $row['lote'], $row['edad'], 
        $row['galpon'], $row['etapa'], $row['animales_tratados'], 
        $row['producto'], $row['via_adm'], $row['dosis'], 
        $row['total_dos'], $row['responsable'],$row['usuario'],$fecha
    );

    $stmt = sqlsrv_query($conn, $sql, $params);
    if ($stmt === false) {
        echo json_encode(array("mensaje" => "Error al insertar los datos"));
        exit;
    }
    $insertCount++;
}

// Verificar si se insertaron registros
if ($insertCount > 0) {
    echo json_encode(array("mensaje" => "correcto"));
} else {
    echo json_encode(array("mensaje" => "No se insertó ningún registro"));
}

sqlsrv_close($conn);
?>

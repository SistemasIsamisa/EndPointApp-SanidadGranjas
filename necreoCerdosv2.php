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

// Ruta donde se guardarán las imágenes en el servidor
$uploadDir = "../uploads/necroCerdos/";
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true); // Crear el directorio si no existe
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
$sql = "INSERT INTO GR_necroCerdos 
    (fecha, granja, realizado, lote, edad, diagnostico, obs, foto1, foto2, foto3, usuario,fecha_real) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

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
    // Procesar y guardar las imágenes en el servidor
    $foto1Path = saveImage($row['foto1'], $uploadDir, 'foto1_' . uniqid());
    $foto2Path = saveImage($row['foto2'], $uploadDir, 'foto2_' . uniqid());
    $foto3Path = saveImage($row['foto3'], $uploadDir, 'foto3_' . uniqid());

    // Parámetros para la inserción en la base de datos
    $params = array(
        $row['fecha'], $row['granja'], $row['realizado'], 
        $row['lote'], $row['edad'], $row['diagnostico'], 
        $row['obs'], $foto1Path, $foto2Path, $foto3Path, 
        $row['usuario'],$fecha
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

// Cerrar la conexión a la base de datos
sqlsrv_close($conn);

// Función para guardar una imagen desde una cadena Base64
function saveImage($base64String, $uploadDir, $fileName) {
    if (empty($base64String)) {
        return null; // Si la imagen está vacía, no guardar nada
    }
    
    // Decodificar la cadena Base64
    $imageData = base64_decode($base64String);
    if ($imageData === false) {
        return null; // Error al decodificar la imagen
    }

    // Crear la ruta completa del archivo
    $filePath = $uploadDir . $fileName . '.jpg';

    // Guardar la imagen en el servidor
    file_put_contents($filePath, $imageData);

    // Devolver la ruta del archivo guardado
    return $filePath;
}
?>

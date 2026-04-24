<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    // Si es una solicitud OPTIONS, devolver solo los encabezados y salir.
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");
    exit(0);
}
$jsonData = file_get_contents('php://input');
if ($jsonData === false) {
    $response = array('status' => 'error', 'message' => 'No se pudieron obtener los datos JSON');
    echo json_encode($response);
    exit;
}
$dvalor = json_decode($jsonData, true);

if ($dvalor === null) {
    $response = array('status' => 'error', 'message' => 'No se pudieron decodificar los datos JSON');
    echo json_encode($response);
    exit;
}
$token = $dvalor['token'];
//$pass = $dvalor['pass'];
$usuario = "Daluc";
$fecha = "2024-09-22";
$syn = "N";
if($token != "1234567")
{
    $response = array('status' => 'error', 'message' => 'Error de token - sin autorización');
    echo json_encode($response);
    exit;
}
include("../maria_con.php"); // nuevo archivo de conexión

$stmt2 = $conexion->query("SELECT id,usuario,passwd,sincronice FROM GR_usuarios");
$result = $stmt2->fetchAll(PDO::FETCH_OBJ);

$data = [];

foreach($result as $item)
{
    $valores = [
        "id" => $item->id,
        "usuario" => $item->usuario,
        "pass" => $item->passwd,
        "sync" => $item->sincronice
    ];
    $data[] = $valores;
}

header('Content-type:application/json;charset=utf-8');
echo json_encode($data, JSON_PRETTY_PRINT);
    /*$stmt = $conexion->prepare("INSERT INTO APP_users (usuario,passwd,xlastuser,xlastdate,sincronice) VALUES (:usuario, :passwd, :xlastuser, :xlastdate, :sincronice)");
    $stmt->bindParam(':usuario', $user);
    $stmt->bindParam(':passwd', $pass);
    $stmt->bindParam(':xlastuser', $user);
    $stmt->bindParam(':xlastdate', $fecha);
    $stmt->bindParam(':sincronice', $syn);
    $stmt = $conexion->prepare("insert into logs (dato,fecha) VALUES(:token, now())");
    $stmt->bindParam(':token', $token);
    $stmt->execute(); */
?>
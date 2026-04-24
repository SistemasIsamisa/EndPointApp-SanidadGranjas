<?php
include("../con_varios.php");

if ($conn === false) {
    die(json_encode(array("mensaje" => "Error en la conexión con la base de datos")));
}

$data = json_decode(file_get_contents('php://input'), true);
if (!$data) {
    echo json_encode(array("mensaje" => "No se recibió ningún dato"));
    exit;
}

$uploadDir = "../uploads/vr_faenamiento/";
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

function convertir_fecha($fecha_string) {
    $fecha = DateTime::createFromFormat('d/m/Y', $fecha_string);
    if (!$fecha) return null;
    return $fecha->format('Y-m-d');
}

function saveImage($base64String, $uploadDir, $fileName) {
    if (empty($base64String)) return null;

    $imageData = base64_decode($base64String);
    if ($imageData === false) return null;

    $filePath = $uploadDir . $fileName . '.jpg';
    file_put_contents($filePath, $imageData);
    return $filePath;
}

$sql = "INSERT INTO dbo.GR_vr_faenamiento (
            fecha, nombre_evaluador, planta_faenamiento,
            densidad_jabas_ok, sin_signos_enfermedad, zonas_operacion_completas, areas_equipos_limpios_poes,
            grifos_operativos_presion, lavamanos_desinfectante_ok, pediluvios_desinfectante_ok, personal_capac_salud_indum,
            control_cloro_residual, iluminacion_suficiente, agua_escaldado_cambio_diario, eviscerado_sin_ruptura_digestiva,
            poes_registros_actualizados, chiller_limpieza_temp_0a4, camara_temp_registros_ok, camara_tamano_distrib_ok,
            bpm_cumplimiento_manual, aturdimiento_amb_oscuro_param, sangrado_10a15s_dur_60a200, escaldado_temp_50a65_dur_ok,
            maquina_peladora_rev_limp, agua_presion_remueve_contam, vet_inspeccion_postmortem_reg, reg_puntos_criticos_completo,
            comisos_condenas_manejo_ok, despacho_vehiculos_temp_ok,
            observaciones, foto1, foto2, foto3, usuario
        ) VALUES (
            ?, ?, ?,
            ?, ?, ?, ?,
            ?, ?, ?, ?,
            ?, ?, ?, ?,
            ?, ?, ?, ?,
            ?, ?, ?, ?,
            ?, ?, ?, ?,
            ?, ?,
            ?, ?, ?, ?,
            ?
        )";

$insertCount = 0;

foreach ($data as $row) {

    // Fecha
    if (!isset($row['fecha']) || $row['fecha'] === "") {
        $fecha_db = date("Y-m-d");
    } else {
        $fecha_tmp = convertir_fecha($row['fecha']);
        $fecha_db = $fecha_tmp ? $fecha_tmp : date("Y-m-d");
    }

    // Fotos
    $foto1Path = saveImage($row['foto1'] ?? null, $uploadDir, 'foto1_' . uniqid());
    $foto2Path = saveImage($row['foto2'] ?? null, $uploadDir, 'foto2_' . uniqid());
    $foto3Path = saveImage($row['foto3'] ?? null, $uploadDir, 'foto3_' . uniqid());

    $params = array(
        $fecha_db,
        $row['nombre_evaluador'] ?? null,
        $row['planta_faenamiento'] ?? null,

        $row['densidad_jabas_ok'] ?? null,
        $row['sin_signos_enfermedad'] ?? null,
        $row['zonas_operacion_completas'] ?? null,
        $row['areas_equipos_limpios_poes'] ?? null,

        $row['grifos_operativos_presion'] ?? null,
        $row['lavamanos_desinfectante_ok'] ?? null,
        $row['pediluvios_desinfectante_ok'] ?? null,
        $row['personal_capac_salud_indum'] ?? null,

        $row['control_cloro_residual'] ?? null,
        $row['iluminacion_suficiente'] ?? null,
        $row['agua_escaldado_cambio_diario'] ?? null,
        $row['eviscerado_sin_ruptura_digestiva'] ?? null,

        $row['poes_registros_actualizados'] ?? null,
        $row['chiller_limpieza_temp_0a4'] ?? null,
        $row['camara_temp_registros_ok'] ?? null,
        $row['camara_tamano_distrib_ok'] ?? null,

        $row['bpm_cumplimiento_manual'] ?? null,
        $row['aturdimiento_amb_oscuro_param'] ?? null,
        $row['sangrado_10a15s_dur_60a200'] ?? null,
        $row['escaldado_temp_50a65_dur_ok'] ?? null,

        $row['maquina_peladora_rev_limp'] ?? null,
        $row['agua_presion_remueve_contam'] ?? null,
        $row['vet_inspeccion_postmortem_reg'] ?? null,
        $row['reg_puntos_criticos_completo'] ?? null,

        $row['comisos_condenas_manejo_ok'] ?? null,
        $row['despacho_vehiculos_temp_ok'] ?? null,

        $row['observaciones'] ?? null,
        $foto1Path,
        $foto2Path,
        $foto3Path,
        $row['usuario'] ?? null
    );

    $stmt = sqlsrv_query($conn, $sql, $params);
    if ($stmt === false) {
        echo json_encode(array("mensaje" => "Error al insertar los datos", "error" => sqlsrv_errors()));
        exit;
    }

    $insertCount++;
}

echo json_encode(array("mensaje" => $insertCount > 0 ? "correcto" : "No se insertó ningún registro"));
sqlsrv_close($conn);
?>
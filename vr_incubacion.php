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

$uploadDir = "../uploads/vr_incubacion/";
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

$sql = "INSERT INTO dbo.GR_vr_incubacion (
            fecha, nombre_evaluador, planta_incubacion,
            aislamiento_instal_ok, cerco_perimetrico, ctrl_reg_ing_personas, desinf_veh_eq_mat_ing,
            duchas_personal_visitas, agua_caliente_disp, cambio_ropa_ing,
            prog_limp_desinf_incubadoras, prog_limp_desinf_nacedoras, prog_limp_desinf_ambientes,
            monit_micro_incub_naced_amb_2m, ctrl_plagas_integral, ss_hh_limp_conserv, cap_personal_bpm,
            reg_ing_sal_prod_avic, agua_abast_sanit_sem_anal_2a, manejo_desechos_bpm, desagues_adecuados,
            verif_calidad_vacun_reg, verif_calidad_ave_bb_reg, embriodiagnosis_proc_reg,
            observaciones, foto1, foto2, foto3, usuario
        ) VALUES (
            ?, ?, ?,
            ?, ?, ?, ?,
            ?, ?, ?,
            ?, ?, ?,
            ?, ?, ?, ?,
            ?, ?, ?, ?,
            ?, ?, ?,
            ?, ?, ?, ?,
            ?
        )";

$insertCount = 0;

foreach ($data as $row) {
    if (!isset($row['fecha']) || $row['fecha'] === "") {
        $fecha_db = date("Y-m-d");
    } else {
        $fecha_tmp = convertir_fecha($row['fecha']);
        $fecha_db = $fecha_tmp ? $fecha_tmp : date("Y-m-d");
    }

    $foto1Path = saveImage($row['foto1'] ?? null, $uploadDir, 'foto1_' . uniqid());
    $foto2Path = saveImage($row['foto2'] ?? null, $uploadDir, 'foto2_' . uniqid());
    $foto3Path = saveImage($row['foto3'] ?? null, $uploadDir, 'foto3_' . uniqid());

    $params = array(
        $fecha_db,
        $row['nombre_evaluador'] ?? null,
        $row['planta_incubacion'] ?? null,

        $row['aislamiento_instal_ok'] ?? null,
        $row['cerco_perimetrico'] ?? null,
        $row['ctrl_reg_ing_personas'] ?? null,
        $row['desinf_veh_eq_mat_ing'] ?? null,

        $row['duchas_personal_visitas'] ?? null,
        $row['agua_caliente_disp'] ?? null,
        $row['cambio_ropa_ing'] ?? null,

        $row['prog_limp_desinf_incubadoras'] ?? null,
        $row['prog_limp_desinf_nacedoras'] ?? null,
        $row['prog_limp_desinf_ambientes'] ?? null,

        $row['monit_micro_incub_naced_amb_2m'] ?? null,
        $row['ctrl_plagas_integral'] ?? null,
        $row['ss_hh_limp_conserv'] ?? null,
        $row['cap_personal_bpm'] ?? null,

        $row['reg_ing_sal_prod_avic'] ?? null,
        $row['agua_abast_sanit_sem_anal_2a'] ?? null,
        $row['manejo_desechos_bpm'] ?? null,
        $row['desagues_adecuados'] ?? null,

        $row['verif_calidad_vacun_reg'] ?? null,
        $row['verif_calidad_ave_bb_reg'] ?? null,
        $row['embriodiagnosis_proc_reg'] ?? null,

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
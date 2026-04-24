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

$uploadDir = "../uploads/vr_aves/";
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

$sql = "INSERT INTO dbo.GR_vr_aves (
            fecha, nombre_evaluador, granja_repr_aves,
            aislamiento_instal_ok, cerco_perimetrico, ctrl_reg_ing_personas, desinf_veh_eq_mat_ing,
            duchas_personal_visitas, agua_caliente_disp, cambio_ropa_calzado_ing, instal_facil_hig_orden,
            prot_galpon_agua_alim_aves_silv, sin_otras_especies_dom, ctrl_plagas_integral, prog_limp_desinf,
            agua_abast_sanit_sem_anal_2a, monit_serol_mg_ms_salmon_4a, area_necropsia_equip_ok, manejo_aves_muertas_desechos_ok,
            ss_hh_limp_conserv, cap_personal_bpm_2m, reg_ocurr_sanit, almac_huevos_prot_desinf,
            aves_salud_manejo_ok, reg_ing_sal_prod_avic, desagues_adecuados, pediluvio_por_area, reg_vacun_despar_prog,
            observaciones, foto1, foto2, foto3, usuario
        ) VALUES (
            ?, ?, ?,
            ?, ?, ?, ?,
            ?, ?, ?, ?,
            ?, ?, ?, ?,
            ?, ?, ?, ?,
            ?, ?, ?, ?,
            ?, ?, ?, ?, ?,
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
        $row['granja_repr_aves'] ?? null,

        $row['aislamiento_instal_ok'] ?? null,
        $row['cerco_perimetrico'] ?? null,
        $row['ctrl_reg_ing_personas'] ?? null,
        $row['desinf_veh_eq_mat_ing'] ?? null,

        $row['duchas_personal_visitas'] ?? null,
        $row['agua_caliente_disp'] ?? null,
        $row['cambio_ropa_calzado_ing'] ?? null,
        $row['instal_facil_hig_orden'] ?? null,

        $row['prot_galpon_agua_alim_aves_silv'] ?? null,
        $row['sin_otras_especies_dom'] ?? null,
        $row['ctrl_plagas_integral'] ?? null,
        $row['prog_limp_desinf'] ?? null,

        $row['agua_abast_sanit_sem_anal_2a'] ?? null,
        $row['monit_serol_mg_ms_salmon_4a'] ?? null,
        $row['area_necropsia_equip_ok'] ?? null,
        $row['manejo_aves_muertas_desechos_ok'] ?? null,

        $row['ss_hh_limp_conserv'] ?? null,
        $row['cap_personal_bpm_2m'] ?? null,
        $row['reg_ocurr_sanit'] ?? null,
        $row['almac_huevos_prot_desinf'] ?? null,

        $row['aves_salud_manejo_ok'] ?? null,
        $row['reg_ing_sal_prod_avic'] ?? null,
        $row['desagues_adecuados'] ?? null,
        $row['pediluvio_por_area'] ?? null,
        $row['reg_vacun_despar_prog'] ?? null,

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
<!doctype html>
<?php
date_default_timezone_set('America/Lima');
?>
<html>
<head>
    <meta charset="utf-8">
    <title>Lista de precios</title>
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <!-- DataTables Export Buttons CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
    <style>
        /* Ajustar las imágenes dentro de las celdas */
        img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            border: 1px solid #ddd;
            padding: 2px;
            box-sizing: border-box;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            text-align: center;
            vertical-align: middle;
        }
    </style>
</head>
<body>
<div align="center">
    <table id="tablaReporte" class="display nowrap" style="width:100%" border="1">
        <thead>
            <tr>
                <?php
                $reporte = $_POST["origen"];
                $fechai = $_POST["fechaInicio"];
                $fechaf = $_POST["fechaFin"];
                include("../con_varios.php");

                switch ($reporte) {
                    case "insectos":
                        echo "
                            <th>id</th>
                            <th>Fecha</th>
                            <th>Granja</th>
                            <th>Area</th>
                            <th>Galpon-ubicación</th>
                            <th>Tipodetrampa</th>
                            <th>Cantidaddetrampas</th>
                            <th>Producto</th>
                            <th>Dosis</th>
                            <th>Totalusoproducto(kg-L)</th>
                            <th>Grado de infestación</th>
                            <th>Responsable</th>
                            <th>Observaciones</th>";
                        $query = "SELECT id, fecha_real, granja, area, galpon, t_trampa, c_trampa, producto, dosis, total, grado, responsable, obs FROM GR_insectos where fecha_real between '$fechai' and '$fechaf'";
                        break;
                    case "medicacion":
                        echo "
                            <th>id</th> 
                            <th>Fecha</th>
                            <th>Lote</th>
                            <th>Edad (sem)</th>
                            <th>Galpon</th>
                            <th>Etapa</th>
                            <th>Animales tratados</th>
                            <th>Producto</th>
                            <th>Via de administración</th>
                            <th>Dosis</th>
                            <th>Total Dosificación</th>
                            <th>Responsable</th> ";
                        $query = "SELECT id, fecha_real, lote, edad, galpon, etapa, animales_tratador, producto, via_admin, dosis, total_dos, responsable FROM GR_medicacion where fecha_real between '$fechai' and '$fechaf'";
                        break;
                    case "roedores":
                        echo "
                            <th>id</th> 
                            <th>Fecha</th>  
                            <th>Granja</th>
                            <th>Area</th>
                            <th>Galpon-ubicación</th>
                            <th>Cebadero 1</th>
                            <th>Cebadero 2</th>
                            <th>Cebadero 3</th>
                            <th>Cebadero 4</th>
                            <th>Cebadero 5</th>
                            <th>Cebadero 6</th>
                            <th>Cebadero 7</th>
                            <th>Cebadero 8</th>
                            <th>Cebadero 9</th>
                            <th>Cebadero 10</th>
                            <th>Cebadero 11</th>
                            <th>Cebadero 12</th>
                            <th>Producto</th>
                            <th>Dosificación</th>
                            <th>Total uso producto (L/Kg)</th>
                            <th>Responsable</th>
                            <th>Observaciones</th> ";
                        $query = "SELECT id, fecha_real, granja, area, galpon, ceb1, ceb2, ceb3, ceb4, ceb5, ceb6, ceb7, ceb8, ceb9, ceb10, ceb11, ceb12, producto, dosis, total, responsable, obs FROM GR_roedores where fecha_real between '$fechai' and '$fechaf'";
                        break;
                    case "aves":
                        echo "
                            <th>ID</th>
                            <th>Fecha</th>
                            <th>Granja</th>
                            <th>Realizado por</th>
                            <th>Lote</th>
                            <th>Edad (Sem)</th>
                            <th>Diagnóstico</th>
                            <th>Observaciones</th>
                            <th>Imagen 1</th>
                            <th>Imagen 2</th>
                            <th>Imagen 3</th>";
                        $query = "SELECT id, fecha_real, granja, realizado, lote, edad, diagnostico, obs, foto1, foto2, foto3 FROM GR_necroAves where fecha_real between '$fechai' and '$fechaf'";
                        break;
                    case "cerdos":
                        echo "
                            <th>ID</th>
                            <th>Fecha</th>
                            <th>Granja</th>
                            <th>Realizado por</th>
                            <th>Lote</th>
                            <th>Edad (Sem)</th>
                            <th>Diagnóstico</th>
                            <th>Observaciones</th>
                            <th>Imagen 1</th>
                            <th>Imagen 2</th>
                            <th>Imagen 3</th>";
                        $query = "SELECT id, fecha_real, granja, realizado, lote, edad, diagnostico, obs, foto1, foto2, foto3 FROM GR_necroCerdos where fecha_real between '$fechai' and '$fechaf'";
                        break;
                    case "vr_plincubacion":
                        echo "
                            <th>ID</th>
                            <th>Fecha</th>
                            <th>Nombre Evaluador</th>
                            <th>Planta Incubación</th>

                            <th>Aislamiento de instalación adecuado</th>
                            <th>Cerco perimétrico</th>
                            <th>Control y registro de ingreso de personas</th>
                            <th>Desinfección de vehículos/equipos/materiales antes de ingresar</th>
                            <th>Duchas para personal y visitas</th>
                            <th>Disponibilidad de agua caliente</th>
                            <th>Cambio de ropa para ingreso</th>
                            <th>Programa de limpieza y desinfección de incubadoras</th>
                            <th>Programa de limpieza y desinfección de nacedoras</th>
                            <th>Programa de limpieza y desinfección de ambientes</th>
                            <th>Monitoreo microbiológico (Incubadora/Nacedora/Ambientes) cada 2 meses</th>
                            <th>Control integral de plagas</th>
                            <th>Servicios higiénicos limpios y conservados</th>
                            <th>Capacitación del personal en BPM</th>
                            <th>Registro de ingreso/salida de productos avícolas</th>
                            <th>Abastecimiento de agua: sanitización semanal y análisis 2 veces/año</th>
                            <th>Manejo de desechos (BPM)</th>
                            <th>Desagües adecuados</th>
                            <th>Verificación de calidad de vacunación con registro</th>
                            <th>Verificación de calidad de ave BB con registro</th>
                            <th>Embriodiagnosis: procedimiento y registro</th>
                            <th>Observaciones</th>
                            <th>Imagen 1</th>
                            <th>Imagen 2</th>
                            <th>Imagen 3</th>";
                        $query = "SELECT
                                    id,
                                    fecha,
                                    nombre_evaluador,
                                    planta_incubacion,
                                    aislamiento_instal_ok,
                                    cerco_perimetrico,
                                    ctrl_reg_ing_personas,
                                    desinf_veh_eq_mat_ing,
                                    duchas_personal_visitas,
                                    agua_caliente_disp,
                                    cambio_ropa_ing,
                                    prog_limp_desinf_incubadoras,
                                    prog_limp_desinf_nacedoras,
                                    prog_limp_desinf_ambientes,
                                    monit_micro_incub_naced_amb_2m,
                                    ctrl_plagas_integral,
                                    ss_hh_limp_conserv,
                                    cap_personal_bpm,
                                    reg_ing_sal_prod_avic,
                                    agua_abast_sanit_sem_anal_2a,
                                    manejo_desechos_bpm,
                                    desagues_adecuados,
                                    verif_calidad_vacun_reg,
                                    verif_calidad_ave_bb_reg,
                                    embriodiagnosis_proc_reg,
                                    observaciones,
                                    foto1, foto2, foto3
                                FROM GR_vr_incubacion
                                WHERE fecha BETWEEN '$fechai' AND '$fechaf'";
                        break;
                    case "vr_granjasaves":
                        echo "
                            <th>ID</th>
                            <th>Fecha</th>
                            <th>Nombre Evaluador</th>
                            <th>Granja Reproducción Aves</th>
                            <th>Aislamiento de instalación adecuado</th>
                            <th>Cerco perimétrico</th>
                            <th>Control y registro de ingreso de personas</th>
                            <th>Desinfección de vehículos/equipos/materiales antes de ingresar</th>
                            <th>Duchas para personal y visitas</th>
                            <th>Disponibilidad de agua caliente</th>
                            <th>Cambio de ropa y calzado para ingreso</th>
                            <th>Instalación de fácil higiene, ordenada y limpia</th>
                            <th>Galpones/agua/alimento protegidos del ingreso de aves silvestres</th>
                            <th>No hay presencia de otras especies domésticas dentro de la granja</th>
                            <th>Control integral de plagas</th>
                            <th>Programa de limpieza y desinfección</th>
                            <th>Abastecimiento de agua: sanitización semanal y análisis 2 veces/año</th>
                            <th>Monitoreo serológico (MG, MS) y Salmonella 4 veces/año</th>
                            <th>Área de necropsia equipada</th>
                            <th>Procedimiento e infraestructura para manejo de aves muertas/desechos</th>
                            <th>Servicios higiénicos limpios y conservados</th>
                            <th>Capacitación al personal (buenas prácticas) al menos cada 2 meses</th>
                            <th>Registro de ocurrencias sanitarias</th>
                            <th>Condiciones adecuadas para almacenamiento de huevos y protocolo de desinfección</th>
                            <th>Aves con buen estado de salud y condiciones adecuadas de manejo</th>
                            <th>Registro foliado de ingresos/salidas de productos avícolas (huevo, ave)</th>
                            <th>Desagües adecuados</th>
                            <th>Pediluvio u otro sistema de desinfección de calzado por área</th>
                            <th>Programas de vacunación y desparasitación según programa</th>
                            <th>Observaciones</th>
                            <th>Imagen 1</th>
                            <th>Imagen 2</th>
                            <th>Imagen 3</th>";
                        $query = "SELECT
                                    id,
                                    fecha,
                                    nombre_evaluador,
                                    granja_repr_aves,
                                    aislamiento_instal_ok,
                                    cerco_perimetrico,
                                    ctrl_reg_ing_personas,
                                    desinf_veh_eq_mat_ing,
                                    duchas_personal_visitas,
                                    agua_caliente_disp,
                                    cambio_ropa_calzado_ing,
                                    instal_facil_hig_orden,
                                    prot_galpon_agua_alim_aves_silv,
                                    sin_otras_especies_dom,
                                    ctrl_plagas_integral,
                                    prog_limp_desinf,
                                    agua_abast_sanit_sem_anal_2a,
                                    monit_serol_mg_ms_salmon_4a,
                                    area_necropsia_equip_ok,
                                    manejo_aves_muertas_desechos_ok,
                                    ss_hh_limp_conserv,
                                    cap_personal_bpm_2m,
                                    reg_ocurr_sanit,
                                    almac_huevos_prot_desinf,
                                    aves_salud_manejo_ok,
                                    reg_ing_sal_prod_avic,
                                    desagues_adecuados,
                                    pediluvio_por_area,
                                    reg_vacun_despar_prog,
                                    observaciones,
                                    foto1, foto2, foto3
                                FROM GR_vr_aves
                                WHERE fecha BETWEEN '$fechai' AND '$fechaf'";
                        break;
                    case "vr_granjascerdos":
                        echo "
                            <th>ID</th>
                            <th>Fecha</th>
                            <th>Nombre Evaluador</th>
                            <th>Granja Porcina</th>
                            <th>Aislamiento de instalación adecuado</th>
                            <th>Cerco perimétrico</th>
                            <th>Control y registro de ingreso de personas</th>
                            <th>Desinfección de vehículos/equipos/materiales antes de ingresar</th>
                            <th>Duchas para personal y visitas</th>
                            <th>Disponibilidad de agua caliente</th>
                            <th>Cambio de ropa y calzado para ingreso</th>
                            <th>Instalación de fácil higiene, ordenada y limpia</th>
                            <th>Galpones/agua/alimento protegidos del ingreso de aves silvestres</th>
                            <th>No hay presencia de otras especies domésticas dentro de la granja</th>
                            <th>Control integral de plagas</th>
                            <th>Programa de limpieza y desinfección</th>
                            <th>Pediluvio u otro sistema de desinfección de calzado por área</th>
                            <th>Sistema de agua adecuado: sanitización semanal y análisis 2 veces/año</th>
                            <th>Monitoreo serológico al menos 2 veces/año</th>
                            <th>Área de necropsia equipada</th>
                            <th>Infraestructura para eliminación de animales con bioseguridad</th>
                            <th>Servicios higiénicos limpios y conservados</th>
                            <th>Capacitación al personal al menos cada 2 meses</th>
                            <th>Registro de ocurrencias sanitarias</th>
                            <th>Efluentes (excretas) tratados antes de evacuar</th>
                            <th>Animales con buen estado de salud y condiciones adecuadas de manejo</th>
                            <th>Registro foliado de ingreso y salida de animales</th>
                            <th>Desagües adecuados</th>
                            <th>Observaciones</th>
                            <th>Imagen 1</th>
                            <th>Imagen 2</th>
                            <th>Imagen 3</th>";
                        $query = "SELECT
                                    id,
                                    fecha,
                                    nombre_evaluador,
                                    granja_porcina,
                                    aislamiento_instal_ok,
                                    cerco_perimetrico,
                                    ctrl_reg_ing_personas,
                                    desinf_veh_eq_mat_ing,
                                    duchas_personal_visitas,
                                    agua_caliente_disp,
                                    cambio_ropa_calzado_ing,
                                    instal_facil_hig_orden,
                                    prot_galpon_agua_alim_aves_silv,
                                    sin_otras_especies_dom,
                                    ctrl_plagas_integral,
                                    prog_limp_desinf,
                                    pediluvio_por_area,
                                    agua_abast_sanit_sem_anal_2a,
                                    monit_serologico_2a,
                                    area_necropsia_equip_ok,
                                    elim_animales_infra_bioseg,
                                    ss_hh_limp_conserv,
                                    cap_personal_bpm_2m,
                                    reg_ocurr_sanit,
                                    efluentes_tratados,
                                    animales_salud_manejo_ok,
                                    reg_foliado_ing_sal_anim,
                                    desagues_adecuados,
                                    observaciones,
                                    foto1, foto2, foto3
                                FROM GR_vr_cerdos
                                WHERE fecha BETWEEN '$fechai' AND '$fechaf'";
                        break;


                    case "vr_faenamiento":
                       echo "
                        <th>ID</th>
                        <th>Fecha</th>
                        <th>Nombre Evaluador</th>
                        <th>Planta Faenamiento</th>
                        <th>Aves en jabas con densidad correcta, sin lesiones</th>
                        <th>Las aves no presentan signos de enfermedad</th>
                        <th>Área de operación con zonas completas</th>
                        <th>Áreas/equipos/instrumentos limpios según POES (con registros)</th>
                        <th>Operatividad de grifos y presión de agua</th>
                        <th>Operatividad de lavamanos y solución desinfectante</th>
                        <th>Pediluvios con solución desinfectante y cambio frecuente</th>
                        <th>Personal capacitado, sano e indumentaria correcta</th>
                        <th>Control de cloro residual en el agua</th>
                        <th>Iluminación suficiente en superficies de trabajo</th>
                        <th>Agua de escaldado: se cambia al menos 1 vez al día</th>
                        <th>Eviscerado: no ocurre ruptura del aparato digestivo</th>
                        <th>POES/Higiene: registros correctos y carcasas limpias</th>
                        <th>Limpieza chiller 1 vez/día y agua 0-4°C</th>
                        <th>Cámara refrigeración: temperatura/manejo y registros actualizados</th>
                        <th>Disposición productos: tamaño/distribución permite buena conservación</th>
                        <th>Cumplimiento BPM según manual del establecimiento</th>
                        <th>Aturdimiento: ambiente oscuro y parámetros correctos (>=4s)</th>
                        <th>Sangrado 10-15s post aturdimiento, duración 60-200s</th>
                        <th>Escaldado: agua 50-65°C y duración 60-210s</th>
                        <th>Máquina peladora: revisión diaria y limpieza 1 vez/día</th>
                        <th>Agua y presión suficientes para remover contaminantes visibles</th>
                        <th>Veterinario realiza inspección post-mortem con higiene y registro</th>
                        <th>Registros de puntos críticos completos y correctos</th>
                        <th>Comisos y condenas: destruidos/desnaturalizados y subproductos manejados correctamente</th>
                        <th>Despacho: vehículos adecuados y temperatura asegura conservación</th>
                        <th>Observaciones</th>
                        <th>Imagen 1</th>
                        <th>Imagen 2</th>
                        <th>Imagen 3</th>";
                        $query = "SELECT
                                    id,
                                    fecha,
                                    nombre_evaluador,
                                    planta_faenamiento,
                                    densidad_jabas_ok,
                                    sin_signos_enfermedad,
                                    zonas_operacion_completas,
                                    areas_equipos_limpios_poes,
                                    grifos_operativos_presion,
                                    lavamanos_desinfectante_ok,
                                    pediluvios_desinfectante_ok,
                                    personal_capac_salud_indum,
                                    control_cloro_residual,
                                    iluminacion_suficiente,
                                    agua_escaldado_cambio_diario,
                                    eviscerado_sin_ruptura_digestiva,
                                    poes_registros_actualizados,
                                    chiller_limpieza_temp_0a4,
                                    camara_temp_registros_ok,
                                    camara_tamano_distrib_ok,
                                    bpm_cumplimiento_manual,
                                    aturdimiento_amb_oscuro_param,
                                    sangrado_10a15s_dur_60a200,
                                    escaldado_temp_50a65_dur_ok,
                                    maquina_peladora_rev_limp,
                                    agua_presion_remueve_contam,
                                    vet_inspeccion_postmortem_reg,
                                    reg_puntos_criticos_completo,
                                    comisos_condenas_manejo_ok,
                                    despacho_vehiculos_temp_ok,
                                    observaciones,
                                    foto1, foto2, foto3
                                FROM GR_vr_faenamiento
                                WHERE fecha BETWEEN '$fechai' AND '$fechaf'";
                        break;

                    // Puedes añadir otros casos aquí...
                }
                ?>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = sqlsrv_query($conn, $query);

            // Verificar si la consulta devuelve resultados
            if ($result) {
                while ($reg = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                    echo "<tr>";
                    foreach ($reg as $key => $value) {
                        // Si el valor es una imagen, incluir etiqueta <img>
                        if (strpos($key, 'foto') !== false) {
                            echo "<td><img src='$value' alt='Imagen'></td>";
                        } else if(strpos($key, 'fecha') !== false){
                            $vfecha = $value->format('Y-m-d');
                            echo "<td>$vfecha</td>";
                        }else{
                            echo "<td>$value</td>";
                        }
                    }
                    echo "</tr>";
                }
            }
            ?>
        </tbody>
    </table>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<!-- DataTables Export Buttons JS -->
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

<script>
    $(document).ready(function () {
        $('#tablaReporte').DataTable({
            dom: 'Bfrtip', // Permite incluir botones de exportación
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: 'Exportar a Excel',
                    exportOptions: {
                        columns: ':visible'
                    }
                }
            ],
            scrollX: true, // Activa el desplazamiento horizontal para tablas amplias
            responsive: true,
            language: {
                url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
            }
        });
    });
</script>
</body>
</html>

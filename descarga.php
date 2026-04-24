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

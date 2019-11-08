<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Plugin strings are defined here.
 *
 * @package     local_dominosdashboard
 * @category    dashboard
 * @copyright   2019 Subitus <contacto@subitus.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../config.php');
$context_system = context_system::instance();
require_login();
require_once(__DIR__ . '/lib.php');

global $DB;
$PAGE->set_url($CFG->wwwroot . "/local/dominosdashboard/inner.php");
$PAGE->set_context($context_system);
$PAGE->set_pagelayout('admin');
$PAGE->set_title(get_string('pluginname', 'local_dominosdashboard'));


//$tabOptions = local_dominosdashboard_get_course_tabs();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>

    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom scripts for all pages-->
    <!-- <script src="js/sb-admin-2.min.js"></script> -->

    <!-- <script src="vendor/chart.js/Chart.min.js"></script> -->

    <!-- <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"> -->
    <!-- <link rel="stylesheet" href="css/jquery.loadingModal.css"> -->
    <link href="estilos_city.css" rel="stylesheet">
    <!-- <script src="hoteles_city_scripts.js"></script> -->

</head>

<body style="background-color: #ecedf1;">

    <?php
        local_hoteles_city_dashboard_print_filters();
     ?>

    <!-- Título -->
    <div>
        <h3 style="text-align: center;">Reportes</h3>
    </div>

    <!-- Filtro -->
    <div class="row" style="margin-bottom: 10px;">
        <div class="col-sm-6" style="padding-left: 20px;">
            <select multiple="multiple" id="my-select" name="my-select[]">
                <option value='elem_1'>elem 1</option>
                <option value='elem_2'>elem 2</option>
                <option value='elem_3'>elem 3</option>
                <option value='elem_4'>elem 4</option>
                <option value='elem_100'>elem 100</option>
            </select>
            <!-- <div class="btn-group">
                <button type="button" class="btn Primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Marca
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <a class="dropdown-item" href="#">Something else here</a>
                    <a class="dropdown-item" href="#">Separated link</a>
                </div>
            </div> -->
        </div>

        <div class="col-sm-6" style="text-align: end;">
            <div class="btn-group dropleft">
                <button type="button" class="btn Primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Generar Reporte
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="#">Avances de todos los cursos disponibles en Moodle</a>
                    <a class="dropdown-item" href="#">Estatus de consulta de cursos</a>
                    <a class="dropdown-item" href="#">Aprobaciones de cursos, calificaciones obtenidas por curso por persona</a>
                    <a class="dropdown-item" href="#">Avances de capacitación en Oficina Central, por direcciones (centro de costos)</a>
                    <a class="dropdown-item" href="#">Avance de capacitación por curso en Hoteles: por región, por hotel, por persona y por puesto</a>
                    <a class="dropdown-item" href="#">Avance de capacitación por curso en Oficina Central y por direcciones</a>
                    <a class="dropdown-item" href="#">Personal activo en City Campus</a>
                    <a class="dropdown-item" href="#">Avance de capacitaciones por curso de Directores Regionales de Operaciones y Subdirectores Regionales de Venta</a>
                    <a class="dropdown-item" href="#">Avance de capacitación por módulo en los cursos que aplica</a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <!-- Core plugin JavaScript-->
    <!-- <script src="vendor/jquery-easing/jquery.easing.min.js"></script> -->
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script> -->
    <!-- <script src="bootstrap/bootstrap-multiselect.min.js"></script>
    <script src="bootstrap/bootstrap-multiselect.css"></script> -->

    <script>
        // $(document).ready(function(){
        //     $('#my-select').multiSelect();
        // });
    </script>

</body>

</html>
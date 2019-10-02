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
 * @package     local_hoteles_city_dashboard
 * @category    dashboard
 * @copyright   2019 Subitus <contacto@subitus.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../config.php');
require_login();
$context_system = context_system::instance();
require_once(__DIR__ . '/lib.php');
$courseid = optional_param('id', 0, PARAM_INT);
global $DB;
// $course = $DB->get_record($table = 'course', $conditions_array = array('id' => $courseid), 'id, shortname, fullname', MUST_EXIST);
$PAGE->set_url($CFG->wwwroot . "/local/hoteles_city_dashboard/detalle_curso.php");
$PAGE->set_context($context_system);
// $PAGE->set_pagelayout('admin');

// $PAGE->set_title(get_string('course_details_title', 'local_hoteles_city_dashboard') . $course->fullname);

// echo $OUTPUT->header();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detalle del curso</title>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/css/bootstrap.min.css" integrity="sha384-2hfp1SzUoho7/TsGGGDaFdsuuDL0LX2hnUp6VkX3CUQ2K4K+xjboZdsXyp4oUHZj" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="css/jquery.loadingModal.css">
    <link href="estilos.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
</head>

<body>
    <div class="container row" style="max-width: 100%; min-height: 300px;">
        <div class="row col-sm-12" id="contenido_dashboard">
            <!-- <table frame="void" id="tabla_comparativa${currentTab}" rules="rows" style="width:100%;text-align: center;">
                <tr class="rankingt${currentTab}">
                    <th>Nombre del curso</th>
                    <th class="txt_tabla_aprobados">Aprobados</th>
                    <th class="txt_tabla_no_aprobados">No Aprobados</th>
                    <th class="txt_tabla_inscritos">Total de usuarios inscritos</th>
                    <th class="txt_tabla_porcentaje_aprobacion">Porcentaje de Aprobación del curso</th>
                </tr>
                <tr class="rankingt${currentTab}">
                    <th>Nombre del curso</th>
                    <th class="txt_tabla_aprobados">Aprobados</th>
                    <th class="txt_tabla_no_aprobados">No Aprobados</th>
                    <th class="txt_tabla_inscritos">Total de usuarios inscritos</th>
                    <th class="txt_tabla_porcentaje_aprobacion">Porcentaje de Aprobación del curso</th>
                </tr>
            </table> -->
            <!-- <table class="datatable_">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">First</th>
                        <th scope="col">Last</th>
                        <th scope="col">Handle</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                    </tr>
                    <tr>
                        <th scope="row">2</th>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td>@fat</td>
                    </tr>
                    <tr>
                        <th scope="row">3</th>
                        <td>Larry</td>
                        <td>the Bird</td>
                        <td>@twitter</td>
                    </tr>
                </tbody>
            </table> -->

            <table class="table" id="datatable_">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">First</th>
                        <th scope="col">Last</th>
                        <th scope="col">Handle</th>
                    </tr>
                </thead>
                <tbody id="tabla_">
                    <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                    </tr>
                    <tr>
                        <th scope="row">2</th>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td>@fat</td>
                    </tr>
                    <tr>
                        <th scope="row">3</th>
                        <td>Larry</td>
                        <td>the Bird</td>
                        <td>@twitter</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://npmcdn.com/tether@1.2.4/dist/js/tether.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/js/bootstrap.min.js" integrity="sha384-VjEeINv9OSwtWFLAtmc4JCtEJXXBub00gtSnszmspDLCtC0I4z4nqz7rEFbIZLLU" crossorigin="anonymous"></script>
    <!-- <link href="libs/c3.css" rel="stylesheet"> -->
    <script src="//d3js.org/d3.v3.min.js" charset="utf-8"></script>
    <!-- <script src="libs/c3.js"></script> -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <!-- <script src="js/jquery.loadingModal.js"></script> -->
    <script>
        var tabla;
        $(document).ready( function () {
            tabla = $('#datatable_').DataTable();
        });
        function agregar(){
            key = makeid();
            tabla.row.add([
                key,key,key,key
            ]).draw(false);
            // $('#tabla_').append(`
            //     <tr>
            //         <th scope="row">${key}</th>
            //         <td>${key}1</td>
            //         <td>${key}2</td>
            //         <td>${key}3</td>
            //     </tr>`);
        }

        function makeid() {
            var result           = '';
            var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            var charactersLength = characters.length;
            for ( var i = 0; i < 10; i++ ) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength));
            }
            return result;
        }
        
    </script>
</body>

</html>
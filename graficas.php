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
$context_system = context_system::instance();
require_login();
require_once(__DIR__ . '/lib.php');

global $DB;
$PAGE->set_url($CFG->wwwroot . "/local/hoteles_city_dashboard/graficas.php");
$PAGE->set_context($context_system);
$PAGE->set_pagelayout('admin');
$PAGE->set_title(get_string('pluginname', 'local_hoteles_city_dashboard'));


//$tabOptions = local_hoteles_city_dashboard_get_course_tabs();

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

    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"> -->
    <!-- <link rel="stylesheet" href="css/jquery.loadingModal.css"> -->
    <link href="estilos_city.css" rel="stylesheet">
    <!-- <script src="hoteles_city_scripts.js"></script> -->

</head>

<body style="background-color: #ecedf1;">

    <form action="" name='local_hoteles_city_dashboard_filters' class='row' id='local_hoteles_city_dashboard_filters' >
        <?php
            local_hoteles_city_dashboard_print_filters();
        ?>
    </form>
    <div class="row">
        <div class="col-12 text-right" style="padding-right: 2%;">
            <button class='btn btn-primary' onclick="obtenerGraficas()">Aplicar filtros</button>
        </div>
    </div>

    <!-- Título -->
    <div>
        <h3 style="text-align: center;">Reportes</h3>
    </div>

    <!-- Div para pintar las graficas de los cursos -->
    <div id="curso_graficas" class="row" style="padding: 15px 25px;"></div>

    
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <!-- Core plugin JavaScript-->
    <!-- <script src="vendor/jquery-easing/jquery.easing.min.js"></script> -->
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="choicesjs/styles/choices.min.css" />
    <script src="choicesjs/scripts/choices.min.js"></script>

    <script>
        $(document).ready(function(){
            $('.multiselect-setting').each(function(index, element){ // Generación de filtros con herramenta choices.js
                var multipleCancelButton = new Choices( '#' + element.id, { removeItemButton: true, searchEnabled: true,
                    placeholderValue: 'Presione aquí para agregar un filtro', searchPlaceholderValue: 'Buscar filtro', 
                    placeholder: true,
                } );
            });
            obtenerGraficas();
        });
        function obtenerGraficas(){
            // peticion = [];
            peticion = $('#local_hoteles_city_dashboard_filters').serializeArray();
            peticion.push({name: 'request_type', value: 'course_list'});
            // peticion.push({name: 'request_type', value: 'dashboard'});
            //peticion.push({name: 'type', value: currentTab});
            //dateBegining = Date.now();
            // $('#local_hoteles_city_dashboard_content').html('Cargando la información');
            $.ajax({
                type: "POST",
                url: "services.php",
                data: peticion,
                dataType: "json"
            })
                .done(function(data) {
                    //console.log(data);
                    informacion = JSON.parse(JSON.stringify(data));
                    informacion = informacion.data;
                    console.log('Imprimiendo la respuesta', informacion);
                    for(var i = 0; i < informacion.length; i++){                        
                        info = informacion[i];
                        //console.log(info);
                        var course = new GraphicsDashboard('curso_graficas',info.title,info.chart,info,4);
                        course.printCard();
                        if(info.chart == 'bar-agrupadas'){                        
                            course.comparative_graph();
                        }
                        if(info.chart == 'line'){
                            course.comparative_graph();
                        }
                        if(info.chart == 'horizontalBar'){
                            course.comparative_graph();
                        }
                        if (info.chart == 'burbuja') {
                            course.comparative_graph();
                        }
                        if (info.chart == 'pie') {
                            course.individual_graph();
                        }
                        if (info.chart == 'bar') {
                            course.individual_graph();
                        }
 
                    }
                })
                .fail(function (error, error2) {
                    isCourseLoading = false;
                    console.log('Entra a fail');
                    console.log(error);
                    console.log(error2);
                });
        }
    </script>

    

    <script src="classes.js"></script>

</body>

</html>
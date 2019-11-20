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

<body style="background-color: #ecedf1; max-height: 100%;">

<!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <!-- <h1 class="txt_modal">Cargando...</h1> -->
            <div id="loader" style="margin-top: 100px;"></div>
        </div>
    </div> 

    
    <div class="row container" style=" max-width: 100%; min-height: 400px;">
        <form action="" name='local_hoteles_city_dashboard_filters' class='row col-sm-12' id='local_hoteles_city_dashboard_filters' >
            <?php
                local_hoteles_city_dashboard_print_filters();
            ?>
        </form>
        <!-- <div class="row col-sm-12"> -->
            <div class="col-12 text-right" style="padding-right: 2%;">
                <button class='btn btn-primary' onclick="obtenerGraficas();modalLoader();">Aplicar filtros</button>
            </div>
        <!-- </div> -->
    
        <!-- Título -->
        <!-- <div class="col-sm-12 text-center">
            <h3 style="text-align: center;">Reportes</h3>
        </div> -->
    </div>

    <!-- <div>
        <pre id="json"></pre>
    </div> -->    

    <!-- Div para pintar la grafica comparativa de los cursos -->
    <div class="row" style="justify-content: center;" id="comparative">
        <div class="col-8">
                    <div class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary"><a href="#">Comparativa</a></h6>
                            <div class="dropdown no-arrow">
                                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                </a>
                                
                            </div>
                        </div>
                        <!-- Card Body -->
                        <div class="card-body">
                            <div class="">                  
                                <canvas id="grafica_comparativa"></canvas>                  
                            </div>
                        </div>    
                    </div>
        </div>
    </div>

    <!-- Div para pintar las graficas de los cursos -->
    <div id="curso_graficas" class="row" style="padding: 15px 25px; max-width: 100%;"></div>

    
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
            modalLoader();
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
                    // document.getElementById("json").innerHTML = JSON.stringify(data, undefined, 2);
                    // console.log(data);
                    //console.log(data);
                    informacion = JSON.parse(JSON.stringify(data));
                    informacion = informacion.data;
                    console.log('Imprimiendo la respuesta', informacion);
                    cleanDiv();
                    comparative(informacion);
                    showPage();                    
                    
                    
                    for(var i = 0; i < informacion.length; i++){                        
                        info = informacion[i];
                        //console.log(info);
                        var course = new GraphicsDashboard('curso_graficas',info.title,info.chart,info,4,info.id);
                        course.printCardCourse();
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
                    showPage();
                });
        }

        function cleanDiv(){
            document.getElementById('curso_graficas').innerHTML='';
        }

        //Informacion para la grafica comparativa
        function comparative(informacion){
            data_labels = [];
            arr_completado_percantage = [];
            arr_nocompletado_percentage = [];
            datasets_completado = { label: 'Completado', borderColor: "#1cc88a", backgroundColor: 'transparent', data: arr_completado_percantage }
            datasets_nocompletado = { label: 'No Completado', borderColor: "#e74a3b", backgroundColor: 'transparent', data: arr_nocompletado_percentage }
            dataset = [];        
            for(var i = 0; i < informacion.length; i++){
                info = informacion[i];
                data_labels.push(info.title);
                // console.log('LABELS');
                // console.log(data_labels)
                arr_completado_percantage.push(info.percentage);
                // console.log('% COMPLETADO');
                // console.log(arr_completado_percantage)
                arr_nocompletado_percentage.push(100 - info.percentage);
                // console.log('% NO COMPLETADO');
                // console.log(arr_nocompletado_percentage)
            }
            dataset.push(datasets_completado);
            dataset.push(datasets_nocompletado);
            d_graph = { labels: data_labels, datasets: dataset };

            // console.log('INFO')
            // console.log(d_graph)

            //return d_graph;

            var ctx = document.getElementById('grafica_comparativa');
            var chart = new Chart(ctx, {
                type: 'line',        
                data: d_graph
                                    // labels: ['Variable 1', 'Variable 2', 'Variable 3', 'Variable 4', 'Variable 5', 'Variable 6'],
                                    // datasets: [{
                                    //     label: 'A',
                                    //     borderColor: "#3e95cd",
                                    //     backgroundColor: 'transparent',
                                    //     data: [15, 40, 30, 26, 12, 34, 0],
                                    // }, {
                                    //     label: 'B',
                                    //     borderColor: "#8e5ea2",
                                    //     backgroundColor: 'transparent',
                                    //     data: [5, 45, 26, 31, 41, 10, 0],
                                    // }]
                  
            });

        }

        function onchangeFilter(filterid){ // Se ejecuta esta función cuando el elemento ha cambiado
            // console.log('El elemento ha cambiado');
        }
    </script>

    <style>
        .choices__button:hover{
            text-indent: -9999px;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            border: 0;
            background-color: transparent;
            background-repeat: no-repeat;
            background-position: center;
            cursor: pointer;
        }

        .choices__button:active{
            text-indent: -9999px;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            border: 0;
            background-color: transparent;
            background-repeat: no-repeat;
            background-position: center;
            cursor: pointer;
        }

        .choices__button:visited{
            text-indent: -9999px;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            border: 0;
            background-color: transparent;
            background-repeat: no-repeat;
            background-position: center;
            cursor: pointer;
        }

        .choices__button:focus{
            text-indent: -9999px;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            border: 0;
            background-color: transparent;
            background-repeat: no-repeat;
            background-position: center;
            cursor: pointer;
        }

        .choices__button:focus-within{
            text-indent: -9999px;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            border: 0;
            background-color: transparent;
            background-repeat: no-repeat;
            background-position: center;
            cursor: pointer;
        }
    </style>

    <script src="classes.js"></script>
    <script>
    // var ctx = document.getElementById('grafica_comparativa');
    // var chart = new Chart(ctx, {
    //     type: 'line',        
    //     data: {
    //                         labels: ['Variable 1', 'Variable 2', 'Variable 3', 'Variable 4', 'Variable 5', 'Variable 6'],
    //                         datasets: [{
    //                             label: 'A',
    //                             borderColor: "#3e95cd",
    //                             backgroundColor: 'transparent',
    //                             data: [15, 40, 30, 26, 12, 34, 0],
    //                         }, {
    //                             label: 'B',
    //                             borderColor: "#8e5ea2",
    //                             backgroundColor: 'transparent',
    //                             data: [5, 45, 26, 31, 41, 10, 0],
    //                         }]
    //                     },    
    // });
    </script>
</body>

</html>
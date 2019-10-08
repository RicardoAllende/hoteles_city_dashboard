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
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">    
    <link rel="stylesheet" href="css/jquery.loadingModal.css">
    <link href="estilos_city.css" rel="stylesheet">
    <!-- <script src="hoteles_city_scripts.js"></script> -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
</head>
<body style="background-color: #ecedf1;">

    <!-- Título -->
    <div>
        <h3 style="text-align: center;">Reportes</h3>
    </div>

    <!-- Filtro -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div class="input-group margen_filtro">
    <a href="dashboard.php" class="btn btn-primary" role="button" aria-pressed="true">Volver a dashboard</a>      
    </div>    
    </div>
    <!-- <div class="input-group margen_filtro">
        <h5 class="txt_filtro">Filtro: </h5>        
        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Marca
        </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <a class="dropdown-item" href="#">Something else here</a>
                <div role="separator" class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Separated link</a>
            </div>       
    </div> -->

    <!-- Inicia row para cards informativas -->
    

    <!-- Gráfica comparativa -->
    <!-- <div class="row" style="justify-content: center;">
        <div class="col-sm-6">
            <div class="card shadow mb-4"> -->
                <!-- Card Header - Dropdown -->
                <!-- <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Comparativa</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Dropdown Header:</div>
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </div>
                </div> -->
                <!-- Card Body -->
                <!-- <div class="card-body"> -->
                    <!-- <div class="chart-container">  -->
                         <!-- <div class="chart-area">                                          
                                <canvas id="chart_comparativa_regionales"></canvas>                                           
                        </div> 
                     </div>   
                </div>
            </div>
              
        </div>
    </div> -->

    
    <div class="row" style="justify-content: center;">
        <!-- Gráfica 1 -->
        <div class="col-sm-4">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary"><a href="seccion_regionales_iframe.php">Reporte</a></h6>
                        <div class="dropdown no-arrow">
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                <div class="dropdown-header">Dropdown Header:</div>
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </div>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="">                  
                            <canvas id="myAreaChart1"></canvas>                  
                        </div>
                    </div>    
                </div>
        </div>        
    </div>
    <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Reporte</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Nombre de usuario</th>
                      <th>Nombre</th>
                      <th>Puesto</th>
                      <th>Hotel</th>
                      <th>Curso</th>
                      <th>Calificación</th>
                      <th>Fecha</th>
                    </tr>
                  </thead>                  
                  <tbody>
                    <tr>
                      <td>Tiger</td>
                      <td>Tiger Nixon</td>
                      <td>Gerente</td>
                      <td>Hotel 61</td>
                      <td>Curso 1</td>
                      <td>9</td>
                      <td>2011/04/25</td>
                    </tr>                    
                    <tr>
                      <td>Jenette</td>
                      <td>Jenette Caldwell</td>
                      <td>Gerente</td>
                      <td>Hotel 30</td>
                      <td>Curso 3</td>
                      <td>9</td>
                      <td>2011/09/03</td>
                    </tr>                    
                    <tr>
                      <td>Shou</td>
                      <td>Shou Itou</td>
                      <td>Gerente</td>
                      <td>Hotel 20</td>
                      <td>Curso 2</td>
                      <td>10</td>
                      <td>2011/08/14</td>                      
                    </tr>
                    <tr>
                      <td>Michelle</td>
                      <td>Michelle House</td>
                      <td>Gerente</td>
                      <td>Hotel 37</td>
                      <td>Curso 7</td>
                      <td>10</td>
                      <td>2011/06/02</td>                      
                    </tr>                   
                    <tr>
                      <td>Hope</td>
                      <td>Hope Fuentes</td>
                      <td>Recamarero</td>
                      <td>Hotel 41</td>
                      <td>Curso 4</td>
                      <td>9</td>
                      <td>2010/02/12</td>                      
                    </tr>                   
                    <tr>
                      <td>Sakura</td>
                      <td>Sakura Yamamoto</td>
                      <td>Gerente</td>
                      <td>Hotel 37</td>
                      <td>Curso 13</td>
                      <td>10</td>
                      <td>2009/08/19</td>                      
                    </tr>                   
                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </div>

    
        
    
    
    
    
    
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script> -->
    <script src="https://npmcdn.com/tether@1.2.4/dist/js/tether.min.js"></script>
    <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/js/bootstrap.min.js" integrity="sha384-VjEeINv9OSwtWFLAtmc4JCtEJXXBub00gtSnszmspDLCtC0I4z4nqz7rEFbIZLLU" crossorigin="anonymous"></script> -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="js/jquery.loadingModal.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>

    <!-- Gráfica comparativa -->
    <!-- <script>
    var ctx = document.getElementById('chart_comparativa_regionales');
    var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'line',

    // The data for our dataset
    data: {
        labels: ['Hotel1', 'Hotel2', 'Hotel3', 'Hotel4', 'Hotel5'],
        datasets: [{
            label: 'A',           
            backgroundColor: 'transparent',
            borderColor: 'rgb(255, 99, 132)',
            data: [90, 80, 90, 92, 95],
        },{
            label: 'B',           
            backgroundColor: 'transparent',
            borderColor: 'rgb(255, 99, 132)',
            data: [50, 10, 20, 10, 10],
        }]
    },

    // Configuration options go here
    options: {
        
    }
    });
    </script> -->

    <!-- Gráfica 1 -->
    <script>
    var ctx = document.getElementById('myAreaChart1');
    var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'line',

    // The data for our dataset
    data: {
    labels: ['Variable 1', 'Variable 2', 'Variable 3', 'Variable 4', 'Variable 5', 'Variable 6'],
    datasets: [{
        label: 'A',
        borderColor: "#3e95cd",
        backgroundColor: 'transparent',       
        data: [15, 40, 30, 26, 12, 34, 0],
    },{
        label: 'B',
        borderColor: "#8e5ea2",
        backgroundColor: 'transparent',       
        data: [5, 45, 26, 31, 41, 10, 0],
    }]
    },

    // Configuration options go here
    options: {
    
    }
    });
    </script>   
    
    
    <script>
        var muestraComparativas = false;
        var mostrarEnlaces = true;
        var isCourseLoading = false;
        var isFilterLoading = false;
        var trabajoPendiente = false;
        var currentTab = 1;
        var indicator;
        var item;
        var tituloPestana = "";
        var tabsCursos = [false, false, false];
        function cambiarpestana(id){
            if(id != currentTab){
                hidePage("ldm_tab_" + id);
                currentTab = id;
                tituloPestana = pestanas[id];
                setTimeout(function() {
                    obtenerInformacion();
                }, 500);
            }
        }
        pestanas = [
            '',
            'Programas de entrenamiento',
            'Lanzamientos y campañas',
            'Cruce de indicadores'
        ]
        document.addEventListener("DOMContentLoaded", function() {
                $('.course-selector').change(function(){obtenerInformacion()});
                tituloPestana = pestanas[1];
                // tituloPestana = $('#tab-selector').children('option:selected').html();
                // $('#tab-selector').change(function(){ tituloPestana = $(this).children('option:selected').html(); obtenerInformacion(); });
                obtenerInformacion();
                obtenerFiltros();
        });
        var dateBegining;
        var dateEnding;
        function quitarFiltros(){
            peticionFiltros({
                request_type: 'user_catalogues'
            });
            obtenerInformacion();
        }
        // function rehacerPeticion(){
        //     trabajoPendiente = true;
        //     setTimeout(function() {                
        //     }, 2000);
        // }
        // function reObtenerInformacion(){

        // }
        function obtenerInformacion(indicator){
            // if(isCourseLoading){
            //     console.log('Cargando contenido de cursos, no debe procesar más peticiones por el momento');
            //     return;
            // }
            // isCourseLoading = !isCourseLoading;
            // console.log("Obteniendo gráficas");
            informacion = $('#filter_form').serializeArray();
            informacion.push({name: 'request_type', value: 'course_list'});
            informacion.push({name: 'type', value: currentTab});
            dateBegining = Date.now();
            // $('#local_dominosdashboard_content').html('Cargando la información');
            $.ajax({
                type: "POST",
                url: "services.php",
                data: informacion,
                dataType: "json"
            })
            .done(function(data) {
                isCourseLoading = false;
                console.log('Data obtenida', data);
                respuesta = JSON.parse(JSON.stringify(data));
                respuesta = respuesta.data;
                console.log('Imprimiendo la respuesta', respuesta);
                dateEnding = Date.now();
                // $('#local_dominosdashboard_content').html('<pre>' + JSON.stringify(data, undefined, 2) + '</pre>');
                console.log(`Tiempo de respuesta de API al obtener json para listado de cursos ${dateEnding - dateBegining} ms`);
                render_div = "#ldm_tab_" + currentTab;
                var cosa = generarGraficasTodosLosCursos(render_div, respuesta, tituloPestana);
                setTimeout(function(){
                    if(cosa == true){
                        showPage("ldm_tab_" + currentTab);
                    }
                },1000)
                
                
            })
            .fail(function(error, error2) {
                isCourseLoading = false;
                console.log(error);
                console.log(error2);
            });
            if(indicator !== undefined){
                obtenerFiltros(indicator);
            }
        }

        
        
    </script>
    <!-- <script src="hoteles_city_scripts.js"></script> -->

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>
        
        
</body>
</html>
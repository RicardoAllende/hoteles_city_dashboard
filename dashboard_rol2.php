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
    <?php echo local_hoteles_city_dashboard_print_theme_variables(); ?>
</head>
<body style="background-color: #ecedf1;">

    <!-- Título -->
    <div>
        <h3 style="text-align: center;">Reportes</h3>
    </div>

    <!-- Filtro -->
    <div class="row" style="margin-bottom: 10px;">
        

        <div class="col-sm-12" style="text-align: end;">    
            <div class="btn-group dropleft">
                <button type="button" class="btn Primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Generar Reporte
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="data-table-bar.php">Avances de todos los cursos disponibles en Moodle</a>
                    <a class="dropdown-item" href="data-table-pie.php">Estatus de consulta de cursos</a>
                    <a class="dropdown-item" href="data-table-tendencia.php">Aprobaciones de cursos, calificaciones obtenidas por curso por persona</a>            
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

    <!-- Inicia row para cards informativas -->
    <div class="row">

        <!-- Card Número de hoteles-->
        <div class="col-sm-3 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Número de hoteles</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">40,000</div>
                </div>
                <div class="col-auto">
                <i class="fas fa-building fa-2x text-gray-300"></i>
                </div>
            </div>
            </div>
        </div>
        </div>

        <!-- Card  Cantidad de usuarios-->
        <div class="col-sm-3 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Cantidad de usuarios</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">15,000</div>
                </div>
                <div class="col-auto">
                <i class="fas fa-user-friends fa-2x text-gray-300"></i>
                </div>
            </div>
            </div>
        </div>
        </div>

        <!-- Card Aprobados-->
        <div class="col-sm-3 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Aprobados</div>
                <div class="row no-gutters align-items-center">
                    <div class="col-auto">
                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">90%</div>
                    </div>
                    <div class="col">
                    <div class="progress progress-sm mr-2">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 90%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    </div>
                </div>
                </div>
                <div class="col-auto">
                <i class="fas fa-user-graduate fa-2x text-gray-300"></i>
                </div>
            </div>
            </div>
        </div>
        </div>

        <!-- Card No aprobados-->
        <div class="col-sm-3 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">No aprobados</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">18</div>
                </div>
                <div class="col-auto">
                <i class="fas fa-user-times fa-2x text-gray-300"></i>
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>
    <!-- Termina row para cards informativas -->   


    
    <div class="row" style="justify-content: center;">
        <!-- Gráfica 1 -->
        <div class="col-sm-4">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary"><a href="seccion_regionales_iframe.php">Avance global de capacitación</a></h6>
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

        <!-- Gráfica 2 -->
        <div class="col-sm-4">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary"><a href="seccion_regionales_iframe.php">Avance por regiones</a></h6>
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
                            <canvas id="myAreaChart2"></canvas>                  
                        </div>
                    </div>    
                </div>
        </div>
    </div>

    <div class="row" style="justify-content: center;">
        <!-- Gráfica 3 -->
        <div class="col-sm-4">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary"><a href="seccion_regionales_iframe.php">Avance de capacitación de la Oficina Central</a></h6>
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
                            <canvas id="myAreaChart3"></canvas>                  
                        </div>
                    </div>    
                </div>
        </div>

        <!-- Gráfica 4 -->
        <div class="col-sm-4">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary"><a href="seccion_regionales_iframe.php">Avance en capacitación por hoteles</a></h6>
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
                            <canvas id="myAreaChart4"></canvas>                  
                        </div>
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
    type: 'bar',

    // The data for our dataset
    data: {
    labels: ['Centro', 'Suites', 'Plus', 'Express', 'Junior', 'OC'],
    datasets: [{
        label: 'Aprobados',
        backgroundColor: '#1cc88a',       
        data: [15, 40, 30, 26, 12, 34, 0],
    },{
        label: 'No Aprobados',
        backgroundColor: '#e74a3b',       
        data: [5, 45, 26, 31, 41, 10, 0],
    }]
    },

    // Configuration options go here
    options: {
    
    }
    });
    </script>

    <!-- Gráfica 2 -->
    <script>
    var ctx = document.getElementById('myAreaChart2');
    var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'bar',

    // The data for our dataset
    data: {
    labels: ['NO', 'NE', 'CO', 'Metro', 'Sur', 'SE', 'LA'],
    datasets: [{
        label: 'Aprobados',            
        //borderColor: '#1cc88a',
        data: [15, 40, 26, 31, 41, 10, 19, 0],
    },{
        label: 'No Aprobados',            
        //borderColor: '#e74a3b',
        data: [5, 45, 30, 26, 12, 34, 5, 0],
    }]
},

// Configuration options go here
options: {
    
}
});
    </script>

    <!-- Gráfica 3 -->
    <script>
    var ctx = document.getElementById('myAreaChart3');
    var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'bar',

    // The data for our dataset
    data: {
    labels: ['OP', 'CH', 'BR', 'TI', 'FI', 'LE', 'AD', 'FR', 'DE'],
    datasets: [{
        label: 'Aprobados',            
        //borderColor: 'yellow',
        data: [15, 40, 26, 31, 41, 10, 19, 0],
    },{
        label: 'No Aprobados',            
        //borderColor: '#e74a3b',
        data: [5, 45, 30, 26, 12, 34, 5, 0],
    }]
    },

// Configuration options go here
    options: {
        
    }
    });
    </script>

    <!-- Gráfica 4 -->
    <script>
    var ctx = document.getElementById('myAreaChart4');
    var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'horizontalBar',

    // The data for our dataset
    data: {
        labels: ['EVD', 'JVD', 'GV', 'ALL', 'CA', 'JM', 'CO', 'CXC'],
        datasets: [{
            label: 'A',            
            //borderColor: 'rgb(255, 99, 132)',
            data: [15, 40, 12, 30, 26, 50, 1, 9, 0],
        }]
    },

    // Configuration options go here
    options: {
        legend: { display: false },
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
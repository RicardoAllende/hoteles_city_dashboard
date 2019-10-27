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
    
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <!-- Core plugin JavaScript-->
    <!-- <script src="vendor/jquery-easing/jquery.easing.min.js"></script> -->
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <script src="vendor/chart.js/Chart.min.js"></script>

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">    
    <!-- <link rel="stylesheet" href="css/jquery.loadingModal.css"> -->
    <link href="estilos_city.css" rel="stylesheet">
    <!-- <script src="hoteles_city_scripts.js"></script> -->    
    
    <?php echo local_hoteles_city_dashboard_print_theme_variables(); ?>
</head>
<body style="background-color: #ecedf1;">

<!-- onload="loaderGeneral()" -->


    <!-- Título -->
    <div>
        <h3 style="text-align: center;">Reportes</h3>
    </div>

    <!-- Filtro -->
    <div class="row" style="margin-bottom: 10px;">
        <div class="col-sm-6" style="padding-left: 20px;">
            <div class="btn-group">            
                <button type="button" class="btn Primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Marca
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <a class="dropdown-item" href="#">Something else here</a>            
                    <a class="dropdown-item" href="#">Separated link</a>
                </div>
            </div>
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

    <!-- Inicia row para cards informativas -->
    <div class="row" id="cards informativas">

        <!-- Card Número de hoteles-->
        <div class="col-sm-3 mb-4">
        <div class="card border_left_color_primary shadow h-100 py-2">
            <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                <div class="txt_primary text-uppercase mb-1">Número de hoteles</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800" id="card_numero_hoteles">40,000</div>
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
        <div class="card border_left_color_warning shadow h-100 py-2">
            <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                <div class="txt_warning text-uppercase mb-1">Cantidad de usuarios</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800" id="card_cantidad_usarios">15,000</div>
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
        <div class="card border_left_color_success shadow h-100 py-2">
            <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                <div class="txt_success text-uppercase mb-1">Aprobados</div>
                <div class="row no-gutters align-items-center">
                    <div class="col-auto">
                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800" id="card_aprobados">90%</div>
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
        <div class="card border_left_color_danger shadow h-100 py-2">
            <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                <div class="txt_danger text-uppercase mb-1">No aprobados</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800" id="card_no_aprobados">18</div>
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
    
    
    
    <!-- Div para pintar las graficas en dashboard -->
    <div id="contenedor_graficas" class="row" style="padding: 15px 25px;"></div>
    
    
     
    
    
    
    
    
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script> -->
    <script src="https://npmcdn.com/tether@1.2.4/dist/js/tether.min.js"></script>
    <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/js/bootstrap.min.js" integrity="sha384-VjEeINv9OSwtWFLAtmc4JCtEJXXBub00gtSnszmspDLCtC0I4z4nqz7rEFbIZLLU" crossorigin="anonymous"></script> -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <!-- <script src="js/jquery.loadingModal.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>

    
    
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
                    //obtenerInformacion();
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
                //obtenerInformacion();
                //obtenerFiltros();
        });
        var dateBegining;
        var dateEnding;
        function quitarFiltros(){
            peticionFiltros({
                request_type: 'user_catalogues'
            });
            //obtenerInformacion();
        }
        
        
        
    </script>   

    <script src="classes.js"></script>
    <script>
        regresaInfoByCurso(); 
    </script>
    
    


<!-- Modal -->

    <div class="modal fade" id="modal_loader">
        <div class="modal-dialog-centered" role="document">
            <h1 class="txt_modal">Cargando</h1>            
        </div>
    </div>


</body>
</html>
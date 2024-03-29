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
$PAGE->set_url($CFG->wwwroot . "/local/hoteles_city_dashboard/inner.php");
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
    <script src="vendor/chart.js/Chart.min.js"></script>
    <link href="estilos_city.css" rel="stylesheet">

    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
     -->
        
    
    <!-- Custom styles for this page -->
    <!-- <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet"> -->

    

    <!-- Bootstrap core JavaScript-->
    <!-- <script src="vendor/jquery/jquery.min.js"></script> -->
    <!-- Core plugin JavaScript-->
    <!-- <script src="vendor/jquery-easing/jquery.easing.min.js"></script> -->
    <!-- <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script> -->

    

    <!-- Custom scripts for all pages-->
    <!-- <script src="js/sb-admin-2.min.js"></script> -->

    

    <!-- <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">     -->
    <!-- <link rel="stylesheet" href="css/jquery.loadingModal.css"> -->
    
    <!-- <script src="hoteles_city_scripts.js"></script>     -->
    
</head>
<body style="background-color: #ecedf1; max-width: 100%; max-height: 100%;">

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <!-- <h1 class="txt_modal">Cargando...</h1> -->
            <div id="loader" style="margin-top: 100px;"></div>
        </div>
</div> 


    <!-- Título -->
    <div style="max-width: 100%;">
        <h3 style="text-align: center;">Reportes</h3>
    </div>

    
     

    <!-- Inicia row para cards informativas -->
    <div class="row container" id="cards informativas" style="max-width: 100%;">

        <!-- Card Número de hoteles-->
        <div class="col-sm-3 mb-4">
        <div class="card border_left_color_primary shadow h-100 py-2">
            <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                <div class="txt_primary text-uppercase mb-1">Número de hoteles</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800" id="card_numero_hoteles"></div>
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
        <div class="card border_left_color_secondary shadow h-100 py-2">
            <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                <div class="txt_secondary text-uppercase mb-1">Cantidad de usuarios</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800" id="card_cantidad_usarios"></div>
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
                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800" id="card_aprobados"></div>
                    </div>
                    <div class="col">
                    <div class="progress progress-sm mr-2">
                        <div class="progress-bar bg-success" role="progressbar" style="width:0%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" id="progress_aprobados"></div>
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
                <div class="row no-gutters align-items-center">
                    <div class="col-auto">
                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="card_no_aprobados"></div>
                    </div>
                    <div class="col">
                    <div class="progress progress-sm mr-2">
                        <div class="progress-bar bg-danger" role="progressbar" style="width:0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="progress_noaprobados"></div>
                    </div>
                    </div>
                </div>
                </div>
                <div class="col-auto">
                <i class="fas fa-user-times fa-2x text-gray-300"></i>
                </div>
            </div>
            </div>
        </div>
        </div>   
    <!-- Termina row para cards informativas -->   
    <div class="col-12 text-right" style="padding-right: 2%;">
                <button class='btn btn-primary' onclick="top.window.location.href='estatus_curso.php'">Gráficas de curso</button>
    </div>
    
    
    <!-- Div para pintar las graficas en dashboard -->
    <div id="contenedor_graficas" class="row" style="padding: 15px 25px; max-width: 100%;"></div>
    
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="choicesjs/styles/choices.min.css" />
    <script src="choicesjs/scripts/choices.min.js"></script>
    
    
    
    
    
    <!-- <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script> -->
    <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script> -->
    <!-- <script src="https://npmcdn.com/tether@1.2.4/dist/js/tether.min.js"></script> -->
    <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/js/bootstrap.min.js" integrity="sha384-VjEeINv9OSwtWFLAtmc4JCtEJXXBub00gtSnszmspDLCtC0I4z4nqz7rEFbIZLLU" crossorigin="anonymous"></script> -->
    <!-- <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script> -->
    <!-- <script src="js/jquery.loadingModal.js"></script> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script> -->

    
    
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


</body>
</html>
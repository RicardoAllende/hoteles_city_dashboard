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
        <h3 style="text-align: center; margin-bottom: 60px;">Formulario</h3>
    </div>

    <form>
        <div class="form-group row" style="justify-content: center;">
            <label for="username" class="col-sm-2 col-form-label">User name</label>
            <div class="col-sm-2">
                <input type="text" class="form-control" id="username" placeholder="User name">
            </div>
        </div>
        <div class="form-group row" style="justify-content: center;">
            <label for="password" class="col-sm-2 col-form-label">Password</label>
            <div class="col-sm-2">
                <input type="password" class="form-control" id="password" placeholder="Password">
            </div>
        </div>
        <div class="form-group row" style="justify-content: center;">
            <label for="nombre" class="col-sm-2 col-form-label">Nombre</label>
            <div class="col-sm-2">
                <input type="text" class="form-control" id="nombre" placeholder="Nombre">
            </div>
        </div>
        <div class="form-group row" style="justify-content: center;">
            <label for="apellidos" class="col-sm-2 col-form-label">Apellidos</label>
            <div class="col-sm-2">
                <input type="text" class="form-control" id="apellidos" placeholder="Apellidos">
            </div>
        </div>
        <div class="form-group row" style="justify-content: center;">
            <label for="email" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-2">
                <input type="email" class="form-control" id="email" placeholder="Email">
            </div>
        </div>
        <div class="form-group row" style="justify-content: center;">
            <label for="puesto" class="col-sm-2 col-form-label">Puesto</label>
            <div class="col-sm-2">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Puesto
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </div>
        </div>
        <div class="form-group row" style="justify-content: center;">
            <label for="hotel" class="col-sm-2 col-form-label">Hotel</label>
            <div class="col-sm-2">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Hotel
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </div>
        </div>
        <div class="form-group row" style="justify-content: center;">
            <label for="personalizados" class="col-sm-2 col-form-label">Campos personalizados</label>
            <div class="col-sm-2">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Campos personalizados
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </div>
        </div>                
        <div class="form-group row" style="justify-content: center;" >
            <div class="col-sm-1" style="margin-top: 20px;">
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </form>
    
    
    
    
    
    
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
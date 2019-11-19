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
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/css/bootstrap.min.css" integrity="sha384-2hfp1SzUoho7/TsGGGDaFdsuuDL0LX2hnUp6VkX3CUQ2K4K+xjboZdsXyp4oUHZj" crossorigin="anonymous">
    <link rel="stylesheet" href="css/jquery.loadingModal.css">
    <link href="estilos_city.css" rel="stylesheet">
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <!-- <script src="hoteles_city_scripts.js"></script> -->
</head>
<body style="background-color: #ecedf1;">
        <!-- Custom fonts for this template -->
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

  <!-- Custom styles for this page -->
  <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet"> 
    <div style="padding: 1rem;">
    <a href="dashboard.php" class="btn btn-primary" role="button" aria-pressed="true">Crear</a>
    </div>         
          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Reporte</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive" style="text-align: center;">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Nombre de usuario</th>
                      <th>Status</th>
                      <th>Alta</th>
                      <th>Baja</th>
                      <th>Editar</th>                                           
                    </tr>
                  </thead>                  
                  <tbody>
                    <tr>
                      <td>Tiger</td>
                      <td>Activo</td>
                      <td><a href="dashboard.php" class="btn btn-success" role="button" aria-pressed="true">Alta</a></td>
                      <td><a href="dashboard.php" class="btn btn-danger" role="button" aria-pressed="true">Baja</a></td>
                      <td><a href="dashboard.php" class="btn btn-warning" role="button" aria-pressed="true">Editar</a></td>                      
                    </tr>                    
                    <tr>
                      <td>Jenette</td>
                      <td>Activo</td>
                      <td><a href="dashboard.php" class="btn btn-success" role="button" aria-pressed="true">Alta</a></td>
                      <td><a href="dashboard.php" class="btn btn-danger" role="button" aria-pressed="true">Baja</a></td>
                      <td><a href="dashboard.php" class="btn btn-warning" role="button" aria-pressed="true">Editar</a></td>                       
                    </tr>                    
                    <tr>
                      <td>Shou</td>
                      <td>Activo</td>
                      <td><a href="dashboard.php" class="btn btn-success" role="button" aria-pressed="true">Alta</a></td>
                      <td><a href="dashboard.php" class="btn btn-danger" role="button" aria-pressed="true">Baja</a></td>
                      <td><a href="dashboard.php" class="btn btn-warning" role="button" aria-pressed="true">Editar</a></td>                                             
                    </tr>
                    <tr>
                      <td>Michelle</td>
                      <td>Activo</td>
                      <td><a href="dashboard.php" class="btn btn-success" role="button" aria-pressed="true">Alta</a></td>
                      <td><a href="dashboard.php" class="btn btn-danger" role="button" aria-pressed="true">Baja</a></td>
                      <td><a href="dashboard.php" class="btn btn-warning" role="button" aria-pressed="true">Editar</a></td>                                              
                    </tr>                   
                    <tr>
                      <td>Hope</td>
                      <td>Activo</td>
                      <td><a href="dashboard.php" class="btn btn-success" role="button" aria-pressed="true">Alta</a></td>
                      <td><a href="dashboard.php" class="btn btn-danger" role="button" aria-pressed="true">Baja</a></td>
                      <td><a href="dashboard.php" class="btn btn-warning" role="button" aria-pressed="true">Editar</a></td>                                             
                    </tr>                   
                    <tr>
                      <td>Sakura</td>
                      <td>Activo</td>
                      <td><a href="dashboard.php" class="btn btn-success" role="button" aria-pressed="true">Alta</a></td>
                      <td><a href="dashboard.php" class="btn btn-danger" role="button" aria-pressed="true">Baja</a></td>
                      <td><a href="dashboard.php" class="btn btn-warning" role="button" aria-pressed="true">Editar</a></td>                                              
                    </tr>                   
                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

     

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/datatables-demo.js"></script>



        
         
    
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script> -->
    <script src="https://npmcdn.com/tether@1.2.4/dist/js/tether.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/js/bootstrap.min.js" integrity="sha384-VjEeINv9OSwtWFLAtmc4JCtEJXXBub00gtSnszmspDLCtC0I4z4nqz7rEFbIZLLU" crossorigin="anonymous"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="js/jquery.loadingModal.js"></script>
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
            // $('#local_hoteles_city_dashboard_content').html('Cargando la información');
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
                // $('#local_hoteles_city_dashboard_content').html('<pre>' + JSON.stringify(data, undefined, 2) + '</pre>');
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
    <script src="hoteles_city_scripts.js"></script>
    
    
</body>
</html>
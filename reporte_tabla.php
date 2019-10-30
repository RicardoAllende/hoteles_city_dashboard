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

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Dashboard</title>

  <!-- <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  <link rel="stylesheet" href="css/jquery.loadingModal.css"> -->

  <!-- Custom fonts for this template -->
  
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <!-- Custom styles for this template -->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
  <!-- Custom styles for this page -->
  <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <?php echo local_hoteles_city_dashboard_print_theme_variables(); ?>

</head>

<body style="background-color: #ecedf1;">

  <!-- Título -->
  <div>
      <h3 style="text-align: center;">Reportes</h3>
  </div>
  <!-- Botón regresar a Dashboard -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <div class="input-group margen_filtro">
      <a href="dashboard.php" class="btn Primary" role="button" aria-pressed="true">Volver a dashboard</a>      
      </div>    
  </div>

  <div class="row" style="justify-content: center;" id="graph_data_table">
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

  <!-- Inicia data-table -->
  <div class="row" style="justify-content: center;" id="table_informacion">
    <div class="col-sm-10">      
            
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
              <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Reporte</h6>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                      <tr>
                        <th>Hotel</th>
                        <th>Nombre de usuario</th>
                        <th>Puesto</th>
                        <th>Curso</th>
                        <th>Estatus</th>                        
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                      <th>Hotel</th>
                        <th>Nombre de usuario</th>
                        <th>Puesto</th>
                        <th>Curso</th>
                        <th>Estatus</th>                        
                      </tr>
                    </tfoot>
                    <tbody>
                      <tr>
                        <td>Hotel</td>
                        <td>Tiger Nixon</td>
                        <td>Gerente</td>
                        <td>61</td>
                        <td>Activo</td>                        
                      </tr>
                      <tr>
                        <td>Hotel</td>
                        <td>Francisco Nixon</td>
                        <td>Amo de llaves</td>
                        <td>63</td>
                        <td>Activo</td>                        
                      </tr>
                      <tr>
                        <td>Hotel</td>
                        <td>Ashton Cox</td>
                        <td>Amo de llaves</td>
                        <td>66</td>
                        <td>Activo</td>                        
                      </tr>
                      <tr>
                        <td>Hotel</td>
                        <td>Cedric Kelly</td>
                        <td>Recamarera</td>
                        <td>22</td>
                        <td>Activo</td>                        
                      </tr>
                      <tr>
                        <td>Hotel</td>
                        <td>Airi Satou</td>
                        <td>Gerente</td>
                        <td>33</td>
                        <td>Activo</td>                        
                      </tr>
                      <tr>
                        <td>Hotel</td>
                        <td>Brielle Williamson</td>
                        <td>Gerente</td>
                        <td>61</td>
                        <td>Activo</td>                        
                      </tr>
                      <tr>
                        <td>Hotel</td>
                        <td>Herrod Chandler</td>
                        <td>Gerente</td>
                        <td>59</td>
                        <td>Activo</td>                        
                      </tr>
                      <tr>
                        <td>Hotel</td>
                        <td>Rhona Davidson</td>
                        <td>Gerente</td>
                        <td>55</td>
                        <td>Activo</td>                        
                      </tr>
                      <tr>
                        <td>Hotel</td>
                        <td>Colleen Hurst</td>
                        <td>Gerente</td>
                        <td>39</td>
                        <td>Activo</td>                        
                      </tr>
                      <tr>
                        <td>Hotel</td>
                        <td>Sonya Frost</td>
                        <td>Gerente</td>
                        <td>23</td>
                        <td>Activo</td>                        
                      </tr>
                      <tr>
                        <td>Hotel</td>
                        <td>Jena Gaines</td>
                        <td>Gerente</td>
                        <td>30</td>
                        <td>Activo</td>                        
                      </tr>
                      <tr>
                        <td>Hotel</td>
                        <td>Quinn Flynn</td>
                        <td>Gerente</td>
                        <td>22</td>
                        <td>Activo</td>                        
                      </tr>
                      <tr>
                        <td>Hotel</td>
                        <td>Charde Marshall</td>
                        <td>Gerente</td>
                        <td>36</td>
                        <td>Activo</td>                        
                      </tr>
                      <tr>
                        <td>Hotel</td>
                        <td>Haley Kennedy</td>
                        <td>Gerente</td>
                        <td>43</td>
                        <td>Activo</td>                        
                      </tr>
                      <tr>
                        <td>Hotel</td>
                        <td>Tatyana Fitzpatrick</td>
                        <td>Amo de llaves</td>
                        <td>19</td>
                        <td>Activo</td>                        
                      </tr>
                      <tr>
                        <td>Hotel</td>
                        <td>Michael Silva</td>
                        <td>Amo de llaves</td>
                        <td>66</td>
                        <td>Activo</td>                        
                      </tr>
                      <tr>
                        <td>Hotel</td>
                        <td>Paul Byrd</td>
                        <td>Gerente</td>
                        <td>64</td>
                        <td>Activo</td>                        
                      </tr>
                      <tr>
                        <td>Hotel</td>
                        <td>Gloria Little</td>
                        <td>Gerente</td>
                        <td>59</td>
                        <td>Activo</td>                        
                      </tr>
                      <tr>
                        <td>Hotel</td>
                        <td>Bradley Greer</td>
                        <td>Gerente</td>
                        <td>41</td>
                        <td>Activo</td>                        
                      </tr>
                      <tr>
                        <td>Hotel</td>
                        <td>Dai Rios</td>
                        <td>Gerente</td>
                        <td>35</td>
                        <td>Activo</td>                        
                      </tr>
                      <tr>
                        <td>Hotel</td>
                        <td>Jenette Caldwell</td>
                        <td>Gerente</td>
                        <td>30</td>
                        <td>Activo</td>                        
                      </tr>
                      <tr>
                        <td>Hotel</td>
                        <td>Yuri Berry</td>
                        <td>Gerente</td>
                        <td>40</td>
                        <td>Activo</td>                        
                      </tr>
                      <tr>
                        <td>Hotel</td>
                        <td>Caesar Vance</td>
                        <td>Recamarero</td>
                        <td>21</td>
                        <td>Activo</td>                        
                      </tr>
                      <tr>
                        <td>Hotel</td>
                        <td>Doris Wilder</td>
                        <td>Gerente</td>
                        <td>23</td>
                        <td>Activo</td>                        
                      </tr>
                      <tr>
                        <td>Hotel</td>
                        <td>Angelica Ramos</td>
                        <td>Amo de llaves</td>
                        <td>47</td>
                        <td>Activo</td>                        
                      </tr>
                      <tr>
                        <td>Hotel</td>
                        <td>Gavin Joyce</td>
                        <td>Gerente</td>
                        <td>42</td>
                        <td>Activo</td>                        
                      </tr>
                      <tr>
                        <td>Hotel</td>
                        <td>Jennifer Chang</td>
                        <td>Gerente</td>
                        <td>28</td>
                        <td>Activo</td>                        
                      </tr>
                      <tr>
                        <td>Hotel</td>
                        <td>Brenden Wagner</td>
                        <td>Gerente</td>
                        <td>28</td>
                        <td>Activo</td>                        
                      </tr>
                      <tr>
                        <td>Hotel</td>
                        <td>Fiona Green</td>
                        <td>Gerente</td>
                        <td>48</td>
                        <td>Activo</td>                        
                      </tr>
                      <tr>
                        <td>Hotel</td>
                        <td>Shou Itou</td>
                        <td>Gerente</td>
                        <td>20</td>
                        <td>Activo</td>                        
                      </tr>
                      <tr>
                        <td>Hotel</td>
                        <td>Michelle House</td>
                        <td>Gerente</td>
                        <td>37</td>
                        <td>Activo</td>                        
                      </tr>
                      <tr>
                        <td>Hotel</td>
                        <td>Suki Burks</td>
                        <td>Gerente</td>
                        <td>53</td>
                        <td>Activo</td>                        
                      </tr>
                      <tr>
                        <td>Hotel</td>
                        <td>Prescott Bartlett</td>
                        <td>Gerente</td>
                        <td>27</td>
                        <td>Activo</td>                        
                      </tr>
                      <tr>
                        <td>Hotel</td>
                        <td>Gavin Cortez</td>
                        <td>Recamarera</td>
                        <td>22</td>
                        <td>Activo</td>                        
                      </tr>
                      <tr>
                        <td>Hotel</td>
                        <td>Martena Mccray</td>
                        <td>Gerente</td>
                        <td>46</td>
                        <td>No Activo</td>                        
                      </tr>
                      <tr>
                        <td>Hotel</td>
                        <td>Unity Butler</td>
                        <td>Amo de llaves</td>
                        <td>47</td>
                        <td>Activo</td>                        
                      </tr>
                      <tr>
                        <td>Hotel</td>
                        <td>Howard Hatfield</td>
                        <td>Recamarero</td>
                        <td>51</td>
                        <td>Activo</td>                        
                      </tr>
                      <tr>
                        <td>Hotel</td>
                        <td>Hope Fuentes</td>
                        <td>Amo de llaves</td>
                        <td>41</td>
                        <td>Activo</td>                        
                      </tr>
                      <tr>
                        <td>Hotel</td>
                        <td>Vivian Harrell</td>
                        <td>Recamarero</td>
                        <td>62</td>
                        <td>Activo</td>                        
                      </tr>
                      <tr>
                        <td>Hotel</td>
                        <td>Timothy Mooney</td>
                        <td>Gerente</td>
                        <td>37</td>
                        <td>Activo</td>                        
                      </tr>
                      <tr>
                        <td>Hotel</td>
                        <td>Jackson Bradshaw</td>
                        <td>Gerente</td>
                        <td>65</td>
                        <td>Activo</td>                        
                      </tr>
                      <tr>
                        <td>Hotel</td>
                        <td>Olivia Liang</td>
                        <td>Gerente</td>
                        <td>64</td>
                        <td>Activo</td>                        
                      </tr>
                      <tr>
                        <td>Hotel</td>
                        <td>Bruno Nash</td>
                        <td>Gerente</td>
                        <td>38</td>
                        <td>Activo</td>                        
                      </tr>
                      <tr>
                        <td>Hotel</td>
                        <td>Sakura Yamamoto</td>
                        <td>Gerente</td>
                        <td>37</td>
                        <td>Activo</td>                        
                      </tr>
                      <tr>
                        <td>Hotel</td>
                        <td>Thor Walton</td>
                        <td>Gerente</td>
                        <td>61</td>
                        <td>Activo</td>                        
                      </tr>
                      <tr>
                        <td>Hotel</td>
                        <td>Finn Camacho</td>
                        <td>Gerente</td>
                        <td>47</td>
                        <td>Activo/td>                        
                      </tr>
                      <tr>
                        <td>Hotel</td>
                        <td>Serge Baldwin</td>
                        <td>Gerente</td>
                        <td>64</td>
                        <td>Activo</td>                        
                      </tr>
                      <tr>
                        <td>Hotel</td>
                        <td>Zenaida Frank</td>
                        <td>Gerente</td>
                        <td>63</td>
                        <td>Activo</td>                        
                      </tr>
                      <tr>
                        <td>Hotel</td>
                        <td>Zorita Serrano</td>
                        <td>Gerente</td>
                        <td>56</td>
                        <td>Activo</td>                        
                      </tr>
                      <tr>
                        <td>Hotel</td>
                        <td>Jennifer Acosta</td>
                        <td>Gerente</td>
                        <td>43</td>
                        <td>Activo</td>
                        
                      </tr>
                      <tr>
                        <td>Hotel</td>
                        <td>Cara Stevens</td>
                        <td>Recamarera</td>
                        <td>46</td>
                        <td>Activo</td>
                        
                      </tr>
                      <tr>
                        <td>Hotel</td>
                        <td>Hermione Butler</td>
                        <td>Gerente</td>
                        <td>47</td>
                        <td>Activo</td>                        
                      </tr>
                      <tr>
                        <td>Hotel</td>
                        <td>Lael Greer</td>
                        <td>Gerente</td>
                        <td>21</td>
                        <td>Activo</td>                        
                      </tr>
                      <tr>
                        <td>Hotel</td>
                        <td>Jonas Alexander</td>
                        <td>Gerente</td>
                        <td>30</td>
                        <td>Activo</td>                        
                      </tr>
                      <tr>
                        <td>Hotel</td>
                        <td>Shad Decker</td>
                        <td>Amo de llaves</td>
                        <td>51</td>
                        <td>Activo</td>                        
                      </tr>
                      <tr>
                        <td>Hotel</td>
                        <td>Michael Bruce</td>
                        <td>Recamarero</td>
                        <td>29</td>
                        <td>Activo</td>                        
                      </tr>
                      <tr>
                        <td>Hotel</td>
                        <td>Donna Snider</td>
                        <td>Recamarera</td>
                        <td>27</td>
                        <td>Activo</td>                        
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
    </div>
  </div>  
  <!-- Fin data-table   -->

     

      


  

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="login.html">Logout</a>
        </div>
      </div>
    </div>
  </div>

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

  <script src="vendor/chart.js/Chart.min.js"></script>

  <!-- <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
  <script src="https://npmcdn.com/tether@1.2.4/dist/js/tether.min.js"></script>
  <script src="js/jquery.loadingModal.js"></script> -->
  


    <script>
        var ctx = document.getElementById('myAreaChart1');
        var chart = new Chart(ctx, {
        // The type of chart we want to create
        type: 'bar',

        // The data for our dataset
        data: {
        labels: ['Variable 1', 'Variable 2', 'Variable 3', 'Variable 4', 'Variable 5', 'Variable 6'],
        datasets: [{
            label: 'A',
            backgroundColor: '#1cc88a',       
            data: [15, 40, 30, 26, 12, 34, 0],
        },{
            label: 'B',
            backgroundColor: '#e74a3b',       
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

</body>

</html>

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
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

  <!-- Custom styles for this page -->
  <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body style="background-color: #ecedf1;">

  <!-- Título -->
  <div>
      <h3 style="text-align: center;">Administración de usuarios</h3>
  </div>
  <!-- Botón regresar a Dashboard -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <div class="input-group margen_filtro" style="padding-left: 165px;">
      <a href="dashboard.php" class="btn btn-primary" role="button" aria-pressed="true">Crear</a>      
      </div>    
  </div>

  

  <!-- Inicia data-table -->
  <div class="row" style="justify-content: center;">
    <div class="col-sm-10">      
            
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
              <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Reporte</h6>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" style="text-align: center;">
                    <thead>
                      <tr>
                        <th>Nombre de usuario</th>
                        <th>Status</th>
                        <th>Alta</th>
                        <th>Baja</th>
                        <th>Editar</th>
                        <!-- <th>Start date</th>
                        <th>Salary</th> -->
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th>Nombre de usuario</th>
                        <th>Status</th>
                        <th>Alta</th>
                        <th>Baja</th>
                        <th>Editar</th>
                        <!-- <th>Start date</th>
                        <th>Salary</th> -->
                      </tr>
                    </tfoot>
                    <tbody>
                      <tr>
                        <td>Tiger Nixon</td>
                        <td>Activo</td>
                        <td><a href="form.php" class="btn btn-success" role="button" aria-pressed="true">Alta</a></td>
                        <td><a href="form_baja.php" class="btn btn-danger" role="button" aria-pressed="true">Baja</a></td>
                        <td><a href="form.php" class="btn btn-warning" role="button" aria-pressed="true">Editar</a></td>
                        <!-- <td>2011/04/25</td>
                        <td>$320,800</td> -->
                      </tr>
                      <tr>
                        <td>Garrett Winters</td>
                        <td>Activo</td>
                        <td><a href="dashboard.php" class="btn btn-success" role="button" aria-pressed="true">Alta</a></td>
                        <td><a href="dashboard.php" class="btn btn-danger" role="button" aria-pressed="true">Baja</a></td>
                        <td><a href="dashboard.php" class="btn btn-warning" role="button" aria-pressed="true">Editar</a></td>
                        <!-- <td>2011/07/25</td>
                        <td>$170,750</td> -->
                      </tr>
                      <tr>
                        <td>Ashton Cox</td>
                        <td>Activo</td>
                        <td><a href="dashboard.php" class="btn btn-success" role="button" aria-pressed="true">Alta</a></td>
                        <td><a href="dashboard.php" class="btn btn-danger" role="button" aria-pressed="true">Baja</a></td>
                        <td><a href="dashboard.php" class="btn btn-warning" role="button" aria-pressed="true">Editar</a></td>
                        <!-- <td>2009/01/12</td>
                        <td>$86,000</td> -->
                      </tr>
                      <tr>
                        <td>Cedric Kelly</td>
                        <td>Activo</td>
                        <td><a href="dashboard.php" class="btn btn-success" role="button" aria-pressed="true">Alta</a></td>
                        <td><a href="dashboard.php" class="btn btn-danger" role="button" aria-pressed="true">Baja</a></td>
                        <td><a href="dashboard.php" class="btn btn-warning" role="button" aria-pressed="true">Editar</a></td>
                        <!-- <td>2012/03/29</td>
                        <td>$433,060</td> -->
                      </tr>
                      <tr>
                        <td>Airi Satou</td>
                        <td>Desactivo</td>
                        <td><a href="form.php" class="btn btn-success" role="button" aria-pressed="true">Alta</a></td>
                        <td><a href="form_baja.php" class="btn btn-danger" role="button" aria-pressed="true">Baja</a></td>
                        <td><a href="form.php" class="btn btn-warning" role="button" aria-pressed="true">Editar</a></td>
                        <!-- <td>2008/11/28</td>
                        <td>$162,700</td> -->
                      </tr>
                      <tr>
                        <td>Brielle Williamson</td>
                        <td>Desactivo</td>
                        <td><a href="dashboard.php" class="btn btn-success" role="button" aria-pressed="true">Alta</a></td>
                        <td><a href="dashboard.php" class="btn btn-danger" role="button" aria-pressed="true">Baja</a></td>
                        <td><a href="dashboard.php" class="btn btn-warning" role="button" aria-pressed="true">Editar</a></td>
                        <!-- <td>2012/12/02</td>
                        <td>$372,000</td> -->
                      </tr>
                      <tr>
                        <td>Herrod Chandler</td>
                        <td>Desactivo</td>
                        <td><a href="dashboard.php" class="btn btn-success" role="button" aria-pressed="true">Alta</a></td>
                        <td><a href="dashboard.php" class="btn btn-danger" role="button" aria-pressed="true">Baja</a></td>
                        <td><a href="dashboard.php" class="btn btn-warning" role="button" aria-pressed="true">Editar</a></td>
                        <!-- <td>2012/08/06</td>
                        <td>$137,500</td> -->
                      </tr>
                      <tr>
                        <td>Rhona Davidson</td>
                        <td>Desactivo</td>
                        <td><a href="dashboard.php" class="btn btn-success" role="button" aria-pressed="true">Alta</a></td>
                        <td><a href="dashboard.php" class="btn btn-danger" role="button" aria-pressed="true">Baja</a></td>
                        <td><a href="dashboard.php" class="btn btn-warning" role="button" aria-pressed="true">Editar</a></td>
                        <!-- <td>2010/10/14</td>
                        <td>$327,900</td> -->
                      </tr>
                      <tr>
                        <td>Colleen Hurst</td>
                        <td>Activo</td>
                        <td><a href="dashboard.php" class="btn btn-success" role="button" aria-pressed="true">Alta</a></td>
                        <td><a href="dashboard.php" class="btn btn-danger" role="button" aria-pressed="true">Baja</a></td>
                        <td><a href="dashboard.php" class="btn btn-warning" role="button" aria-pressed="true">Editar</a></td>
                        <!-- <td>2009/09/15</td>
                        <td>$205,500</td> -->
                      </tr>
                      <tr>
                        <td>Sonya Frost</td>
                        <td>Activo</td>
                        <td><a href="dashboard.php" class="btn btn-success" role="button" aria-pressed="true">Alta</a></td>
                        <td><a href="dashboard.php" class="btn btn-danger" role="button" aria-pressed="true">Baja</a></td>
                        <td><a href="dashboard.php" class="btn btn-warning" role="button" aria-pressed="true">Editar</a></td>
                        <!-- <td>2008/12/13</td>
                        <td>$103,600</td> -->
                      </tr>
                      <tr>
                        <td>Jena Gaines</td>
                        <td>Activo</td>
                        <td><a href="dashboard.php" class="btn btn-success" role="button" aria-pressed="true">Alta</a></td>
                        <td><a href="dashboard.php" class="btn btn-danger" role="button" aria-pressed="true">Baja</a></td>
                        <td><a href="dashboard.php" class="btn btn-warning" role="button" aria-pressed="true">Editar</a></td>
                        <!-- <td>2008/12/19</td>
                        <td>$90,560</td> -->
                      </tr>
                      <tr>
                        <td>Quinn Flynn</td>
                        <td>Desactivo</td>
                        <td><a href="dashboard.php" class="btn btn-success" role="button" aria-pressed="true">Alta</a></td>
                        <td><a href="dashboard.php" class="btn btn-danger" role="button" aria-pressed="true">Baja</a></td>
                        <td><a href="dashboard.php" class="btn btn-warning" role="button" aria-pressed="true">Editar</a></td>
                        <!-- <td>2013/03/03</td>
                        <td>$342,000</td> -->
                      </tr>
                      <tr>
                        <td>Charde Marshall</td>
                        <td>Activo</td>
                        <td><a href="dashboard.php" class="btn btn-success" role="button" aria-pressed="true">Alta</a></td>
                        <td><a href="dashboard.php" class="btn btn-danger" role="button" aria-pressed="true">Baja</a></td>
                        <td><a href="dashboard.php" class="btn btn-warning" role="button" aria-pressed="true">Editar</a></td>
                        <!-- <td>2008/10/16</td>
                        <td>$470,600</td> -->
                      </tr>
                      <tr>
                        <td>Haley Kennedy</td>
                        <td>Activo</td>
                        <td><a href="dashboard.php" class="btn btn-success" role="button" aria-pressed="true">Alta</a></td>
                        <td><a href="dashboard.php" class="btn btn-danger" role="button" aria-pressed="true">Baja</a></td>
                        <td><a href="dashboard.php" class="btn btn-warning" role="button" aria-pressed="true">Editar</a></td>
                        <!-- <td>2012/12/18</td>
                        <td>$313,500</td> -->
                      </tr>
                      <tr>
                        <td>Tatyana Fitzpatrick</td>
                        <td>Activo</td>
                        <td><a href="dashboard.php" class="btn btn-success" role="button" aria-pressed="true">Alta</a></td>
                        <td><a href="dashboard.php" class="btn btn-danger" role="button" aria-pressed="true">Baja</a></td>
                        <td><a href="dashboard.php" class="btn btn-warning" role="button" aria-pressed="true">Editar</a></td>
                        <!-- <td>2010/03/17</td>
                        <td>$385,750</td> -->
                      </tr>
                      <tr>
                        <td>Michael Silva</td>
                        <td>Desactivo</td>
                        <td><a href="dashboard.php" class="btn btn-success" role="button" aria-pressed="true">Alta</a></td>
                        <td><a href="dashboard.php" class="btn btn-danger" role="button" aria-pressed="true">Baja</a></td>
                        <td><a href="dashboard.php" class="btn btn-warning" role="button" aria-pressed="true">Editar</a></td>
                        <!-- <td>2012/11/27</td>
                        <td>$198,500</td> -->
                      </tr>
                      <tr>
                        <td>Paul Byrd</td>
                        <td>Activo</td>
                        <td><a href="dashboard.php" class="btn btn-success" role="button" aria-pressed="true">Alta</a></td>
                        <td><a href="dashboard.php" class="btn btn-danger" role="button" aria-pressed="true">Baja</a></td>
                        <td><a href="dashboard.php" class="btn btn-warning" role="button" aria-pressed="true">Editar</a></td>
                        <!-- <td>2010/06/09</td>
                        <td>$725,000</td> -->
                      </tr>
                      <tr>
                        <td>Gloria Little</td>
                        <td>Activo</td>
                        <td><a href="dashboard.php" class="btn btn-success" role="button" aria-pressed="true">Alta</a></td>
                        <td><a href="dashboard.php" class="btn btn-danger" role="button" aria-pressed="true">Baja</a></td>
                        <td><a href="dashboard.php" class="btn btn-warning" role="button" aria-pressed="true">Editar</a></td>
                        <!-- <td>2009/04/10</td>
                        <td>$237,500</td> -->
                      </tr>
                      <tr>
                        <td>Bradley Greer</td>
                        <td>Activo</td>
                        <td><a href="dashboard.php" class="btn btn-success" role="button" aria-pressed="true">Alta</a></td>
                        <td><a href="dashboard.php" class="btn btn-danger" role="button" aria-pressed="true">Baja</a></td>
                        <td><a href="dashboard.php" class="btn btn-warning" role="button" aria-pressed="true">Editar</a></td>
                        <!-- <td>2012/10/13</td>
                        <td>$132,000</td> -->
                      </tr>
                      <tr>
                        <td>Dai Rios</td>
                        <td>Activo</td>
                        <td><a href="dashboard.php" class="btn btn-success" role="button" aria-pressed="true">Alta</a></td>
                        <td><a href="dashboard.php" class="btn btn-danger" role="button" aria-pressed="true">Baja</a></td>
                        <td><a href="dashboard.php" class="btn btn-warning" role="button" aria-pressed="true">Editar</a></td>
                        <!-- <td>2012/09/26</td>
                        <td>$217,500</td> -->
                      </tr>
                      <tr>
                        <td>Jenette Caldwell</td>
                        <td>Activo</td>
                        <td><a href="dashboard.php" class="btn btn-success" role="button" aria-pressed="true">Alta</a></td>
                        <td><a href="dashboard.php" class="btn btn-danger" role="button" aria-pressed="true">Baja</a></td>
                        <td><a href="dashboard.php" class="btn btn-warning" role="button" aria-pressed="true">Editar</a></td>
                        <!-- <td>2011/09/03</td>
                        <td>$345,000</td> -->
                      </tr>
                      <tr>
                        <td>Yuri Berry</td>
                        <td>Activo</td>
                        <td><a href="dashboard.php" class="btn btn-success" role="button" aria-pressed="true">Alta</a></td>
                        <td><a href="dashboard.php" class="btn btn-danger" role="button" aria-pressed="true">Baja</a></td>
                        <td><a href="dashboard.php" class="btn btn-warning" role="button" aria-pressed="true">Editar</a></td>
                        <!-- <td>2009/06/25</td>
                        <td>$675,000</td> -->
                      </tr>
                      <tr>
                        <td>Caesar Vance</td>
                        <td>Activo</td>
                        <td><a href="dashboard.php" class="btn btn-success" role="button" aria-pressed="true">Alta</a></td>
                        <td><a href="dashboard.php" class="btn btn-danger" role="button" aria-pressed="true">Baja</a></td>
                        <td><a href="dashboard.php" class="btn btn-warning" role="button" aria-pressed="true">Editar</a></td>
                        <!-- <td>2011/12/12</td>
                        <td>$106,450</td> -->
                      </tr>
                      <tr>
                        <td>Doris Wilder</td>
                        <td>Activo</td>
                        <td><a href="dashboard.php" class="btn btn-success" role="button" aria-pressed="true">Alta</a></td>
                        <td><a href="dashboard.php" class="btn btn-danger" role="button" aria-pressed="true">Baja</a></td>
                        <td><a href="dashboard.php" class="btn btn-warning" role="button" aria-pressed="true">Editar</a></td>
                        <!-- <td>2010/09/20</td>
                        <td>$85,600</td> -->
                      </tr>
                      <tr>
                        <td>Angelica Ramos</td>
                        <td>Activo</td>
                        <td><a href="dashboard.php" class="btn btn-success" role="button" aria-pressed="true">Alta</a></td>
                        <td><a href="dashboard.php" class="btn btn-danger" role="button" aria-pressed="true">Baja</a></td>
                        <td><a href="dashboard.php" class="btn btn-warning" role="button" aria-pressed="true">Editar</a></td>
                        <!-- <td>2009/10/09</td>
                        <td>$1,200,000</td> -->
                      </tr>
                      <tr>
                        <td>Gavin Joyce</td>
                        <td>Activo</td>
                        <td><a href="dashboard.php" class="btn btn-success" role="button" aria-pressed="true">Alta</a></td>
                        <td><a href="dashboard.php" class="btn btn-danger" role="button" aria-pressed="true">Baja</a></td>
                        <td><a href="dashboard.php" class="btn btn-warning" role="button" aria-pressed="true">Editar</a></td>
                        <!-- <td>2010/12/22</td>
                        <td>$92,575</td> -->
                      </tr>
                      <tr>
                        <td>Jennifer Chang</td>
                        <td>Activo</td>
                        <td><a href="dashboard.php" class="btn btn-success" role="button" aria-pressed="true">Alta</a></td>
                        <td><a href="dashboard.php" class="btn btn-danger" role="button" aria-pressed="true">Baja</a></td>
                        <td><a href="dashboard.php" class="btn btn-warning" role="button" aria-pressed="true">Editar</a></td>
                        <!-- <td>2010/11/14</td>
                        <td>$357,650</td> -->
                      </tr>
                      <tr>
                        <td>Brenden Wagner</td>
                        <td>Activo</td>
                        <td><a href="dashboard.php" class="btn btn-success" role="button" aria-pressed="true">Alta</a></td>
                        <td><a href="dashboard.php" class="btn btn-danger" role="button" aria-pressed="true">Baja</a></td>
                        <td><a href="dashboard.php" class="btn btn-warning" role="button" aria-pressed="true">Editar</a></td>
                        <!-- <td>2011/06/07</td>
                        <td>$206,850</td> -->
                      </tr>
                      <tr>
                        <td>Fiona Green</td>
                        <td>Activo</td>
                        <td><a href="dashboard.php" class="btn btn-success" role="button" aria-pressed="true">Alta</a></td>
                        <td><a href="dashboard.php" class="btn btn-danger" role="button" aria-pressed="true">Baja</a></td>
                        <td><a href="dashboard.php" class="btn btn-warning" role="button" aria-pressed="true">Editar</a></td>
                        <!-- <td>2010/03/11</td>
                        <td>$850,000</td> -->
                      </tr>
                      <tr>
                        <td>Shou Itou</td>
                        <td>Activo</td>
                        <td><a href="dashboard.php" class="btn btn-success" role="button" aria-pressed="true">Alta</a></td>
                        <td><a href="dashboard.php" class="btn btn-danger" role="button" aria-pressed="true">Baja</a></td>
                        <td><a href="dashboard.php" class="btn btn-warning" role="button" aria-pressed="true">Editar</a></td>
                        <!-- <td>2011/08/14</td>
                        <td>$163,000</td> -->
                      </tr>
                      <tr>
                        <td>Michelle House</td>
                        <td>Activo</td>
                        <td><a href="dashboard.php" class="btn btn-success" role="button" aria-pressed="true">Alta</a></td>
                        <td><a href="dashboard.php" class="btn btn-danger" role="button" aria-pressed="true">Baja</a></td>
                        <td><a href="dashboard.php" class="btn btn-warning" role="button" aria-pressed="true">Editar</a></td>
                        <!-- <td>2011/06/02</td>
                        <td>$95,400</td> -->
                      </tr>
                      <tr>
                        <td>Suki Burks</td>
                        <td>Activo</td>
                        <td><a href="dashboard.php" class="btn btn-success" role="button" aria-pressed="true">Alta</a></td>
                        <td><a href="dashboard.php" class="btn btn-danger" role="button" aria-pressed="true">Baja</a></td>
                        <td><a href="dashboard.php" class="btn btn-warning" role="button" aria-pressed="true">Editar</a></td>
                        <!-- <td>2009/10/22</td>
                        <td>$114,500</td> -->
                      </tr>
                      <tr>
                        <td>Prescott Bartlett</td>
                        <td>Activo</td>
                        <td><a href="dashboard.php" class="btn btn-success" role="button" aria-pressed="true">Alta</a></td>
                        <td><a href="dashboard.php" class="btn btn-danger" role="button" aria-pressed="true">Baja</a></td>
                        <td><a href="dashboard.php" class="btn btn-warning" role="button" aria-pressed="true">Editar</a></td>
                        <!-- <td>2011/05/07</td>
                        <td>$145,000</td> -->
                      </tr>
                      <tr>
                        <td>Gavin Cortez</td>
                        <td>Activo</td>
                        <td><a href="dashboard.php" class="btn btn-success" role="button" aria-pressed="true">Alta</a></td>
                        <td><a href="dashboard.php" class="btn btn-danger" role="button" aria-pressed="true">Baja</a></td>
                        <td><a href="dashboard.php" class="btn btn-warning" role="button" aria-pressed="true">Editar</a></td>
                        <!-- <td>2008/10/26</td>
                        <td>$235,500</td> -->
                      </tr>
                      <tr>
                        <td>Martena Mccray</td>
                        <td>Activo</td>
                        <td><a href="dashboard.php" class="btn btn-success" role="button" aria-pressed="true">Alta</a></td>
                        <td><a href="dashboard.php" class="btn btn-danger" role="button" aria-pressed="true">Baja</a></td>
                        <td><a href="dashboard.php" class="btn btn-warning" role="button" aria-pressed="true">Editar</a></td>
                        <!-- <td>2011/03/09</td>
                        <td>$324,050</td> -->
                      </tr>
                      <tr>
                        <td>Unity Butler</td>
                        <td>Activo</td>
                        <td><a href="dashboard.php" class="btn btn-success" role="button" aria-pressed="true">Alta</a></td>
                        <td><a href="dashboard.php" class="btn btn-danger" role="button" aria-pressed="true">Baja</a></td>
                        <td><a href="dashboard.php" class="btn btn-warning" role="button" aria-pressed="true">Editar</a></td>
                        <!-- <td>2009/12/09</td>
                        <td>$85,675</td> -->
                      </tr>
                      <tr>
                        <td>Howard Hatfield</td>
                        <td>Activo</td>
                        <td><a href="dashboard.php" class="btn btn-success" role="button" aria-pressed="true">Alta</a></td>
                        <td><a href="dashboard.php" class="btn btn-danger" role="button" aria-pressed="true">Baja</a></td>
                        <td><a href="dashboard.php" class="btn btn-warning" role="button" aria-pressed="true">Editar</a></td>
                        <!-- <td>2008/12/16</td>
                        <td>$164,500</td> -->
                      </tr>
                      <tr>
                        <td>Hope Fuentes</td>
                        <td>Activo</td>
                        <td><a href="dashboard.php" class="btn btn-success" role="button" aria-pressed="true">Alta</a></td>
                        <td><a href="dashboard.php" class="btn btn-danger" role="button" aria-pressed="true">Baja</a></td>
                        <td><a href="dashboard.php" class="btn btn-warning" role="button" aria-pressed="true">Editar</a></td>
                        <!-- <td>2010/02/12</td>
                        <td>$109,850</td> -->
                      </tr>
                      <tr>
                        <td>Vivian Harrell</td>
                        <td>Activo</td>
                        <td><a href="dashboard.php" class="btn btn-success" role="button" aria-pressed="true">Alta</a></td>
                        <td><a href="dashboard.php" class="btn btn-danger" role="button" aria-pressed="true">Baja</a></td>
                        <td><a href="dashboard.php" class="btn btn-warning" role="button" aria-pressed="true">Editar</a></td>
                        <!-- <td>2009/02/14</td>
                        <td>$452,500</td> -->
                      </tr>
                      <tr>
                        <td>Timothy Mooney</td>
                        <td>Activo</td>
                        <td><a href="dashboard.php" class="btn btn-success" role="button" aria-pressed="true">Alta</a></td>
                        <td><a href="dashboard.php" class="btn btn-danger" role="button" aria-pressed="true">Baja</a></td>
                        <td><a href="dashboard.php" class="btn btn-warning" role="button" aria-pressed="true">Editar</a></td>
                        <!-- <td>2008/12/11</td>
                        <td>$136,200</td> -->
                      </tr>
                      <tr>
                        <td>Jackson Bradshaw</td>
                        <td>Activo</td>
                        <td><a href="dashboard.php" class="btn btn-success" role="button" aria-pressed="true">Alta</a></td>
                        <td><a href="dashboard.php" class="btn btn-danger" role="button" aria-pressed="true">Baja</a></td>
                        <td><a href="dashboard.php" class="btn btn-warning" role="button" aria-pressed="true">Editar</a></td>
                        <!-- <td>2008/09/26</td>
                        <td>$645,750</td> -->
                      </tr>
                      <tr>
                        <td>Olivia Liang</td>
                        <td>Activo</td>
                        <td><a href="dashboard.php" class="btn btn-success" role="button" aria-pressed="true">Alta</a></td>
                        <td><a href="dashboard.php" class="btn btn-danger" role="button" aria-pressed="true">Baja</a></td>
                        <td><a href="dashboard.php" class="btn btn-warning" role="button" aria-pressed="true">Editar</a></td>
                        <!-- <td>2011/02/03</td>
                        <td>$234,500</td> -->
                      </tr>
                      <tr>
                        <td>Bruno Nash</td>
                        <td>Activo</td>
                        <td><a href="dashboard.php" class="btn btn-success" role="button" aria-pressed="true">Alta</a></td>
                        <td><a href="dashboard.php" class="btn btn-danger" role="button" aria-pressed="true">Baja</a></td>
                        <td><a href="dashboard.php" class="btn btn-warning" role="button" aria-pressed="true">Editar</a></td>
                        <!-- <td>2011/05/03</td>
                        <td>$163,500</td> -->
                      </tr>
                      <tr>
                        <td>Sakura Yamamoto</td>
                        <td>Activo</td>
                        <td><a href="dashboard.php" class="btn btn-success" role="button" aria-pressed="true">Alta</a></td>
                        <td><a href="dashboard.php" class="btn btn-danger" role="button" aria-pressed="true">Baja</a></td>
                        <td><a href="dashboard.php" class="btn btn-warning" role="button" aria-pressed="true">Editar</a></td>
                        <!-- <td>2009/08/19</td>
                        <td>$139,575</td> -->
                      </tr>
                      <tr>
                        <td>Thor Walton</td>
                        <td>Activo</td>
                        <td><a href="dashboard.php" class="btn btn-success" role="button" aria-pressed="true">Alta</a></td>
                        <td><a href="dashboard.php" class="btn btn-danger" role="button" aria-pressed="true">Baja</a></td>
                        <td><a href="dashboard.php" class="btn btn-warning" role="button" aria-pressed="true">Editar</a></td>
                        <!-- <td>2013/08/11</td>
                        <td>$98,540</td> -->
                      </tr>
                      <tr>
                        <td>Finn Camacho</td>
                        <td>Activo</td>
                        <td><a href="dashboard.php" class="btn btn-success" role="button" aria-pressed="true">Alta</a></td>
                        <td><a href="dashboard.php" class="btn btn-danger" role="button" aria-pressed="true">Baja</a></td>
                        <td><a href="dashboard.php" class="btn btn-warning" role="button" aria-pressed="true">Editar</a></td>
                        <!-- <td>2009/07/07</td>
                        <td>$87,500</td> -->
                      </tr>
                      <tr>
                        <td>Serge Baldwin</td>
                        <td>Activo</td>
                        <td><a href="dashboard.php" class="btn btn-success" role="button" aria-pressed="true">Alta</a></td>
                        <td><a href="dashboard.php" class="btn btn-danger" role="button" aria-pressed="true">Baja</a></td>
                        <td><a href="dashboard.php" class="btn btn-warning" role="button" aria-pressed="true">Editar</a></td>
                        <!-- <td>2012/04/09</td>
                        <td>$138,575</td> -->
                      </tr>
                      <tr>
                        <td>Zenaida Frank</td>
                        <td>Activo</td>
                        <td><a href="dashboard.php" class="btn btn-success" role="button" aria-pressed="true">Alta</a></td>
                        <td><a href="dashboard.php" class="btn btn-danger" role="button" aria-pressed="true">Baja</a></td>
                        <td><a href="dashboard.php" class="btn btn-warning" role="button" aria-pressed="true">Editar</a></td>
                        <!-- <td>2010/01/04</td>
                        <td>$125,250</td> -->
                      </tr>
                      <tr>
                        <td>Zorita Serrano</td>
                        <td>Activo</td>
                        <td><a href="dashboard.php" class="btn btn-success" role="button" aria-pressed="true">Alta</a></td>
                        <td><a href="dashboard.php" class="btn btn-danger" role="button" aria-pressed="true">Baja</a></td>
                        <td><a href="dashboard.php" class="btn btn-warning" role="button" aria-pressed="true">Editar</a></td>
                        <!-- <td>2012/06/01</td>
                        <td>$115,000</td> -->
                      </tr>
                      <tr>
                        <td>Jennifer Acosta</td>
                        <td>Activo</td>
                        <td><a href="dashboard.php" class="btn btn-success" role="button" aria-pressed="true">Alta</a></td>
                        <td><a href="dashboard.php" class="btn btn-danger" role="button" aria-pressed="true">Baja</a></td>
                        <td><a href="dashboard.php" class="btn btn-warning" role="button" aria-pressed="true">Editar</a></td>
                        <!-- <td>2013/02/01</td>
                        <td>$75,650</td> -->
                      </tr>
                      <tr>
                        <td>Cara Stevens</td>
                        <td>Activo</td>
                        <td><a href="dashboard.php" class="btn btn-success" role="button" aria-pressed="true">Alta</a></td>
                        <td><a href="dashboard.php" class="btn btn-danger" role="button" aria-pressed="true">Baja</a></td>
                        <td><a href="dashboard.php" class="btn btn-warning" role="button" aria-pressed="true">Editar</a></td>
                        <!-- <td>2011/12/06</td>
                        <td>$145,600</td> -->
                      </tr>
                      <tr>
                        <td>Hermione Butler</td>
                        <td>Activo</td>
                        <td><a href="dashboard.php" class="btn btn-success" role="button" aria-pressed="true">Alta</a></td>
                        <td><a href="dashboard.php" class="btn btn-danger" role="button" aria-pressed="true">Baja</a></td>
                        <td><a href="dashboard.php" class="btn btn-warning" role="button" aria-pressed="true">Editar</a></td>
                        <!-- <td>2011/03/21</td>
                        <td>$356,250</td> -->
                      </tr>
                      <tr>
                        <td>Lael Greer</td>
                        <td>Activo</td>
                        <td><a href="dashboard.php" class="btn btn-success" role="button" aria-pressed="true">Alta</a></td>
                        <td><a href="dashboard.php" class="btn btn-danger" role="button" aria-pressed="true">Baja</a></td>
                        <td><a href="dashboard.php" class="btn btn-warning" role="button" aria-pressed="true">Editar</a></td>
                        <!-- <td>2009/02/27</td>
                        <td>$103,500</td> -->
                      </tr>
                      <tr>
                        <td>Jonas Alexander</td>
                        <td>Activo</td>
                        <td><a href="dashboard.php" class="btn btn-success" role="button" aria-pressed="true">Alta</a></td>
                        <td><a href="dashboard.php" class="btn btn-danger" role="button" aria-pressed="true">Baja</a></td>
                        <td><a href="dashboard.php" class="btn btn-warning" role="button" aria-pressed="true">Editar</a></td>
                        <!-- <td>2010/07/14</td>
                        <td>$86,500</td> -->
                      </tr>
                      <tr>
                        <td>Shad Decker</td>
                        <td>Activo</td>
                        <td><a href="dashboard.php" class="btn btn-success" role="button" aria-pressed="true">Alta</a></td>
                        <td><a href="dashboard.php" class="btn btn-danger" role="button" aria-pressed="true">Baja</a></td>
                        <td><a href="dashboard.php" class="btn btn-warning" role="button" aria-pressed="true">Editar</a></td>
                        <!-- <td>2008/11/13</td>
                        <td>$183,000</td> -->
                      </tr>
                      <tr>
                        <td>Michael Bruce</td>
                        <td>Activo</td>
                        <td><a href="dashboard.php" class="btn btn-success" role="button" aria-pressed="true">Alta</a></td>
                        <td><a href="dashboard.php" class="btn btn-danger" role="button" aria-pressed="true">Baja</a></td>
                        <td><a href="dashboard.php" class="btn btn-warning" role="button" aria-pressed="true">Editar</a></td>
                        <!-- <td>2011/06/27</td>
                        <td>$183,000</td> -->
                      </tr>
                      <tr>
                        <td>Donna Snider</td>
                        <td>Activo</td>
                        <td><a href="dashboard.php" class="btn btn-success" role="button" aria-pressed="true">Alta</a></td>
                        <td><a href="dashboard.php" class="btn btn-danger" role="button" aria-pressed="true">Baja</a></td>
                        <td><a href="dashboard.php" class="btn btn-warning" role="button" aria-pressed="true">Editar</a></td>
                        <!-- <td>2011/01/25</td>
                        <td>$112,000</td> -->
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

</body>

</html>

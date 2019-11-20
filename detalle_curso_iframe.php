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
 * Listado de usuarios inscritos en un curso
 *
 * @package     local_hoteles_city_dashboard
 * @category    admin
 * @copyright   2019 Subitus <contacto@subitus.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/lib.php');
local_hoteles_city_dashboard_user_has_access(local_hoteles_city_dashboard_reportes);
$PAGE->set_context(context_system::instance());
$courseid = optional_param('courseid', -1, PARAM_INT);
// $course = $DB->get_record('course', array('id' => $courseid), 'id, fullname', MUST_EXIST);
$PAGE->set_url($CFG->wwwroot . '/local/hoteles_city_dashboard/detalle_curso_iframe.php');
$PAGE->set_pagelayout('admin');
$PAGE->set_title('Detalle cursos');


// echo $OUTPUT->header();
$report_info = local_hoteles_city_dashboard_get_report_columns(local_hoteles_city_dashboard_course_users_pagination);
$courses = local_hoteles_city_dashboard_get_courses_setting(true);
if($courseid != -1){
    $default_courses = $courseid;
}else{
    $default_courses = implode(',', array_keys($courses));
}
$description = ""; // No es usado en esta sección
echo "<div class='container row'> <input type='hidden' name='request_type' value='course_users_pagination'>" .
 local_hoteles_city_dashboard_print_multiselect('report_courses', "Cursos", $default_courses, $courses, true, $class = 'col-sm-12') . "</div>";

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
    
</head>
<body style="background-color: #ecedf1; max-width: 100%;">

<!-- Div para pintar la grafica del curso -->
<div class="row" style="justify-content: center;">
        <div class="col-8">
                    <div class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary"><a href="#">Comparativa</a></h6>
                            <div class="dropdown no-arrow">
                                <!-- <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                </a> -->
                                
                            </div>
                        </div>
                        <!-- Card Body -->
                        <div class="card-body">
                            <div class="">                  
                                <canvas id="grafica"></canvas>                  
                            </div>
                        </div>    
                    </div>
        </div>
    </div>

<table id='empTable' class='display dataTable table table-bordered'>    
    <thead>
        <tr>
            <?php echo $report_info->table_code; ?>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <?php echo $report_info->table_code; ?>
        </tr>
    </tfoot>
</table>

<link href="css/sb-admin-2.min.css" rel="stylesheet">
<script src="vendor/chart.js/Chart.min.js"></script>
<script>
    var ctx = document.getElementById('grafica');
    var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'pie',

    // The data for our dataset
    data: {
        labels: ['Completado', 'No Completado'],
        datasets: [{
            label: 'A',            
            backgroundColor: ["#1cc88a", "#e74a3b"],
            data: [60, 40],
        }]
    },

    // Configuration options go here
    options: {
        
    }
    });
    </script>




<!-- Datatable CSS -->
<link href='datatables/jquery.dataTables.min.css' rel='stylesheet' type='text/css'>

<!-- <link href='//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css' rel='stylesheet' type='text/css'> -->
<link href="datatables/buttons.dataTables.min.css" rel="stylesheet">

<!-- jQuery Library -->
<script src="vendor/jquery/jquery.min.js"></script>

<!-- Datatable JS -->
<script src="datatables/jquery.dataTables.min.js"></script>
<script src="datatables/dataTables.buttons.min.js"></script>
<script src="datatables/buttons.flash.min.js"></script>
<script src="datatables/jszip.min.js"></script>
<script src="datatables/pdfmake.min.js"></script>
<script src="datatables/vfs_fonts.js"></script>
<script src="datatables/buttons.html5.min.js"></script>
<script src="datatables/buttons.print.min.js"></script>

<link rel="stylesheet" href="choicesjs/styles/choices.min.css" />
<script src="choicesjs/scripts/choices.min.js"></script>

<!-- Table -->
<script>
    var _datatable;
    var reportCourses;
    $(document).ready(function(){
        
        $('select[multiple]').each(function(index, element){ // Generación de filtros con herramenta choices.js
            var multipleCancelButton = new Choices( '#' + element.id, { removeItemButton: true, searchEnabled: true,
                placeholder: true,
            } );
        });
        reportCourses = "<?php echo $default_courses; ?>";

        _datatable = $('#empTable').DataTable({
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            'ajax': {
                'url':'services.php',
                data: function(d){
                    d['request_type'] = 'course_users_pagination';
                    d['reportCourses'] = reportCourses;
                }
            },
            lengthMenu: [[10, 15, 20, 100, -1], [10, 15, 20, 100, "Todos los registros"]],
            'dom': 'Bfrtip',
            "pageLength": 10,
            buttons: [
                {
                    extend: 'excel',
                    text: '<span class="fa fa-file-excel-o"></span> Exportar a excel',
                    exportOptions: {
                        modifier: {
                            search: 'applied',
                            order: 'applied'
                        },
                        columns: [<?php echo $report_info->ajax_printed_rows; ?>],
                    },
                },
                {
                    extend: 'excel',
                    text: '<span class="fa fa-file-o"></span> Exportar a CSV',
                    exportOptions: {
                        modifier: {
                            search: 'applied',
                            order: 'applied'
                        },
                        columns: [<?php echo $report_info->ajax_printed_rows; ?>],
                    },
                },
                'pageLength',
            ],
            'columns': [
                <?php echo $report_info->ajax_code; ?>
            ],
            language: {
                "url": "datatables/Spanish.json",

                "emptyTable":     "No se encontró información",
                // "infoFiltered":   "(filtered from _MAX_ total entries)",
                "loadingRecords": "Cargando...",
                "processing":     "Procesando...",
                "search":         "Búsqueda:",
                // "zeroRecords":    "No matching records found",
                "paginate": {
                    "first":      "Primera",
                    "last":       "Última",
                    "next":       "Siguiente",
                    "previous":   "Anterior"
                },
                buttons: {
                    pageLength: {
                        _: "Mostrando %d filas",
                        '-1': "Mostrando todas las filas"
                    }
                }
            },
            "columnDefs": [
                { "targets": [<?php echo $report_info->ajax_link_fields; ?>], "orderable": false }
            ]
            // language: {
            // },
            // buttons: [ { extend: 'excel', action: newExportAction } ],
        });
        $('#report_courses').change(function(){ // Recargar página al seleccionar curso
            reportCourses = $('#report_courses').val();
            // console.log('Reload');
            _datatable.ajax.reload();
        });

        /**
         Función que se ejecuta al elegir/quitar cursos
         */
        function graficaDeCursos(){
            
        }
    });
</script>

</body>
</html>
<?php
// echo $OUTPUT->footer();
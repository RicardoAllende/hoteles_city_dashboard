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
 * Listado de usuarios seccionados a los que el usuario tenga acceso
 *
 * @package     local_hoteles_city_dashboard
 * @category    admin
 * @copyright   2019 Subitus <contacto@subitus.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/lib.php');
$PAGE->set_context(context_system::instance());
$PAGE->set_url($CFG->wwwroot . '/local/hoteles_city_dashboard/usuarios_iframe.php');
$type = optional_param('type', local_hoteles_city_dashboard_all_users_pagination, PARAM_INT);

$title = local_hoteles_city_dashboard_get_pagination_name($type);

$PAGE->set_title($title);
$PAGE->set_pagelayout('admin');
$report_info = local_hoteles_city_dashboard_get_report_columns($type);
// echo $OUTPUT->header();
// echo local_hoteles_city_dashboard_print_theme_variables();
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>

    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">    
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <!-- Custom styles for this page -->
    <!-- <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet"> -->

    

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

<body>

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

<!-- Table -->
<script>
    $(document).ready(function(){
        $('#empTable').DataTable({
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            'ajax': {
                'url':'services.php',
                data: {
                    request_type: 'all_users_pagination',
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
                // "decimal":        "",
                // "info":           "Showing _START_ to _END_ of _TOTAL_ entries",
                // "infoEmpty":      "Showing 0 to 0 of 0 entries",
                // "infoPostFix":    "",
                // "thousands":      ",",
                // "lengthMenu":     "Show _MENU_ entries",
                // "aria": {
                //     "sortAscending":  ": activate to sort column ascending",
                //     "sortDescending": ": activate to sort column descending"
                // }
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
    });
</script>

</body>
</html>
<?php
// echo $OUTPUT->footer();
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
 * Página de pruebas
 *
 * @package     local_hoteles_city_dashboard
 * @category    admin
 * @copyright   2019 Subitus <contacto@subitus.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/lib.php');
$PAGE->set_context(context_system::instance());
$PAGE->set_title('Pruebas hoteles city');
$PAGE->set_url($CFG->wwwroot . '/local/hoteles_city_dashboard/ejemplo_ajax.php');

echo $OUTPUT->header();
// foreach (local_hoteles_city_dashboard_get_courses() as $key => $course) {
//     _print($course->fullname, local_hoteles_city_dashboard_get_course_information($course->id));
// }
$report_info = local_hoteles_city_dashboard_get_report_columns();
?>

<!-- Datatable CSS -->
<link href='//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.0/css/buttons.dataTables.min.css">
<table id='empTable' class='display dataTable'>    
    <thead>
        <tr>
            <?php echo $report_info->table_code; ?>
        </tr>
    </thead>
</table>

<!-- jQuery Library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- Datatable JS -->
<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.print.min.js"></script>

<!-- Table -->
<script>
    $(document).ready(function(){
        $('#empTable').DataTable({
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            'ajax': {
                'url':'ajax_file.php'
            },
            lengthMenu: [[10, 20, 100, -1], [10, 20, 100, "Todos los registros"]],
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
                        }
                    }
                }, 'pageLength'
            ],
            'columns': [
                <?php echo $report_info->ajax_code; ?>
            ],
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
            },
            language: {
                buttons: {
                    pageLength: {
                        _: "Mostrando %d filas",
                        '-1': "Mostrando todas las filas"
                    }
                }
            },
            // buttons: [ { extend: 'excel', action: newExportAction } ],
        });
    });
</script>
<?php
echo $OUTPUT->footer();
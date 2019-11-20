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
$PAGE->set_url($CFG->wwwroot . '/local/hoteles_city_dashboard/detalle_curso.php');
$PAGE->set_pagelayout('admin');
$PAGE->set_title('Detalle cursos');


echo $OUTPUT->header();
$report_info = local_hoteles_city_dashboard_get_report_columns(local_hoteles_city_dashboard_course_users_pagination);
$courses = local_hoteles_city_dashboard_get_courses_setting(true);
$url = $CFG->wwwroot . '/local/hoteles_city_dashboard/detalle_curso_iframe.php';
if($courseid != -1){
    $url .= "?courseid=" . $courseid;
    $default_courses = $courseid;
}else{
    $default_courses = implode(',', array_keys($courses));
}
$description = ""; // No es usado en esta sección
// echo "<div class='container row'> <input type='hidden' name='request_type' value='course_users_pagination'>" .
//  local_hoteles_city_dashboard_print_multiselect('report_courses', "Cursos", $default_courses, $courses, true, $class = 'col-sm-12') . "</div>";
//  echo $OUTPUT->header();


 ?>
    <iframe src="<?php echo $url; ?>" id="page_iframe" frameborder="0" style="width: 100%; overflow: hidden;"></iframe>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById('region-main').style.width = "100%";
            require(['jquery'], function ($) {
                setInterval(function() { iResize('page_iframe'); }, 100);
            });
        });
        function iResize(frame_id) {
            element = document.getElementById(frame_id);
            if(element != null){
                if(element.contentWindow != null){
                    if(element.contentWindow.document != null){
                        if(element.contentWindow.document.body != null){
                            if(element.contentWindow.document.body.offsetHeight != null){
                                size = (element.contentWindow.document.body.offsetHeight ) + 'px';
                                // console.log(size);
                                document.getElementById(frame_id).style.height = "1500px";
                            }
                        }
                    }
                }
            }
        }
    
    </script>
 <?php
 
 echo $OUTPUT->footer();
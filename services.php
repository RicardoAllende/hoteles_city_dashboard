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
 * Plugin administration pages are defined here.
 *
 * @package     local_hoteles_city_dashboard
 * @category    admin
 * @copyright   2019 Subitus <contacto@subitus.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

header("Content-Type: application/json");
require_once(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/lib.php');
$context_system = context_system::instance();
if( ! has_capability('local/hoteles_city_dashboard:view', $context_system) ){
    die(local_hoteles_city_dashboard_error_response("Usuario no autenticado"));
}
if($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['request_type'])){
    $request_type = $_POST['request_type'];
    switch($request_type){
        case 'course_completion':
            if(!empty($_POST['courseid'])){
                $courseid = $_POST['courseid'];
                die(local_hoteles_city_dashboard_format_response(local_hoteles_city_dashboard_get_course_information($courseid, $params = $_POST)));
            }else{
                die(local_hoteles_city_dashboard_error_response("courseid (int) not found"));
            }
            break;
        case 'course_list':
            if(isset($_POST['type'])){
                die(local_hoteles_city_dashboard_format_response(local_hoteles_city_dashboard_get_courses_overview($_POST['type'], $_POST)));
            }else{
                die(local_hoteles_city_dashboard_error_response('type (int) not found'));
            }
            break;
        case 'competencies': 
            die(local_hoteles_city_dashboard_format_response(local_hoteles_city_dashboard_get_all_user_competencies($_POST)));
            break;
        case 'user_catalogues':
            die(local_hoteles_city_dashboard_format_response(local_hoteles_city_dashboard_get_user_catalogues($_POST)));
            break;
        case 'course_historics':
            if(empty($_POST['courseid'])){
                die(local_hoteles_city_dashboard_error_response("courseid (int) not found"));
            }else{
                die(local_hoteles_city_dashboard_format_response(local_hoteles_city_dashboard_get_historic_reports(intval($_POST['courseid']))));
            }
            break;
        case 'course_comparative':
            if(!empty($_POST['courseid'])){
                if(isset($_POST['selected_filter'])){
                    $courseid = $_POST['courseid'];
                    die(local_hoteles_city_dashboard_format_response(local_hoteles_city_dashboard_get_course_comparative($courseid, $params = $_POST)));
                }else{
                    die(local_hoteles_city_dashboard_error_response("selected_filter (string) not found"));                
                }
            }else{
                die(local_hoteles_city_dashboard_error_response("courseid (int) not found"));
            }
            break;
        case 'kpi_list':
            die(local_hoteles_city_dashboard_format_response(local_hoteles_city_dashboard_get_kpi_list()));
        break;
        case 'delete_kpi':
            die(local_hoteles_city_dashboard_delete_kpi($params = $_POST));
        break;
        case 'update_kpi':
            die(local_hoteles_city_dashboard_update_kpi($params = $_POST));
        break;
        case 'create_kpi':
            die(local_hoteles_city_dashboard_create_kpi($params = $_POST));
        break;
        case 'create_region':
            die(local_hoteles_city_dashboard_create_region($params = $_POST));
        break;
        case 'relate_region_institution':
            die(local_hoteles_city_dashboard_relate_region_institution($params = $_POST));
        break;
        case 'update_region':
            die(local_hoteles_city_dashboard_update_region($params = $_POST));
        break;
        case 'get_region_institutions':
            $regionid = isset($_POST['region']) ? $_POST['region'] : '';
            die(local_hoteles_city_dashboard_get_region_insitutions($regionid));
        break;
        default:
            die(local_hoteles_city_dashboard_error_response("request_type not allowed"));
            break;
    }
}
die(local_hoteles_city_dashboard_error_response($_SERVER['REQUEST_METHOD'] . " method not allowed"));
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
$PAGE->set_url($CFG->wwwroot . '/local/hoteles_city_dashboard/pruebas.php');
$PAGE->set_pagelayout('admin');

echo $OUTPUT->header();
global $DB, $USER, $SESSION;

$tiempo_inicial = microtime(true); //true es para que sea calculado en segundos
// _print(local_hoteles_city_dashboard_get_user_permissions(true));
// $sql = "SELECT institution FROM {dashboard_region_ins} WHERE users LIKE ? ";
// _print($DB->get_fieldset_sql($sql, array('3')));
_print('Instituciones', local_hoteles_city_dashboard_get_institutions());
echo $OUTPUT->action_link('www.google.com', $text = 'google', $component_action = null, $attributes_array = array('class' => 'descarga'));
_print('Permisos', local_hoteles_city_dashboard_get_user_permissions());
_print('Roles', $SESSION->dashboard_roles);
_print('Insitution, department', $USER->institution, $USER->department);
// _print(local_hoteles_city_dashboard_make_courses_cache());

// global $DB;
// $caches = $DB->get_records('dashboard_cache');
// foreach ($caches as $cache) {
//     _print($cache->query);
//     _log(json_decode($cache->query));
// }

// _print(_print(local_hoteles_city_dashboard_get_role_permissions()));
// local_hoteles_city_dashboard_print_institutions_in_js();


// $tiempo_final = microtime(true);
// $tiempo = $tiempo_final - $tiempo_inicial; //este resultado estará en segundos
// _log("<br>El tiempo de ejecución del archivo ha sido de " . $tiempo . " segundos");


// dd(local_hoteles_city_dashboard_get_allowed_filters());
// dd(local_hoteles_city_dashboard_get_catalogues());
// _print(list($enrolledsql, $params) = get_enrolled_sql(
//     context_course::instance(8)));
// _print(get_config('local_hoteles_city_dashboard'));
$params = array('institution' => 'Institución 1', 'department' => ['Primer departamento', 'Segundo departamento']);
// _print(local_hoteles_city_dashboard_create_user_filters_sql( $params ));
// $params = [
//     'institution' => 'Hotel 2',
//     'department' => 'Gerente General'
// ];

// Prueba de paginación de usuarios
// $total_elements = $DB->count_records_sql('SELECT count(*) FROM {user} WHERE id > 1 AND suspended = 0 AND deleted = 0');
// _print('Total de elementos', $total_elements);
// $limite = 500;
// $iterations = ceil($total_elements / $limite);
// _print('Número de interacciones', $iterations);

// for ($i=0; $i < $iterations; $i++) { 
//     $limitfrom = $limite * $i;

//     $users = $DB->get_records_sql('SELECT id, alternatename, imagealt, email, middlename, picture, firstnamephonetic, lastnamephonetic,
//     id as userid, firstname, lastname, id as userid FROM {user} WHERE id > 1 AND suspended = 0 AND deleted = 0', array(), $limitfrom, $limite );
//     _print(count($users), "$limitfrom, $limite");
//     echo "<br>";
// }
 
$tiempo_final = microtime(true);
$tiempo = $tiempo_final - $tiempo_inicial; //este resultado estará en segundos

_log("<br>El tiempo de ejecución del archivo ha sido de " . $tiempo . " segundos");

echo $OUTPUT->footer();
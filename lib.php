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
 * @category    string
 * @copyright   2019 Subitus <contacto@subitus.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$roles = null;
$permissions = null;

DEFINE('local_hoteles_city_dashboard_return_random_data', false);

/**
 * Permisos que existen en el dashboard
 */
DEFINE('local_hoteles_city_dashboard_alta_baja_usuarios', 'Administración de usuarios');
DEFINE('local_hoteles_city_dashboard_alta_baja_usuarios_oficina_central', 'Administración de usuarios de Oficina Central');
DEFINE('local_hoteles_city_dashboard_listado_todos_los_usuarios', 'Administración de todos los usuarios');
DEFINE('local_hoteles_city_dashboard_cambio_usuarios', 'Cambio de usuarios (suspendidos)');
DEFINE('local_hoteles_city_dashboard_graficas_comparativas', 'Avances de todos los cursos: por región, por hotel, por persona y por puesto');
DEFINE('local_hoteles_city_dashboard_reportes', 'Gráficas de cursos');
DEFINE('local_hoteles_city_dashboard_ajustes', 'Ajustes dashboard administrativo Hoteles City');
DEFINE('local_hoteles_city_dashboard_services', 'Web service');
DEFINE('local_hoteles_city_dashboard_apply_filters', 'Aplicar filtros'); // Aplicar filtros para personas con acceso a toda la información
DEFINE('local_hoteles_city_dashboard_create_user', 'Crear usuario'); // Aplicar filtros para personas con acceso a toda la información


DEFINE('local_hoteles_city_dashboard_gerente_ao', 'role_1');
// DEFINE('local_hoteles_city_dashboard_coordinador_ao', 'role_2'); // Pidieron que se eliminara
DEFINE('local_hoteles_city_dashboard_director_regional', 'role_3');
DEFINE('local_hoteles_city_dashboard_personal_elearning', 'role_4');
DEFINE('local_hoteles_city_dashboard_gerente_hotel', 'role_5');
DEFINE('local_hoteles_city_dashboard_administrador', 'role_6');

DEFINE('local_hoteles_city_gerente_general_value', 'Gerente General');
DEFINE('local_hoteles_city_dashboard_oficina_central_value', 'Oficina Central');

DEFINE('local_hoteles_city_dashboard_course_users_pagination', 1);
DEFINE('local_hoteles_city_dashboard_all_users_pagination', 2);
DEFINE('local_hoteles_city_dashboard_suspended_users_pagination', 3);
DEFINE('local_hoteles_city_dashboard_actived_users_pagination', 4);
DEFINE('local_hoteles_city_dashboard_oficina_central_pagination', 5);

DEFINE('local_hoteles_city_dashboard_filter_prefix_default_field', 'default_');
DEFINE('local_hoteles_city_dashboard_filter_prefix_custom_field', 'custom_');

DEFINE('local_hoteles_city_dashboard_theme_colors', [
    'Primary' => "#4e73df",
    'Success' => "#1cc88a",
    'Info' => "#36b9cc",
    'Warning' => "#f6c23e",
    'Danger' => "#e74a3b",
    'Secondary' => "#858796",
    'color_aprobados' => "#1cc88a",
    'color_no_aprobado' => "#e74a3b",
    'color_variable_extra' => "#36b9cc",
]);

DEFINE('local_hoteles_city_dashboard_marca_field', 'marcafield');
DEFINE('local_hoteles_city_dashboard_special_custom_fields', [ // Campos personalizados necesarios
    local_hoteles_city_dashboard_marca_field => "Marca"
]);

// Agrega enlace al Dashboard en el menú lateral de Moodle
function local_hoteles_city_dashboard_extend_navigation(global_navigation $nav) {
    global $CFG; 
    $permissions = local_hoteles_city_dashboard_get_user_permissions();
    // $parent = $nav->add (
    //     get_string('pluginname', 'local_hoteles_city_dashboard') 
    // );
    foreach ($permissions as $key) {
        switch ($key) {
            case local_hoteles_city_dashboard_alta_baja_usuarios:
                $node = $nav->add (
                    $key,
                    new moodle_url( $CFG->wwwroot . '/local/hoteles_city_dashboard/usuarios.php?type=' 
                    . local_hoteles_city_dashboard_actived_users_pagination )
                );
                $node->showinflatnavigation = true;
                break;
            
            case local_hoteles_city_dashboard_alta_baja_usuarios_oficina_central:
                $node = $nav->add (
                    $key,
                    new moodle_url( $CFG->wwwroot . '/local/hoteles_city_dashboard/usuarios.php?type=' 
                    . local_hoteles_city_dashboard_oficina_central_pagination )
                );
                $node->showinflatnavigation = true;
                break;
            case local_hoteles_city_dashboard_cambio_usuarios:
                $node = $nav->add (
                    $key,
                    new moodle_url( $CFG->wwwroot . '/local/hoteles_city_dashboard/usuarios.php?type='
                    . local_hoteles_city_dashboard_suspended_users_pagination )
                );
                $node->showinflatnavigation = true;
                break;
            
            case local_hoteles_city_dashboard_listado_todos_los_usuarios:
                $node = $nav->add (
                    $key,
                    new moodle_url( $CFG->wwwroot . '/local/hoteles_city_dashboard/usuarios.php?type='
                    . local_hoteles_city_dashboard_all_users_pagination )
                );
                $node->showinflatnavigation = true;
                break;

            case local_hoteles_city_dashboard_reportes:
                $node = $nav->add (
                    'Gráficas de cursos',
                    new moodle_url( $CFG->wwwroot . '/local/hoteles_city_dashboard/estatus_curso.php' )
                );
                $node->showinflatnavigation = true;
                $node = $nav->add (
                    'Reporte de cursos',
                    new moodle_url( $CFG->wwwroot . '/local/hoteles_city_dashboard/detalle_curso.php' )
                );
                $node->showinflatnavigation = true;
                break;
            case local_hoteles_city_dashboard_graficas_comparativas:
                $node = $nav->add (
                    $key,
                    new moodle_url( $CFG->wwwroot . '/local/hoteles_city_dashboard/dashboard.php' )
                );
                $node->showinflatnavigation = true;
                break;
            case local_hoteles_city_dashboard_ajustes:
                $node = $nav->add (
                    $key,
                    new moodle_url( $CFG->wwwroot . '/local/hoteles_city_dashboard/ajustes.php' )
                );
                $node->showinflatnavigation = true;
                break;
        }
    }
}

function local_hoteles_city_dashboard_get_role_permissions(){
    $all_permissions = [
        local_hoteles_city_dashboard_graficas_comparativas, // Gráficas comparativas
        local_hoteles_city_dashboard_reportes, // Gráficas por curso y listado de usuarios por curso
        // local_hoteles_city_dashboard_alta_baja_usuarios, // Ellos tienen edición de todos los usuarios, esta opción es duplicada para ellos
        local_hoteles_city_dashboard_cambio_usuarios,
        local_hoteles_city_dashboard_alta_baja_usuarios_oficina_central,
        local_hoteles_city_dashboard_listado_todos_los_usuarios,
        local_hoteles_city_dashboard_ajustes,
        local_hoteles_city_dashboard_services,
        local_hoteles_city_dashboard_apply_filters,
        local_hoteles_city_dashboard_create_user,
    ];
    $response = array(
        local_hoteles_city_dashboard_director_regional => [
            local_hoteles_city_dashboard_reportes,
            local_hoteles_city_dashboard_services,
        ],
        local_hoteles_city_dashboard_gerente_hotel => [
            local_hoteles_city_dashboard_create_user,
            local_hoteles_city_dashboard_reportes,
            local_hoteles_city_dashboard_alta_baja_usuarios, // Alta y baja de usuarios de hoteles
            local_hoteles_city_dashboard_services,
        ],
    );
    $response[local_hoteles_city_dashboard_gerente_ao] = $all_permissions;
    $response[local_hoteles_city_dashboard_personal_elearning] = $all_permissions;
    $permisos_admin = array_diff($all_permissions, [local_hoteles_city_dashboard_cambio_usuarios]); // No se permite hacer cambios
    $response[local_hoteles_city_dashboard_administrador] = $permisos_admin;
    return $response;
}

function local_hoteles_city_dashboard_get_dashboard_roles(){
    return array(
        local_hoteles_city_dashboard_gerente_ao         => "Gerente Aprendizaje Organizacional",
        // local_hoteles_city_dashboard_director_regional  => "Director regional", // Se obtiene según campo department de usuario
        local_hoteles_city_dashboard_personal_elearning => "Personal Elearning",
        // local_hoteles_city_dashboard_gerente_hotel => "Gerente de hotel", // Se obtiene según campo department de usuario
        // local_hoteles_city_dashboard_administrador      => "Administrador del dashboard", // Se pretende que sea el administrador del sitio
    );
}

/**
 * Devuelve un listado de los roles disponibles junto con sus usuarios que tienen los diferentes roles
 * @return array 
 */
function local_hoteles_city_dashboard_get_all_roles_with_users(){
    $roles = local_hoteles_city_dashboard_get_dashboard_roles();
    // $role_ids = array_keys($roles); // Todos los roles
    $response = array();
    foreach($roles as $key => $role){
        $response[$role] = local_hoteles_city_dashboard_get_role_users($key);
    }
    return $response;
}

$cache_marcafield = null;
/**
 * Devuelve el id o el campo con formato para aplicar en filtros del campo personalizado de marcas
 * @param bool $returnOnlyId
 * @return int|string dependiendo el id de los
 */
function local_hoteles_city_dashboard_get_marcafield($returnOnlyId = false){
    global $cache_marcafield;
    if($cache_marcafield !== null){
        return ($returnOnlyId) ? $cache_marcafield : local_hoteles_city_dashboard_filter_prefix_custom_field . $cache_marcafield ;
    }
    $marcafield = get_config('local_hoteles_city_dashboard', 'marcafield');
    if(empty($marcafield)){
        $marcafield = -1;
    }
    $cache_marcafield = $marcafield;
    return ($returnOnlyId) ? $cache_marcafield : local_hoteles_city_dashboard_filter_prefix_custom_field . $cache_marcafield ;
}

function local_hoteles_city_dashboard_get_role_users($id){
    $roles = local_hoteles_city_dashboard_get_dashboard_roles();
    $role_ids = array_keys($roles);
    if(in_array($id, $role_ids)){
        $config_name = $id;
        $config = get_config('local_hoteles_city_dashboard', $config_name);
        if(!empty($config)){
            $config = explode(' ', $config);
            if(!empty($config)){
                global $DB;
                list($insql, $inparams) =  $DB->get_in_or_equal($config);
                $query = "SELECT id, concat(firstname, ' ', lastname) as name
                FROM {user} AS u WHERE email {$insql}";
                return $DB->get_records_sql_menu($query, $inparams);
            }
        }
    }
    return array();
}

// Directores regionales                           --pendiente--
// Gerente de hoteles                              institution = "Gerentes Generales"
// Gerente de Aprendizaje Organizacional           Rol "AO"
// Coordinadores de Aprendizaje Organizacional     Rol "AO"
// Personal de E-learning                          --?--
// Otros que requieren acceso                      Proponer
// Administrador del dashboard                     Administrador del sistema

function local_hoteles_city_dashboard_save_custom_settings(array $params){
    try {
        // $keys = array_keys($params);
        $excluded = array('mform_isexpanded', 'sesskey', '_qf__');
        foreach($params as $key => $param){
            $to_exclude = false;
            foreach ($excluded as $e_key) {
                $search = strpos($key, $e_key);
                if($search !== false){
                    $to_exclude = true;                
                }
            }
            if($to_exclude){
                continue;
            }
            if(empty($param)){
                continue;
            }
            if(is_array($param)){
                $param = implode(',', $param);
                set_config($key, $param, 'local_hoteles_city_dashboard');
            }else{
                set_config($key, $param, 'local_hoteles_city_dashboard');
            }
        }
    } catch (\Exception $th) {
        _log($th);
        return "Error";
    }
}

/**
 * @return array
 */
function local_hoteles_city_dashboard_get_courses_overview(array $params = array()){
    // $courses = local_hoteles_city_dashboard_get_courses();
    $courses = local_hoteles_city_dashboard_get_array_from_config(get_config('local_hoteles_city_dashboard', 'dashboard_courses'));
    $courses_in_order = array();
    $params = local_hoteles_city_dashboard_get_restricted_params($params);
    foreach($courses as $courseid){
        $course_information = local_hoteles_city_dashboard_get_course_information(intval($courseid), $params);        
        if(empty($course_information)){
            continue;
        }
        array_push($courses_in_order, $course_information);
    }
    usort($courses_in_order, function ($a, $b) {return $a->title > $b->title;});
    return $courses_in_order;
}

function local_hoteles_city_dashboard_user_has_access($section = '', string $message = '', bool $throwError = true){
    if(empty($message)){
        $message = "Usted no tiene permiso para acceder a esta sección";
    }
    if(empty($section)){
        print_error($message);
    }
    require_login();
    $permissions = local_hoteles_city_dashboard_get_user_permissions();
    $hasAccess = in_array($section, $permissions);
    if($throwError){
        if(!$hasAccess){
            print_error($message);
        }
    }else{
        return $hasAccess;
    }
    return true;
}

function local_hoteles_city_dashboard_get_departments(){
    $key = 'department';
    $result = local_hoteles_city_dashboard_get_catalogues([$key]);
    $result = $result[$key];
    $response = array();
    foreach($result as $result){
        $response[$result] = $result;
    }
    return $response;
}

function local_hoteles_city_dashboard_get_marcas(){
    $marcafield = local_hoteles_city_dashboard_get_marcafield();
    $result = local_hoteles_city_dashboard_get_catalogues([$marcafield]);
    if(isset($result[$marcafield])){
        return $result[$marcafield];
    }
    return array();
}

$cache_gerentes_generales = null;
function local_hoteles_city_dashboard_get_gerentes_generales(){
    global $cache_gerentes_generales;
    if($cache_gerentes_generales !== null){
        return $cache_gerentes_generales;
    }
    global $DB;
    $gerente_general = local_hoteles_city_gerente_general_value;
    $query = "SELECT id, concat(firstname, ' ', lastname) as name
    FROM {user} AS u WHERE u.deleted = '0'AND u.department = ?";
    $query_params = array($gerente_general);
    $result = $DB->get_records_sql_menu($query, $query_params);
    $cache_gerentes_generales = $result;
    return $cache_gerentes_generales;
}

function local_hoteles_city_dashboard_get_gerentes_generales_de_institution(){
    $institutions = local_hoteles_city_dashboard_get_institutions();
    $response = array();
    foreach ($institutions as $institution) {
        $result[$institution] = local_hoteles_city_dashboard_get_institution_manager($institution, false);
    }
    return $response;
}

function local_hoteles_city_dashboard_get_institution_manager(string $institution, bool $returnAsArray = true){
    $default = $returnAsArray ? array() : '- (No asignado)';
    if(empty($institution)){
        return $default;
    }
    global $DB;
    $department = local_hoteles_city_gerente_general_value;
    $sql = "SELECT id, concat(firstname, ' ', lastname) as name FROM {user} WHERE department = ? AND institution = ? AND deleted = 0 AND suspended = 0";
    $result = $DB->get_records_sql_menu($sql, array($department, $institution));
    if($result){
        $default = $returnAsArray ? $result : implode(', ', $result);
    }
    return $default;
}

function local_hoteles_city_dashboard_get_gerentes_ao(){
    return local_hoteles_city_dashboard_get_role_users(local_hoteles_city_dashboard_gerente_ao);
}

function local_hoteles_city_dashboard_get_directores_regionales(){
    global $DB;
    $local_hoteles_city_dashboard_director_regional_value = local_hoteles_city_dashboard_director_regional_value;
    return $DB->get_records_sql_menu("SELECT id, concat(firstname, ' ', lastname) as name
     FROM {user} WHERE deleted = 0 AND suspended = 0 AND department LIKE '{$local_hoteles_city_dashboard_director_regional_value}%'");
}

function local_hoteles_city_dashboard_get_personal_elearning(){
    return local_hoteles_city_dashboard_get_role_users(local_hoteles_city_dashboard_personal_elearning);
}

function custom_useredit_shared_definition(&$mform, $editoroptions, $filemanageroptions, $user) {
    if(isset($_GET['suspenduser'])){
        $allowed_fields = "_";
    }else{
        $allowed_fields = get_config('local_hoteles_city_dashboard', 'userformdefaultfields');
    }
    if(empty($allowed_fields)){
        return;
    }
    $allowed_fields = explode(',', $allowed_fields);

    global $CFG, $USER, $DB;

    if ($user->id > 0) {
        useredit_load_preferences($user, false);
    }

    $strrequired = get_string('required');
    $stringman = get_string_manager();

    // Add the necessary names.
    $fields = useredit_get_required_name_fields(); // firstname y lastname
    foreach ($fields as $fullname) {
        $mform->addElement('text', $fullname,  get_string($fullname),  'maxlength="100" size="30"');
        if ($stringman->string_exists('missing'.$fullname, 'core')) {
            $strmissingfield = get_string('missing'.$fullname, 'core');
        } else {
            $strmissingfield = $strrequired;
        }
        $mform->addRule($fullname, $strmissingfield, 'required', null, 'client');
        $mform->setType($fullname, PARAM_NOTAGS);
    }

    // $mform->addElement('text', 'password', get_string('password'), 'size="20"');
    // $mform->addHelpButton('username', 'username', 'auth');
    // $mform->setType('password', core_user::get_property_type('password'));

    $enabledusernamefields = useredit_get_enabled_name_fields();
    // Add the enabled additional name fields.
    foreach ($enabledusernamefields as $addname) {
        $mform->addElement('text', $addname,  get_string($addname), 'maxlength="100" size="30"');
        $mform->addRule($addname, $strrequired, 'required');
        $mform->setType($addname, PARAM_NOTAGS);
    }

    // if(in_array('institution', $allowed_fields)){
        $institutions = local_hoteles_city_dashboard_get_institutions();
        $required = $strrequired;
        $nombre = 'Unidad operativa';
        if(isset($user->suspended) && isset($user->institution)){
            if($user->suspended){
                if(isset($_GET['suspenduser'])){ // Usuario suspendido que pretende ser reactivado
                    $nombre = "Unidad operativa nueva";
                    $mform->addElement('static', 'description', 'Unidad operativa actual: <b>' . $user->institution . '</b>');
                }
            }
        }
        $mform->addElement('select', 'institution', $nombre, $institutions);
        if(!empty($institutions)){
            $required = "Contacte al administrador para que le asigne unidades operativas";
            $mform->addRule('institution', $required, 'required');
        }
        // $mform->addElement('text', 'institution', get_string('institution'), 'maxlength="255" size="25"');
        // $mform->setType('institution', core_user::get_property_type('institution'));
    // }

    // if(in_array('department', $allowed_fields)){
        $departments = local_hoteles_city_dashboard_get_departments();
        $nombre = 'Puesto';
        if(isset($user->suspended) && isset($user->department)){
            if($user->suspended){
                if(isset($_GET['suspenduser'])){ // Usuario suspendido que pretende ser reactivado
                    $nombre = "Puesto nuevo";
                    $mform->addElement('static', 'description', 'Puesto actual: <b>' . $user->department . '</b>');
                }
            }
        }
        $mform->addElement('select', 'department', $nombre, $departments);
        if(!empty($departments)){
            $mform->addRule('department', $strrequired, 'required');
        }
        $mform->setType('department', core_user::get_property_type('department'));
    // }

    // Do not show email field if change confirmation is pending.
    // if ($user->id > 0 and !empty($CFG->emailchangeconfirmation) and !empty($user->preference_newemail)) {
    //     $notice = get_string('emailchangepending', 'auth', $user);
    //     $notice .= '<br /><a href="edit.php?cancelemailchange=1&amp;id='.$user->id.'">'
    //             . get_string('emailchangecancel', 'auth') . '</a>';
    //     $mform->addElement('static', 'emailpending', get_string('email'), $notice);
    // } else {
    //     $mform->addElement('text', 'email', get_string('email'), 'maxlength="100" size="30"');
    //     $mform->addRule('email', $strrequired, 'required', null, 'client');
    //     $mform->setType('email', PARAM_RAW_TRIMMED);
    // }
    // Mostrando campo de email
    if(in_array('email', $allowed_fields)){
        $mform->addElement('text', 'email', get_string('email'), 'maxlength="100" size="30"');
        $mform->addRule('email', $strrequired, 'required', null, 'client');
        $mform->setType('email', PARAM_RAW_TRIMMED);
    }

    // $choices = array();
    // $choices['0'] = get_string('emaildisplayno');
    // $choices['1'] = get_string('emaildisplayyes');
    // $choices['2'] = get_string('emaildisplaycourse');
    // $mform->addElement('select', 'maildisplay', get_string('emaildisplay'), $choices);
    // $mform->setDefault('maildisplay', core_user::get_property_default('maildisplay'));
    $mform->addElement('hidden', 'maildisplay', core_user::get_property_default('maildisplay'));
    $mform->setType('maildisplay', PARAM_INT);

    if(in_array('city', $allowed_fields)){
        $mform->addElement('text', 'city', get_string('city'), 'maxlength="120" size="21"');
        $mform->addRule('city', $strrequired, 'required');
        $mform->setType('city', PARAM_TEXT);
        if (!empty($CFG->defaultcity)) {
            $mform->setDefault('city', $CFG->defaultcity);
        }
    }

    if(in_array('country', $allowed_fields)){
        $choices = get_string_manager()->get_list_of_countries();
        $choices = array('' => get_string('selectacountry') . '...') + $choices;
        $mform->addElement('select', 'country', get_string('selectacountry'), $choices);
        $mform->addRule('country', $strrequired, 'required');
        if (!empty($CFG->country)) {
            $mform->setDefault('country', core_user::get_property_default('country'));
        }
    }

    // if(in_array('timezone', $allowed_fields)){
    //     if (isset($CFG->forcetimezone) and $CFG->forcetimezone != 99) {
    //         $choices = core_date::get_list_of_timezones($CFG->forcetimezone);
    //         $mform->addElement('static', 'forcedtimezone', get_string('timezone'), $choices[$CFG->forcetimezone]);
    //         $mform->addElement('hidden', 'timezone');
    //         $mform->setType('timezone', core_user::get_property_type('timezone'));
    //     } else {
    //         $choices = core_date::get_list_of_timezones($user->timezone, true);
    //         $mform->addElement('select', 'timezone', get_string('timezone'), $choices);
    //     }
    // }

    // if (!empty($CFG->allowuserthemes)) {
    //     $choices = array();
    //     $choices[''] = get_string('default');
    //     $themes = get_list_of_themes();
    //     foreach ($themes as $key => $theme) {
    //         if (empty($theme->hidefromselector)) {
    //             $choices[$key] = get_string('pluginname', 'theme_'.$theme->name);
    //         }
    //     }
    //     $mform->addElement('select', 'theme', get_string('preferredtheme'), $choices);
    // }

    $class = '';
    if(!in_array('description', $allowed_fields)){
        $class = 'class = "ocultar-elemento d-none hidden-xl-down"';
    }
    $mform->addElement('editor', 'description_editor', get_string('userdescription'), $class, $editoroptions);
    $mform->setType('description_editor', PARAM_CLEANHTML);
    $mform->addHelpButton('description_editor', 'userdescription');

    // Edición de imágenes
    // if(get_config('local_hoteles_city_dashboard', 'userformimage')){
    //     // if (empty($USER->newadminuser)) {
    //         $mform->addElement('header', 'moodle_picture', get_string('pictureofuser'));
    //         $mform->setExpanded('moodle_picture', true);
    
    //         if (!empty($CFG->enablegravatar)) {
    //             $mform->addElement('html', html_writer::tag('p', get_string('gravatarenabled')));
    //         }
    
    //         $mform->addElement('static', 'currentpicture', get_string('currentpicture'));
    
    //         $mform->addElement('checkbox', 'deletepicture', get_string('deletepicture'));
    //         $mform->setDefault('deletepicture', 0);
    
    //         $mform->addElement('filemanager', 'imagefile', get_string('newpicture'), '', $filemanageroptions);
    //         $mform->addHelpButton('imagefile', 'newpicture');
    
    //         $mform->addElement('text', 'imagealt', get_string('imagealt'), 'maxlength="100" size="30"');
    //         $mform->setType('imagealt', PARAM_TEXT);
    
    //     // }
    // }

    // Display user name fields that are not currenlty enabled here if there are any.
    // $disabledusernamefields = useredit_get_disabled_name_fields($enabledusernamefields);
    // if (count($disabledusernamefields) > 0) {
    //     $mform->addElement('header', 'moodle_additional_names', get_string('additionalnames'));
    //     foreach ($disabledusernamefields as $allname) {
    //         $mform->addElement('text', $allname, get_string($allname), 'maxlength="100" size="30"');
    //         $mform->setType($allname, PARAM_NOTAGS);
    //     }
    // }
    if(in_array('interests', $allowed_fields)){ 
        // if (core_tag_tag::is_enabled('core', 'user') and empty($USER->newadminuser)) {
            $mform->addElement('header', 'moodle_interests', get_string('interests'));
            $mform->addElement('tags', 'interests', get_string('interestslist'),
                array('itemtype' => 'user', 'component' => 'core'));
            $mform->addRule('interests', $strrequired, 'required');
            $mform->addHelpButton('interests', 'interestslist');
        // }
    }


    // Moodle optional fields.
    // $mform->addElement('header', 'moodle_optional', get_string('optional', 'form'));

    if(in_array('url', $allowed_fields)){ 
        $mform->addElement('text', 'url', get_string('webpage'), 'maxlength="255" size="50"');
        $mform->addRule('url', $strrequired, 'required');
        $mform->setType('url', core_user::get_property_type('url'));
    }

    if(in_array('icq', $allowed_fields)){
        $mform->addElement('text', 'icq', get_string('icqnumber'), 'maxlength="15" size="25"');
        $mform->setType('icq', core_user::get_property_type('icq'));
        $mform->addRule('icq', $strrequired, 'required');
        $mform->setForceLtr('icq');
    }

    if(in_array('skype', $allowed_fields)){
        $mform->addElement('text', 'skype', get_string('skypeid'), 'maxlength="50" size="25"');
        $mform->setType('skype', core_user::get_property_type('skype'));
        $mform->addRule('skype', $strrequired, 'required');
        $mform->setForceLtr('skype');
    }

    if(in_array('aim', $allowed_fields)){
        $mform->addElement('text', 'aim', get_string('aimid'), 'maxlength="50" size="25"');
        $mform->setType('aim', core_user::get_property_type('aim'));
        $mform->addRule('aim', $strrequired, 'required');
        $mform->setForceLtr('aim');
    }

    if(in_array('yahoo', $allowed_fields)){
        $mform->addElement('text', 'yahoo', get_string('yahooid'), 'maxlength="50" size="25"');
        $mform->setType('yahoo', core_user::get_property_type('yahoo'));
        $mform->addRule('yahoo', $strrequired, 'required');
        $mform->setForceLtr('yahoo');
    }

    if(in_array('msn', $allowed_fields)){
        $mform->addElement('text', 'msn', get_string('msnid'), 'maxlength="50" size="25"');
        $mform->setType('msn', core_user::get_property_type('msn'));
        $mform->addRule('msn', $strrequired, 'required');
        $mform->setForceLtr('msn');
    }

    if(in_array('idnumber', $allowed_fields)){
        $mform->addElement('text', 'idnumber', get_string('idnumber'), 'maxlength="255" size="25"');
        $mform->addRule('idnumber', $strrequired, 'required');
        $mform->setType('idnumber', core_user::get_property_type('idnumber'));
    }

    // if(in_array('country', $allowed_fields)){
    //     $choices = get_string_manager()->get_list_of_countries();
    //     $choices = array('' => get_string('selectacountry') . '...') + $choices;
    //     $mform->addElement('select', 'country', get_string('selectacountry'), $choices);
    //     $mform->addRule('country', $strrequired, 'required');
    //     if (!empty($CFG->country)) {
    //         $mform->setDefault('country', core_user::get_property_default('country'));
    //     }
    // }

    if(in_array('phone1', $allowed_fields)){
        $mform->addElement('text', 'phone1', get_string('phone1'), 'maxlength="20" size="25"');
        $mform->setType('phone1', core_user::get_property_type('phone1'));
        $mform->addRule('phone1', $strrequired, 'required');
        $mform->setForceLtr('phone1');
    }

    if(in_array('phone2', $allowed_fields)){
        $mform->addElement('text', 'phone2', get_string('phone2'), 'maxlength="20" size="25"');
        $mform->setType('phone2', core_user::get_property_type('phone2'));
        $mform->addRule('phone2', $strrequired, 'required');
        $mform->setForceLtr('phone2');
    }

    if(in_array('address', $allowed_fields)){
        $mform->addElement('text', 'address', get_string('address'), 'maxlength="255" size="25"');
        $mform->addRule('address', $strrequired, 'required');
        $mform->setType('address', core_user::get_property_type('address'));
    }
}


/**
 * Print out the customisable categories and fields for a users profile
 *
 * @param moodleform $mform instance of the moodleform class
 * @param int $userid id of user whose profile is being edited.
 */
function custom_profile_definition($mform, $userid = 0) {
    global $CFG, $DB;

    // If user is "admin" fields are displayed regardless.
    $update = has_capability('moodle/user:update', context_system::instance());

    $categories = profile_get_user_fields_with_data_by_category($userid);
    $count = 0;
    // $first = true;
    if(isset($_GET['suspenduser'])){
        $allowed_fields = "";
    }else{
        $allowed_fields = get_config('local_hoteles_city_dashboard', 'userformcustomfields');
    }
    if(empty($allowed_fields)){
        return;
    }
    $allowed_fields = explode(',', $allowed_fields);
    $any = false;
    foreach ($categories as $categoryid => $fields) {
        // Check first if *any* fields will be displayed.
        // $display = false;
        // foreach ($fields as $formfield) {
        //     if ($formfield->is_visible()) {
        //         $display = true;
        //     }
        // }

        // Display the header and the fields.
        // if ($display or $update) {
        $first = true;
        if (!empty($fields)) {
            // $formfield = reset($fields);
            $category = false;
            foreach ($fields as $formfield) {
                if(!in_array($formfield->fieldid, $allowed_fields)){
                    continue;
                }
                // while($count < 5){
                    //     $count++;
                    // }
                if($first){
                    // $mform->addElement('header', 'category_'.$categoryid, format_string($formfield->get_category_name()));
                    $first = !$first;
                    $first = false;
                }
                if(!$any){
                    $mform->addElement('header', 'custom_fields', 'Campos de perfil personalizados');
                    $mform->setExpanded('custom_fields', true);
                    $any = true;
                }

                $formfield->edit_field_add($mform);
                $formfield->edit_field_set_default($mform);
                $formfield->edit_field_set_required($mform);

                $mform->addRule($formfield->inputname, 'Este campo es requerido', 'required');
            }
        }
    }
}

/**
 * Adds profile fields to user edit forms.
 * @param moodleform $mform
 * @param int $userid
 */
function custom_profile_definition_after_data($mform, $userid) {
    global $CFG;

    $userid = ($userid < 0) ? 0 : (int)$userid;

    $fields = profile_get_user_fields_with_data($userid);
    foreach ($fields as $formfield) {
        $formfield->edit_after_data($mform);
    }
}

/**
 * Devuelve la lista de campos que contiene la tabla user
 * @param bool $form true elimina las opciones username, firstname, lastname
 * @return array
 */
function local_hoteles_city_dashboard_get_default_profile_fields(bool $profileForm = false){
    $fields = array(
        'username' => 'Nombre de usuario', 
        // 'firstname' => 'Nombre (s)', 
        'name' => 'Nombre', // Incluye firstname y lastname
        // 'lastname' => 'Apellido (s)', 
        'email' => 'Dirección Email',
        'address' => 'Dirección', 
        'phone1' => 'Teléfono', 
        'phone2' => 'Teléfono móvil', 
        'icq' => 'Número de ICQ', 
        'skype' => 'ID Skype', 
        'yahoo' => 'ID Yahoo', 
        'aim' => 'ID AIM', 
        'msn' => 'ID MSN', 
        'department' => 'Puesto',
        'institution' => 'Unidad operativa', 
        // 'interests' => 'Intereses', 
        'idnumber' => 'Número de ID', 
        // 'lang', 
        // 'timezone', 
        'description' => 'Descripción',
        'city' => 'Ciudad', 
        'url' => 'Página web', 
        'country' => 'País',
    );
    if($profileForm){
        unset($fields['username']);
        unset($fields['firstname']);
        unset($fields['lastname']);
    // }else{
    //     $fields['fullname'] = 'Nombre completo'; // Fusión del nombre y apellido
    }
    return $fields;
}

function local_hoteles_city_dashboard_get_count_users($userids){ // Editado
    global $DB;
    // $whereids = implode(' AND _us_.id IN ', $userids->filters);
    $whereids = local_hoteles_city_dashboard_get_whereids_clauses($userids, '_us_.id');
    $query = "SELECT count(*) FROM {user} as _us_ WHERE 1 = 1 {$whereids}";
    $response = $DB->count_records_sql($query, $userids->params);
    // _sql($query, $userids->params, 'Inscritos ' . $response);
    return $response;
}

function local_hoteles_city_dashboard_get_whereids_clauses($userids, $fieldname){
    $response = "";
    if(!empty($userids->custom_filters)){
        $separator = " AND {$fieldname} IN ";
        $response .= ($separator . implode($separator, $userids->custom_filters));
    }
    return $response;
}

/**
 * Devuelve una consulta para obtener el id de los usuarios inscritos en un curso (s)
 * @param string|int $course id (o ids) de los cursos que se desea crear el segmento de la consulta
 * @param string $fecha_inicial Fecha inicial de inscripción a un curso
 * @param string $fecha_final Fecha final de inscripción a un curso
 * @return array ($query, $query_parameters) para agregar como where in de los usuarios inscritos en el curso
 */
function local_hoteles_city_dashboard_get_enrolled_userids($course, string $fecha_inicial, string $fecha_final,
        $params = array(), bool $apply_distinct = true){
    if(empty($course)){
        print_error('No se ha enviado id del curso local_hoteles_city_dashboard_get_enrolled_userids');
    }
    $many_courses = strpos($course, ',') !== false;
    $query_parameters = array();
    $campo_fecha = "__ue__.timestart";
    $filtro_fecha = local_hoteles_city_dashboard_create_sql_dates($campo_fecha, $fecha_inicial, $fecha_final);
    $params = local_hoteles_city_dashboard_get_restricted_params($params);

    $wherecourse = ($many_courses) ? " IN ({$course}) " : " = {$course} ";

    list($user_table_sql, $user_table_params) = local_hoteles_city_dashboard_create_user_filters_sql($params, $prefix = '__user__'); // Filtros de la tabla user
    $query_parameters = array_merge($query_parameters, $user_table_params);

    /* User is active participant (used in user_enrolments->status) -- Documentación tomada de enrollib.php define('ENROL_USER_ACTIVE', 0); */
    if($apply_distinct){
        $query = "( SELECT DISTINCT __user__.id FROM {user} AS __user__
        JOIN {user_enrolments} AS __ue__ ON __ue__.userid = __user__.id
        JOIN {enrol} __enrol__ ON (__enrol__.id = __ue__.enrolid AND __enrol__.courseid $wherecourse)
        WHERE __ue__.status = 0 AND __user__.deleted = 0 {$filtro_fecha} AND __user__.suspended = 0 {$user_table_sql} )";
    }else{
        $query = "( SELECT __user__.id AS userid, __course__.fullname as coursename, __course__.id as courseid FROM {user} AS __user__
        JOIN {user_enrolments} AS __ue__ ON __ue__.userid = __user__.id
        JOIN {enrol} __enrol__ ON (__enrol__.id = __ue__.enrolid AND __enrol__.courseid $wherecourse)
        JOIN {course} __course__ ON __enrol__.courseid = __course__.id
        WHERE __ue__.status = 0 AND __user__.deleted = 0 {$filtro_fecha} AND __user__.suspended = 0 {$user_table_sql} )";
    }

    // $query = "( SELECT DISTINCT __user__.id FROM {user} AS __user__
    // JOIN {user_enrolments} AS __ue__ ON __ue__.userid = __user__.id
    // JOIN {enrol} __enrol__ ON (__enrol__.id = __ue__.enrolid AND __enrol__.courseid = {$course})
    // WHERE __ue__.status = 0 AND __user__.deleted = 0 {$filtro_fecha} AND __user__.suspended = 0 AND __user__.id NOT IN 
    // (SELECT DISTINCT __role_assignments__.userid as userid
    //     FROM {course} AS __course__
    //     LEFT JOIN {context} AS __context__ ON __course__.id = __context__.instanceid
    //     JOIN {role_assignments} AS __role_assignments__ ON __role_assignments__.contextid = __context__.id
    //     WHERE __course__.id = {$course}
    //     AND __role_assignments__.roleid NOT IN (5) # No students
    // ) )";

    return array($query, $query_parameters);
}

/**
 * Obtiene la información de un curso
 * @param int|string $courseid Id de un curso o id de distintos cursos en formato: "1,2,3"
 * @param array $params arreglo con el nombre de un 
 */
function local_hoteles_city_dashboard_get_course_information($courseid, array $params = array()){
    global $DB;
    if(empty($courseid)){
        print_error('Es necesario enviar al menos un curso');
    }
    $many_courses = strpos($courseid, ',') !== false;

    $course = new stdClass();
    if(!$many_courses){
        $course = $DB->get_record('course', array('id' => $courseid));
        if($course === false){
            return false;
        }
    }
    // $response = new stdClass();
    if(local_hoteles_city_dashboard_return_random_data){
        $response = new stdClass();
        $response->enrolled_users = random_int(100, 2000);
        $response->approved_users = random_int(0, $response->enrolled_users);
        $response->not_approved_users = $response->enrolled_users - $response->approved_users;
        $response->percentage = local_hoteles_city_dashboard_percentage_of($response->approved_users, $response->enrolled_users);
    }else{
        $response = local_hoteles_city_dashboard_get_info_from_cache($courseid, $params);
    }
    $response->key = 'course' . $courseid;
    $response->id = $courseid;
    $response->groups = [
        [
            'chart' => 'barras_agrupadas',
            'name'  => 'Grupo 1'
        ],
        [
            'chart' => 'line',
            'name'  => 'Segundo grupo'
        ]
    ];
    $response->chart = 'pie';// local_hoteles_city_dashboard_get_course_chart($courseid);
    // $response->comparative = [
    //     // ...
    // ];
    if(!$many_courses){
        $response->title = $course->fullname;
    }
    $response->status = 'ok';
    // $fecha_inicial = local_hoteles_city_dashboard_get_value_from_params($params, 'fecha_inicial');
    // $fecha_final = local_hoteles_city_dashboard_get_value_from_params($params, 'fecha_final');

    // if($get_activities){
    //     $response->activities = local_hoteles_city_dashboard_get_activities_completion($courseid, $userids, $fecha_inicial, $fecha_final); //
    // }

    // if(local_hoteles_city_dashboard_return_random_data){
    //     $response->enrolled_users = random_int(100, 2000);
    //     $response->approved_users = random_int(0, $response->enrolled_users);

    // }else{
    //     $userids = local_hoteles_city_dashboard_get_userids_with_params($courseid, $params);
    //     $response->enrolled_users = local_hoteles_city_dashboard_get_count_users($userids); //
    //     if($response->enrolled_users == 0){
    //         $response->approved_users = 0; // No puede haber usuarios aprobados si no hay inscritos
    //     }else{
    //         $response->approved_users = local_hoteles_city_dashboard_get_approved_users($courseid, $userids, $fecha_inicial, $fecha_final); //
    //     }
    // }
    // $response->not_approved_users = $response->enrolled_users - $response->approved_users;

    return $response;
}


function local_hoteles_city_dashboard_get_info_from_cache($course, array $params){
    global $DB;

    $cache_query = local_hoteles_city_dashboard_create_cache_query_from_params($params);

    $sql = "SELECT courses as id, query, enrolled_users, approved_users, percentage, 'caché'AS source,
     enrolled_users - approved_users AS not_approved_users FROM {dashboard_cache} WHERE courses = ? AND query = ?";
    $record = $DB->get_record_sql($sql, array($course, $cache_query));

    if(empty($record)){ // Crear caché en caso de que no exista
        $record = local_hoteles_city_dashboard_make_course_cache($course, $params, true);
    }
    return $record;
}

function local_hoteles_city_dashboard_make_course_cache($course, array $params, bool $isNewRecord = false){
    global $DB;
    $currenttime = time();


    
    $course_information = new stdClass();
    $userids = local_hoteles_city_dashboard_get_userids_with_params($course, $params);
    $many_courses = strpos($course, ',') !== false;
    if($many_courses){
        $course_information->enrolled_users = local_hoteles_city_dashboard_count_users_many_courses($course, $params);
    }else{
        $course_information->enrolled_users = local_hoteles_city_dashboard_get_count_users($userids); //
    }
    if($course_information->enrolled_users == 0){
        $course_information->approved_users = 0; // No puede haber usuarios aprobados si no hay inscritos
    }else{
        $course_information->approved_users = local_hoteles_city_dashboard_get_approved_users($course, $userids); //
    }
    $course_information->not_approved_users = $course_information->enrolled_users - $course_information->approved_users;
    $course_information->percentage = local_hoteles_city_dashboard_percentage_of($course_information->approved_users, $course_information->enrolled_users);


    $cache_query = local_hoteles_city_dashboard_create_cache_query_from_params($params);
    $record = null;
    if(!$isNewRecord){
        $sql = "SELECT *, enrolled_users - approved_users as not_approved_users FROM {dashboard_cache} WHERE courses = ? AND query = ?";
        $record = $DB->get_record_sql($sql, array($course, $cache_query));
    }

    if(!empty($record)){ // Actualizar
        // $record->query = $cache_query;
        $record->enrolled_users = $course_information->enrolled_users;
        $record->approved_users = $course_information->approved_users;
        $record->percentage = $course_information->percentage;
        $record->timecreated = $currenttime;
        $DB->update_record('dashboard_cache', $record);
    }else{ // Crear registro
        $record = new stdClass();
        $record->query = $cache_query;
        $record->courses = $course;
        $record->enrolled_users = $course_information->enrolled_users;
        $record->approved_users = $course_information->approved_users;
        $record->percentage = $course_information->percentage;
        $record->timecreated = $currenttime;
        $DB->insert_record('dashboard_cache', $record);
    }
    $record->id = $record->courses;
    return $record;
}

function local_hoteles_city_dashboard_get_activities(int $courseid, string $andwhere = ""){
    global $DB;
    $actividades = array();
    $query  = "SELECT id, CASE ";
    $tiposDeModulos = $DB->get_records('modules', array('visible' => 1), 'id,name');
    foreach ($tiposDeModulos as $modulo) {
        $nombre  = $modulo->name;
        $alias = 'a'.$modulo->id;
        $query .= ' WHEN cm.module = '.$modulo->id.' THEN (SELECT '.$alias.'.name FROM {'.$nombre.'} '.$alias.' WHERE '.$alias.'.id = cm.instance) ';
    }
    $query .= " END AS name
    from {course_modules} cm
    where course = {$courseid} {$andwhere} ";
    return $DB->get_records_sql_menu($query);
}

function local_hoteles_city_dashboard_get_tracked_activities(int $courseid){
    return local_hoteles_city_dashboard_get_activities($courseid, 'AND cm.completion > 0');
}

function local_hoteles_city_dashboard_get_pagination_name(int $type, string $additional = ''){
    switch ($type) {
        case local_hoteles_city_dashboard_course_users_pagination:
            return "Usuarios del curso " . $additional;
            break;
        
        case local_hoteles_city_dashboard_all_users_pagination:
            return "Usuarios" . $additional;
            break;
        
        case local_hoteles_city_dashboard_suspended_users_pagination:
            return "Usuarios suspendidos " . $additional;
            break;
        
        case local_hoteles_city_dashboard_actived_users_pagination:
            return "Usuarios activos " . $additional;
            break;
        
        case local_hoteles_city_dashboard_oficina_central_pagination:
            return "Usuarios de oficina central " . $additional;
            break;
        
        default:
            return false;
            break;
    }
}

function local_hoteles_city_dashboard_print_theme_variables(){
    $config = get_config('local_hoteles_city_dashboard');
    $config = (array) $config;
    $script = "<script>";
    $stylesheet = "<style>";
    foreach (local_hoteles_city_dashboard_theme_colors as $name => $value) {
        if(!empty($config[$name])) $value = $config[$name];
        $script .= " {$name} = '{$value}'; ";
        $stylesheet .= " .{$name} { background-color: {$value} !important; color: #ffffff } .{$name}:hover { color: #ffffff !important; } ";
    }
    $script .= "</script>";
    $stylesheet .= "</style>";
    echo $stylesheet;
    echo $script;
    // _log(compact('stylesheet', 'script'));
}

/**
 * Devuelve el listado configurado de los filtros de la tabla user y los campos personalizados 
 */
function local_hoteles_city_dashboard_get_report_fields(){
    $default_fields = local_hoteles_city_dashboard_get_default_report_fields();
    $custom_fields = local_hoteles_city_dashboard_get_custom_report_fields();
    return array($default_fields, $custom_fields);
}

/**
 * Devuelve los campos de reporte ordenados según la configuración o añade los últimos en caso de no existir
 * @return array
 */
function local_hoteles_city_dashboard_get_report_fields_in_order(){
    list($default_report_fields, $custom_report_fields) = local_hoteles_city_dashboard_get_report_fields();
    $all_filters = $default_report_fields + $custom_report_fields;

    $update_config = false;
    $original_config = $keys = get_config('local_hoteles_city_dashboard', 'sort_report_fields');
    if($keys === false){ // No existe orden, crearlo
        $keys = array_keys($all_filters);
        $update_config = true;
    }else{
        $keys = explode(',', $keys);
    }

    // ejemplo: $keys = ['username', 'name', 1, 3];

    foreach($all_filters as $filter_key => $filter_name){ // Agregando los filtros que no estaban antes
        if(!in_array($filter_key, $keys)){
            array_push($keys, $filter_key);
        }
    }

    $response = array();
    foreach ($keys as $key_id => $key) {
        if(!array_key_exists($key, $all_filters)){ // El filtro fue eliminado de ajustes
            unset($keys[$key_id]);
        }else{ // El filtro sigue en ajustes
            $response[$key] = $all_filters[$key];
        }
    }
    
    $keys_with_order = implode(',', array_keys($response));
    if($update_config || $keys_with_order != $original_config){
        set_config('sort_report_fields', $keys_with_order, 'local_hoteles_city_dashboard');
    }
    return $response;
}

function local_hoteles_city_dashboard_set_new_order($key, string $action){
    if(!($action == 'up' || $action == 'down')){
        print_error("Acción '{$action}' no soportada");
    }
    $fields_in_order = local_hoteles_city_dashboard_get_report_fields_in_order();
    $keys_fields_in_order = array_keys($fields_in_order);
    if(is_number($key)){
        $position = array_search($key, $keys_fields_in_order);
    }else{
        $position = array_search($key, $keys_fields_in_order, true);
    }
    if($position !== false){
        switch($action){
            case 'up':
                $new_config = local_hoteles_city_dashboard_array_up($keys_fields_in_order, $position);
            break;
            case 'down':
                $new_config = local_hoteles_city_dashboard_array_down($keys_fields_in_order, $position);
            break;
        }
        $new_config = implode(',', $new_config);
        set_config('sort_report_fields', $new_config, 'local_hoteles_city_dashboard');
    }else{
        print_error('No se encuentra el filtro');
    }
    return true;
}

function local_hoteles_city_dashboard_array_down($array,$position) {
    if( count($array)-1 > $position ) {
		$response = array_slice($array,0,$position,true);
		$response[] = $array[$position+1];
		$response[] = $array[$position];
		$response += array_slice($array,$position+2,count($array),true);
		// return($response);
    } else { $response = $array; }
    return $response;
}

function local_hoteles_city_dashboard_array_up($array,$position) {
	if( $position > 0 and $position < count($array) ) {
		$response = array_slice($array,0,($position-1),true);
		$response[] = $array[$position];
		$response[] = $array[$position-1];
		$response += array_slice($array,($position+1),count($array),true);
		// return($response);
	} else { $response = $array; }
    return $response;
}

/**
 * Devuelve true si es un campo personalizado o false si es estándar de la tabla user de Moodle
 * @param string $field Nombre clave del campo
 * @return bool true si es campo personalizado o false si es de la tabla user
 */
function local_hoteles_city_dashboard_is_custom_field(string $field){
    // is_number();
    $response = is_number($field);
    return $response;
}

function local_hoteles_city_dashboard_get_report_columns(int $type, bool $returnLinks = true, $searched = '', $prefix = 'user.'){
    $select_sql = array("{$prefix}id");
    $ajax_names = array();
    $visible_names = array();
    $slim_query = array("id");
    // $slim_query = 
    // array_push($select_sql, 'fullname');

    $report_fields = local_hoteles_city_dashboard_get_report_fields_in_order();

    if(empty($report_fields)){
        array_push($report_fields, 'name'); // Agregar name por si no se encuentra ningún campo
    }

    foreach($report_fields as $field_key => $field_name){
        if( local_hoteles_city_dashboard_is_custom_field($field_key) ){
            $new_key = "custom_" .$field_key;
            $select_key = " COALESCE((SELECT data FROM {user_info_data} AS uif WHERE uif.userid = user.id AND fieldid = {$field_key} LIMIT 1), '') AS {$new_key}";
            array_push($ajax_names, $new_key);
            array_push($select_sql, $select_key);
            array_push($visible_names, $field_name);
            if($new_key == $searched){
                array_push($slim_query, $select_key);
            }
        }else{
            switch ($field_key) {
                case 'name':
                    array_push($ajax_names, $field_key);
                    array_push($select_sql, "concat({$prefix}firstname, ' ', {$prefix}lastname, '||', {$prefix}id ) as {$field_key}");
                    array_push($visible_names, 'Nombre');
                break;

                case 'suspended':
                    if($field_key == $searched){
                        array_push($slim_query, $prefix . $field_key);
                    }
                    $query = "IF({$prefix}{$field_key} = 0, 'Activo', 'Suspendido') AS {$field_key}";
                    array_push($ajax_names, $field_key);
                    array_push($select_sql, $query);
                    array_push($visible_names, $field_name);
                break;
                
                default:
                    if($field_key == $searched){
                        array_push($slim_query, $prefix . $field_key);
                    }
                    array_push($ajax_names, $field_key);
                    array_push($select_sql, $prefix . $field_key);
                    array_push($visible_names, $field_name);
                break;
            }

        }
    }

    switch ($type) {
        case local_hoteles_city_dashboard_course_users_pagination:
            // $courses = local_hoteles_city_dashboard_get_courses_setting();
            $key_name = 'coursename';
            $field = "{$key_name}";
            array_push($select_sql, $field);
            array_push($ajax_names, $key_name);
            if($key_name == $searched){
                array_push($slim_query, $field);
            }
            array_push($visible_names, 'Curso');

            $key_name = 'custom_completion';
            $field = "IF( EXISTS( SELECT id FROM {course_completions} AS cc WHERE user.id = cc.userid 
            AND cc.course = temporal.courseid AND cc.timecompleted IS NOT NULL), 'Completado', 'No completado') as {$key_name}";
            array_push($select_sql, $field);
            array_push($ajax_names, $key_name);
            if($key_name == $searched){
                array_push($slim_query, $field);
            }
            array_push($visible_names, 'Estatus');

            if($returnLinks){                
                $key_name = "link_libro_calificaciones";
                $field = "concat({$prefix}id, '||', courseid ) as {$key_name}";
                array_push($select_sql, $field);
                if($key_name == $searched){
                    array_push($slim_query, $field);
                }
                array_push($ajax_names, $key_name);
                array_push($visible_names, 'Libro de calificaciones');
            }

            break;    
        case local_hoteles_city_dashboard_all_users_pagination:
            if($returnLinks){                
                $key_name = 'link_edit_user';
                $field = "{$prefix}id as {$key_name}";
                $field_slim = "'e' as {$key_name}";
                array_push($select_sql, $field);
                array_push($ajax_names, $key_name);
                array_push($visible_names, 'Editar usuario');
            }

            if($returnLinks){                
                $key_name = "link_suspend_user";
                $field = "{$prefix}id, concat({$prefix}id, '||', {$prefix}suspended)  as {$key_name}";
                $field_slim = "'s' as {$key_name}";
                array_push($select_sql, $field);
                array_push($ajax_names, $key_name);
                array_push($visible_names, 'Suspender usuario');
            }

            break;
        case local_hoteles_city_dashboard_suspended_users_pagination:
            if($returnLinks){                
                $key_name = 'link_edit_user';
                $field = "{$prefix}id as {$key_name}";
                $field_slim = "'e' as {$key_name}";
                array_push($select_sql, $field);
                array_push($ajax_names, $key_name);
                array_push($visible_names, 'Editar usuario');
            }

            if($returnLinks){                
                $key_name = "link_suspend_user";
                $field = "{$prefix}id, concat({$prefix}id, '||', {$prefix}suspended)  as {$key_name}";
                $field_slim = "'s' as {$key_name}";
                array_push($select_sql, $field);
                array_push($ajax_names, $key_name);
                array_push($visible_names, 'Cambiar usuario');
            }
        break;

        case local_hoteles_city_dashboard_actived_users_pagination:
            if($returnLinks){                
                $key_name = 'link_edit_user';
                $field = "{$prefix}id as {$key_name}";
                $field_slim = "'e' as {$key_name}";
                array_push($select_sql, $field);
                array_push($ajax_names, $key_name);
                array_push($visible_names, 'Editar usuario');
            }

            if($returnLinks){                
                $key_name = "link_suspend_user";
                $field = "{$prefix}id, concat({$prefix}id, '||', {$prefix}suspended)  as {$key_name}";
                $field_slim = "'s' as {$key_name}";
                array_push($select_sql, $field);
                array_push($ajax_names, $key_name);
                array_push($visible_names, 'Suspender usuario');
            }
        break;

        case local_hoteles_city_dashboard_oficina_central_pagination:
            if($returnLinks){                
                $key_name = 'link_edit_user';
                $field = "{$prefix}id as {$key_name}";
                $field_slim = "'e' as {$key_name}";
                array_push($select_sql, $field);
                array_push($ajax_names, $key_name);
                array_push($visible_names, 'Editar usuario');
            }

            if($returnLinks){                
                $key_name = "link_suspend_user";
                $field = "{$prefix}id, concat({$prefix}id, '||', {$prefix}suspended)  as {$key_name}";
                $field_slim = "'s' as {$key_name}";
                array_push($select_sql, $field);
                array_push($ajax_names, $key_name);
                array_push($visible_names, 'Suspender usuario');
            }

        break;
            default:
            # code...
            break;
    }

    $imploded_sql = implode(', 
    ', $select_sql);
    $imploded_slim = implode(', 
    ', $slim_query);
    $ajax_code = "";
    $ajax_printed_rows = '';
    $ajax_link_fields = '';
    $count = 0;
    foreach($ajax_names as $an){
        $islink = true;
        switch($an){
            case 'link_suspend_user':
                $ajax_code .= "{data: '{$an}', render: 
                function ( data, type, row ) { 
                    parts = data.split('||');
                    id = parts[0];
                    suspended = parts[1];
                    texto = (suspended == '1') ? 'Quitar suspensión' : 'Suspender';
                    clase = (suspended == '1') ? 'btn btn-success' : 'btn btn-danger';
                    return '<a target=\"_blank\" class=\"' + clase + '\" href=\"administrar_usuarios.php?suspenduser=1&id=' + id + '\">' + texto + '</a>'; }  
                }, ";
            break;
            case 'link_edit_user':
                $ajax_code .= "{data: '{$an}', render: 
                function ( data, type, row ) { return '<a target=\"_blank\" class=\"btn btn-primay\" href=\"administrar_usuarios.php?id=' + data + '\">Editar usuario</a>'; }  }, ";
                // $ajax_code .= "{data: '{$an}', render: function ( data, type, row ) { return data; }  }, ";            
            break;
            case 'name':
                $islink = false;
                $ajax_code .= "{data: '{$an}', render: 
                    function ( data, type, row ) { 
                        parts = data.split('||');// nombre||id
                        return '<a class=\"\" href=\"administrar_usuarios.php?id=' + parts[1] + '\">' + parts[0] + '</a>'; 
                    } 
                }, ";
            // $ajax_code .= "{data: '{$an}', render: function ( data, type, row ) { return data; }  }, ";
            break;
            case 'link_libro_calificaciones':
                global $CFG;
                $ajax_code .= "{data: '{$an}', render: function ( data, type, row ) {
                    parts = data.split('||'); /* id||courseid */
                    return `<a target=\"_blank\" class=\"btn btn-primay\" href=\"{$CFG->wwwroot}/grade/report/user/index.php?id=` + parts[1] + `&userid=` + parts[0] + `\">Libro de calificaciones</a>`; 
                }}, ";
                break;
            default:
                $islink = false;
                $ajax_printed_rows .= ($count . ',');
                $ajax_code .= "{data: '{$an}' },";
            break;
        }
        if($islink){
            $ajax_link_fields .= ($count . ",");
        }
        $count++;
    }
    // $ajax_code .= "{data: '{$an}', render: function ( data, type, row ) // Ejemplo agregando una columna de alguna ya generada
    //                 { return 'Otra cosa con el mismo {$an}' + data; } // Ejemplo agregando una columna de alguna ya generada
    //             }, "; // Ejemplo agregando una columna de alguna ya generada
    // $table_code .= "<th>Una última columna</th>"; // Ejemplo agregando una columna de alguna ya generada
    $table_code = "";
    foreach($visible_names as $vn){
        $table_code .= "<th>{$vn}</th>";
    }
    $response = new stdClass();
    if($type == local_hoteles_city_dashboard_course_users_pagination){
        $response->select_sql = "CONCAT({$prefix}id, courseid) AS _id, " . $imploded_sql;
    }else{
        $response->select_sql = $prefix . 'id, ' . $imploded_sql;
    }
    $response->ajax_code = $ajax_code;
    $response->ajax_printed_rows = $ajax_printed_rows;
    $response->table_code = $table_code;
    $response->slim_query = $imploded_slim;
    $response->ajax_names = $ajax_names;
    $response->visible_names = $visible_names;
    $response->ajax_link_fields = $ajax_link_fields;

    return $response;
}

function local_hoteles_city_dashboard_get_course_grade_item_id(int $courseid){
    global $DB;
    return $DB->get_field('grade_items', 'id', array('courseid' => $courseid, 'itemtype' => 'course'));
}

function local_hoteles_city_dashboard_get_value_from_params(array $params, string $search, $returnIfNotExists = '', bool $apply_not_empty = true){
    if(array_key_exists($search, $params)){
        if($apply_not_empty){
            if(!empty($params[$search])){
                return $params[$search];
            }
        }else{
            return $params[$search];
        }
    }
    return $returnIfNotExists;
}

function local_hoteles_city_dashboard_create_sql_dates($campo_fecha, $fecha_inicial, $fecha_final){
    $filtro_fecha = '';
    if(empty($fecha_inicial) && empty($fecha_final)){ // las 2 vacías
        $filtro_fecha = ""; // No se aplica filtro
    }elseif(!empty($fecha_inicial) && empty($fecha_final)){ // solamente fecha_inicial
        $filtro_fecha = " AND FROM_UNIXTIME({$campo_fecha}) > '{$fecha_inicial}'";
        // $filtro_fecha .= $campo_fecha . ' ';
    }elseif(empty($fecha_inicial) && !empty($fecha_final)){ // solamente fecha_final
        $filtro_fecha = " AND FROM_UNIXTIME({$campo_fecha}) < '{$fecha_final}'";
    }elseif(!empty($fecha_inicial) && !empty($fecha_final)){ // ambas requeridas
        $filtro_fecha = " AND (FROM_UNIXTIME({$campo_fecha}) BETWEEN '{$fecha_inicial}' AND '{$fecha_final}')";
    }
    return $filtro_fecha;
}

/**
 * Devuelve el conteo de los estudiantes aprobados en el curso
 * @param int|string $course id del curso a buscar
 * @param stdClass $userids obtenido desde local_hoteles_city_dashboard_get_userids_with_params()
 * @param string $fecha_inicial fecha inicial en formato YYYY-MM-DD o ''
 * @param string $fecha_final fecha final en formato YYYY-MM-DD o ''
 * @return int Número de estudiantes aprobados
 */
function local_hoteles_city_dashboard_get_approved_users($course, stdClass $userids, string $fecha_inicial = '', string $fecha_final = ''){ //
    $response = 0;

    if(empty($course)){
        print_error('No se ha enviado id del curso local_hoteles_city_dashboard_get_approved_users');
    }

    $many_courses = strpos($course, ',') !== false;
    $wherecourse = ($many_courses) ? " IN ({$course}) " : " = {$course} ";

    $whereids = local_hoteles_city_dashboard_get_whereids_clauses($userids, 'cc.userid');
    $campo_fecha = "cc.timecompleted";
    $filtro_fecha = local_hoteles_city_dashboard_create_sql_dates($campo_fecha, $fecha_inicial, $fecha_final);    
    $query = "SELECT count(*) AS completions FROM {course_completions} AS cc JOIN {user} AS u ON cc.userid = u.id
    WHERE cc.course {$wherecourse} AND cc.timecompleted IS NOT NULL {$filtro_fecha} {$whereids} ";

    global $DB;
    if($result = $DB->get_record_sql($query, $userids->params)){
        // _sql($query, $userids->params, 'Consulta local_hoteles_city_dashboard_get_approved_users resultado ' . $result->completions);
        $response = $result->completions;
    }else{
        _log('No se ejecutó la consulta correctamente');
        _sql($query, $userids->params, 'Error local_hoteles_city_dashboard_get_approved_users');
    }
    return intval($response);
}

function local_hoteles_city_dashboard_percentage_of(int $number, int $total, int $decimals = 2 ){
    if($number > $total){
        _log('El valor total es mayor ');
    }
    if($total != 0){
        return round($number / $total * 100, $decimals);
    }else{
        return 0;
    }
}

/**
 * Devuelve información para consulta de usuarios según los filtros agregados
 * @param int|string $course Id o ids en formato  "1,2,3" de los que se planea tomar la información del curso
 * @param array $params parámetros de búsqueda de cursos, son permitidos campos personalizados y campos de la tabla usuarios
 * @return stdClass
 */
function local_hoteles_city_dashboard_get_userids_with_params($course, array $params = array()){
    // $whereClauses = array(); // Aplicables sobre campos de la tabla user
    $whereinClauses = array(); // Aplicables sobre campos de usuario personalizados
    $query_parameters = array();

    $fecha_inicial = local_hoteles_city_dashboard_get_value_from_params($params, 'fecha_inicial');
    $fecha_final = local_hoteles_city_dashboard_get_value_from_params($params, 'fecha_final');
    // Se omite $fecha_inicial debido a que si se incluye los usuarios inscritos anteriormente serían omitidos, activar si se pide explícitamente ese funcionamiento
    list($ids, $enrol_params) = local_hoteles_city_dashboard_get_enrolled_userids($course, '', $fecha_final, $params);
    // _log('Desde inscripción', $ids);
    $query_parameters = array_merge($query_parameters, $enrol_params);
    array_push($whereinClauses, $ids); // Campos de usuario personalizados
    global $DB;
    if(!empty($params)){
        foreach ($params as $key => $value) {
            if(strpos($key, local_hoteles_city_dashboard_filter_prefix_custom_field) !== false){
                $hasCustomField = true;
                list($insql, $inparams) = $DB->get_in_or_equal($value);
                $query_parameters = array_merge($query_parameters, $inparams);
                // $query_parameters = array_merge($query_parameters, $user_table_params);
                $fieldid = str_replace(local_hoteles_city_dashboard_filter_prefix_custom_field, '', $key);
                $where = " (SELECT DISTINCT userid FROM {user_info_data} WHERE fieldid = {$fieldid} AND data {$insql}) ";
                array_push($whereinClauses, $where);
            }
        }
    }
    $response = new stdClass();
    $response->custom_filters = $whereinClauses;
    $response->params = $query_parameters;
    return $response;
}

/**
 * Devuelve una consulta para obtener el id de los usuarios inscritos en un listado de cursos
 * @param string|int $course id (o ids) de los cursos que se desea crear el segmento de la consulta
 * @param string $fecha_inicial Fecha inicial de inscripción a un curso
 * @param string $fecha_final Fecha final de inscripción a un curso
 * @return string cadena para agregar como where in de los usuarios inscritos en el curso
 */
function local_hoteles_city_dashboard_count_users_many_courses(string $courses, $params = array()){
    $params = local_hoteles_city_dashboard_get_restricted_params($params);
    if(empty($courses)){
        print_error('No se ha enviado id del curso local_hoteles_city_dashboard_count_users_many_courses');
    }
    $fecha_inicial = local_hoteles_city_dashboard_get_value_from_params($params, 'fecha_inicial');
    $fecha_final = local_hoteles_city_dashboard_get_value_from_params($params, 'fecha_final');
    $query_parameters = array();
    $campo_fecha = "__ue__.timestart";
    $filtro_fecha = local_hoteles_city_dashboard_create_sql_dates($campo_fecha, $fecha_inicial, $fecha_final);
    $many_courses = strpos($courses, ',') !== false;
    $wherecourse = ($many_courses) ? " IN ({$courses}) " : " = {$courses} ";
    // $distinctClause = (!$many_courses) ? 'DISTINCT' : '';

    list($user_table_sql, $user_table_params) = local_hoteles_city_dashboard_create_user_filters_sql($params, '__user__'); // Filtros de la tabla user
    $query_parameters = array_merge($query_parameters, $user_table_params);

    /* User is active participant (used in user_enrolments->status) -- Documentación tomada de enrollib.php define('ENROL_USER_ACTIVE', 0); */
    $query = " SELECT count(*) FROM {user} AS __user__
    JOIN {user_enrolments} AS __ue__ ON __ue__.userid = __user__.id
    JOIN {enrol} __enrol__ ON (__enrol__.id = __ue__.enrolid AND __enrol__.courseid $wherecourse)
    WHERE __ue__.status = 0 AND __user__.deleted = 0 {$filtro_fecha} AND __user__.suspended = 0 {$user_table_sql} ";

    global $DB;
    $whereinClauses = array();
    if(!empty($params)){
        foreach ($params as $key => $value) {
            if(strpos($key, local_hoteles_city_dashboard_filter_prefix_custom_field) !== false){
                list($insql, $inparams) = $DB->get_in_or_equal($value);
                $query_parameters = array_merge($query_parameters, $inparams);
                $query_parameters = array_merge($query_parameters, $user_table_params);
                $fieldid = str_replace(local_hoteles_city_dashboard_filter_prefix_custom_field, '', $key);
                $where = " (SELECT DISTINCT userid FROM {user_info_data} WHERE fieldid = {$fieldid} AND data {$insql} {$user_table_sql} ) ";
                array_push($whereinClauses, $where);
            }
        }
    }

    $userids = new stdClass();
    $userids->custom_filters = $whereinClauses;

    $whereids = local_hoteles_city_dashboard_get_whereids_clauses($userids, '__user__.id');
    $query .= " {$whereids}";

    return $DB->count_records_sql($query, $query_parameters);
}

/**
 * Crea un segmento de consulta sql que se agrega para aplicar filtros dentro de la tabla user
 * @param array $params Parámetros donde van campos para aplicar, por ejemplo array('email' => 'x@subitus.com', 'institution' => ['institution 1', 'institution 2'])
 * @param string $prefix prefijo que se aplica a la tabla usuarios, se recomienda que sea un alias sql
 * @return array ((array)condiciones, (array)parámetros)
 */
function local_hoteles_city_dashboard_create_user_filters_sql(array $params, string $prefix = ''){
    global $DB;
    if(strpos($prefix, '.') === false && $prefix != ''){
        $prefix .= '.';
    }
    $clauses = array();
    $query_params = array();
    $allowed_filters = local_hoteles_city_dashboard_get_allowed_filters();
    foreach ($params as $key => $value) {
        if(in_array($key, $allowed_filters->filterdefaultfields)){
            list($insql, $inparams) = $DB->get_in_or_equal($value);
            $query_params = array_merge($query_params, $inparams);
            $where = " {$prefix}{$key} {$insql} ";
            array_push($clauses, $where);
        }
    }
    if(!empty($clauses)){
        $separator = " AND ";
        $clauses = $separator . implode(' AND ', $clauses);
    }else{
        $clauses = '';
        $query_params = array();
    }
    return array($clauses, $query_params);
}

$cache_custom_profile_fields = null;
/**
 * Devuelve un menú (clave => valor ... ) de los campos de usuario personalizados
 * @param string $ids ids de los campos personalizados. Ejemplo: 1,2,3
 * @return array|false Menú de los campos de usuario personalizados o false si no se encuentran
 */
function local_hoteles_city_dashboard_get_custom_profile_fields(string $ids = ''){
    global $cache_custom_profile_fields;
    if($cache_custom_profile_fields !== null){
        return $cache_custom_profile_fields;
    }
    global $DB;
    if(!empty($ids)){
        return $DB->get_records_sql_menu("SELECT id, name FROM {user_info_field} WHERE id IN ({$ids}) ORDER BY name");
    }
    $response = $DB->get_records_menu('user_info_field', array(), 'name', "id, name");
    $cache_custom_profile_fields = $response;
    return $response;
}

/**
 * Regresa información para la paginación de usuarios compatible con datatables
 */
function local_hoteles_city_dashboard_get_paginated_users(array $params, $type){
    $courseid = local_hoteles_city_dashboard_get_value_from_params($params, 'courseid');
    $courseid = intval($courseid);
    $queryParams = array();

    $join_sql = '';
    switch($type){
        case local_hoteles_city_dashboard_course_users_pagination:
            $courses = local_hoteles_city_dashboard_get_value_from_params($params, 'reportCourses');
            if(is_array($courses)){
                $courses = implode(',', $courses);
            }
            if(empty($courses)){
                $courses = '-1';
            }
            list($join, $enrol_params) = local_hoteles_city_dashboard_get_enrolled_userids($courses, $desde = '', $hasta = '', $params, $apply_distinct = false);
            $join_sql = " JOIN {$join} AS temporal ON temporal.userid = user.id ";
            $where_sql_query = " 1 ";
            $queryParams = array_merge($queryParams, $enrol_params);
        break;

        case local_hoteles_city_dashboard_all_users_pagination:
            $restricted_params = local_hoteles_city_dashboard_get_restricted_params($params);
            list($user_table_sql, $user_table_params) = local_hoteles_city_dashboard_create_user_filters_sql($restricted_params, $prefix_ = 'user'); // Filtros de la tabla user
            $queryParams = array_merge($queryParams, $user_table_params);
            $where_sql_query = " user.id > 1 AND user.deleted = 0 {$user_table_sql}";
        break;

        case local_hoteles_city_dashboard_suspended_users_pagination:
            $restricted_params = local_hoteles_city_dashboard_get_restricted_params($params);
            list($user_table_sql, $user_table_params) = local_hoteles_city_dashboard_create_user_filters_sql($restricted_params, $prefix_ = 'user'); // Filtros de la tabla user
            $queryParams = array_merge($queryParams, $user_table_params);
            $where_sql_query = " user.id > 1 AND user.suspended = 1 AND user.deleted = 0 {$user_table_sql}";
        break;

        case local_hoteles_city_dashboard_actived_users_pagination:
            $restricted_params = local_hoteles_city_dashboard_get_restricted_params($params);
            list($user_table_sql, $user_table_params) = local_hoteles_city_dashboard_create_user_filters_sql($restricted_params, $prefix_ = 'user'); // Filtros de la tabla user
            $queryParams = array_merge($queryParams, $user_table_params);
            $marcafield = local_hoteles_city_dashboard_get_marcafield(true);
            $marcaValue = local_hoteles_city_dashboard_oficina_central_value;
            $where_sql_query = " user.id > 1 AND user.suspended = 0 AND user.deleted = 0 {$user_table_sql} AND 
            user.id NOT IN (SELECT distinct userid FROM {user_info_data} WHERE fieldid = {$marcafield} AND data = '{$marcaValue}')";
        break;

        case local_hoteles_city_dashboard_oficina_central_pagination:
            $restricted_params = local_hoteles_city_dashboard_get_restricted_params($params);
            list($user_table_sql, $user_table_params) = local_hoteles_city_dashboard_create_user_filters_sql($restricted_params, $prefix_ = 'user'); // Filtros de la tabla user
            $queryParams = array_merge($queryParams, $user_table_params);
            $marcafield = local_hoteles_city_dashboard_get_marcafield(true);
            $marcaValue = local_hoteles_city_dashboard_oficina_central_value;
            $where_sql_query = " user.id > 1 AND user.deleted = 0 {$user_table_sql} AND user.id IN 
             (SELECT distinct userid FROM {user_info_data} WHERE fieldid = {$marcafield} AND data = '{$marcaValue}')";
        break;

        default:
            $where_sql_query = ' user.id > 1 ';
        break;
    }
    if(empty($params)){
        return array();
    }
    global $DB;
    $draw = $params['draw'];
    $row = $params['start'];
    $rowperpage = $params['length']; // Rows display per page
    $columnIndex = $params['order'][0]['column']; // Column index
    $columnName = $params['columns'][$columnIndex]['data']; // Column name
    $columnSortOrder = $params['order'][0]['dir']; // asc or desc
    $searchValue = $params['search']['value']; // Search value

    ## Search 
    $searchQuery = " WHERE " . $where_sql_query;
    $searched = '';
    if(!empty($searchValue) && strpos($columnName, 'link') !== false){
        $searched = $columnName;
    }
    
    
    $report_info = local_hoteles_city_dashboard_get_report_columns($type, true, $searched);

    /* Versión con consulta de solamente nombre y email */
    // if($searchValue != ''){
    //     $searchValue = "%{$searchValue}%";
    //     $searchQuery = " WHERE email like ? or concat(firstname, ' ', lastname) like ? AND " . $where_sql_query;
    //     array_push($queryParams, $searchValue);
    //     array_push($queryParams, $searchValue);
    // }

    ## Fetch records
    $select_sql = $report_info->select_sql;
    $select_slim = $report_info->slim_query;
    $limit = " LIMIT {$row}, {$rowperpage}";
    if($rowperpage == -1){
        $limit = "";
    }
    
    ## Total number of records without filtering
    $query = "SELECT COUNT(*) FROM {user} AS user {$join_sql} WHERE " . $where_sql_query;
    $totalRecords = $DB->count_records_sql($query, $queryParams);//($table, $conditions_array);
    // _log('Elementos totales', $totalRecords);    
    if($searchValue != ''){
        if($columnName == 'name'){ // Campo por defecto name
        // if(strpos('user.name',$columnName) !== false){
            $searchValue = "%{$searchValue}%";
            $searchQuery = " WHERE " . $where_sql_query . " AND CONCAT(firstname, ' ', lastname) like ? ";
            // array_push($queryParams, $searchValue);
        }elseif(strpos($columnName, 'custom_') !== false){ // Campo que requiere having
        // }elseif(strpos('user.',$columnName) !== false){
            $searchValue = "%{$searchValue}%";
            $searchQuery = " WHERE $where_sql_query HAVING {$columnName} like ?  " ;
        }else{ // Campo estándar de la tabla user
            $searchValue = "%{$searchValue}%";
            $searchQuery = " WHERE {$columnName} like ? AND " . $where_sql_query;
        }
        $searched = $columnName;
    }

    ## Total number of record with filtering
    $query = "SELECT count(*) FROM (SELECT {$select_slim} FROM {user} AS user {$join_sql} {$searchQuery}) AS t1";
    $queryParamsFilter = $queryParams;
    if($searchValue != ''){
        array_push($queryParamsFilter, $searchValue);
        array_push($queryParams, $searchValue);
    }
    // $queryParamsFilter = array($searchValue);
    
    $totalRecordwithFilter = $DB->count_records_sql($query, $queryParamsFilter);
    // _log('Elementos filtrados', $totalRecordwithFilter);
    
    ## Consulta de los elementos
    // $queryParams = array();
    // array_push($queryParams, $searchValue);
    $query = "select {$select_sql} from {user} AS user {$join_sql} {$searchQuery} order by {$columnName} {$columnSortOrder} {$limit}";
    // _sql($query, $queryParams);
    $records = $DB->get_records_sql($query, $queryParams);

    ## Response
    $response = array(
        "draw" => intval($draw),
        "iTotalRecords" => $totalRecordwithFilter,
        "iTotalDisplayRecords" => $totalRecords,
        "aaData" => array_values($records)
    );
    $json_response = json_encode($response);
    return $json_response;
}

if(!function_exists('_sql')){
    /**
     * Imprime los parámetros enviados con la función error_log()
     * @param mixed ...$parameters Recibe varios parámetros e imprime su valor en el archivo log, para pasarlos a cadena de texto se utiliza print_r($var, true)
     */
    function _sql(string $query, array $params = array(), string $title = ''){
        global $CFG;
        $prefix = $CFG->prefix;
        $title .= ' ';
        $original = $query;
        $query = str_replace('{', $prefix, $query);
        $query = str_replace('}', '', $query);
        // buscar
        $error = "";
        $num_params = count($params);
        $nested_params = substr_count($query, '?');
        $showParams = false;
        $replaceParams = false;
        if($nested_params > $num_params){
            $error .= "Parámetros necesitados: {$nested_params} Parámetros enviados: {$num_params}";
            $showParams = true;
        }elseif($nested_params < $num_params){
            $replaceParams = $showParams = true;
            $error .= "Parámetros necesitados: {$nested_params} Parámetros enviados: {$num_params}";
        }else{
            $replaceParams = true;
        }
        if($replaceParams){
            for($i = 0; $i < $nested_params; $i++){
                $query = local_hoteles_city_dashboard_str_replace_first('?', "'".$params[$i] . "'", $query);
            }
        }
        if(!$showParams || empty($params)){ $params = ''; }
        _log($title, $query, $params, $error);
    }
}

/**
 * Devuelve la cadena con el texto remplazado en solo la primera ocurrencia
 * @param string $buscar Texto a buscar
 * @param string $remplazar Texto con el que será remplazado
 * @param string $str Cadena donde se remplazará la primera ocurrencia
 * @return string texto en el cual se remplaza sólo la primera ocurrencia
 */
function local_hoteles_city_dashboard_str_replace_first($buscar, $remplazar, $str){
    $pos = strpos($str, $buscar);
    if ($pos !== false) {
        $newstring = substr_replace($str, $remplazar, $pos, strlen($buscar));
    }
    return $newstring;
    // $buscar = '/'.preg_quote($buscar, '/').'/';
    // return preg_replace($buscar, $remplazar, $str, 1);
}

/**
 * Devuelve un arreglo de nombres de campos de la tabla de moodle user. Hay un campo diferente llamado fullname que equivale a CONCAT(firstname, ' ', lastname)
 * @return array ['firstname','lastname','email' ... ]
 */
function local_hoteles_city_dashboard_get_default_report_fields(){
    if($config = get_config('local_hoteles_city_dashboard', 'reportdefaultfields')){
        if(!empty($config)){
            $menu = local_hoteles_city_dashboard_get_default_profile_fields();
            $configs = explode(',', $config);
            $response = array();
            foreach($configs as $r){
                if(array_key_exists($r, $menu)){
                    $response[$r] = $menu[$r];
                }
            }
            return $response;
        }
    }
    return array();
}

/**
 * Devuelve un arreglo de ids de los campos de usuario
 * @return array [1,2,3,...]
 */
function local_hoteles_city_dashboard_get_custom_report_fields(){
    if($config = get_config('local_hoteles_city_dashboard', 'reportcustomfields')){
        if(!empty($config)){
            $menu = local_hoteles_city_dashboard_get_custom_profile_fields($config);
            $configs = explode(',', $config);
            $response = array();
            foreach($configs as $r){
                if(array_key_exists($r, $menu)){
                    $response[$r] = $menu[$r];
                }
            }
            return $response;
        }
    }
    return array();
}

if(!function_exists('dd')){
    /**
     * Aplica las funciones die(var_dump()) del elemento enviado
     * @param any $element Elemento para imprimir y terminar el script
     */
    function dd($element){
        die(var_dump($element));
    }
}

if(!function_exists('_log')){
    /**
     * Imprime los parámetros enviados con la función error_log()
     * @param mixed ...$parameters Recibe varios parámetros e imprime su valor en el archivo log, para pasarlos a cadena de texto se utiliza print_r($var, true)
     */
    function _log(...$parameters){
        $output = "";
        foreach($parameters as $parameter){
            if($parameter === true){
                $output .= ' true ' . ' ';
            }
            elseif($parameter === false){
                $output .= ' false ' . ' ';
            }
            elseif($parameter === null){
                $output .= ' null ' . ' ';
            }else{
                $output .= print_r($parameter, true) . ' ';
            }
        }
        error_log($output);
    }
}

if(!function_exists('_print')){
    /**
     * Imprime los parámetros enviados con la función error_log()
     * @param ... any Recibe varios parámetros e imprime su valor en el archivo log, para pasarlos a cadena de texto se utiliza print_r($var, true)
     */
    function _print(...$parameters){
        $output = "<pre>";
        foreach($parameters as $parameter){
            if($parameter === true){
                $output .= ' true ' . ' <br>';
            }
            elseif($parameter === false){
                $output .= ' false ' . ' <br>';
            }
            elseif($parameter === null){
                $output .= ' null ' . ' <br>';
            }else{
                $output .= print_r($parameter, true) . ' <br>';
            }
        }
        $output .= "</pre>";
        echo $output;
    }
}

function local_hoteles_city_dashboard_format_response($data, string $dataname = "data", string $status = 'ok'){
    if(is_array($data)){
        $count = count($data);
    } else {
        $count = 1;
    }
    if(empty($data)){
        if($status == 'ok'){
            $status = "No data found";
        }
        $count = 0;
    }
    $result = array();
    $result['status'] = $status;
    $result['count'] = $count;
    $result[$dataname] = $data;
    return json_encode($result);
}

function local_hoteles_city_dashboard_done_successfully($message = 'ok'){
    $result = new stdClass();
    $result->status  = 'ok';
    $result->message = $message;
    return json_encode($result);
}

function local_hoteles_city_dashboard_error_response($message = 'error'){
    $result = new stdClass();
    $result->status  = 'error';
    $result->message = $message;
    return json_encode($result);
}

function local_hoteles_city_dashboard_get_courses(string $andWhereClause = "", array $andWhereClauseParams = array() ){
    global $DB;
    $query = "SELECT id, fullname FROM {course} where category != 0 {$andWhereClause} order by sortorder";
    return $DB->get_records_sql_menu($query, $andWhereClauseParams);
}

function local_hoteles_city_dashboard_get_courses_setting(bool $returnWithNames = false){
    $config = get_config('local_hoteles_city_dashboard', 'dashboard_courses');
    if($returnWithNames){
        if(empty($config)){ return array(); }
        global $DB;
        return $DB->get_records_sql_menu("SELECT id, fullname FROM {course} WHERE id IN ({$config})");
    }else{
        return $config;
    }
}

$global_allowed_fields = null;
/**
 * Devuelve los filtros configurados por el usuario y los filtros por defecto (institution y department)
 * @param bool $merge_filter_names Regresar los valores como arreglo de campos o como clase con los parámetros separados
 * @return stdClass|array el objeto tiene las claves filterdefaultfields y filtercustomfields
 */
function local_hoteles_city_dashboard_get_allowed_filters(bool $merge_filter_names = false){
    global $global_allowed_fields;
    if($global_allowed_fields !== null){
        if($merge_filter_names){
            return $global_allowed_fields->filters;
        }
        return $global_allowed_fields;
    }
    $response = new stdClass();
    $response->filter_names = array();
    $defaultFields = local_hoteles_city_dashboard_get_default_profile_fields();
    $required_keys = array('institution', 'department');
    $response->filterdefaultfields = array_merge(
        local_hoteles_city_dashboard_get_array_from_config(get_config('local_hoteles_city_dashboard', 'filterdefaultfields')),
     $required_keys);

    foreach ($response->filterdefaultfields as $filter_value) {
        switch ($filter_value) {
            case 'institution':
                $name = "Unidad operativa";
                break;

            case 'department':
                $name = "Puesto";
                break;
            
            default:
                $name = $defaultFields[$filter_value];
                break;
        }
        $response->filter_names[$filter_value] = $name;
    }

    $config_custom_fields = get_config('local_hoteles_city_dashboard', 'filtercustomfields');
    $response->filtercustomfields = local_hoteles_city_dashboard_get_array_from_config($config_custom_fields, ',', local_hoteles_city_dashboard_filter_prefix_custom_field);
    foreach (local_hoteles_city_dashboard_special_custom_fields as $key => $value) {
        $config = get_config('local_hoteles_city_dashboard', $key);
        if(!empty($config)){
            $filtername = local_hoteles_city_dashboard_filter_prefix_custom_field . $config;
            array_push($response->filtercustomfields, $filtername);
        }
    }

    $customFields = local_hoteles_city_dashboard_get_custom_profile_fields();
    
    foreach ($response->filtercustomfields as $filter_value) {
        // $response->filter_names[$filter_value] = $customFields[$filter_value];

        $response->filter_names[$filter_value] = $customFields[str_replace(local_hoteles_city_dashboard_filter_prefix_custom_field, '', $filter_value)];
    }


    $response->filters = array_unique(array_merge($required_keys, $response->filterdefaultfields, $response->filtercustomfields));
    $global_allowed_fields = $response;
    if($merge_filter_names){
        return $response->filters;
    }
    return $response;
}

$cache_catalogues = null;
function local_hoteles_city_dashboard_get_catalogues($only = array()){
    global $cache_catalogues;
    if($cache_catalogues !== null && empty($only)){
        return $cache_catalogues;
    }
    $tiempo_inicial = microtime(true); // true es para que sea calculado en segundos
    global $DB;
    $returnAll = empty($only);
    $response = array();
    // $required_keys = array('institution', 'department');
    $allowed_filters = local_hoteles_city_dashboard_get_allowed_filters();

    $filterdefaultfields = $allowed_filters->filterdefaultfields;
    foreach ($filterdefaultfields as $key) {
        if($returnAll || in_array($key, $only)){ // de la tabla usuarios
            switch ($key) {
                case 'institution':
                    $institutions = local_hoteles_city_dashboard_get_institutions();
                    $response[$key] = $institutions;
                    break;
                
                default:
                    $result  = $DB->get_fieldset_sql("SELECT distinct {$key} FROM {user}
                    WHERE suspended = 0 AND deleted = 0 AND {$key} != ''"); // Puestos
                    if($result){
                        $arreglo = array();
                        foreach($result as $r){
                            $arreglo[$r] = $r;
                        }
                        $response[$key] = $arreglo;
                    }else{
                        $response[$key] = array();
                    }
                    break;
            }
        }
    }
    
    // if(!$returnAll && empty($only)) return $response;
    
    $filtercustomfields = $allowed_filters->filtercustomfields;
    foreach ($filtercustomfields as $id) {
        if($returnAll || in_array($id, $only)){
            $result = local_hoteles_city_dashboard_get_custom_catalogue($id);
            
            if($result){
                $response[$id] = $result;
            }
        }
    }
    $tiempo_final = microtime(true);
    $tiempo = $tiempo_final - $tiempo_inicial; //este resultado estará en segundos
    // _log("El tiempo de ejecución de los catálogos es: " . $tiempo . " segundos");
    $cache_catalogues = $response;
    return $response;
}

/**
 * Devuelve un arreglo con el id de los elementos en configuración, la configuración debe ser de tipo multiselect
 * @param string|bool $config Configuración obtenida desde get_config
 * @param string $separator Separador de los elementos, por defecto , según el estándar de moodle
 * @param string $prefix Prefijo que se agregará a cada elemento resultante
 * @return array claves de los elementos configurados
 */
function local_hoteles_city_dashboard_get_array_from_config($config, string $separator = ',', string $prefix = ''){
    if($config === false){
        return array();
    }
    if(empty($config)){
        return array();
    }
    try{
        $response = explode($separator, $config);
        if(!empty($prefix)){
            foreach($response as $key => $r){
                $response[$key] = $prefix . $r;
            }
        }
        return $response;
    }catch(Exception $e){
        return array();
    }
}

$cache_regiones = null;
function local_hoteles_city_dashboard_get_regions(){
    global $cache_regiones;
    if($cache_regiones !== null){
        return $cache_regiones;
    }
    global $DB;
    $response = $DB->get_records('dashboard_region', array('active' => 1));
    $cache_regiones = $response;
    return $response;
}

function local_hoteles_city_dashboard_create_region(array $params){
    try{
        global $DB;
        $name = local_hoteles_city_dashboard_get_value_from_params($params, 'name', false);
        $users = local_hoteles_city_dashboard_get_value_from_params($params, 'userid');
        if(local_hoteles_city_dashboard_has_empty($name)){
            // _log('Datos vacíos en creación de región', $params);
            return 'Hay datos vacíos';
        }
        $existent = $DB->record_exists('dashboard_region', array('name' => $name));
        if($existent){
            return "Ya existe esta región";
        }
        $region = new stdClass();
        $region->name = $name;
        $region->users = local_hoteles_city_dashboard_get_string_from_value($users);
        $region->active = 1;
        $insertion = $DB->insert_record('dashboard_region', $region);
        return "ok";
    }catch(Exception $e){
        _log('Error al crear región', $e);
        return 'Por favor, inténtelo de nuevo';
    }
}

function local_hoteles_city_dashboard_relate_region_institution(array $params){
    try{
        global $DB;
        $regionid = local_hoteles_city_dashboard_get_value_from_params($params, 'id', '');
        $institution = local_hoteles_city_dashboard_get_value_from_params($params, 'institution', '');
        if(local_hoteles_city_dashboard_has_empty($regionid)){
            _log('Datos vacíos en creación de kpi', $params);
            return 'Por favor llene todos los campos';
        }
        $record = $DB->get_record('dashboard_region_ins', compact('institution'));
        if($record === false){ // Inexistent
            $record = new stdClass();
            $record->regionid = $regionid;
            $record->institution = $institution;
            $record->active = 1;
            $insertion = $DB->insert_record('dashboard_region_ins', $record);
        }else{
            if($regionid != $record->regionid ){
                $record->regionid = $regionid;
                $record->active = 1;
                $update = $DB->update_record('dashboard_region_ins', $record);
            }
        }
        return "ok";
    }catch(Exception $e){
        _log('Error al relacionar región con institución', $e);
        return 'Por favor, inténtelo de nuevo';
    }
}

function local_hoteles_city_dashboard_update_region(array $params){
    try{
        $id = local_hoteles_city_dashboard_get_value_from_params($params, 'id', false);
        $users = local_hoteles_city_dashboard_get_value_from_params($params, 'userid', '');
        if(empty($id)) return "No se encontró región";
        $delete = local_hoteles_city_dashboard_get_value_from_params($params, 'delete', false);
        
        global $DB;
        if($delete){ // Eliminando la región definitivamente
            $DB->delete_records('dashboard_region', array('id' => $id));
            /** Asignación a una región existente */
            // Se desactiva porque quizá no sea el comportamiento esperado
            // $firstRegionId = $DB->get_field_sql('SELECT id FROM {dashboard_region} WHERE active = 1 LIMIT 1');
            // if($firstRegionId !== false){
            //     $DB->execute('UPDATE {dashboard_region_ins} SET regionid = ? WHERE regionid = ?', array($firstRegionId, $id));
            // }
            /** Termina asignación a una región existente */
            return "Eliminada";
        }
        $name = local_hoteles_city_dashboard_get_value_from_params($params, 'name', false);
        $change_status = local_hoteles_city_dashboard_get_value_from_params($params, 'change_status', false);
        if(empty($name) && empty($change_status)) return "Por favor, agregue un nombre a la región e inténtelo de nuevo";
        $region = $DB->get_record('dashboard_region', array('id' => $id));
        if(empty($region)) return "No se encontró la región";
        
        $region->name = $name;
        $region->users = local_hoteles_city_dashboard_get_string_from_value($users);
        if($change_status) { $region->active = !$region->active; }
        // $record = $DB->get_record('dashboard_region_ins', array('regionid' => $regionid));
        $update = $DB->update_record('dashboard_region', $region, false);
        // _log(compact('update', 'region'));
        // if($record === false){ // Inexistent
        //     $relation = new stdClass();
        //     $relation->regionid = $regionid;
        //     $relation->institution = $institution;
        //     $relation->active = 1;
        // }else{
        //     if($institution != $record->institution ){
        //         $relation->institution = $institution;
        //         $relation->active = 1;
        //         $update = $DB->update_record('dashboard_region_ins', $record);
        //     }
        // }
        if($change_status){
            return $region->active ? "Región habilitada correctamente" : "Región deshabilitada correctamente";
        }
        return "ok";
    }catch(Exception $e){
        _log('Error al relacionar región con institución', $e);
        return 'Por favor, inténtelo de nuevo';
    }
}

function local_hoteles_city_dashboard_get_region_institution_relationships(){
    global $DB;
    return $DB->get_records('dashboard_region_ins');
}

function local_hoteles_city_dashboard_print_multiselect(string $name, string $title = "", string $default, array $menu, $keysAsValue = false, $containerclass = 'col-sm-3'){
    $class = 'multiselect-setting';
    $element = "";
    $element .= "<select class=\"{$class} form-control hoteles_city_dashboard_input\" name=\"{$name}[]\" 
      default=\"{$default}\"  multiple=\"multiple\" id=\"{$name}\">";
    
    $element .= "<option value=''>Seleccione {$title}</option>";
    $original_default = $default;
    if(!empty($default)){
        $default = explode(',', $default);
    }else{
        $default = array();
    }
    
    foreach ($menu as $key => $value) {
        $selected = "";
        if(in_array($key, $default)){
            $selected = "selected";
            if($value == ''){
                $selected = '';
            }
        }
        if($keysAsValue){
            $element .= "<option {$selected} value=\"{$key}\">{$value}</option>";
        }else{
            $element .= "<option {$selected} value=\"{$value}\">{$value}</option>";
        }
    }
    $element .= "</select>";
    return "<div class=\"form-group {$containerclass}\">
                <label class=\"form-label text-sm-right col-form-label\" for=\"{$name}\">{$title}</label>
                <div class=\"\">
                    {$element}
                </div>
            </div>";
}

function local_hoteles_city_dashboard_create_form_part($content, $title, $description, $default, $name = ""){
    if(empty($default)){
        $default = " Ninguno(a)";
    }
    return "<div class=\"form-group row\">
                <label class=\"col-sm-3 form-label text-sm-right col-form-label\" for=\"{$name}\">{$title}</label>
                <div class=\"col-sm-9\">
                    {$content}
                    <div class='form-defaultinfo text-muted' >Valor por defecto: {$default}</div>
                    <p>{$description}</p>
                </div>
            </div>";
}

/**
 * Devuelve las unidades operativas correspondientes (institutions) de la región
 * @param int $regionid Id de la región que se desean ver las unidades operativas
 * @return string Unidades operativas correspondientes a la región
 */
function local_hoteles_city_dashboard_get_region_insitutions($regionid, $returnAsString = false){
    $default = "";
    if(empty($regionid)) return $default;
    global $DB;
    $regions = $DB->get_records_sql_menu('SELECT id, institution FROM {dashboard_region_ins} WHERE regionid = ?', array($regionid));
    if($regions){
        if($returnAsString){
            $regions = implode(', ', $regions);            
        }
        return $regions;
    }
    return $default;
}

function local_hoteles_city_dashboard_has_empty(... $params){
    foreach($params as $param){
        if(empty($param)){
            // if($param !== 0){ // Acepta el 0 como valor válido
                return true;
            // }
        }
    }
    return false;
}

function local_hoteles_city_dashboard_get_custom_catalogue($fieldid){
    if(strpos($fieldid, local_hoteles_city_dashboard_filter_prefix_custom_field) !== false){
        $fieldid = str_replace(local_hoteles_city_dashboard_filter_prefix_custom_field, '', $fieldid);
    }
    global $DB;
    $query = "SELECT DISTINCT data FROM {user_info_data} AS info_data JOIN {user} AS user ON info_data.userid = user.id where fieldid = {$fieldid} 
    AND data != '' AND user.deleted = 0 AND user.suspended = 0 order by data ASC";
    return $DB->get_fieldset_sql($query);
}

function local_hoteles_city_dashboard_slug(string $text){
    // replace non letter or digits by -
    $text = preg_replace('~[^\pL\d]+~u', '_', $text);

    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);

    // trim
    $text = trim($text, '_');

    // remove duplicate -
    $text = preg_replace('~-+~', '_', $text);

    // lowercase
    $text = strtolower($text);

    if (empty($text)) {
        return 'n-a';
    }

    return $text;
}

/**
 * Devuelve arreglo de permisos [permiso1, permiso2] a las que el usuario tiene acceso, lo deja también almacenado en global $SESSION
 * @param bool $forceReloadPermissions volver a consultar los roles y permisos
 * @return array [permiso1, permiso2]
 */
function local_hoteles_city_dashboard_get_user_permissions(bool $forceReloadPermissions = false){
    global $SESSION;
    if(!isloggedin()){
        if(isset($SESSION->dashboard_roles)){
            unset($SESSION->dashboard_roles);
        }
        if(isset($SESSION->dashboard_permissions)){
            unset($SESSION->dashboard_permissions);
        }
        return array();
    }
    if(isset($SESSION->dashboard_permissions) && !$forceReloadPermissions){
        return $SESSION->dashboard_permissions;
    }
    global $USER;

    $email = $USER->email;
    $permission_list = local_hoteles_city_dashboard_get_role_permissions();
    $SESSION->dashboard_roles = array();
    $SESSION->dashboard_permissions = array();

    if(empty($USER->email)){
        return array();
    }
    if(local_hoteles_city_dashboard_is_gerente_general()){
        array_push($SESSION->dashboard_roles, local_hoteles_city_dashboard_gerente_hotel);
        $SESSION->dashboard_permissions = array_merge($SESSION->dashboard_permissions, $permission_list[local_hoteles_city_dashboard_gerente_hotel]);
        $SESSION->dashboard_permissions = array_unique($SESSION->dashboard_permissions);
        $SESSION->dashboardCapability = in_array(local_hoteles_city_dashboard_reportes, $SESSION->dashboard_permissions);
        return $SESSION->dashboard_permissions;
    }
    if(local_hoteles_city_dashboard_is_director_regional()){
        array_push($SESSION->dashboard_roles, local_hoteles_city_dashboard_director_regional);
        $SESSION->dashboard_permissions = array_merge($SESSION->dashboard_permissions, $permission_list[local_hoteles_city_dashboard_director_regional]);
        $SESSION->dashboard_permissions = array_unique($SESSION->dashboard_permissions);
        $SESSION->dashboardCapability = in_array(local_hoteles_city_dashboard_reportes, $SESSION->dashboard_permissions);
        return $SESSION->dashboard_permissions;
    }
    if(is_siteadmin()){
        array_push($SESSION->dashboard_roles, local_hoteles_city_dashboard_administrador);
        $SESSION->dashboard_permissions = array_merge($SESSION->dashboard_permissions, $permission_list[local_hoteles_city_dashboard_administrador]);
        $SESSION->dashboard_permissions = array_unique($SESSION->dashboard_permissions);
        $SESSION->dashboardCapability = in_array(local_hoteles_city_dashboard_reportes, $SESSION->dashboard_permissions);
        return $SESSION->dashboard_permissions;
    }
    foreach (local_hoteles_city_dashboard_get_dashboard_roles() as $key => $name) {
        if(local_hoteles_city_dashboard_user_has_role($key)){
            array_push($SESSION->dashboard_roles, $key);
            $SESSION->dashboard_permissions = array_merge($SESSION->dashboard_permissions, $permission_list[$key]);
            $SESSION->dashboard_permissions = array_unique($SESSION->dashboard_permissions);
            $SESSION->dashboardCapability = in_array(local_hoteles_city_dashboard_reportes, $SESSION->dashboard_permissions);
            return $SESSION->dashboard_permissions;
        }
        // $config_name = $key;
        // $config = get_config('local_hoteles_city_dashboard', $config_name);
        // if(!empty($config)){
        //     $config = explode(' ', $config);
        //     if(in_array($email, $config)){
        //         return array('Con rol', $name);
        //         array_push($SESSION->dashboard_roles, $key);
        //         $SESSION->dashboard_permissions = array_merge($SESSION->dashboard_permissions, $permission_list[$key]);
        //         $SESSION->dashboard_permissions = array_unique($SESSION->dashboard_permissions);
        //         $SESSION->dashboardCapability = in_array(local_hoteles_city_dashboard_reportes, $SESSION->dashboard_permissions);
        //         return $SESSION->dashboard_permissions;
        //     }
        // }
    }
    return $SESSION->dashboard_permissions;
}

function local_hoteles_city_dashboard_user_has_role(string $key){
    global $USER;
    $email = $USER->email;
    $config_name = $key;
    $config = get_config('local_hoteles_city_dashboard', $config_name);
    if(!empty($config)){
        $config = explode(' ', $config);
        return in_array($email, $config);
    }
    return false;
}

$cache_institutions = null;
/**
 * Devuelve un listado de hoteles (institutions) del gerente general de la región
 * @return array Listado de instituciones
 */
function local_hoteles_city_dashboard_get_institutions(){
    global $cache_institutions;
    if($cache_institutions !== null){
        return $cache_institutions;
    }
    $default = array();
    if(!isloggedin()){
        return $default;
    }
    global $DB, $USER;
    $userid = $USER->id;
    $email = $USER->email;
    // $institution = $USER->institution;
    // if(empty($institution)){
    //     return array();
    // }
    // $query = "SELECT DISTINCT institution FROM {dashboard_region_ins} as dri WHERE dri.regionid = (SELECT regionid 
    // FROM {dashboard_region_ins} WHERE institution = '{$institution}' LIMIT 1)";
    // return $DB->get_fieldset_sql($query);
    $cache_institutions = array();
    $queryAllInstitutions = "SELECT DISTINCT institution FROM {user} WHERE deleted = 0 AND id > 1 AND institution != ''";
    if(is_siteadmin()){        
        $cache_institutions = $DB->get_fieldset_sql($queryAllInstitutions);
    }elseif(local_hoteles_city_dashboard_is_gerente_ao()){
        $cache_institutions = $DB->get_fieldset_sql($queryAllInstitutions);
    }elseif(local_hoteles_city_dashboard_is_personal_elearning()){
        $cache_institutions = $DB->get_fieldset_sql($queryAllInstitutions);
    }elseif(local_hoteles_city_dashboard_is_gerente_general()){
        $institutions = array();
        $institution = $USER->institution;

        if(!empty($institution)){
            array_push($institutions, $institution);
        }
        // $query = "SELECT DISTINCT institution FROM {user} WHERE id = {$userid} AND institution != ''";
        // $query = "SELECT DISTINCT institution FROM {dashboard_region_ins} as dri WHERE dri.regionid = (SELECT regionid 
        // FROM {dashboard_region_ins} WHERE institution = '{$institution}' LIMIT 1) AND institution != ''";
        // $institutions = $DB->get_fieldset_sql($query);
        $temporal_institutions = local_hoteles_city_dashboard_get_temporal_institutions($email);
        $institutions = array_unique(array_merge($institutions, $temporal_institutions));
        $cache_institutions = $institutions;
    }elseif(local_hoteles_city_dashboard_is_director_regional()){
        $user_regions = local_hoteles_city_dashboard_get_user_regions($userid);
        if(empty($user_regions)){
            return $default;
        }
        $user_regions = implode(',', $user_regions);
        $query = "SELECT DISTINCT institution FROM {dashboard_region_ins} as dri WHERE institution != '' AND 
        regionid IN ({$user_regions})";
        $cache_institutions = $DB->get_fieldset_sql($query);
    }
    $temporal = array();
    foreach ($cache_institutions as $key) {
        $temporal[$key] = $key;
    }
    $cache_institutions = $temporal;
    return $cache_institutions;
}

/**
 * Devuelve las regiones a las que el usuario fue asignado
 * @param int $userid
 */
function local_hoteles_city_dashboard_get_user_regions($userid, bool $onlyIds = true){
    $regiones = local_hoteles_city_dashboard_get_regions();
    $response = array();
    foreach($regiones as $region){
        $users = $region->users;
        if(empty($users)){
            continue;
        }
        $users = explode(',', $users);
        if(in_array($userid, $users)){
            if($onlyIds){
                array_push($response, $region->id);
            }else{
                array_push($response, $region);
            }
        }
    }
    return $response;
}

function local_hoteles_city_dashboard_get_regional_institutions(){
    global $USER, $DB;
    $institution = $USER->institution;
    $query = "SELECT DISTINCT institution FROM {dashboard_region_ins} as dri WHERE dri.regionid = (SELECT regionid 
        FROM {dashboard_region_ins} WHERE institution = '{$institution}' LIMIT 1) AND institution != ''";
    return $DB->get_fieldset_sql($query);
}

function local_hoteles_city_dashboard_get_all_institutions(){
    global $DB;
    $queryAllInstitutions = "SELECT DISTINCT institution FROM {user} WHERE deleted = 0 AND id > 1 AND institution != ''";
    $institutions = $DB->get_fieldset_sql($queryAllInstitutions);
    $response = array();
    foreach ($institutions as $institution) {
        $response[$institution] = $institution;
    }
    return $response;
}

/**
 * Devuelve las instituciones temporales que le corresponden a un usuario
 * @param string $user_email Email del usuario
 * @return array Instituciones
 */
function local_hoteles_city_dashboard_get_temporal_institutions(string $user_email = null){
    if($user_email === null){
        global $USER;
        $user_email = $USER->email;
    }
    if(empty($user_email)){
        return array();
    }
    
    global $DB;

    $sql = "SELECT institution FROM {dashboard_region_ins} WHERE users LIKE ? ";
    return $DB->get_fieldset_sql($sql, array('%' . $user_email . '%'));
}

function local_hoteles_city_dashboard_is_gerente_ao(){
    global $SESSION;
    if(isset($SESSION->dashboard_roles)){
        $global_user_permissions = (array) $SESSION->dashboard_roles;
        return in_array(local_hoteles_city_dashboard_gerente_ao, $global_user_permissions);
    }
    return local_hoteles_city_dashboard_user_has_role(local_hoteles_city_dashboard_gerente_ao);
}

DEFINE('local_hoteles_city_dashboard_director_regional_value', "Director Regional");

function local_hoteles_city_dashboard_is_director_regional(){
    // global $SESSION;
    // if(isset($SESSION->dashboard_roles)){
    //     $global_user_permissions = (array) $SESSION->dashboard_roles;
    //     return in_array(local_hoteles_city_dashboard_director_regional, $global_user_permissions);
    // }
    global $USER;
    $position = strpos($USER->department, local_hoteles_city_dashboard_director_regional_value);
    if($position !== false){
        return true;
    }
    return false;
    // return local_hoteles_city_dashboard_user_has_role(local_hoteles_city_dashboard_director_regional);
}

function local_hoteles_city_dashboard_is_personal_elearning(){
    global $SESSION;
    if(isset($SESSION->dashboard_roles)){
        $global_user_permissions = (array) $SESSION->dashboard_roles;
        return in_array(local_hoteles_city_dashboard_personal_elearning, $global_user_permissions);
    }
    return local_hoteles_city_dashboard_user_has_role(local_hoteles_city_dashboard_personal_elearning);
}

function local_hoteles_city_dashboard_is_gerente_general(){
    // global $SESSION;
    // if(isset($SESSION->dashboard_roles)){
    //     $global_user_permissions = (array) $SESSION->dashboard_roles;
    //     return in_array(local_hoteles_city_dashboard_gerente_hotel, $global_user_permissions);
    // }
    global $USER;
    return $USER->department == local_hoteles_city_gerente_general_value;
}

function local_hoteles_city_dashboard_get_course_comparative(int $courseid, $selected_filter){
    $response = new stdClass();
    global $DB;
    $course = $DB->get_record('course', array('id' => $courseid), 'id, shortname, fullname');
    $response->title = $course->fullname;
    $response->key = 'course_' . $course->id;
    $response->id = $course->id;
    $response->shortname = $course->shortname;
    $response->fullname = $course->fullname;
    $indicators = local_hoteles_city_dashboard_get_indicators();
    // $conditions = local_hoteles_city_dashboard_get_wheresql_for_user_catalogues($params, $indicators);
    if($course === false){
        return array();
    }
    // $fecha_inicial = local_hoteles_city_dashboard_get_value_from_params($params, 'fecha_inicial');
    // $fecha_final = local_hoteles_city_dashboard_get_value_from_params($params, 'fecha_final');
    // $indicator = $params['selected_filter'];
    // $catalogue = local_hoteles_city_dashboard_get_catalogue($indicator, $conditions->sql, $conditions->params);
    // if(!in_array('', $catalogue)){
    //     array_push($catalogue, '');
    // }
    // $key = $indicator;
    // $comparative = array();
    // foreach($catalogue as $catalogue_item){
    //     $item_to_compare = new stdClass();
    //     $params[$key] = [$catalogue_item];
    //     $item_to_compare = local_hoteles_city_dashboard_get_info_from_cache($courseid, $params, $return_regions = true);
    //     if($catalogue_item == ''){
    //         $item_to_compare->name = '(Vacío)';
    //     }else{
    //         $item_to_compare->name = $catalogue_item;
    //     }

    //     // $userids = local_hoteles_city_dashboard_get_userids_with_params($courseid, $params);
    //     // $item_to_compare->enrolled_users = local_hoteles_city_dashboard_get_count_users($userids);
    //     // if($item_to_compare->enrolled_users == 0){
    //     //     $item_to_compare->approved_users = 0;
    //     // }else{
    //     //     $item_to_compare->approved_users = local_hoteles_city_dashboard_get_approved_users($courseid, $userids, $fecha_inicial, $fecha_final);
    //     // }
    //     // $item_to_compare->percentage = local_hoteles_city_dashboard_percentage_of($item_to_compare->approved_users, $item_to_compare->enrolled_users);
    //     array_push($comparative, $item_to_compare);
    // }
    // $response->comparative = $comparative;
    // $response->filter = $indicator;
    return $response;
}

function local_hoteles_city_dashboard_get_custom_field_filters_configuration(){

}

function local_hoteles_city_dashboard_update_gerente_regional(array $params){	
    try{	
        global $DB;	
        $id = local_hoteles_city_dashboard_get_value_from_params($params, 'id', false);	
        $users = local_hoteles_city_dashboard_get_value_from_params($params, 'userid', '');	
        if(local_hoteles_city_dashboard_has_empty($id)){	
            _log('local_hoteles_city_dashboard_update_gerente_regional Faltan datos institution, userid', $params);	
            return 'Por favor recargue la página';	
        }
        $users = local_hoteles_city_dashboard_get_string_from_value($users);

        $record = $DB->get_record('dashboard_region', compact('id'));	
        if($record === false){ // Crear	
            return "No existe la región a actualizar ({$id})";	
        }else{ // Actualizar	
            if($users != $record->users ){	
                $record->users = $users;
                // $record->active = 1;	
                $update = $DB->update_record('dashboard_region', $record);	
            }	
        }	
        return "ok";	
    }catch(Exception $e){	
        _log('Error local_hoteles_city_dashboard_update_gerente_regional', $e);	
        return 'Por favor, inténtelo de nuevo';	
    }	
}	
function local_hoteles_city_dashboard_update_gerente_general(array $params){	
    try{	
        global $DB;	
        $institution = local_hoteles_city_dashboard_get_value_from_params($params, 'institution', false);	
        $userid = local_hoteles_city_dashboard_get_value_from_params($params, 'userid', false);	
        if(local_hoteles_city_dashboard_has_empty($userid)){	
            _log('local_hoteles_city_dashboard_update_gerente_general Faltan datos institution, userid', $params);
            return 'Por favor recargue la página';	
        }	
        $record = $DB->get_record('dashboard_region_ins', compact('institution'));	
        if($record === false){ // Crear	
            $record = new stdClass();	
            $record->institution = $institution;	
            $record->userid = $userid;	
            $record->active = 1;	
            $insertion = $DB->insert_record('dashboard_region_ins', $record);	
        }else{ // Actualizar	
            if($userid != $record->userid ){	
                $record->userid = $userid;	
                $record->active = 1;	
                $update = $DB->update_record('dashboard_region_ins', $record);	
            }	
        }	
        return "ok";	
    }catch(Exception $e){	
        _log('Error local_hoteles_city_dashboard_update_gerente_general', $e);	
        return 'Por favor, inténtelo de nuevo';	
    }	
}

function local_hoteles_city_dashboard_get_dashboard_windows(){

    if(local_hoteles_city_dashboard_return_random_data){
        $response = array();
        $item = new stdClass();
        $item->elements = array();
        $item->name = "Avance global de capacitación";
        $item->chart = 'bar-agrupadas';
        for ($i=0; $i < 6; $i++) { // Marcas
            $element = new stdClass();
            $element->name = "Marca " . $i;
            $element->enrolled_users = random_int(10, 10000);
            $element->approved_users = random_int(5, $element->enrolled_users);
            // $element->chart = 'bar-agrupadas';
            $element->percentage = local_hoteles_city_dashboard_percentage_of($element->approved_users, $element->enrolled_users);
            $element->not_approved_users = $element->enrolled_users - $element->approved_users;
            $element->value = $element->percentage;
            $element->type = 'section_1';
            array_push($item->elements, $element);
        }
        array_push($response, $item);
        $item = new stdClass();
        $item->elements = array();
        $item->name = "Avance por regiones";
        $item->chart = 'bar-agrupadas';
        for ($i=0; $i < 6; $i++) { 
            $element = new stdClass();
            $element->name = "Región " . $i;
            $element->enrolled_users = random_int(10, 10000);
            $element->approved_users = random_int(5, $element->enrolled_users);
            // $element->chart = 'bar-agrupadas';
            $element->percentage = local_hoteles_city_dashboard_percentage_of($element->approved_users, $element->enrolled_users);
            $element->not_approved_users = $element->enrolled_users - $element->approved_users;
            $element->value = $element->percentage;
            $element->type = 'section_2';
            array_push($item->elements, $element);
        }
        array_push($response, $item);
        $item = new stdClass();
        $item->elements = array();
        $item->name = "Avance de capacitaciones en Oficina Central";
        $item->chart = 'bar-agrupadas';
        for ($i=0; $i < 9; $i++) { // Direcciones
            $element = new stdClass();
            $element->name = "Dirección " . $i;
            $element->enrolled_users = random_int(10, 10000);
            $element->approved_users = random_int(5, $element->enrolled_users);
            // $element->chart = 'bar-agrupadas';
            $element->percentage = local_hoteles_city_dashboard_percentage_of($element->approved_users, $element->enrolled_users);
            $element->not_approved_users = $element->enrolled_users - $element->approved_users;
            $element->value = $element->percentage;
            $element->type = 'section_3';
            array_push($item->elements, $element);
        }
        array_push($response, $item);
        $item = new stdClass();
        $item->elements = array();
        $item->name = "Avance de capacitación por puesto en hoteles";
        $item->chart = 'horizontalBar';
        for ($i=0; $i < 12; $i++) { // Puestos
            $element = new stdClass();
            $element->name = "Puesto " . $i;
            // $element->chart = 'horizontalBar';
            $element->enrolled_users = random_int(10, 10000);
            $element->approved_users = random_int(5, $element->enrolled_users);
            $element->percentage = local_hoteles_city_dashboard_percentage_of($element->approved_users, $element->enrolled_users);
            $element->not_approved_users = $element->enrolled_users - $element->approved_users;
            $element->value = $element->percentage;
            $element->type = 'section_4';
            array_push($item->elements, $element);
        }
        array_push($response, $item);
        return $response;
    }else{
        $response = array();
        
        $courses = local_hoteles_city_dashboard_get_courses_setting();
        
        $marcafield = local_hoteles_city_dashboard_get_marcafield(true);
        $marca_param = local_hoteles_city_dashboard_get_marcafield();
        $item = new stdClass();
        $item->elements = array();
        $item->name = "Avance global de capacitación";
        $item->chart = 'bar-agrupadas';
        $marcas = local_hoteles_city_dashboard_get_custom_catalogue($marcafield);
        foreach($marcas as $marca){
            $params = array();
            $params[$marca_param] = $marca;
            // $element = new stdClass();
            $element = local_hoteles_city_dashboard_get_info_from_cache($courses, $params);
            $element->name = $marca;
            // $userids = local_hoteles_city_dashboard_get_userids_with_params($courses, $params);
            // $element->enrolled_users = local_hoteles_city_dashboard_count_users_many_courses($courses, $params);
            // $element->approved_users = local_hoteles_city_dashboard_get_approved_users($courses, $userids, '', '');
            // $element->percentage = local_hoteles_city_dashboard_percentage_of($element->approved_users, $element->enrolled_users);
            // $element->not_approved_users = $element->enrolled_users - $element->approved_users;
            // $element->value = $element->percentage;
            $element->type = 'section_1';
            array_push($item->elements, $element);
        }
        array_push($response, $item);
    
        /**
         * Regiones
         */
        $regions = local_hoteles_city_dashboard_get_regions(array('active' => '1'));
        $item = new stdClass();
        $item->elements = array();
        $item->name = "Avance por regiones"; // Por regiones
        $item->chart = 'bar-agrupadas';
        if(!empty($regions)){
            foreach($regions as $region){
                $institutions = local_hoteles_city_dashboard_get_region_insitutions($region->id);
                $params = array();
                $params['institution'] = $institutions;
                
                
                
                if(!empty($institutions)){
                    $element = local_hoteles_city_dashboard_get_info_from_cache($courses, $params);
                    // $userids = local_hoteles_city_dashboard_get_userids_with_params($courses, $params);
                    
                    // $element->enrolled_users = local_hoteles_city_dashboard_count_users_many_courses($courses, $params);
                    // $element->approved_users = local_hoteles_city_dashboard_get_approved_users($courses, $userids, '', '');
                    
                }else{
                    $element = new stdClass();
                    _log('Región sin instituciones ', $region); // Se establece en 0 porque no debe mostrar información y el servicio mostraría todas
                    $element->enrolled_users = 0;
                    $element->approved_users = 0;
                    $element->not_approved_users = 0;
                    $element->percentage = 0;
                }
                
                $element->name = $region->name;
                // $element->percentage = local_hoteles_city_dashboard_percentage_of($element->approved_users, $element->enrolled_users);
                // $element->not_approved_users = $element->enrolled_users - $element->approved_users;
                // $element->value = $element->percentage;
                $element->type = 'section_2';
                array_push($item->elements, $element);
            }
        }
        array_push($response, $item);
        /**
         * Termina cálculo de regiones
         */
    
    
        /**
         * Avance de direcciones en oficina central
         */
        $item = new stdClass();
        $item->elements = array();
        $item->name = "Avance de capacitaciones en Oficina Central";
        $direcciones_oficina_central = get_config('local_hoteles_city_dashboard', 'direcciones_oficina_central');
        if(!empty($direcciones_oficina_central)){
            $direcciones_oficina_central = explode(',', $direcciones_oficina_central);
            $item->chart = 'bar-agrupadas';
            foreach($direcciones_oficina_central as $direccion_oficina_central){
                $params = array();
                $params['institution'] = $direccion_oficina_central;
                // $element = new stdClass();
                $element = local_hoteles_city_dashboard_get_info_from_cache($courses, $params);
                $element->name = $direccion_oficina_central;
                
                // $userids = local_hoteles_city_dashboard_get_userids_with_params($courses, $params);
                
                // $element->enrolled_users = local_hoteles_city_dashboard_count_users_many_courses($courses, $params);
                // $element->approved_users = local_hoteles_city_dashboard_get_approved_users($courses, $userids, '', '');
                
                // $element->percentage = local_hoteles_city_dashboard_percentage_of($element->approved_users, $element->enrolled_users);
                // $element->not_approved_users = $element->enrolled_users - $element->approved_users;
                // $element->value = $element->percentage;
                $element->type = 'section_3';
                array_push($item->elements, $element);
            }
        }
        array_push($response, $item);
        /**
         * Termina avance de direcciones en oficina central
         */
    
    
        /**
         * Avance por puestos
         */
        $item = new stdClass();
        $item->elements = array();
        $item->name = "Avance de capacitación por puesto en hoteles";
        $item->chart = 'horizontalBar';
        $puestos = get_config('local_hoteles_city_dashboard', 'puestos_en_dashboard');
        if(!empty($puestos)){
            $puestos = explode(',', $puestos);
            $item->chart = 'bar-agrupadas';
            foreach($puestos as $puesto){
                $params = array();
                $params['department'] = $puesto;
                // $element = new stdClass();
                $element = local_hoteles_city_dashboard_get_info_from_cache($courses, $params);
                $element->name = $puesto;
                
                // $userids = local_hoteles_city_dashboard_get_userids_with_params($courses, $params);
                
                // $element->enrolled_users = local_hoteles_city_dashboard_count_users_many_courses($courses, $params);
                // $element->approved_users = local_hoteles_city_dashboard_get_approved_users($courses, $userids, '', '');
                
                // $element->percentage = local_hoteles_city_dashboard_percentage_of($element->approved_users, $element->enrolled_users);
                // $element->not_approved_users = $element->enrolled_users - $element->approved_users;
                // $element->value = $element->percentage;
                $element->type = 'section_4';
                array_push($item->elements, $element);
            }
        }
        array_push($response, $item);
        /**
         * Termina avance por puestos
         */
    
        return $response;
    }
}

function local_hoteles_city_dashboard_print_filters(){
    $catalogues = local_hoteles_city_dashboard_get_catalogues();
    $allowed_filters = local_hoteles_city_dashboard_get_allowed_filters();
    // $canPrinAllFilters = local_hoteles_city_dashboard_has_permission(local_hoteles_city_dashboard_apply_filters);
    // $filtersWithoutPermissions = array('institution', 'department');
    // echo "<form name='$identifier' class='row' id='$identifier'>";
    foreach($catalogues as $catalogue_name => $catalogue_items){
        $name = $catalogue_name;
        $title = $allowed_filters->filter_names[$catalogue_name];
        $description = ""; // No es usado en esta sección
        $default = ""; // No es usado en esta sección
        if($catalogue_name == 'institution'){
            $catalogue_items = local_hoteles_city_dashboard_get_institutions();
            $default = implode(',', $catalogue_items);
        }
        echo local_hoteles_city_dashboard_print_multiselect($name, $title, $description, $catalogue_items);
    }
    // echo "<button value='Submit'>Submit</button>";
    // echo "</form>";
}

function local_hoteles_city_dashboard_get_gerentes_temporales_institution(string $institution, $returnAsArray = true){
    global $DB;
    $field = $DB->get_field('dashboard_region_ins', 'users', compact('institution'));
    if(empty($field)){
        return $returnAsArray ? array() : '';
    }
    return $returnAsArray ? explode(' ', $field) : $field;
}

function local_hoteles_city_dashboard_update_gerentes_temporales(array $params){
    $institution = local_hoteles_city_dashboard_get_value_from_params($params, 'institution');
    $gerentes_temporales = trim(local_hoteles_city_dashboard_get_value_from_params($params, 'gerentes_temporales', ''));
    global $DB;
    $record = $DB->get_record('dashboard_region_ins', compact('institution'));
    if($record){
        if($record->users != $gerentes_temporales){
            $record->users = $gerentes_temporales;
            $DB->update_record('dashboard_region_ins', $record);
        }else{
            _log('No actualizado');
        }
        return 'ok';
    }else{
        $record = new stdClass();
        $record->regionid = null;
        $record->institution = $institution;
        $record->users = $gerentes_temporales;
        $record->active = 1;
        $DB->insert_record('dashboard_region_ins', $record);
        return 'ok';
    }
    return "Error, recargue la página e inténtelo más tarde";
}

function local_hoteles_city_dashboard_print_institutions_in_js(){
    $response = new stdClass();
    $response->institutions = array_values(local_hoteles_city_dashboard_get_institutions());
    $response->num_institutions = count($response->institutions);
    $result = json_encode($response);
    $result = "<script> var __hoteles__ = {$result}; </script>";
    echo $result;
}

function local_hoteles_city_dashboard_has_permission($permission){
    $permissions = local_hoteles_city_dashboard_get_user_permissions();
    return in_array($permission, $permissions);
}

/**
 * Devuelve el arreglo de parámetros sin los filtros que no le corresponden a algún usuario
 * En caso de ser gerente regional o de hotel, sólo permite consultar el filtro de institution y elimina las instituciones que no le pertenezcan
 * @param array $params Petición con los filtros
 * @return array
 */
function local_hoteles_city_dashboard_get_restricted_params(array $params){
    // if(local_hoteles_city_dashboard_has_permission(local_hoteles_city_dashboard_apply_filters)){
    //     return $params;
    // }else{
        $allowed_filters = local_hoteles_city_dashboard_get_allowed_filters();
        if(local_hoteles_city_dashboard_is_director_regional() || local_hoteles_city_dashboard_is_gerente_general()){
            $institutions = local_hoteles_city_dashboard_get_institutions();
            if(empty($institutions)){ // No tiene instituciones asignadas, se debe tratar de un error
                print_error('El usuario no tiene instituciones asignadas');
            }
            foreach($allowed_filters->filters as $filter){
                switch ($filter) {
                    case 'institution':
                        $allowed_elements = array();
                        if(isset($params['institution'])){
                            $institution_request = $params['institution'];
                            if(is_string($institution_request) || is_numeric($institution_request)){
                                if(!in_array($institution_request, $institutions)){ // No le corresponde esta institución, poner aquellas que sí
                                    $params['institution'] = $institutions;
                                }
                            }elseif(is_array($institution_request)){
                                foreach($institution_request as $ins){ // Recorrer aquellas que está consultando para ver si le corresponden
                                    array_push($allowed_elements, $ins);
                                }
                                if(empty($allowed_elements)){ // Si no hay válidas, sólo incluir aquellas que le corresponden
                                    $params['institution'] = $institutions;
                                }else{
                                    $params['institution'] = $allowed_elements;
                                }
                            }
                        }else{
                            $params['institution'] = $institutions;
                        }
                        break;
                    case 'department':

                    default:
                        // if(isset($params[$filter])){
                        //     unset($params[$filter]);
                        // }
                        break;
                }
            }
            if(!isset($params['institution'])){
                $params['institution'] = $institutions;
            }
        }
        return $params;
    // }
    // return array();
}

/**
 * Devuelve únicamente los parámetros que correspodan a los filtros
 * @param array $params Petición del usuario
 * @return array filtros compatibles con consulta
 */
function local_hoteles_city_get_only_allowed_params_from_array(array $params){
    $response = array();
    $allowed_filters = local_hoteles_city_dashboard_get_allowed_filters();
    foreach($allowed_filters->filters as $filter){
        if(array_key_exists($filter, $params)){
            $response[$filter] = $params[$filter];
        }
    }
    return $response;
}

/**
 * Devuelve los filtros con los cuales fue creada una petición de caché
 * @param array $params Petición del usuario
 * @return array filtros compatibles con consulta
 */
function local_hoteles_city_dashboard_get_filters_from_query_string(string $encoded){
    $default = array();
    if(empty($encoded)){
        return $default;
    }
    $params = (array) json_decode($encoded);
    if(empty($params)){
        return $default;
    }
    return local_hoteles_city_get_only_allowed_params_from_array($params);
}

/**
 * Devuelve la consulta correspondiente a una petición
 * @param array $params Petición del usuario
 * @return array filtros compatibles con consulta
 */
function local_hoteles_city_dashboard_create_cache_query_from_params(array $params){
    $params = local_hoteles_city_get_only_allowed_params_from_array($params);
    ksort($params);
    if(empty($params)) return '';
    return json_encode($params);
}

/**
 * Crea la caché de los cursos que se consultaron anteriormente
 */
function local_hoteles_city_dashboard_make_courses_cache(){
    $startprocesstime = microtime(true); //true es para que sea calculado en segundos
    global $DB;

    $count = 0;
    $total_elements = $DB->count_records_sql('SELECT count(*) FROM {dashboard_cache}');
    $limite = 500;
    $iterations = ceil($total_elements / $limite);

    for ($i=0; $i < $iterations; $i++) { 
        $limitfrom = $limite * $i;

        $cache_records = $DB->get_records_sql('SELECT * FROM {dashboard_cache} order by id', array(), $limitfrom, $limite );
        foreach($cache_records as $cache_record){
            $count++;
            local_hoteles_city_dashboard_make_course_cache($cache_record->courses, local_hoteles_city_dashboard_get_filters_from_query_string($cache_record->query), false);
        }
    }

    $finalprocesstime = microtime(true);
    $functiontime = $finalprocesstime - $startprocesstime; //este resultado estará en segundos
    return "Se ejecutaron {$count} actualizaciones en {$functiontime} segundos";
}

function local_hoteles_city_dashboard_get_dashboard_cards_info(){
    global $DB;
    $courses = local_hoteles_city_dashboard_get_courses_setting();
    $params = array();
    $response = new stdClass();
    $response->institutions = array_values(local_hoteles_city_dashboard_get_institutions());
    $response->num_institutions = count($response->institutions);
    $response->num_users = $DB->count_records_sql('SELECT count(*) FROM {user} WHERE id > 1 AND deleted = 0 AND suspended = 0');
    $courses_information = local_hoteles_city_dashboard_get_info_from_cache($courses, $params);
    $approved_users = $courses_information->percentage;
    $not_approved_users = 100 - $courses_information->percentage;
    $response->approved_users = $approved_users;
    $response->not_approved_users = $not_approved_users;
    return $response;
}

function local_hoteles_city_dashboard_get_string_from_value($value){
    if(empty($value)){
        return '';
    }
    if(is_string($value) || is_numeric($value)){
        return $value;
    }elseif(is_array($value)){
        return implode(',', $value);
    }
}

function local_hoteles_city_dashboard_export_configurable_report($type, $params = array()){
    global $CFG;
    // $tiempo_inicial = microtime(true); //true es para que sea calculado en segundos
    require_once($CFG->dirroot.'/lib/excellib.class.php');

    $information = local_hoteles_city_dashboard_get_configurable_report_records($type, $params);

    $currentdate = date("d-m-Y_H:i:s");
    $filename = 'Reporte_personalizado_' . $currentdate;

    $report_columns = local_hoteles_city_dashboard_get_report_columns($type, $returnLinks = false);

    $ajax_names = $report_columns->ajax_names;

    $downloadfilename = clean_filename($filename);
    // Creating a workbook.
    $workbook = new MoodleExcelWorkbook("-");
    // Sending HTTP headers.
    $workbook->send($downloadfilename);
    // Adding the worksheet.
    $myxls = $workbook->add_worksheet($filename);

    foreach($report_columns->visible_names as $key => $column_header){
        $myxls->write_string(0, $key, $column_header);
    }
    $i = 1; // Comienza en uno porque la primera línea corresponde a las cabeceras
    $j = 0;
    foreach ($information as $line) { // Obtener sólo los campos del reporte
        foreach($ajax_names as $an){
            $myxls->write_string($i, $j, $line->{$an});
            $j++;
        }
        $i++;
        $j = 0;
    }

    // $tiempo_final = microtime(true);
    // $tiempo = $tiempo_final - $tiempo_inicial; //este resultado estará en segundos

    // _log("<br>El tiempo de exportado es: " . $tiempo . " segundos");

    $workbook->close();
    exit;    
}

function local_hoteles_city_dashboard_get_configurable_report_records($type, array $params = array()){
    $join_sql = '';
    $queryParams = array();
    switch($type){
        case local_hoteles_city_dashboard_course_users_pagination:
            $courses = local_hoteles_city_dashboard_get_value_from_params($params, 'reportCourses');
            if(empty($courses)){ // Todos los cursos configurados
                $courses = local_hoteles_city_dashboard_get_courses_setting();
            }
            if(is_array($courses)){
                $courses = implode(',', $courses);
            }
            // _log('Generando desde ', $courses);
            if(empty($courses)){
                $courses = '-1';
            }
            list($join, $enrol_params) = local_hoteles_city_dashboard_get_enrolled_userids($courses, $desde = '', $hasta = '', $params, $apply_distinct = false);
            $join_sql = " JOIN {$join} AS temporal ON temporal.userid = user.id ";
            $queryParams = array_merge($queryParams, $enrol_params);
        break;

        case local_hoteles_city_dashboard_all_users_pagination:
            $join_sql = " user.id > 1 AND user.deleted = 0";
        break;

        case local_hoteles_city_dashboard_suspended_users_pagination:
            $join_sql = ' user.id > 1 AND user.suspended = 1 AND user.deleted = 0';
        break;

        case local_hoteles_city_dashboard_actived_users_pagination:
            $marcafield = local_hoteles_city_dashboard_get_marcafield(true);
            $marcaValue = local_hoteles_city_dashboard_oficina_central_value;
            $join_sql = " user.id > 1 AND user.suspended = 0 AND user.deleted = 0 AND 
            user.id NOT IN (SELECT distinct userid FROM {user_info_data} WHERE fieldid = {$marcafield} AND data = '{$marcaValue}')";
        break;

        case local_hoteles_city_dashboard_oficina_central_pagination:
            $marcafield = local_hoteles_city_dashboard_get_marcafield(true);
            $marcaValue = local_hoteles_city_dashboard_oficina_central_value;
            $join_sql = " user.id > 1 AND user.deleted = 0 AND user.id IN 
             (SELECT distinct userid FROM {user_info_data} WHERE fieldid = {$marcafield} AND data = '{$marcaValue}')";
        break;

        default:
            $join_sql = ' user.id > 1 ';
        break;
    }

    global $DB;
    
    $report_info = local_hoteles_city_dashboard_get_report_columns($type);
    $select_sql = $report_info->select_sql;
    $orderBy = "";
    if(!empty($report_info->ajax_names)){
        $orderBy = in_array('name', $report_info->ajax_names)? "order by name" : "order by " . $report_info->ajax_names[0];
    }
    $columnSortOrder = 'ASC';
    $query = "select {$select_sql} from {user} AS user {$join_sql} {$orderBy} {$columnSortOrder}";
    $records = $DB->get_records_sql($query, $queryParams);

    _log(count($records));
    return $records;
}

/**
 * Devuelve si el usuario tiene acceso total en el dashboard
 * @return bool true|false
 */
function local_hoteles_city_dashboard_user_has_all_permissions(){
    return is_siteadmin() || local_hoteles_city_dashboard_is_personal_elearning() || local_hoteles_city_dashboard_is_gerente_ao();
}
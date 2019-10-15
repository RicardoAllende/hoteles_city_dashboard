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

// Agrega enlace al Dashboard en el menú lateral de Moodle
function local_hoteles_city_dashboard_extend_navigation(global_navigation $nav) {
    global $CFG; 
    if(has_capability('local/hoteles_city_dashboard:view', context_system::instance())){
        $node = $nav->add (
            get_string('pluginname', 'local_hoteles_city_dashboard'),
            new moodle_url( $CFG->wwwroot . '/local/hoteles_city_dashboard/dashboard.php' ),
            navigation_node::TYPE_CUSTOM,
            'Dashboard',
            'local_hoteles_city_dashboard',
            new pix_icon("b/report", 'moodle')
        );
        $node->showinflatnavigation = true;
        $node = $nav->add (
            'Configuraciones ' . get_string('pluginname', 'local_hoteles_city_dashboard'),
            new moodle_url( $CFG->wwwroot . '/admin/settings.php?section=local_hoteles_city_dashboard' )
        );
        $node->showinflatnavigation = true;
    }
}

/**
 * @return array
 */
function local_hoteles_city_dashboard_get_courses_overview(array $params = array()){
    $courses = local_hoteles_city_dashboard_get_courses();
    foreach($courses as $course){
        $course_information = local_hoteles_city_dashboard_get_course_information($course->id, $params);        
        if(empty($course_information)){
            continue;
        }
        array_push($courses_in_order, $course_information);
    }
    usort($courses_in_order, function ($a, $b) {return $a->percentage < $b->percentage;});
    return ['type' => 'course_list', 'result' => $courses_in_order];
}

function local_hoteles_city_dashboard_user_has_access(){
    return true;
}

function custom_useredit_shared_definition(&$mform, $editoroptions, $filemanageroptions, $user) {
    $allowed_fields = get_config('local_hoteles_city_dashboard', 'userformdefaultfields');
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
        $mform->addRule('', $strrequired, 'required');
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
        $mform->addRule('text', $strrequired, 'required');
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

    // if(in_array('institution', $allowed_fields)){
        $mform->addElement('text', 'institution', get_string('institution'), 'maxlength="255" size="25"');
        $mform->addRule('institution', $strrequired, 'required');
        $mform->setType('institution', core_user::get_property_type('institution'));
    // }

    // if(in_array('department', $allowed_fields)){
        $mform->addElement('text', 'department', get_string('department'), 'maxlength="255" size="25"');
        $mform->addRule('department', $strrequired, 'required');
        $mform->setType('department', core_user::get_property_type('department'));
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
    $allowed_fields = get_config('local_hoteles_city_dashboard', 'userformcustomfields');
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
                    // _log($formfield);
                    $mform->addElement('header', 'custom_fields', 'Campos de perfil del usuario');
                    $mform->setExpanded('custom_fields', true);
                    $any = true;
                }
                $formfield->edit_field($mform);
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
        'firstname' => 'Nombre (s)', 
        'lastname' => 'Apellido (s)', 
        'email' => 'Dirección Email',
        'address' => 'Dirección', 
        'phone1' => 'Teléfono', 
        'phone2' => 'Teléfono móvil', 
        'icq' => 'Número de ICQ', 
        'skype' => 'ID Skype', 
        'yahoo' => 'ID Yahoo', 
        'aim' => 'ID AIM', 
        'msn' => 'ID MSN', 
        // 'department' => 'Departamento',
        // 'institution' => 'Institución', 
        'interests' => 'Intereses', 
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

function local_hoteles_city_dashboard_get_count_users($userids){
    global $DB;
    // $whereids = implode(' AND _us_.id IN ', $userids->filters);
    $whereids = local_hoteles_city_dashboard_get_whereids_clauses($userids->filters, '_us_.id');
    return $DB->count_records_sql("SELECT count(*) FROM {user} as _us_ WHERE 1 = 1 {$whereids}", $userids->params);
}

function local_hoteles_city_dashboard_get_whereids_clauses($filters, $fieldname){
    if(empty($filters)){
        return "";
    }
    $separator = " AND {$fieldname} IN ";
    return $separator . implode($separator, $filters);
}

function local_hoteles_city_dashboard_get_enrolled_users_ids(int $courseid, string $fecha_inicial, string $fecha_final){
    $campo_fecha = "_ue.timestart";
    $filtro_fecha = local_hoteles_city_dashboard_create_sql_dates($campo_fecha, $fecha_inicial, $fecha_final);
    /* User is active participant (used in user_enrolments->status) -- Documentación tomada de enrollib.php 
    define('ENROL_USER_ACTIVE', 0);*/
    $query = "( SELECT DISTINCT __user__.id FROM {user} AS __user__
    JOIN {user_enrolments} AS __ue__ ON __ue__.userid = __user__.id
    JOIN {enrol} __enrol__ ON (__enrol__.id = __ue__.enrolid AND __enrol__.courseid = {$courseid})
    WHERE __ue__.status = 0 AND __user__.deleted = 0 {$filtro_fecha} AND __user__.suspended = 0)";
    // $query = "( SELECT DISTINCT __user__.id FROM {user} AS __user__
    // JOIN {user_enrolments} AS __ue__ ON __ue__.userid = __user__.id
    // JOIN {enrol} __enrol__ ON (__enrol__.id = __ue__.enrolid AND __enrol__.courseid = {$courseid})
    // WHERE __ue__.status = 0 AND __user__.deleted = 0 {$filtro_fecha} AND __user__.suspended = 0 AND __user__.id NOT IN 
    // (SELECT DISTINCT __role_assignments__.userid as userid
    //     FROM {course} AS __course__
    //     LEFT JOIN {context} AS __context__ ON __course__.id = __context__.instanceid
    //     JOIN {role_assignments} AS __role_assignments__ ON __role_assignments__.contextid = __context__.id
    //     WHERE __course__.id = {$courseid}
    //     AND __role_assignments__.roleid NOT IN (5) # No students
    // ) )";

    return $query;
}

/**
 * Obtiene la información de un curso
 * @param int $courseid Id de un curso
 * @param array $params arreglo con el nombre de un 
 */
function local_hoteles_city_dashboard_get_course_information(int $courseid, array $params = array()){
    global $DB;
    $course = $DB->get_record('course', array('id' => $courseid));
    if($course === false){
        return false;
    }
    $response = new stdClass();
    $response->key = 'course' . $courseid;
    $response->id = $courseid;
    // $response->chart = local_hoteles_city_dashboard_get_course_chart($courseid);
    $response->title = $course->fullname;
    $response->status = 'ok';
    $fecha_inicial = local_hoteles_city_dashboard_get_value_from_params($params, 'fecha_inicial');
    $fecha_final = local_hoteles_city_dashboard_get_value_from_params($params, 'fecha_final');

    $userids = local_hoteles_city_dashboard_get_user_ids_with_params($courseid, $params);
    if(empty($userids)){
        $response->activities = [];
        $response->enrolled_users = 0;
        $response->approved_users = 0;
        $response->percentage = 0;
        $response->not_approved_users = $response->enrolled_users - $response->approved_users;
        $response->value = 0;
        return $response;
    }
    // if($get_activities){
    //     $response->activities = local_hoteles_city_dashboard_get_activities_completion($courseid, $userids, $fecha_inicial, $fecha_final); //
    // }

    $response->enrolled_users = local_hoteles_city_dashboard_get_count_users($userids); //
    $response->approved_users = local_hoteles_city_dashboard_get_approved_users($courseid, $userids, $fecha_inicial, $fecha_final); //
    $response->not_approved_users = $response->enrolled_users - $response->approved_users;
    $response->percentage = local_hoteles_city_dashboard_percentage_of($response->approved_users, $response->enrolled_users);
    $response->value = $response->percentage;
    return $response;
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

DEFINE('local_hoteles_city_dashboard_pagination_course', 1);
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

function local_hoteles_city_dashboard_print_theme_variables(){
    $config = get_config('local_hoteles_city_dashboard');
    $config = (array) $config;
    $script = "<script>";
    $stylesheet = "<style>";
    foreach (local_hoteles_city_dashboard_theme_colors as $name => $value) {
        if(!empty($config[$name])) $value = $config[$name];
        $script .= " {$name} = '{$value}'; ";
        $stylesheet .= " .{$name} { background-color: {$value} !important; } ";
    }
    $script .= "</script>";
    $stylesheet .= "</style>";
    echo $stylesheet;
    echo $script;
    // _log(compact('stylesheet', 'script'));
}

DEFINE('local_hoteles_city_dashboard_pagination_admin', 2);
function local_hoteles_city_dashboard_get_report_columns(int $type = 0, $custom_information, $searched = '', $prefix = 'user.'){
    $select_sql = array("concat({$prefix}id, '||', {$prefix}firstname, ' ', {$prefix}lastname ) as name");
    $ajax_names = array("name");
    $visible_names = array('Nombre');
    $slim_query = array("id");
    // $slim_query = 
    // array_push($select_sql, 'fullname');
    $default_fields = local_hoteles_city_dashboard_get_default_report_fields();
    foreach($default_fields as $key => $df){
        if($key == $searched){
            array_push($slim_query, $prefix . $key);
        }
        array_push($ajax_names, $key);
        array_push($select_sql, $prefix . $key);
        array_push($visible_names, $df);
    }
    $custom_fields = local_hoteles_city_dashboard_get_custom_report_fields();
    $underscores = '_';
    foreach ($custom_fields as $key => $cf) {
        $new_key = "custom_" .$key;
        $select_key = " COALESCE((SELECT data FROM {user_info_data} AS {$underscores}uif WHERE {$underscores}uif.userid = user.id AND fieldid = {$key} LIMIT 1), '') AS {$new_key}";
        array_push($ajax_names, $new_key);
        array_push($select_sql, $select_key);
        array_push($visible_names, $cf);
        if($new_key == $searched){
            array_push($slim_query, $select_key);
        }
        $underscores .= "_";
    }
    switch ($type) {
        case local_hoteles_city_dashboard_pagination_course:
            global $DB;
            $courseid = $custom_information;
            $name = $DB->get_field('course', 'fullname', array('id' => $custom_information));
            if($name !== false){
                $key_name = 'custom_completion';
                $field = "IF( EXISTS( SELECT id FROM {course_completions} AS cc WHERE user.id = cc.userid 
                AND cc.course = {$custom_information} AND cc.timecompleted IS NOT NULL), 'Completado', 'No completado') as {$key_name}";
                array_push($select_sql, $field);
                array_push($ajax_names, $key_name);
                if($key_name == $searched){
                    array_push($slim_query, $field);
                }
                array_push($visible_names, $name);

                $key_name = 'custom_completion_date';
                $field = "COALESCE( EXISTS( SELECT DATE(FROM_UNIXTIME(cc.timecompleted)) FROM {course_completions} AS cc WHERE user.id = cc.userid 
                AND cc.course = {$custom_information} AND cc.timecompleted IS NOT NULL), '-') as {$key_name}";
                array_push($select_sql, $field);
                array_push($ajax_names, $key_name);
                if($key_name == $searched){
                    array_push($slim_query, $field);
                }
                array_push($visible_names, 'Fecha de completado');

                $grade_item = local_hoteles_city_dashboard_get_course_grade_item_id($custom_information);

                if($grade_item !== false){
                    $key_name = "custom_grade";
                    $field = "COALESCE( ( SELECT ROUND(gg.finalgrade, 2) FROM {grade_grades} AS gg
                    WHERE user.id = gg.userid AND gg.itemid = {$grade_item}), '-') as {$key_name}";
                    $field_slim = $field;
                    array_push($select_sql, $field);
                    if($key_name == $searched){
                        array_push($slim_query, $field_slim);
                    }
                    array_push($ajax_names, $key_name);
                    array_push($visible_names, 'Calificación actual');

                    $key_name = "custom_grade_date";
                    $field = "COALESCE( ( SELECT DATE(FROM_UNIXTIME(gg.timemodified)) FROM {grade_grades} AS gg
                    WHERE user.id = gg.userid AND gg.itemid = {$grade_item}), '-') as {$key_name}";
                    $field_slim = $field;
                    array_push($select_sql, $field);
                    if($key_name == $searched){
                        array_push($slim_query, $field_slim);
                    }
                    array_push($ajax_names, $key_name);
                    array_push($visible_names, 'Fecha de calificación');

                    // grade/report/grader/index.php?id=6 // Agregar libro de calificaciones // https://durango.aprendiendo.org.mx/grade/report/user/index.php?userid=8&id=6
                    
                }else{
                    _log('No existe item_grade para el curso: ', $custom_information);
                }
            }
            $key_name = 'link_edit_user';
            $field = "{$prefix}id as {$key_name}";
            $field_slim = "'edit' as {$key_name}";
            array_push($select_sql, $field);
            array_push($ajax_names, $key_name);
            // if($key_name == $searched){
            //     array_push($slim_query, $field_slim);
            // }
            array_push($visible_names, 'Editar usuario');

            $key_name = "link_suspend_user";
            $field = "{$prefix}id as {$key_name}";
            $field_slim = "'suspend' as {$key_name}";
            array_push($select_sql, $field);
            array_push($ajax_names, $key_name);
            // if($key_name == $searched){
            //     array_push($slim_query, $field_slim);
            // }
            array_push($visible_names, 'Suspender usuario');

            $key_name = "link_libro_calificaciones";
            $field = "{$prefix}id as {$key_name}";
            // $field_slim = "'suspend' as {$key_name}";
            array_push($select_sql, $field);
            array_push($ajax_names, $key_name);
            // if($key_name == $searched){
            //     array_push($slim_query, $field_slim);
            // }
            array_push($visible_names, 'Libro de calificaciones');

            break;    
        case local_hoteles_city_dashboard_pagination_admin:
            $key_name = 'link_edit_user';
            $field = "{$prefix}id as {$key_name}";
            $field_slim = "'edit' as {$key_name}";
            array_push($select_sql, $field);
            array_push($ajax_names, $key_name);
            // if($key_name == $searched){
            //     array_push($slim_query, $field_slim);
            // }
            array_push($visible_names, 'Editar usuario');

            $key_name = "link_suspend_user";
            $field = "{$prefix}id as {$key_name}";
            $field_slim = "'suspend' as {$key_name}";
            array_push($select_sql, $field);
            array_push($ajax_names, $key_name);
            // if($key_name == $searched){
            //     array_push($slim_query, $field_slim);
            // }
            array_push($visible_names, 'Suspender usuario');

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
                function ( data, type, row ) { return '<a target=\"_blank\" class=\"btn btn-info\" href=\"administrar_usuarios.php?id=' + data + '\">Suspender usuario</a>'; }  }, ";
            break;
            case 'link_edit_user':
                $ajax_code .= "{data: '{$an}', render: 
                function ( data, type, row ) { return '<a target=\"_blank\" class=\"btn btn-info\" href=\"administrar_usuarios.php?id=' + data + '\">Editar usuario</a>'; }  }, ";
                // $ajax_code .= "{data: '{$an}', render: function ( data, type, row ) { return data; }  }, ";            
            break;
            case 'name':
                $ajax_code .= "{data: '{$an}', render: 
                    function ( data, type, row ) { 
                        parts = data.split('||');
                        return '<a class=\"\" href=\"administrar_usuarios.php?id=' + parts[0] + '\">' + parts[1] + '</a>'; 
                    } 
                }, ";
            // $ajax_code .= "{data: '{$an}', render: function ( data, type, row ) { return data; }  }, ";
            break;
            case 'link_libro_calificaciones':
                global $CFG;
                $ajax_code .= "{data: '{$an}', render: function ( data, type, row ) 
                    { return '<a target=\"_blank\" class=\"btn btn-info\" href=\"{$CFG->wwwroot}/grade/report/user/index.php?id={$custom_information}&userid=' + data + '\">Libro de calificaciones</a>'; }  
                }, ";
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
    $table_code = "";
    foreach($visible_names as $vn){
        $table_code .= "<th>{$vn}</th>";
    }
    // $table_code .= "<th>Una última columna</th>"; // Ejemplo agregando una columna de alguna ya generada
    $response = new stdClass();
    $response->select_sql = $prefix . 'id, ' . $imploded_sql;
    $response->ajax_code = $ajax_code;
    $response->ajax_printed_rows = $ajax_printed_rows;
    $response->table_code = $table_code;
    $response->slim_query = $imploded_slim;
    $response->default_fields = $default_fields;
    $response->custom_fields = $custom_fields;
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
 * @param int $courseid id del curso a buscar
 * @param stdClass $userids obtenido desde local_hoteles_city_dashboard_get_user_ids_with_params()
 * @param string $fecha_inicial fecha inicial en formato YYYY-MM-DD o ''
 * @param string $fecha_final fecha final en formato YYYY-MM-DD o ''
 * @return int Número de estudiantes aprobados
 */
function local_hoteles_city_dashboard_get_approved_users(int $courseid, stdClass $userids, string $fecha_inicial, string $fecha_final){ //
    $response = 0;

    $whereids = local_hoteles_city_dashboard_get_whereids_clauses($userids->filters, 'p.userid');
    $campo_fecha = "p.timecompleted";
    $filtro_fecha = local_hoteles_city_dashboard_create_sql_dates($campo_fecha, $fecha_inicial, $fecha_final);    
    $query = "SELECT count(*) AS completions FROM {course_completions} AS p
    WHERE p.course = {$courseid} AND p.timecompleted IS NOT NULL {$filtro_fecha} {$whereids} ";

    global $DB;
    if($result = $DB->get_record_sql($query, $userids->params)){
        $response = $result->completions;
        return $response;
    }
}

function local_hoteles_city_dashboard_percentage_of(int $number, int $total, int $decimals = 2 ){
    if($total != 0){
        return round($number / $total * 100, $decimals);
    }else{
        return 0;
    }
}

function local_hoteles_city_dashboard_get_user_ids_with_params(int $courseid, array $params = array()){
    $fecha_inicial = local_hoteles_city_dashboard_get_value_from_params($params, 'fecha_inicial');
    $fecha_final = local_hoteles_city_dashboard_get_value_from_params($params, 'fecha_final');
    // Se omite $fecha_inicial debido a que si se incluye los usuarios inscritos anteriormente serían omitidos, activar si se pide explícitamente ese funcionamiento
    // $ids = local_hoteles_city_dashboard_get_enrolled_users_ids($courseid, $fecha_inicial, $fecha_final);
    $ids = local_hoteles_city_dashboard_get_enrolled_users_ids($courseid, '', $fecha_final);
    $filters_sql = array();
    array_push($filters_sql, $ids);
    $query_parameters = array();
    // Falta adaptar la lógica de las consultas
    // if(!empty($params)){
    //     $indicators = local_hoteles_city_dashboard_get_indicators();
    //     $prefix = "___";
    //     $tableName = 'user_info_data';
    //     foreach($params as $key => $param){
    //         if(array_search($key, $indicators) !== false){
    //             $fieldid = get_config('local_hoteles_city_dashboard', "filtro_" . $key);
    //             if($fieldid !== false){
    //                 $prefix .= '_';
    //                 $alias = $prefix . $tableName;
    //                 $data = $params[$key];
    //                 if(is_string($data) || is_numeric($data)){
    //                     array_push($filters_sql, " (SELECT DISTINCT {$alias}.userid FROM {user_info_data} AS {$alias} WHERE {$alias}.fieldid = ? AND {$alias}.data = ?) ");
    //                     array_push($query_parameters, $fieldid);
    //                     array_push($query_parameters, $data);
    //                 }elseif(is_array($data)){
    //                     $wheres = array();
    //                     $query_params = array();
    //                     $options = array();
    //                     foreach ($data as $d) {
    //                             array_push($wheres, " data = ? ");
    //                             array_push($query_params, $d);
    //                             array_push($options, $d);
    //                             array_push($query_parameters, $d);
    //                     }
    //                     if(!empty($options)){
    //                         $bindParams = array();
    //                         for($i = 0; $i < count($options); $i++){
    //                             array_push($bindParams, '?');
    //                         }
    //                         $bindParams = implode(',', $bindParams);
    //                         array_push($filters_sql, " (SELECT DISTINCT {$alias}.userid FROM {user_info_data} AS {$alias} WHERE {$alias}.data IN ({$bindParams}) AND {$alias}.fieldid = ? ) ");
    //                         array_push($query_parameters, $fieldid);                            
    //                     }
    //                     if(!empty($wheres)){
    //                         $wheres = " AND ( " . implode(" || ", $wheres) . " ) ";
    //                     }
    //                 }
    //             }
    //         }
    //     }
    // }
    $response = new stdClass();
    $response->filters = $filters_sql;
    $response->params = $query_parameters;
    return $response;
}

/**
 * Devuelve un menú (clave => valor ... ) de los campos de usuario personalizados
 */
function local_hoteles_city_dashboard_get_custom_profile_fields(string $ids = ''){
    global $DB;
    if(!empty($ids)){
        return $DB->get_records_sql_menu("SELECT id, name FROM {user_info_field} WHERE id IN ({$ids}) ORDER BY name");
    }
    return $DB->get_records_menu('user_info_field', array(), 'name', "id, name");
}

/**
 * Regresa información para la paginación de usuarios compatible con datatables
 */
function local_hoteles_city_dashboard_get_paginated_users(array $params){
    $courseid = local_hoteles_city_dashboard_get_value_from_params($params, 'courseid');
    $courseid = intval($courseid);
    // _log($params);
    $enrol_sql_query = " user.id IN " . local_hoteles_city_dashboard_get_enrolled_users_ids($courseid, $desde = '', $hasta = '');
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
    $searchQuery = " WHERE " . $enrol_sql_query;
    $searched = '';
    if(!empty($searchValue) && strpos($columnName, 'link') !== false){
        $searched = $columnName;
    }
    $queryParams = array();
    
    
    $report_info = local_hoteles_city_dashboard_get_report_columns(local_hoteles_city_dashboard_pagination_course, $courseid, $searched);

    /* Versión con consulta de solamente nombre y email */
    // if($searchValue != ''){
    //     $searchValue = "%{$searchValue}%";
    //     $searchQuery = " WHERE email like ? or concat(firstname, ' ', lastname) like ? AND " . $enrol_sql_query;
    //     array_push($queryParams, $searchValue);
    //     array_push($queryParams, $searchValue);
    // }

    ## Fetch records
    // $report_info = local_hoteles_city_dashboard_get_report_columns(local_hoteles_city_dashboard_pagination_course, $courseid, $searched);
    $select_sql = $report_info->select_sql;
    $select_slim = $report_info->slim_query;
    $limit = " LIMIT {$row}, {$rowperpage}";
    if($rowperpage == -1){
        $limit = "";
    }
    
    ## Total number of records without filtering
    $query = 'SELECT COUNT(*) FROM {user} AS user WHERE ' . $enrol_sql_query;
    // _sql('Sin filtro ', $query, $queryParams);
    $totalRecords = $DB->count_records_sql($query);//($table, $conditions_array);
    // _log('Elementos totales', $totalRecords);    
    if($searchValue != ''){
        if($columnName == 'name'){ // Campo por defecto name
        // if(strpos('user.name',$columnName) !== false){
            $searchValue = "%{$searchValue}%";
            $searchQuery = " WHERE " . $enrol_sql_query . " AND CONCAT(firstname, ' ', lastname) like ? ";
            // array_push($queryParams, $searchValue);
        }elseif(strpos($columnName, 'custom_') !== false){ // Campo que requiere having
        // }elseif(strpos('user.',$columnName) !== false){
            $searchValue = "%{$searchValue}%";
            $searchQuery = " WHERE $enrol_sql_query HAVING {$columnName} like ?  " ;
        }else{ // Campo estándar de la tabla user
            $searchValue = "%{$searchValue}%";
            $searchQuery = " WHERE {$columnName} like ? AND " . $enrol_sql_query;
        }
        $searched = $columnName;
    }

    ## Total number of record with filtering
    $query = "SELECT count(*) FROM (SELECT {$select_slim} FROM {user} AS user {$searchQuery}) AS t1";
    $queryParamsFilter = array($searchValue);
    
    $totalRecordwithFilter = $DB->count_records_sql($query, $queryParamsFilter);
    // _log('Elementos filtrados', $totalRecordwithFilter);
    // _sql('Filtrados ', $query, $queryParamsFilter);
    
    ## Consulta de los elementos
    $queryParams = array();
    array_push($queryParams, $searchValue);
    $query = "select {$select_sql} from {user} AS user {$searchQuery} order by {$columnName} {$columnSortOrder} {$limit}";
    // _log($query);
    // _log($queryParams);
    // _sql('Consulta de elementos ', $query, $queryParams);
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
    function _sql(string $title = 'Probando Consulta. Debugger por subitus', string $query, array $params = array()){
        $title .= ' ';
        $original = $query;
        $query = str_replace('{', 'mdl_', $query);
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
    $query = "SELECT id, fullname, shortname FROM {course} where category != 0 {$andWhereClause} order by sortorder";
    return $DB->get_records_sql($query, $andWhereClauseParams);
}

function local_hoteles_city_dashboard_get_catalogues(){
    global $DB;
    $institutions = $DB->get_records_sql_menu("SELECT distinct institution, institution as i FROM {user}
     WHERE suspended = 0 AND deleted = 0 AND institution != ''"); // Hoteles
    $departments  = $DB->get_records_sql_menu("SELECT distinct department, department as i FROM {user}
     WHERE suspended = 0 AND deleted = 0 AND department != ''"); // Puestos
    $filtercustomfields = local_hoteles_city_dashboard_get_array_from_config(get_config('local_hoteles_city_dashboard', 'filtercustomfields'));
    
    $filterdefaultfields = local_hoteles_city_dashboard_get_array_from_config(get_config('local_hoteles_city_dashboard', 'filterdefaultfields'));

    // "SELECT data from {user_info_data} as uid_ WHERE uid_.fieldid = {$fieldid} AND uid_.userid = uid.userid {$_allow_empty} (SELECT data as menu_value FROM {user_info_data} where fieldid = {$fieldid} {$andWhereSql} {$allow_empty} group by data) ";
    return compact('institutions', 'departments');
}

function local_hoteles_city_dashboard_get_array_from_config($config){
    if($config === false){
        return array();
    }
    if(empty($config)){
        return array();
    }
    try{
        return explode(',', $config);
    }catch(Exception $e){
        return array();
    }
}

function local_hoteles_city_dashboard_get_regions(){
    global $DB;
    return $DB->get_records('dashboard_region');
}

function local_hoteles_city_dashboard_create_region(array $params){
    try{
        global $DB;
        $name = local_hoteles_city_dashboard_get_value_from_params($params, 'name', false);
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
        $regionid = local_hoteles_city_dashboard_get_value_from_params($params, 'id', false);
        $institution = local_hoteles_city_dashboard_get_value_from_params($params, 'institution', false);
        if(local_hoteles_city_dashboard_has_empty($regionid, $institution)){
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
        if(empty($id)) return "No se encontró región";
        $delete = local_hoteles_city_dashboard_get_value_from_params($params, 'delete', false);
        
        global $DB;
        if($delete){
            $DB->delete_records('dashboard_region', array('id' => $id));
            $firstRegionId = $DB->get_field_sql('SELECT id FROM {dashboard_region} WHERE active = 1 LIMIT 1');
            if($firstRegionId !== false){
                $DB->execute('UPDATE {dashboard_region_ins} SET regionid = ? WHERE regionid = ?', array($firstRegionId, $id));
            }
            return "Eliminada";
        }
        $name = local_hoteles_city_dashboard_get_value_from_params($params, 'name', false);
        $change_status = local_hoteles_city_dashboard_get_value_from_params($params, 'change_status', false);
        if(empty($name) && empty($change_status)) return "Por favor, agregue un nombre a la región e inténtelo de nuevo";
        $region = $DB->get_record('dashboard_region', array('id' => $id));
        if(empty($region)) return "No se encontró la región";
        // if(local_hoteles_city_dashboard_has_empty($regionid, $institution)){
        //     _log('Datos vacíos en creación de kpi', $params);
        //     return 'Por favor llene todos los campos';
        // }
        $region->name = $name;
        if($change_status) { $region->active = !$region->active; }
        // $record = $DB->get_record('dashboard_region_ins', array('regionid' => $regionid));
        $insertion = $DB->update_record('dashboard_region', $region);
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
        return "ok";
    }catch(Exception $e){
        _log('Error al relacionar región con institución', $e);
        return 'Por favor, inténtelo de nuevo';
    }
}

function local_hoteles_city_dashboard_get_region_institution_relationships(){
    global $DB;
    return $DB->get_records_sql_menu('SELECT institution, regionid FROM {dashboard_region_ins}');
}

/**
 * Devuelve las unidades operativas correspondientes (institutions) de la región
 * @param int $regionid Id de la región que se desean ver las unidades operativas
 * @return string Unidades operativas correspondientes a la región
 */
function local_hoteles_city_dashboard_get_region_insitutions($regionid){
    $default = "Sin unidades operativas";
    if(empty($regionid)) return $default;
    global $DB;
    $regions = $DB->get_records_sql_menu('SELECT id, institution FROM {dashboard_region_ins} WHERE regionid = ?', array($regionid));
    if($regions){
        $regions = implode(', ', $regions);
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

function local_hoteles_city_dashboard_get_custom_catalogue(int $fieldid){
    global $DB;
    $query = "SELECT DISTINCT data, data FROM {user_info_data} where fieldid = {$fieldid} group by data order by data ASC";
    return $DB->get_records_sql_menu($query);
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

/*
SELECT u.firstname AS 'First' , u.lastname AS 'Last', CONCAT(u.firstname , ' ' , u.lastname) AS 'Display Name', 
c.fullname AS 'Course', 
-- cc.name AS 'Category',
CASE 
  WHEN gi.itemtype = 'course' 
   THEN CONCAT(c.fullname, ' - Total')
  ELSE gi.itemname
END AS 'Item Name',
 
ROUND(gg.finalgrade,2) AS Grade,
FROM_UNIXTIME(gg.timemodified) AS TIME
 
FROM mdl_course AS c
-- JOIN mdl_context AS ctx ON c.id = ctx.instanceid
-- JOIN mdl_role_assignments AS ra ON ra.contextid = ctx.id
JOIN mdl_grade_items AS gi ON gi.courseid = c.id
JOIN mdl_grade_grades AS gg ON gi.id = gg.itemid
JOIN mdl_user AS u ON gg.userid = u.id
-- JOIN mdl_course_categories AS cc ON cc.id = c.category
 
-- WHERE  gi.courseid = c.id AND gi.itemtype = 'course'
WHERE gi.itemtype = 'course' AND gi.courseid = c.id
ORDER BY lastname



SELECT CONCAT( ROUND(gg.finalgrade,2), ' - ', FROM_UNIXTIME(gg.timemodified)) AS Grade
 
FROM mdl_course AS c
JOIN mdl_context AS ctx ON c.id = ctx.instanceid
JOIN mdl_role_assignments AS ra ON ra.contextid = ctx.id
JOIN mdl_user AS u ON u.id = ra.userid
JOIN mdl_grade_grades AS gg ON gg.userid = u.id
JOIN mdl_grade_items AS gi ON gi.id = gg.itemid
-- JOIN mdl_course_categories AS cc ON cc.id = c.category
 
WHERE  gi.courseid = c.id AND gi.itemtype = 'course'





SELECT u.firstname AS 'First' , u.lastname AS 'Last', CONCAT(u.firstname , ' ' , u.lastname) AS 'Display Name', 
c.fullname AS 'Course', 
cc.name AS 'Category',
CASE 
  WHEN gi.itemtype = 'course' 
   THEN CONCAT(c.fullname, ' - Total')
  ELSE gi.itemname
END AS 'Item Name',
 
ROUND(gg.finalgrade,2) AS Grade,
FROM_UNIXTIME(gg.timemodified) AS TIME
 
FROM mdl_course AS c
JOIN mdl_context AS ctx ON c.id = ctx.instanceid
JOIN mdl_role_assignments AS ra ON ra.contextid = ctx.id
JOIN mdl_user AS u ON u.id = ra.userid
JOIN mdl_grade_grades AS gg ON gg.userid = u.id
JOIN mdl_grade_items AS gi ON gi.id = gg.itemid
JOIN mdl_course_categories AS cc ON cc.id = c.category
 
WHERE  gi.courseid = c.id AND gi.itemtype = 'course'
ORDER BY lastname
*/
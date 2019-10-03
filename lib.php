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
    }
}

function custom_useredit_shared_definition(&$mform, $editoroptions, $filemanageroptions, $user) {
    $allowed_fields = get_config('local_hoteles_city_dashboard', 'userformdefaultfields');
    // _log('userformdefaultfields', $allowed_fields);
    if(empty($allowed_fields)){
        return;
    }
    $allowed_fields = explode(',', $allowed_fields);
    // _log('custom_useredit_shared_definition() allowed fields', $allowed_fields);

    global $CFG, $USER, $DB;

    if ($user->id > 0) {
        useredit_load_preferences($user, false);
    }

    $strrequired = get_string('required');
    $stringman = get_string_manager();

    // Add the necessary names.
    $fields = useredit_get_required_name_fields(); // fullname y lastname
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

    $enabledusernamefields = useredit_get_enabled_name_fields();
    // _log('$enabledusernamefields', $enabledusernamefields);
    // Add the enabled additional name fields.
    foreach ($enabledusernamefields as $addname) {
        $mform->addElement('text', $addname,  get_string($addname), 'maxlength="100" size="30"');
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
        $mform->setType('city', PARAM_TEXT);
        if (!empty($CFG->defaultcity)) {
            $mform->setDefault('city', $CFG->defaultcity);
        }
    }

    if(in_array('country', $allowed_fields)){
        $choices = get_string_manager()->get_list_of_countries();
        $choices = array('' => get_string('selectacountry') . '...') + $choices;
        $mform->addElement('select', 'country', get_string('selectacountry'), $choices);
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

    if(in_array('description', $allowed_fields)){
        $mform->addElement('editor', 'description_editor', get_string('userdescription'), null, $editoroptions);
        $mform->setType('description_editor', PARAM_CLEANHTML);
        $mform->addHelpButton('description_editor', 'userdescription');
    // }else{
    //     $mform->addElement('hidden', 'description_editor');
    //     $mform->setType('description_editor', PARAM_CLEANHTML);
    //     // $mform->addHelpButton('description_editor', 'userdescription');
    }

    // Edición de imágenes
    if(get_config('local_hoteles_city_dashboard', 'userformimage')){
        // if (empty($USER->newadminuser)) {
            $mform->addElement('header', 'moodle_picture', get_string('pictureofuser'));
            $mform->setExpanded('moodle_picture', true);
    
            if (!empty($CFG->enablegravatar)) {
                $mform->addElement('html', html_writer::tag('p', get_string('gravatarenabled')));
            }
    
            $mform->addElement('static', 'currentpicture', get_string('currentpicture'));
    
            $mform->addElement('checkbox', 'deletepicture', get_string('deletepicture'));
            $mform->setDefault('deletepicture', 0);
    
            $mform->addElement('filemanager', 'imagefile', get_string('newpicture'), '', $filemanageroptions);
            $mform->addHelpButton('imagefile', 'newpicture');
    
            $mform->addElement('text', 'imagealt', get_string('imagealt'), 'maxlength="100" size="30"');
            $mform->setType('imagealt', PARAM_TEXT);
    
        // }
    }

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
            $mform->addHelpButton('interests', 'interestslist');
        // }
    }


    // Moodle optional fields.
    // $mform->addElement('header', 'moodle_optional', get_string('optional', 'form'));

    if(in_array('url', $allowed_fields)){ 
        $mform->addElement('text', 'url', get_string('webpage'), 'maxlength="255" size="50"');
        $mform->setType('url', core_user::get_property_type('url'));
    }

    if(in_array('icq', $allowed_fields)){
        $mform->addElement('text', 'icq', get_string('icqnumber'), 'maxlength="15" size="25"');
        $mform->setType('icq', core_user::get_property_type('icq'));
        $mform->setForceLtr('icq');
    }

    if(in_array('skype', $allowed_fields)){
        $mform->addElement('text', 'skype', get_string('skypeid'), 'maxlength="50" size="25"');
        $mform->setType('skype', core_user::get_property_type('skype'));
        $mform->setForceLtr('skype');
    }

    if(in_array('aim', $allowed_fields)){
        $mform->addElement('text', 'aim', get_string('aimid'), 'maxlength="50" size="25"');
        $mform->setType('aim', core_user::get_property_type('aim'));
        $mform->setForceLtr('aim');
    }

    if(in_array('yahoo', $allowed_fields)){
        $mform->addElement('text', 'yahoo', get_string('yahooid'), 'maxlength="50" size="25"');
        $mform->setType('yahoo', core_user::get_property_type('yahoo'));
        $mform->setForceLtr('yahoo');
    }

    if(in_array('msn', $allowed_fields)){
        $mform->addElement('text', 'msn', get_string('msnid'), 'maxlength="50" size="25"');
        $mform->setType('msn', core_user::get_property_type('msn'));
        $mform->setForceLtr('msn');
    }

    if(in_array('idnumber', $allowed_fields)){
        $mform->addElement('text', 'idnumber', get_string('idnumber'), 'maxlength="255" size="25"');
        $mform->setType('idnumber', core_user::get_property_type('idnumber'));
    }

    if(in_array('institution', $allowed_fields)){
        $mform->addElement('text', 'institution', get_string('institution'), 'maxlength="255" size="25"');
        $mform->setType('institution', core_user::get_property_type('institution'));
    }

    if(in_array('department', $allowed_fields)){
        $mform->addElement('text', 'department', get_string('department'), 'maxlength="255" size="25"');
        $mform->setType('department', core_user::get_property_type('department'));
    }

    if(in_array('phone1', $allowed_fields)){
        $mform->addElement('text', 'phone1', get_string('phone1'), 'maxlength="20" size="25"');
        $mform->setType('phone1', core_user::get_property_type('phone1'));
        $mform->setForceLtr('phone1');
    }

    if(in_array('phone2', $allowed_fields)){
        $mform->addElement('text', 'phone2', get_string('phone2'), 'maxlength="20" size="25"');
        $mform->setType('phone2', core_user::get_property_type('phone2'));
        $mform->setForceLtr('phone2');
    }

    if(in_array('address', $allowed_fields)){
        $mform->addElement('text', 'address', get_string('address'), 'maxlength="255" size="25"');
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
    // _log('categorías', $categories); // QUITAR ESTO
    $count = 0;
    // $first = true;
    $allowed_fields = get_config('local_hoteles_city_dashboard', 'userformcustomfields');
    if(empty($allowed_fields)){
        return;
    }
    $allowed_fields = explode(',', $allowed_fields);
    $any = false;
    foreach ($categories as $categoryid => $fields) {
        // _log('fields', $fields); // QUITAR ESTO
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
                    //     _log($formfield);
                    // }
                if($first){
                    // $mform->addElement('header', 'category_'.$categoryid, format_string($formfield->get_category_name()));
                    $first = !$first;
                    // _log($formfield);
                    $first = false;
                }
                if(!$any){
                    $mform->addElement('header', 'custom_fields', 'Campos de perfil del usuario');
                    $mform->setExpanded('custom_fields', true);
                    $any = true;
                }
                $formfield->edit_field($mform);
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
        'department' => 'Departamento',
        'institution' => 'Institución', 
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
    // _log('Llegando a local_hoteles_city_dashboard_get_whereids_clauses()', $filters);
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
    WHERE __ue__.status = 0 AND __user__.deleted = 0 {$filtro_fecha} AND __user__.suspended = 0 AND __user__.id NOT IN 
    (SELECT DISTINCT __role_assignments__.userid as userid
        FROM {course} AS __course__
        LEFT JOIN {context} AS __context__ ON __course__.id = __context__.instanceid
        JOIN {role_assignments} AS __role_assignments__ ON __role_assignments__.contextid = __context__.id
        WHERE __course__.id = {$courseid}
        AND __role_assignments__.roleid NOT IN (5) # No students
    ) )";

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
    _log('local_hoteles_city_dashboard_get_user_ids_with_params()', $userids);
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

function local_hoteles_city_dashboard_get_report_columns($prefix = 'user.'){
    $select_sql = array("concat({$prefix}firstname, ' ', {$prefix}lastname) as name");
    $ajax_names = array("name");
    $visible_names = array('Nombre');
    // array_push($select_sql, 'fullname');
    $default_fields = local_hoteles_city_dashboard_get_default_report_fields();
    // _log(compact('default_fields'));
    foreach($default_fields as $key => $df){
        array_push($ajax_names, $key);
        array_push($select_sql, $prefix . $key);
        array_push($visible_names, $df);
    }
    $custom_fields = local_hoteles_city_dashboard_get_custom_report_fields();
    // _log(compact('custom_fields'));
    $underscores = '_';
    foreach ($custom_fields as $key => $cf) {
        $new_key = "custom_" .$key;
        $select_key = " COALESCE((SELECT data FROM {user_info_data} AS {$underscores}uif WHERE {$underscores}uif.userid = user.id AND fieldid = {$key} LIMIT 1), '') AS {$new_key}";
        array_push($ajax_names, $new_key);
        array_push($select_sql, $select_key);
        array_push($visible_names, $cf);
        $underscores .= "_";
    }
    $imploded_sql = implode(', 
    ', $select_sql);
    $ajax_code = "";
    foreach($ajax_names as $an){
        $ajax_code .= "{data: '{$an}'}, ";
    }
    $table_code = "";
    foreach($visible_names as $vn){
        $table_code .= "<th>{$vn}</th>";
    }
    // _log($table_code);

    $response = new stdClass();
    $response->select_sql = $prefix . 'id, ' . $imploded_sql;
    $response->ajax_code = $ajax_code;
    $response->table_code = $table_code;

    return $response;
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
function local_hoteles_city_dashboard_get_paginated_users(array $params, int $courseid = null){
    if(empty($params)){
        return array();
    }
    _log($params);
    global $DB;
    $draw = $params['draw'];
    $row = $params['start'];
    $rowperpage = $params['length']; // Rows display per page
    $columnIndex = $params['order'][0]['column']; // Column index
    $columnName = $params['columns'][$columnIndex]['data']; // Column name
    $columnSortOrder = $params['order'][0]['dir']; // asc or desc
    $searchValue = $params['search']['value']; // Search value

    ## Search 
    $searchQuery = " ";
    $queryParams = array();
    if($searchValue != ''){
        $searchValue = "%{$searchValue}%";
        $searchQuery = " WHERE email like ? or concat(firstname, ' ', lastname) like ? ";
        array_push($queryParams, $searchValue);
        array_push($queryParams, $searchValue);
    }

    ## Total number of records without filtering
    $totalRecords = $DB->count_records('user');//($table, $conditions_array);

    ## Total number of record with filtering
    $totalRecordwithFilter = $DB->count_records_sql("select count(*) from {user} {$searchQuery}", $queryParams);

    $default_fields = local_hoteles_city_dashboard_get_default_report_fields();
    $custom_fields  = local_hoteles_city_dashboard_get_custom_report_fields();

    $orderBy = " order by {$columnName} {$columnSortOrder} ";
    if($columnName == 'fullname'){
        $orderBy = " ORDER BY fullname {$columnSortOrder}";
    }

    // _log('$default_fields', $default_fields);
    $select_default = "";
    if(!empty($default_fields)){
        $select_default = ', ' . implode(',', $default_fields);
    }
    // _log('$custom_fields', $custom_fields);
    if(!empty($custom_fields)){
        implode(',', $custom_fields);
    }

    ## Fetch records
    $report_info = local_hoteles_city_dashboard_get_report_columns();
    // _log($report_info);
    $select_sql = $report_info->select_sql;
    $limit = " LIMIT {$row}, {$rowperpage}";
    if($rowperpage == -1){
        $limit = "";
    }
    $records = $DB->get_records_sql("select {$select_sql} from {user} AS user {$searchQuery} order by {$columnName} {$columnSortOrder}
                                     {$limit}", $queryParams);

    ## Response
    $response = array(
        "draw" => intval($draw),
        "iTotalRecords" => $totalRecordwithFilter,
        "iTotalDisplayRecords" => $totalRecords,
        "aaData" => array_values($records)
    );
    $json_response = json_encode($response);
    // _log($response);
    return $json_response;
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
     * @param ... any Recibe varios parámetros e imprime su valor en el archivo log, para pasarlos a cadena de texto se utiliza print_r($var, true)
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
    return $DB->get_records_sql($query);
}

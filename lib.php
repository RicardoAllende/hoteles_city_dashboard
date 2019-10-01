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

function local_hoteles_city_dashboard_user_has_access(bool $throwError = true){
    $has_capability = has_capability('local/hoteles_city_dashboard:view', context_system::instance());
    if(!$has_capability){ // si el rol del usuario no tiene permiso, buscar si está en la configuración: allowed_email_admins
        if(isloggedin()){
            $allowed_email_admins = get_config('local_hoteles_city_dashboard', 'allowed_email_admins');
            if(!empty($allowed_email_admins)){
                $allowed_email_admins = explode(' ', $allowed_email_admins);
                if(!empty($allowed_email_admins)){
                    global $USER;
                    $email = $USER->email;
                    if(in_array($email, $allowed_email_admins) !== false){
                        $has_capability = true;
                    }
                }
            }
        }
    }
    if($throwError){
        if(!$has_capability){
            print_error('Usted no tiene permiso para acceder a esta sección');
        }
    }else{
        return $has_capability;
    }
}

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
    $allowed_fields = get_config('local_hoteles_city_dashboard', 'signindefaultfields');
    _log('signindefaultfields', $allowed_fields);
    if(empty($allowed_fields)){
        return;
    }
    $allowed_fields = explode(',', $allowed_fields);
    _log('custom_useredit_shared_definition() allowed fields', $allowed_fields);

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

    if(in_array('timezone', $allowed_fields)){
        if (isset($CFG->forcetimezone) and $CFG->forcetimezone != 99) {
            $choices = core_date::get_list_of_timezones($CFG->forcetimezone);
            $mform->addElement('static', 'forcedtimezone', get_string('timezone'), $choices[$CFG->forcetimezone]);
            $mform->addElement('hidden', 'timezone');
            $mform->setType('timezone', core_user::get_property_type('timezone'));
        } else {
            $choices = core_date::get_list_of_timezones($user->timezone, true);
            $mform->addElement('select', 'timezone', get_string('timezone'), $choices);
        }
    }

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
    }

    // Edición de imágenes
    // if(in_array('imagen', $allowed_fields)){
        if (empty($USER->newadminuser)) {
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
    
        }
    // }

    // Display user name fields that are not currenlty enabled here if there are any.
    $disabledusernamefields = useredit_get_disabled_name_fields($enabledusernamefields);
    if (count($disabledusernamefields) > 0) {
        $mform->addElement('header', 'moodle_additional_names', get_string('additionalnames'));
        foreach ($disabledusernamefields as $allname) {
            $mform->addElement('text', $allname, get_string($allname), 'maxlength="100" size="30"');
            $mform->setType($allname, PARAM_NOTAGS);
        }
    }
    if(in_array('interests', $allowed_fields)){ 
        if (core_tag_tag::is_enabled('core', 'user') and empty($USER->newadminuser)) {
            $mform->addElement('header', 'moodle_interests', get_string('interests'));
            $mform->addElement('tags', 'interests', get_string('interestslist'),
                array('itemtype' => 'user', 'component' => 'core'));
            $mform->addHelpButton('interests', 'interestslist');
        }
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
    $allowed_fields = get_config('local_hoteles_city_dashboard', 'signincustomfields');
    if(empty($allowed_fields)){
        return;
    }
    $allowed_fields = explode(',', $allowed_fields);
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
                    $mform->addElement('header', 'category_'.$categoryid, format_string($formfield->get_category_name()));
                    $first = !$first;
                    // _log($formfield);
                    $first = false;
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

function local_hoteles_city_dashboard_get_default_profile_fields(){
    $fields = array(
        // 'username', 
        // 'fullname', 
        // 'firstname', 
        // 'lastname', 
        'email',
        'address', 
        'phone1', 
        'phone2', 
        'icq', 
        'skype', 
        'yahoo', 
        'aim', 
        'msn', 
        'department',
        'institution', 
        'interests', 
        'idnumber', 
        // 'lang', 
        'timezone', 
        'description',
        'city', 
        'url', 
        'country',
    );
    $response = array();
    foreach($fields as $field){
        $response[$field] = $field;
    }
    return $response;
}


// DEFINE("LOCAL_HOTELES_CITY_DASHBOARD_CATEGORY_PARENT_NAME", "parent_category");
// DEFINE("LOCAL_HOTELES_CITY_DASHBOARD_DEBUG", true);

// DEFINE("LOCAL_HOTELES_CITY_KPI_NA", 0);
// DEFINE("LOCAL_HOTELES_CITY_KPI_OPS", 1);
// DEFINE("LOCAL_HOTELES_CITY_KPI_HISTORICO", 2);
// DEFINE("LOCAL_HOTELES_CITY_KPI_SCORCARD", 3);

// DEFINE("LOCAL_HOTELES_CITY_DASHBOARD_NOFILTER", "__NOFILTER__");

// DEFINE('LOCAL_HOTELES_CITY_DASHBOARD_PROGRAMAS_ENTRENAMIENTO', 1);
// DEFINE('LOCAL_HOTELES_CITY_DASHBOARD_CURSOS_CAMPANAS', 2);
// DEFINE('LOCAL_HOTELES_CITY_DASHBOARD_COURSE_KPI_COMPARATIVE', 3);
// DEFINE('LOCAL_HOTELES_CITY_DASHBOARD_AVAILABLE_COURSES', 4);

// function local_hoteles_city_dashboard_get_course_tabs(){
//     return $tabOptions = [
//         LOCAL_HOTELES_CITY_DASHBOARD_PROGRAMAS_ENTRENAMIENTO => 'Programas de entrenamiento',
//         LOCAL_HOTELES_CITY_DASHBOARD_CURSOS_CAMPANAS => 'Campañas',
//         LOCAL_HOTELES_CITY_DASHBOARD_COURSE_KPI_COMPARATIVE => "Comparación de KPI's",
//     ];
// }

// function local_hoteles_city_dashboard_get_course_tabs_as_js_script(){
//     $result = json_encode(local_hoteles_city_dashboard_get_course_tabs());
//     return "<script> var ldm_course_tabs = {$result}; </script>";
// }

// function local_hoteles_city_dashboard_get_KPIS(){
//     return [
//         // LOCAL_HOTELES_CITY_KPI_NA => "N/A", // No kpi
//         LOCAL_HOTELES_CITY_KPI_OPS => "AUDITORÍA ICA",
//         LOCAL_HOTELES_CITY_KPI_HISTORICO => "TOTAL DE QUEJAS POR TIENDA",
//         LOCAL_HOTELES_CITY_KPI_SCORCARD => "INDICADORES RRHH"
//     ];
// }

// DEFINE("LOCAL_HOTELES_CITY_DASHBOARD_COMPLETION_DEFAULT", 1);
// DEFINE("LOCAL_HOTELES_CITY_DASHBOARD_COMPLETION_DEFAULT_AND_GRADE", 2);
// DEFINE("LOCAL_HOTELES_CITY_DASHBOARD_COMPLETION_BY_GRADE", 3);
// DEFINE("LOCAL_HOTELES_CITY_DASHBOARD_COMPLETION_BY_BADGE", 4);
// DEFINE("LOCAL_HOTELES_CITY_DASHBOARD_COMPLETION_BY_ACTIVITY", 5);
// DEFINE("LOCAL_HOTELES_CITY_DASHBOARD_COMPLETION_BY_AVG", 6);
// //DEFINE("LOCAL_HOTELES_CITY_DASHBOARD_COMPLETION_BY_ATTENDANCE", 5);

// DEFINE('LOCAL_HOTELES_CITY_DASHBOARD_INDICATORS', 'regiones/distritos/entrenadores/tiendas/puestos/ccosto');
// DEFINE('LOCAL_HOTELES_CITY_DASHBOARD_INDICATORS_FOR_KPIS', 'regiones/distritos/tiendas/periodos');
// DEFINE('LOCAL_HOTELES_CITY_DASHBOARD_CHARTS', ['bar' => 'Barras', 'pie' => 'Pay', 'gauge' => 'Círculo']); //'bar/pie/gauge');


// function local_hoteles_city_dashboard_relate_column_with_fields(array $columns, array $requiredFields, bool &$hasRequiredColumns){
//     $response = array();
//     $notFound = array();
//     foreach($requiredFields as $field){
//         $pos = array_search($field, $columns);
//         if($pos === false){
//             $hasRequiredColumns = false;
//             array_push($notFound, $field);
//         }else{
//             $response[$field] = $pos;
//         }
//     }
//     if(!$hasRequiredColumns){
//         return $notFound;
//     }
//     return $response;
// }

// function local_hoteles_city_dashboard_get_catalogue(string $key, string $andWhereSql = '', array $query_params = array()){
//     $indicators = local_hoteles_city_dashboard_get_indicators();
//     if(array_search($key, $indicators) === false){
//         return [];
//     }
//     $fieldid = get_config('local_hoteles_city_dashboard', "filtro_" . $key);
//     if($fieldid === false){
//         return [];
//     }
//     $setting = "allow_empty_" . $key;
//     $allow_empty = get_config('local_hoteles_city_dashboard', $setting);
//     if($allow_empty) {
//         $allow_empty = "";
//     } else {
//         $allow_empty = " AND data != '' AND data IS NOT NULL ";
//     }
//     global $DB;
//     if($key == 'ccosto'){
//         $ccomfield = get_config('local_hoteles_city_dashboard', "filtro_idccosto");
//         if(!empty($ccomfield)){
//             if(!empty($allow_empty)){
//                 $_allow_empty = " AND uid_.data != '' AND uid_.data IS NOT NULL ";
//             }else{
//                 $_allow_empty = "";
//             }
//             // $query = "SELECT data from {user_info_data} as uid_ WHERE uid_.fieldid = {$fieldid} AND uid_.userid = uid.userid {$_allow_empty} (SELECT data as menu_value FROM {user_info_data} where fieldid = {$fieldid} {$andWhereSql} {$allow_empty} group by data) ";
//             // $query = "SELECT data as menu_id, COALESCE((SELECT data from {user_info_data} as uid_ WHERE uid_.fieldid = {$fieldid} AND uid_.userid = uid.userid {$_allow_empty} LIMIT 1), '') as menu_value
//             //  FROM {user_info_data} uid where fieldid = {$ccomfield} {$andWhereSql} {$allow_empty} group by menu_id HAVING menu_value != ''";
//             $query = "SELECT distinct data as menu_id, COALESCE((SELECT data from {user_info_data} as uid_ WHERE uid_.fieldid = {$ccomfield} AND uid_.userid = uid.userid {$_allow_empty} LIMIT 1), '') as menu_value
//              FROM {user_info_data} uid where fieldid = {$fieldid} {$andWhereSql} {$allow_empty} group by menu_id HAVING menu_value != '' ORDER BY menu_value ASC";
//             $result = $DB->get_records_sql_menu($query, $query_params);
//             // if($result){
//             //     $_result = array();
//             //     foreach($result as $key => $temporal){
//             //         $result
//             //     }
//             // }
//             // usort($result, function ($a, $b) {return $a->percentage < $b->percentage;});
//             return $result;
//         }
//     }
//     $query = "SELECT data, data as _data FROM {user_info_data} where fieldid = {$fieldid} {$andWhereSql} {$allow_empty} group by data order by data ASC ";
//     // _log('local_hoteles_city_dashboard_get_catalogue query', $query);
//     return $DB->get_records_sql_menu($query, $query_params);
// }

// function local_hoteles_city_dashboard_get_user_catalogues(array $params = array()){
//     $response = array();
//     $returnOnly = $indicators = local_hoteles_city_dashboard_get_indicators();
//     if(!empty($params['selected_filter'])){
//         $returnOnly = local_hoteles_city_dashboard_get_indicators($params['selected_filter']);
//     }
//     if(empty($returnOnly)){
//         return [];
//     }
    
//     $conditions = local_hoteles_city_dashboard_get_wheresql_for_user_catalogues($params, $indicators);
//     foreach($returnOnly as $indicator){
//         $response[$indicator] = local_hoteles_city_dashboard_get_catalogue($indicator, $conditions->sql, $conditions->params);
//     }
//     // _log($response);
//     return $response;
// }

// function local_hoteles_city_dashboard_get_wheresql_for_user_catalogues(array $params, $indicators){
//     $query_params = array();
//     $conditions = array();
//     $andWhereSql = "";
//     $response = new stdClass();
//     if(!empty($params)){
//         foreach($params as $key => $param){
//             if(array_search($key, $indicators) !== false){
//                 $fieldid = get_config('local_hoteles_city_dashboard', "filtro_" . $key);
//                 if($fieldid !== false){
//                     $data = $params[$key];
//                     if(is_string($data) || is_numeric($data)){
//                         array_push($conditions, " (fieldid = {$fieldid} AND data = ?)");
//                         array_push($query_params, $data);
//                     }elseif(is_array($data)){
//                         $fieldConditions = array();
//                         foreach ($data as $d) {
//                             array_push($fieldConditions, " ? ");
//                             array_push($query_params, $d);
//                         }
//                         if(!empty($fieldConditions)){
//                             array_push($conditions, "(fieldid = {$fieldid} AND data in (" . implode(",", $fieldConditions) . "))");
//                         }
//                     }
//                 }
//             }
//         }
//     }
//     if(!empty($conditions)){
//         $andWhereSql = " AND userid IN ( SELECT DISTINCT userid FROM {user_info_data} WHERE " . implode(' OR ', $conditions) . ")";
//     }
//     $response->sql = $andWhereSql;
//     $response->params = $query_params;
//     return $response;
// }

// function local_hoteles_city_dashboard_get_all_catalogues_for_kpi($kpi, $params = array()){
//     $indicators = array();
//     foreach(local_hoteles_city_dashboard_get_kpi_indicators() as $indicator){
//         $indicators[$indicator] = local_hoteles_city_dashboard_get_kpi_catalogue($indicator, $kpi, $params);
//     }
//     _log($indicators);
//     return $indicators;
// }

// function local_hoteles_city_dashboard_get_completion_modes(){
//     return [
//         LOCAL_HOTELES_CITY_DASHBOARD_COMPLETION_DEFAULT => "Finalizado/No finalizado (seguimiento de finalización configurado)",
//         // LOCAL_HOTELES_CITY_DASHBOARD_COMPLETION_DEFAULT_AND_GRADE => "Finalizado/No finalizado más calificación (por ponderación en curso pero no establecida para finalización de curso)",
//         LOCAL_HOTELES_CITY_DASHBOARD_COMPLETION_BY_GRADE => "Calificación de una actividad",
//         LOCAL_HOTELES_CITY_DASHBOARD_COMPLETION_BY_BADGE => "Obtención de una insignia",
//         LOCAL_HOTELES_CITY_DASHBOARD_COMPLETION_BY_ACTIVITY => "Finalización de una actividad",
//     ];
// }

// function local_hoteles_city_dashboard_get_course_grade(int $userid, stdClass $course, $default = -1,  $scale = 10){
//     global $DB;
//     $grade = $default;
//     $query = "SELECT grades.finalgrade as finalgrade, items.grademax as grademax FROM {grade_grades} grades JOIN {grade_items} items
//     ON grades.itemid = items.id where items.itemtype = 'course' AND items.courseid = {$course->id} AND grades.userid = {$userid}";
//     if($data = $DB->get_record_sql($query)){
//         if($data->grademax > 0){
//             $grade = $data->finalgrade / $data->grademax * $scale;
//         }
//     }
//     return $grade;
// }

// /**
//  * @param $userid int
//  * @param $course_completion_info intance of $course = $DB->get_record('course', array('id' => $course->id)); $info = new completion_info($course);
//  */
// function local_hoteles_city_dashboard_get_completed_activities_in_course(int $userid, $course_completion_info){
//     if(is_int($course_completion_info)){
//         global $DB;
//         $course = $DB->get_record('course', array('id' => $course_completion_info));
//         $course_completion_info = new completion_info($course);
//     }
//     $defaultResponse = 0;
//     if($course->id === 1){
//         return $defaultResponse;
//     }
//     global $USER, $DB;
    
//     $context = context_course::instance($course->id);

//     // // Get course completion data.
//     $course = $DB->get_record('course', array('id' => $course->id));
//     $info = new completion_info($course);

//     // Load criteria to display.
//     $completions = $course_completion_info->get_completions($userid);

//     // Check if this course has any criteria.
//     if (empty($completions)){
//         return $defaultResponse;
//     }

//     // Check this user is enroled.
//     if ($info->is_tracked_user($userid)){

//         $completed_activities = 0;

//         // Loop through course criteria.
//         foreach ($completions as $completion){
//             $criteria = $completion->get_criteria();
//             $complete = $completion->is_complete();
//             if($complete){
//                 $completed_activities++;
//             }
//         }
//         return $completed_activities;
//     }

//     return $defaultResponse;
// }

// function local_hoteles_city_dashboard_get_course_completion(int $userid, stdClass $course, $completion_info = null ){
//     if($completion_info == null){
//         require_once(__DIR__ . '/../../lib/completionlib.php');
//         $completion_info = new completion_info($course);
//     }

// }

// function local_hoteles_city_dashboard_get_module_grade(int $userid, int $moduleid, int $scale = 10){
//     global $DB;
//     $grade = 0;
//     $query = "SELECT grades.finalgrade as finalgrade, items.grademax as grademax FROM {grade_grades} grades JOIN {grade_items} items
//     ON grades.itemid = items.id where items.itemtype = 'mod' AND grades.userid = {$userid} AND items.iteminstance = {$moduleid}";
//     if($data = $DB->get_record_sql($query)){
//         if($data->grademax > 0){
//             $grade = $data->finalgrade / $data->grademax * $scale;
//         }
//     }
//     return $grade;
// }

// function local_hoteles_city_dashboard_is_enrolled(int $courseid, int $userid){
//     return is_enrolled(context_course::instance($courseid), $userid);    
// }

// function local_hoteles_city_dashboard_get_enrolled_users_count(int $courseid, string $userids = '', string $fecha_inicial, string $fecha_final){ //
//     $email_provider = local_hoteles_city_dashboard_get_email_provider_to_allow();
//     if(empty($userids)){
//         return 0; // default
//     }else{
//         $whereids = " AND ra.userid IN ({$userids})";
//     }
//     if(!empty($email_provider)){
//         $where = " AND email LIKE '{$email_provider}'"; 
//     }else{
//         $where = ""; 
//     }
//     $query = "SELECT COUNT(DISTINCT ra.userid) AS learners
//     FROM {course} AS c
//     LEFT JOIN {context} AS ctx ON c.id = ctx.instanceid
//     JOIN {role_assignments} AS ra ON ra.contextid = ctx.id
//     WHERE c.id = {$courseid}
//     AND ra.userid IN(SELECT id from {user} WHERE deleted = 0 AND suspended = 0 {$where} {$whereids})
//     AND ra.roleid IN (5) # default student role";
//     global $DB;
//     if($result = $DB->get_record_sql($query)){
//         return intval($result->learners);
//     }
//     return 0; // default
// }

// function local_hoteles_city_dashboard_get_email_provider_to_allow(){
//     if($email_provider = get_config('local_hoteles_city_dashboard', 'allowed_email_addresses_in_course')){
//         return $email_provider; // Ejemplo: @subitus.com.mx
//     }else{
//         return ""; // Permitirá todos los correos si no se configura esta sección
//     }
// }

// function local_hoteles_city_dashboard_get_enrolled_users_ids(int $courseid, string $fecha_inicial, string $fecha_final){
//     $email_provider = local_hoteles_city_dashboard_get_email_provider_to_allow();
//     if(!empty($email_provider)){
//         $where = " AND email LIKE '%{$email_provider}'"; 
//     }else{
//         $where = ""; 
//     }
//     $campo_fecha = "_ue.timestart";
//     $filtro_fecha = local_hoteles_city_dashboard_create_sql_dates($campo_fecha, $fecha_inicial, $fecha_final);
//     /* User is active participant (used in user_enrolments->status) -- Documentación tomada de enrollib.php 
//     define('ENROL_USER_ACTIVE', 0);*/
//     $query = "SELECT DISTINCT _user.id FROM {user} _user
//     JOIN {user_enrolments} _ue ON _ue.userid = _user.id
//     JOIN {enrol} _enrol ON (_enrol.id = _ue.enrolid AND _enrol.courseid = {$courseid})
//     WHERE _ue.status = 0 AND _user.deleted = 0 {$filtro_fecha} AND _user.suspended = 0 {$where} AND _user.id NOT IN 
//     (SELECT DISTINCT ra.userid as userid
//         FROM {course} AS _c
//         LEFT JOIN {context} AS ctx ON _c.id = ctx.instanceid
//         JOIN {role_assignments} AS ra ON ra.contextid = ctx.id
//         WHERE _c.id = {$courseid}
//         AND ra.roleid NOT IN (5) # No students
//     )";
//     // _log('local_hoteles_city_dashboard_get_enrolled_users_ids ', $query);
//     global $DB;
//     if($result = $DB->get_fieldset_sql($query)){
//         return $result;
//     }
//     return array(); // default
// }

// function local_hoteles_city_dashboard_get_courses_with_filter(bool $allCourses = false, int $type){
//     $LOCAL_HOTELES_CITY_DASHBOARD_CURSOS_CAMPANAS = get_config('local_hoteles_city_dashboard', 'LOCAL_HOTELES_CITY_DASHBOARD_CURSOS_CAMPANAS');
//     if($LOCAL_HOTELES_CITY_DASHBOARD_CURSOS_CAMPANAS === false && $LOCAL_HOTELES_CITY_DASHBOARD_CURSOS_CAMPANAS == ''){
//         $LOCAL_HOTELES_CITY_DASHBOARD_CURSOS_CAMPANAS = "";
//     }
//     switch ($type) {
//         case LOCAL_HOTELES_CITY_DASHBOARD_AVAILABLE_COURSES:
//             return local_hoteles_city_dashboard_get_courses($allCourses);
//             break;
//         case LOCAL_HOTELES_CITY_DASHBOARD_PROGRAMAS_ENTRENAMIENTO: // Cursos en línea
//         # not in
//             // $LOCAL_HOTELES_CITY_DASHBOARD_CURSOS_CAMPANAS = get_config('local_hoteles_city_dashboard', 'LOCAL_HOTELES_CITY_DASHBOARD_CURSOS_CAMPANAS');
//             if($LOCAL_HOTELES_CITY_DASHBOARD_CURSOS_CAMPANAS != ""){
//                 $where = " AND id NOT IN ({$LOCAL_HOTELES_CITY_DASHBOARD_CURSOS_CAMPANAS}) ";
//             }else{
//                 $where = "";
//             }
//             return local_hoteles_city_dashboard_get_courses($allCourses, $where);
//             break;
        
//         case LOCAL_HOTELES_CITY_DASHBOARD_CURSOS_CAMPANAS: // Cursos presenciales
//         # where id in
//             // $LOCAL_HOTELES_CITY_DASHBOARD_CURSOS_CAMPANAS = get_config('local_hoteles_city_dashboard', 'LOCAL_HOTELES_CITY_DASHBOARD_CURSOS_CAMPANAS');
//             if($LOCAL_HOTELES_CITY_DASHBOARD_CURSOS_CAMPANAS != ""){
//                 $where = " AND id IN ({$LOCAL_HOTELES_CITY_DASHBOARD_CURSOS_CAMPANAS}) ";
//             }else{
//                 return array();
//                 $where = "";
//             }
//             return local_hoteles_city_dashboard_get_courses($allCourses, $where);
//             break;
        
//         case LOCAL_HOTELES_CITY_DASHBOARD_COURSE_KPI_COMPARATIVE: // Cruce de kpis LOCAL_HOTELES_CITY_KPI_NA
//             $kpis = local_hoteles_city_dashboard_get_KPIS();
//             $wherecourseidin = array();

//             foreach($kpis as $key => $kpi){
//                 $name = 'kpi_' . $key;
//                 if( $config = get_config('local_hoteles_city_dashboard', $name)){
//                     array_push($wherecourseidin, $config);
//                 }
//                 // $title = get_string('kpi_relation', $ldm_pluginname) . ': ' . $kpi;
//                 // $description = get_string('kpi_relation' . '_desc', $ldm_pluginname);        
//                 // $setting = new admin_setting_configmultiselect($name, $title, $description, array(), $courses_min);
//                 // $page->add($setting);
//             }
//             if(!empty($wherecourseidin)){
//                 $wherecourseidin = array_unique($wherecourseidin);
//                 $wherecourseidin = implode(',', $wherecourseidin);
//                 $where = " AND id IN ({$wherecourseidin}) ";
//                 return local_hoteles_city_dashboard_get_courses($allCourses, $where);
//             }
//             return array();

//             return array_filter(local_hoteles_city_dashboard_get_courses($allCourses), function ($element){
//                 $config = get_config('local_hoteles_city_dashboard', 'course_kpi_' . $element->id);
//                 $result = ($config !== false && $config != LOCAL_HOTELES_CITY_KPI_NA);
//                 return $result;
//             });
//             break;
        
//         default:
//             return array();
//             break;
//     }
// }

// function local_hoteles_city_dashboard_get_kpi_overview(array $params = array(), bool $allCourses = false){
//     $kpis = local_hoteles_city_dashboard_get_KPIS();
//     $wherecourseidin = array();
//     $ids = array();
//     $configs = array();

//     foreach($kpis as $key => $kpi){
//         $name = 'kpi_' . $key;
//         if( $config = get_config('local_hoteles_city_dashboard', $name)){
//             if(empty($config)){
//                 continue;
//             }
//             $configs[$key] = explode(',', $config);
//             $ids = array_merge($ids, explode(',', $config));
//         }
//     }
//     if(empty($ids)){
//         return array();
//     }
//     $ids = array_unique($ids);
//     $ids = implode(',', $ids);
//     $where = " AND id IN ({$ids}) ";
//     $courses = local_hoteles_city_dashboard_get_courses($allCourses, $where);
//     foreach($courses as $key => $course){
//         $courses[$key] = local_hoteles_city_dashboard_get_course_information($key, false, false, $params, false);
//     }
//     $response = array();
//     foreach($configs as $kpi => $config){
//         $kpi_status = new stdClass();
//         $kpi_courses = array();
//         foreach($config as $course_id){
//             array_push($kpi_courses, $courses[$course_id]);
//         }
//         switch($kpi){
//             case LOCAL_HOTELES_CITY_KPI_OPS: // 1 // Aprobado, no aprobado y destacado
//                 $kpi_status->type = $kpis[LOCAL_HOTELES_CITY_KPI_OPS];
//                 break;
//             case LOCAL_HOTELES_CITY_KPI_HISTORICO: // 2 retorna el número de quejas
//                 $kpi_status->type = $kpis[LOCAL_HOTELES_CITY_KPI_HISTORICO];
                
//                 break;
//             case LOCAL_HOTELES_CITY_KPI_SCORCARD: // 3 Rotación rolling y rotación mensual
//                 $kpi_status->type = $kpis[LOCAL_HOTELES_CITY_KPI_SCORCARD];
//                 break;
//         }
//         $kpi_status->name = $kpis[$kpi];
//         $kpi_status->id = $kpi;
//         $kpi_status->courses = $kpi_courses;
//         $kpi_status->status = local_hoteles_city_dashboard_get_kpi_results($kpi, $params);
//         array_push($response, $kpi_status);
//     }
//     return ['type' => 'kpi_list', 'result' => $response];
    

//     if(!empty($wherecourseidin)){
//         $wherecourseidin = array_unique($wherecourseidin);
//         $wherecourseidin = implode(',', $wherecourseidin);
//         $where = " AND id IN ({$wherecourseidin}) ";
//         return local_hoteles_city_dashboard_get_courses($allCourses, $where);
//     }
//     return array();
// }

// /**
//  * @return array
//  */
// function local_hoteles_city_dashboard_get_courses_overview(int $type, array $params = array(), bool $allCourses = false){
//     if($type === LOCAL_HOTELES_CITY_DASHBOARD_COURSE_KPI_COMPARATIVE){
//         return local_hoteles_city_dashboard_get_kpi_overview($params, $allCourses);
//     }
//     $courses = local_hoteles_city_dashboard_get_courses_with_filter($allCourses, $type);
//     $courses_in_order = array();
//     foreach($courses as $course){
//         $course_information = local_hoteles_city_dashboard_get_course_information($course->id, $kpis = false, $activities = false, $params, false);        
//         if(empty($course_information)){
//             continue;
//         }
//         array_push($courses_in_order, $course_information);
//     }
//     usort($courses_in_order, function ($a, $b) {return $a->percentage < $b->percentage;});
//     return ['type' => 'course_list', 'result' => $courses_in_order];
// }

// function local_hoteles_city_dashboard_get_course_chart(int $courseid){
//     if($response = get_config('local_hoteles_city_dashboard', 'course_main_chart_' . $courseid)){
//         return $response;
//     }
//     return "bar";
// }

// // function local_hoteles_city_dashboard_get_course_color(int $courseid){
// //     if($response = get_config('local_hoteles_city_dashboard', 'course_main_chart_color_' . $courseid)){
// //         return $response;
// //     }
// //     return "#006491";
// // }

// function local_hoteles_city_dashboard_get_date_add_days(int $days = 1){
//     $date = new DateTime(date('Y-m-d'));

//     $date->modify("+{$days} day");
//     return $date->format('Y-m-d');
// }

// function local_hoteles_city_dashboard_create_slug($str, $delimiter = '_'){
//     $slug = strtolower(trim(preg_replace('/[\s-]+/', $delimiter, preg_replace('/[^A-Za-z0-9-]+/', $delimiter, preg_replace('/[&]/', 'and', preg_replace('/[\']/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $str))))), $delimiter));
//     return $slug;
// } 

// function local_hoteles_city_dashboard_get_course_information(int $courseid, bool $get_kpis = false, bool $get_activities = false, array $params = array(), bool $get_comparative = false){
//     global $DB;
//     $course = $DB->get_record('course', array('id' => $courseid));
//     if($course === false){
//         return false;
//     }
//     $response = new stdClass();
//     $response->key = 'course' . $courseid;
//     $response->id = $courseid;
//     $response->chart = local_hoteles_city_dashboard_get_course_chart($courseid);
//     $response->title = $course->fullname;
//     $response->status = 'ok';
//     $fecha_inicial = local_hoteles_city_dashboard_get_value_from_params($params, 'fecha_inicial');
//     $fecha_final = local_hoteles_city_dashboard_get_value_from_params($params, 'fecha_final');

//     $userids = local_hoteles_city_dashboard_get_user_ids_with_params($courseid, $params);
//     if($userids === false){
//         $response->activities = [];
//         $response->enrolled_users = 0;
//         $response->approved_users = 0;
//         $response->percentage = 0;
//         $response->not_approved_users = $response->enrolled_users - $response->approved_users;
//         $response->value = 0;
//         return $response;
//     }
//     $num_users = count($userids);
//     $userids = implode(',', $userids);
//     if($get_activities){
//         $response->activities = local_hoteles_city_dashboard_get_activities_completion($courseid, $userids, $fecha_inicial, $fecha_final); //
//     }

//     $response->enrolled_users = $num_users; //
//     $response->approved_users = local_hoteles_city_dashboard_get_approved_users($courseid, $userids, $fecha_inicial, $fecha_final); //
//     $response->not_approved_users = $response->enrolled_users - $response->approved_users;
//     $response->percentage = local_hoteles_city_dashboard_percentage_of($response->approved_users, $response->enrolled_users);
//     $response->value = $response->percentage;
//     return $response;
// }

// function local_hoteles_city_dashboard_get_course_comparative(int $courseid, array $params){
//     $response = new stdClass();
//     global $DB;
//     $course = $DB->get_record('course', array('id' => $courseid), 'id, shortname, fullname');
//     $response->title = $course->fullname;
//     $response->key = 'course_' . $course->id;
//     $response->id = $course->id;
//     $response->shortname = $course->shortname;
//     $response->fullname = $course->fullname;
//     $indicators = local_hoteles_city_dashboard_get_indicators();
//     $conditions = local_hoteles_city_dashboard_get_wheresql_for_user_catalogues($params, $indicators);
//     if($course === false){
//         return array();
//     }
//     $fecha_inicial = local_hoteles_city_dashboard_get_value_from_params($params, 'fecha_inicial');
//     $fecha_final = local_hoteles_city_dashboard_get_value_from_params($params, 'fecha_final');
//     $indicator = $params['selected_filter'];
//     if(isset($params[$indicator])){
//         _log('Se tienen parámetros');
//     }
//     $catalogue = local_hoteles_city_dashboard_get_catalogue($indicator, $conditions->sql, $conditions->params);
//     $key = $indicator;
//     $comparative = array();
//     foreach($catalogue as $catalogue_item){
//         $item_to_compare = new stdClass();
//         $item_to_compare->name = $catalogue_item;
//         $params[$key] = [$catalogue_item];
//         $userids = local_hoteles_city_dashboard_get_user_ids_with_params($courseid, $params, false);                
//         if(empty($userids)){
//             $item_to_compare->enrolled_users = 0;
//             $item_to_compare->approved_users = 0;
//             $item_to_compare->percentage = local_hoteles_city_dashboard_percentage_of($item_to_compare->approved_users, $item_to_compare->enrolled_users);                    
//         }else{
//             $item_to_compare->enrolled_users = count($userids); //
//             $userids = implode(',', $userids);
//             $item_to_compare->approved_users = local_hoteles_city_dashboard_get_approved_users($courseid, $userids, $fecha_inicial, $fecha_final); //
//             $item_to_compare->percentage = local_hoteles_city_dashboard_percentage_of($item_to_compare->approved_users, $item_to_compare->enrolled_users);
//         }
//         array_push($comparative, $item_to_compare);
//     }
//     $response->comparative = $comparative;
//     $response->filter = $indicator;
//     return $response;
// }

// function local_hoteles_city_dashboard_get_value_from_params(array $params, string $search, $returnIfNotExists = '', bool $apply_not_empty = false){
//     if(array_key_exists($search, $params)){
//         if($apply_not_empty){
//             if(!empty($params[$search])){
//                 return $params[$search];
//             }
//         }else{
//             return $params[$search];
//         }
//     }
//     return $returnIfNotExists;
// }

// function local_hoteles_city_dashboard_create_sql_dates($campo_fecha, $fecha_inicial, $fecha_final){
//     $filtro_fecha = '';
//     if(empty($fecha_inicial) && empty($fecha_final)){ // las 2 vacías
//         $filtro_fecha = ""; // No se aplica filtro
//     }elseif(!empty($fecha_inicial) && empty($fecha_final)){ // solamente fecha_inicial
//         $filtro_fecha = " AND FROM_UNIXTIME({$campo_fecha}) > '{$fecha_inicial}'";
//         // $filtro_fecha .= $campo_fecha . ' ';
//     }elseif(empty($fecha_inicial) && !empty($fecha_final)){ // solamente fecha_final
//         $filtro_fecha = " AND FROM_UNIXTIME({$campo_fecha}) < '{$fecha_final}'";
//     }elseif(!empty($fecha_inicial) && !empty($fecha_final)){ // ambas requeridas
//         $filtro_fecha = " AND (FROM_UNIXTIME({$campo_fecha}) BETWEEN '{$fecha_inicial}' AND '{$fecha_final}')";
//     }
//     return $filtro_fecha;
// }

// function local_hoteles_city_dashboard_get_time_from_month_and_year(int $month, int $year){
//     $date = new DateTime("{$year}-{$month}-02");
//     return $date->format('U');
// }

// function local_hoteles_city_dashboard_get_ideales_as_js_script(){
//     $ideal_cobertura = get_config('local_hoteles_city_dashboard', 'ideal_cobertura');
//     if($ideal_cobertura === false){
//         $ideal_cobertura = 94;
//     }
//     $ideal_rotacion  = get_config('local_hoteles_city_dashboard', 'ideal_rotacion');
//     if($ideal_rotacion === false){
//         $ideal_rotacion = 85;
//     }
//     return "<script> var ideal_cobertura = {$ideal_cobertura}; var ideal_rotacion = {$ideal_rotacion}; </script>";
// }

// function local_hoteles_city_dashboard_get_approved_users(int $courseid, string $userids = '', string $fecha_inicial, string $fecha_final){ //
//     $response = 0;
//     if(empty($userids)){ // no users to search in query
//         // _log('No se encuentran usuarios');
//         return $response;
//     }
//     $completion_mode = get_config('local_hoteles_city_dashboard', "course_completion_" . $courseid);
//     // // _log($completion_mode);
//     $default = 0;
//     if($completion_mode === false){ // missing configuration
//         // _log("Missing configuration courseid", $courseid, 'completion mode returned false');
//         return $response;
//     }
//     $query = "";
//     // _log("Tipo de completado", $completion_mode);
//     switch($completion_mode){
//         case LOCAL_HOTELES_CITY_DASHBOARD_COMPLETION_DEFAULT:
//             if(empty($userids)){
//                 $whereids = "";
//             }else{
//                 $whereids = " AND p.userid IN ({$userids})";
//             }
//             $campo_fecha = "p.timecompleted";
//             $filtro_fecha = local_hoteles_city_dashboard_create_sql_dates($campo_fecha, $fecha_inicial, $fecha_final);    
//             $query = "SELECT count(*) AS completions FROM {course_completions} AS p
//             WHERE p.course = {$courseid} AND p.timecompleted IS NOT NULL {$whereids} {$filtro_fecha} ";
//         break;
//         case LOCAL_HOTELES_CITY_DASHBOARD_COMPLETION_BY_GRADE:
//             if(empty($userids)){
//                 $whereids = "";
//             }else{
//                 $whereids = " AND gg.userid IN ({$userids})";
//             }
//             $grade_item = get_config('local_hoteles_city_dashboard', 'course_grade_activity_completion_' . $courseid);
//             $minimum_score = get_config('local_hoteles_city_dashboard', 'course_minimum_score_' . $courseid);
//             if($grade_item === false || $minimum_score === false){ // Missing configuration
//                 // _log("Missing configuration courseid", $courseid, 'LOCAL_HOTELES_CITY_DASHBOARD_COMPLETION_BY_GRADE');
//                 return $response;
//             }
//             $campo_fecha = "gg.timemodified";
//             $filtro_fecha = local_hoteles_city_dashboard_create_sql_dates($campo_fecha, $fecha_inicial, $fecha_final);
//             $query = "SELECT count(*) AS completions FROM {grade_grades} AS gg WHERE
//              gg.itemid = {$grade_item} AND final_grade >= {$minimum_score} {$whereids} {$filtro_fecha}";
//         break;
//         // case LOCAL_HOTELES_CITY_DASHBOARD_COMPLETION_BY_AVG:
//         //     $query = "Query LOCAL_HOTELES_CITY_DASHBOARD_COMPLETION_BY_AVG";
//         // break;
//         case LOCAL_HOTELES_CITY_DASHBOARD_COMPLETION_BY_ACTIVITY:
//             if(empty($userids)){
//                 $whereids = "";
//             }else{
//                 $whereids = " AND userid IN ({$userids})";
//             }
//             $completion_activity = get_config('local_hoteles_city_dashboard', 'course_completion_activity_' . $courseid);
//             /* completionstate 0 => 'In Progress' 1 => 'Completed' 2 => 'Completed with Pass' completionstate = 3 => 'Completed with Fail' */
//             $campo_fecha = "timemodified";
//             $filtro_fecha = local_hoteles_city_dashboard_create_sql_dates($campo_fecha, $fecha_inicial, $fecha_final);
//             $query = "SELECT count(*) AS completions from {course_modules_completion} WHERE
//              coursemoduleid = {$completion_activity} AND completionstate IN (1,2) $whereids {$filtro_fecha}";
//         break;
//         case LOCAL_HOTELES_CITY_DASHBOARD_COMPLETION_BY_BADGE:
//             // Obtener los id de usuarios inscritos en el curso
//             $completion_badge = get_config('local_hoteles_city_dashboard', 'badge_completion_' . $courseid);
//             // $ids = implode(',', $ids);
//             if(empty($userids)){
//                 $whereids = "";
//             }else{
//                 $whereids = " AND userid IN ({$userids})";
//             }
//             $campo_fecha = "dateissued";
//             $filtro_fecha = local_hoteles_city_dashboard_create_sql_dates($campo_fecha, $fecha_inicial, $fecha_final);
//         $query = "SELECT count(*) AS completions from {badge_issued} WHERE badgeid = {$completion_badge} {$whereids} {$filtro_fecha}";
//         break;
//         default: 
//             // $response->message = 'Completion not allowed';
//             return $response;
//         break;
//     }
//     if(!empty($query)){
//         global $DB;
//         if($result = $DB->get_record_sql($query)){
//             $response = $result->completions;
//             return $response;
//         }
//     }
//     return $response;
// }

// function local_hoteles_city_dashboard_percentage_of(int $number, int $total, int $decimals = 2 ){
//     if($total != 0){
//         return round($number / $total * 100, $decimals);
//     }else{
//         return 0;
//     }
// }

// function local_hoteles_city_dashboard_get_course_grade_item_id(int $courseid){
//     global $DB;
//     return $DB->get_field('grade_items', 'id', array('courseid' => $courseid, 'itemtype' => 'course'));
// }

// function local_hoteles_city_dashboard_get_selected_params(array $params){
//     $result = array();
//     if(!empty($params)){
//         $indicators = local_hoteles_city_dashboard_get_indicators();
//         foreach($params as $key => $param){
//             if(array_search($key, $indicators) !== false){
//                 $filter = array();

//                 $data = $params[$key];
//                 if(is_string($data) || is_numeric($data)){
//                     array_push($filter, $data);
//                 }elseif(is_array($data)){
//                     foreach ($data as $d) {
//                         array_push($filter, $d);
//                     }
//                 }

//                 if(!empty($filter)){
//                     $result[$key] = implode(', ', $filter);
//                 }
//             }
//         }

//         $fecha_inicial = local_hoteles_city_dashboard_get_value_from_params($params, 'fecha_inicial');
//         if(!empty($fecha_inicial)){
//             $result['fecha_inicial'] = $fecha_inicial;
//         }

//         $fecha_final = local_hoteles_city_dashboard_get_value_from_params($params, 'fecha_final');
//         if(!empty($fecha_final)){
//             $result['fecha_final'] = $fecha_final;
//         }
//     }
//     return $result;
// }

// function local_hoteles_city_dashboard_get_user_ids_with_params(int $courseid, array $params = array(), bool $returnAsString = false){
//     $fecha_inicial = local_hoteles_city_dashboard_get_value_from_params($params, 'fecha_inicial');
//     $fecha_final = local_hoteles_city_dashboard_get_value_from_params($params, 'fecha_final');
//     // Se omite $fecha_inicial debido a que si se incluye los usuarios inscritos anteriormente serían omitidos, activar si se pide explícitamente ese funcionamiento
//     // $ids = local_hoteles_city_dashboard_get_enrolled_users_ids($courseid, $fecha_inicial, $fecha_final);
//     $ids = local_hoteles_city_dashboard_get_enrolled_users_ids($courseid, '', $fecha_final);
//     if(empty($ids)){
//         return false;
//     }
//     $allow_users = array();
//     $filter_active = false;
//     if(!empty($params)){
//         global $DB;
//         $indicators = local_hoteles_city_dashboard_get_indicators();
//         // // _log('indicators', $indicators);
//         // $position = array_search();
//         foreach($params as $key => $param){
//             // // _log('$params as $key => $param', $key, $param);
//             if(array_search($key, $indicators) !== false){
//                 $fieldid = get_config('local_hoteles_city_dashboard', "filtro_" . $key);
//                 if($fieldid !== false){
//                     $data = $params[$key];
//                     $filter_active = true;
//                     if(is_string($data) || is_numeric($data)){
//                         // $newIds = 
//                         $newIds = $DB->get_fieldset_select('user_info_data', 'distinct userid', ' fieldid = :fieldid AND data = :data ', array('fieldid' => $fieldid, 'data' => $params[$key]));
//                     }elseif(is_array($data)){
//                         $wheres = array();
//                         $query_params = array();
//                         foreach ($data as $d) {
//                                 array_push($wheres, " data = ? ");
//                                 array_push($query_params, $d);
//                         }
//                         if(!empty($wheres)){
//                             $wheres = " AND ( " . implode(" || ", $wheres) . " ) ";
//                             $query = "SELECT DISTINCT userid FROM {user_info_data} WHERE fieldid = {$fieldid} " . $wheres;
//                             $newIds = $DB->get_fieldset_sql($query, $query_params);
//                         }else{
//                             $newIds = false;
//                         }
//                     }else{
//                         $newIds = false;
//                     }

//                     if($newIds){
//                         if(is_array($newIds)){
//                             $allow_users[] = $newIds;
//                         }else{
//                             // _log("no existen usuarios con esta coincidencia",array('fieldid' => $fieldid, 'data' => $params[$key]));
//                         }
//                     }else{
//                         // _log('no newIds', array('fieldid' => $fieldid, 'data' => $params[$key]));
//                         if($returnAsString){
//                             return ""; // Search returns empty
//                         }else{
//                             return array(); // Search returns empty
//                         }
//                     }
//                 }else{
//                     // _log('no fieldid');
//                 }
//             }else{
//                 // // _log('array_key_exists returns false');
//             }
//         }
//     }
//     $ids = array_unique($ids);
//     // // _log('$allow_users', $allow_users);
//     if($filter_active){
//         if(count($allow_users) > 1){
//             $allow_users = call_user_func_array('array_intersect', $allow_users);
//         }else{
//             $allow_users = $allow_users[0];
//         }
//         $ids = array_filter($ids, function($element) use($allow_users){
//             return array_search($element, $allow_users) !== false;
//         });
//     }

//     if($returnAsString){
//         return implode(',', $ids);
//     }else{
//         return $ids;
//     }
// }

// function local_hoteles_city_dashboard_get_gradable_items(int $courseid, int $hidden = 0){
//     if($hidden != 1 || $hidden != 0){
//         $hidden = 0;
//     }
//     global $DB;
//     return $DB->get_records_menu('grade_items', array('courseid' => $courseid, 'itemtype' => 'mod', 'hidden' => $hidden), '', 'id,itemname');
// }

// // function local_hoteles_city_dashboard_(){
    
// // }

// function local_hoteles_city_dashboard_get_indicators(string $from = ''){
//     $indicators = explode('/', LOCAL_HOTELES_CITY_DASHBOARD_INDICATORS);
//     if(!empty($from)){
//         $exists = array_search($from, $indicators);
//         if($exists !== false){
//             $exists++;
//             $filter = array();
//             for ($i=$exists; $i < count($indicators); $i++) { 
//                 array_push($filter, $indicators[$i]);
//             }
//             $indicators = $filter;
//         }
//     }
//     return $indicators;
// }

// function local_hoteles_city_dashboard_get_kpi_indicators(string $from = ''){
//     $indicators = explode('/', LOCAL_HOTELES_CITY_DASHBOARD_INDICATORS_FOR_KPIS);
//     if(!empty($from)){
//         $exists = array_search($from, $indicators);
//         if($exists !== false){
//             $exists++;
//             $filter = array();
//             for ($i=$exists; $i < count($indicators); $i++) { 
//                 array_push($filter, $indicators[$i]);
//             }
//             $indicators = $filter;
//         }
//     }
//     return $indicators;
// }

// function local_hoteles_city_dashboard_get_charts(){
//     return LOCAL_HOTELES_CITY_DASHBOARD_CHARTS;
// }

function local_hoteles_city_dashboard_get_custom_profile_fields(){
    global $DB;
    $profileFields = array();
    foreach($DB->get_records('user_info_field', array(), 'id, name') as $profileField){
        $profileFields[$profileField->id] = $profileField->shortname;
    }
    return $profileFields;
}

// if(!function_exists('dd')){
//     function dd($element){
//         die(var_dump($element));
//     }
// }

// if(!function_exists('_log')){
//     function _log(...$parameters){
//         if(!LOCAL_HOTELES_CITY_DASHBOARD_DEBUG){
//             return;
//         }
//         $output = "";
//         foreach($parameters as $parameter){
//             if($parameter === true){
//                 $output .= ' true ' . ' ';
//             }
//             elseif($parameter === false){
//                 $output .= ' false ' . ' ';
//             }
//             elseif($parameter === null){
//                 $output .= ' null ' . ' ';
//             }else{
//                 $output .= print_r($parameter, true) . ' ';
//             }
//         }
//         error_log($output);
//     }
// }

// if(!function_exists('_print')){
//     function _print(...$parameters){
//         $output = "<pre>";
//         foreach($parameters as $parameter){
//             if($parameter === true){
//                 $output .= ' true ' . ' <br>';
//             }
//             elseif($parameter === false){
//                 $output .= ' false ' . ' <br>';
//             }
//             elseif($parameter === null){
//                 $output .= ' null ' . ' <br>';
//             }else{
//                 $output .= print_r($parameter, true) . ' <br>';
//             }
//         }
//         $output .= "</pre>";
//         echo $output;
//     }
// }

// function local_hoteles_city_dashboard_format_response($data, string $dataname = "data", string $status = 'ok'){
//     if(is_array($data)){
//         $count = count($data);
//     } else {
//         $count = 1;
//     }
//     if(empty($data)){
//         if($status == 'ok'){
//             $status = "No data found";
//         }
//         $count = 0;
//     }
//     $result = array();
//     $result['status'] = $status;
//     $result['count'] = $count;
//     $result[$dataname] = $data;
//     return json_encode($result);
// }

// function local_hoteles_city_dashboard_done_successfully($message = 'ok'){
//     $result = new stdClass();
//     $result->status  = 'ok';
//     $result->message = $message;
//     return json_encode($result);
// }

// function local_hoteles_city_dashboard_error_response($message = 'error'){
//     $result = new stdClass();
//     $result->status  = 'error';
//     $result->message = $message;
//     return json_encode($result);
// }

// function local_hoteles_city_dashboard_get_courses(bool $allCourses = false, $andWhereClause = ""){
//     global $DB;
//     $categories = local_hoteles_city_dashboard_get_categories_with_subcategories(local_hoteles_city_dashboard_get_category_parent(), false);
//     if($allCourses){
//         $query = "SELECT id, fullname, shortname FROM {course} where category in ({$categories}) {$andWhereClause} order by sortorder";
//     }else{
//         if($exclusion = get_config('local_hoteles_city_dashboard', 'excluded_courses')){
//             if($exclusion != ''){
//                 $andWhereClause .= " AND id NOT IN ({$exclusion}) ";
//             }
//         }
//         $query = "SELECT id, fullname, shortname FROM {course} where category in ({$categories}) {$andWhereClause} order by sortorder";
//     }
//     return $DB->get_records_sql($query);
// }

// function local_hoteles_city_dashboard_get_categories(){
//     global $DB;
//     $categories = $DB->get_records_sql('SELECT id, name, path FROM {course_categories}');
//     if($categories == false){
//         return [];
//     }
//     $cats = array();
//     foreach($categories as $category){
//         $cats[$category->id] = $category->name;
//     }
//     return $cats;
// }

// function local_hoteles_city_dashboard_get_categories_with_subcategories(int $category_id, bool $returnAsArray = true/*, string $path, array $categories*/){
//     global $DB;
//     $category = $DB->get_record('course_categories', array('id' => $category_id));
//     $categories = array();
//     if($category){
//         $query = "SELECT id FROM {course_categories} WHERE path LIKE '{$category->path}%' AND id != {$category_id}";
//         array_push($categories, $category_id);
//         foreach($DB->get_records_sql($query) as $subc){
//             array_push($categories, $subc->id);
//         }
//     }
//     if($returnAsArray){
//         return $categories;
//     }else{
//         return implode(",", $categories);
//     }
// }

// function local_hoteles_city_dashboard_get_category_parent(){
//     if($data = get_config('local_hoteles_city_dashboard', LOCAL_HOTELES_CITY_DASHBOARD_CATEGORY_PARENT_NAME)){
//         return $data;
//     }else{
//         return 1; // Miscelaneous
//     }
// }

// /**
//  * @param int $badge_status Badge status: 0 = inactive, 1 = active, 2 = active+locked, 3 = inactive+locked, 4 = archived, -1 = all badge status
//  */
// function local_hoteles_city_dashboard_get_badges(int $badge_status = -1){
//     if(!is_int($badge_status)){
//         $status = -1;
//     }
//     global $DB;
//     if($badge_status != -1){
//         return $DB->get_records_menu('badge', array('status' => $badge_status), '', 'id,name');
//     }
//     return $DB->get_records_menu('badge', array(), '', 'id,name');
// }

// function local_hoteles_city_dashboard_get_activities(int $courseid, string $andwhere = ""){
//     global $DB;
//     $actividades = array();
//     $query  = "SELECT id, CASE ";
//     $tiposDeModulos = $DB->get_records('modules', array('visible' => 1), 'id,name');
//     foreach ($tiposDeModulos as $modulo) {
//         $nombre  = $modulo->name;
//         $alias = 'a'.$modulo->id;
//         $query .= ' WHEN cm.module = '.$modulo->id.' THEN (SELECT '.$alias.'.name FROM {'.$nombre.'} '.$alias.' WHERE '.$alias.'.id = cm.instance) ';
//     }
//     $query .= " END AS name
//     from {course_modules} cm
//     where course = {$courseid} {$andwhere} ";
//     return $DB->get_records_sql_menu($query);
// }

// function local_hoteles_city_dashboard_get_activities_completion(int $courseid, string $userids, string $fecha_inicial, string $fecha_final){

//     $activities = array();
//     if(empty($userids)){
//         return $activities;
//     }
//     global $DB;
//     $courseactivities = local_hoteles_city_dashboard_get_activities($courseid, " AND completion != 0 ");
//     foreach($courseactivities as $key => $activity){
//         $activityInformation = local_hoteles_city_dashboard_get_activity_completions($activityid = $key, $userids, $title = $activity, $fecha_inicial, $fecha_final);
//         array_push($activities, $activityInformation);
//     }
//     usort($activities, function ($a, $b) {return $a['completed'] < $b['completed'];});
//     return $activities;
// }

// function local_hoteles_city_dashboard_get_activity_completions(int $activityid, string $userids = "", $title = "", string $fecha_inicial, string $fecha_final){
//     $campo_fecha = "timemodified";
//     $filtro_fecha = "";
//     $filtro_fecha = local_hoteles_city_dashboard_create_sql_dates($campo_fecha, $fecha_inicial, $fecha_final);
//     global $DB;
//     $key = "module" . $activityid;
//     // $inProgress         = $DB->count_records_sql("SELECT count(*) FROM {course_modules_completion} WHERE coursemoduleid = {$activityid} AND userid IN ({$userids}) AND completionstate = 0");
//     $completed          = $DB->count_records_sql("SELECT count(*) FROM {course_modules_completion} WHERE coursemoduleid = {$activityid} AND userid IN ({$userids}) AND completionstate IN (1,2) {$filtro_fecha}");
//     // $completedWithFail  = $DB->count_records_sql("SELECT count(*) FROM {course_modules_completion} WHERE coursemoduleid = {$activityid} AND userid IN ({$userids}) AND completionstate = 3");
//     return compact('key', 'title', 'inProgress', 'completed', 'completedWithFail');
// }

// function local_hoteles_city_dashboard_get_competencies($conditions = array()){
//     global $DB;
//     return $DB->get_records('competency', $conditions);
// }

// function local_hoteles_city_dashboard_get_user_competencies($userid){
//     global $DB;
//     $sql = "SELECT c.*
//                 FROM {competency_usercomp} uc
//                 JOIN {competency} c
//                 ON c.id = uc.competencyid
//                 WHERE uc.userid = ?";
//     return $DB->get_records_sql($sql, array($userid));
// }

// function local_hoteles_city_dashboard_get_all_user_competencies(array $conditions = array()){
//     global $DB;
//     $competencies = $DB->get_records('competency', array(), '', 'id, shortname, shortname as title');
//     foreach($competencies as $competency){
//         $competency->proficiency = $DB->count_records('competency_usercomp', array('competencyid' => $competency->id, 'proficiency' => 1));
//     }
//     usort($competencies, function($a, $b){
//         return $a->proficiency - $b->proficiency;
//     });
//     return $competencies;
// }

// function local_hoteles_city_dashboard_get_last_month_key(array $columns){
//     $meses = "12_DICIEMBRE,11_NOVIEMBRE,10_OCTUBRE,9_SEPTIEMBRE,8_AGOSTO,7_JULIO,6_JUNIO,5_MAYO,4_ABRIL,3_MARZO,2_FEBRERO,1_ENERO";
//     $meses = explode(',', $meses);
//     foreach($meses as $mes){
//         $search = array_search($mes, $columns);
//         if($search !== false){
//             // _log("El índice retornado es: ", $search);
//             return $search;
//         }
//     }
//     return -1; // it will throw an error
// }

// function local_hoteles_city_dashboard_get_last_month_name(array $columns){
//     $meses = "12_DICIEMBRE,11_NOVIEMBRE,10_OCTUBRE,9_SEPTIEMBRE,8_AGOSTO,7_JULIO,6_JUNIO,5_MAYO,4_ABRIL,3_MARZO,2_FEBRERO,1_ENERO";
//     $meses = explode(',', $meses);
//     foreach($meses as $mes){
//         $search = array_search($mes, $columns);
//         if($search !== false){
//             // _log("El índice retornado es: ", $search);
//             return $mes;
//         }
//     }
//     return -1; // it will throw an error
// }

// function local_hoteles_city_dashboard_convert_month_name(string $monthName){
//     $parts = explode('_', $monthName);
//     return $parts[0];
// }

// function local_hoteles_city_dashboard_format_month_from_kpi($m){
//     if(empty($m)){
//         return "";
//     }
//     if(is_int($m)){
//         if($m <= 13){ // de 1 a 12
//             return $m;
//         }
//     }
//     if(is_string($m)){
//         $m = strtoupper($m);
//         $meses = [
//             1 => 'ENERO',
//             2 => 'FEBRERO',
//             3 => 'MARZO',
//             4 => 'ABRIL',
//             5 => 'MAYO',
//             6 => 'JUNIO',
//             7 => 'JULIO',
//             8 => 'AGOSTO',
//             9 => 'SEPTIEMBRE',
//             10 => 'OCTUBRE',
//             11 => 'NOVIEMBRE',
//             12 => 'DICIEMBRE',
//         ];
//         $busqueda = array_search($m, $meses);
//         if($busqueda !== false){
//             return $busqueda;
//         }
//         $meses = [
//             1 => 'ENE',
//             2 => 'FEB',
//             3 => 'MAR',
//             4 => 'ABR',
//             5 => 'MAY',
//             6 => 'JUN',
//             7 => 'JUL',
//             8 => 'AGO',
//             9 => 'SEP',
//             10 => 'OCT',
//             11 => 'NOV',
//             12 => 'DIC',
//         ];
//         $busqueda = array_search($m, $meses);
//         if($busqueda !== false){
//             return $busqueda;
//         }
//     }
//     return $m;
// }


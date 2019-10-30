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
 * Form for editing a users profile
 *
 * @copyright 1999 Martin Dougiamas  http://dougiamas.com
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @package core_user
 */

if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.');    //  It must be included from a Moodle page.
}

require_once($CFG->dirroot.'/lib/formslib.php');
require_once(__DIR__ . '/lib.php');
// require_once($CFG->dirroot . '/user/profile/lib.php');

/**
 * Class filter_settings.
 *
 * @copyright 2019 Subitus contacto@subitus.com
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class filter_settings extends moodleform {

    /**
     * Define the form.
     */
    public function definition() {
        global $USER, $CFG, $COURSE;

        $mform = $this->_form;
        if (!is_array($this->_customdata)) {
            throw new coding_exception('invalid custom data for custom_settings hoteles_city_dashboard');
        }
        $configs = $this->_customdata['configs'];
        $default_profile_fields = local_hoteles_city_dashboard_get_default_profile_fields(true);
        $all_default_profile_fields = local_hoteles_city_dashboard_get_default_profile_fields();
        $custom_fields = local_hoteles_city_dashboard_get_custom_profile_fields();
        echo local_hoteles_city_dashboard_print_theme_variables();
        // $configs = get_config('local_hoteles_city_dashboard');
        // $configs = (array) $configs;
        $pluginname = 'local_hoteles_city_dashboard';
        
        $mform->addElement('header', 'special_custom_fields', get_string('special_custom_fields_header', $pluginname));

        foreach (local_hoteles_city_dashboard_special_custom_fields as $key => $value) {
            $name = $key;
            $title = $value;
            $description = "Seleccione el campo personalizado que tiene el campo " . strtolower($value); // get_string($name . '_desc', $pluginname);
            $default = !empty($configs[$name]) ? $configs[$name] : "";
            $select = $mform->addElement('select', $name, $title, $custom_fields);
            $mform->setDefault($name, $default);
            $mform->addElement('static', 'description', '', $description);
        }

        $courses = local_hoteles_city_dashboard_get_courses();
        $name = 'dashboard_courses';
        $title = get_string('dashboard_courses', $pluginname);
        $description = get_string('dashboard_courses' . '_desc', $pluginname);
        $default = !empty($configs[$name]) ? $configs[$name] : '';
        $select = $mform->addElement('select', $name, $title, $courses, 'class = " multiselect-setting "');
        $select->setMultiple(true);
        $mform->getElement($name)->setSelected(explode(',', $default));
        $mform->addElement('static', 'description', '', $description);
        

        $institutions = local_hoteles_city_dashboard_get_institutions();
        $name = 'direcciones';
        $title = get_string('direcciones', $pluginname);
        $description = get_string('direcciones' . '_desc', $pluginname);
        $default = !empty($configs[$name]) ? $configs[$name] : '';
        $select = $mform->addElement('select', $name, $title, $institutions, 'class = " multiselect-setting "');
        $select->setMultiple(true);
        $mform->getElement($name)->setSelected(explode(',', $default));
        $mform->addElement('static', 'description', '', $description);

        $mform->addElement('header', 'reportfields_header', get_string('reportfields_header', $pluginname));
        $mform->setExpanded('reportfields_header', true);

        $name = 'reportdefaultfields';
        $title = get_string('reportdefaultfields', $pluginname);
        $description = get_string('reportdefaultfields' . '_desc', $pluginname);
        $default = !empty($configs[$name]) ? $configs[$name] : "";
        $select = $mform->addElement('select', $name, $title, $all_default_profile_fields, 'class = " multiselect-setting "');
        $select->setMultiple(true);
        $mform->getElement($name)->setSelected(explode(',', $default));
        $mform->addElement('static', 'description', '', $description);

        $name = 'reportcustomfields';
        $title = get_string('reportcustomfields', $pluginname);
        $description = get_string('reportcustomfields' . '_desc', $pluginname);
        $default = !empty($configs[$name]) ? $configs[$name] : "";
        $select = $mform->addElement('select', $name, $title, $custom_fields, 'class = " multiselect-setting "');
        $select->setMultiple(true);
        $mform->getElement($name)->setSelected(explode(',', $default));
        $mform->addElement('static', 'description', '', $description);



        $mform->addElement('header', 'signinfields', get_string('signinfields', $pluginname));
        $mform->setExpanded('signinfields', true);

        $name = 'userformdefaultfields';    
        $title = get_string('userformdefaultfields', 'local_hoteles_city_dashboard');
        $description = get_string('userformdefaultfields' . '_desc', $pluginname);
        $default = !empty($configs[$name]) ? $configs[$name] : "";
        $select = $mform->addElement('select', $name, $title, $default_profile_fields, 'class = " multiselect-setting "');
        $select->setMultiple(true);
        $mform->getElement($name)->setSelected(explode(',', $default));
        $mform->addElement('static', 'description', '', $description);

        $name = 'userformcustomfields';
        $title = get_string('userformcustomfields', $pluginname);
        $description = get_string('userformcustomfields' . '_desc', $pluginname);
        $default = !empty($configs[$name]) ? $configs[$name] : "";
        $select = $mform->addElement('select', $name, $title, $custom_fields, 'class = " multiselect-setting "');
        $select->setMultiple(true);
        $mform->getElement($name)->setSelected(explode(',', $default));
        $mform->addElement('static', 'description', '', $description);



        $mform->addElement('header', 'filterfields', get_string('filterfields', $pluginname));
        $mform->setExpanded('filterfields', true);

        $name = 'filterdefaultfields';
        $title = get_string('filterdefaultfields', $pluginname);
        $description = get_string('filterdefaultfields' . '_desc', $pluginname);
        $default = !empty($configs[$name]) ? $configs[$name] : "";
        $select = $mform->addElement('select', $name, $title, $all_default_profile_fields, 'class = " multiselect-setting "');
        $select->setMultiple(true);
        $mform->getElement($name)->setSelected(explode(',', $default));
        $mform->addElement('static', 'description', '', $description);

        $name = 'filtercustomfields';
        $title = get_string('filtercustomfields', $pluginname);
        $description = get_string('filtercustomfields' . '_desc', $pluginname);
        $default = !empty($configs[$name]) ? $configs[$name] : "";
        $select = $mform->addElement('select', $name, $title, $custom_fields, 'class = " multiselect-setting "');
        $select->setMultiple(true);
        $mform->getElement($name)->setSelected(explode(',', $default));
        $mform->addElement('static', 'description', '', $description);

    }

    /**
     * Extend the form definition after data has been parsed.
     */
    public function definition_after_data() {
        
    }

    /**
     * Validate the form data.
     * @param array $usernew
     * @param array $files
     * @return array|bool
     */
    public function validation($usernew, $files) {
        
    }
}

/**
 * Class permission_settings.
 *
 * @copyright 2019 Subitus contacto@subitus.com
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class permission_settings extends moodleform {

    /**
     * Define the form.
     */
    public function definition() {
        global $USER, $CFG, $COURSE;

        $mform = $this->_form;
        echo local_hoteles_city_dashboard_print_theme_variables();
        // $configs = get_config('local_hoteles_city_dashboard');
        // $configs = (array) $configs;
        $pluginname = 'local_hoteles_city_dashboard';

        if (!is_array($this->_customdata)) {
            throw new coding_exception('invalid custom data for custom_settings hoteles_city_dashboard');
        }
        $configs = $this->_customdata['configs'];

        // $strgeneral  = get_string('general');
        $strrequired = get_string('required');

        $mform->addElement('header', 'permissions', get_string('filterfields', $pluginname));
        $mform->setExpanded('permissions', true);
        
        foreach (local_hoteles_city_dashboard_get_dashboard_roles() as $key => $value) {
            $name = $key;
            $default = !empty($configs[$name]) ? $configs[$name] : "";
            $mform->addElement('text', $name, $value, 'size = "80"');
            $mform->addRule($name, $strrequired, 'required');
            $mform->setDefault($name, $default);
            $mform->setType($name, PARAM_TEXT);
            $mform->addElement('static', 'description', '', 'Escriba el correo de los usuarios que tendrán el perfil "' . strtolower($value) . '" separados por un espacio');
        }
        
    }

    /**
     * Extend the form definition after data has been parsed.
     */
    public function definition_after_data() {
        
    }

    /**
     * Validate the form data.
     * @param array $usernew
     * @param array $files
     * @return array|bool
     */
    public function validation($usernew, $files) {
        
    }
}



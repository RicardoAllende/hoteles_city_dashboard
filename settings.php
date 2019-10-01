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

defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {
    // TODO: Define the plugin settings page.
    // https://docs.moodle.org/dev/Admin_settings

    require_once(__DIR__ . '/lib.php');
    $lhcd_pluginname = 'local_hoteles_city_dashboard';

    $settings = new theme_boost_admin_settingspage_tabs($lhcd_pluginname, get_string('pluginname', $lhcd_pluginname));
    $ADMIN->add('modules', $settings);

    $page = new admin_settingpage($lhcd_pluginname . 'tab_userform', get_string('tab_userform', $lhcd_pluginname)); // Inicia pestaña

    $default_profile_fields = local_hoteles_city_dashboard_get_default_profile_fields(true);
    $name = $lhcd_pluginname . '/userformdefaultfields';
    $title = get_string('userformdefaultfields', $lhcd_pluginname);
    $description = get_string('userformdefaultfields' . '_desc', $lhcd_pluginname);
    $setting = new admin_setting_configmultiselect($name, $title, $description, array(), $default_profile_fields);
    $page->add($setting);
    
    $name = new lang_string('userformimage', $lhcd_pluginname);
    $description = new lang_string('userformimage_desc', $lhcd_pluginname);
    $setting = new admin_setting_configcheckbox($lhcd_pluginname . '/userformimage', $name, $description, 0);
    $page->add($setting);

    $custom_fields = local_hoteles_city_dashboard_get_custom_profile_fields();
    $name = $lhcd_pluginname . '/userformcustomfields';
    $title = get_string('userformcustomfields', $lhcd_pluginname);
    $description = get_string('userformcustomfields' . '_desc', $lhcd_pluginname);
    $setting = new admin_setting_configmultiselect($name, $title, $description, array(), $custom_fields);
    $page->add($setting);
    
    $settings->add($page); // Se agrega pestaña a la administración del plugin

    // $page = new admin_settingpage($lhcd_pluginname . 'tab_userform', get_string('tab_userform', $lhcd_pluginname)); // Inicia pestaña

    // $default_profile_fields = local_hoteles_city_dashboard_get_default_profile_fields();
    // $name = $lhcd_pluginname . '/userformdefaultfields';
    // $title = get_string('userformdefaultfields', $lhcd_pluginname);
    // $description = get_string('userformdefaultfields' . '_desc', $lhcd_pluginname);
    // $setting = new admin_setting_configmultiselect($name, $title, $description, array(), $default_profile_fields);
    // $page->add($setting);
    
    // $name = new lang_string('userformimage', $lhcd_pluginname);
    // $description = new lang_string('userformimage_desc', $lhcd_pluginname);
    // $setting = new admin_setting_configcheckbox($lhcd_pluginname . '/userformimage', $name, $description, 0);
    // $page->add($setting);

    // $custom_fields = local_hoteles_city_dashboard_get_custom_profile_fields();
    // $name = $lhcd_pluginname . '/userformcustomfields';
    // $title = get_string('userformcustomfields', $lhcd_pluginname);
    // $description = get_string('userformcustomfields' . '_desc', $lhcd_pluginname);
    // $setting = new admin_setting_configmultiselect($name, $title, $description, array(), $custom_fields);
    // $page->add($setting);
    
    // $settings->add($page); // Se agrega pestaña a la administración del plugin

}

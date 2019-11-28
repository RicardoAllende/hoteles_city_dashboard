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
    require_once(__DIR__ . '/lib.php');
    // TODO: Define the plugin settings page.
    // https://docs.moodle.org/dev/Admin_settings

    $ADMIN->add('localplugins', new admin_category('local_hoteles_city_dashboard', get_string('pluginname', 'local_hoteles_city_dashboard')));

    $ADMIN->add('local_hoteles_city_dashboard', new admin_externalpage('local_hoteles_city_dashboard_settings', get_string('pluginname', 'local_hoteles_city_dashboard') . ' ajustes',
     $CFG->wwwroot . '/local/hoteles_city_dashboard/ajustes.php'));

    $ADMIN->add('local_hoteles_city_dashboard', new admin_externalpage('local_hoteles_city_dashboard_alta_baja',
     local_hoteles_city_dashboard_alta_baja_usuarios,
     $CFG->wwwroot . '/local/hoteles_city_dashboard/usuarios.php?type=' 
     . local_hoteles_city_dashboard_actived_users_pagination));

    $ADMIN->add('local_hoteles_city_dashboard', new admin_externalpage('local_hoteles_city_dashboard_oficina_central',
     local_hoteles_city_dashboard_alta_baja_usuarios_oficina_central,
     $CFG->wwwroot . '/local/hoteles_city_dashboard/usuarios.php?type=' . local_hoteles_city_dashboard_oficina_central_pagination));

    $ADMIN->add('local_hoteles_city_dashboard', new admin_externalpage('local_hoteles_city_dashboard_cambio_usuarios',
     local_hoteles_city_dashboard_cambio_usuarios,
     $CFG->wwwroot . '/local/hoteles_city_dashboard/usuarios.php?type=' . local_hoteles_city_dashboard_suspended_users_pagination));

    $ADMIN->add('local_hoteles_city_dashboard', new admin_externalpage('local_hoteles_city_dashboard_todos_los_usuarios',
     local_hoteles_city_dashboard_listado_todos_los_usuarios,
     $CFG->wwwroot . '/local/hoteles_city_dashboard/usuarios.php?type=' . local_hoteles_city_dashboard_all_users_pagination));

    $ADMIN->add('local_hoteles_city_dashboard', new admin_externalpage('local_hoteles_city_dashboard_graficas',
     'Gráficas de cursos',
     $CFG->wwwroot . '/local/hoteles_city_dashboard/estatus_curso.php'));

    $ADMIN->add('local_hoteles_city_dashboard', new admin_externalpage('local_hoteles_city_dashboard_reportes',
     'Reporte de cursos ',
     $CFG->wwwroot . '/local/hoteles_city_dashboard/detalle_curso.php'));

    $ADMIN->add('local_hoteles_city_dashboard', new admin_externalpage('local_hoteles_city_dashboard_comparativas',
     local_hoteles_city_dashboard_graficas_comparativas,
     $CFG->wwwroot . '/local/hoteles_city_dashboard/dashboard.php'));

    // require_once(__DIR__ . '/lib.php');
    // $lhcd_pluginname = 'local_hoteles_city_dashboard';

    // $settings = new theme_boost_admin_settingspage_tabs($lhcd_pluginname, get_string('pluginname', $lhcd_pluginname));
    // $ADMIN->add('local_hoteles_city_dashboard', $settings);

    // $page = new admin_settingpage($lhcd_pluginname . 'tab_userform', get_string('tab_userform', $lhcd_pluginname)); // Inicia pestaña
    
    // $default_profile_fields = local_hoteles_city_dashboard_get_default_profile_fields(true);
    // $all_default_profile_fields = local_hoteles_city_dashboard_get_default_profile_fields();
    // $custom_fields = local_hoteles_city_dashboard_get_custom_profile_fields();

    // $default = array('email');
    // $name = $lhcd_pluginname . '/userformdefaultfields';
    // $title = get_string('userformdefaultfields', $lhcd_pluginname);
    // $description = get_string('userformdefaultfields' . '_desc', $lhcd_pluginname);
    // $setting = new admin_setting_configmultiselect($name, $title, $description, $default, $default_profile_fields);
    // $page->add($setting);
    
    // $name = $lhcd_pluginname . '/userformcustomfields';
    // $title = get_string('userformcustomfields', $lhcd_pluginname);
    // $description = get_string('userformcustomfields' . '_desc', $lhcd_pluginname);
    // $setting = new admin_setting_configmultiselect($name, $title, $description, array(), $custom_fields);
    // $page->add($setting);
    
    // $settings->add($page); // Se agrega pestaña a la administración del plugin



    // $page = new admin_settingpage($lhcd_pluginname . 'tab_profile', get_string('tab_profile', $lhcd_pluginname)); // Inicia pestaña

    // $name = $lhcd_pluginname . '/reportdefaultfields';
    // $title = get_string('reportdefaultfields', $lhcd_pluginname);
    // $description = get_string('reportdefaultfields' . '_desc', $lhcd_pluginname);
    // $setting = new admin_setting_configmultiselect($name, $title, $description, array(), $all_default_profile_fields);
    // $page->add($setting);

    // $name = $lhcd_pluginname . '/reportcustomfields';
    // $title = get_string('reportcustomfields', $lhcd_pluginname);
    // $description = get_string('reportcustomfields' . '_desc', $lhcd_pluginname);
    // $setting = new admin_setting_configmultiselect($name, $title, $description, array(), $custom_fields);
    // $page->add($setting);
    
    // $settings->add($page); // Se agrega pestaña a la administración del plugin

    // $page = new admin_settingpage($lhcd_pluginname . 'tab_filters', get_string('tab_filters', $lhcd_pluginname)); // Inicia pestaña

    // $name = $lhcd_pluginname . '/filterdefaultfields';
    // $title = get_string('filterdefaultfields', $lhcd_pluginname);
    // $description = get_string('filterdefaultfields' . '_desc', $lhcd_pluginname);
    // $setting = new admin_setting_configmultiselect($name, $title, $description, array(), $all_default_profile_fields);
    // $page->add($setting);

    // $name = $lhcd_pluginname . '/filtercustomfields';
    // $title = get_string('filtercustomfields', $lhcd_pluginname);
    // $description = get_string('filtercustomfields' . '_desc', $lhcd_pluginname);
    // $setting = new admin_setting_configmultiselect($name, $title, $description, array(), $custom_fields);
    // $page->add($setting);
    
    // $settings->add($page); // Se agrega pestaña a la administración del plugin

}

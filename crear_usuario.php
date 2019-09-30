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
require_once(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/profileform_hoteles.php');
require_once($CFG->libdir.'/gdlib.php');
require_once($CFG->libdir.'/adminlib.php');
// require_once($CFG->dirroot.'/user/editadvanced_form.php');
require_once($CFG->dirroot.'/user/editlib.php');
require_once($CFG->dirroot.'/user/profile/lib.php');
require_once($CFG->dirroot.'/user/lib.php');
require_once($CFG->dirroot.'/webservice/lib.php');

global $DB;
$id     = optional_param('id', $USER->id, PARAM_INT);    // User id; -1 if creating new user.

$systemcontext = get_system_context();

if ($id == -1) {
    // Creating new user.
    $user = new stdClass();
    $user->id = -1;
    $user->auth = 'manual';
    $user->confirmed = 1;
    $user->deleted = 0;
    $user->timezone = '99';
    require_capability('moodle/user:create', $systemcontext);
    admin_externalpage_setup('addnewuser', '', array('id' => -1));
} else {
    // Editing existing user.
    require_capability('moodle/user:update', $systemcontext);
    $user = $DB->get_record('user', array('id' => $id), '*', MUST_EXIST);
    $PAGE->set_context(context_user::instance($user->id));
    $PAGE->navbar->includesettingsbase = true;
    if ($user->id != $USER->id) {
        $PAGE->navigation->extend_for_user($user);
    } else {
        if ($node = $PAGE->navigation->find('myprofile', navigation_node::TYPE_ROOTNODE)) {
            $node->force_open();
        }
    }
}
$mform = new profileform_hoteles(null, array('user' => $user));
echo $OUTPUT->header();
$mform->display();
echo $OUTPUT->footer();
<?php

/**
 * Powerful function that is used by edit and editadvanced to add common form elements/rules/etc.
 *
 * @param moodleform $mform
 * @param array $editoroptions
 * @param array $filemanageroptions
 * @param stdClass $user
 */
function custom_useredit_shared_definition(&$mform, $editoroptions, $filemanageroptions, $user) {
    global $CFG, $USER, $DB;

    if ($user->id > 0) {
        useredit_load_preferences($user, false);
    }

    $strrequired = get_string('required');
    $stringman = get_string_manager();

    // Add the necessary names.
    $fields = useredit_get_required_name_fields();
    // _log('useredit_shared_definition', $fields); // quitar esto
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
    // Add the enabled additional name fields.
    foreach ($enabledusernamefields as $addname) {
        $mform->addElement('text', $addname,  get_string($addname), 'maxlength="100" size="30"');
        $mform->setType($addname, PARAM_NOTAGS);
    }

    // Do not show email field if change confirmation is pending.
    if ($user->id > 0 and !empty($CFG->emailchangeconfirmation) and !empty($user->preference_newemail)) {
        $notice = get_string('emailchangepending', 'auth', $user);
        $notice .= '<br /><a href="edit.php?cancelemailchange=1&amp;id='.$user->id.'">'
                . get_string('emailchangecancel', 'auth') . '</a>';
        $mform->addElement('static', 'emailpending', get_string('email'), $notice);
    } else {
        $mform->addElement('text', 'email', get_string('email'), 'maxlength="100" size="30"');
        $mform->addRule('email', $strrequired, 'required', null, 'client');
        $mform->setType('email', PARAM_RAW_TRIMMED);
    }

    $choices = array();
    $choices['0'] = get_string('emaildisplayno');
    $choices['1'] = get_string('emaildisplayyes');
    $choices['2'] = get_string('emaildisplaycourse');
    $mform->addElement('select', 'maildisplay', get_string('emaildisplay'), $choices);
    $mform->setDefault('maildisplay', core_user::get_property_default('maildisplay'));

    $mform->addElement('text', 'city', get_string('city'), 'maxlength="120" size="21"');
    $mform->setType('city', PARAM_TEXT);
    if (!empty($CFG->defaultcity)) {
        $mform->setDefault('city', $CFG->defaultcity);
    }

    $choices = get_string_manager()->get_list_of_countries();
    $choices = array('' => get_string('selectacountry') . '...') + $choices;
    $mform->addElement('select', 'country', get_string('selectacountry'), $choices);
    if (!empty($CFG->country)) {
        $mform->setDefault('country', core_user::get_property_default('country'));
    }

    if (isset($CFG->forcetimezone) and $CFG->forcetimezone != 99) {
        $choices = core_date::get_list_of_timezones($CFG->forcetimezone);
        $mform->addElement('static', 'forcedtimezone', get_string('timezone'), $choices[$CFG->forcetimezone]);
        $mform->addElement('hidden', 'timezone');
        $mform->setType('timezone', core_user::get_property_type('timezone'));
    } else {
        $choices = core_date::get_list_of_timezones($user->timezone, true);
        $mform->addElement('select', 'timezone', get_string('timezone'), $choices);
    }

    if (!empty($CFG->allowuserthemes)) {
        $choices = array();
        $choices[''] = get_string('default');
        $themes = get_list_of_themes();
        foreach ($themes as $key => $theme) {
            if (empty($theme->hidefromselector)) {
                $choices[$key] = get_string('pluginname', 'theme_'.$theme->name);
            }
        }
        $mform->addElement('select', 'theme', get_string('preferredtheme'), $choices);
    }

    $mform->addElement('editor', 'description_editor', get_string('userdescription'), null, $editoroptions);
    $mform->setType('description_editor', PARAM_CLEANHTML);
    $mform->addHelpButton('description_editor', 'userdescription');

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

    // Display user name fields that are not currenlty enabled here if there are any.
    $disabledusernamefields = useredit_get_disabled_name_fields($enabledusernamefields);
    if (count($disabledusernamefields) > 0) {
        $mform->addElement('header', 'moodle_additional_names', get_string('additionalnames'));
        foreach ($disabledusernamefields as $allname) {
            $mform->addElement('text', $allname, get_string($allname), 'maxlength="100" size="30"');
            $mform->setType($allname, PARAM_NOTAGS);
        }
    }

    if (core_tag_tag::is_enabled('core', 'user') and empty($USER->newadminuser)) {
        $mform->addElement('header', 'moodle_interests', get_string('interests'));
        $mform->addElement('tags', 'interests', get_string('interestslist'),
            array('itemtype' => 'user', 'component' => 'core'));
        $mform->addHelpButton('interests', 'interestslist');
    }

    // Moodle optional fields.
    $mform->addElement('header', 'moodle_optional', get_string('optional', 'form'));

    $mform->addElement('text', 'url', get_string('webpage'), 'maxlength="255" size="50"');
    $mform->setType('url', core_user::get_property_type('url'));

    $mform->addElement('text', 'icq', get_string('icqnumber'), 'maxlength="15" size="25"');
    $mform->setType('icq', core_user::get_property_type('icq'));
    $mform->setForceLtr('icq');

    $mform->addElement('text', 'skype', get_string('skypeid'), 'maxlength="50" size="25"');
    $mform->setType('skype', core_user::get_property_type('skype'));
    $mform->setForceLtr('skype');

    $mform->addElement('text', 'aim', get_string('aimid'), 'maxlength="50" size="25"');
    $mform->setType('aim', core_user::get_property_type('aim'));
    $mform->setForceLtr('aim');

    $mform->addElement('text', 'yahoo', get_string('yahooid'), 'maxlength="50" size="25"');
    $mform->setType('yahoo', core_user::get_property_type('yahoo'));
    $mform->setForceLtr('yahoo');

    $mform->addElement('text', 'msn', get_string('msnid'), 'maxlength="50" size="25"');
    $mform->setType('msn', core_user::get_property_type('msn'));
    $mform->setForceLtr('msn');

    $mform->addElement('text', 'idnumber', get_string('idnumber'), 'maxlength="255" size="25"');
    $mform->setType('idnumber', core_user::get_property_type('idnumber'));

    $mform->addElement('text', 'institution', get_string('institution'), 'maxlength="255" size="25"');
    $mform->setType('institution', core_user::get_property_type('institution'));

    $mform->addElement('text', 'department', get_string('department'), 'maxlength="255" size="25"');
    $mform->setType('department', core_user::get_property_type('department'));

    $mform->addElement('text', 'phone1', get_string('phone1'), 'maxlength="20" size="25"');
    $mform->setType('phone1', core_user::get_property_type('phone1'));
    $mform->setForceLtr('phone1');

    $mform->addElement('text', 'phone2', get_string('phone2'), 'maxlength="20" size="25"');
    $mform->setType('phone2', core_user::get_property_type('phone2'));
    $mform->setForceLtr('phone2');

    $mform->addElement('text', 'address', get_string('address'), 'maxlength="255" size="25"');
    $mform->setType('address', core_user::get_property_type('address'));
}


/**
 * Print out the customisable categories and fields for a users profile
 *
 * @param moodleform $mform instance of the moodleform class
 * @param int $userid id of user whose profile is being edited.
 */
function custom_profile_definition($mform, $userid = 0) {
    _log('Entró en la función custom_profile_definition');
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
                    _log($formfield);
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

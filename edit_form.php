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
 * Form for editing Mentees block instances.
 *
 * @package   moodlecore
 * @copyright 2009 Tim Hunt
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Form for editing Mentees block instances.
 *
 * @copyright 2009 Tim Hunt
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_children_edit_form extends block_edit_form {
    protected function specific_definition($mform) {
        global $DB;
        $select = 'SELECT r.* ';
        $from = 'FROM {role} r
                    JOIN {role_context_levels} rcl ON r.id = rcl.roleid ';
        $where = 'WHERE rcl.contextlevel = ?';
        $roles = $DB->get_records_sql_menu($select.$from.$where, array(CONTEXT_USER));

        // Fields for editing HTML block title and contents.
        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));

        $mform->addElement('text', 'config_title', get_string('configtitleblankhides', 'block_children'));
        $mform->addElement('select', 'config_roleid', get_string('parentrole', 'block_children'), $roles);
        $mform->addHelpButton('config_roleid', 'parentrole', 'block_children');
        $mform->setType('config_title', PARAM_MULTILANG);
    }
}

<?php

class block_children extends block_base {

    function init() {
        $this->title = get_string('pluginname', 'block_children');
    }

    function applicable_formats() {
        return array('all' => true, 'tag' => false);
    }

    function specialization() {
        $this->title = isset($this->config->title) ? $this->config->title : get_string('newchildrenblock', 'block_children');
    }

    function instance_allow_multiple() {
        return true;
    }

    function get_content() {
        global $CFG, $USER, $DB;

        if ($this->content !== NULL) {
            return $this->content;
        }

        if (!isset($this->config->roleid) || empty($this->config->roleid)) {
            $this->content->text = get_string('needsconfig', 'block_children');
        } else {

            // get all the mentees, i.e. users you have a direct assignment to
            $contextparams = array($USER->id, CONTEXT_USER, $this->config->roleid);
            if ($usercontexts = $DB->get_records_sql("SELECT c.instanceid, c.instanceid, u.firstname, u.lastname
                                                        FROM {role_assignments} ra, {context} c, {user} u
                                                       WHERE ra.userid = ?
                                                             AND ra.contextid = c.id
                                                             AND c.instanceid = u.id
                                                             AND c.contextlevel = ?
                                                             AND ra.roleid = ?
                                                       ORDER BY u.lastname", $contextparams)) {

                $users = array();

                foreach ($usercontexts as $usercontext) {
                    $userurl = new moodle_url('/user/view.php', array('id' => $usercontext->instanceid, 'course' => SITEID));
                    $users[] = html_writer::link($userurl, fullname($usercontext));
                }
                $this->content->text = html_writer::alist($users);
            }
        }

        $this->content->footer = '';

        return $this->content;
    }
}


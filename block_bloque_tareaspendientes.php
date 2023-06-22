
<?php
defined('MOODLE_INTERNAL') || die();

class block_bloque_tareaspendientes extends block_base {
    public function init() {
        $this->title = get_string('pluginname', 'block_bloque_tareaspendientes');
    }

    public function get_content() {
        global $DB;
        
        if ($this->content !== null) {
            return $this->content;
        }
        
        $this->content = new stdClass;
        $this->content->text = '';
        
        $assignments = $DB->get_records_sql(
            "SELECT * FROM {assign} WHERE duedate - :time < 24*60*60 - 60",
            array('time'=>time())
        );
        
        foreach ($assignments as $assignment) {
            $users = $this->get_enrolled_users($assignment->course);
            foreach ($users as $user) {
                $subject = "Tarea pendiente: " . $assignment->name;
                $message = "La tarea '" . $assignment->name . "' está por vencer en un día. Por favor, revisa Moodle para más detalles.";
                email_to_user($user, core_user::get_support_user(), $subject, $message);
            }
        }
        
        $this->content->text = 'Se han enviado notificaciones de tareas pendientes.';
        
        return $this->content;
    }

    public function instance_allow_multiple() {
        return false;
    }

    private function get_enrolled_users($courseid) {
        $context = context_course::instance($courseid);
        $users = get_enrolled_users($context);
        
        return $users;
    }
}


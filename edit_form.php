<?php
 
class block_firstblock_edit_form extends block_edit_form {
 
    protected function specific_definition($mform) {
 
        // Section header title according to language file.
        $mform->addElement('header', 'config_header', get_string('blocksettings', 'block'));
 
        $mform->addElement('text', 'config_title', 'searchterm');
        $mform->setDefault('config_title', 'Moodle Blocks');
        $mform->setType('config_title', PARAM_TEXT);
    }
}


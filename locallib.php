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
 * Internal library of functions for module character
 *
 * All the character specific functions, needed to implement the module
 * logic, should go here. Never include this file from your lib.php!
 *
 * @package    mod_character
 * @copyright  2016 Your Name <contact@alfasz.me>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/*
 * Does something really useful with the passed things
 *
 * @param array $things
 * @return object
 *function character_do_something_useful(array $things) {
 *    return new stdClass();
 *}
 */

require_once("$CFG->libdir/formslib.php");
 
class character_sprite_form extends moodleform {
    //Add elements to form
    public function definition() {
        global $CFG;
        global $DB;
        global $USER;
        $userid = $USER->id;
        
        $mform = $this->_form; // Don't forget the underscore! 

        
        $character_sprite = $DB->get_record('character_sprite', array('userid' => $userid));

        if(!$character_sprite){$character_sprite = (object) array("id" => '', "userid"=> '', "username"=> '', "background"=>  0, "skin"=>  0, "hair"=>  0, "eyes"=>  0, "mouth"=>  0, "body"=>  0, "legs"=>  0, "shoes"=>  0, "complements"=>  0 );}

        $mform->addElement('hidden', 'username', $character_sprite->username,'id=input_name class=input_sprite');
        $mform->setType('username', PARAM_TEXT);

        
            foreach($character_sprite as $cname => $cvalue){
                if($cname != 'id' and $cname != 'userid' and $cname != 'username'){
                
                $mform->addElement('hidden', $cname, $cvalue,'class=input_sprite id=input_'.$cname);
                $mform->setType($cname, PARAM_TEXT);
                
                }
            }
        
        
        $character_skills = $DB->get_record('character_skills', array('userid' => $userid));
        
        if(!$character_skills){$character_skills = (object) array("id"=> "", "userid"=> "", "skill1"=> 0, "skill2"=> 0, "skill3"=> 0, "skill4"=> 0, "skill5"=> 0, "skill6"=> 0, "skill7"=> 0, "skill8"=> 0 );}
        
        foreach($character_skills as $cname => $cvalue){
             if($cname != 'id' and $cname != 'userid'){
                
                $mform->addElement('hidden', $cname, $cvalue,'id=input_'.$cname);
                $mform->setType($cname, PARAM_TEXT);
            }
        }
        
        
        
    $this->add_action_buttons();
    
    }
    //Custom validation should be added here
    function validation($data, $files) {
        return array();
    }
}